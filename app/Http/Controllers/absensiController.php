<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\proyek;
use Illuminate\Support\Facades\Log;
use App\Models\absensi;
use App\Models\pekerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class AbsensiController extends Controller
{
    public function showKepalaTukangAndProyekLocation()
    {
        $pekerjaKepalaTukang = pekerja::where('role', 'kepala tukang')->get();

        $result = [];

        foreach ($pekerjaKepalaTukang as $pekerja) {
            $lokasiProyek = DB::table('proyeks')
                ->where('id_proyek', $pekerja->id_proyek)
                ->value('lokasi_proyek');

            $result[] = [
                'nama_pekerja' => $pekerja->nama_pekerja,
                'lokasi_proyek' => $lokasiProyek,
                'id_proyek' => $pekerja->id_proyek,
            ];
        }

        return view('Absensi.index', compact('result'));
    }

    public function showForm($id_proyek)
    {
        // Mengambil data pekerja berdasarkan id_proyek
        $pekerja = pekerja::where('id_proyek', $id_proyek)->get();
        $lokasi_proyek = proyek::find($id_proyek)->lokasi_proyek;

        return view('Absensi.insert', compact('pekerja', 'id_proyek', 'lokasi_proyek'));
    }


    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'id_proyek' => 'required',
            'id_pekerja' => 'required|array',
            'status_absensi' => 'required|array',
            // Other validation rules...
        ]);

        // Mendapatkan pengguna yang sedang login
        $user = Auth::user();
        $idProyekAbsensi = $request->input('id_proyek');

        // Mendapatkan id pekerja yang diabsensi
        $idPekerjaAbsensi = $request->input('id_pekerja');

        // Memeriksa apakah pengguna telah melakukan absensi pada hari yang sama dengan id_pekerja yang sama
        $latestAbsensi = Absensi::where('id_pekerja', $idPekerjaAbsensi)
            ->whereDate('created_at', Carbon::today())
            ->exists();

        if ($latestAbsensi) {
            return redirect()->back()->with('error', 'Anda sudah melakukan absensi hari ini untuk pekerja ini.');
        }

        // Iterate over the submitted data
        foreach ($idPekerjaAbsensi as $index => $idPekerja) {
            // Create a new Absensi instance for each entry
            $absensi = new Absensi();
            $absensi->id_proyek = $request->input('id_proyek');
            $absensi->id_pekerja = $idPekerja;
            $absensi->status_absensi = $request->input('status_absensi')[$index];
            $absensi->save();
        }
        return redirect()->back()->with('success', 'Absensi created successfully');
    }
    public function edit($id_proyek)
    {
        // Temukan data absensi berdasarkan id_proyek
        $absensis = Absensi::where('id_proyek', $id_proyek)->get();

        if ($absensis->isEmpty()) {
            // Jika data tidak ditemukan, mungkin hendak menangani kasus ini
            abort(404, 'Data absensi tidak ditemukan');
        }

        // Temukan lokasi proyek berdasarkan $id_proyek atau sesuai kebutuhan aplikasi Anda
        $lokasi_proyek = Proyek::find($id_proyek)->lokasi_proyek;

        // Mendapatkan daftar tanggal dari data absensi
        $daftarTanggal = Absensi::where('id_proyek', $id_proyek)
            ->pluck(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
            ->unique();

        // Kirim data absensi, lokasi proyek, dan daftar tanggal ke view untuk ditampilkan dalam form edit
        return view('absensi.edit', compact('absensis', 'lokasi_proyek', 'daftarTanggal', 'id_proyek'));
    }
    public function showFormWithDateDropdown($id_proyek = null)
    {
        // Get the project ID associated with the authenticated user
        $user = Auth::user();
        if ($user) {
            $id_proyek = $user->project_id;
        }

        // Mendapatkan daftar tanggal dari data absensi
        $daftarTanggal = Absensi::where('id_proyek', $id_proyek)
            ->pluck(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
            ->unique();

        return view('absensi.form_pencarian', compact('daftarTanggal', 'id_proyek'));
    }

    public function search(Request $request)
    {
        // Ambil data pencarian dari request
        $id_proyek = $request->input('id_proyek');
        $tanggal = $request->input('tanggal');

        // Temukan data absensi berdasarkan id_proyek dan tanggal
        $absensis = Absensi::where('id_proyek', $id_proyek)
            ->whereDate('created_at', $tanggal)
            ->get();

        // Mendapatkan tanggal dalam format yang sesuai
        $formattedDate = \Carbon\Carbon::parse($tanggal)->format('d/m/Y');

        // Kembalikan tampilan parsial yang berisi tabel dengan data hasil pencarian
        return view('partials.search_result', compact('absensis', 'formattedDate'));
    }
    public function ubahStatusAbsensi(Request $request, $id_absensi)
    {
        // Temukan absensi berdasarkan ID
        $absensi = Absensi::findOrFail($id_absensi);

        // Validasi data yang diterima dari form
        $request->validate([
            'new_status' => 'required|in:masuk,setengah hari,tidak masuk'
        ]);

        // Perbarui status absensi dengan status baru
        $absensi->status_absensi = $request->input('new_status');
        $absensi->save();

        // Redirect ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Status absensi berhasil diperbarui.');
    }
    public function reduceKasbon(Request $request, $id_proyek)
    {
        // Validasi input jika diperlukan
        $request->validate([
            'potongan' => 'array', // Sesuaikan dengan kebutuhan validasi
        ]);

        foreach ($request->potongan as $id_pekerja => $potongan) {
            // Lakukan operasi sesuai kebutuhan, misalnya update ke database
            $pekerja = pekerja::find($id_pekerja);

            // Pastikan pekerja ditemukan sebelum melakukan operasi
            if ($pekerja) {
                $pekerja->jumlah_kasbon -= $potongan;
                // Lakukan operasi lainnya sesuai kebutuhan

                // Simpan perubahan
                $pekerja->save();
            }
        }

        // Redirect atau tampilkan response sesuai kebutuhan
        return redirect()->route('report.post', ['id_proyek' => $id_proyek])->with('success', 'Kasbon berhasil dikurangi');
    }
}