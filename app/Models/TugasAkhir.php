<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TugasAkhir extends Model
{
    protected $table = 'tugas_akhir';

    protected $fillable = [
        'judul',
        'slug',
        'abstrak',
        'tahun_lulus',
        'kategori_id',
        'file_laporan',
        'pending_file',
        'surat_administrasi',
        'score_toeic',
        'sertikom',
        'file_skkm',
        'is_approved',
        'status',
        'rejection_reason',
        'link_repository',
        'demo_video'
    ];

    protected $casts = [
        'tahun_lulus' => 'integer',
        'is_approved' => 'boolean'
    ];

    protected static function booted(): void
    {
        static::saving(function (TugasAkhir $tugasAkhir) {
            if ($tugasAkhir->isDirty('judul') || ! $tugasAkhir->slug) {
                $base = Str::slug($tugasAkhir->judul) ?: 'tugas-akhir';
                $slug = $base;
                $suffix = 2;
                while (static::where('slug', $slug)->whereKeyNot($tugasAkhir->getKey())->exists()) {
                    $slug = $base . '-' . $suffix++;
                }
                $tugasAkhir->slug = $slug;
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function mahasiswa()
    {
        return $this->belongsToMany(
            Mahasiswa::class,
            'tugas_akhir_mahasiswa',
            'tugas_akhir_id',
            'mahasiswa_id'
        );
    }

    public function category()
    {
        return $this->belongsTo(
            Kategori::class,
            'kategori_id'
        );
    }
}
