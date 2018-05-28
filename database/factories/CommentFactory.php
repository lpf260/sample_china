<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Comment::class, function (Faker $faker) {
    $date_time = $faker->date." ".$faker->time;

    return [
        'title' => $faker->title,
        'content' => $faker->text,
        'uid' => rand(1,8898989),
        'created_at' => $date_time,
        'updated_at' => $date_time,
    ];
});
