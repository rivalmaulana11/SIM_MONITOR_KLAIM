<?php
// File: database/migrations/xxxx_create_klaim_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('klaim', function (Blueprint $table) {
            $table->id();
            $table->string('no_sep')->unique(); // Nomor SEP
            $table->string('no_kartu'); // No Kartu BPJS
            $table->string('nama_pasien');
            $table->date('tgl_masuk');
            $table->date('tgl_keluar');
            $table->enum('jenis_rawat', ['Rawat Inap', 'Rawat Jalan']);
            $table->string('kelas_rawat')->nullable();
            $table->string('kode_diagnosa')->nullable();
            $table->text('diagnosa')->nullable();
            $table->string('kode_prosedur')->nullable();
            $table->text('prosedur')->nullable();
            $table->decimal('tarif_rs', 15, 2)->default(0); // Tarif Rumah Sakit
            $table->decimal('tarif_bpjs', 15, 2)->default(0); // Tarif yang disetujui BPJS
            $table->decimal('selisih', 15, 2)->default(0); // Selisih tarif
            $table->enum('status', ['pending', 'cair', 'tidak_layak'])->default('pending');
            $table->text('keterangan')->nullable();
            $table->string('periode'); // Format: YYYY-MM
            $table->timestamp('tgl_upload')->nullable();
            $table->timestamp('tgl_feedback')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('klaim');
    }
};