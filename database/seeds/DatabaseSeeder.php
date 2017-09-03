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
        if (app()->environment() === 'production') {
            exit();
        }

        Eloquent::unguard();

        // Truncate all tables, except migrations.
        $tables      = DB::select('SHOW TABLES');
        $queryOutput = 'Tables_in_' . getenv('DB_DATABASE');

        foreach($tables as $table) {
            if ($table->$queryOutput !== 'migrations') {
                DB::table($table->$queryOutput)->truncate();
            }
        }

        // Find and run all seeders
        $classes = require base_path().'/vendor/composer/autoload_classmap.php';

        foreach ($classes as $class) {
            if (strpos($class, 'TableSeeder') !== false) {
                $seederClass = substr(last(explode('/', $class)), 0, -4);
                $this->call($seederClass);
            }
        }
    }
}
