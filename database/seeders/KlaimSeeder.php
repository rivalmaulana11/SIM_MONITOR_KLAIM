<?php
// File: database/seeders/KlaimSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Klaim;
use Carbon\Carbon;

class KlaimSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'no_sep' => '0301R0011123K000001',
                'no_kartu' => '0001234567890',
                'nama_pasien' => 'BUDI SANTOSO',
                'tgl_masuk' => '2024-11-01',
                'tgl_keluar' => '2024-11-05',
                'jenis_rawat' => 'Rawat Inap',
                'kelas_rawat' => 'Kelas 1',
                'kode_diagnosa' => 'A09',
                'diagnosa' => 'Diare dan Gastroenteritis',
                'kode_prosedur' => '89.54',
                'prosedur' => 'Elektrokardiografi',
                'tarif_rs' => 5500000,
                'tarif_bpjs' => 5200000,
                'selisih' => 300000,
                'status' => 'cair',
                'keterangan' => 'Klaim disetujui',
                'periode' => '2024-11',
                'tgl_upload' => Carbon::now()->subDays(20),
                'tgl_feedback' => Carbon::now()->subDays(15),
            ],
            [
                'no_sep' => '0301R0011123K000002',
                'no_kartu' => '0001234567891',
                'nama_pasien' => 'SITI AMINAH',
                'tgl_masuk' => '2024-11-03',
                'tgl_keluar' => '2024-11-03',
                'jenis_rawat' => 'Rawat Jalan',
                'kelas_rawat' => null,
                'kode_diagnosa' => 'J00',
                'diagnosa' => 'Nasofaringitis Akut',
                'kode_prosedur' => null,
                'prosedur' => null,
                'tarif_rs' => 250000,
                'tarif_bpjs' => 250000,
                'selisih' => 0,
                'status' => 'cair',
                'keterangan' => 'Klaim disetujui',
                'periode' => '2024-11',
                'tgl_upload' => Carbon::now()->subDays(18),
                'tgl_feedback' => Carbon::now()->subDays(12),
            ],
            [
                'no_sep' => '0301R0011123K000003',
                'no_kartu' => '0001234567892',
                'nama_pasien' => 'AHMAD HIDAYAT',
                'tgl_masuk' => '2024-11-08',
                'tgl_keluar' => '2024-11-12',
                'jenis_rawat' => 'Rawat Inap',
                'kelas_rawat' => 'Kelas 2',
                'kode_diagnosa' => 'I21.9',
                'diagnosa' => 'Infark Miokard Akut',
                'kode_prosedur' => '36.1',
                'prosedur' => 'Angiografi Koroner',
                'tarif_rs' => 12500000,
                'tarif_bpjs' => 11000000,
                'selisih' => 1500000,
                'status' => 'pending',
                'keterangan' => 'Menunggu verifikasi BPJS',
                'periode' => '2024-11',
                'tgl_upload' => Carbon::now()->subDays(10),
                'tgl_feedback' => null,
            ],
            [
                'no_sep' => '0301R0011123K000004',
                'no_kartu' => '0001234567893',
                'nama_pasien' => 'DEWI LESTARI',
                'tgl_masuk' => '2024-11-10',
                'tgl_keluar' => '2024-11-10',
                'jenis_rawat' => 'Rawat Jalan',
                'kelas_rawat' => null,
                'kode_diagnosa' => 'E11',
                'diagnosa' => 'Diabetes Mellitus Tipe 2',
                'kode_prosedur' => null,
                'prosedur' => null,
                'tarif_rs' => 180000,
                'tarif_bpjs' => 0,
                'selisih' => -180000,
                'status' => 'tidak_layak',
                'keterangan' => 'Pasien tidak memenuhi syarat klaim',
                'periode' => '2024-11',
                'tgl_upload' => Carbon::now()->subDays(8),
                'tgl_feedback' => Carbon::now()->subDays(5),
            ],
            [
                'no_sep' => '0301R0011123K000005',
                'no_kartu' => '0001234567894',
                'nama_pasien' => 'JOKO SUSILO',
                'tgl_masuk' => '2024-11-12',
                'tgl_keluar' => '2024-11-15',
                'jenis_rawat' => 'Rawat Inap',
                'kelas_rawat' => 'Kelas 3',
                'kode_diagnosa' => 'K35',
                'diagnosa' => 'Apendisitis Akut',
                'kode_prosedur' => '47.0',
                'prosedur' => 'Apendektomi',
                'tarif_rs' => 8500000,
                'tarif_bpjs' => 8500000,
                'selisih' => 0,
                'status' => 'cair',
                'keterangan' => 'Klaim disetujui',
                'periode' => '2024-11',
                'tgl_upload' => Carbon::now()->subDays(5),
                'tgl_feedback' => Carbon::now()->subDays(2),
            ],
            [
                'no_sep' => '0301R0011123K000006',
                'no_kartu' => '0001234567895',
                'nama_pasien' => 'RINA FITRIANI',
                'tgl_masuk' => '2024-11-15',
                'tgl_keluar' => '2024-11-18',
                'jenis_rawat' => 'Rawat Inap',
                'kelas_rawat' => 'Kelas 1',
                'kode_diagnosa' => 'O80',
                'diagnosa' => 'Persalinan Normal',
                'kode_prosedur' => '73.59',
                'prosedur' => 'Persalinan Spontan',
                'tarif_rs' => 4200000,
                'tarif_bpjs' => 3800000,
                'selisih' => 400000,
                'status' => 'pending',
                'keterangan' => 'Dalam proses verifikasi',
                'periode' => '2024-11',
                'tgl_upload' => Carbon::now()->subDays(3),
                'tgl_feedback' => null,
            ],
        ];

        foreach ($data as $item) {
            Klaim::create($item);
        }

        $this->command->info('✅ Berhasil membuat ' . count($data) . ' data klaim dummy!');
    }
}