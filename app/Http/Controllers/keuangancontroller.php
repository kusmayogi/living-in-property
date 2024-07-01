<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\keuangan;
use App\Models\pemasukan;
use App\Models\Pengeluaran;
use App\Models\Proyek;
use Illuminate\Http\Request;

class keuangancontroller extends Controller
{
    public function index()
    {
        $pengeluaran = Pengeluaran::all();
        $pemasukan = Pemasukan::all();

        // Menghitung jumlah pengeluaran
        $totalPengeluaran = $pengeluaran->sum('amount');

        // Menghitung jumlah pemasukan
        $totalPemasukan = $pemasukan->sum('amount');

        return view('keuangan.index', compact('totalPengeluaran', 'totalPemasukan'));
    }
    public function pemasukan()
    {
        $keuangans = keuangan::all();
        return view('keuangan/pemasukan', compact('keuangans'));
    }
    public static function getTotalPengeluaran()
    {
        return Pengeluaran::sum('total_pengeluaran');
    }
    public static function getTotalPemasukan()
    {
        return pemasukan::sum('nominal');
    }
}
