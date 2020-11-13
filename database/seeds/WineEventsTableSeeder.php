<?php

use App\WineEvent;
use Illuminate\Database\Seeder;

class WineEventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(WineEvent::class, 30)->create();
    }
}
