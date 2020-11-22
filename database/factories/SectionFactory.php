<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Section::class, function (Faker $faker) {
    $name = $faker->sentence(1, 10);
    return [
        'name_ru' => $name,
        'name_kz' => $name,
        'course_id' => $faker->numberBetween(1, 30),
        'sort_number' => $faker->numberBetween(1, 20),
    ];
});
