<?php

use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder
 * Main database seeder class used to create users in the database.
 *
 */
class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
    }
}
