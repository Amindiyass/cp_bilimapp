<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Payment::class, function (Faker $faker) {
    return [
        'balance_history_id' => 1,
        'balance' => $faker->randomNumber(),
        'user_id' => 1,
        'subscription_id' => 1,
        'comment' => $faker->text,
        'status_id' => 1,
        'check_response' => json_encode([]),
        'pay_response' => json_encode([]),
    ];
});
