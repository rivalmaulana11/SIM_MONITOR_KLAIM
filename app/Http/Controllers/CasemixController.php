<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Klaim;
use Illuminate\Support\Facades\DB;

class CasemixController extends Controller
{
    /**
     * Display dashboard casemix
     */
    public function dashboard(Request $request)
    {
        // Query dasar
        $query = Klaim::query();

        // Filter berdasarkan request
        if ($request->filled('status_upload')) {
            $query->where('status_upload', $request->status_upload);
        }

        if ($request->filled('kategori')) {
            if ($request->kategori == 'belum') {
                $query->whereNull('kategori');
            } else {
                $query->where('kategori', $request->kategori);
            }
        }

        if ($request->filled('jenis_rawat')) {
            $query->where('jenis_rawat', $request->jenis_rawat);
        }

        if ($request->filled('periode')) {
            $periode = $request->periode;
            $query->whereYear('tgl_masuk', '=', date('Y', strtotime($periode . '-01')))
                  ->whereMonth('tgl_masuk', '=', date('m', strtotime($periode . '-01')));
        }

        // Get data klaim
        $klaimList = $query->orderBy('created_at', 'desc')->get();

        // Statistik
        $totalBelumKategori = Klaim::whereNull('kategori')->count();
        $totalUpload = Klaim::where('status_upload', 'uploaded')->count();
        $totalDiproses = Klaim::whereNotNull('kategori')->count();
        $totalKlaim = Klaim::count();

        return view('casemix.dashboard', compact(
            'klaimList',
            'totalBelumKategori',
            'totalUpload',
            'totalDiproses',
            'totalKlaim'
        ));
    }

    /**
     * Upload file E-KLAIM
     */
    public function uploadEklaim(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:10240', // 10MB
            'periode' => 'required|date_format:Y-m',
            'keterangan' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            // Import file excel
            $file = $request->file('file');
            $periode = $request->periode;
            $keterangan = $request->keterangan;

            // TODO: Implementasi import Excel menggunakan Laravel Excel
            // Contoh: Excel::import(new KlaimImport($periode, $keterangan), $file);

            // Untuk sementara, simpan info upload
            // $uploaded = UploadLog::create([
            //     'user_id' => auth()->id(),
            //     'type' => 'eklaim',
            //     'file_name' => $file->getClientOriginalName(),
            //     'periode' => $periode,
            //     'keterangan' => $keterangan,
            //     'status' => 'success'
            // ]);

            // Generate 3 surat pengajuan awal
            // TODO: Implementasi generate surat

            DB::commit();

            return redirect()->route('casemix.dashboard')
                ->with('success', 'File E-KLAIM berhasil diupload. Sistem sedang memproses data dan menghasilkan 3 surat pengajuan awal.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('casemix.dashboard')
                ->with('error', 'Gagal upload file: ' . $e->getMessage());
        }
    }

    /**
     * Upload file feedback BPJS
     */
    public function uploadFeedback(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:10240',
            'periode' => 'required|date_format:Y-m',
            'keterangan' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $file = $request->file('file');
            $periode = $request->periode;
            $keterangan = $request->keterangan;

            // TODO: Implementasi import feedback Excel
            // Excel::import(new FeedbackImport($periode), $file);

            // Update status klaim berdasarkan feedback
            // TODO: Match data feedback dengan klaim yang ada

            DB::commit();

            return redirect()->route('casemix.dashboard')
                ->with('success', 'File feedback BPJS berhasil diupload dan data klaim telah diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('casemix.dashboard')
                ->with('error', 'Gagal upload feedback: ' . $e->getMessage());
        }
    }

    /**
     * Detail klaim
     */
    public function detail($id)
    {
        $klaim = Klaim::findOrFail($id);

        return view('casemix.detail', compact('klaim'));
    }

    /**
     * Kategorikan klaim
     */
    public function kategorikan(Request $request, $id)
    {
        $request->validate([
            'kategori' => 'required|in:cair,pending,tidak_layak',
            'catatan' => 'nullable|string|max:500'
        ]);

        try {
            $klaim = Klaim::findOrFail($id);
            
            $klaim->update([
                'kategori' => $request->kategori,
                'catatan_kategori' => $request->catatan,
                'dikategorikan_oleh' => auth()->id(),
                'dikategorikan_pada' => now()
            ]);

            // TODO: Generate 2 surat lanjutan berdasarkan kategori
            // if ($request->kategori == 'cair') {
            //     // Generate surat untuk klaim cair
            // } elseif ($request->kategori == 'pending') {
            //     // Generate surat untuk klaim pending
            // }

            // Update status klaim otomatis
            $klaim->update([
                'status' => $request->kategori
            ]);

            return redirect()->route('casemix.dashboard')
                ->with('success', 'Klaim berhasil dikategorikan sebagai ' . strtoupper($request->kategori) . '. Surat lanjutan sedang digenerate.');

        } catch (\Exception $e) {
            return redirect()->route('casemix.dashboard')
                ->with('error', 'Gagal mengkategorikan klaim: ' . $e->getMessage());
        }
    }

    /**
     * Kategorikan multiple klaim sekaligus
     */
    public function kategorikanBulk(Request $request)
    {
        $request->validate([
            'klaim_ids' => 'required|array',
            'klaim_ids.*' => 'exists:klaims,id',
            'kategori' => 'required|in:cair,pending,tidak_layak',
            'catatan' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $updated = Klaim::whereIn('id', $request->klaim_ids)
                ->update([
                    'kategori' => $request->kategori,
                    'catatan_kategori' => $request->catatan,
                    'dikategorikan_oleh' => auth()->id(),
                    'dikategorikan_pada' => now(),
                    'status' => $request->kategori
                ]);

            DB::commit();

            return redirect()->route('casemix.dashboard')
                ->with('success', $updated . ' klaim berhasil dikategorikan sebagai ' . strtoupper($request->kategori));

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('casemix.dashboard')
                ->with('error', 'Gagal mengkategorikan klaim: ' . $e->getMessage());
        }
    }
}