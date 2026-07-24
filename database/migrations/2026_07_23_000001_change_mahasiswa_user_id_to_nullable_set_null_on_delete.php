<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE `mahasiswa` DROP FOREIGN KEY `mahasiswa_user_id_foreign`');
        DB::statement('ALTER TABLE `mahasiswa` MODIFY `user_id` BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE `mahasiswa` ADD CONSTRAINT `mahasiswa_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE `mahasiswa` DROP FOREIGN KEY `mahasiswa_user_id_foreign`');
        DB::statement('ALTER TABLE `mahasiswa` MODIFY `user_id` BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE `mahasiswa` ADD CONSTRAINT `mahasiswa_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE');
    }
};
