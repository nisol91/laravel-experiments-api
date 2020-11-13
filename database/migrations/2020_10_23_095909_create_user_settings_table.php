<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('address');
            $table->string('profile_image');
            $table->boolean('hide_profile');
            $table->unsignedInteger('number_of_orders');
            $table->timestamps();
        });

        // table è per l'update. quando si fa una pivot è sempre meglio prima creare i campi
        // e poi fare l'update con le foreign, per evitare che laravel generi errori in fase di migration
        Schema::table('user_settings', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_settings');
    }
}
