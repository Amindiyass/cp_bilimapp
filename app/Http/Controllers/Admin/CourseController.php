<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CourseStoreRequest;
use App\Http\Requests\Admin\SectionStoreRequest;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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

        $result = (new \App\Models\Course)->store($request);

        if ($result['success']) {
            return redirect(route('course.index'))
                ->with('success', 'Вы успешно добавили курс');
        }

        return redirect(route('course.index'))
            ->with('error', $result['message']);
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

    public function tempSectionSave(SectionStoreRequest $request)
    {
        $sessionId = \session()->getId();
        $key = sprintf('%s-%s', 'course_section', $sessionId);
        Session::push($key . '.name_ru', $request->name_ru);
        Session::push($key . '.name_kz', $request->name_kz);
        Session::push($key . '.sort_number', $request->sort_number);

        return redirect(route('course.create'))
            ->with('success', 'Вы успешно добавили тему')->withInput();
    }

    public function destroy($id)
    {
        //
    }
}
