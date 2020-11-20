<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'regions';
    protected $primaryKey = 'id';
    protected $fillable = ['area_id', 'name_ru', 'name_kz'];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function schools()
    {
        return $this->hasMany(School::class);
    }
}
