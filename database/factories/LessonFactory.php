<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Lesson::class, function (Faker $faker) {
    $name = $faker->sentence(1,10);
    return [
        'name_ru' => $name,
        'name_kz' => $name,
        'section_id' => $faker->numberBetween(1,100),
        'description_kz' => $name,
        'description_ru' => $name,
        'what_will_learn_kz' => $name,
        'what_will_learn_ru' => $name,
    ];
});
