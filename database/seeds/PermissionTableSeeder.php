<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            // Syntaxis: ['name' => '<role name>'],

            // Global role scopes
            ['name' => 'admin'],
            ['name' => 'verhuur'],
            ['name' => 'leiding'],
            ['name' => 'hoofdleiding']
        ];

        // If there is data in the role table. Delete it.
        $table = DB::table('roles');
        $table->delete();
        $table->insert($data);
    }
}
