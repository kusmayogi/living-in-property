<?php

namespace App\Http\Controllers;

use App\Models\proyek;
use App\Http\Controllers\Controller;
use App\Models\pekerja;
use App\Models\User;
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
        $statusOptions = ['Dimulai', 'Progress', 'Selesai'];
        $users = User::all(); 
        return view('proyek.create', compact('statusOptions', 'users'));
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
            'id' => 'required|exists:users,id' // Validasi user_id
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
        $proyeks = Proyek::findOrFail($id_proyek);
        $statusOptions = ['Dimulai', 'Progress', 'Selesai'];
        $users = User::all(); // Ambil semua data users untuk dropdown
        return view('proyek.edit', compact('proyeks', 'statusOptions', 'users'));
    }

    public function update(Request $request, $id_proyek)
    {
        $proyek = Proyek::findOrFail($id_proyek);

        $validatedData = $request->validate([
            'nama_pemilik' => 'required',
            'lokasi_proyek' => 'required',
            'tanggal_dimulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date',
            'status' => 'required|in:Dimulai,Progress,Selesai',
            'keterangan' => 'required',
            'nilai_proyek' => 'required',
            'id' => 'required|exists:users,id', // Validasi user_id
        ]);

        $proyek->update($validatedData);

        return redirect()->route('proyek.index')->with('success', 'Proyek berhasil diperbarui.');
    }
}
