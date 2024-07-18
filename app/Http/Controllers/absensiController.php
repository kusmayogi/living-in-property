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
        $user_id = Auth::id();
        $pekerjaKepalaTukang = Pekerja::where('role', 'kepala tukang')->get();
        $proyeks = Proyek::where('id', $user_id)->get();
        $result = [];

        foreach ($proyeks as $proyek) {
            $pekerjaKepalaTukang = pekerja::where('id_proyek', $proyek->id_proyek)
                ->where('role', 'kepala tukang')
                ->get();

            foreach ($pekerjaKepalaTukang as $pekerja) {
                $result[] = (object) [
                    'nama_pekerja' => $pekerja->nama_pekerja,
                    'lokasi_proyek' => $proyek->lokasi_proyek,
                    'id_proyek' => $proyek->id_proyek,
                    'user_id' => $proyek->id, // Tambahkan user_id untuk pengecekan di view
                ];
            }
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
    public function showWeeklyAttendance()
    {
        $weekNumber = date('W'); // Minggu ke berapa dalam tahun ini
        $year = date('Y');

        $pekerjas = Pekerja::all(); // Ambil semua pekerja
        $rekapAbsensi = [];

        foreach ($pekerjas as $pekerja) {
            $attendance = [
                'nama_pekerja' => $pekerja->nama_pekerja,
                'senin' => $this->getAttendanceStatus($pekerja->id, $year, $weekNumber, 1),
                'selasa' => $this->getAttendanceStatus($pekerja->id, $year, $weekNumber, 2),
                'rabu' => $this->getAttendanceStatus($pekerja->id, $year, $weekNumber, 3),
                'kamis' => $this->getAttendanceStatus($pekerja->id, $year, $weekNumber, 4),
                'jumat' => $this->getAttendanceStatus($pekerja->id, $year, $weekNumber, 5),
                'sabtu' => $this->getAttendanceStatus($pekerja->id, $year, $weekNumber, 6),
                'total_poin' => $this->getTotalPoints($pekerja->id, $year, $weekNumber)
            ];

            $rekapAbsensi[] = $attendance;
        }

        // Logging untuk debug
        Log::info('Rekap Absensi:', ['rekapAbsensi' => $rekapAbsensi, 'weekNumber' => $weekNumber, 'year' => $year]);

        return view('absensi.rekap_absensi_mingguan', compact('rekapAbsensi', 'weekNumber', 'year'));
    }

    private function getTotalPoints($pekerjaId, $year, $weekNumber)
    {
        $totalPoints = 0;
        for ($dayOfWeek = 0; $dayOfWeek <= 6; $dayOfWeek++) {
            $totalPoints += $this->getAttendanceStatus($pekerjaId, $year, $weekNumber, $dayOfWeek);
        }
        return $totalPoints;
    }

    private function getAttendanceStatus($pekerjaId, $year, $weekNumber, $dayOfWeek)
    {
        $absensi = Absensi::where('id_pekerja', $pekerjaId)
            ->whereYear('created_at', $year)
            ->where(DB::raw('WEEK(created_at)'), $weekNumber)
            ->get()
            ->filter(function ($record) use ($dayOfWeek) {
                return \Carbon\Carbon::parse($record->created_at)->dayOfWeek == $dayOfWeek;
            })
            ->first();

        // Logging untuk debug
        Log::info('Absensi:', ['pekerja_id' => $pekerjaId, 'year' => $year, 'weekNumber' => $weekNumber, 'dayOfWeek' => $dayOfWeek, 'absensi' => $absensi]);

        if ($absensi) {
            switch ($absensi->status) {
                case 'masuk':
                    return 1;
                case 'setengah_hari':
                    return 0.5;
                case 'tidak_masuk':
                    return 0;
                default:
                    return 0;
            }
        }

        return 0;
    }
}