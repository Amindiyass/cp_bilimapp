<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';
    protected $casts = [
        'right_variant_id' => 'array'
    ];
    protected $fillable = [
        'test_id',
        'right_variant_id',
        'order_number',
        'created_at',
        'updated_at',
        'body_kz',
        'body_ru'
    ];
    protected $appends = [
        'multiple'
    ];


    public function variants()
    {
        return $this->hasMany(TestVariant::class);
    }

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function right_variants()
    {
        return count(json_decode($this->right_variant_id));
    }

    public function getMultipleAttribute()
    {
        return is_array($this->right_variant_id) ? count($this->right_variant_id) > 1 : false;
    }
}
