<?php

// app/Models/Proyek.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Proyek extends Model
{
    protected $fillable = [
        'nama_pemilik',
        'lokasi_proyek',
        'tanggal_dimulai',
        'tanggal_selesai',
        'status',
        'keterangan',
        'nilai_proyek',
    ];

// app/Models/Proyek.php
public function subProyeks()
{
    return $this->hasMany(Proyek::class, 'id_proyek');
}
protected $primaryKey = 'id_proyek';

    public function proyeks()
    {
        return $this->hasMany(Proyek::class, 'id_proyek');
    }
    protected $table = 'proyeks';

    // Define any relationships with other models
    public function pekerja()
    {
        return $this->hasMany(Pekerja::class, 'id_proyek');
    }
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_proyek', 'id_proyek', 'id');
    }


}
