<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'languages';
    protected $primaryKey = 'id';
    protected $fillable = ['name_kz', 'name_ru'];


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
