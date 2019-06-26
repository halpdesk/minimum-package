<?php

use Faker\Generator as Faker;
use Halpdesk\LaravelMinimumPackage\Models\User;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
    ];
});
