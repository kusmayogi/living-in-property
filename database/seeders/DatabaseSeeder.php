<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use KeuanganSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    
    public function run()
    {
        $this->call([
            // other seeders
            KeuanganSeeder::class,
        ]);
    }
}
