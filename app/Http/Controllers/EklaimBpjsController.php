<?php

namespace App\Http\Controllers;

use App\Models\EklaimBpjs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class EklaimBpjsController extends Controller
{
    // ============================================
    // INDEX + SEARCH + FILTER
    // ============================================
    public function index(Request $request)
    {
        // Query builder
        $query = EklaimBpjs::query();

        // 1) SEARCH (SEP, No Kartu, Nama Pasien)
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('sep', 'LIKE', "%{$search}%")
                    ->orWhere('no_sep', 'LIKE', "%{$search}%")
                    ->orWhere('nokartu', 'LIKE', "%{$search}%")
                    ->orWhere('no_kartu', 'LIKE', "%{$search}%")
                    ->orWhere('nama_pasien', 'LIKE', "%{$search}%");
            });
        }

        // 2) FILTER: Nama file upload
        if ($request->filled('file_name')) {
            $query->where('file_name', $request->file_name);
        }

        // 3) FILTER: Status Rawat (Inap/Jalan)
        if ($request->filled('status_rawat')) {
            if ($request->status_rawat == 'inap') {
                // Rawat inap → LOS > 0 atau discharge_date tidak null
                $query->where(function ($q) {
                    $q->where('los', '>', 0)
                        ->orWhereNotNull('discharge_date');
                });
            } elseif ($request->status_rawat == 'jalan') {
                // Rawat jalan → LOS 0 atau null
                $query->where(function ($q) {
                    $q->where('los', '<=', 0)
                        ->orWhereNull('los');
                });
            }
        }

        // 4) FILTER: Periode Upload (created_at)
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Ambil data
        $data = $query->orderBy('created_at', 'desc')
            ->paginate(50)
            ->appends($request->query());

        // Dropdown file upload
        $uploadedFiles = EklaimBpjs::select('file_name')
            ->distinct()
            ->whereNotNull('file_name')
            ->orderBy('file_name', 'desc')
            ->pluck('file_name');

        // Statistik
        $statistics = [
            'total' => EklaimBpjs::count(),
            'bulan_ini' => EklaimBpjs::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'total_tarif_rs' => EklaimBpjs::sum('tarif_rs'),
            'total_tarif_inacbg' => EklaimBpjs::sum('tarif_inacbg'),
        ];

        return view('casemix.index', compact('data', 'statistics', 'uploadedFiles'));
    }

    // ============================================
    // SHOW UPLOAD FORM
    // ============================================
    public function upload()
    {
        return view('casemix.upload');
    }

    // ============================================
    // STORE / IMPORT FILE + SIMPAN file_name
    // ============================================
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,txt|max:20480'
        ], [
            'file.required' => 'File harus dipilih',
            'file.mimes' => 'File harus berformat Excel (.xlsx, .xls) atau TXT',
            'file.max' => 'Ukuran file maksimal 20MB',
        ]);

        try {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName(); // simpan nama file upload
            $extension = $file->getClientOriginalExtension();

            // Tentukan cara baca file
            if (in_array(strtolower($extension), ['xlsx', 'xls'])) {
                $rows = $this->readExcelFile($file);
            } elseif (strtolower($extension) == 'txt') {
                $rows = $this->readTxtFile($file);
            } else {
                return back()->with('error', 'Format file tidak didukung');
            }

            if (count($rows) <= 1) {
                return back()->with('error', 'File kosong atau hanya berisi header');
            }

            $headers = array_map(function ($h) {
                return strtoupper(trim($h ?? ''));
            }, $rows[0]);

            $success = 0;
            $failed = 0;
            $duplicate = 0;
            $errors = [];

            DB::beginTransaction();

            try {
                // Loop mulai dari baris ke-2 (index 1), skip header
                for ($i = 1; $i < count($rows); $i++) {
                    $col = $rows[$i];

                    // Skip baris kosong
                    if (empty(array_filter($col))) {
                        continue;
                    }

                    // Cari index kolom SEP
                    $sepIndex = $this->findColumnIndex($headers, 'SEP');

                    if ($sepIndex === false) {
                        $failed++;
                        $errors[] = "Baris " . ($i + 1) . ": Kolom SEP tidak ditemukan di header";
                        continue;
                    }

                    // Validasi SEP ada di kolom yang ditemukan
                    if (!isset($col[$sepIndex])) {
                        $failed++;
                        $errors[] = "Baris " . ($i + 1) . ": SEP tidak ditemukan pada index {$sepIndex}";
                        continue;
                    }

                    // Ambil NO SEP dari kolom yang ditemukan
                    $sep = strtoupper(trim($col[$sepIndex] ?? ''));

                    // Validasi SEP tidak boleh kosong
                    if ($sep == '') {
                        $failed++;
                        $errors[] = "Baris " . ($i + 1) . ": NO SEP kosong";
                        continue;
                    }

                    // Cek duplikat SEP
                    if (EklaimBpjs::where('sep', $sep)->exists()) {
                        $duplicate++;
                        continue;
                    }

                    // Helper function untuk ambil data by header
                    $getCol = function ($headerName) use ($headers, $col) {
                        $index = $this->findColumnIndex($headers, $headerName);
                        return ($index !== false && isset($col[$index])) ? $col[$index] : '';
                    };

                    // Insert data ke database dengan mapping dinamis
                    try {
                        EklaimBpjs::create([
                            'file_name' => $fileName,
                            'kode_rs' => strtoupper($getCol('KODE_RS')),
                            'kelas_rs' => strtoupper($getCol('KELAS_RS')),
                            'kelas_rawat' => strtoupper($getCol('KELAS_RAWAT')),
                            'kode_tarif' => strtoupper($getCol('KODE_TARIF')),
                            'ptd' => strtoupper($getCol('PTD')),

                            'admission_date' => $this->formatDate($getCol('ADMISSION_DATE')),
                            'discharge_date' => $this->formatDate($getCol('DISCHARGE_DATE')),
                            'birth_date' => $this->formatDate($getCol('BIRTH_DATE')),

                            'birth_weight' => $getCol('BIRTH_WEIGHT'),
                            'sex' => strtoupper($getCol('SEX')),
                            'discharge_status' => strtoupper($getCol('DISCHARGE_STATUS')),
                            'diaglist' => strtoupper($getCol('DIAGLIST')),
                            'proclist' => strtoupper($getCol('PROCLIST')),

                            'adl1' => $getCol('ADL1'),
                            'adl2' => $getCol('ADL2'),

                            'in_sp' => strtoupper($getCol('IN_SP')),
                            'in_sr' => strtoupper($getCol('IN_SR')),
                            'in_si' => strtoupper($getCol('IN_SI')),
                            'in_sd' => strtoupper($getCol('IN_SD')),

                            'inacbg' => strtoupper($getCol('INACBG')),
                            'subacute' => strtoupper($getCol('SUBACUTE')),
                            'chronic' => strtoupper($getCol('CHRONIC')),
                            'sp' => strtoupper($getCol('SP')),
                            'sr' => strtoupper($getCol('SR')),
                            'si' => strtoupper($getCol('SI')),
                            'sd' => strtoupper($getCol('SD')),

                            'deskripsi_inacbg' => strtoupper($getCol('DESKRIPSI_INACBG')),
                            'tarif_inacbg' => $this->toNumber($getCol('TARIF_INACBG')),
                            'tarif_subacute' => $this->toNumber($getCol('TARIF_SUBACUTE')),
                            'tarif_chronic' => $this->toNumber($getCol('TARIF_CHRONIC')),

                            'deskripsi_sp' => strtoupper($getCol('DESKRIPSI_SP')),
                            'tarif_sp' => $this->toNumber($getCol('TARIF_SP')),
                            'deskripsi_sr' => strtoupper($getCol('DESKRIPSI_SR')),
                            'tarif_sr' => $this->toNumber($getCol('TARIF_SR')),
                            'deskripsi_si' => strtoupper($getCol('DESKRIPSI_SI')),
                            'tarif_si' => $this->toNumber($getCol('TARIF_SI')),
                            'deskripsi_sd' => strtoupper($getCol('DESKRIPSI_SD')),
                            'tarif_sd' => $this->toNumber($getCol('TARIF_SD')),

                            'total_tarif' => $this->toNumber($getCol('TOTAL_TARIF')),
                            'tarif_rs' => $this->toNumber($getCol('TARIF_RS')),
                            'tarif_poli_eks' => $this->toNumber($getCol('TARIF_POLI_EKS')),

                            'los' => $getCol('LOS'),
                            'icu_indikator' => strtoupper($getCol('ICU_INDIKATOR')),
                            'icu_los' => $getCol('ICU_LOS'),
                            'vent_hour' => $getCol('VENT_HOUR'),

                            'nama_pasien' => strtoupper($getCol('NAMA_PASIEN')),
                            'mrn' => strtoupper($getCol('MRN')),
                            'umur_tahun' => $getCol('UMUR_TAHUN'),
                            'umur_hari' => $getCol('UMUR_HARI'),
                            'dpjp' => strtoupper($getCol('DPJP')),

                            'sep' => $sep,
                            'no_sep' => $sep,
                            'nokartu' => strtoupper($getCol('NOKARTU')),
                            'payor_id' => strtoupper($getCol('PAYOR_ID')),
                            'coder_id' => strtoupper($getCol('CODER_ID')),
                            'versi_inacbg' => strtoupper($getCol('VERSI_INACBG')),
                            'versi_grouper' => strtoupper($getCol('VERSI_GROUPER')),

                            'c1' => $getCol('C1'),
                            'c2' => substr($getCol('C2'), 0, 65535),
                            'c3' => $getCol('C3'),
                            'c4' => $getCol('C4'),

                            'prosedur_non_bedah' => $this->toNumber($getCol('PROSEDUR_NON_BEDAH')),
                            'prosedur_bedah' => $this->toNumber($getCol('PROSEDUR_BEDAH')),
                            'konsultasi' => $this->toNumber($getCol('KONSULTASI')),
                            'tenaga_ahli' => $this->toNumber($getCol('TENAGA_AHLI')),
                            'keperawatan' => $this->toNumber($getCol('KEPERAWATAN')),
                            'penunjang' => $this->toNumber($getCol('PENUNJANG')),
                            'radiologi' => $this->toNumber($getCol('RADIOLOGI')),
                            'laboratorium' => $this->toNumber($getCol('LABORATORIUM')),
                            'pelayanan_darah' => $this->toNumber($getCol('PELAYANAN_DARAH')),
                            'rehabilitasi' => $this->toNumber($getCol('REHABILITASI')),
                            'kamar_akomodasi' => $this->toNumber($getCol('KAMAR_AKOMODASI')),
                            'rawat_intensif' => $this->toNumber($getCol('RAWAT_INTENSIF')),
                            'obat' => $this->toNumber($getCol('OBAT')),
                            'alkes' => $this->toNumber($getCol('ALKES')),
                            'bmhp' => $this->toNumber($getCol('BMHP')),
                            'sewa_alat' => $this->toNumber($getCol('SEWA_ALAT')),
                            'obat_kronis' => $this->toNumber($getCol('OBAT_KRONIS')),
                            'obat_kemo' => $this->toNumber($getCol('OBAT_KEMO')),
                        ]);

                        $success++;
                    } catch (Exception $e) {
                        $failed++;
                        $errors[] = "Baris " . ($i + 1) . ": " . $e->getMessage();
                        Log::error("Error importing row " . ($i + 1) . ": " . $e->getMessage());
                    }
                }

                DB::commit();

                // Simpan hasil upload ke session
                session()->flash('upload_result', compact('success', 'failed', 'duplicate', 'errors'));

                return redirect()->route('casemix.upload')
                    ->with('success', "Upload selesai! {$success} berhasil, {$duplicate} duplikat, {$failed} gagal.");

            } catch (Exception $e) {
                DB::rollBack();
                Log::error('Import Data Error: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses data: ' . $e->getMessage());
            }

        } catch (Exception $e) {
            Log::error('File Upload Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membaca file: ' . $e->getMessage());
        }
    }

    /**
     * Baca file Excel dan konversi ke array
     */
    private function readExcelFile($file)
    {
        return Excel::toArray([], $file)[0];
    }

    /**
     * Baca file TXT dan konversi ke array
     */
    private function readTxtFile($file)
    {
        $content = file_get_contents($file->getRealPath());

        // Deteksi dan hapus BOM jika ada
        $content = $this->removeBOM($content);

        // Split menjadi baris
        $lines = preg_split('/\r\n|\r|\n/', $content);

        // Hapus baris kosong
        $lines = array_filter($lines, function ($line) {
            return trim($line) != '';
        });

        // Reset array index
        $lines = array_values($lines);

        if (empty($lines)) {
            throw new Exception('File TXT kosong');
        }

        // Deteksi delimiter dari baris pertama
        $delimiter = $this->detectDelimiter($lines[0]);

        Log::info("Detected delimiter: " . ($delimiter == "\t" ? 'TAB' : $delimiter));

        // Parse semua baris
        $rows = [];
        foreach ($lines as $line) {
            $row = str_getcsv($line, $delimiter);
            $rows[] = $row;
        }

        return $rows;
    }

    /**
     * Deteksi delimiter yang digunakan di file TXT
     */
    private function detectDelimiter($line)
    {
        $delimiters = [
            "\t" => substr_count($line, "\t"),  // Tab
            ";" => substr_count($line, ";"),    // Semicolon
            "|" => substr_count($line, "|"),    // Pipe
            "," => substr_count($line, ","),    // Comma
        ];

        // Pilih delimiter dengan count terbanyak
        arsort($delimiters);
        $delimiter = key($delimiters);

        // Jika tidak ada delimiter yang ditemukan, gunakan tab sebagai default
        if ($delimiters[$delimiter] == 0) {
            return "\t";
        }

        return $delimiter;
    }

    /**
     * Hapus BOM (Byte Order Mark) dari string
     */
    private function removeBOM($text)
    {
        $bom = pack('H*', 'EFBBBF');
        return preg_replace("/^$bom/", '', $text);
    }

    /**
     * Cari index kolom berdasarkan nama header
     */
    private function findColumnIndex($headers, $columnName)
    {
        $columnName = strtoupper(trim($columnName));

        // Cari exact match
        $index = array_search($columnName, $headers);
        if ($index !== false) {
            return $index;
        }

        // Cari partial match (kolom yang mengandung kata yang dicari)
        foreach ($headers as $idx => $header) {
            if (stripos($header, $columnName) !== false) {
                return $idx;
            }
        }

        return false;
    }

    /**
     * Konversi tanggal Excel ke format Y-m-d
     */
    private function formatDate($value)
    {
        if (!$value || $value === '') {
            return null;
        }

        // Jika berupa angka (Excel date serial)
        if (is_numeric($value)) {
            try {
                return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value))
                    ->format('Y-m-d');
            } catch (Exception $e) {
                return null;
            }
        }

        // Jika berupa string tanggal
        $formats = ['d/m/Y', 'Y-m-d', 'd-m-Y', 'm/d/Y', 'Y-m-d H:i:s', 'd/m/Y H:i:s'];
        foreach ($formats as $fmt) {
            try {
                return Carbon::createFromFormat($fmt, $value)->format('Y-m-d');
            } catch (Exception $e) {
                continue;
            }
        }

        return null;
    }

    /**
     * Konversi angka dari Excel/TXT (menghilangkan format)
     */
    private function toNumber($angka)
    {
        if ($angka === null || $angka === '') {
            return 0;
        }

        // Jika sudah numeric, langsung return
        if (is_numeric($angka)) {
            return (float)$angka;
        }

        // Bersihkan format (hapus koma sebagai ribuan, dot jika ada)
        // Catatan: asumsi input bisa memakai titik atau koma sebagai pemisah ribuan/desimal;
        // di sini kita hapus semua koma/dot lalu konversi ke float.
        $angka = str_replace([',', '.'], '', trim($angka));

        return floatval($angka);
    }

    /**
     * Hapus data per baris
     */
    public function destroy($id)
    {
        try {
            $eklaim = EklaimBpjs::findOrFail($id);
            $eklaim->delete();

            return redirect()->back()->with('success', 'Data berhasil dihapus');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Hapus semua data
     */
    public function deleteAll()
    {
        try {
            DB::beginTransaction();

            $totalData = EklaimBpjs::count();

            // Hapus semua data
            EklaimBpjs::truncate();

            DB::commit();

            Log::info("All E-Klaim data deleted. Total: {$totalData} records");

            return redirect()->route('casemix.index')
                ->with('success', "Berhasil menghapus semua data ({$totalData} data dihapus)");
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Delete All Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus semua data: ' . $e->getMessage());
        }
    }
}
