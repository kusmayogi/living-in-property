<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;
    protected $table = 'pengeluarans';

    // Menentukan primary key
    protected $primaryKey = 'id_pengeluaran';
    protected $fillable = ['judul_pengeluaran', 'satuan', 'harga_satuan', 'total_pengeluaran', 'id_proyek', 'sumber_dana', 'keterangan', 'vendor', 'foto', 'user_id'];

    protected $dispatchesEvents = [
        'creating' => \App\Events\PengeluaranCreating::class,
    ];

    // public function users()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }
}
