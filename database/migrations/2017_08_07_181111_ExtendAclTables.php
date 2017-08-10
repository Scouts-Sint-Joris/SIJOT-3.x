<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExtendAclTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $config = config('laravel-permission.table_names');

        Schema::table($config['roles'], function (Blueprint $table) {
            $table->integer('author_id')->after('id'); 
            $table->string('system_role')->after('author_id');
            $table->text('description')->after('name');
        });

        Schema::table($config['permissions'], function (Blueprint $table) {
            $table->integer('author_id')->after('id'); 
            $table->string('system_permission')->after('author_id');
            $table->text('description')->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $config = config('laravel-permission.table_names');

        Schema::table($config['roles'], function (Blueprint $table) {
            $table->dropColumn('author_id');
            $table->dropColumn('system_role');
            $table->dropColumn('description');
        });

        Schema::table($config['permissions'], function (Blueprint $table) {
            $table->dropColumn('author_id'); 
            $table->dropColumn('system_permission');
            $table->dropColumn('description');
        });
    }
}
