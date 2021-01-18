<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Exception;

class Stuff extends Model
{
    public function store($request)
    {
        try {
            DB::beginTransaction();

            $stuff = new User();
            $stuff->name = $request->name;
            $stuff->email = $request->email;
            $stuff->password = Hash::make($request->password);
            $stuff->is_active = true;
            $stuff->save();

            $role_name = User::getRoleNames($request->role_id);
            $stuff->assignRole($role_name);

            DB::commit();
            return [
                'success' => true,
                'message' => null,
            ];
        } catch (Exception $exception) {
            DB::rollBack();
            $message = sprintf('%s %s %s',
                $exception->getFile(),
                $exception->getLine(),
                $exception->getMessage());

            return [
                'success' => false,
                'message' => $message,
            ];
        }


    }

    public function modify($request, $id)
    {
        try {
            DB::beginTransaction();

            $stuff = User::find($id);
            $stuff->name = $request->name;
            $stuff->email = $request->email;
            $stuff->save();

            $stuff->removeRole('admin');
            $stuff->removeRole('stuff');
            $stuff->removeRole('moderator');
            
            $role_name = User::getRoleNames($request->role_id);
            $stuff->assignRole($role_name);

            DB::commit();
            return [
                'success' => true,
                'message' => null,
            ];
        } catch (Exception $exception) {
            DB::rollBack();
            $message = sprintf('%s %s %s',
                $exception->getFile(),
                $exception->getLine(),
                $exception->getMessage());

            return [
                'success' => false,
                'message' => $message,
            ];
        }


    }

    public function password_change($request)
    {
        try {
            DB::table('users')
                ->where(['id' => $request->user_id])
                ->update([
                    'password' => Hash::make($request->password),
                ]);
        } catch (\Exception $exception) {
            $message = sprintf('%s %s %s', $exception->getFile(), $exception->getLine(), $exception->getMessage());
            info($message);
            return [
                'success' => false,
                'message' => $message
            ];
        }
        return [
            'success' => true,
            'message' => '',
        ];

    }


}
