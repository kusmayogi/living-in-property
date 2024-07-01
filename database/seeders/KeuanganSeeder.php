<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Pekerja;
use App\Models\Kasbon;

class KeuanganSeeder extends Seeder
{
    public function run()
    {
        // Your trigger creation SQL here
        DB::unprepared('CREATE TRIGGER kurangi_kasbon AFTER INSERT ON kasbon FOR EACH ROW BEGIN ... END;');
    }
}
