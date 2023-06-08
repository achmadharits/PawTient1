<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPraktik extends Model
{
    use HasFactory;
    protected $table = 'jadwalpraktik';
    protected $fillable = [
        'id_dokter',
        'hari',
        'jam_kerja',
    ];
    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }
}
