<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    public static function get_items()
    {
        $result = cache()->remember('test_count', '300', function () {
            $users = User::where('is_active', true)->get();

            $subscriptions = $users->loadCount('subscriptions')->pluck('subscriptions_count');
            $subscriptions = array_sum($subscriptions->toArray());

            #TODO user activity count after integration laravel-activity

            $subject = Subject::all()->count();

            $lessons = Lesson::all()->count();

            $tests = Test::all()->count();

            $videos = Video::all()->count();

            $conspectus = Conspectus::all()->count();

            $assignments = Assignment::all()->count();

//            $subject_details = Subject::detail();

            $result = [
                'users' => $users->count(),
                'subscriptions' => $subscriptions,
                'subject' => $subject,
                'lessons' => $lessons,
                'tests' => $tests,
                'videos' => $videos,
                'conspectus' => $conspectus,
                'assignments' => $assignments,

            ];

            return $result;
        });

        return $result;
    }
}
