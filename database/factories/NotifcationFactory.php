<?php

/**
 * Notification Factory
 * Used to determine random data to seed into the database
 *
 * @var Factory $factory
 */

use App\Notification;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Notification::class, function (Faker $faker) {

    // Randomized if a notification has been soft deleted on seeding
    $soft_deleted = NULL;
    if( rand(1, 10 ) >= 7){
        $soft_deleted = Carbon::now();
    }

    return [
        'type' => $faker->randomElement(['critical', 'general', 'error', 'notice']),
        'read' => rand(1, 2),
        'message' => $faker->paragraph(1),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
        'deleted_at' => $soft_deleted,
    ];
});
