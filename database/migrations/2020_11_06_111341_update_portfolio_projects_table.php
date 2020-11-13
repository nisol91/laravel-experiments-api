<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePortfolioProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('portfolio_projects', function (Blueprint $table) {
            $table->longText('long_description');
            $table->longText('long_description_ita');
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
            $table->dropColumn('long_description');
            $table->dropColumn('long_description_ita');
        });
    }
}
