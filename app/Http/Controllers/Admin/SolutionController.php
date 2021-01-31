<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubjectStoreRequest;
use App\Models\Solution;
use App\Models\Subject;
use Illuminate\Http\Request;

class SolutionController extends Controller
{
    public function index()
    {
        $solutions = Solution::select('course_id')->orderBy('course_id')->groupBy('course_id')->paginate(15);
        return view('admin.solution.index', [
            'solutions' => $solutions,
        ]);
    }

    public function create()
    {
        return view('admin.solution.create');
    }

    public function store(SubjectStoreRequest $request)
    {
        $subject = new Subject();
        $subject->fill($request->all());
        $subject->save();

        return redirect(route('solution.index'))
            ->with('success', 'Вы успешно добавили предмет');
    }


    public function edit(Subject $subject)
    {
        return view('admin.solution.edit', [
            'subject' => $subject
        ]);

    }

    public function update(SubjectStoreRequest $request, Subject $subject)
    {
        $subject->fill($request->all());
        $subject->save();

        return redirect(route('solution.index'))
            ->with('success', 'Вы успешно изменили предмет');


    }

    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect(route('solution.index'))
            ->with('success', 'Вы успешно удалили предмет');
    }

}
