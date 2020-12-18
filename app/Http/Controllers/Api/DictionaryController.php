<?php

namespace App\Http\Controllers\Api;

use App\Models\Area;
use App\Models\EducationLevel;
use App\Models\Language;
use App\Models\Region;
use App\Models\School;

class DictionaryController extends BaseController
{
    public function areas()
    {
        return $this->sendResponse(Area::all());
    }

    public function schools()
    {
        return $this->sendResponse(School::all());
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
