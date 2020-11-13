<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // sempre meglio far generare gli user per primi
        $this->call(UsersTableSeeder::class);

        $this->call(BookablesTableSeeder::class);
        // $this->call(BookingsTableSeeder::class);
        // $this->call(ReviewsTableSeeder::class);
        $this->call(WineEventsTableSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(CategorySeeder::class);
    }
}
