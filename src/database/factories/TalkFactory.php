<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Talk;
use App\User;
use Faker\Generator as Faker;

$factory->define(Talk::class, function (Faker $faker) {

    $date = new \DateTime();

    // add random number months to current date
    $month = $date->format('m');
    $monthsToAdd = ($month % 2 === 0) ? [2, 4, 6] : [1, 3, 5];
    $randomMonthToAdd = $monthsToAdd[array_rand($monthsToAdd)];
    $date->modify("+$randomMonthToAdd month");

    $year = $date->format('Y');
    $month = $date->format('m');

    $str = "first tuesday $year-$month";
    $date = (new \DateTime())->setTimestamp(strtotime($str));

    return [
        'topic' => $faker->text(80),
        'description' => $faker->sentence(120),
        'date' => $date,
        'status' => Talk::STATUS[array_rand(Talk::STATUS)],
        'user_id' => factory(User::class),
    ];
});
