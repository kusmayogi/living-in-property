<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\absensi;
use Illuminate\Http\Request;

class reportController extends Controller
{
    public function store(Request $request)
    {
        $nama_pekerja = $request->input('nama_pekerja');
        $jumlah_kasbon = $request->input('jumlah_kasbon');
        $total_kehadiran = $request->input('total_kehadiran');
        $gaji = $request->input('gaji');
        $potongan = $request->input('potongan');

        foreach ($nama_pekerja as $index => $nama) {
            $totalGaji = ($gaji[$index]) - ($potongan[$index] ?? 0);

            absensi::create([
                'nama_pekerja' => $nama,
                'jumlah_kasbon' => $jumlah_kasbon[$index] ?? 0,
                'total_kehadiran' => $total_kehadiran[$index],
                'gaji' => $gaji[$index],
                'potongan' => $potongan[$index] ?? 0,
                'total_gaji' => $totalGaji,
            ]);
        }

        return redirect()->route('your.redirect.route')->with('success', 'Data berhasil disimpan.');
    }
}
