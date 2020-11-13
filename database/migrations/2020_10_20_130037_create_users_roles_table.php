<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_roles', function (Blueprint $table) {
            // many to many relationship between users and roles

            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();
        });

        // table è per l'update. quando si fa una pivot è sempre meglio prima creare i campi
        // e poi fare l'update con le foreign, per evitare che laravel generi errori in fase di migration

        Schema::table('users_roles', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_roles');
    }
}
