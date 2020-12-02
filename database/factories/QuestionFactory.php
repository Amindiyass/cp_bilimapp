<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Question;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'body' => $faker->text,
        'test_id' => 1,
        'right_variant_id' => [$faker->numberBetween(1, 4) => $faker->numberBetween(1, 4)],
        'order_number' => 1
    ];
});
