<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Home extends Model
{
    public static function get_items(int $week_number)
    {
        $result = cache()->remember('test_count', '300', function () use ($week_number) {
            $users = User::where('is_active', true)->get();

            $subscriptions = $users->loadCount('subscriptions')->pluck('subscriptions_count');
            $subscriptions = array_sum($subscriptions->toArray());

            #TODO user activity count after integration laravel-activity

            $subjects = Subject::all();
            $subject_count = $subjects->count();

            $courses = Course::all();
            $course_count = $courses->count();

            $lessons = Lesson::all()->count();

            $tests = Test::all()->count();

            $videos = Video::all()->count();

            $conspectus = Conspectus::all()->count();

            $assignments = Assignment::all()->count();

            $likes = Like::all()->count();

            $reviews = Review::all()->count();


            $weekDays = [];
            $day_names = [];


            $date_string = sprintf("%s weeks last Monday", $week_number);


            if ($week_number == 0) {
                $date_string = "last monday";
            }

            $last_monday = date('d-m-Y', strtotime($date_string));
            # TODO if i will use
//        $ru_weekdays = array('Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье');


            $ts = strtotime($last_monday);
            $year = date('o', $ts);
            $week = date('W', $ts);
            for ($i = 1; $i <= 7; $i++) {
                $week_day = strtotime($year . 'W' . $week . $i);
                $week_day = date("Y-m-d", $week_day);
                $weekDays[] = $week_day;
            }

            $registered_count = User::whereYear('created_at', '=', date('Y', strtotime($weekDays[0])))
                ->whereMonth('created_at', '=', date('m', strtotime($weekDays[0])))
                ->whereDay('created_at', '>=', date('d', strtotime($weekDays[0])))
                ->whereDay('created_at', '<=', date('d', strtotime($weekDays[6])))
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as user_count'))
                ->groupBy('date')
                ->get()
                ->pluck('user_count', 'date')
                ->toArray();


            $registered_count = array_map(function ($item) use ($registered_count) {
                return ($registered_count[$item]) ?? 0;
            }, $weekDays);


            #TODO complete subject users  and decrease code lines


            $subject_tests = DB::table('subjects')->join('courses', 'subjects.id', '=', 'courses.subject_id')
                ->join('sections', 'sections.course_id', '=', 'courses.id')
                ->join('tests', 'tests.section_id', '=', 'sections.id')
                ->whereNull('deleted_at')
                ->groupBy('subjects.id')
                ->select('subjects.id', DB::raw('count(tests.id) as item_count'))
                ->get()
                ->pluck('item_count', 'id')
                ->toArray();

            $subject_lessons = DB::table('subjects')->join('courses', 'subjects.id', '=', 'courses.subject_id')
                ->join('sections', 'sections.course_id', '=', 'courses.id')
                ->join('lessons', 'lessons.section_id', '=', 'sections.id')
                ->groupBy('subjects.id')
                ->select('subjects.id', DB::raw('count(lessons.id) as item_count'))
                ->get()
                ->pluck('item_count', 'id')
                ->toArray();


            $subject_assignments = DB::table('subjects')->join('courses', 'subjects.id', '=', 'courses.subject_id')
                ->join('sections', 'sections.course_id', '=', 'courses.id')
                ->join('lessons', 'lessons.section_id', '=', 'sections.id')
                ->join('assignments', 'assignments.lesson_id', '=', 'lessons.id')
                ->groupBy('subjects.id')
                ->select('subjects.id', DB::raw('count(assignments.id) as item_count'))
                ->get()
                ->pluck('item_count', 'id')
                ->toArray();

            $subject_courses = DB::table('subjects')->join('courses', 'subjects.id', '=', 'courses.subject_id')
                ->groupBy('subjects.id')
                ->select('subjects.id', DB::raw('count(courses.id) as item_count'))
                ->get()
                ->pluck('item_count', 'id')
                ->toArray();


            $subject_rates = [];
            foreach ($subjects as $subject) {
                $subject_rates[$subject->id]['name_ru'] = $subject->name_ru;
                $subject_rates[$subject->id]['name_kz'] = $subject->name_kz;
                $subject_rates[$subject->id]['course_count'] = $subject_courses[$subject->id] ?? 0;
                $subject_rates[$subject->id]['lesson_count'] = $subject_lessons[$subject->id] ?? 0;
                $subject_rates[$subject->id]['test_count'] = $subject_tests[$subject->id] ?? 0;
                $subject_rates[$subject->id]['assignment_count'] = $subject_assignments[$subject->id] ?? 0;
            }

            $result = [
                'users' => $users->count(),
                'subscriptions' => $subscriptions,
                'subjects' => $subject_count,
                'courses' => $course_count,
                'lessons' => $lessons,
                'tests' => $tests,
                'videos' => $videos,
                'conspectus' => $conspectus,
                'assignments' => $assignments,
                'likes' => $likes,
                'reviews' => $reviews,
                'lastWeekDays' => $weekDays,
                'registered_count' => $registered_count,
                'subject_rates' => $subject_rates,
            ];

            return $result;
        });

        return $result;
    }
}
