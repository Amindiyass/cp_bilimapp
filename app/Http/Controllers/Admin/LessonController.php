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

    public function tempVideoSave(VideoStoreRequest $request)
    {
        $sessionId = \session()->getId();
        $key = sprintf('%s-%s', 'lesson_video', $sessionId);
        Session::forget($key);
        Session::push($key . '.title_kz', $request->title_kz);
        Session::push($key . '.title_ru', $request->title_ru);
        Session::push($key . '.path', $request->path);
        Session::push($key . '.sort_number', $request->sort_number);

        return redirect(route('lesson.create'))->with([
            'success' => 'Вы успешно добавили видео',
        ]);
    }

    public function videoReset()
    {
        $sessionId = \session()->getId();
        $key = sprintf('%s-%s', 'lesson_video', $sessionId);
        Session::forget($key);
        return redirect(route('lesson.create'))->with([
            'success' => 'Вы успешно сбросили видео',
        ]);

    }

    public function tempConspectusesSave(ConspectusStoreRequest $request)
    {
        $sessionId = \session()->getId();
        $key = sprintf('%s-%s', 'lesson_conspectus', $sessionId);
        Session::forget($key);
        Session::push($key . '.body', $request->body);

        return redirect(route('lesson.create'))->with([
            'success' => 'Вы успешно добавили конспект',
        ]);
    }

    public function conspectusReset()
    {
        $sessionId = \session()->getId();
        $key = sprintf('%s-%s', 'lesson_conspectus', $sessionId);
        Session::forget($key);
        return redirect(route('lesson.create'))->with([
            'success' => 'Вы успешно сбросили конспект',
        ]);

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
    function update(Request $request, $id)
    {
        //
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
