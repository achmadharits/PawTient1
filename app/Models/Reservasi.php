<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;
    protected $table = 'reservasi';
    // protected $primaryKey = 'id_reservasi';
    // protected $keyType = 'string';
    // public $incrementing = false;
    protected $fillable = [
        // 'id_reservasi',
        'id_dokter',
        'id_pasien',
        'tgl_reservasi',
        'jam_reservasi',
        'jenis_hewan',
        'status',
        'deskripsi'
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
