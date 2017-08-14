<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('author_id'); 
            $table->string('title'); 
            $table->string('image_path');
            $table->string('url'); 
            $table->text('description'); 
            $table->timestamps();
        });

        Schema::create('groups_photos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('groups_id'); 
            $table->integer('photos_id'); 
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
        Schema::dropIfExists('photos');
        Schema::dropIfExists('groups_photos');
    }
}
