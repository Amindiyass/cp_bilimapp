<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Test::class, function (Faker $faker) {
    $name = $faker->sentence(1, 10);
    return [
        'name_kz' => $name,
        'name_ru' => $name,
        'duration' => $faker->time(),
        'lesson_id' => $faker->numberBetween(1, 200),
        'subject_id' => $faker->numberBetween(1, 20),
        'from_time' => $faker->date('Y-m-d H:i:s'),
        'till_time' => $faker->date('Y-m-d H:i:s'),
    ];
});
