<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCoordinatesToWineEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wine_events', function (Blueprint $table) {
            $table->decimal('lat', 10, 7);
            $table->decimal('lng', 10, 7);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wine_events', function (Blueprint $table) {
            $table->dropColumn('lat');
            $table->dropColumn('lng');
        });
    }
}
