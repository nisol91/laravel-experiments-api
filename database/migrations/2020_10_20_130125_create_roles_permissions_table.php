<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('roles_permissions', function (Blueprint $table) {
            // many to many relationship between roles and permissions

            $table->integer('role_id')->unsigned();
            $table->integer('permission_id')->unsigned();
        });


        // table è per l'update. quando si fa una pivot è sempre meglio prima creare i campi
        // e poi fare l'update con le foreign, per evitare che laravel generi errori in fase di migration
        Schema::table('roles_permissions', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
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
        Schema::dropIfExists('roles_permissions');
    }
}
