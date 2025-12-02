<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eklaim_bpjs', function (Blueprint $table) {
            $table->id();

            // ==========================
            // FIELD DASAR
            // ==========================
            $table->string('no_sep', 50)->nullable(); // sudah tidak unique
            $table->string('no_kartu', 50)->nullable();
            $table->string('nama_peserta', 150)->nullable();
            $table->date('tgl_masuk')->nullable();
            $table->date('tgl_pulang')->nullable();
            $table->string('jenis_rawat', 20)->nullable();
            $table->string('kelas_rawat', 10)->nullable();
            $table->string('diagnosa_primer')->nullable();
            $table->string('kode_icd10', 20)->nullable();
            $table->decimal('tarif_rs', 15, 2)->default(0);
            $table->decimal('tarif_inacbg', 15, 2)->default(0);
            $table->string('grouper', 50)->nullable();
            $table->string('status_pulang', 50)->nullable();
            $table->string('status_klaim', 30)->nullable();
            $table->text('catatan')->nullable();

            // ==========================
            // FIELD TAMBAHAN E-KLAIM
            // ==========================
            $table->string('kode_rs')->nullable();
            $table->string('kelas_rs')->nullable();
            $table->string('kode_tarif')->nullable();
            $table->string('ptd')->nullable();

            $table->date('admission_date')->nullable();
            $table->date('discharge_date')->nullable();
            $table->date('birth_date')->nullable();

            $table->string('birth_weight')->nullable();
            $table->string('sex')->nullable();
            $table->string('discharge_status')->nullable();

            $table->text('diaglist')->nullable();
            $table->text('proclist')->nullable();
            $table->string('adl1')->nullable();
            $table->string('adl2')->nullable();

            $table->string('in_sp')->nullable();
            $table->string('in_sr')->nullable();
            $table->string('in_si')->nullable();
            $table->string('in_sd')->nullable();

            $table->string('inacbg')->nullable();
            $table->string('subacute')->nullable();
            $table->string('chronic')->nullable();

            $table->string('sp')->nullable();
            $table->string('sr')->nullable();
            $table->string('si')->nullable();
            $table->string('sd')->nullable();

            $table->text('deskripsi_inacbg')->nullable();

            $table->decimal('tarif_subacute', 15, 2)->nullable();
            $table->decimal('tarif_chronic', 15, 2)->nullable();

            $table->text('deskripsi_sp')->nullable();
            $table->decimal('tarif_sp', 15, 2)->nullable();

            $table->text('deskripsi_sr')->nullable();
            $table->decimal('tarif_sr', 15, 2)->nullable();

            $table->text('deskripsi_si')->nullable();
            $table->decimal('tarif_si', 15, 2)->nullable();

            $table->text('deskripsi_sd')->nullable();
            $table->decimal('tarif_sd', 15, 2)->nullable();

            $table->decimal('total_tarif', 15, 2)->nullable();
            $table->decimal('tarif_poli_eks', 15, 2)->nullable();

            $table->string('los')->nullable();
            $table->string('icu_indikator')->nullable();
            $table->string('icu_los')->nullable();
            $table->string('vent_hour')->nullable();

            $table->string('nama_pasien')->nullable();
            $table->string('mrn')->nullable();

            $table->string('umur_tahun')->nullable();
            $table->string('umur_hari')->nullable();

            $table->string('dpjp')->nullable();
            $table->string('sep')->nullable();
            $table->string('nokartu')->nullable();

            $table->string('payor_id')->nullable();
            $table->string('coder_id')->nullable();
            $table->string('versi_inacbg')->nullable();
            $table->string('versi_grouper')->nullable();

            $table->string('c1')->nullable();
            $table->string('c2')->nullable();
            $table->string('c3')->nullable();
            $table->string('c4')->nullable();

            $table->decimal('prosedur_non_bedah', 15, 2)->nullable();
            $table->decimal('prosedur_bedah', 15, 2)->nullable();
            $table->decimal('konsultasi', 15, 2)->nullable();
            $table->decimal('tenaga_ahli', 15, 2)->nullable();
            $table->decimal('keperawatan', 15, 2)->nullable();
            $table->decimal('penunjang', 15, 2)->nullable();
            $table->decimal('radiologi', 15, 2)->nullable();
            $table->decimal('laboratorium', 15, 2)->nullable();
            $table->decimal('pelayanan_darah', 15, 2)->nullable();
            $table->decimal('rehabilitasi', 15, 2)->nullable();
            $table->decimal('kamar_akomodasi', 15, 2)->nullable();
            $table->decimal('rawat_intensif', 15, 2)->nullable();
            $table->decimal('obat', 15, 2)->nullable();
            $table->decimal('alkes', 15, 2)->nullable();
            $table->decimal('bmhp', 15, 2)->nullable();
            $table->decimal('sewa_alat', 15, 2)->nullable();
            $table->decimal('obat_kronis', 15, 2)->nullable();
            $table->decimal('obat_kemo', 15, 2)->nullable();

            $table->timestamps();

            // INDEXES
            $table->index('no_sep');
            $table->index('no_kartu');
            $table->index('tgl_masuk');
            $table->index('status_klaim');
            $table->index('sep');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eklaim_bpjs');
    }
};
