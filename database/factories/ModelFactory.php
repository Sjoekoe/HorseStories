<?php
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/
$factory->define(EQM\Models\Users\User::class, function (Faker\Generator $faker) {
    return [
        'last_name' => $faker->name,
        'first_name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt('password'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(EQM\Models\Settings\Setting::class, function (Faker\Generator $faker) {
    return [
        'email_notifications' => true,
        'date_format' => 'd/m/Y',
        'language' => 'en',
    ];
});