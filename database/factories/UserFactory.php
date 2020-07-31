<?php

/**
 * User Factory
 * Used to determine random data to seed into the database
 *
 * @var Factory $factory
 */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => $faker->password(20),
    ];
});
