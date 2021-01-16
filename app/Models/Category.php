<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function solutions()
    {
        return $this->belongsToMany('App\Solution','solution_categories');
    }
}
