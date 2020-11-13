<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('users_permissions', function (Blueprint $table) {
            // many to many relationship between users and permissions

            // nb: se user_id è increments e unsigned, allora per coerenza devo avere integer e unsigned
            $table->integer('user_id')->unsigned();
            $table->integer('permission_id')->unsigned();
        });

        // table è per l'update. quando si fa una pivot è sempre meglio prima creare i campi
        // e poi fare l'update con le foreign, per evitare che laravel generi errori in fase di migration

        Schema::table('users_permissions', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_permissions');
    }
}
