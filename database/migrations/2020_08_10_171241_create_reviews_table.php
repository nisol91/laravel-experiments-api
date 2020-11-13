<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            // questo è un id unico a stringa
            $table->uuid('id')->primary();
            $table->timestamps();

            $table->unsignedTinyInteger('rating');
            $table->text('content');


            //  usando questo comando non va, funzionano solo quelli sotto
            // $table->unsignedBigInteger('bookable_id')->index();

            $table->integer('bookable_id')->unsigned()->index();
            $table->foreign('bookable_id')->references('id')->on('bookables');


            // $table->unsignedBigInteger('booking_id')->index()->nullable();
            $table->integer('booking_id')->unsigned()->index()->nullable();
            $table->foreign('booking_id')->references('id')->on('bookables');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
