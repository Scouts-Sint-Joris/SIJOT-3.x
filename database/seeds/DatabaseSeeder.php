<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GroupsSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(ThemeTableSeeder::class);
        $this->call(AbilityTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
