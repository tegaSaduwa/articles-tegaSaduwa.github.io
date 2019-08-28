<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Articles::class, function (Faker $faker) {
    return [
        'title' => $faker-> text(50),
        'body' => $faker-> text(200)
    ];
});
