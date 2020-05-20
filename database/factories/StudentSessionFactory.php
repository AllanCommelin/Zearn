<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Session;
use App\StudentSession;
use App\User;
use Faker\Generator as Faker;

$factory->define(StudentSession::class, function (Faker $faker) {
    return [
        'session_id' => factory(Session::class),
        'student_id' => factory(User::class)->create(['role' => 'student']),
        'student_mark' => $faker->numberBetween(0,20)
    ];
});
