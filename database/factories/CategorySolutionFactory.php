<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\SolutionCategory::class, function (Faker $faker) {
    return [
        'category_id' => $faker->numberBetween(1, 200),
        'solution_id' => $faker->numberBetween(1,1400),
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];
});
