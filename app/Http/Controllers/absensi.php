<?php

// app/Http/Controllers/AbsensiController.php

namespace App\Http\Controllers;

use App\Models\Absensi; // Make sure to import the Absensi model
use App\Models\Pekerja; // Make sure to import the Pekerja model
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index()
    {
        $absensiData = Absensi::all();
        return view('absensi.index', compact('absensiData'));
    }

    // Assuming that this is the Absensi model, so you should define the fillable property here
    protected $fillable = ['id_proyek', 'id_pekerja', 'status_absensi'];

    public function pekerja()
    {
        return $this->belongsTo(Pekerja::class, 'id_pekerja');
    }
}
