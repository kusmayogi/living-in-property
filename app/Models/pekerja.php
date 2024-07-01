<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pekerja extends Model
{
    protected $primaryKey = 'id_pekerja';

    public function proyek()
    {
        return $this->belongsTo(Proyek::class, 'id_proyek');
    }

    use HasFactory;

    protected $fillable = [
        'nama_pekerja', 'role', 'upah', 'id_proyek', 'jumlah_kasbon'
    ];

    protected $attributes = [
        'upah' => 0.00,
    ];

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'id_pekerja');
    }
}
