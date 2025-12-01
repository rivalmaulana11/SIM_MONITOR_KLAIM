<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Klaim extends Model
{
    use HasFactory;

    protected $table = 'klaim';

    protected $fillable = [
        'no_sep',
        'no_kartu',
        'nama_pasien',
        'tgl_masuk',
        'tgl_keluar',
        'jenis_rawat',
        'kode_diagnosa',
        'diagnosa',
        'tarif_rs',
        'tarif_bpjs',
        'selisih',
        'status',
        'status_upload',
        'kategori',
        'catatan_kategori',
        'dikategorikan_oleh',
        'dikategorikan_pada',
        'uploaded_by',
        'uploaded_at',
        'periode_upload',
        'file_reference',
    ];

    protected $casts = [
        'tgl_masuk' => 'datetime',
        'tgl_keluar' => 'datetime',
        'tarif_rs' => 'decimal:2',
        'tarif_bpjs' => 'decimal:2',
        'selisih' => 'decimal:2',
        'dikategorikan_pada' => 'datetime',
        'uploaded_at' => 'datetime',
    ];

    /**
     * Accessor untuk format tarif RS
     */
    protected function tarifRsFormat(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp ' . number_format($this->tarif_rs, 0, ',', '.')
        );
    }

    /**
     * Accessor untuk format tarif BPJS
     */
    protected function tarifBpjsFormat(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp ' . number_format($this->tarif_bpjs, 0, ',', '.')
        );
    }

    /**
     * Accessor untuk format selisih
     */
    protected function selisihFormat(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->selisih >= 0) {
                    return '+Rp ' . number_format($this->selisih, 0, ',', '.');
                } else {
                    return '-Rp ' . number_format(abs($this->selisih), 0, ',', '.');
                }
            }
        );
    }

    /**
     * Accessor untuk status badge
     */
    protected function statusBadge(): Attribute
    {
        return Attribute::make(
            get: function () {
                $badges = [
                    'cair' => '<span class="badge text-bg-success">Cair</span>',
                    'pending' => '<span class="badge text-bg-warning">Pending</span>',
                    'tidak_layak' => '<span class="badge text-bg-danger">Tidak Layak</span>',
                ];
                
                return $badges[$this->status] ?? '<span class="badge text-bg-secondary">Belum Ada Status</span>';
            }
        );
    }

    /**
     * Accessor untuk kategori badge
     */
    protected function kategoriBadge(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->kategori) {
                    return '<span class="badge text-bg-warning">Belum Kategori</span>';
                }
                
                $badges = [
                    'cair' => '<span class="badge text-bg-success">Cair</span>',
                    'pending' => '<span class="badge text-bg-warning">Pending</span>',
                    'tidak_layak' => '<span class="badge text-bg-danger">Tidak Layak</span>',
                ];
                
                return $badges[$this->kategori] ?? '<span class="badge text-bg-secondary">-</span>';
            }
        );
    }

    /**
     * Accessor untuk status upload badge
     */
    protected function statusUploadBadge(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->status_upload == 'uploaded') {
                    return '<span class="badge text-bg-success">Terupload</span>';
                } else {
                    return '<span class="badge text-bg-secondary">Belum Upload</span>';
                }
            }
        );
    }

    /**
     * Relationship dengan User yang mengkategorikan
     */
    public function kategorikanOleh()
    {
        return $this->belongsTo(User::class, 'dikategorikan_oleh');
    }

    /**
     * Relationship dengan User yang upload
     */
    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Scope untuk filter klaim yang belum dikategorikan
     */
    public function scopeBelumKategori($query)
    {
        return $query->whereNull('kategori');
    }

    /**
     * Scope untuk filter klaim yang sudah diupload
     */
    public function scopeUploaded($query)
    {
        return $query->where('status_upload', 'uploaded');
    }

    /**
     * Scope untuk filter klaim yang sudah dikategorikan
     */
    public function scopeSudahKategori($query)
    {
        return $query->whereNotNull('kategori');
    }

    /**
     * Scope untuk filter berdasarkan periode
     */
    public function scopePeriode($query, $periode)
    {
        if ($periode) {
            $year = date('Y', strtotime($periode . '-01'));
            $month = date('m', strtotime($periode . '-01'));
            
            return $query->whereYear('tgl_masuk', $year)
                         ->whereMonth('tgl_masuk', $month);
        }
        
        return $query;
    }

    /**
     * Scope untuk filter berdasarkan jenis rawat
     */
    public function scopeJenisRawat($query, $jenisRawat)
    {
        if ($jenisRawat) {
            return $query->where('jenis_rawat', $jenisRawat);
        }
        
        return $query;
    }
}