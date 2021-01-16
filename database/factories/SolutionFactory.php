<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Solution::class, function (Faker $faker) {
    return [
        'question' => $faker->sentences(20,true),
        'answer' => $faker->sentences(20,true),
        'course_id' => $faker->numberBetween(1, 60),
        'order' => rand(1,50),
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];
});
