@extends('adminlte::page')

@section('title', 'Upload E-Klaim BPJS')

@section('content_header')
    <h1><i class="fas fa-upload"></i> Upload E-Klaim BPJS</h1>
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
    
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="icon fas fa-exclamation-triangle"></i>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    {{-- Upload Result --}}
    @if(session('upload_result'))
        @php $result = session('upload_result'); @endphp
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-check-circle"></i> Hasil Upload</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="info-box bg-success">
                            <span class="info-box-icon"><i class="fas fa-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Data Berhasil</span>
                                <span class="info-box-number">{{ $result['success'] ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="info-box bg-warning">
                            <span class="info-box-icon"><i class="fas fa-copy"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Data Duplikat</span>
                                <span class="info-box-number">{{ $result['duplicate'] ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="info-box bg-danger">
                            <span class="info-box-icon"><i class="fas fa-times"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Data Gagal</span>
                                <span class="info-box-number">{{ $result['failed'] ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if(!empty($result['errors']))
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Detail Error:</h5>
                        <ul>
                            @foreach($result['errors'] as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    @endif
    
    {{-- Upload Form --}}
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-file-upload"></i> Upload File E-Klaim</h3>
        </div>
        
        <form action="{{ route('casemix.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
            @csrf
            
            <div class="card-body">
                {{-- Jenis Layanan --}}
                <div class="form-group">
                    <label for="jenis_layanan">Jenis Layanan</label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="rawat_jalan" name="jenis_layanan" value="rawat_jalan" checked>
                                <label for="rawat_jalan" class="custom-control-label">
                                    <i class="fas fa-user-md"></i> Rawat Jalan
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="rawat_inap" name="jenis_layanan" value="rawat_inap">
                                <label for="rawat_inap" class="custom-control-label">
                                    <i class="fas fa-hospital"></i> Rawat Inap
                                </label>
                            </div>
                        </div>
                    </div>
                    @error('jenis_layanan')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>
                
                {{-- Periode Upload --}}
                <div class="form-group">
                    <label for="periode">Periode Upload</label>
                    <div class="row">
                        <div class="col-md-6">
                            <select class="form-control @error('periode') is-invalid @enderror" id="bulan" name="bulan" required>
                                <option value="">Pilih Bulan</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control @error('periode') is-invalid @enderror" id="tahun" name="tahun" required>
                                <option value="">Pilih Tahun</option>
                                @php
                                    $currentYear = date('Y');
                                    for ($year = $currentYear - 2; $year <= $currentYear + 2; $year++) {
                                        echo "<option value=\"$year\">$year</option>";
                                    }
                                @endphp
                            </select>
                        </div>
                    </div>
                    <input type="hidden" id="periode" name="periode" value="">
                    <small class="form-text text-muted">Pilih bulan dan tahun untuk klaim yang akan diupload</small>
                    @error('periode')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="file">Pilih File Excel atau TXT</label>
                    <div class="custom-file">
                        <input type="file" 
                               class="custom-file-input @error('file') is-invalid @enderror" 
                               id="file" 
                               name="file" 
                               accept=".xlsx,.xls,.txt"
                               required>
                        <label class="custom-file-label" for="file" id="fileLabel">Pilih file Excel atau TXT...</label>
                        @error('file')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <small class="form-text text-muted">
                        Format: .xlsx, .xls, atau .txt (maksimal 20MB)
                    </small>
                </div>
                
                <div id="filePreview" class="alert alert-info" style="display: none;">
                    <h5><i class="icon fas fa-info-circle"></i> Info File:</h5>
                    <p class="mb-1"><strong>Nama:</strong> <span id="fileName"></span></p>
                    <p class="mb-1"><strong>Ukuran:</strong> <span id="fileSize"></span></p>
                    <p class="mb-1"><strong>Tipe:</strong> <span id="fileType"></span></p>
                    <p class="mb-1"><strong>Jenis Layanan:</strong> <span id="jenisLayanan" class="badge badge-primary"></span></p>
                    <p class="mb-1"><strong>Periode:</strong> <span id="periodeInfo" class="badge badge-info"></span></p>
                    <p class="mb-0"><strong>Format:</strong> <span id="fileFormat" class="badge badge-primary"></span></p>
                </div>
            </div>
            
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="fas fa-upload"></i> Upload & Import Data
                </button>
                <a href="{{ route('casemix.index') }}" class="btn btn-secondary">
                    <i class="fas fa-list"></i> Lihat Data
                </a>
            </div>
        </form>
    </div>
    
    {{-- Info Box --}}
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-info-circle"></i> Informasi Format File</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        
        <div class="card-body">
            {{-- Tabs for different file formats --}}
            <ul class="nav nav-tabs" id="formatTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="excel-tab" data-toggle="tab" href="#excel" role="tab">
                        <i class="fas fa-file-excel"></i> Format Excel
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="txt-tab" data-toggle="tab" href="#txt" role="tab">
                        <i class="fas fa-file-alt"></i> Format TXT
                    </a>
                </li>
            </ul>

            <div class="tab-content mt-3" id="formatTabContent">
                {{-- Excel Format Tab --}}
                <div class="tab-pane fade show active" id="excel" role="tabpanel">
                    <div class="alert alert-info">
                        <h5><i class="fas fa-lightbulb"></i> Penting untuk File Excel!</h5>
                        <ul class="mb-0">
                            <li>File harus berformat <strong>.xlsx</strong> atau <strong>.xls</strong></li>
                            <li><strong>Baris pertama HARUS HEADER</strong> dengan nama kolom</li>
                            <li>Harus ada kolom dengan nama <strong>"SEP"</strong> (NO SEP adalah kolom wajib)</li>
                            <li>Sistem akan otomatis mendeteksi posisi kolom berdasarkan nama header</li>
                            <li>Data dengan NO SEP duplikat otomatis dilewati</li>
                        </ul>
                    </div>

                    <h5>Kolom yang Dikenali (Header Excel):</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="small">
                                <li><code>KODE_RS</code>, <code>KELAS_RS</code>, <code>KELAS_RAWAT</code></li>
                                <li><code>ADMISSION_DATE</code>, <code>DISCHARGE_DATE</code></li>
                                <li><code>NAMA_PASIEN</code>, <code>MRN</code>, <code>SEX</code></li>
                                <li><code>DIAGLIST</code>, <code>PROCLIST</code></li>
                                <li><code>INACBG</code>, <code>DESKRIPSI_INACBG</code></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="small">
                                <li><code>SEP</code> ⚠️ <strong>WAJIB!</strong></li>
                                <li><code>NOKARTU</code>, <code>DPJP</code></li>
                                <li><code>TARIF_RS</code>, <code>TARIF_INACBG</code></li>
                                <li><code>LOS</code>, <code>ICU_INDIKATOR</code></li>
                                <li>Dan kolom lainnya... (lihat dokumentasi)</li>
                            </ul>
                        </div>
                    </div>

                    <h5 class="mt-3">Contoh Format Excel:</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th>KODE_RS</th>
                                    <th>KELAS_RS</th>
                                    <th>NAMA_PASIEN</th>
                                    <th>SEP</th>
                                    <th>NOKARTU</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>0301R001</td>
                                    <td>C</td>
                                    <td>BUDI SANTOSO</td>
                                    <td>0301R0010124K001</td>
                                    <td>0001234567890</td>
                                </tr>
                                <tr>
                                    <td>0301R001</td>
                                    <td>C</td>
                                    <td>ANI WIJAYA</td>
                                    <td>0301R0010125K001</td>
                                    <td>0001234567891</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- TXT Format Tab --}}
                <div class="tab-pane fade" id="txt" role="tabpanel">
                    <div class="alert alert-success">
                        <h5><i class="fas fa-lightbulb"></i> Penting untuk File TXT!</h5>
                        <ul class="mb-0">
                            <li>File harus berformat <strong>.txt</strong> (plain text)</li>
                            <li>Data dipisahkan dengan <strong>delimiter</strong> (Tab, Semicolon, Comma, atau Pipe)</li>
                            <li><strong>Baris pertama HARUS HEADER</strong> dengan nama kolom</li>
                            <li>Sistem akan otomatis mendeteksi delimiter yang digunakan</li>
                            <li>Kolom <strong>SEP</strong> wajib ada</li>
                        </ul>
                    </div>

                    <h5>Delimiter yang Didukung:</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <ul>
                                <li><strong>Tab</strong> (<code>\t</code>) - Paling umum dari export aplikasi</li>
                                <li><strong>Semicolon</strong> (<code>;</code>) - Export dari Excel</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul>
                                <li><strong>Comma</strong> (<code>,</code>) - CSV format</li>
                                <li><strong>Pipe</strong> (<code>|</code>) - Export khusus</li>
                            </ul>
                        </div>
                    </div>

                    <h5 class="mt-3">Contoh Format TXT (Tab-delimited):</h5>
                    <div class="bg-dark text-white p-3 rounded">
                        <code style="color: #00ff00;">
KODE_RS&nbsp;&nbsp;&nbsp;&nbsp;KELAS_RS&nbsp;&nbsp;&nbsp;&nbsp;NAMA_PASIEN&nbsp;&nbsp;&nbsp;&nbsp;SEP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NOKARTU<br>
0301R001&nbsp;&nbsp;&nbsp;&nbsp;C&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BUDI SANTOSO&nbsp;&nbsp;&nbsp;&nbsp;0301R0010124K001&nbsp;&nbsp;&nbsp;&nbsp;0001234567890<br>
0301R001&nbsp;&nbsp;&nbsp;&nbsp;C&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ANI WIJAYA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0301R0010125K001&nbsp;&nbsp;&nbsp;&nbsp;0001234567891
                        </code>
                    </div>

                    <h5 class="mt-3">Contoh Format TXT (Semicolon-delimited):</h5>
                    <div class="bg-dark text-white p-3 rounded">
                        <code style="color: #00ff00;">
KODE_RS;KELAS_RS;NAMA_PASIEN;SEP;NOKARTU<br>
0301R001;C;BUDI SANTOSO;0301R0010124K001;0001234567890<br>
0301R001;C;ANI WIJAYA;0301R0010125K001;0001234567891
                        </code>
                    </div>

                    <div class="alert alert-warning mt-3">
                        <i class="fas fa-exclamation-triangle"></i> <strong>Catatan:</strong> Pastikan file TXT Anda menggunakan encoding <strong>UTF-8</strong> untuk menghindari masalah karakter special.
                    </div>
                </div>
            </div>

            <div class="alert alert-warning mt-3">
                <h5><i class="fas fa-exclamation-triangle"></i> Troubleshooting</h5>
                <p>Jika upload gagal dengan error "Format tidak sesuai (kolom kurang)", gunakan <strong>Debug Tool</strong> untuk melihat struktur file Anda:</p>
                <a href="/debug-excel" class="btn btn-warning btn-sm" target="_blank">
                    <i class="fas fa-bug"></i> Buka Debug Tool
                </a>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .info-box-number {
            font-size: 2rem !important;
            font-weight: bold;
        }
        
        #filePreview {
            margin-top: 15px;
            border-left: 4px solid #17a2b8;
        }
        
        .card-primary:not(.card-outline)>.card-header {
            background-color: #007bff;
        }
        
        .custom-file-label::after {
            content: "Browse";
        }

        .nav-tabs .nav-link {
            color: #495057;
        }

        .nav-tabs .nav-link.active {
            color: #007bff;
            font-weight: 600;
        }

        code {
            background-color: #f4f4f4;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 90%;
        }

        .bg-dark code {
            background-color: transparent;
        }
        
        .custom-control-label {
            padding-left: 25px;
        }
        
        .custom-control-label::before {
            width: 20px;
            height: 20px;
            border-radius: 4px;
        }
        
        .custom-control-label::after {
            width: 20px;
            height: 20px;
        }
        
        .input-group-text {
            background-color: #f8f9fa;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Function to update periode hidden field
            function updatePeriodeField() {
                const bulan = $('#bulan').val();
                const tahun = $('#tahun').val();

                if (bulan && tahun) {
                    $('#periode').val(tahun + '-' + bulan);
                } else {
                    $('#periode').val('');
                }
                updatePreview();
            }

            // Event listeners for bulan and tahun selects
            $('#bulan, #tahun').on('change', function() {
                updatePeriodeField();
            });

            // Update preview function
            function updatePreview() {
                const jenisLayanan = $('input[name="jenis_layanan"]:checked').val();
                const bulan = $('#bulan').val();
                const tahun = $('#tahun').val();

                if (jenisLayanan) {
                    $('#jenisLayanan').text(jenisLayanan === 'rawat_jalan' ? 'Rawat Jalan' : 'Rawat Inap');
                }

                if (bulan && tahun) {
                    const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    const bulanIndex = parseInt(bulan) - 1;
                    const formattedPeriode = monthNames[bulanIndex] + ' ' + tahun;
                    $('#periodeInfo').text(formattedPeriode);
                }
            }
            
            // File input change event
            $('#file').on('change', function(e) {
                const file = e.target.files[0];
                
                if (file) {
                    // Validate file size (20MB = 20 * 1024 * 1024 bytes)
                    const maxSize = 20 * 1024 * 1024;
                    if (file.size > maxSize) {
                        Swal.fire({
                            icon: 'error',
                            title: 'File Terlalu Besar',
                            text: 'Ukuran file maksimal 20MB'
                        });
                        $(this).val('');
                        $('#fileLabel').text('Pilih file Excel atau TXT...');
                        $('#filePreview').slideUp();
                        return;
                    }
                    
                    // Validate file extension
                    const allowedExtensions = ['xlsx', 'xls', 'txt'];
                    const fileExtension = file.name.split('.').pop().toLowerCase();
                    if (!allowedExtensions.includes(fileExtension)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Format File Salah',
                            text: 'Hanya file .xlsx, .xls, atau .txt yang diperbolehkan'
                        });
                        $(this).val('');
                        $('#fileLabel').text('Pilih file Excel atau TXT...');
                        $('#filePreview').slideUp();
                        return;
                    }
                    
                    // Update label
                    $('#fileLabel').text(file.name);
                    
                    // Determine format icon and label
                    let formatLabel = '';
                    let formatClass = 'badge-primary';
                    
                    if (fileExtension === 'xlsx' || fileExtension === 'xls') {
                        formatLabel = 'Excel File';
                        formatClass = 'badge-success';
                    } else if (fileExtension === 'txt') {
                        formatLabel = 'Text File (TXT)';
                        formatClass = 'badge-info';
                    }
                    
                    // Show preview
                    $('#fileName').text(file.name);
                    $('#fileSize').text((file.size / 1024 / 1024).toFixed(2) + ' MB');
                    $('#fileType').text(file.type || 'text/plain');
                    $('#fileFormat').text(formatLabel).removeClass('badge-primary badge-success badge-info').addClass(formatClass);
                    
                    // Update jenis layanan and periode info
                    updatePreview();
                    
                    $('#filePreview').slideDown();
                } else {
                    $('#fileLabel').text('Pilih file Excel atau TXT...');
                    $('#filePreview').slideUp();
                }
            });
            
            // Jenis layanan change event
            $('input[name="jenis_layanan"]').on('change', function() {
                updatePreview();
            });
            
            // Form submit event
            $('#uploadForm').on('submit', function(e) {
                const fileInput = $('#file')[0];
                const periode = $('#periode').val();
                
                // Validate if file is selected
                if (!fileInput.files || !fileInput.files[0]) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'File Belum Dipilih',
                        text: 'Silakan pilih file Excel atau TXT terlebih dahulu'
                    });
                    return false;
                }
                
                // Validate periode
                if (!periode) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Periode Belum Dipilih',
                        text: 'Silakan pilih periode upload terlebih dahulu'
                    });
                    return false;
                }
                
                const btn = $('#submitBtn');
                btn.prop('disabled', true);
                btn.html('<i class="fas fa-spinner fa-spin"></i> Sedang mengupload dan memproses...');
                
                // Show loading overlay
                Swal.fire({
                    title: 'Sedang memproses...',
                    html: 'Mohon tunggu, data sedang diimport ke database',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            });
            
            // Auto dismiss alerts after 5 seconds
            setTimeout(function() {
                $('.alert').not('.alert-warning').not('.alert-info').fadeOut('slow');
            }, 5000);
        });
    </script>
@stop