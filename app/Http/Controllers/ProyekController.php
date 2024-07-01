<?php

namespace App\Http\Controllers;
use App\Models\proyek;
use App\Http\Controllers\Controller;
use App\Models\pekerja;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\Paginator;
class ProyekController extends Controller
{
    public function index()
{
    $proyeks = Proyek::all();
    return view('Proyek/index', compact('proyeks'));
}
public function create()
    {
        // Ambil semua proyek untuk dropdown
        $statusOptions = ['Dimulai', 'Progress', 'Selesai'];
    return view('proyek.create', compact('statusOptions'));
    }
 
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_pemilik' => 'required',
            'lokasi_proyek' => 'required',
            'tanggal_dimulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date',
            'status' => 'required|in:Dimulai,Progress,Selesai',
            'keterangan' => 'required',
            'nilai_proyek' => 'required',
        ]);

        Proyek::create($validatedData);

        return redirect()->route('proyek.index'); // Assuming 'index' is the name of your index route
    }
    
    public function destroy($id_proyek)
    {
        $proyeks = Proyek::findOrFail($id_proyek);
        $proyeks->delete();

        return redirect()->route('proyek.index')->with('success', 'Proyek deleted successfully.');
    }
    public function edit($id_proyek)
{
    // Fetch the Proyek record by ID
    $proyeks = Proyek::findOrFail($id_proyek);

    // Return the view with the Proyek data
    return view('proyek.edit', compact('proyeks'));
}
public function update(Request $request, $id_proyek)
{
    // Validate the request
    $proyek = Proyek::findOrFail($id_proyek); // Gantilah dengan model dan kunci primer yang sesuai
    $proyek->nama_pemilik = $request->input('nama_pemilik');
    $proyek->lokasi_proyek = $request->input('lokasi_proyek');
    $proyek->tanggal_dimulai = $request->input('tanggal_dimulai');
    $proyek->tanggal_selesai = $request->input('tanggal_selesai');
    $proyek->status = $request->input('status');
    $proyek->nilai_proyek = $request->input('nilai_proyek');
    $proyek->keterangan = $request->input('keterangan');

    // Simpan perubahan ke dalam database
    $proyek->save();

    // Redirect atau berikan respons sesuai kebutuhan aplikasi Anda
    return redirect()->route('proyek.index')->with('success', 'Proyek berhasil diperbarui.');
}
}
