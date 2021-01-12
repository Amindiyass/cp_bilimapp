<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\CheckTestRequest;
use App\Models\Test;

class TestController extends BaseController
{
    public function check(Test $test, CheckTestRequest $request)
    {
        $answers = $request->get('answers');
        $result = $test->checkTestByAnswer($answers);
        // $result = $result->makeHidden('answers');
        return $this->sendResponse($result->load('test.questions'));
    }
}
