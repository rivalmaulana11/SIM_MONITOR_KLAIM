<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EklaimBpjs extends Model
{
    use HasFactory;

    protected $table = 'eklaim_bpjs';

    protected $fillable = [
        'kode_rs',
        'kelas_rs',
        'kelas_rawat',
        'kode_tarif',
        'ptd',
        'admission_date',
        'discharge_date',
        'birth_date',
        'birth_weight',
        'sex',
        'discharge_status',
        'diaglist',
        'proclist',
        'adl1',
        'adl2',
        'in_sp',
        'in_sr',
        'in_si',
        'in_sd',
        'inacbg',
        'subacute',
        'chronic',
        'sp',
        'sr',
        'si',
        'sd',
        'deskripsi_inacbg',
        'tarif_inacbg',
        'tarif_subacute',
        'tarif_chronic',
        'deskripsi_sp',
        'tarif_sp',
        'deskripsi_sr',
        'tarif_sr',
        'deskripsi_si',
        'tarif_si',
        'deskripsi_sd',
        'tarif_sd',
        'total_tarif',
        'tarif_rs',
        'tarif_poli_eks',
        'los',
        'icu_indikator',
        'icu_los',
        'vent_hour',
        'nama_pasien',
        'mrn',
        'umur_tahun',
        'umur_hari',
        'dpjp',
        'sep',
        'nokartu',
        'payor_id',
        'coder_id',
        'versi_inacbg',
        'versi_grouper',
        'c1',
        'c2',
        'c3',
        'c4',
        'prosedur_non_bedah',
        'prosedur_bedah',
        'konsultasi',
        'tenaga_ahli',
        'keperawatan',
        'penunjang',
        'radiologi',
        'laboratorium',
        'pelayanan_darah',
        'rehabilitasi',
        'kamar_akomodasi',
        'rawat_intensif',
        'obat',
        'alkes',
        'bmhp',
        'sewa_alat',
        'obat_kronis',
        'obat_kemo',
        
        // Field tambahan dari migration pertama (opsional)
        'no_sep',
        'no_kartu',
        'nama_peserta',
        'tgl_masuk',
        'tgl_pulang',
        'jenis_rawat',
        'diagnosa_primer',
        'kode_icd10',
        'grouper',
        'status_pulang',
        'status_klaim',
        'catatan',
    ];

    protected $casts = [
        'admission_date' => 'date',
        'discharge_date' => 'date',
        'birth_date' => 'date',
        'tgl_masuk' => 'date',
        'tgl_pulang' => 'date',
        'tarif_rs' => 'decimal:2',
        'tarif_inacbg' => 'decimal:2',
        'tarif_subacute' => 'decimal:2',
        'tarif_chronic' => 'decimal:2',
        'tarif_sp' => 'decimal:2',
        'tarif_sr' => 'decimal:2',
        'tarif_si' => 'decimal:2',
        'tarif_sd' => 'decimal:2',
        'total_tarif' => 'decimal:2',
        'tarif_poli_eks' => 'decimal:2',
        'prosedur_non_bedah' => 'decimal:2',
        'prosedur_bedah' => 'decimal:2',
        'konsultasi' => 'decimal:2',
        'tenaga_ahli' => 'decimal:2',
        'keperawatan' => 'decimal:2',
        'penunjang' => 'decimal:2',
        'radiologi' => 'decimal:2',
        'laboratorium' => 'decimal:2',
        'pelayanan_darah' => 'decimal:2',
        'rehabilitasi' => 'decimal:2',
        'kamar_akomodasi' => 'decimal:2',
        'rawat_intensif' => 'decimal:2',
        'obat' => 'decimal:2',
        'alkes' => 'decimal:2',
        'bmhp' => 'decimal:2',
        'sewa_alat' => 'decimal:2',
        'obat_kronis' => 'decimal:2',
        'obat_kemo' => 'decimal:2',
    ];

    // Accessor untuk format tanggal Indonesia
    public function getAdmissionDateFormattedAttribute()
    {
        return $this->admission_date ? $this->admission_date->format('d/m/Y') : '-';
    }

    public function getDischargeDateFormattedAttribute()
    {
        return $this->discharge_date ? $this->discharge_date->format('d/m/Y') : '-';
    }

    // Accessor untuk format rupiah
    public function getTarifRsFormattedAttribute()
    {
        return 'Rp ' . number_format($this->tarif_rs, 0, ',', '.');
    }

    public function getTarifInacbgFormattedAttribute()
    {
        return 'Rp ' . number_format($this->tarif_inacbg, 0, ',', '.');
    }

    public function getTotalTarifFormattedAttribute()
    {
        return 'Rp ' . number_format($this->total_tarif, 0, ',', '.');
    }

    // Hitung lama rawat (LOS - Length of Stay)
    public function getLamaRawatAttribute()
    {
        if ($this->admission_date && $this->discharge_date) {
            return $this->admission_date->diffInDays($this->discharge_date);
        }
        return $this->los ?? 0;
    }
}