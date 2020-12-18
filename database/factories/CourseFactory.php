<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Model;


$factory->define(App\Models\Course::class, function (Faker $faker) {
    $name = $faker->sentence(1, 7);
    $desc = $faker->paragraph();
    return [
        'name_ru' => $name,
        'name_kz' => $name,
        'language_id' => $faker->numberBetween(1, 2),
        'subject_id' => $faker->numberBetween(1, 20),
        'class_id' => $faker->numberBetween(1, 11),
        'order' => $faker->numberBetween(1, 20),
        'description_ru' => $desc,
        'description_kz' => $desc,

    ];
});
