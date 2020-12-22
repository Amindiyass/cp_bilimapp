<?php


namespace App\Filters;

use Illuminate\Database\Query\Builder;

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

//    public function subjects($subject_ids)
//    {
//        return $this->builder->whereIn('subject_id', $this->paramToArray($subject_ids));
//    }

    public function subjects($subjects)
    {
        $subjects = $this->paramToArray($subjects);

        return $this->builder->whereHas('subject', function($query) use ($subjects) {
            return $query->whereIn('name_kz', $subjects)->orWhereIn('name_ru', $subjects);
        });
    }

    public function subject($subject)
    {
        return $this->builder->whereHas('subject', function ($query) use ($subject) {
            return $query->where('name_kz', 'LIKE', '%'.$subject.'%')->orWhere('name_ru', 'LIKE', '%'.$subject.'%');
        });
    }

    public function subject_id($subject)
    {
        return $this->builder->where('subject_id', $subject);
    }


}
