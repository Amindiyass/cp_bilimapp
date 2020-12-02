<?php

namespace App\Http\Controllers\Admin;

use App\Filters\StudentFilter;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Course;
use App\Models\EducationLevel;
use App\Models\Language;
use App\Models\Region;
use App\Models\School;
use App\Models\Student;
use App\Models\Subscription;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {

        $students = Student::all();
        $items = (new \App\Models\Student)->get_items();
        $items['students'] = $students;

        return view('admin.student.index', $items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $items = (new \App\Models\Student)->get_items();
        return view('admin.student.create', $items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function filter(StudentFilter $filters, Request $request)
    {
        $areas = !empty($request->input('area')) ? explode(',', $request->input('area')) : [];
        $regions = !empty($request->input('region')) ? explode(',', $request->input('region')) : [];
        $schools = !empty($request->input('school')) ? explode(',', $request->input('school')) : [];
        $classes = !empty($request->input('class')) ? explode(',', $request->input('class')) : [];
        $languages = !empty($request->input('language')) ? explode(',', $request->input('language')) : [];

        $students = Student::filter($filters)->get();
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

