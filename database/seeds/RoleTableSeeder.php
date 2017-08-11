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
            ['name' => 'admin', 'description' => 'De administrator gebruikersgroep.'],
            ['name' => 'verhuur', 'description' => 'De gebruikersgroep verantworodelijk voor de verhuur.'],
            ['name' => 'leiding', 'description' => 'De gebruikersgroep van de leiding.'],
            ['name' => 'hoofdleiding', 'description' => 'de gebruikers groep voor de hooofleiding v/d groep.']
        ];

        // If there is data in the role table. Delete it.
        $table = DB::table('roles');
        $table->delete();
        $table->insert($data);
    }
}
