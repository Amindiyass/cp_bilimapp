<?php

namespace App\Http\Controllers\Api;

use App\Models\Area;
use App\Models\EducationLevel;
use App\Models\Language;
use App\Models\Region;
use App\Models\School;
use Illuminate\Http\Request;

class DictionaryController extends BaseController
{
    public function areas(Request $request)
    {
        $query = Area::query();
        $query->when($request->region_id, fn($query) => $query->where('region_id', request('region_id')));
        return $this->sendResponse($query->get());
    }

    public function schools(Request $request)
    {
        $query = School::query();
        $query->when($request->region_id, fn($query) => $query->where('region_id', request('region_id')));
        return $this->sendResponse($query->get());
    }

    public function regions()
    {
        return $this->sendResponse(Region::all());
    }

    public function languages()
    {
        return $this->sendResponse(Language::all());
    }

    public function classes()
    {
        return $this->sendResponse(EducationLevel::all());
    }
}
