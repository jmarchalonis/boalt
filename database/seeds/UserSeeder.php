<?php

use App\User;
use Illuminate\Database\Seeder;

/**
 * Class UserSeeder
 * This Seeder is used to create a database of the
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 100)
            ->create()
            ->each(
                function ($user) {
                    // Seed 5 Notifications for Each User
                    $user->notifications()->createMany(
                        factory(App\Notification::class, 5)->make()->toArray()
                    );
                }
            );
    }
}
