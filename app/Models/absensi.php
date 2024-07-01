<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class absensi extends Model
{
    protected $primaryKey = 'id_absensi';
    public function pekerja()
    {
        return $this->belongsTo(Pekerja::class, 'id_pekerja'); // Sesuaikan nama foreign key jika diperlukan
    }
}
