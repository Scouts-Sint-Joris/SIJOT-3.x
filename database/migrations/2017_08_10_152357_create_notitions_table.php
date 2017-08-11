<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notitions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('author_id');
            $table->text('text');
            $table->timestamps();
        });

        Schema::create('lease_notitions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lease_id');
            $table->integer('notitions_id');
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
        Schema::dropIfExists('notitions');
        Schema::dropIfExists('lease_notitions');
    }
}
