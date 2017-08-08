<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

/**
 * Class RoleTableSeeder
 */
class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Start database truncate
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
