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
        $table =  DB::table('roles');
        $table->delete();

        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Verhuur']);
    }
}
