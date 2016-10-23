<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHashedWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hashed_words', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('word_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('hash');
            $table->string('algorithm');

            $table->foreign('word_id')->references('id')->on('vocabulary');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('hashed_words');
    }
}
