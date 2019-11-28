<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsFiguresUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments_figures_users', function (Blueprint $table) {
            //$table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('figure_id');
            $table->unsignedBigInteger('comment_id');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('figure_id')->references('id')->on('figures');
            $table->foreign('comment_id')->references('id')->on('comments');

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
        Schema::dropIfExists('comments_figures_users');
    }
}
