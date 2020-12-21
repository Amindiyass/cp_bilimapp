<?php


namespace App\Filters;


class StudentFilter extends QueryFilter
{
    public function area($area_ids = [])
    {
        if (empty($area_ids)) {
            return false;
        }
        return $this->builder->whereIn('area_id', $this->paramToArray($area_ids));
    }

    public function region($region_ids = [])
    {
        if (empty($region_ids)) {
            return false;
        }
        return $this->builder->whereIn('region_id', $this->paramToArray($region_ids));
    }

    public function school($school_ids = [])
    {
        if (empty($school_ids)) {
            return false;
        }
        return $this->builder->whereIn('school_id', $this->paramToArray($school_ids));
    }

    public function class($class_ids = [])
    {
        if (empty($class_ids)) {
            return false;
        }
        return $this->builder->whereIn('class_id', $this->paramToArray($class_ids));
    }

    public function language($language_ids = [])
    {
        if (empty($language_ids)) {
            return false;
        }
        return $this->builder->whereIn('language_id', $this->paramToArray($language_ids));
    }
}
