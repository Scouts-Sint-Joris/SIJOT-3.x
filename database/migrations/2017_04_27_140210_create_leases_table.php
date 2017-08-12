<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('status_id')->nullable();
            $table->integer('opener_id')->nullable(); 
            $table->integer('afsluiter_id')->nullable();
            $table->string('kapoenen_lokaal')->nullable();
            $table->string('welpen_lokaal')->nullable();
            $table->string('jongGivers_lokaal')->nullable(); 
            $table->string('givers_lokaal')->nullable(); 
            $table->string('jins_lokaal')->nullable();
            $table->string('grote_zaal')->nullable();
            $table->string('toiletten')->nullable();
            $table->string('groeps_naam');
            $table->string('contact_email');
            $table->string('tel_nummer')->nullable();
            $table->date('eind_datum');
            $table->date('start_datum');
            $table->softDeletes();
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
        Schema::dropIfExists('leases');
    }
}
