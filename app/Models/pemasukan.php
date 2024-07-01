<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pemasukan extends Model
{
    use HasFactory;
    protected $fillable = ['id_pemasukan','nama_pembeli', 'nominal', 'keterangan', 'metode_pembayaran', 'foto', 'lokasi', 'tanggal',  'tujuan'];
}
 