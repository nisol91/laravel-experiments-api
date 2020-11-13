<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\WineEvent;
use Carbon\Carbon;
use Faker\Generator as Faker;

$cities = [
    'Parma',
    'Piacenza',
    'Verona',
    'Firenze',
    'Brescia',
    'Vicenza',
    'Asti',
    'Cuneo',
];

$factory->define(WineEvent::class, function (Faker $faker) use ($cities) {
    $from = Carbon::instance($faker->dateTimeBetween('-1 months', '+1 months'));
    $to = (clone $from)->addDays(random_int(0, 14));
    return [
        'name' => $faker->name,
        'description' => $faker->text(),
        'city' => Arr::random($cities),
        'price' => random_int(15, 600),
        'from' => $from,
        'to' => $to,
        'lat' => mt_rand (10*10, 12*10) / 10,
        'lng' => mt_rand (40*10, 45*10) / 10,
    ];
});
