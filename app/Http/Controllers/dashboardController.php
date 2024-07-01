<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pekerja;
use App\Models\DataProyek; // Import model DataProyek
use App\Models\Proyek;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil jumlah pekerja dari database
        $jumlahPekerja = Pekerja::count();
        
        // Mengambil jumlah proyek dengan status "on progress" dari database
        $jumlahProyekOnProgress = Proyek::where('status', 'Progress')->count();

        // Mengirimkan jumlah pekerja dan jumlah proyek ke tampilan dashboard
        return view('dashboard', [
            'jumlahPekerja' => $jumlahPekerja,
            'jumlahProyekOnProgress' => $jumlahProyekOnProgress
        ]);
    }
}
