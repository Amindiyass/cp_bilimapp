<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\EducationLevel::class, function (Faker $faker) {
    $name = $faker->sentence(1, 7);
    return [
        'name_kz' => $name,
        'name_ru' => $name,
        'order_number' => $faker->unique()->numberBetween(1, 11),
    ];
});
