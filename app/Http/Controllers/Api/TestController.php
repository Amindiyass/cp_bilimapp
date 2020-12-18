<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CheckTestRequest;
use App\Models\Test;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TestController extends BaseController
{
    public function show(Test $test)
    {
        $test = $test->with(['questions' => function (HasMany $query) {
            return $query->select('body', 'test_id', 'id')->orderBy('order_number');
        }, 'questions.variants' => function (HasMany $query) {
            return $query->select('variant_in_kz', 'variant_in_ru', 'question_id');
        }])->first()->append('next');
        return $this->sendResponse($test);
    }

    public function check(Test $test, CheckTestRequest $request)
    {
        $answers = $request->get('answers');
        $result = $test->checkTest($answers);
        $result = $result->select('wrong_answered', 'right_answered', 'passed', 'total_question')->first();
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