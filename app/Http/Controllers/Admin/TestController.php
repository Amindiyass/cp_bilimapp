<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TestStoreRequest;
use App\Models\Course;
use App\Models\Question;
use App\Models\Section;
use App\Models\Test;
use App\Models\TestVariant;
use App\User;
use Illuminate\Http\Request;

class TestController extends BaseController
{
    public function index()
    {
        $tests = Test::all();
        $tests = $tests->loadCount('questions');

        return view('admin.test.index', [
            'tests' => $tests
        ]);
    }

    public function create()
    {
        $courses = Course::all()->pluck('name_ru', 'id')->toArray();
        $sections = Section::all()->pluck('name_ru', 'id')->toArray();

        return view('admin.test.create', [
            'courses' => $courses,
            'sections' => $sections,
        ]);
    }

    public function store(TestStoreRequest $request)
    {
        $test = new Test();
        $test->fill($request->all());
        $test->save();

        for ($i = 0; $i < count($request->question_in_kz);$i++) {
            $rightVariants = [];
            $question = Question::create([
                'test_id' => $test->id,
                'body_kz' => $request->question_in_kz[$i],
                'body_ru' => $request->question_in_ru[$i],
                'right_variant_id' => [],
                'order_number' => 1
            ]);
            for ($j = 0; $j < count($request->variant_in_kz[$i]);$j++) {
                $variant = TestVariant::create([
                    'variant_in_kz' => $request->variant_in_kz[$i][$j],
                    'variant_in_ru' => $request->variant_in_ru[$i][$j],
                    'question_id' => $question->id,
                    'test_id' => $test->id,
                    'order_number' => 1
                ]);
                if (isset($request->variant[$i][$j]) && $request->variant[$i][$j] == 'on') {
                    $rightVariants[] = $variant->id;
                }
            }
            $question->right_variant_id = $rightVariants;
            $question->save();
        }

        return redirect(route('test.index'))
            ->with('success', 'Вы успешно добавили тест');

    }

    public function edit(Test $test)
    {
        if (!isset($test->section->course->id)) {
            return redirect(route('test.edit', $test->id))
                ->with('error', 'Не указаны разделы добавьте раздел.');
        }

        $course_id = $test->section->course->id;
        $courses = Course::all()->pluck('name_ru', 'id')->toArray();
        $sections = Section::where(['course_id' => $course_id])->get()->pluck('name_ru', 'id')->toArray();
        $questions = $test->questions;
        return view('admin.test.edit', [
            'test' => $test,
            'courses' => $courses,
            'sections' => $sections,
            'questions' => $questions,
        ]);
    }

    public function update(TestStoreRequest $request, Test $test)
    {
        $test->fill($request->all());
        $test->save();
        return redirect(route('test.edit', $test->id))
            ->with('success', 'Вы успешно изменили тест');
    }

    public function destroy(Test $test)
    {
        foreach ($test->questions as $question) {
            $question->variants()->delete();
        }
        $test->questions()->delete();
        $test->delete();
        return redirect(route('test.index'))
            ->with('success', 'Вы успешно удалили тест');
    }

    public function get_sections($item_id)
    {
        $sections = Section::where(['course_id' => $item_id])->get()->pluck('name_ru', 'id')->toArray();
        return $sections;
    }

    public function ajax(Request $request)
    {
        $type = $request->type;
        switch ($type) {
            case 'get_sections':
                $result = $this->get_sections($request->item_id);
                break;
        }
        return response()->json($result);
    }
}
