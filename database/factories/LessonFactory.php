<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Lesson;
use App\User;
use Faker\Generator as Faker;

$factory->define(Lesson::class, function (Faker $faker) {
    return [
        'professor_id' => factory(User::class)->create(['role' => 'professor']),
        'name' => $faker->unique()->randomElement(['Framework React', 'PHP', 'Framework Laravel', 'UML', 'Nodejs', 'MySQL', 'Sys Admin'])
    ];
});
