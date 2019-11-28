<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiguresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('figures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('image_preview');
            $table->text('description');
            $table->double('x');
            $table->double('y');
            $table->double('z');
            //$table->string('difficulty');
            $table->enum('difficulty', ['easy', 'normal', 'hard']);
            $table->string('glb_download');
            //$table->string('type');
            $table->enum('type', ['public', 'private']);

            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('figures');
    }
}
