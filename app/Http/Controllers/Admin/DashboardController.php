<?php
// File: app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Klaim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik klaim
        $totalKlaim = Klaim::count();
        $klaimCair = Klaim::where('status', 'cair')->count();
        $klaimPending = Klaim::where('status', 'pending')->count();
        $klaimTidakLayak = Klaim::where('status', 'tidak_layak')->count();

        // Tambahan
        $totalDiproses = Klaim::where('status', 'diproses')->count();

        // Total nilai klaim
        $totalNilaiCair = Klaim::where('status', 'cair')->sum('tarif_bpjs');
        $totalNilaiPending = Klaim::where('status', 'pending')->sum('tarif_rs');
        $totalNilaiTidakLayak = Klaim::where('status', 'tidak_layak')->sum('tarif_rs');

        // Selisih (Untung/Rugi)
        $totalSelisih = Klaim::where('status', 'cair')->sum('selisih');

        // Total klaim belum ter-kategori
        $totalBelumKategori = Klaim::whereNull('kategori')
            ->orWhere('kategori', '')
            ->count();

        // Total klaim terupload
        $totalUpload = Klaim::count();

        // Ambil semua data klaim
        $klaimList = Klaim::orderBy('created_at', 'desc')->get();

        // Data chart
        $klaimPerBulan = Klaim::select(
            DB::raw('periode'),
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN status = "cair" THEN 1 ELSE 0 END) as cair'),
            DB::raw('SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending'),
            DB::raw('SUM(CASE WHEN status = "tidak_layak" THEN 1 ELSE 0 END) as tidak_layak'),
            DB::raw('SUM(CASE WHEN status = "diproses" THEN 1 ELSE 0 END) as diproses')
        )
        ->groupBy('periode')
        ->orderBy('periode', 'desc')
        ->limit(6)
        ->get()
        ->reverse();

        return view('admin.dashboard', compact(
            'totalKlaim',
            'klaimCair',
            'klaimPending',
            'klaimTidakLayak',
            'totalDiproses',   // <<< DITAMBAHKAN DI SINI
            'totalNilaiCair',
            'totalNilaiPending',
            'totalNilaiTidakLayak',
            'totalSelisih',
            'totalBelumKategori',
            'totalUpload',
            'klaimList',
            'klaimPerBulan'
        ));
    }

    public function getKlaimData(Request $request)
    {
        $query = Klaim::query();

        if ($request->status != '') {
            $query->where('status', $request->status);
        }
        if ($request->periode != '') {
            $query->where('periode', $request->periode);
        }
        if ($request->jenis_rawat != '') {
            $query->where('jenis_rawat', $request->jenis_rawat);
        }

        $klaim = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'data' => $klaim
        ]);
    }
}
