<?php

use Faker\Generator as Faker;

$factory->define(App\Url::class, function (Faker $faker) {
    return [
        'url' => $faker->url,
        'hits' => $faker->numberBetween(0, 99999),
    ];
});