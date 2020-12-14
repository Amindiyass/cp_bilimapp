<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VariantStoreRequest;
use App\Http\Requests\Admin\VariantUpdateRequest;
use App\Models\Course;
use App\Models\Question;
use App\Models\TestVariant;
use Illuminate\Http\Request;

class TestVariantController extends BaseController
{

    public function add(VariantStoreRequest $request)
    {
        $question = Question::where(['id' => $request->question_id])->first();
        $result = (new \App\Models\TestVariant)->store($request);
        if ($result['success']) {
            return redirect(route('question.edit', $question->id))
                ->with('success', 'Вы успешно добавили вариант')
                ->with('question', $question);
        }
        return redirect(route('question.edit', $question->id))
            ->with('question', $question)
            ->with('error', $result['message']);

    }

    public function update(VariantUpdateRequest $request)
    {
        $variant = TestVariant::find($request->variant_id);
        $question = $variant->question;
        $result = (new \App\Models\TestVariant)->modify($request);
        if ($result['success']) {
            return redirect(route('question.edit', $question->id))
                ->with('success', 'Вы успешно изменили вариант')
                ->with('question', $question);
        }
        return redirect(route('question.edit', $question->id))
            ->with('question', $question)
            ->with('error', $result['message']);
    }

    public function destroy($id)
    {
        $testVariant = TestVariant::find($id);
        $question_id = $testVariant->question->id;
        $testVariant->delete();
        return redirect(route('question.edit', $question_id))
            ->with('success', 'Вы успешно удалили вариант');
    }

    public function get_test_variants_by_id($id)
    {
        $bool = false;
        $testVariant = TestVariant::find($id);
        if ($testVariant->is_right()) {
            $bool = true;
        }
        
        $testVariant = $testVariant->toArray();
        $testVariant['is_right'] = $bool;

        return $testVariant;

    }

    public function ajax(Request $request)
    {
        $type = $request->type;
        $item_id = $request->item_id;
        switch ($type) {
            case 'get_test_variants_by_id';
                $result = $this->get_test_variants_by_id($item_id);
        }
        return response()->json($result);
    }
}
