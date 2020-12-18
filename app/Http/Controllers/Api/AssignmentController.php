<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\SearchAssignmentRequest;
use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentController extends BaseController
{
    public function show(Assignment $assignment)
    {
        if (!$assignment->checkLesson()) {
            return $this->sendError('Lesson not passed');
        }
        return $this->sendResponse($assignment);
    }

    public function solution(Assignment $assignment)
    {
        if (!$assignment->checkLesson()) {
            return $this->sendError('Lesson not passed');
        }
        return $this->sendResponse($assignment->solution);
    }


    public function search(SearchAssignmentRequest $request)
    {
        $assignments = Assignment::where('content', 'like', '%'.$request->input('content').'%')->paginate(30);
        return $this->sendResponse($assignments);
    }
}
