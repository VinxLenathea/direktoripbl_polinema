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
            $table->string('pending_file')->nullable()->after('file_laporan');
            $table->boolean('is_approved')->default(false)->after('pending_file');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tugas_akhir', function (Blueprint $table) {
            $table->dropColumn(['pending_file', 'is_approved']);
        });
    }
};
