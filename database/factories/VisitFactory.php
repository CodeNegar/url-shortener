<?php

use Carbon\Carbon;
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

$factory->define(App\Visit::class, function (Faker $faker) {
    return [
        'url_id'      => 1,
        'created_at'  => Carbon::now(),
        'os'          => 'Windows 10',
        'client_type' => 'browser',
        'client_name' => 'Chrome',
        'device'      => 'desktop',
        'referrer'    => 'http://localhost/example',
        'ip'          => '127.0.0.1',
        'country'     => 'localhost',
        'user_agent'  => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.139 Safari/537.36',
        'is_bot'      => 0,
    ];
});
