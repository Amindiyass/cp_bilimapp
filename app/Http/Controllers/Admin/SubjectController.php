<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubjectStoreRequest;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::orderBy('id')->paginate(15);
        return view('admin.subject.index', [
            'subjects' => $subjects,
        ]);
    }

    public function create()
    {
        return view('admin.subject.create');
    }

    public function store(SubjectStoreRequest $request)
    {
        $subject = new Subject();
        $subject->fill($request->all());
        $subject->save();

        return redirect(route('subject.index'))
            ->with('success', 'Вы успешно добавили предмет');
    }


    public function edit(Subject $subject)
    {
        return view('admin.subject.edit', [
            'subject' => $subject
        ]);

    }

    public function update(SubjectStoreRequest $request, Subject $subject)
    {
        $subject->fill($request->all());
        $subject->save();

        return redirect(route('subject.index'))
            ->with('success', 'Вы успешно изменили предмет');


    }

    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect(route('subject.index'))
            ->with('success', 'Вы успешно удалили предмет');
    }

}
