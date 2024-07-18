<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pekerja;
use App\Models\Proyek;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
class PekerjaController extends Controller
{
    public function index()
    {
        $pekerjas = Pekerja::with('proyek')->get();
        $pekerjas = Pekerja::all();
        $jumlahPekerja = Pekerja::count();
        foreach ($pekerjas as $pekerja) {
        }
        return view('Data_pekerja.index', compact('pekerjas'));
    }
    public function showKepalaTukangAndProyekLocation()
    {
        $pekerjaKepalaTukang = Pekerja::where('role', 'kepala tukang')->get();

        $result = [];

        foreach ($pekerjaKepalaTukang as $pekerja) {
            $lokasiProyek = DB::table('proyeks')
                ->where('id_proyek', $pekerja->id_proyek)
                ->value('lokasi_proyek');

            $result[] = [
                'nama_pekerja' => $pekerja->nama_pekerja,
                'lokasi_proyek' => $lokasiProyek,
                'id_pekerja' => $pekerja->id,  //uming you have an 'id' field in the Pekerja model
            ];
        }

        return view('absensi.index', compact('result'));
    }
    public function insert($id_proyek)
    {
        // Find the Proyek based on id_proyek
        $proyek = Proyek::find($id_proyek);

        if (!$proyek) {
            // Handle the case where no matching proyek is found
            return redirect()->route('Absensi.index')->with('error', 'No proyek found for the given id_proyek');
        }

        // Retrieve the list of pekerja associated with the Proyek
        $pekerjaList = $proyek->pekerja;

        // Continue with your logic...

        return redirect()->route('Absensi.index')->with('success', 'Absensi berhasil dicatat.');
    }

    public function gaji()
    {
        $pekerjaKepalaTukang = Pekerja::where('role', 'kepala tukang')->get();

        $result = [];

        foreach ($pekerjaKepalaTukang as $pekerja) {
            $lokasiProyek = DB::table('proyeks')
                ->where('id_proyek', $pekerja->id_proyek)
                ->value('lokasi_proyek');

            $result[] = [
                'nama_pekerja' => $pekerja->nama_pekerja,
                'lokasi_proyek' => $lokasiProyek,
                'id_pekerja' => $pekerja->id, // Assuming you have an 'id' field in the Pekerja model
            ];
        }

        return view('gaji.index', compact('result'));
    }
    public function create()
    {
        $allProyeks = Proyek::all();
        return view('Data_pekerja.create', compact('allProyeks'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'nama_pekerja' => 'required',
            'upah' => 'required',
            'alamat' => 'required',
            'role' => 'required|string|in:Kepala Tukang,Tukang,Kuli',
            'id_proyek' => 'required|exists:proyeks,id_proyek',
        ]);

        // Create a new employee with the selected project
        Pekerja::create($validatedData);

        return redirect()->route('Data_pekerja.index')->with('success', 'Employee added successfully.');
    }

    public function show($id_pekerja)
{
    // Pastikan $id_pekerja diinisialisasi dengan nilai yang valid
    
}

public function edit($id_pekerja)
{
    $pekerja = Pekerja::findOrFail($id_pekerja);
    $allProyeks = Proyek::all(); // Ambil seluruh proyek

    return view('Data_pekerja.edit', compact('pekerja', 'allProyeks'));
}


public function update(Request $request, Pekerja $pekerja)
    {
        $request->validate([
            'nama_pekerja' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'upah' => 'required|numeric',
            'alamat' => 'required|string|max:255',
            'jumlah_kasbon' => 'required|numeric',
            'id_proyek' => 'required|exists:proyeks,id_proyek',
        ]);

        $pekerja->update($request->all());

        return redirect()->route('Data_pekerja.index')
            ->with('success', 'Data Pekerja berhasil diperbarui.');
    }


    public function destroy($id_pekerja)
    {
        $dataPekerja = Pekerja::findOrFail($id_pekerja);
        $dataPekerja->delete();

        return redirect()->route('Data_pekerja.index')->with('success', 'Data Pekerja berhasil dihapus.');
    }
    public function kurangiKasbon(Request $request)
    {
        $idPekerja = $request->input('id_pekerja');
        $jumlahPotong = $request->input('jumlah_potong');

        $pekerja = Pekerja::find($idPekerja);

        // Lakukan validasi dan pengurangan kasbon
        if ($pekerja) {
            $pekerja->jumlah_kasbon -= $jumlahPotong;
            $pekerja->save();
        }

        return redirect()->back()->with('success', 'Kasbon berhasil dikurangi.');
    }
}
