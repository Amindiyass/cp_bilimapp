<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Region::class, function (Faker $faker) {
    $name = $faker->sentence(1, 5);
    return [
        'area_id' => $faker->numberBetween(1, 10),
        'name_kz' => $name,
        'name_ru' => $name,
    ];
});
