<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Student;
use App\Models\UserSubscription;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $users = User::where('is_active', true)->get();

        $subscriptions = $users->loadCount('subscriptions')->pluck('subscriptions_count');
        $subscriptions = array_sum($subscriptions->toArray());

        #TODO user activity count after integration laravel-activity
        return view('admin.home.index', [
            'users' => $users->count(),
            'subscriptions' => $subscriptions,
        ]);
    }
}
