<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'area_id' => 'required',
            'region_id' => 'required|int',
            'school_id' => 'required|int',
            'class_id' => 'required|int',
            'language_id' => 'required|int',
            'email' => 'required',
            'password' => 'required',
            'recommend_user_id' => 'int',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()]);
        }

        try {
            DB::beginTransaction();

            $new_user = [
                'name' => $request->first_name,
                'password' => Hash::make($request->password),
                'email' => $request->email,
                'is_active' => true,
                'balance' => 0,
            ];
            $user = User::create($new_user);

            $new_student = $request->all();
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
            'email' => $request->email,
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

    public function user_info()
    {
        $user = Auth::user();
        return response()->json(['success' => true, 'data' =>
            $user
        ], 200);
    }
}
