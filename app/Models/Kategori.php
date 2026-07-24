<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $fillable = ['nama_kategori', 'slug'];

    protected static function booted(): void
    {
        static::saving(function (Kategori $kategori) {
            if ($kategori->isDirty('nama_kategori') || ! $kategori->slug) {
                $base = Str::slug($kategori->nama_kategori) ?: 'kategori';
                $slug = $base;
                $suffix = 2;
                while (static::where('slug', $slug)->whereKeyNot($kategori->getKey())->exists()) {
                    $slug = $base . '-' . $suffix++;
                }
                $kategori->slug = $slug;
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function tugasAkhirs()
    {
        return $this->hasMany(TugasAkhir::class);
    }
}
