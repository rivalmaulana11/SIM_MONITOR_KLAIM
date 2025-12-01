@extends('layouts.admin')

@section('title', 'Dashboard Casemix')

@section('content')
<!--begin::App Content Header-->
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Dashboard Casemix</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Casemix</li>
                </ol>
            </div>
        </div>
        <!--end::Row-->
    </div>
    <!--end::Container-->
</div>
<!--end::App Content Header-->

<!--begin::App Content-->
<div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">

        <!-- Alert Success -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Alert Error -->
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!--begin::Row - Quick Actions-->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-primary bg-opacity-10 rounded-circle">
                                    <i class="bi bi-cloud-upload fs-2 text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="card-title mb-1">Upload File E-KLAIM</h5>
                                <p class="card-text text-muted small mb-0">Upload file dari sistem E-Klaim (.xlsx)</p>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#uploadEklaimModal">
                            <i class="bi bi-upload me-2"></i>Upload File E-KLAIM
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-success bg-opacity-10 rounded-circle">
                                    <i class="bi bi-file-earmark-check fs-2 text-success"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="card-title mb-1">Upload Feedback BPJS</h5>
                                <p class="card-text text-muted small mb-0">Upload file feedback dari BPJS (.xlsx)</p>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#uploadFeedbackModal">
                            <i class="bi bi-upload me-2"></i>Upload Feedback BPJS
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Row-->

        <!--begin::Row - Stats-->
        <div class="row mb-4">
            <div class="col-lg-3 col-6">
                <div class="small-box text-bg-warning">
                    <div class="inner">
                        <h3>{{ $totalBelumKategori }}</h3>
                        <p>Layak</p>
                    </div>
                    <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="#" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                        Kategorikan <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box text-bg-info">
                    <div class="inner">
                        <h3>{{ $totalUpload }}</h3>
                        <p>Pending</p>
                    </div>
                    <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625z"></path>
                        <path d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-6.963-6.963z"></path>
                    </svg>
                    <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                        Lihat Detail <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box text-bg-success">
                    <div class="inner">
                        <h3>{{ $totalDiproses }}</h3>
                        <p>Tidak Layak</p>
                    </div>
                    <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                        Lihat Detail <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box text-bg-primary">
                    <div class="inner">
                        <h3>{{ $totalKlaim }}</h3>
                        <p>Total Klaim</p>
                    </div>
                    <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z"></path>
                    </svg>
                    <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                        Lihat Semua <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
            </div>
        </div>
        <!--end::Row-->

        {{-- <!--begin::Row - Hak Akses-->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="bi bi-shield-check me-2"></i>Hak Akses Casemix</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Upload file dari E-KLAIM (Menghasilkan 3 surat pengajuan awal)
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Upload file feedback BPJS
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Memisahkan klaim sesuai kategori (Menghasilkan 2 surat lanjutan)
                            </li>
                            <li class="mb-0">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Sistem otomatis mengubah status klaim
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Row--> --}}

        <!--begin::Row - Data Tabel-->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="bi bi-table me-2"></i>Data Klaim Terupload</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                                <i class="bi bi-funnel"></i> Filter
                            </button>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="klaimTable" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th>No. SEP</th>
                                    <th>No. Kartu</th>
                                    <th>Nama Pasien</th>
                                    <th>Tgl Masuk</th>
                                    <th>Tgl Keluar</th>
                                    <th>Jenis Rawat</th>
                                    <th>Diagnosa</th>
                                    <th class="text-end">Tarif RS</th>
                                    <th class="text-end">Tarif BPJS</th>
                                    <th>Status Upload</th>
                                    <th>Kategori</th>
                                    <th style="width: 150px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($klaimList as $index => $klaim)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><small>{{ $klaim->no_sep }}</small></td>
                                    <td><small>{{ $klaim->no_kartu }}</small></td>
                                    <td>{{ $klaim->nama_pasien }}</td>
                                    <td><small>{{ $klaim->tgl_masuk->format('d/m/Y') }}</small></td>
                                    <td><small>{{ $klaim->tgl_keluar->format('d/m/Y') }}</small></td>
                                    <td>
                                        @if($klaim->jenis_rawat == 'Rawat Inap')
                                            <span class="badge text-bg-info">{{ $klaim->jenis_rawat }}</span>
                                        @else
                                            <span class="badge text-bg-secondary">{{ $klaim->jenis_rawat }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $klaim->kode_diagnosa }}</small><br>
                                        <small>{{ Str::limit($klaim->diagnosa, 30) }}</small>
                                    </td>
                                    <td class="text-end"><small>{{ $klaim->tarif_rs_format }}</small></td>
                                    <td class="text-end"><small>{{ $klaim->tarif_bpjs_format }}</small></td>
                                    <td>
                                        @if($klaim->status_upload == 'uploaded')
                                            <span class="badge text-bg-success">Terupload</span>
                                        @else
                                            <span class="badge text-bg-secondary">Belum Upload</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($klaim->kategori)
                                            <span class="badge text-bg-primary">{{ $klaim->kategori }}</span>
                                        @else
                                            <span class="badge text-bg-warning">Belum Kategori</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" class="btn btn-info" onclick="detailKlaim({{ $klaim->id }})" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-warning" onclick="kategorikanKlaim({{ $klaim->id }})" title="Kategorikan">
                                                <i class="bi bi-tags"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="13" class="text-center py-4">
                                        <i class="bi bi-inbox fs-3 text-muted d-block mb-2"></i>
                                        <span class="text-muted">Belum ada data klaim yang diupload</span>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Row-->

    </div>
    <!--end::Container-->
</div>
<!--end::App Content-->

<!-- Modal Upload E-KLAIM - Enhanced Version -->
<div class="modal fade" id="uploadEklaimModal" tabindex="-1" aria-labelledby="uploadEklaimModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadEklaimModalLabel">
                    <i class="bi bi-cloud-upload me-2"></i>Upload File E-KLAIM
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('casemix.upload.eklaim') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <small>Upload file Excel (.xlsx) dari sistem E-KLAIM. File akan diproses dan menghasilkan 3 surat pengajuan awal.</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="jenisRawat" class="form-label">
                                Jenis Rawat <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="jenisRawat" name="jenis_rawat" required>
                                <option value="">Pilih Jenis Rawat</option>
                                <option value="rawat_inap">Rawat Inap</option>
                                <option value="rawat_jalan">Rawat Jalan</option>
                            </select>
                            <div class="form-text">Pilih kategori jenis rawat untuk file yang akan diupload</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="fileEklaim" class="form-label">
                                Pilih File Excel <span class="text-danger">*</span>
                            </label>
                            <input type="file" class="form-control" id="fileEklaim" name="file" accept=".xlsx,.xls" required>
                            <div class="form-text">Format: .xlsx atau .xls (Max 10MB)</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="periodeData" class="form-label">
                                Periode Data <span class="text-danger">*</span>
                            </label>
                            <input type="month" class="form-control" id="periodeData" name="periode_data" required>
                            <div class="form-text">Periode bulan data klaim</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="periodePengajuan" class="form-label">
                                Periode Pengajuan <span class="text-danger">*</span>
                            </label>
                            <input type="month" class="form-control" id="periodePengajuan" name="periode_pengajuan" required>
                            <div class="form-text">Periode bulan pengajuan ke BPJS</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Tambahkan keterangan jika diperlukan (opsional)"></textarea>
                    </div>

                    <!-- Preview Info -->
                    <div class="card bg-light" id="uploadPreview" style="display: none;">
                        <div class="card-body">
                            <h6 class="card-title mb-3"><i class="bi bi-info-circle me-2"></i>Ringkasan Upload</h6>
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted d-block">Jenis Rawat</small>
                                    <strong id="previewJenisRawat">-</strong>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">File</small>
                                    <strong id="previewFile">-</strong>
                                </div>
                                {{-- <div class="col-6 mt-2">
                                    <small class="text-muted d-block">Periode Data</small>
                                    <strong id="previewPeriodeData">-</strong>
                                </div> --}}
                                <div class="col-6 mt-2">
                                    <small class="text-muted d-block">Periode Pengajuan</small>
                                    <strong id="previewPeriodePengajuan">-</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-upload me-2"></i>Upload File
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Upload Feedback BPJS - Enhanced Version -->
<div class="modal fade" id="uploadFeedbackModal" tabindex="-1" aria-labelledby="uploadFeedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadFeedbackModalLabel">
                    <i class="bi bi-file-earmark-check me-2"></i>Upload Feedback BPJS
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('casemix.upload.feedback') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-success">
                        <i class="bi bi-info-circle me-2"></i>
                        <small>Upload file Excel feedback dari BPJS. File akan dicocokkan dengan data klaim yang sudah ada.</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="jenisRawatFeedback" class="form-label">
                                Jenis Rawat <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="jenisRawatFeedback" name="jenis_rawat" required>
                                <option value="">Pilih Jenis Rawat</option>
                                <option value="rawat_inap">Rawat Inap</option>
                                <option value="rawat_jalan">Rawat Jalan</option>
                            </select>
                            <div class="form-text">Pilih kategori jenis rawat untuk feedback</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="fileFeedback" class="form-label">
                                Pilih File Excel <span class="text-danger">*</span>
                            </label>
                            <input type="file" class="form-control" id="fileFeedback" name="file" accept=".xlsx,.xls" required>
                            <div class="form-text">Format: .xlsx atau .xls (Max 10MB)</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="periodeDataFeedback" class="form-label">
                                Periode Data <span class="text-danger">*</span>
                            </label>
                            <input type="month" class="form-control" id="periodeDataFeedback" name="periode_data" required>
                            <div class="form-text">Periode bulan data feedback</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="periodePengajuanFeedback" class="form-label">
                                Periode Pengajuan <span class="text-danger">*</span>
                            </label>
                            <input type="month" class="form-control" id="periodePengajuanFeedback" name="periode_pengajuan" required>
                            <div class="form-text">Periode pengajuan yang di-feedback</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="keteranganFeedback" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keteranganFeedback" name="keterangan" rows="3" placeholder="Tambahkan keterangan jika diperlukan (opsional)"></textarea>
                    </div>

                    <!-- Preview Info -->
                    <div class="card bg-light" id="feedbackPreview" style="display: none;">
                        <div class="card-body">
                            <h6 class="card-title mb-3"><i class="bi bi-info-circle me-2"></i>Ringkasan Upload</h6>
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted d-block">Jenis Rawat</small>
                                    <strong id="previewJenisRawatFeedback">-</strong>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">File</small>
                                    <strong id="previewFileFeedback">-</strong>
                                </div>
                                <div class="col-6 mt-2">
                                    <small class="text-muted d-block">Periode Data</small>
                                    <strong id="previewPeriodeDataFeedback">-</strong>
                                </div>
                                <div class="col-6 mt-2">
                                    <small class="text-muted d-block">Periode Pengajuan</small>
                                    <strong id="previewPeriodePengajuanFeedback">-</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-upload me-2"></i>Upload Feedback
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Modal Filter -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter Data Klaim</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="filterForm">
                    <div class="mb-3">
                        <label class="form-label">Status Upload</label>
                        <select class="form-select" name="status_upload">
                            <option value="">Semua Status</option>
                            <option value="uploaded">Terupload</option>
                            <option value="not_uploaded">Belum Upload</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-select" name="kategori">
                            <option value="">Semua Kategori</option>
                            <option value="cair">Cair</option>
                            <option value="pending">Pending</option>
                            <option value="tidak_layak">Tidak Layak</option>
                            <option value="belum">Belum Kategori</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Rawat</label>
                        <select class="form-select" name="jenis_rawat">
                            <option value="">Semua Jenis</option>
                            <option value="Rawat Inap">Rawat Inap</option>
                            <option value="Rawat Jalan">Rawat Jalan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Periode</label>
                        <input type="month" class="form-control" name="periode">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="applyFilter()">Terapkan Filter</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Kategorikan -->
<div class="modal fade" id="kategoriModal" tabindex="-1" aria-labelledby="kategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kategoriModalLabel">Kategorikan Klaim</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="kategoriForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-select" name="kategori" required>
                            <option value="">Pilih Kategori</option>
                            <option value="cair">Cair</option>
                            <option value="pending">Pending</option>
                            <option value="tidak_layak">Tidak Layak</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea class="form-control" name="catatan" rows="3" placeholder="Tambahkan catatan jika diperlukan"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .small-box .inner h3 {
        font-size: 2.5rem;
        font-weight: bold;
    }
    .table th {
        font-size: 0.85rem;
        white-space: nowrap;
    }
    .table td {
        font-size: 0.8rem;
        vertical-align: middle;
    }
</style>
@endpush

@push('scripts')
<script>
// Preview untuk Upload E-KLAIM
document.addEventListener('DOMContentLoaded', function() {
    const jenisRawat = document.getElementById('jenisRawat');
    const fileEklaim = document.getElementById('fileEklaim');
    const periodeData = document.getElementById('periodeData');
    const periodePengajuan = document.getElementById('periodePengajuan');
    const uploadPreview = document.getElementById('uploadPreview');

    function updatePreview() {
        if (jenisRawat.value && fileEklaim.files.length > 0 && periodeData.value && periodePengajuan.value) {
            document.getElementById('previewJenisRawat').textContent = 
                jenisRawat.options[jenisRawat.selectedIndex].text;
            document.getElementById('previewFile').textContent = fileEklaim.files[0].name;
            document.getElementById('previewPeriodeData').textContent = 
                new Date(periodeData.value + '-01').toLocaleDateString('id-ID', { year: 'numeric', month: 'long' });
            document.getElementById('previewPeriodePengajuan').textContent = 
                new Date(periodePengajuan.value + '-01').toLocaleDateString('id-ID', { year: 'numeric', month: 'long' });
            uploadPreview.style.display = 'block';
        } else {
            uploadPreview.style.display = 'none';
        }
    }

    jenisRawat.addEventListener('change', updatePreview);
    fileEklaim.addEventListener('change', updatePreview);
    periodeData.addEventListener('change', updatePreview);
    periodePengajuan.addEventListener('change', updatePreview);

    // Preview untuk Upload Feedback
    const jenisRawatFeedback = document.getElementById('jenisRawatFeedback');
    const fileFeedback = document.getElementById('fileFeedback');
    const periodeDataFeedback = document.getElementById('periodeDataFeedback');
    const periodePengajuanFeedback = document.getElementById('periodePengajuanFeedback');
    const feedbackPreview = document.getElementById('feedbackPreview');

    function updateFeedbackPreview() {
        if (jenisRawatFeedback.value && fileFeedback.files.length > 0 && 
            periodeDataFeedback.value && periodePengajuanFeedback.value) {
            document.getElementById('previewJenisRawatFeedback').textContent = 
                jenisRawatFeedback.options[jenisRawatFeedback.selectedIndex].text;
            document.getElementById('previewFileFeedback').textContent = fileFeedback.files[0].name;
            document.getElementById('previewPeriodeDataFeedback').textContent = 
                new Date(periodeDataFeedback.value + '-01').toLocaleDateString('id-ID', { year: 'numeric', month: 'long' });
            document.getElementById('previewPeriodePengajuanFeedback').textContent = 
                new Date(periodePengajuanFeedback.value + '-01').toLocaleDateString('id-ID', { year: 'numeric', month: 'long' });
            feedbackPreview.style.display = 'block';
        } else {
            feedbackPreview.style.display = 'none';
        }
    }

    jenisRawatFeedback.addEventListener('change', updateFeedbackPreview);
    fileFeedback.addEventListener('change', updateFeedbackPreview);
    periodeDataFeedback.addEventListener('change', updateFeedbackPreview);
    periodePengajuanFeedback.addEventListener('change', updateFeedbackPreview);

    // Reset preview ketika modal ditutup
    document.getElementById('uploadEklaimModal').addEventListener('hidden.bs.modal', function () {
        uploadPreview.style.display = 'none';
        this.querySelector('form').reset();
    });

    document.getElementById('uploadFeedbackModal').addEventListener('hidden.bs.modal', function () {
        feedbackPreview.style.display = 'none';
        this.querySelector('form').reset();
    });
});
$(function () {
    // Initialize DataTable
    $('#klaimTable').DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
        "pageLength": 25,
        "order": [[0, 'asc']],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        }
    });
});

function detailKlaim(id) {
    // Redirect ke halaman detail atau buka modal detail
    window.location.href = '/casemix/klaim/' + id;
}

function kategorikanKlaim(id) {
    const form = document.getElementById('kategoriForm');
    form.action = '/casemix/klaim/' + id + '/kategorikan';
    
    const modal = new bootstrap.Modal(document.getElementById('kategoriModal'));
    modal.show();
}

function applyFilter() {
    // Implementasi filter
    const form = document.getElementById('filterForm');
    const formData = new FormData(form);
    
    // Convert FormData to query string
    const params = new URLSearchParams(formData).toString();
    window.location.href = '/casemix/dashboard?' + params;
}
</script>
@endpush