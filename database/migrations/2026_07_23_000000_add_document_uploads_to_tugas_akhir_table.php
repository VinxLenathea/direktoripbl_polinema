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
        Schema::table('tugas_akhir', function (Blueprint $table) {
            $table->string('surat_administrasi')->nullable()->after('pending_file');
            $table->string('score_toeic')->nullable()->after('surat_administrasi');
            $table->string('sertikom')->nullable()->after('score_toeic');
            $table->string('file_skkm')->nullable()->after('sertikom');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tugas_akhir', function (Blueprint $table) {
            $table->dropColumn(['surat_administrasi', 'score_toeic', 'sertikom', 'file_skkm']);
        });
    }
};
