<?php

namespace App\Http\Controllers\Admin;

use App\Filters\AssignmentFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AssignmentStoreRequest;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index()
    {
        $assignments = Assignment::all();
        return view('admin.assignment.index', [
            'assignments' => $assignments,
        ]);
    }

    public function create()
    {
        return view('admin.assignment.create');
    }

    public function store(AssignmentStoreRequest $request)
    {
        $result = Assignment::store($request);
        if ($result['success']) {
            return redirect(route('assignment.index'))
                ->with('success', 'Вы успешно добавили задание');
        }
        return redirect(route('assignment.create'))
            ->with('error', $result['message']);
    }

    public function edit(Assignment $assignment)
    {
        return view('admin.assignment.edit', [
            'assignment' => $assignment,
        ]);
    }

    public function update(Request $request, Assignment $assignment)
    {
        $result = Assignment::store($request, $assignment);
        if ($result['success']) {
            return redirect(route('assignment.index'))
                ->with('success', 'Вы успешно изменили задание');
        }
        return redirect(route('assignment.create'))
            ->with('error', $result['message']);
    }

    public function destroy(Assignment $assignment)
    {
        if ($assignment->delete()) {
            return redirect(route('assignment.index'))->with('success', 'Вы успешно удалили задание !');
        }
    }

    public function filter(AssignmentFilter $filters, Request $request)
    {
        $items = (new \App\Models\Assignment())->get_temp_filter_items($request);
        $assignments = Assignment::filter($filters)->get();

        return redirect(route('assignment.index'))
            ->with('assignments', $assignments)
            ->with('subjects', $items['subjects'])
            ->with('sections', $items['sections'])
            ->with('lessons', $items['lessons']);
    }

    public function get_sections($item_id)
    {
        $courseIds = Course::where(['subject_id' => $item_id])->get()->pluck('id')->toArray();
        $result = Section::whereIn('course_id', $courseIds)->get()->pluck('name_ru', 'id')->toArray();
        return $result;
    }

    public function get_lessons($item_id)
    {
        $result = Lesson::where(['section_id' => $item_id])->get()->pluck('name_ru', 'id')->toArray();
        return $result;
    }

    public function ajax(Request $request)
    {
        switch ($request->type) {
            case 'get_sections':
                return response()->json($this->get_sections($request->item_id));
            case 'get_lessons':
                return response()->json($this->get_lessons($request->item_id));
        }
    }

}
