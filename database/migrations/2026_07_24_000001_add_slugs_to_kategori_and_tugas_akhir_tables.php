<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kategori', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('nama_kategori');
        });

        Schema::table('tugas_akhir', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('judul');
        });

        $usedCategorySlugs = [];
        foreach (DB::table('kategori')->orderBy('id')->get() as $category) {
            $base = Str::slug($category->nama_kategori) ?: 'kategori';
            $slug = $base;
            $suffix = 2;
            while (in_array($slug, $usedCategorySlugs, true)) {
                $slug = $base . '-' . $suffix++;
            }
            $usedCategorySlugs[] = $slug;
            DB::table('kategori')->where('id', $category->id)->update(['slug' => $slug]);
        }

        $usedProjectSlugs = [];
        foreach (DB::table('tugas_akhir')->orderBy('id')->get() as $project) {
            $base = Str::slug($project->judul) ?: 'tugas-akhir';
            $slug = $base;
            $suffix = 2;
            while (in_array($slug, $usedProjectSlugs, true)) {
                $slug = $base . '-' . $suffix++;
            }
            $usedProjectSlugs[] = $slug;
            DB::table('tugas_akhir')->where('id', $project->id)->update(['slug' => $slug]);
        }

        Schema::table('kategori', function (Blueprint $table) {
            $table->unique('slug');
        });

        Schema::table('tugas_akhir', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    public function down(): void
    {
        Schema::table('kategori', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });

        Schema::table('tugas_akhir', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};
