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
        Schema::create('riwayat_keluar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('id_jenisKendaraan')->nullable()->constrained('jenis_kendaraan')->onDelete('set null');
            $table->string('kode_unik', 20)->nullable();
            $table->string('nama_kendaraan', 50)->nullable();
            $table->dateTime('waktu_masuk')->nullable();
            $table->timestamp('waktu_keluar')->useCurrent();
            $table->integer('durasi_hari')->nullable();
            $table->integer('biaya')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_keluar');
    }
};
