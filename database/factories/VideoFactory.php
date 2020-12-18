<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Video::class, function (Faker $faker) {
    $name = $faker->sentence(1, 20);
    return [
        'title_kz' => $name,
        'title_ru' => $name,
        'lesson_id' => $faker->numberBetween(1, 200),
        'subject_id' => $faker->numberBetween(1, 20),
        'path' => $faker->sentence(1, 20),
        'sort_number' => $faker->numberBetween(1, 5),
    ];
});
