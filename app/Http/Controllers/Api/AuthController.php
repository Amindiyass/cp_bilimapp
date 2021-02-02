<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Mail\Send;
use App\Http\Requests\Api\AuthRegisterRequest;
use App\Http\Requests\Api\AuthRestoreRequest;
use App\Http\Requests\Api\ReconfirmCodeRequest;
use App\Http\Requests\Api\UpdatePasswordRequest;
use App\Models\Promocode;
use App\Models\School;
use App\Models\Student;
use App\Models\UserSubscription;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    public function restore(AuthRestoreRequest $request)
    {
        $phone = $request->phone;
        $code = rand(1000, 9999);
        $message = sprintf("Код для регистраций на bilim.app, Код: %s", $code);
        Send::request($phone, $message);

        $user = User::where('phone', $phone)->first();
        $user->associateRedisCodeAndPhone($phone, $code);

        return $this->sendResponse([]);
    }

    public function restoreConfirm(ReconfirmCodeRequest $request)
    {
        /** @var User $user */
        $phone = $request->phone;
        $user = User::where('phone', $phone)->first();
        if ($user->checkCode($request->input('phone'), $request->input('code'))) {
            $token = $user->createToken('AppName')->accessToken;

            return response()->json(['success' => true, 'data' => [
                'user_id' => $user->id,
                'token' => $token,
            ]]);
        }
    }

    public function sendConfirmationPhone(AuthRegisterRequest $request)
    {
        $phone = $request->phone;
        $code = rand(1000, 9999);
        $message = sprintf("Код для регистраций на bilim.app, Код: %s", $code);
        Send::request($phone, $message);

        #TODO if response error
        $this->redisSet($request->all(), $code);

        if ($request->input('promocode')) {
            $promocode = Promocode::whereName($request->input('promocode'))->first();
            if ($promocode) {
                $this->redisSetInviter($request->input('phone'), $promocode->user_id);
            }
        }

        return response()->json([
            'success' => true,
            'phone' => $phone,
            'message' => null,
        ]);
    }

    public function confirmAndRegister(Request $request) // TODO validate
    {

        $phone = $request->phone;
        $code = $request->code;
        $result = $this->redisGet($phone);


        $validator = Validator::make($request->all(), [
            'phone' => 'required|unique:users',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 400);
        }


        if ($code != $result['code']) {
            return [
                'success' => false,
                'message' => 'Код пароль не совпадает! Попробуйте еще раз.'
            ];
        }

        try {
            DB::beginTransaction();
            $new_user = [
                'name' => $result['first_name'],
                'password' => Hash::make($result['password']),
                'email' => $result['email'],
                'is_active' => true,
                'balance' => 0,
                'phone' => $phone,
                'last_visit' => date('Y-m-d H:i:s'),
                'inviter_id' => $result['inviter_id']
            ];
            $user = User::create($new_user);

            $user->assignRole('student');

            if (empty($result['school_id']) && !empty($result['school_name'])) {
                $school = new School();
                $school->name_kz = $result['school_name'];
                $school->name_ru = $result['school_name'];
                $school->region_id = $result['region_id'];
                $school->save();
                $result['school_id'] = $school->id;
            }

            $new_student = $result;
            $new_student['user_id'] = $user->id;

            Student::create($new_student);

            DB::commit();

        } catch (\Exception $exception) {
            DB::rollBack();

            $message = sprintf('%s, %s, %s', $exception->getMessage(), $exception->getFile(), $exception->getLine());
            info($message);

            return response()->json([
                'success' => false,
                'message' => $message,
            ]);
        }

        $token = $user->createToken('AppName')->accessToken;
        return response()->json(['success' => true,
            'data' => ['user_id' => $user->id, 'token' => $token]],
            200);
    }

    public function login(Request $request)
    {
        $credentials = [
            'phone' => $request->phone,
            'password' => $request->password
        ];

        if (auth()->attempt($credentials)) {

            $user = Auth::user();
            $token = $user->createToken('AppName')->accessToken;

            return response()->json(['success' => true, 'data' => [
                'user_id' => $user->id,
                'token' => $token,
            ]], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'unauthorized'], 401);
        }
    }

    public function logout()
    {
        auth()->user()->token()->revoke();
        return $this->sendResponse([], 'Logout success');
    }

    public function user_info()
    {
        $user = Auth::user();
        return response()->json(['success' => true, 'data' =>
            $user
        ], 200);
    }

    public function redisSetInviter($phone, $inviterId)
    {
        Redis::hSet($phone, 'inviter_id', $inviterId);
    }

    public function redisSet(array $array, $code)
    {
        $phone = $array['phone'];
        Redis::hSet($phone, 'first_name', $array['first_name']);
        Redis::hSet($phone, 'last_name', $array['last_name']);
        Redis::hSet($phone, 'area_id', $array['area_id']);
        Redis::hSet($phone, 'region_id', $array['region_id']);
        if (!empty($array['school_id'])){
            Redis::hSet($phone, 'school_id', $array['school_id']);
        }
        if (!empty($array['school_name'])){
            Redis::hSet($phone, 'school_name', $array['school_name']);
        }
        Redis::hSet($phone, 'class_id', $array['class_id']);
        Redis::hSet($phone, 'language_id', $array['language_id']);
        Redis::hSet($phone, 'email', $array['email']);
        Redis::hSet($phone, 'password', $array['password']);
        Redis::hSet($phone, 'code', $code);
    }

    public function redisGet(int $phone)
    {
        $result = [
            'first_name' => Redis::hGet($phone, 'first_name'),
            'last_name' => Redis::hGet($phone, 'last_name'),
            'area_id' => Redis::hGet($phone, 'area_id'),
            'region_id' => Redis::hGet($phone, 'region_id'),
            'school_id' => Redis::hGet($phone, 'school_id'),
            'school_name' => Redis::hGet($phone, 'school_name'),
            'class_id' => Redis::hGet($phone, 'class_id'),
            'language_id' => Redis::hGet($phone, 'language_id'),
            'email' => Redis::hGet($phone, 'email'),
            'password' => Redis::hGet($phone, 'password'),
            'inviter_id' => Redis::hGet($phone, 'inviter_id'),
            'code' => Redis::hGet($phone, 'code'),
        ];

        return $result;

    }

    public function reconfirmCode(ReconfirmCodeRequest $request)
    {
        $user = auth()->user();
        $phone = $request->get('phone');
        $code = $request->get('code');
        if ($user->checkCode($phone, $code)) {
            $user->phone = $phone;
            $user->save();
            return $this->sendResponse('Phone updated');
        } else {
            return $this->sendResponse('Error. Code not valid');
        }
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = auth()->user();

        $user->password = Hash::make($request->input('password'));

        $user->save();

        return $this->sendResponse([], 'Password updated');
    }
}
