<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiguresTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('figures_tags', function (Blueprint $table) {
            //$table->bigIncrements('id');
            $table->unsignedBigInteger('figure_id');
            $table->unsignedBigInteger('tag_id');

            $table->foreign('figure_id')->references('id')->on('figures');
            $table->foreign('tag_id')->references('id')->on('tags');

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
        Schema::dropIfExists('figures_tags');
    }
}
