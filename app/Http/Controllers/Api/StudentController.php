<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Mail\Send;
use App\Http\Requests\Api\StudentUpdateRequest;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;

class StudentController extends BaseController
{
    public function profile()
    {
        $student = Student::byUser()->with(['user' => function($query) {
            $query->select('id', 'avatar_image');
        }])->first();
        return $this->sendResponse($student);
    }

    public function update(Student $student, StudentUpdateRequest $request)
    {
        $user = auth()->user();
        $student = $student->byUser()->first();
        $student->update($request->all());
        if ($request->has('photo')) {
            $user->avatar_image = Storage::putFile('avatars/' . auth()->id(), $request->file('photo'), 'public');
            $user->save();
            $phone = $request->input('phone');
            $code = rand(1000, 9999);
            $message = sprintf("Доступ на %s, Код: %s", config('app.url'), $code);
            Send::request($phone, $message);
            $user->associateRedisCodeAndPhone($phone, $code);
        }
        return $this->sendResponse($student->load('user'));
    }
}
