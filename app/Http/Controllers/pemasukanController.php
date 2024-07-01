<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\pemasukan;
use App\Models\Proyek;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class pemasukanController extends Controller
{
    public function pemasukan()
    {
        $pemasukans = pemasukan::all();
        return view('keuangan/pemasukan', compact('pemasukans'));
    }
    public function create()
    {
        return view('keuangan/create_pemasukan');
    }

public function store(Request $request)
{
    // Validasi data yang dikirimkan oleh formulir
    $request->validate([
        'nama_pembeli' => 'required',
        'nominal' => 'required|numeric',
        'tanggal_pembayaran' => 'required',
        'keterangan' => 'nullable',
        'lokasi' => 'nullable',
        'tujuan_transfer' => 'nullable',
        'metode_pembayaran' => 'nullable',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Sesuaikan dengan kebutuhan
    ]);

    // Proses penyimpanan data pemasukan
    $pemasukan = new Pemasukan();
    $pemasukan->nama_pembeli = $request->nama_pembeli;
    $pemasukan->nominal = $request->nominal;
    $pemasukan->tanggal_pembayaran = $request->tanggal_pembayaran;
    $pemasukan->keterangan = $request->keterangan;
    $pemasukan->lokasi = $request->lokasi;
    $pemasukan->tujuan_transfer = $request->tujuan_transfer;
    $pemasukan->metode_pembayaran = $request->metode_pembayaran;

    // Proses penyimpanan foto jika diunggah
    if ($request->hasFile('foto')) {
        $fotoPath = $request->file('foto')->store('public/foto_pemasukan');
        $pemasukan->foto = basename($fotoPath);
    }

    $pemasukan->save();

    // Redirect atau kirim respons sesuai kebutuhan
    return redirect()->route('keuangan/pemasukan')->with('success', 'Data pemasukan berhasil disimpan');
}
public function edit($id_pemasukan)
    {
        $pemasukan = Pemasukan::find($id_pemasukan);

        return view('keuangan.edit_pemasukan', compact('pemasukan'));
    }

public function update(Request $request, $id_pemasukan)
{
    $request->validate([
        'nama_pembeli' => 'required|string|max:255',
        'nominal' => 'required|numeric',
        'keterangan' => 'nullable|string',
        'metode_pembayaran' => 'required|string',
        'tanggal_pembayaran' => 'required|date',
        'tujuan_transfer' => 'nullable|string',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'lokasi' => 'nullable|string',
        // Add validation for other fields as needed
    ]);

    $pemasukan = Pemasukan::find($id_pemasukan);

    if (!$pemasukan) {
        return redirect()->route('pemasukan.index')->with('error', 'Data Pemasukan tidak ditemukan');
    }

    // Update data pemasukan based on form input
    $pemasukan->nama_pembeli = $request->nama_pembeli;
    $pemasukan->nominal = $request->nominal;
    $pemasukan->keterangan = $request->keterangan;
    $pemasukan->metode_pembayaran = $request->metode_pembayaran;
    $pemasukan->tanggal_pembayaran = $request->tanggal_pembayaran;
    $pemasukan->tujuan_transfer = $request->tujuan_transfer;
    // Add update for other fields as needed

    // Upload and update foto if provided
    if ($request->hasFile('foto')) {
        $fotoPath = $request->file('foto')->store('pemasukan_fotos', 'public');
        $pemasukan->foto = $fotoPath;
    }

    $pemasukan->lokasi = $request->lokasi;

    // Save changes to the database
    $pemasukan->save();

    return redirect()->route('keuangan.pemasukan')->with('success', 'Data Pemasukan berhasil diubah');
}
}
