@extends('adminlte::page')

@section('title', 'Dashboard Keuangan - RSKK')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Dashboard Keuangan</h1>
      </div>
      {{-- <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('keuangan.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div> --}}
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">

    @if($uploadBaruHariIni > 0)
    <div class="alert alert-info alert-dismissible fade show shadow-sm" role="alert">
      <h5><i class="icon fas fa-info-circle"></i> Notifikasi Upload Baru!</h5>
      Casemix telah mengupload <strong>{{ $uploadBaruHariIni }}</strong> file hari ini. 
      Sistem telah otomatis generate surat pengajuan klaim. Silakan cek pada menu Surat Pengajuan.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @endif
    
    <div class="row">
      <div class="col-12 mb-4">
        <div class="card shadow-sm">
          <div class="card-header bg-gradient-info">
            <h3 class="card-title text-white">
              <i class="fas fa-filter mr-2"></i>Filter Laporan & Surat
            </h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <form action="#" method="GET" id="filterForm">
              <div class="row">
                <div class="col-md-4 mb-3">
                  <label for="namaFileInput">
                    <i class="fas fa-file-alt mr-1 text-primary"></i>
                    <strong>Nama File Upload dari Casemix</strong>
                  </label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fas fa-search"></i>
                      </span>
                    </div>
                    <input type="text" 
                            name="nama_file" 
                            id="namaFileInput"
                            class="form-control" 
                            placeholder="Cari nama file..." 
                            list="fileList">
                    <datalist id="fileList">
                      <option value="eklaim_januari_2024.xlsx">eklaim_januari_2024.xlsx (Upload: 15/01/2024)</option>
                      <option value="eklaim_februari_2024.xlsx">eklaim_februari_2024.xlsx (Upload: 14/02/2024)</option>
                      <option value="feedback_bpjs_jan2024.xlsx">feedback_bpjs_jan2024.xlsx (Upload: 20/01/2024)</option>
                      <option value="eklaim_maret_2024.xlsx">eklaim_maret_2024.xlsx (Upload: 15/03/2024)</option>
                      <option value="feedback_bpjs_feb2024.xlsx">feedback_bpjs_feb2024.xlsx (Upload: 22/02/2024)</option>
                    </datalist>
                    <div class="input-group-append">
                      <button type="button" class="btn btn-outline-secondary" onclick="clearFileFilter()">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <small class="text-muted">
                    <i class="fas fa-info-circle"></i> Ketik atau pilih dari daftar file yang pernah diupload
                  </small>
                </div>

                <div class="col-md-4 mb-3">
                  <label>
                    <i class="fas fa-calendar-alt mr-1 text-success"></i>
                    <strong>Periode Tanggal Upload</strong>
                  </label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fas fa-calendar"></i>
                      </span>
                    </div>
                    <input type="date" 
                            name="tanggal_mulai" 
                            class="form-control" 
                            placeholder="Dari tanggal"
                            value="{{ date('Y-m-01') }}">
                    <div class="input-group-append input-group-prepend">
                      <span class="input-group-text">s/d</span>
                    </div>
                    <input type="date" 
                            name="tanggal_akhir" 
                            class="form-control" 
                            placeholder="Sampai tanggal"
                            value="{{ date('Y-m-d') }}">
                  </div>
                  <small class="text-muted">
                    <i class="fas fa-info-circle"></i> Filter berdasarkan tanggal file diupload oleh Casemix
                  </small>
                </div>

                <div class="col-md-2 mb-3">
                  <label>
                    <i class="fas fa-tags mr-1 text-warning"></i>
                    <strong>Status Klaim</strong>
                  </label>
                  <select name="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="cair">✓ Cair</option>
                    <option value="pending">⏱ Pending</option>
                    <option value="tidak_layak">✗ Tidak Layak</option>
                  </select>
                  <small class="text-muted">
                    <i class="fas fa-info-circle"></i> Filter status
                  </small>
                </div>

                <div class="col-md-2 mb-3">
                  <label>&nbsp;</label>
                  <div class="d-grid gap-2">
                    <button type="button" class="btn btn-info btn-block mb-1" onclick="applyFilter()">
                      <i class="fas fa-search mr-1"></i> Filter
                    </button>
                    <button type="button" class="btn btn-secondary btn-block" onclick="resetFilter()">
                      <i class="fas fa-redo mr-1"></i> Reset
                    </button>
                  </div>
                </div>
              </div>

              <div class="collapse" id="advancedFilter">
                <hr class="border-info">
                <h6 class="text-info mb-3">
                  <i class="fas fa-sliders-h mr-2"></i>Filter Lanjutan
                </h6>
                <div class="row">
                  <div class="col-md-3 mb-3">
                    <label>
                      <i class="fas fa-file-signature mr-1"></i>Jenis Surat
                    </label>
                    <select name="jenis_surat" class="form-control">
                      <option value="">Semua Surat</option>
                      <option value="pengajuan">📄 Surat Pengajuan</option>
                      <option value="penerimaan">📋 Surat Penerimaan</option>
                    </select>
                  </div>

                  <div class="col-md-3 mb-3">
                    <label>
                      <i class="fas fa-hospital-user mr-1"></i>Jenis Rawat
                    </label>
                    <select name="jenis_rawat" class="form-control">
                      <option value="">Semua Jenis</option>
                      <option value="Rawat Inap">🏥 Rawat Inap</option>
                      <option value="Rawat Jalan">🚶 Rawat Jalan</option>
                    </select>
                  </div>

                  <div class="col-md-3 mb-3">
                    <label>
                      <i class="fas fa-user-check mr-1"></i>Diupload Oleh
                    </label>
                    <select name="uploaded_by" class="form-control">
                      <option value="">Semua User</option>
                      <option value="casemix1">👤 Casemix User 1</option>
                      <option value="casemix2">👤 Casemix User 2</option>
                      <option value="casemix3">👤 Casemix User 3</option>
                    </select>
                  </div>

                  <div class="col-md-3 mb-3">
                    <label>
                      <i class="fas fa-sort-amount-down mr-1"></i>Urutkan Berdasarkan
                    </label>
                    <select name="sort_by" class="form-control">
                      <option value="terbaru">🕐 Upload Terbaru</option>
                      <option value="terlama">🕑 Upload Terlama</option>
                      <option value="nilai_tertinggi">💰 Nilai Tertinggi</option>
                      <option value="nilai_terendah">💵 Nilai Terendah</option>
                      <option value="nama_file">📝 Nama File A-Z</option>
                    </select>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label>
                      <i class="fas fa-dollar-sign mr-1"></i>Range Nilai Klaim
                    </label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Rp</span>
                      </div>
                      <input type="number" name="nilai_min" class="form-control" placeholder="Nilai minimum">
                      <div class="input-group-append input-group-prepend">
                        <span class="input-group-text">s/d</span>
                      </div>
                      <div class="input-group-prepend">
                        <span class="input-group-text">Rp</span>
                      </div>
                      <input type="number" name="nilai_max" class="form-control" placeholder="Nilai maksimum">
                    </div>
                  </div>

                  <div class="col-md-6 mb-3">
                    <label>
                      <i class="fas fa-hashtag mr-1"></i>Nomor SEP
                    </label>
                    <input type="text" 
                            name="no_sep" 
                            class="form-control" 
                            placeholder="Cari berdasarkan nomor SEP...">
                  </div>
                </div>
              </div>

              <div class="text-center mt-3">
                <a class="btn btn-link btn-sm text-info" 
                    data-toggle="collapse" 
                    href="#advancedFilter" 
                    role="button" 
                    aria-expanded="false"
                    id="toggleAdvanced">
                  <i class="fas fa-chevron-down mr-1"></i> 
                  <strong>Tampilkan Filter Lanjutan</strong>
                </a>
              </div>
            </form>
          </div>

          <div class="card-footer bg-light" id="filterPreview" style="display: none;">
            <div class="row">
              <div class="col-md-12">
                <h6 class="text-primary mb-3">
                  <i class="fas fa-eye mr-2"></i>Preview Filter Aktif:
                </h6>
                <div id="activeFilters" class="d-flex flex-wrap">
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="row" id="filterResultCard" style="display: none;">
      <div class="col-12 mb-4">
        <div class="card shadow-sm">
          <div class="card-header bg-gradient-success">
            <h3 class="card-title text-white">
              <i class="fas fa-check-circle mr-2"></i>Hasil Filter
            </h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool text-white" onclick="closeFilterResult()">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="row text-center mb-3">
              <div class="col-md-3">
                <div class="border-right">
                  <h4 class="text-info"><i class="fas fa-database"></i> <span id="totalRecords">0</span></h4>
                  <p class="text-muted mb-0">Total Records</p>
                </div>
              </div>
              <div class="col-md-3">
                <div class="border-right">
                  <h4 class="text-success"><i class="fas fa-check-circle"></i> Rp <span id="totalCair">0</span></h4>
                  <p class="text-muted mb-0">Total Cair</p>
                </div>
              </div>
              <div class="col-md-3">
                <div class="border-right">
                  <h4 class="text-warning"><i class="fas fa-clock"></i> Rp <span id="totalPending">0</span></h4>
                  <p class="text-muted mb-0">Total Pending</p>
                </div>
              </div>
              <div class="col-md-3">
                <h4 class="text-danger"><i class="fas fa-times-circle"></i> Rp <span id="totalTidakLayak">0</span></h4>
                <p class="text-muted mb-0">Total Tidak Layak</p>
              </div>
            </div>
            <div class="text-center">
              <button class="btn btn-success mr-2">
                <i class="fas fa-file-excel mr-1"></i> Export Excel
              </button>
              <button class="btn btn-info mr-2">
                <i class="fas fa-print mr-1"></i> Print
              </button>
              <button class="btn btn-primary">
                <i class="fas fa-eye mr-1"></i> Lihat Detail
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card shadow-sm">
          <div class="card-header bg-gradient-primary">
            <h3 class="card-title text-white">
              <i class="fas fa-calculator mr-2"></i>Rekap Keuangan Klaim
            </h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box shadow-sm hover-effect">
                  <span class="info-box-icon bg-success elevation-2">
                    <i class="fas fa-check-circle"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text">Total Klaim Cair</span>
                    <span class="info-box-number">
                      Rp {{ number_format($totalKlaimCair, 0, ',', '.') }}
                    </span>
                    <small class="text-muted">{{ $jumlahKlaimCair }} Klaim</small>
                  </div>
                </div>
              </div>

              <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box shadow-sm hover-effect">
                  <span class="info-box-icon bg-warning elevation-2">
                    <i class="fas fa-clock"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text">Total Pending</span>
                    <span class="info-box-number">
                      Rp {{ number_format($totalKlaimPending, 0, ',', '.') }}
                    </span>
                    <small class="text-muted">{{ $jumlahKlaimPending }} Klaim</small>
                  </div>
                </div>
              </div>

              <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box shadow-sm hover-effect">
                  <span class="info-box-icon bg-danger elevation-2">
                    <i class="fas fa-times-circle"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text">Total Tidak Layak</span>
                    <span class="info-box-number">
                      Rp {{ number_format($totalKlaimTidakLayak, 0, ',', '.') }}
                    </span>
                    <small class="text-muted">{{ $jumlahKlaimTidakLayak }} Klaim</small>
                  </div>
                </div>
              </div>

              <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box shadow-sm hover-effect">
                  <span class="info-box-icon elevation-2 {{ $selisihBiaya >= 0 ? 'bg-primary' : 'bg-danger' }}">
                    <i class="fas {{ $selisihBiaya >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text">Selisih Biaya RS</span>
                    <span class="info-box-number {{ $selisihBiaya >= 0 ? 'text-primary' : 'text-danger' }}">
                      Rp {{ number_format(abs($selisihBiaya), 0, ',', '.') }}
                    </span>
                    <small class="text-muted">{{ $selisihBiaya >= 0 ? 'Untung' : 'Rugi' }}</small>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-4 col-md-6 col-12 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0">
              <i class="fas fa-file-signature mr-2"></i>Surat Pengajuan Klaim
            </h3>
          </div>
          <div class="card-body d-flex flex-column">
            <p class="text-muted mb-2">3 Surat yang dibuat otomatis sistem dari upload Casemix</p>
            <ul class="list-unstyled small text-muted mb-3">
              <li><i class="fas fa-check text-success"></i> Surat Pengantar</li>
              <li><i class="fas fa-check text-success"></i> BA Verifikasi</li>
              <li><i class="fas fa-check text-success"></i> Surat Rincian</li>
            </ul>
            <div class="mt-auto">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <small class="text-muted">Surat Tersedia</small>
                <span class="badge badge-primary badge-pill">{{ $totalSuratPengajuan }}</span>
              </div>
              <a href="{{ route('keuangan.surat-pengajuan') }}" class="btn btn-primary btn-block">
                <i class="fas fa-folder-open mr-2"></i>Kelola Surat Pengajuan
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6 col-12 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-header bg-success text-white">
            <h3 class="card-title mb-0">
              <i class="fas fa-file-invoice mr-2"></i>Surat Penerimaan Klaim
            </h3>
          </div>
          <div class="card-body d-flex flex-column">
            <p class="text-muted mb-2">2 Surat yang dibuat otomatis setelah feedback BPJS</p>
            <ul class="list-unstyled small text-muted mb-3">
              <li><i class="fas fa-check text-success"></i> Surat Penerimaan Cair</li>
              <li><i class="fas fa-check text-success"></i> Surat Penerimaan Tidak Layak</li>
            </ul>
            <div class="mt-auto">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <small class="text-muted">Surat Tersedia</small>
                <span class="badge badge-success badge-pill">{{ $totalSuratPenerimaan }}</span>
              </div>
              <a href="{{ route('keuangan.surat-penerimaan') }}" class="btn btn-success btn-block">
                <i class="fas fa-folder-open mr-2"></i>Kelola Surat Penerimaan
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6 col-12 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-header text-white" style="background-color: #6f42c1;">
            <h3 class="card-title mb-0">
              <i class="fas fa-tasks mr-2"></i>Verifikasi & Arsip
            </h3>
          </div>
          <div class="card-body d-flex flex-column">
            <p class="text-muted mb-2">Kelola status dan arsipkan surat klaim</p>
            <ul class="list-unstyled small text-muted mb-3">
              <li><i class="fas fa-check text-success"></i> Tandai surat diterima</li>
              <li><i class="fas fa-check text-success"></i> Arsipkan surat</li>
              <li><i class="fas fa-check text-success"></i> Catatan internal</li>
            </ul>
            <div class="mt-auto">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <small class="text-muted">Surat Diverifikasi</small>
                <span class="badge badge-pill" style="background-color: #6f42c1; color: white;">{{ $totalSuratDiverifikasi }}</span>
              </div>
              <a href="{{ route('keuangan.verifikasi-arsip') }}" class="btn btn-block text-white" style="background-color: #6f42c1;">
                <i class="fas fa-clipboard-check mr-2"></i>Kelola Verifikasi
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-8 mb-4">
        <div class="card shadow-sm">
          <div class="card-header border-0">
            <div class="d-flex justify-content-between">
              <h3 class="card-title">
                <i class="fas fa-chart-area mr-2"></i>Statistik Klaim Bulanan
              </h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="card-body">
            <canvas id="klaimChart" style="height: 300px; max-height: 300px;"></canvas>
          </div>
        </div>
      </div>

      <div class="col-lg-4 mb-4">
        <div class="card shadow-sm">
          <div class="card-header border-0">
            <h3 class="card-title">
              <i class="fas fa-bell mr-2"></i>Notifikasi & Aktivitas
            </h3>
          </div>
          <div class="card-body pt-0">
            <div class="timeline timeline-inverse">
              <div class="time-label">
                <span class="bg-danger">Hari Ini</span>
              </div>
              
              <div>
                <i class="fas fa-upload bg-info"></i>
                <div class="timeline-item">
                  <span class="time">
                    <i class="far fa-clock"></i> 2 jam yang lalu
                  </span>
                  <h3 class="timeline-header">
                    <a href="#">Upload Baru dari Casemix</a> <span class="badge badge-info">Baru</span>
                  </h3>
                  <div class="timeline-body">
                    Casemix telah upload file pengajuan klaim. Sistem otomatis generate 3 surat pengajuan.
                  </div>
                  <div class="timeline-footer">
                    <a href="{{ route('keuangan.surat-pengajuan') }}" class="btn btn-primary btn-sm">Lihat Surat</a>
                  </div>
                </div>
              </div>
              
              <div>
                <i class="fas fa-check bg-success"></i>
                <div class="timeline-item">
                  <span class="time">
                    <i class="far fa-clock"></i> 5 jam yang lalu
                  </span>
                  <h3 class="timeline-header">
                    <a href="#">Feedback BPJS Diterima</a>
                  </h3>
                  <div class="timeline-body">
                    Casemix upload feedback BPJS. Sistem otomatis generate 2 surat penerimaan dan update status klaim.
                  </div>
                  <div class="timeline-footer">
                    <a href="{{ route('keuangan.surat-penerimaan') }}" class="btn btn-success btn-sm">Lihat Surat</a>
                  </div>
                </div>
              </div>

              <div>
                <i class="fas fa-archive bg-warning"></i>
                <div class="timeline-item">
                  <span class="time">
                    <i class="far fa-clock"></i> 1 hari yang lalu
                  </span>
                  <h3 class="timeline-header">
                    <a href="#">Surat Diarsipkan</a>
                  </h3>
                  <div class="timeline-body">
                    15 surat pengajuan klaim telah diarsipkan ke sistem.
                  </div>
                </div>
              </div>
              
              <div>
                <i class="far fa-clock bg-gray"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    /* --- EFEK HOVER & SHADOW UMUM --- */
    .card, .info-box {
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        border-radius: 10px; /* Sudut lebih membulat */
        border: none;
    }
    
    .card:hover, .info-box:hover {
        transform: translateY(-3px); /* Hover lebih terasa */
        box-shadow: 0 10px 20px rgba(0,0,0,0.12), 
                    0 6px 6px rgba(0,0,0,0.08) !important;
    }

    /* --- INFO BOX KHUSUS --- */
    .info-box {
        box-shadow: 0 4px 6px rgba(0,0,0,0.1) !important; /* Shadow lebih halus */
    }
    .info-box-icon {
        border-radius: 8px 0 0 8px; /* Sudut membulat hanya di kiri */
        opacity: 0.9;
    }
    .info-box-content {
        padding: 10px;
    }
    .info-box-text {
        font-weight: 600;
    }
    .info-box-number {
        font-size: 1.5rem;
        font-weight: 700;
    }
    
    /* --- CARD KHUSUS --- */
    .card-header {
        border-radius: 10px 10px 0 0;
        border-bottom: none;
    }
    /* Warna gradien yang sedikit lebih modern untuk header */
    .card-header.bg-gradient-info {
        background-image: linear-gradient(to right, #17a2b8, #1a94aa);
    }
    .card-header.bg-gradient-success {
        background-image: linear-gradient(to right, #28a745, #1e9238);
    }
    .card-header.bg-gradient-primary {
        background-image: linear-gradient(to right, #007bff, #0069d9);
    }

    /* --- ALERT NOTIFIKASI BARU --- */
    .alert-info.shadow-sm {
        border-left: 5px solid #117a8b; /* Border kiri tebal */
        background-color: #d1ecf1;
        color: #0c5460;
        border-radius: 10px;
    }
    .alert-info .close {
        color: #0c5460;
    }

    /* --- FILTER FORM STYLES --- */
    #filterForm label {
        font-weight: 600;
        color: #343a40; /* Lebih gelap */
        display: block; /* Memastikan label mengambil baris penuh */
        margin-bottom: 0.5rem;
    }
    
    #filterForm .form-control {
        border-radius: 6px;
    }

    #filterForm .input-group-text {
        border-radius: 6px 0 0 6px;
        background-color: #e9ecef;
    }
    
    #filterForm .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    /* Tombol Filter Lanjutan */
    #toggleAdvanced {
        font-weight: 700 !important;
        text-decoration: none;
    }
    
    /* --- PREVIEW FILTER AKTIF --- */
    #activeFilters .badge {
        font-size: 0.85rem;
        cursor: default;
        padding: 0.5rem 0.75rem;
        border-radius: 20px; /* Lebih bulat seperti pil */
        font-weight: 500;
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
    }
    #activeFilters .badge-primary {
        background-color: #007bff;
        color: white;
    }
    #activeFilters .badge button {
        color: white !important;
        opacity: 0.8;
        padding: 0;
        margin-left: 5px;
        line-height: 1;
    }

    /* --- HASIL FILTER STATS --- */
    #filterResultCard .border-right {
        border-right: 2px solid #adb5bd; /* Warna border yang lebih solid */
        padding-right: 15px;
    }
    #filterResultCard h4 {
        font-size: 1.8rem;
        margin-bottom: 5px;
    }

    /* --- STATISTIK & NOTIFIKASI --- */
    .timeline-item {
        border-radius: 8px;
        margin-bottom: 10px;
        border: 1px solid #e9ecef;
    }
    .timeline-header a {
        font-weight: 600;
    }
    
    /* Media Query for responsiveness */
    @media (max-width: 768px) {
        #filterResultCard .border-right {
            border-right: none;
            border-bottom: 2px solid #e9ecef;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
<script>
  // ... (Kode ChartJS Anda) ...
  $(function() {
    // Chart Configuration (existing code)
    var ctx = document.getElementById('klaimChart').getContext('2d');
    var klaimChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        datasets: [{
          label: 'Klaim Cair',
          data: [120000000, 150000000, 180000000, 145000000, 190000000, 200000000, 175000000, 210000000, 195000000, 220000000, 180000000, 150000000],
          backgroundColor: 'rgba(40, 167, 69, 0.1)',
          borderColor: 'rgba(40, 167, 69, 1)',
          borderWidth: 3,
          fill: true,
          tension: 0.4,
          pointRadius: 4,
          pointHoverRadius: 6
        }, {
          label: 'Klaim Pending',
          data: [80000000, 65000000, 90000000, 75000000, 85000000, 70000000, 95000000, 80000000, 75000000, 85000000, 90000000, 75000000],
          backgroundColor: 'rgba(255, 193, 7, 0.1)',
          borderColor: 'rgba(255, 193, 7, 1)',
          borderWidth: 3,
          fill: true,
          tension: 0.4,
          pointRadius: 4,
          pointHoverRadius: 6
        }, {
          label: 'Tidak Layak',
          data: [20000000, 15000000, 25000000, 18000000, 22000000, 19000000, 28000000, 23000000, 21000000, 26000000, 24000000, 25000000],
          backgroundColor: 'rgba(220, 53, 69, 0.1)',
          borderColor: 'rgba(220, 53, 69, 1)',
          borderWidth: 3,
          fill: true,
          tension: 0.4,
          pointRadius: 4,
          pointHoverRadius: 6
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: true,
            position: 'top',
          },
          tooltip: {
            mode: 'index',
            intersect: false,
            callbacks: {
              label: function(context) {
                let label = context.dataset.label || '';
                if (label) {
                  label += ': ';
                }
                if (context.parsed.y !== null) {
                  label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                }
                return label;
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return 'Rp ' + (value / 1000000) + 'M';
              }
            }
          }
        },
        interaction: {
          mode: 'nearest',
          axis: 'x',
          intersect: false
        }
      }
    });

    // ===== FILTER FUNCTIONS =====
    
    // Toggle icon filter lanjutan
    $('#advancedFilter').on('shown.bs.collapse', function () {
      $('#toggleAdvanced').html('<i class="fas fa-chevron-up mr-1"></i> <strong>Sembunyikan Filter Lanjutan</strong>');
    });

    $('#advancedFilter').on('hidden.bs.collapse', function () {
      $('#toggleAdvanced').html('<i class="fas fa-chevron-down mr-1"></i> <strong>Tampilkan Filter Lanjutan</strong>');
    });

  });

  // Clear file filter
  function clearFileFilter() {
    $('#namaFileInput').val('');
    updateFilterPreview();
  }

  // Reset all filters
  function resetFilter() {
    $('#filterForm')[0].reset();
    // Mengatur ulang nilai tanggal ke default awal bulan dan hari ini
    $('input[name="tanggal_mulai"]').val('{{ date('Y-m-01') }}'); 
    $('input[name="tanggal_akhir"]').val('{{ date('Y-m-d') }}');
    $('#filterPreview').hide();
    $('#activeFilters').empty();
    $('#filterResultCard').hide();
    
    // Show success message
    Swal.fire({
      icon: 'success',
      title: 'Filter Direset!',
      text: 'Semua filter telah dikembalikan ke nilai default.',
      timer: 2000,
      showConfirmButton: false
    });
  }

  // Close filter result card
  function closeFilterResult() {
    $('#filterResultCard').fadeOut();
  }

  // Apply filter (demo)
  function applyFilter() {
    // Collect form data (for potential API submission)
    const formData = $('#filterForm').serializeArray();
    
    // Update filter preview
    updateFilterPreview(formData);

    // Show loading
    Swal.fire({
      title: 'Memproses Filter...',
      html: 'Mencari data sesuai kriteria filter',
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      }
    });

    // Simulate API call
    setTimeout(function() {
      Swal.close();
      
      // Show result card
      $('#filterResultCard').fadeIn();
      
      // Populate with dummy data
      $('#totalRecords').text('150');
      $('#totalCair').text('250.000.000');
      $('#totalPending').text('75.000.000');
      $('#totalTidakLayak').text('25.000.000');

      // Show success notification
      Swal.fire({
        icon: 'success',
        title: 'Filter Berhasil!',
        html: 'Ditemukan <strong>150 records</strong> sesuai kriteria filter.',
        timer: 3000,
        showConfirmButton: false
      });

      // Scroll to result
      $('html, body').animate({
        scrollTop: $('#filterResultCard').offset().top - 100
      }, 1000);
    }, 1500);
  }

  // Update filter preview
  function updateFilterPreview(formData = $('#filterForm').serializeArray()) {
    const filters = [];
    const formMap = new Map(formData.map(i => [i.name, i.value]));
    
    // Nama File
    const namaFile = formMap.get('nama_file');
    if (namaFile) {
      filters.push(`<span class="badge badge-primary mr-2 mb-2 p-2"><i class="fas fa-file mr-1"></i> File: ${namaFile} <button type="button" class="btn btn-xs ml-2" onclick="clearSpecificFilter('nama_file')" style="background: none; border: none; color: white;"><i class="fas fa-times"></i></button></span>`);
    }

    // Periode Tanggal Upload
    const tanggalMulai = formMap.get('tanggal_mulai');
    const tanggalAkhir = formMap.get('tanggal_akhir');
    if (tanggalMulai && tanggalAkhir) {
      filters.push(`<span class="badge badge-success mr-2 mb-2 p-2"><i class="fas fa-calendar mr-1"></i> Upload: ${tanggalMulai} s/d ${tanggalAkhir}</span>`);
    }

    // Status Klaim
    const status = formMap.get('status');
    const statusText = $('select[name="status"] option:selected').text();
    if (status) {
      const statusClass = status === 'cair' ? 'success' : (status === 'pending' ? 'warning' : 'danger');
      filters.push(`<span class="badge badge-${statusClass} mr-2 mb-2 p-2"><i class="fas fa-tag mr-1"></i> Status: ${statusText}</span>`);
    }

    // Advanced Filters
    const jenisSurat = formMap.get('jenis_surat');
    if (jenisSurat) {
      filters.push(`<span class="badge badge-secondary mr-2 mb-2 p-2"><i class="fas fa-file-signature mr-1"></i> Jenis Surat: ${$('select[name="jenis_surat"] option:selected').text().trim()}</span>`);
    }

    const jenisRawat = formMap.get('jenis_rawat');
    if (jenisRawat) {
      filters.push(`<span class="badge badge-secondary mr-2 mb-2 p-2"><i class="fas fa-hospital-user mr-1"></i> Jenis Rawat: ${jenisRawat}</span>`);
    }

    const uploadedBy = formMap.get('uploaded_by');
    if (uploadedBy) {
      filters.push(`<span class="badge badge-secondary mr-2 mb-2 p-2"><i class="fas fa-user-check mr-1"></i> Oleh: ${$('select[name="uploaded_by"] option:selected').text().trim()}</span>`);
    }
    
    const nilaiMin = formMap.get('nilai_min');
    const nilaiMax = formMap.get('nilai_max');
    if (nilaiMin || nilaiMax) {
      let rangeText = 'Nilai Klaim: ';
      if (nilaiMin) rangeText += `Min Rp${parseInt(nilaiMin).toLocaleString('id-ID')}`;
      if (nilaiMin && nilaiMax) rangeText += ' s/d ';
      if (nilaiMax) rangeText += `Max Rp${parseInt(nilaiMax).toLocaleString('id-ID')}`;
      filters.push(`<span class="badge badge-secondary mr-2 mb-2 p-2"><i class="fas fa-dollar-sign mr-1"></i> ${rangeText}</span>`);
    }

    const noSep = formMap.get('no_sep');
    if (noSep) {
      filters.push(`<span class="badge badge-secondary mr-2 mb-2 p-2"><i class="fas fa-hashtag mr-1"></i> No. SEP: ${noSep}</span>`);
    }


    $('#activeFilters').html(filters.join(''));
    if (filters.length > 0) {
      $('#filterPreview').slideDown();
    } else {
      $('#filterPreview').slideUp();
    }
  }

  // Clear specific filter field (used in preview badge)
  function clearSpecificFilter(name) {
    $(`[name="${name}"]`).val('');
    // For date inputs, reset to default range
    if (name === 'tanggal_mulai') {
      $('input[name="tanggal_mulai"]').val('{{ date('Y-m-01') }}');
    }
    if (name === 'tanggal_akhir') {
      $('input[name="tanggal_akhir"]').val('{{ date('Y-m-d') }}');
    }
    
    // Rerun applyFilter to update the preview and results (optional, depending on UX choice)
    applyFilter();
  }
</script>
@endpush