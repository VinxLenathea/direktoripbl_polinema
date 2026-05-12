<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasAkhir extends Model
{
    protected $table = 'tugas_akhir';

    public function mahasiswa()
    {
        return $this->belongsToMany(Mahasiswa::class);
    }

    public function category()
    {
        return $this->belongsTo(Pembimbing ::class);
    }

    public function pembimbing()
    {
        return $this->hasMany(Pembimbing ::class);
    }
}
