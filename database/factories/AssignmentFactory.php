<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Assignment::class, function (Faker $faker) {
    return [
        'lesson_id' => $faker->numberBetween(1, 200),
        'content' => $faker->text(),

    ];
});
