<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Lesson;
use App\Session;
use App\User;
use Faker\Generator as Faker;

$factory->define(Session::class, function (Faker $faker) {
    $start_datetime = $faker->dateTimeBetween('-1 years', '+1 years');
    $end_datetime = $faker->dateTimeBetween($start_datetime, $start_datetime->format('Y-m-d H:i:s').'+2 hours');
    $completed = ($start_datetime < new DateTime());
    return [
        'lesson_id' => factory(Lesson::class),
        'report' => ($completed)?$faker->realText():'',
        'nb_hour' => $faker->time(),
        'nb_classroom' => $faker->numberBetween(0,999),
        'start_datetime' =>$start_datetime,
        'end_datetime' => $end_datetime,
        'completed' => $completed
    ];
});
