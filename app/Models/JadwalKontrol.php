<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKontrol extends Model
{
    use HasFactory;
    protected $table = 'jadwalkontrol';
    protected $primaryKey = 'id_jadwal';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'id_jadwal',
        'id_dokter',
        'id_pasien',
        'tgl_jadwal',
        'jam_jadwal',
        'status',
        'pesan',
        'antrian',
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'id_dokter');
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien');
    }
}
