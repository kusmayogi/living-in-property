<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class kasbon extends Model
{
    protected $table = 'kasbons';
    protected $primaryKey = "id";
    protected $fillable = [
        'id_pekerja', 'kasbons_id', 'jabatan', 'jumlah_kasbon'];
    public function pekerja()
    {
        return $this->hasMany(pekerja::class);
    }  
}