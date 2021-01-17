<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SolutionController extends BaseController
{

    public function courseSolutions(Course $course, Request $request)
    {
        $solutionsQuery = $course->solutions()->with('categories');
        if ($categoryIds = $request->get('category_ids', '')) {
            $categoryIds = is_array($categoryIds) ? $categoryIds : explode(',', $categoryIds);
            $solutionsQuery = $solutionsQuery->whereHas('categories', function (Builder $query) use ($categoryIds) {
                $query->whereIn('categories.id', $categoryIds);
            });
        }
        if ($searchQuery = $request->get('query', '')) {
            $solutionsQuery = $solutionsQuery->where(function ($query) use ($searchQuery){
                $query->whereRaw("answer ilike '%$searchQuery%'")->orWhereRaw("question ilike '%$searchQuery%'");
            });
        }
        return $solutionsQuery->get();
    }

    public function categories(Course $course)
    {
        return $course->solutionCategories;
    }

}
