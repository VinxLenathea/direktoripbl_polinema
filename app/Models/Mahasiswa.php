<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';
    protected $fillable = ['user_id', 'name', 'nim', 'jurusan', 'prodi', 'angkatan'];
    protected $casts = ['angkatan' => 'integer'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tugasAkhir()
{
    return $this->belongsToMany(
        TugasAkhir::class,
        'tugas_akhir_mahasiswa',
        'mahasiswa_id',
        'tugas_akhir_id'
    );
}
}
