<?php


namespace App\Search;


class CourseSearch extends ModelSearch
{
    public function subject($subject_name)
    {
        return $this->builder->where('name_kz', 'LIKE', "%{$subject_name}%")
            ->orWhere('name_ru', 'LIKE', "%{$subject_name}%");
    }
}
