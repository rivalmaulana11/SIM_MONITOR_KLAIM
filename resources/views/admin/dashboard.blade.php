@extends('adminlte::page')

@section('title', 'Dashboard Admin')

@section('content')
<!--begin::App Content Header-->
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Dashboard</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
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
        <!--begin::Row-->
        <div class="row">
            <!--begin::Col - Klaim Cair-->
            <div class="col-lg-3 col-6">
                <div class="small-box text-bg-success">
                    <div class="inner">
                        <h3>{{ $klaimCair }}</h3>
                        <p>Klaim Cair</p>
                        <small class="d-block mt-2">{{ $totalNilaiCair > 0 ? 'Rp ' . number_format($totalNilaiCair, 0, ',', '.') : 'Rp 0' }}</small>
                    </div>
                    <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 01-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004zM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 01-.921.42z"></path>
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v.816a3.836 3.836 0 00-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 01-.921-.421l-.879-.66a.75.75 0 00-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 001.5 0v-.81a4.124 4.124 0 001.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 00-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 00.933-1.175l-.415-.33a3.836 3.836 0 00-1.719-.755V6z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                        More info <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
            </div>
            <!--end::Col-->

            <!--begin::Col - Klaim Pending-->
            <div class="col-lg-3 col-6">
                <div class="small-box text-bg-warning">
                    <div class="inner">
                        <h3>{{ $klaimPending }}</h3>
                        <p>Klaim Pending</p>
                        <small class="d-block mt-2">{{ $totalNilaiPending > 0 ? 'Rp ' . number_format($totalNilaiPending, 0, ',', '.') : 'Rp 0' }}</small>
                    </div>
                    <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="#" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                        More info <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
            </div>
            <!--end::Col-->

            <!--begin::Col - Tidak Layak-->
            <div class="col-lg-3 col-6">
                <div class="small-box text-bg-danger">
                    <div class="inner">
                        <h3>{{ $klaimTidakLayak }}</h3>
                        <p>Tidak Layak</p>
                        <small class="d-block mt-2">{{ $totalNilaiTidakLayak > 0 ? 'Rp ' . number_format($totalNilaiTidakLayak, 0, ',', '.') : 'Rp 0' }}</small>
                    </div>
                    <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                        More info <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
            </div>
            <!--end::Col-->

            <!--begin::Col - Total Klaim-->
            <div class="col-lg-3 col-6">
                <div class="small-box text-bg-primary">
                    <div class="inner">
                        <h3>{{ $totalKlaim }}</h3>
                        <p>Total Klaim</p>
                        <small class="d-block mt-2 text-white">
                            @if($totalSelisih >= 0)
                                +Rp {{ number_format($totalSelisih, 0, ',', '.') }}
                            @else
                                -Rp {{ number_format(abs($totalSelisih), 0, ',', '.') }}
                            @endif
                        </small>
                    </div>
                    <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z"></path>
                    </svg>
                    <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                        More info <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->

        <!--begin::Row-->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-7 connectedSortable">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title"><i class="bi bi-bar-chart-fill me-1"></i> Grafik Klaim per Periode</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="barChart" style="height: 300px;"></div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.Start col -->

            <!-- Start col -->
            <div class="col-lg-5 connectedSortable">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title"><i class="bi bi-pie-chart-fill me-1"></i> Distribusi Status Klaim</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="donutChart" style="height: 300px;"></div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.Start col -->
        </div>
        <!-- /.row (main row) -->

        <!-- Table Row -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title"><i class="bi bi-table me-1"></i> Data Klaim E-KLAIM</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary me-1" data-bs-toggle="modal" data-bs-target="#filterModal">
                                <i class="bi bi-funnel"></i> Filter
                            </button>
                            <button type="button" class="btn btn-sm btn-success" onclick="exportExcel()">
                                <i class="bi bi-file-earmark-excel"></i> Export Excel
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
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
                                    <th class="text-end">Selisih</th>
                                    <th style="width: 100px;">Status</th>
                                    <th style="width: 120px;">Aksi</th>
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
                                    <td class="text-end">
                                        @if($klaim->selisih >= 0)
                                            <small class="text-success fw-bold">{{ $klaim->selisih_format }}</small>
                                        @else
                                            <small class="text-danger fw-bold">{{ $klaim->selisih_format }}</small>
                                        @endif
                                    </td>
                                    <td>{!! $klaim->status_badge !!}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" class="btn btn-info" onclick="detailKlaim({{ $klaim->id }})" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-primary" onclick="editKlaim({{ $klaim->id }})" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="13" class="text-center">Tidak ada data klaim</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!--end::Container-->
</div>
<!--end::App Content-->

<!-- Filter Modal -->
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
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="">Semua Status</option>
                            <option value="cair">Cair</option>
                            <option value="pending">Pending</option>
                            <option value="tidak_layak">Tidak Layak</option>
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
@endsection

@push('styles')
<style>
    .small-box .inner h3 {
        font-size: 2.5rem;
        font-weight: bold;
    }
    .small-box .inner small {
        font-size: 0.875rem;
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
<!-- sortablejs -->
<script src="{{ asset('AdminLTE-master/https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js')}}" crossorigin="anonymous"></script>

<!-- apexcharts -->
<script src="{{ asset('AdminLTE-master/https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js')}}" crossorigin="anonymous"></script>

<script>
$(function () {
    // Sortable cards
    const sortable = new Sortable(document.querySelector('.connectedSortable'), {
        group: 'shared',
        handle: '.card-header',
    });

    const cardHeaders = document.querySelectorAll('.connectedSortable .card-header');
    cardHeaders.forEach((cardHeader) => {
        cardHeader.style.cursor = 'move';
    });

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

    // ============================================
    // BAR CHART - Klaim per Periode
    // ============================================
    const chartData = @json($klaimPerBulan);
    const labels = chartData.map(item => item.periode);
    const dataCair = chartData.map(item => item.cair);
    const dataPending = chartData.map(item => item.pending);
    const dataTidakLayak = chartData.map(item => item.tidak_layak);

    const barChartOptions = {
        series: [
            {
                name: 'Cair',
                data: dataCair
            },
            {
                name: 'Pending',
                data: dataPending
            },
            {
                name: 'Tidak Layak',
                data: dataTidakLayak
            }
        ],
        chart: {
            type: 'bar',
            height: 300,
            toolbar: {
                show: false
            }
        },
        colors: ['#28a745', '#ffc107', '#dc3545'],
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: labels
        },
        yaxis: {
            title: {
                text: 'Jumlah Klaim'
            }
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + " klaim"
                }
            }
        }
    };

    const barChart = new ApexCharts(document.querySelector("#barChart"), barChartOptions);
    barChart.render();

    // ============================================
    // DONUT CHART - Status Distribution
    // ============================================
    const donutChartOptions = {
        series: [{{ $klaimCair }}, {{ $klaimPending }}, {{ $klaimTidakLayak }}],
        chart: {
            type: 'donut',
            height: 300
        },
        labels: ['Cair', 'Pending', 'Tidak Layak'],
        colors: ['#28a745', '#ffc107', '#dc3545'],
        legend: {
            position: 'bottom'
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };

    const donutChart = new ApexCharts(document.querySelector("#donutChart"), donutChartOptions);
    donutChart.render();
});

function detailKlaim(id) {
    alert('Detail klaim ID: ' + id + ' - Fitur akan dikembangkan');
}

function editKlaim(id) {
    alert('Edit klaim ID: ' + id + ' - Fitur akan dikembangkan');
}

function applyFilter() {
    alert('Filter akan diterapkan');
    const modal = bootstrap.Modal.getInstance(document.getElementById('filterModal'));
    modal.hide();
}

function exportExcel() {
    alert('Export Excel - Fitur akan dikembangkan');
}
</script>
@endpush