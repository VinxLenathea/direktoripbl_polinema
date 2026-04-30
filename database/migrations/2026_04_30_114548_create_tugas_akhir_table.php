<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tugas_akhir', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('abstrak');
            $table->year('tahun_lulus');
            $table->foreignId('category_id')->constrained('categories')->ondelete('cascade');
            $table->string('file_laporan');
            $table->string('link_repository')->nullable();
            $table->string('demo_video')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_akhir');
    }
};
