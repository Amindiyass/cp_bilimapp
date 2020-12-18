<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\AssignmentSolution::class, function (Faker $faker) {
    return [
        'content' => $faker->text
    ];
});
