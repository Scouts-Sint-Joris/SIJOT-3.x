<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AbilityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        //! If there is data in the table. We need to delete it.
        $table = DB::table('permissions');
        $table->delete();

        // SYNTAXIS: Permission::create(['name' => '<permission name>']);
        // -----
        Permission::create(['name' => 'access-kapoenen']);
        Permission::create(['name' => 'access-welpen']);
        Permission::create(['name' => 'access-jongGivers']);
        Permission::create(['name' => 'access-givers']);
        Permission::create(['name' => 'access-jins']);
        Permission::create(['name' => 'access-leiding']);

        // Assign all the role to 'hoofdleiding'
        $role = Role::where('name', 'hoofdleiding')->first();
        $role->givePermissionTo('access-kapoenen');
        $role->givePermissionTo('access-welpen');
        $role->givePermissionTo('access-jongGivers');
        $role->givePermissionTo('access-givers');
        $role->givePermissionTo('access-jins');
        $role->givePermissionTo('access-leiding');
    }
}
