<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Student;
use Faker\Generator as Faker;

$factory->define(Student::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name'  => $faker->lastName,
        'area_id' => 1,
        'region_id' => 1,
        'school_id' => 1,
        'language_id' => 1,
        'user_id' => 1,
        'class_id' => 1
    ];
});
