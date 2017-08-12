<?php

use Sijot\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Start database truncate
        $table = DB::table('users');
        $table->delete();

        // Start database write
        $user = User::create([
            'name'          => 'Tim Joosten',
            'email'         => 'topairy@gmail.com',
            'password'      => bcrypt('root1995!'),
            'created_at'    => date('Y-m-d H:i:s', time()),
            'updated_at'    => date('Y-m-d H:i:s', time()),
        ]);

        $user->assignRole('admin');
        $user->assignRole('verhuur');
    }
}
