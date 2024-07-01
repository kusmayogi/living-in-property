<?php

namespace App\Http\Controllers;

use App\Models\gaji;
use App\Models\LaporanGaji;
use App\Models\proyek;
use App\Models\pekerja;
use App\Models\absensi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GajiController extends Controller
{
    public function showForm()
    {
        $proyeks = proyek::all();
        return view('laporan.form', compact('proyeks'));
    }

    // Di dalam controller
// Di dalam controller
public function index($id_proyek)
{
    $pekerja = pekerja::where('id_proyek', $id_proyek)->get();

    $data = [];
    foreach ($pekerja as $pegawai) {
        $absensi = absensi::where('id_proyek', $id_proyek)
            ->where('id_pekerja', $pegawai->id_pekerja)
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->get();

        // Explicitly cast 'status_absensi' values to integers before summing
        $totalKehadiran = $absensi->sum(function ($item) {
            return (int)$item->status_absensi;
        });

        $data[$pegawai->id_pekerja]['kehadiran'] = $totalKehadiran;
        $data[$pegawai->id_pekerja]['upah'] = $pegawai->upah;
    }

    return view('Absensi.report', compact('id_proyek', 'pekerja', 'data'));
}

public function submitReport(Request $request, $id_proyek)
{
    // Validasi input jika diperlukan
    $request->validate([
        'potongan' => 'array', // Sesuaikan dengan kebutuhan validasi
    ]);

    // Periksa apakah array $request->id_pekerja tidak null
    if (!is_null($request->id_pekerja)) {
        foreach ($request->potongan as $index => $potongan) {
            // Periksa apakah indeks $index valid dalam array $request->id_pekerja
            if (array_key_exists($index, $request->id_pekerja)) {
                $laporan = new LaporanGaji();
                $laporan->id_proyek = $id_proyek;
                $laporan->id_pekerja = $request->id_pekerja[$index];
                $laporan->jumlah_kasbon = $request->jumlah_kasbon[$index] ?? 0; // Jika null, set ke 0
                $laporan->total_kehadiran = $request->total_kehadiran[$index] ?? 0;
                $laporan->gaji_total = $request->gaji_total[$index] ?? 0;
                $laporan->potongan = $potongan;
                $laporan->total_gaji = ($request->gaji_total[$index] ?? 0) - $potongan;

                // Simpan data ke dalam database
                $laporan->save();
            } else {
                // Handle case jika indeks tidak valid
                // Misalnya, log pesan kesalahan
                Log::error("Invalid index $index in array \$request->id_pekerja");
                
                // Berikan pesan kesalahan kepada pengguna jika perlu
                return redirect()->back()->with('error', 'Invalid data encountered. Please try again.');
            }
        }
    } else {
        // Handle case jika array $request->id_pekerja null
        Log::error('Array $request->id_pekerja is null');
        
        // Berikan pesan kesalahan kepada pengguna jika perlu
        return redirect()->back()->with('error', 'Invalid data encountered. Please try again.');
    }

    // Redirect atau tampilkan response sesuai kebutuhan
    return redirect()->route('report.post', ['id_proyek' => $id_proyek])->with('success', 'Data berhasil disubmit');
}
}