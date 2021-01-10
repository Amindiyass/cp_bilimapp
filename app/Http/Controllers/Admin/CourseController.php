<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CourseStoreRequest;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::paginate(15);
        return view('admin.course.index', [
            'courses' => $courses,
        ]);
    }

    public function create()
    {
        return view('admin.course.create');
    }

    public function store(CourseStoreRequest $request)
    {
        $course = new Course();
        $course->fill($request->all());
        if ($course->save()) {
            return redirect(route('course.index'))
                ->with('success', 'Вы успешно добавили курс');
        }

        return redirect(route('course.index'))
            ->with('success', 'Ошибка при сохранение курс');
    }


    public function edit(Course $course)
    {
        return view('admin.course.edit', [
            'course' => $course,
        ]);
    }

    public function update(CourseStoreRequest $request, Course $course)
    {
        $course->fill($request->all());
        if ($course->save()) {
            return redirect(route('course.index'))
                ->with('success', 'Вы успешно изменили курс');
        }

        return redirect(route('course.index'))
            ->with('success', 'Ошибка при сохранение курс');
    }

    public function destroy($id)
    {
        //
    }
}
