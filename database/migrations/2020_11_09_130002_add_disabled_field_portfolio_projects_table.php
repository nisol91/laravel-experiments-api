<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDisabledFieldPortfolioProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('portfolio_projects', function (Blueprint $table) {
            $table->boolean('disabled');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('portfolio_projects', function (Blueprint $table) {
            $table->dropColumn('disabled');
        });
    }
}
