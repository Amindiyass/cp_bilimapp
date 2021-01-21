<?php

namespace App\Http\Controllers\Admin;

use App\Filters\CourseFilter;
use App\Filters\StudentFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CourseStoreRequest;
use App\Http\Requests\Admin\SectionStoreRequest;
use App\Models\Course;
use App\Models\EducationLevel;
use App\Models\Language;
use App\Models\Student;
use App\Models\Subject;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::orderBy('id')->get();
        $result = $this->get_items();
        $result['courses'] = $courses;
        return view('admin.course.index', $result);
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
        $result = (new \App\Models\Course)->store($request, $course);

        if ($result['success']) {
            return redirect(route('course.index'))
                ->with('success', 'Вы успешно изменили курс');
        }

        return redirect(route('course.index'))
            ->with('error', $result['message']);
    }

    public function tempSectionSave(SectionStoreRequest $request)
    {
        $sessionId = \session()->getId();
        $key = sprintf('%s-%s', 'course_section', $sessionId);
        $item_key = Session::get($key . '.sort_number');
        $count = isset($item_key) ? count($item_key) + 1 : null;
        Session::push($key . '.key', $count);
        Session::push($key . '.name_ru', $request->name_ru);
        Session::push($key . '.name_kz', $request->name_kz);
        Session::push($key . '.sort_number', $request->sort_number);

        return redirect(route('course.create'))
            ->with('success', 'Вы успешно добавили тему')->withInput();
    }

    public function destroy($id)
    {
        Course::find($id)->delete();
        return redirect(route('course.index'))
            ->with('success', 'Вы успешно удалили курс');
    }

    public function get_items()
    {
        $subjects = Subject::all()->pluck('name_ru', 'id')->toArray();
        $languages = Language::all()->pluck('name_ru', 'id')->toArray();
        $classes = EducationLevel::orderBy('order_number')->get()->pluck('order_number', 'id')->toArray();

        return [
            'subjects' => $subjects,
            'classes' => $classes,
            'languages' => $languages,
        ];
    }

    public function filter(CourseFilter $filters, Request $request)
    {
        $items = (new \App\Models\Course())->get_temp_filter_items($request);
        $courses = Course::filter($filters)->get();

        return redirect(route('course.index'))
            ->with('courses', $courses)
            ->with('subjects', $items['subjects'])
            ->with('classes', $items['classes'])
            ->with('languages', $items['languages']);
    }
}
