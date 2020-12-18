<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Assignment;
use Faker\Generator as Faker;

$factory->define(Assignment::class, function (Faker $faker) {
    return [
        'content' => $faker->text,
        'lesson_id' => 1
    ];
});
