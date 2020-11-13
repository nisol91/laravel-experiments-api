<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePortfolioMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('portfolio_media', function (Blueprint $table) {
            $table->string('storage_path_video');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('portfolio_media', function (Blueprint $table) {
            $table->dropColumn('storage_path_video');
        });
    }
}
