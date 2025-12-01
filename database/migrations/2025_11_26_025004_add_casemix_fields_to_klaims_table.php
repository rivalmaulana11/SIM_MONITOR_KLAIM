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
        Schema::table('klaim', function (Blueprint $table)
 {
            // Kolom untuk status upload
            $table->string('status_upload')->default('not_uploaded')->after('status');
            // Nilai: 'uploaded', 'not_uploaded'
            
            // Kolom untuk kategori
            $table->string('kategori')->nullable()->after('status_upload');
            // Nilai: 'cair', 'pending', 'tidak_layak', null (belum dikategorikan)
            
            // Kolom untuk catatan kategorisasi
            $table->text('catatan_kategori')->nullable()->after('kategori');
            
            // Kolom untuk tracking siapa yang mengkategorikan
            $table->unsignedBigInteger('dikategorikan_oleh')->nullable()->after('catatan_kategori');
            $table->timestamp('dikategorikan_pada')->nullable()->after('dikategorikan_oleh');
            
            // Kolom untuk tracking upload
            $table->unsignedBigInteger('uploaded_by')->nullable()->after('dikategorikan_pada');
            $table->timestamp('uploaded_at')->nullable()->after('uploaded_by');
            
            // Kolom untuk periode upload
            $table->string('periode_upload')->nullable()->after('uploaded_at');
            // Format: YYYY-MM
            
            // Kolom untuk file reference
            $table->string('file_reference')->nullable()->after('periode_upload');
            // Reference ke file yang diupload
            
            // Foreign keys (opsional)
            // $table->foreign('dikategorikan_oleh')->references('id')->on('users')->onDelete('set null');
            // $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('klaim', function (Blueprint $table)
 {
            $table->dropColumn([
                'status_upload',
                'kategori',
                'catatan_kategori',
                'dikategorikan_oleh',
                'dikategorikan_pada',
                'uploaded_by',
                'uploaded_at',
                'periode_upload',
                'file_reference'
            ]);
        });
    }
};