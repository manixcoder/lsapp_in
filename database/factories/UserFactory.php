<?php

use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name'                                  => $faker->name,
        'first_name'                            => $faker->firstName,
        'last_name'                             => $faker->lastName,
        'email'                                 => $faker->unique()->safeEmail,
        'email_verified_at'                     => now(),
        'is_newQuestionArrivedNotification'     =>1,
        'is_reply_to_your_answer'               =>1,
        'is_expert_response_to_question'        =>1,
        'is_marketing_messages'                 =>1,
        'password'                              => bcrypt('qwert@123'), // password
        'remember_token'                        => Str::random(10),
    ];
});
