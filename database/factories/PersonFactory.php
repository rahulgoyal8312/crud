<?php

use Faker\Generator as Faker;

$factory->define(App\Person::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'phone' => $faker->phoneNumber,
        'address'=> $faker->address
    ];
});
