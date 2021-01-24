<?php


namespace App\Http\Controllers\Admin\Ajax;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends BaseController
{
    public function index(Request $request)
    {
        return response()->json(Section::where('course_id', $request->course_id)->get());
    }

}
