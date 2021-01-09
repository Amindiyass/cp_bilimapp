<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends BaseController
{
    public function show(Lesson $lesson)
    {
        $lesson->load(['videos.completedRate', 'conspectus', 'assignments'])->append('next_step');
        return $this->sendResponse($lesson);
    }

    public function assignments(Lesson $lesson)
    {
        $assignments = $lesson->assignments()->select('id', 'lesson_id', 'created_at', 'updated_at')->paginate(30);
        return $this->sendResponse($assignments);
    }
}
