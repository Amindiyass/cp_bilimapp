<?php

namespace App\Http\Controllers\Api;

use App\Models\Area;
use App\Models\EducationLevel;
use App\Models\Language;
use App\Models\Region;
use App\Models\School;
use App\Models\Subject;
use Illuminate\Http\Request;

class DictionaryController extends BaseController
{
    public function areas()
    {
        return $this->sendResponse(Area::all());
    }

    public function schools(Request $request)
    {
        $query = School::query();
        $query->when($request->region_id, fn($query) => $query->where('region_id', request('region_id')));
        return $this->sendResponse($query->get());
    }

    public function regions(Request $request)
    {
        $query = Region::query();
        $query->when($request->area_id, fn($query) => $query->where('area_id', request('area_id')));
        return $this->sendResponse($query->get());
    }

    public function languages()
    {
        return $this->sendResponse(Language::all());
    }

    public function classes()
    {
        return $this->sendResponse(EducationLevel::all());
    }

    public function subjects()
    {
        return $this->sendResponse(Subject::select('id', 'name_ru', 'name_kz')->get());
    }
}
