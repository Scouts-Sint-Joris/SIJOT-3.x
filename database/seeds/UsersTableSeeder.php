<?php

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
        $users = [
            // TEMPLATE: ['name' => '', 'email' => '', 'password' => '', 'created_at' => date('Y-m-d H:i:s',time()), 'updated_at' => date('Y-m-d H:i:s',time())],
            [
                'name' => 'Tim Joosten',
                'email' => 'topairy@gmail.com',
                'password' => bcrypt('root1995!'),
                'created_at' => date('Y-m-d H:i:s',time()),
                'updated_at' => date('Y-m-d H:i:s',time()),
                ],
        ];

        // Start database write
        $table = DB::table('users');
        $table->delete();
        $table->insert($users);
    }
}
