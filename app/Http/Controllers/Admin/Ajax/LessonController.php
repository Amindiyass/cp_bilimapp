<?php


namespace App\Http\Controllers\Admin\Ajax;

use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Http\Request;

class LessonController extends BaseController
{
    public function index(Request $request)
    {
        return response()->json(Lesson::where('section_id', $request->section_id)->get());
    }

}
