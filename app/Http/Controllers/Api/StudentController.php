<?php


namespace App\Http\Controllers\Api;


use App\Http\Requests\Api\StudentUpdateRequest;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;

class StudentController extends BaseController
{
    public function profile()
    {
        $student = Student::byUser()->first();
        return $this->sendResponse($student);
    }

    public function update(Student $student, StudentUpdateRequest $request)
    {
        $student = $student->byUser()->first();
        $student->update($request->all());
        if ($request->has('photo')) {
            Storage::disk('do_spaces')->put('avatars/' . auth()->id(), $request->file('photo'));
        }
        return $this->sendResponse($student);
    }
}
