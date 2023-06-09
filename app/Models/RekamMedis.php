<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    use HasFactory;
    protected $table = 'konsultasi';
    protected $fillable = [
        'id_dokter',
        'id_pasien',
        'id_jenis',
        'tgl_konsultasi',
        'odontogram',
        'anamnesis',
        'diagnosis',
        'perawatan',
    ];
    public function jenisKonsultasi()
    {
        return $this->belongsTo(JenisKonsultasi::class, 'id_jenis');
    }
    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'id_dokter');
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien');
    }
}
