<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class pekerja extends Model
{
    protected $table = 'pekerjas';
    protected $primaryKey = "id_pekerja";
    protected $fillable = [
        'id_pekerja', 'kasbons_id', 'jabatan', 'jumlah_kasbon'];
    public function kasbon()
    {
        return $this->belongsTo(kasbon::class);
    }  
}