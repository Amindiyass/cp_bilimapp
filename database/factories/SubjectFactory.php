<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Subject::class, function (Faker $faker) {
    $name = $faker->sentence(1, 10);
    return [
        'name_kz' => $name,
        'name_ru' => $name,
    ];
});
