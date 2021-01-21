<?php


namespace App\Filters;


class AssignmentFilter extends QueryFilter
{
    public function subjects($subject_ids)
    {
        return $this->builder->orWhereIn('subject_id', $this->paramToArray($subject_ids));
    }

    public function sections($section_ids)
    {
        return $this->builder->orWhereIn('section_id', $this->paramToArray($section_ids));
    }

    public function lessons($lesson_ids)
    {
        return $this->builder->orWhereIn('lesson_id', $this->paramToArray($lesson_ids));
    }

}
