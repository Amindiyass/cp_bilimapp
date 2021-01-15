<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Video;
use Illuminate\Http\Request;

class LessonController extends BaseController
{
    public function show(Lesson $lesson)
    {
        $lesson->load(['videos.completedRate', 'conspectus', 'assignments', 'test', 'video.completedRate'])->append('next_step');
        $lesson->incrementCompletedRate();
        return $this->sendResponse($lesson);
    }

    public function assignments(Lesson $lesson)
    {
        $assignments = $lesson->assignments()->select('id', 'lesson_id','content', 'created_at', 'updated_at')->paginate(30);
        return $this->sendResponse($assignments);
    }
}
