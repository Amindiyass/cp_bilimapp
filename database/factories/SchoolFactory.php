<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\School::class, function (Faker $faker) {
    $name = $faker->sentence(1, 8);
    return [
        'name_ru' => $name,
        'name_kz' => $name,
        'region_id' => $faker->numberBetween(1,10),
    ];
});
