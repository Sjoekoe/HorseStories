<?php

use Carbon\Carbon;
use EQM\Models\Comments\EloquentComment;
use EQM\Models\Disciplines\EloquentDiscipline;
use EQM\Models\Events\EloquentEvent;
use EQM\Models\Horses\EloquentHorse;
use EQM\Models\HorseTeams\EloquentHorseTeam;
use EQM\Models\Palmares\EloquentPalmares;
use EQM\Models\Pedigrees\EloquentPedigree;
use EQM\Models\Statuses\EloquentStatus;
use EQM\Models\Users\EloquentUser;
use Faker\Generator;

$factory->define(EloquentUser::class, function (Generator $faker) {
    return [
        'last_name' => $faker->name,
        'first_name' => $faker->name,
        'email' => $faker->email,
        'language' => 'en',
        'activated' => true,
        'password' => bcrypt('password'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(EloquentHorse::class, function (Generator $faker) {
    return [
        'name' => 'test horse',
        'life_number' => $faker->randomNumber(),
        'date_of_birth' => Carbon::now(),
        'slug' => 'test-horse',
        'gender' => 1,
        'color' => 1,
        'height' => '1m70',
        'breed' => 1,
    ];
});

$factory->define(EloquentHorseTeam::class, function (Generator $faker) {
    return [
        'type' => 1,
    ];
});

$factory->define(EloquentStatus::class, function (Generator $faker) {
    return [
        'body' => $faker->text,
    ];
});

$factory->define(EloquentPalmares::class, function(Generator $faker) {
    return [
        'discipline' => $faker->randomDigitNotNull,
        'level' => 'zz',
        'ranking' => $faker->randomDigitNotNull,
        'date' => $faker->dateTime,
    ];
});

$factory->define(EloquentEvent::class, function(Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});

$factory->define(EloquentPedigree::class, function(Generator $faker) {
    return [];
});

$factory->define(EloquentComment::class, function (Generator $faker) {
    return [
        'body' => $faker->text,
    ];
});

$factory->define(EloquentDiscipline::class, function (Generator $faker) {
    return [];
});
