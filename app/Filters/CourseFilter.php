<?php


namespace App\Filters;


class CourseFilter extends QueryFilter
{
    public function classes($class_ids)
    {
        return $this->builder->whereIn('class_id', $this->paramToArray($class_ids));
    }

    public function languages($language_ids)
    {
        return $this->builder->whereIn('language_id', $this->paramToArray($language_ids));
    }

    public function subjects($subject_ids)
    {
        return $this->builder->whereIn('subject_id', $this->paramToArray($subject_ids));
    }


}
