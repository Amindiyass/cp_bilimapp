<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CheckTestRequest;
use App\Models\Test;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TestController extends BaseController
{
    public function show(Test $test)
    {
        $test = $test->load(['questions' => function (HasMany $query) {
            return $query->select('body_kz', 'body_ru', 'test_id', 'id', 'right_variant_id')->orderBy('order_number');
        }, 'questions.variants' => function (HasMany $query) {
            return $query->select('variant_in_kz', 'variant_in_ru', 'question_id', 'id');
        }, 'lesson.section.course'])->append('next');
        $test->questions->makeHidden('right_variant_id');
        return $this->sendResponse($test);
    }

    public function check(Test $test, CheckTestRequest $request)
    {
        $answers = $request->get('answers');
        $result = $test->checkTest($answers);
        // $result = $result->makeHidden('answers');
        return $this->sendResponse($result);
    }

    public function errors(Test $test)
    {
        if (!$test->results()->exists()) {
            return $this->sendError([], 'Test not passed');
        }
        return $this->sendResponse($test->load('lastResult'));
    }
}
