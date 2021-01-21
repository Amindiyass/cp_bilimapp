<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ConspectusStoreRequest;
use App\Http\Requests\Admin\LessonStoreRequest;
use App\Http\Requests\Admin\VideoStoreRequest;
use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LessonController extends Controller
{
    public function index()
    {
        $lessons = Lesson::paginate(15);
        return view('admin.lesson.index', [
            'lessons' => $lessons
        ]);
    }

    public function create()
    {
        return view('admin.lesson.create');
    }

    public function store(LessonStoreRequest $request)
    {
        $result = (new \App\Models\Lesson)->store($request);
        if ($result['success']) {
            return redirect(route('lesson.index'))
                ->with('success', 'Вы успешно добавили урок!');
        }
        return redirect(route('lesson.index'))
            ->with('error', $result['message']);
    }

    public function get_sections(int $subject_id)
    {
        $sections = Section::where(['course_id' => $subject_id])
            ->get()->pluck('name_ru', 'id');

        return $sections;
    }

    public
    function ajax(Request $request)
    {
        $type = $request->type;
        $item_id = $request->item_id;
        switch ($type) {
            case 'get_sections':
                $result = $this->get_sections($item_id);
                break;
        }
        return $result;
    }


    public
    function edit(Lesson $lesson)
    {
        return view('admin.lesson.edit', [
            'lesson' => $lesson,
        ]);
    }

    public
    function update(LessonStoreRequest $request, Lesson $lesson)
    {
        $result = (new \App\Models\Lesson)->store($request, $lesson);
        if ($result['success']) {
            return redirect(route('lesson.index'))
                ->with('success', 'Вы успешно изменили урок!');
        }
        return redirect(route('lesson.index'))
            ->with('error', $result['message']);
    }

    public
    function destroy(Lesson $lesson)
    {
        $result = (new \App\Models\Lesson)->deleteWithDependencies($lesson);

        if ($result['success']) {
            return redirect(route('lesson.index'))
                ->with('success', 'Вы успешно добавили урок');
        }
        return redirect(route('lesson.index'))
            ->with('error', $result['message']);
    }
}
