<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKonsultasi extends Model
{
    use HasFactory;
    protected $table = 'jeniskonsultasi';

    public function konsultasi()
    {
        return $this->hasMany(RekamMedis::class);
    }
}
