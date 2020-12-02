<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\TestVariant;
use Faker\Generator as Faker;

$factory->define(TestVariant::class, function (Faker $faker) {
    return [
        'variant_in_kz' => $faker->name,
        'variant_in_ru' => $faker->name,
        'order_number' => 1,
        'question_id' => 1
    ];
});
