<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Conspectus;
use App\Models\Course;
use App\Models\Home;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Test;
use App\Models\UserSubscription;
use App\Models\Video;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $week_number = $request->input('week_number', 0);
        $results = (new \App\Models\Home)->get_items($week_number);
        return view('admin.home.index', $results);
    }
}
