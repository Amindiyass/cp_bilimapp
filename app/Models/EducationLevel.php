<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationLevel extends Model
{
    protected $table = 'education_levels';
    protected $primaryKey = 'id';

    public function filter_list()
    {
        $array = ['type' => 'class'];
        $items = [];
        foreach (self::all() as $item) {
            $items[] =
                [
                    'id' => $item->id,
                    'name_kz' => $item->name_kz,
                    'name_ru' => $item->name_ru,
                ];
        }
        $array['items'] = $items;
        return $array;
    }


}
