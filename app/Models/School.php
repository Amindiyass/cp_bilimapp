<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $table = 'schools';
    protected $primaryKey = 'id';
    protected $fillable = ['name_ru', 'name_kz', 'region_id'];


    public function region()
    {
        return $this->belongsTo(Region::class);
    }

}
