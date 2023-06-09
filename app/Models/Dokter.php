<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Dokter extends Authenticatable
{
    use HasFactory;
    protected $table = 'dokter';
    protected $guard = 'dokter';
    protected $primaryKey = 'id_dokter';
    protected $keyType = 'string';

    protected $fillable = [
        'id_dokter',
        'nama',
        'email',
        'password',
        'no_str',
        'no_hp',
        'alamat',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    public function jadwalKontrol()
    {
        return $this->hasMany(JadwalKontrol::class);
    }
    public function reservasi()
    {
        return $this->hasMany(Reservasi::class);
    }
    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class);
    }
    public function izinAbsensi()
    {
        return $this->hasMany(IzinAbsensi::class);
    }
    public function jadwalPraktik()
    {
        return $this->hasMany(JadwalPraktik::class, 'id_dokter', 'id_dokter');
    }
}
