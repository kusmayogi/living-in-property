<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pengeluaran;
use App\Models\Proyek;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengeluaranController extends Controller
{
    public function pengeluaran()
    {
        $pengeluarans = Pengeluaran::all();
        return view('keuangan/pengeluaran', compact('pengeluarans'));
    }

    public function create()
    {
        $allProyeks = Proyek::all();
        return view('keuangan/create_pengeluaran', compact('allProyeks'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'judul_pengeluaran' => 'required',
            'satuan' => 'required',
            'harga_satuan' => 'required|numeric',
            'total_pengeluaran' => 'required',
            'id_proyek' => 'required|exists:proyeks,id_proyek',
            'sumber_dana' => 'required',
            'keterangan' => 'required',
            'vendor' => 'required',
            'foto' => 'file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Menambahkan user_id ke dalam validatedData
        $validatedData['id'] = auth()->id();

        // Handle file upload if a file is provided
        if ($request->hasFile('foto')) {
            $uploadedFile = $request->file('foto');
            $extension = $uploadedFile->getClientOriginalExtension();
            $fileName = uniqid() . '_' . time() . '.' . $extension;
            $uploadedFile->storeAs('public/foto_pengeluaran', $fileName);
            $validatedData['foto'] = $fileName; // menyimpan nama file di database
        }

        // Create a new expense record
        Pengeluaran::create($validatedData);

        return redirect()->route('keuangan.pengeluaran')->with('success', 'Data pengeluaran berhasil disimpan.');
    }
    public function detail($id_pengeluaran)
    {
        $pengeluarans = Pengeluaran::findOrFail($id_pengeluaran);

        return view('keuangan.edit_pengeluaran', compact('pengeluarans'));
    }

    public function update(Request $request, $id_pengeluaran)
    {
        $pengeluaran = Pengeluaran::find($id_pengeluaran);

        if (!$pengeluaran) {
            return redirect()->route('home')->with('error', 'Pengeluaran tidak ditemukan.');
        }

        // Validasi data
        $validatedData = $request->validate([
            'judul_pengeluaran' => 'required|string|max:255',
            'sumber_dana' => 'required|string|max:255',
            'satuan' => 'required|string|max:255',
            'harga_satuan' => 'required|numeric',
            'total_pengeluaran' => 'required|numeric',
            'keterangan' => 'nullable|string',
            'vendor' => 'nullable|string|max:255',
            'id_proyek' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update data pengeluaran
        $pengeluaran->judul_pengeluaran = $validatedData['judul_pengeluaran'];
        $pengeluaran->sumber_dana = $validatedData['sumber_dana'];
        $pengeluaran->satuan = $validatedData['satuan'];
        $pengeluaran->harga_satuan = $validatedData['harga_satuan'];
        $pengeluaran->total_pengeluaran = $validatedData['total_pengeluaran'];
        $pengeluaran->keterangan = $validatedData['keterangan'];
        $pengeluaran->vendor = $validatedData['vendor'];
        $pengeluaran->id_proyek = $validatedData['id_proyek'];

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto_pengeluaran', 'public');
            $pengeluaran->foto = $fotoPath;
        }

        $pengeluaran->save();

        return redirect()->route('keuangan.pengeluaran')->with('success', 'Pengeluaran berhasil diperbarui.');
    }
}
