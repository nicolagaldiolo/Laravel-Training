<?php

use Faker\Generator as Faker;
use App\Category;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name'      => $faker->word,
        'user_id'   => factory(App\User::class)->make(),
    ];
});
