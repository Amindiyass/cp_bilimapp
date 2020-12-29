<?php

namespace App\Http\Controllers\Api;

use App\Filters\CourseFilter;
use App\Models\Course;
use App\Models\EducationLevel;
use App\Models\Language;
use App\Models\Lesson;
use App\Models\Subject;
use App\Models\Student;
use App\Models\Test;
use App\Search\CourseSearch;
use Illuminate\Http\Request;


class CourseController extends BaseController
{
    public function all(CourseFilter $filter)
    {
        return $this->sendResponse(
            Course::filter($filter)->with(['language', 'class', 'subject'])->get()->append(['count_tests', 'count_videos', 'link'])
        );
    }

    public function index(CourseFilter $filter)
    {
        /** @var Student $student */
        $student = auth()->user()->student()->firstOrFail();

        $courses = $student->courses()->filter($filter)->with(['language', 'class', 'subject', 'completedRate' =>
            fn($query) => $query->orderBy('rate', 'DESC')
        ])->get()->append(['count_tests', 'count_videos', 'link']);

        return $this->sendResponse($courses);
    }
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
                'subject_ru' => $course->subject->name_ru,
                'subject_kz' => $course->subject->name_kz,
                'class_ru' => $course->class->name_ru,
                'class_kz' => $course->class->name_kz,
                'name_ru' => $course->name_ru,
                'name_kz' => $course->name_kz,
                'description' => $course->description,
                'tests_count' => $course->count_tests,
                'videos_count' => $course->count_videos,
                'language_ru' => $course->language->name_ru,
                'language_kz' => $course->language->name_kz,
                'photo' => $course->photo,
                'complete_rate' => $completeRate->rate ?? 0
            ],
            'Предмет');
    }

    public function details(Course $course)
    {
        $lessons = $course->lessons()->get();
        $result = [];
        foreach ($lessons as $lesson) {
            if ($lesson->videos->count() > 0) {
                $result[] = $lesson->toArray() + ['type' => 'videos'];
            }
            if ($lesson->tests->count() > 0) {
                unset($lesson->videos);
                $result[] = $lesson->toArray() + ['type' => 'tests'];
            }
            if ($lesson->assignments->count() > 0) {
                unset($lesson->tests);
                $result[] = $lesson->toArray() + ['type' => 'assignments'];
            }
        }
//        $lessons = $course->lessons()
//                          ->with(['videos', 'conspectus', 'tests', 'completedRate', 'assignments' => function($query) {
//                              return $query->select('id', 'lesson_id');
//                          }])
//                          ->get();
        return $this->sendResponse($result, 'Содержимое курса');
    }

    public function tests(Course $course)
    {
        $result = [];
        /** @var Lesson[] $lessons */
        $lessons = $course->lessons()->has('tests')->with('tests.completedRate')->get();
        foreach ($lessons as $lesson) {
            $tests = $lesson->tests->append('count_questions');
            $result = $result + $tests->toArray();
        }
        return $this->sendResponse($result);
    }


    public function filter(CourseFilter $filters)
    {
        $result = [];
        $courses = Course::filter($filters)->get();
        $course_test = Course::test_count();
        $course_video = Course::video_count();
        $course_assignment = Course::assignment_count();
        foreach ($courses as $course) {
            $result[] = [
                'id' => $course->id,
                'name_kz' => $course->name_kz,
                'name_ru' => $course->name_ru,
                'class_name_kz' => $course->class->name_kz,
                'class_name_ru' => $course->class->name_ru,
                'language_name_kz' => $course->language->name_kz,
                'language_name_ru' => $course->language->name_ru,
                'test_quantity' => $course_test[$course->id],
                'video_quantity' => $course_video[$course->id],
                'assignment_quantity' => $course_assignment[$course->id],
            ];
        }
        return $this->sendResponse($result);

    }


    public function search(CourseSearch $search)
    {
        $courses = Course::search($search)->get();
        return $this->sendResponse($courses);
    }


    public
    function filter_attributes()
    {
        $attributes = [
            [
                'type' => 'class',
                'name_ru' => 'Класс',
                'name_kz' => 'Сынып',
            ],
            [
                'type' => 'language',
                'name_ru' => 'Язык',
                'name_kz' => 'Тіл',
            ],
            [
                'type' => 'subject',
                'name_ru' => 'Предмет',
                'name_kz' => 'Пән',
            ]
        ];

        return $this->sendResponse($attributes);
    }

    public
    function filter_variants(Request $request)
    {
        $type = $request->input('type');
        $result = [];
        switch ($type) {
            case 'class':
                $result = (new \App\Models\EducationLevel)->filter_list();
                break;
            case 'language':
                $result = (new \App\Models\Language)->filter_list();
                break;
            case 'subject':
                $result = (new \App\Models\Subject)->filter_list();
                break;
        }
        return $this->sendResponse($result);
    }
}
