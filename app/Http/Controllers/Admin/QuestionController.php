<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\QuestionStoreRequest;
use App\Http\Requests\Admin\QuestionUpdateRequest;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends BaseController
{
    public function add(QuestionStoreRequest $request)
    {
        $question = new Question();
        $question->right_variant_id = json_encode([]);
        $question->order_number = 0;
        $question->fill($request->all());
        $question->save();

        return redirect(route('test.edit', $request->test_id))
            ->with('success', 'Вы успешно добавили вопрос');
    }

    public function edit(Question $question)
    {
        $variants = $question->variants;
        return view('admin.question.edit', [
            'question' => $question,
            'variants' => $variants
        ]);
    }

    public function update(QuestionUpdateRequest $request, Question $question)
    {

        $question->order_number = 0;
        $question->fill($request->all());
        $question->save();

        return redirect(route('question.edit', $question->id))
            ->with('success', 'Вы успешно изменили вопрос');
    }

    public function destroy(Question $question)
    {
        $test_id = $question->test->id;
        $question->variants()->delete();
        $question->delete();
        return redirect(route('test.edit', $test_id))
            ->with('success', 'Вы успешно удалили вопрос и все варианты к этому вопросу');
    }
}
