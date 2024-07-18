<?php

namespace App\Console\Commands;

use App\Models\Pekerja;
use Illuminate\Console\Command;

class ReduceKasbon extends Command
{protected $signature = 'kasbon:reduce';
    protected $description = 'Kurangi jumlah kasbon pekerja setiap minggu';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $pekerjas = Pekerja::all();

        foreach ($pekerjas as $pekerja) {
            if ($pekerja->jumlah_kasbon > 500000) {
                $pekerja->jumlah_kasbon -= 100000;
            } else {
                $pekerja->jumlah_kasbon -= 50000;
            }

            $pekerja->save();
        }

        $this->info('Jumlah kasbon pekerja telah dikurangi.');
    }
}
