<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $casts = [
        'right_variant_id' => 'array'
    ];
    public function variants()
    {
        return $this->hasMany(TestVariant::class);
    }
}
