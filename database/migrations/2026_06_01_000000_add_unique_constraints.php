<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Add unique constraints to NIM and NIP columns
     */
    public function up(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->unique('nim');
        });

        Schema::table('dosen', function (Blueprint $table) {
            $table->unique('nip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropUnique(['nim']);
        });

        Schema::table('dosen', function (Blueprint $table) {
            $table->dropUnique(['nip']);
        });
    }
};
