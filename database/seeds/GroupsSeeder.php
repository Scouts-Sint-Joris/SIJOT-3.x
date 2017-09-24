<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = [
            ['title' => 'De Kapoenen',      'sub_title' => 'van ... tot ... jaar', 'selector' => 'kapoenen'],
            ['title' => 'De Welpen',        'sub_title' => 'van ... tot ... jaar', 'selector' => 'welpen'],
            ['title' => 'De Jong-Givers',   'sub_title' => 'van ... tot ... jaar', 'selector' => 'jongGivers'],
            ['title' => 'De Givers',        'sub_title' => 'van ... tot ... jaar', 'selector' => 'givers'],
            ['title' => 'De Jins',          'sub_title' => 'van ... tot ... jaar', 'selector' => 'jins'],
            ['title' => 'De Leiding',       'sub_title' => 'van ... tot ... jaar', 'selector' => 'leiding'],
        ];

        // Truncate the database table.
        $table = DB::table('groups');
        $table->delete();
        $table->insert($groups);
    }
}
