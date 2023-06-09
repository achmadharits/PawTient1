<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Pasien extends Authenticatable
{
    use HasFactory;
    protected $table = 'pasien';
    protected $guard = 'pasien';
    protected $primaryKey = 'id_pasien';
    protected $keyType = 'string';

    protected $fillable = [
        'id_pasien',
        'nama',
        'email',
        'password',
        'no_hp',
        'alamat',
        'usia',
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
}
