<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IzinAbsensi extends Model
{
    use HasFactory;
    protected $table = 'izinabsensi';
    protected $fillable = [
        'tgl_izin',
        'id_dokter',
        'alasan', 
    ];
    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }
    
}
