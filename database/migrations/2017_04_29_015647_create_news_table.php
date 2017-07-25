<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('author_id')->unsigned()->index();
            $table->foreign('author_id')->references('id')->on('users');
            $table->string('title');
            $table->string('publish')->nullable();
            $table->text('message');
            $table->timestamps();
        });

        Schema::create('categories_news', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('news_id')->unsigned()->index();
            $table->foreign('news_id')->references('id')->on('news');

            $table->integer('categories_id')->unsigned()->index();
            $table->foreign('categories_id')->references('id')->on('categories');

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
        Schema::dropIfExists('news');
        Schema::dropIfExists('categories_news');
    }
}
