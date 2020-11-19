<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'areas';
    protected $primaryKey = 'id';
    protected $fillable = ['name_kz', 'name_ru'];

    public function regions()
    {
        return $this->hasMany(Region::class, 'area_id', 'id');
    }
}
