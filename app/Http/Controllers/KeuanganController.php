<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function dashboard()
    {
        // FB8: Rekap Keuangan Klaim
        // Total Klaim Cair
        $totalKlaimCair = 150000000; // 150 juta
        $jumlahKlaimCair = 45;
        
        // Total Pending
        $totalKlaimPending = 75000000; // 75 juta
        $jumlahKlaimPending = 30;
        
        // Total Tidak Layak
        $totalKlaimTidakLayak = 25000000; // 25 juta
        $jumlahKlaimTidakLayak = 15;
        
        // Selisih Biaya RS (Untung/Rugi)
        $biayaRumahSakit = 220000000; // Total biaya RS
        $totalPendapatan = 250000000; // Total klaim cair + pending
        $selisihBiaya = $totalPendapatan - $biayaRumahSakit; // 30 juta (Untung)
        
        // FB5 & FB6: Surat Pengajuan dan Penerimaan
        $totalSuratPengajuan = 15; // 3 surat per upload x 5 upload
        $totalSuratPenerimaan = 10; // 2 surat per feedback x 5 feedback
        $totalSuratDiverifikasi = 20;
        
        // FB3: Notifikasi Upload Baru
        $uploadBaruHariIni = 2; // Jumlah upload hari ini

        return view('keuangan.dashboard', compact(
            'totalKlaimCair',
            'jumlahKlaimCair',
            'totalKlaimPending',
            'jumlahKlaimPending',
            'totalKlaimTidakLayak',
            'jumlahKlaimTidakLayak',
            'selisihBiaya',
            'totalSuratPengajuan',
            'totalSuratPenerimaan',
            'totalSuratDiverifikasi',
            'uploadBaruHariIni'
        ));
    }

    public function suratPengajuan()
    {
        // FB5: Mengakses Surat Pengajuan Klaim
        return view('keuangan.surat-pengajuan');
    }

    public function suratPenerimaan()
    {
        // FB6: Mengakses Surat Penerimaan Klaim
        return view('keuangan.surat-penerimaan');
    }

    public function verifikasiArsip()
    {
        // FB7: Mengelola Surat (Verifikasi & Arsip)
        return view('keuangan.verifikasi-arsip');
    }

    public function filterLaporan(Request $request)
    {
        // FB9: Filter Laporan & Surat
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalAkhir = $request->input('tanggal_akhir');
        $jenisSurat = $request->input('jenis_surat');
        $status = $request->input('status');

        // Logic filter data
        // ...

        return view('keuangan.laporan', compact(
            'tanggalMulai',
            'tanggalAkhir',
            'jenisSurat',
            'status'
        ));
    }
}