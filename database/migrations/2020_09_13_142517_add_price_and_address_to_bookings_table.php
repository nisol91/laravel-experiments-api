<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceAndAddressToBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedInteger('price');
            $table->unsignedBigInteger('address_id')->index()->nullable();
            // $table->integer('address_id')->unsigned();

            $table->foreign('address_id')->references('id')->on('addresses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('price');

            // mettendo tra quadre si fa capire a laravel di droppare
            // la corretta foreign key, perchè laravel da i suoi nomi
            // alle foreign keys una volta runnate le migrations
            $table->dropForeign(['address_id']);
            $table->dropColumn('address_id');
        });
    }
}
