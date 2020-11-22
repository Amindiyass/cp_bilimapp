<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use App\Models\Test;

class CourseController extends BaseController
{
    /**
     * Display the specified resource.
     *
     * @param Course $course
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Course $course)
    {
        $completeRate = $course->completedRate()->byUser()->first();
        return $this->sendResponse(
            [
                'name_ru' => $course->subject->name_ru . ' ' . $course->class->name_ru,
                'name_kz' => $course->subject->name_kz . ' ' . $course->class->name_kz,
                'description' => $course->description,
                'tests_count' => Test::whereIn('lesson_id', $course->lessons()->select('lessons.id'))->count(),
                'lessons_count' => $course->lessons()->count(),
                'language_ru' => $course->language->name_ru,
                'language_kz' => $course->language->name_kz,
                'photo'       => $course->photo,
                'complete_rate' => $completeRate->rate ?? 0
            ],
            'Предмет');
    }

    public function details(Course $course)
    {
        $lessons = $course->lessons()
                          ->with('videos', 'conspectus', 'tests', 'completedRate')
                          ->get();
        return $this->sendResponse($lessons, 'Содержимое курса');
    }

    public function tests(Course $course)
    {
        $result = [];
        $lessons = $course->lessons()
            ->with('tests.notCompletedRate')
            ->get();
        foreach ($lessons as $lesson) {
            $result[] = $lesson->tests;
        }
        return $this->sendResponse($result);
    }
}
