<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subjects';
    protected $primaryKey = 'id';
    protected $fillable = ['name_ru', 'name_kz'];

    # TODO write relationships before commit


    public function courses()
    {
        return $this->hasMany(Course::class);
    }


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

    public static function detail()
    {
        $subject = Subject::with('courses', 'courses.lesson', 'courses.user')->get();
//        $subject = $subject->load('courses');
        dd($subject->toArray());
    }
}
