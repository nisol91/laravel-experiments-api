<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortfolioMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolio_media', function (Blueprint $table) {
            $table->id();
            $table->string('storage_path');
            $table->integer('portfolio_project_id')->unsigned();
            $table->foreign('portfolio_project_id')->references('id')->on('portfolio_projects');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('portfolio_media');
    }
}
