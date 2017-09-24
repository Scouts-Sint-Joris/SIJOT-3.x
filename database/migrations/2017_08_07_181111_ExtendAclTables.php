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
            $table->integer('author_id')->nullable()->after('id');
            $table->string('system_role')->nullable()->after('author_id');
            $table->text('description')->nullable()->after('name');
        });

        Schema::table($config['permissions'], function (Blueprint $table) {
            $table->integer('author_id')->nullable()->after('id');
            $table->string('system_permission')->nullable()->after('author_id');
            $table->text('description')->nullable()->after('name');
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
            $table->dropColumn(['author_id', 'system_role', 'description']);
        });

        Schema::table($config['permissions'], function (Blueprint $table) {
            $table->dropColumn(['author_id', 'system_permission', 'description']);
        });
    }
}
