<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Subscription::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'price' => $faker->randomNumber(),
        'duration_in_year' => $faker->numberBetween(0, 100),
        'duration_in_month' => $faker->numberBetween(0, 12),
        'duration_in_week' => $faker->randomNumber(),
        'discount' => $faker->numberBetween(0, 100)
    ];
});
