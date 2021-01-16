<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Category::class, function (Faker $faker) {
    $name = $faker->sentence(1, 20);
    return [
        'name_kz' => $name,
        'name_ru' => $name,
        'course_id' => $faker->numberBetween(1, 60),
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];
});
