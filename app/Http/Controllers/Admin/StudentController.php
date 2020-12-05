<?php

namespace App\Http\Controllers\Admin;

use App\Filters\StudentFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StudentStoreRequest;
use App\Http\Requests\Admin\StudentUpdatePasswordRequest;
use App\Models\Area;
use App\Models\Course;
use App\Models\EducationLevel;
use App\Models\Language;
use App\Models\Region;
use App\Models\School;
use App\Models\Student;
use App\Models\Subscription;
use App\Models\UserSubscription;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        $students = (new \App\Models\Student)->get_students();
        $items = (new \App\Models\Student)->get_items();
        $items['students'] = $students;

        return view('admin.student.index', $items);
    }


    public function create()
    {
        $items = (new \App\Models\Student)->get_items();
        return view('admin.student.create', $items);
    }

    public function password_change(StudentUpdatePasswordRequest $request)
    {
        $result = (new \App\Models\Student)->password_change($request);
        if ($result['success']) {
            return redirect(route('student.index'))
                ->with('success', 'Вы успешно изменили пароль');
        }
        return redirect(route('student.index'))
            ->with('error', $result['message']);

    }

    public function add_subscription(Request $request)
    {
        $result = (new \App\Models\Student)->add_subscription($request);
        if ($result['success']) {
            return redirect(route('student.index'))
                ->with('success', 'Вы успешно добавили подписку');
        }
        return redirect(route('student.index'))
            ->with('error', $result['message']);
    }


    public function store(StudentStoreRequest $request)
    {
        $result = (new \App\Models\Student)->store($request->all());
        if ($result['success']) {
            return redirect(route('student.index'))
                ->with('success', 'Вы успешно добавили пользователя');
        }
        return redirect(route('student.index'))
            ->with('error', $result['message']);
    }

    public function edit($id)
    {
        $user = User::find($id);
        $items = (new \App\Models\Student)->get_items();
        $items['user'] = $user;
        return view('admin.student.edit', $items);
    }

    public function update(StudentStoreRequest $request, $id)
    {
        $result = (new \App\Models\Student)->store($request->all());
        if ($result['success']) {
            return redirect(route('student.index'))
                ->with('success', 'Вы успешно добавили пользователя');
        }
        return redirect(route('student.index'))
            ->with('error', $result['message']);
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect(route('student.index'))
            ->with('success', 'Вы успешно удалили пользователя');
    }

    public function filter(StudentFilter $filters, Request $request)
    {
        # TODO move to model
        $areas = !empty($request->input('area')) ? explode(',', $request->input('area')) : [];
        $regions = !empty($request->input('region')) ? explode(',', $request->input('region')) : [];
        $schools = !empty($request->input('school')) ? explode(',', $request->input('school')) : [];
        $classes = !empty($request->input('class')) ? explode(',', $request->input('class')) : [];
        $languages = !empty($request->input('language')) ? explode(',', $request->input('language')) : [];

        $students = Student::filter($filters)->get()->pluck('user_id')->toArray();
        $students = (new \App\Models\Student)->get_students($students);
        return redirect(route('student.index'))
            ->with('students', $students)
            ->with('areas', $areas)
            ->with('schools', $schools)
            ->with('regions', $regions)
            ->with('classes', $classes)
            ->with('languages', $languages);
    }

    public function get_regions($item_id)
    {
        if (is_array($item_id)) {
            $regions = Region::whereIn('area_id', $item_id);
        } else {
            $regions = Region::where(['area_id' => $item_id]);
        }
        $regions = $regions->get()->pluck('name_ru', 'id')->toArray();

        return $regions;

    }

    public function get_schools($item_id)
    {
        if (is_array($item_id)) {
            $schools = School::whereIn('region_id', $item_id);
        } else {
            $schools = School::where(['region_id' => $item_id]);
        }
        $schools = $schools->get()->pluck('name_ru', 'id')->toArray();

        return $schools;
    }

    public function ajax(Request $request)
    {

        $type = $request->type;
        $item_id = $request->item_id;
        switch ($type) {
            case 'get_regions';
                $result = $this->get_regions($item_id);
                break;
            case 'get_schools':
                $result = $this->get_schools($item_id);
                break;
        }
        return response()->json($result);
    }
}

