<?php

use App\Bookable;
use App\Review;
use Illuminate\Database\Seeder;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bookable::all()->each(function (Bookable $bookable) {

            // creo da 5 a 30 review per ogni bookable e non uso create() che salverebbe direttamente,
            // ma uso make()
            $reviews = factory(Review::class, random_int(5, 30))->make();
            $bookable->reviews()->saveMany($reviews);
        });
    }
}
