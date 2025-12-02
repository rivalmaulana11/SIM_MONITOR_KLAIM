@extends('adminlte::page')

@section('title', 'Data E-Klaim BPJS')

@section('content_header')
    <h1><i class="fas fa-database"></i> Data E-Klaim BPJS</h1>
@stop

@section('content')

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="icon fas fa-check"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="icon fas fa-ban"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Statistics Cards --}}
    <div class="row mb-3">
        <div class="col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ number_format($statistics['total'] ?? 0) }}</h3>
                    <p>Total Data</p>
                </div>
                <div class="icon">
                    <i class="fas fa-database"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ number_format($statistics['bulan_ini'] ?? 0) }}</h3>
                    <p>Data Bulan Ini</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>Rp {{ number_format(($statistics['total_tarif_rs'] ?? 0) / 1000000, 0) }}jt</h3>
                    <p>Total Tarif RS</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hospital"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>Rp {{ number_format(($statistics['total_tarif_inacbg'] ?? 0) / 1000000, 0) }}jt</h3>
                    <p>Total Tarif INA-CBG</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter & Search Section --}}
    <div class="card card-primary card-outline mb-3">
        <div class="card-header" style="cursor: pointer;" id="filterToggle">
            <h3 class="card-title">
                <i class="fas fa-filter"></i> Filter & Pencarian Data
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" id="collapseBtn">
                    <i class="fas fa-plus" id="collapseIcon"></i>
                </button>
            </div>
        </div>
        
        <div id="filterBody" style="display: none;">
            <form action="{{ route('casemix.index') }}" method="GET" id="filterForm">
                <div class="card-body">
                    <div class="row">
                        {{-- Search --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><i class="fas fa-search"></i> Cari Data</label>
                                <input type="text" name="search" class="form-control" 
                                       placeholder="No SEP, No Kartu, Nama Pasien..." 
                                       value="{{ request('search') }}">
                                <small class="text-muted">Cari berdasarkan SEP, kartu, atau nama</small>
                            </div>
                        </div>

                        {{-- Filter Nama File --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><i class="fas fa-file"></i> Nama File Upload</label>
                                <select name="file_name" class="form-control">
                                    <option value="">-- Semua File --</option>
                                    @foreach($uploadedFiles as $file)
                                        <option value="{{ $file }}" {{ request('file_name') == $file ? 'selected' : '' }}>
                                            {{ $file }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Filter Status Rawat --}}
                        <div class="col-md-2">
                            <div class="form-group">
                                <label><i class="fas fa-hospital-user"></i> Status Rawat</label>
                                <select name="status_rawat" class="form-control">
                                    <option value="">-- Semua --</option>
                                    <option value="inap" {{ request('status_rawat') == 'inap' ? 'selected' : '' }}>Rawat Inap</option>
                                    <option value="jalan" {{ request('status_rawat') == 'jalan' ? 'selected' : '' }}>Rawat Jalan</option>
                                </select>
                            </div>
                        </div>

                        {{-- Filter Periode --}}
                        <div class="col-md-2">
                            <div class="form-group">
                                <label><i class="fas fa-calendar"></i> Dari Tanggal</label>
                                <input type="date" name="date_from" class="form-control" 
                                       value="{{ request('date_from') }}">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label><i class="fas fa-calendar"></i> Sampai Tanggal</label>
                                <input type="date" name="date_to" class="form-control" 
                                       value="{{ request('date_to') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Terapkan Filter
                    </button>
                    <a href="{{ route('casemix.index') }}" class="btn btn-secondary">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                    <span class="float-right text-muted">
                        @if(request()->hasAny(['search', 'file_name', 'status_rawat', 'date_from', 'date_to']))
                            <span class="badge badge-warning">
                                <i class="fas fa-info-circle"></i> 
                                {{ count(array_filter(request()->only(['search', 'file_name', 'status_rawat', 'date_from', 'date_to']))) }} filter aktif
                            </span>
                        @endif
                    </span>
                </div>
            </form>
        </div>
    </div>
{{-- Data Table --}}
    <div class="card" style="margin-top: 7px;">
        <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <h3 class="card-title text-white"><i class="fas fa-list"></i> Daftar Data E-Klaim</h3>
            <div class="card-tools">
                <a href="{{ route('casemix.upload') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-upload"></i> Upload Data Baru
                </a>
                
                @if($data->total() > 0)
                    <button type="button" class="btn btn-danger btn-sm ml-1" id="deleteAllBtn">
                        <i class="fas fa-trash-alt"></i> Hapus Semua Data
                    </button>
                @endif
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 40px;">No</th>
                            <th style="width: 140px;">No SEP</th>
                            <th style="width: 120px;">No Kartu</th>
                            <th style="width: 180px;">Nama Pasien</th>
                            <th style="width: 100px;">Tgl Masuk</th>
                            <th style="width: 100px;">Tgl Pulang</th>
                            <th style="width: 60px;">Kelas</th>
                            <th style="width: 100px;">Diagnosa</th>
                            <th style="width: 100px;">Grouper</th>
                            <th style="width: 110px;">Tarif RS</th>
                            <th style="width: 110px;">Tarif INA-CBG</th>
                            <th style="width: 90px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($data as $index => $item)
                            <tr>
                                <td class="text-center">{{ $data->firstItem() + $index }}</td>
                                <td><span class="badge badge-info badge-sm">{{ $item->sep ?? $item->no_sep ?? '-' }}</span></td>
                                <td>{{ $item->nokartu ?? $item->no_kartu ?? '-' }}</td>
                                <td>{{ $item->nama_pasien ?? '-' }}</td>
                                <td>{{ $item->admission_date ? \Carbon\Carbon::parse($item->admission_date)->format('d/m/Y') : '-' }}</td>
                                <td>{{ $item->discharge_date ? \Carbon\Carbon::parse($item->discharge_date)->format('d/m/Y') : '-' }}</td>
                                <td class="text-center">{{ $item->kelas_rawat ?? '-' }}</td>
                                <td>{{ $item->diaglist ?? '-' }}</td>
                                <td>{{ $item->inacbg ?? '-' }}</td>
                                <td class="text-right">{{ $item->tarif_rs ? 'Rp ' . number_format($item->tarif_rs, 0, ',', '.') : 'Rp 0' }}</td>
                                <td class="text-right">{{ $item->tarif_inacbg ? 'Rp ' . number_format($item->tarif_inacbg, 0, ',', '.') : 'Rp 0' }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-info btn-xs" data-toggle="modal"
                                        data-target="#detailModal{{ $item->id }}" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <button type="button" class="btn btn-danger btn-xs delete-btn"
                                        data-id="{{ $item->id }}" data-sep="{{ $item->sep ?? $item->no_sep }}" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-info-circle fa-2x mb-2"></i>
                                        <p class="mb-0">Belum ada data. Silakan upload file e-klaim.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination - Hanya di bawah tabel --}}
        @if($data->hasPages())
            <div class="card-footer">
                <div class="row align-items-center">
                    <div class="col-md-5 mb-2 mb-md-0">
                        <div class="pagination-info">
                            <i class="fas fa-info-circle text-primary"></i>
                            Menampilkan <strong class="text-primary">{{ $data->firstItem() }}</strong> 
                            sampai <strong class="text-primary">{{ $data->lastItem() }}</strong> 
                            dari <strong class="text-primary">{{ number_format($data->total()) }}</strong> data
                        </div>
                    </div>
                    
                    <div class="col-md-7">
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm justify-content-end mb-0">
                                {{-- Previous Page Link --}}
                                @if ($data->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">
                                            <i class="fas fa-angle-double-left"></i> Previous
                                        </span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $data->appends(request()->query())->previousPageUrl() }}" rel="prev">
                                            <i class="fas fa-angle-double-left"></i> Previous
                                        </a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @php
                                    $start = max($data->currentPage() - 2, 1);
                                    $end = min($start + 4, $data->lastPage());
                                    $start = max($end - 4, 1);
                                @endphp

                                {{-- First Page --}}
                                @if($start > 1)
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $data->appends(request()->query())->url(1) }}">1</a>
                                    </li>
                                    @if($start > 2)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif
                                @endif

                                {{-- Page Numbers --}}
                                @for ($i = $start; $i <= $end; $i++)
                                    @if ($i == $data->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $i }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $data->appends(request()->query())->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endif
                                @endfor

                                {{-- Last Page --}}
                                @if($end < $data->lastPage())
                                    @if($end < $data->lastPage() - 1)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $data->appends(request()->query())->url($data->lastPage()) }}">
                                            {{ $data->lastPage() }}
                                        </a>
                                    </li>
                                @endif

                                {{-- Next Page Link --}}
                                @if ($data->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $data->appends(request()->query())->nextPageUrl() }}" rel="next">
                                            Next <i class="fas fa-angle-double-right"></i>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">
                                            Next <i class="fas fa-angle-double-right"></i>
                                        </span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Hidden Form for Delete All --}}
    <form id="deleteAllForm" action="{{ route('casemix.deleteAll') }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    {{-- Detail Modals --}}
    @foreach($data as $item)
        <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title text-white">
                            <i class="fas fa-info-circle"></i> Detail E-Klaim - {{ $item->sep ?? $item->no_sep }}
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            {{-- Data Pasien --}}
                            <div class="col-md-6">
                                <div class="card card-outline card-primary mb-3">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0"><i class="fas fa-user"></i> Data Pasien</h6>
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table table-sm table-borderless mb-0">
                                            <tr>
                                                <th width="140">No SEP</th>
                                                <td>{{ $item->sep ?? $item->no_sep ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>No Kartu</th>
                                                <td>{{ $item->nokartu ?? $item->no_kartu ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Nama Pasien</th>
                                                <td><strong>{{ $item->nama_pasien ?? '-' }}</strong></td>
                                            </tr>
                                            <tr>
                                                <th>No MR</th>
                                                <td>{{ $item->mrn ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Lahir</th>
                                                <td>{{ $item->birth_date ? \Carbon\Carbon::parse($item->birth_date)->format('d/m/Y') : '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Umur</th>
                                                <td>{{ $item->umur_tahun ?? '-' }} Tahun {{ $item->umur_hari ? '(' . $item->umur_hari . ' hari)' : '' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Jenis Kelamin</th>
                                                <td>
                                                    @if($item->sex == '1')
                                                        <span class="badge badge-primary">Laki-laki</span>
                                                    @elseif($item->sex == '2')
                                                        <span class="badge badge-danger">Perempuan</span>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                {{-- Data Rawat Inap --}}
                                <div class="card card-outline card-primary mb-3">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0"><i class="fas fa-hospital"></i> Data Rawat Inap</h6>
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table table-sm table-borderless mb-0">
                                            <tr>
                                                <th width="140">Tanggal Masuk</th>
                                                <td>{{ $item->admission_date ? \Carbon\Carbon::parse($item->admission_date)->format('d/m/Y H:i') : '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Pulang</th>
                                                <td>{{ $item->discharge_date ? \Carbon\Carbon::parse($item->discharge_date)->format('d/m/Y H:i') : '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Lama Rawat (LOS)</th>
                                                <td><span class="badge badge-info">{{ $item->los ?? '0' }} Hari</span></td>
                                            </tr>
                                            <tr>
                                                <th>Kelas Rawat</th>
                                                <td>{{ $item->kelas_rawat ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status Pulang</th>
                                                <td>{{ $item->discharge_status ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>DPJP</th>
                                                <td>{{ $item->dpjp ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{-- Data Medis & Tarif --}}
                            <div class="col-md-6">
                                <div class="card card-outline card-success mb-3">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0"><i class="fas fa-stethoscope"></i> Data Medis</h6>
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table table-sm table-borderless mb-0">
                                            <tr>
                                                <th width="140">Diagnosa</th>
                                                <td>{{ $item->diaglist ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Prosedur</th>
                                                <td>{{ $item->proclist ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Grouper INA-CBG</th>
                                                <td><span class="badge badge-success">{{ $item->inacbg ?? '-' }}</span></td>
                                            </tr>
                                            <tr>
                                                <th>Deskripsi</th>
                                                <td>{{ $item->deskripsi_inacbg ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="card card-outline card-warning mb-3">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0"><i class="fas fa-money-bill-wave"></i> Rincian Tarif</h6>
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table table-sm table-borderless mb-0">
                                            <tr>
                                                <th width="140">Prosedur Non Bedah</th>
                                                <td class="text-right">Rp {{ number_format($item->prosedur_non_bedah ?? 0, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Prosedur Bedah</th>
                                                <td class="text-right">Rp {{ number_format($item->prosedur_bedah ?? 0, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Konsultasi</th>
                                                <td class="text-right">Rp {{ number_format($item->konsultasi ?? 0, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Keperawatan</th>
                                                <td class="text-right">Rp {{ number_format($item->keperawatan ?? 0, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Laboratorium</th>
                                                <td class="text-right">Rp {{ number_format($item->laboratorium ?? 0, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Radiologi</th>
                                                <td class="text-right">Rp {{ number_format($item->radiologi ?? 0, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Obat</th>
                                                <td class="text-right">Rp {{ number_format($item->obat ?? 0, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Alkes</th>
                                                <td class="text-right">Rp {{ number_format($item->alkes ?? 0, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <th>BMHP</th>
                                                <td class="text-right">Rp {{ number_format($item->bmhp ?? 0, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr class="border-top">
                                                <th>Tarif RS</th>
                                                <td class="text-right"><strong>Rp {{ number_format($item->tarif_rs ?? 0, 0, ',', '.') }}</strong></td>
                                            </tr>
                                            <tr class="bg-light">
                                                <th>Tarif INA-CBG</th>
                                                <td class="text-right"><strong class="text-success">Rp {{ number_format($item->tarif_inacbg ?? 0, 0, ',', '.') }}</strong></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Informasi Tambahan --}}
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-outline card-secondary mb-0">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0"><i class="fas fa-info-circle"></i> Informasi Tambahan</h6>
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table table-sm table-borderless mb-0">
                                            <tr>
                                                <th width="140">Kode RS</th>
                                                <td width="25%">{{ $item->kode_rs ?? '-' }}</td>
                                                <th width="140">Payor ID</th>
                                                <td>{{ $item->payor_id ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Coder ID</th>
                                                <td>{{ $item->coder_id ?? '-' }}</td>
                                                <th>Versi Grouper</th>
                                                <td>{{ $item->versi_grouper ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@stop

@section('css')
<style>
    /* Table Styles */
    .table {
        font-size: 12px;
    }
    
    .table thead th {
        font-size: 12px;
        font-weight: 600;
        vertical-align: middle;
        white-space: nowrap;
        padding: 10px 8px;
        border: 1px solid #dee2e6;
    }
    
    .table tbody td {
        vertical-align: middle;
        padding: 8px;
        white-space: nowrap;
        border: 1px solid #dee2e6;
    }
    
    /* Badge Styles */
    .badge-sm {
        font-size: 11px;
        padding: 4px 8px;
        font-weight: 500;
    }
    
    /* Button Styles */
    .btn-xs {
        padding: 3px 8px;
        font-size: 11px;
        line-height: 1.5;
    }
    
    /* Modal Styles */
    .modal-body .table th {
        font-weight: 600;
        color: #495057;
        padding: 8px 12px;
    }
    
    .modal-body .table td {
        padding: 8px 12px;
    }
    
    .card-outline {
        border-top-width: 3px;
    }
    
    .card-header {
        padding: 12px 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 8px 8px 0 0;
    }
    
    .card-header .card-title {
        color: white;
        font-weight: 600;
        font-size: 16px;
    }
    
    /* Card Improvements */
    .card {
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border: none;
        margin-bottom: 25px;
        margin-top: 20px;
        clear: both;
    }

    /* Ensure proper spacing */
    .content-wrapper > .content {
        padding-top: 20px;
    }

    /* Fix overlapping issue */
    .card + .card {
        margin-top: 25px;
    }
    
    /* Responsive Table */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    /* Sticky Header */
    @media (min-width: 768px) {
        .table thead th {
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #343a40 !important;
        }
    }
    
    /* Small Box Improvements */
    .small-box {
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
    }
    
    .small-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        z-index: 2;
    }
    
    .small-box h3 {
        font-size: 2rem;
        font-weight: bold;
    }
    
    /* Custom Pagination Styles */
    .pagination {
        margin: 0;
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }
    
    .page-item {
        margin: 0;
    }
    
    .page-link {
        border-radius: 6px;
        border: 1px solid #dee2e6;
        color: #667eea;
        font-weight: 500;
        padding: 6px 12px;
        transition: all 0.3s ease;
        min-width: 40px;
        text-align: center;
    }
    
    .page-link:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: #667eea;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
    }
    
    .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
        color: white;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        font-weight: 600;
    }
    
    .page-item.disabled .page-link {
        background-color: #f8f9fa;
        border-color: #dee2e6;
        color: #6c757d;
        cursor: not-allowed;
    }
    
    /* Card Footer Pagination Container */
    .card-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #e3e6f0;
        padding: 15px 20px;
        border-radius: 0 0 8px 8px;
    }
    
    /* Pagination Info Text */
    .pagination-info {
        color: #495057;
        font-size: 14px;
        font-weight: 500;
    }
    
    /* Alert Improvements */
    .alert {
        border-radius: 8px;
        border-left: 4px solid;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .alert-success {
        border-left-color: #28a745;
    }
    
    .alert-danger {
        border-left-color: #dc3545;
    }
    
    /* Button Improvements */
    .btn {
        border-radius: 6px;
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    /* Table Row Hover */
    .table tbody tr {
        transition: all 0.2s ease;
    }
    
    .table tbody tr:hover {
        background-color: #f8f9fa;
        transform: scale(1.01);
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    /* Action Buttons in Table */
    .btn-info, .btn-danger {
        transition: all 0.2s ease;
    }
    
    .btn-info:hover {
        background-color: #138496;
        border-color: #117a8b;
    }
    
    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }
    
    /* Smooth Page Transitions */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .card, .small-box {
        animation: fadeIn 0.5s ease-out;
    }
    
    /* Loading Animation for Pagination */
    .page-link {
        position: relative;
        overflow: hidden;
    }
    
    .page-link::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s;
    }
    
    .page-link:hover::before {
        left: 100%;
    }

    /* Filter collapse behavior */
    .collapse {
        display: none;
        overflow: hidden;
    }
    
    .collapse.show {
        display: block !important;
    }
    
    #filterBody {
        transition: all 0.3s ease-in-out;
    }

    #collapseIcon {
        transition: transform 0.3s ease;
    }
    
    /* Smooth rotation for icon */
    .fa-chevron-up {
        transform: rotate(0deg);
    }
    
    .fa-chevron-down {
        transform: rotate(0deg);
    }
    
    /* Filter Card Styles */
    .card-primary.card-outline {
        border-top: 3px solid #667eea;
        margin-top: 20px !important;
        margin-bottom: 20px !important;
    }

    .card-primary .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        color: white !important;
    }

    .card-primary .card-header .card-title {
        color: white !important;
    }

    .card-primary .card-header .btn-tool {
        color: white !important;
    }

    /* Clear space between elements */
    .row.mb-4 {
        margin-bottom: 2rem !important;
    }

    /* Form Styles */
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    /* Modal Header Custom */
    .modal-header.bg-info {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%) !important;
    }

    /* Print Styles */
    @media print {
        .btn, .card-tools, .modal, .pagination, .card-footer {
            display: none !important;
        }
    }
    
    /* Responsive Pagination */
    @media (max-width: 768px) {
        .page-link {
            padding: 5px 10px;
            font-size: 12px;
            min-width: 35px;
        }
        
        .pagination {
            justify-content: center;
        }
        
        .pagination-info {
            text-align: center;
            margin-bottom: 10px;
        }
    }

    @media (max-width: 576px) {
        .small-box h3 {
            font-size: 1.5rem;
        }
    }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Toggle Filter Panel with proper event handling
        $('#collapseBtn').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const filterBody = $('#filterBody');
            const icon = $('#collapseIcon');
            
            if (filterBody.hasClass('show')) {
                filterBody.removeClass('show').slideUp(300);
                icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
            } else {
                filterBody.addClass('show').slideDown(300);
                icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
            }
        });

        // Also allow clicking on header to toggle
        $('#filterHeader').on('click', function(e) {
            // Don't trigger if clicking the button itself
            if (!$(e.target).closest('#collapseBtn').length) {
                $('#collapseBtn').trigger('click');
            }
        });

        // Delete single data confirmation
        $('.delete-btn').on('click', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            const sep = $(this).data('sep');

            Swal.fire({
                title: 'Hapus Data?',
                html: `Yakin ingin menghapus data dengan No SEP <strong>${sep}</strong>?<br><small class="text-muted">Data yang dihapus tidak dapat dikembalikan.</small>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash"></i> Ya, Hapus!',
                cancelButtonText: '<i class="fas fa-times"></i> Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Menghapus...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Submit form
                    const form = $('<form>', {
                        method: 'POST',
                        action: `/eklaim/${id}`
                    });
                    form.append(`@csrf`);
                    form.append(`<input type="hidden" name="_method" value="DELETE">`);
                    $('body').append(form);
                    form.submit();
                }
            });
        });

        // Delete all data confirmation
        $('#deleteAllBtn').on('click', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Hapus SEMUA Data?',
                html: `
                    <div class="text-center">
                        <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                        <p class="mb-3"><strong>PERINGATAN!</strong></p>
                        <p>Anda akan menghapus <strong class="text-danger">SEMUA DATA E-KLAIM</strong> yang ada di database.</p>
                        <p class="text-danger"><strong>Tindakan ini tidak dapat dibatalkan!</strong></p>
                        <hr>
                        <p class="small text-muted">Ketik <strong>"HAPUS SEMUA"</strong> untuk konfirmasi:</p>
                    </div>
                `,
                icon: 'error',
                input: 'text',
                inputPlaceholder: 'Ketik: HAPUS SEMUA',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash-alt"></i> Ya, Hapus Semua!',
                cancelButtonText: '<i class="fas fa-times"></i> Batal',
                reverseButtons: true,
                inputValidator: (value) => {
                    if (!value || value.toUpperCase() !== 'HAPUS SEMUA') {
                        return 'Anda harus mengetik "HAPUS SEMUA" untuk konfirmasi!';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading with progress
                    Swal.fire({
                        title: 'Menghapus Semua Data...',
                        html: 'Mohon tunggu, proses sedang berjalan...<br><b></b>',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                            const b = Swal.getHtmlContainer().querySelector('b');
                            let timerInterval = setInterval(() => {
                                b.textContent = `${Math.floor(Math.random() * 100)}%`;
                            }, 100);
                        }
                    });

                    // Submit form
                    $('#deleteAllForm').submit();
                }
            });
        });

        // Auto hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);

        // Tooltip initialization
        $('[data-toggle="tooltip"]').tooltip();

        // Search with debounce
        let searchTimeout;
        $('input[name="search"]').on('keyup', function() {
            clearTimeout(searchTimeout);
            const searchValue = $(this).val();
            
            if (searchValue.length >= 3 || searchValue.length === 0) {
                searchTimeout = setTimeout(function() {
                    $('#filterForm').submit();
                }, 800);
            }
        });

        // Update filter count
        function updateFilterCount() {
            const activeFilters = $('#filterForm input, #filterForm select').filter(function() {
                return $(this).val() !== '' && $(this).attr('name');
            }).length;
            
            if (activeFilters > 0) {
                // Auto expand filter if there are active filters
                if (!$('#filterBody').hasClass('show')) {
                    $('#filterBody').addClass('show').show();
                    $('#collapseIcon').removeClass('fa-chevron-down').addClass('fa-chevron-up');
                }
                
                if ($('.filter-count-badge').length === 0) {
                    $('.card-tools').prepend(
                        `<span class="badge badge-warning mr-2 filter-count-badge">${activeFilters} filter aktif</span>`
                    );
                } else {
                    $('.filter-count-badge').text(`${activeFilters} filter aktif`);
                }
            } else {
                $('.filter-count-badge').remove();
            }
        }

        updateFilterCount();
    });
</script>
@stop