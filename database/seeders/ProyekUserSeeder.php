<?php

namespace Database\Seeders;

use App\Models\Proyek;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProyekUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $pengawas = User::whereHas('role', function ($q) {
            $q->where('name', 'pengawas');
        })->first();

        $proyek = Proyek::first();

        if ($pengawas && $proyek) {
            $pengawas->proyeks()->attach($proyek->id_proyek);
        }
    }
}
