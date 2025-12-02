<!doctype html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('title', 'Dashboard') | RSKK Monitoring Klaim</title>

    <!--begin::Accessibility Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <!--end::Accessibility Meta Tags-->

    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" crossorigin="anonymous" media="print" onload="this.media='all'" />
    <!--end::Fonts-->

    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" crossorigin="anonymous" />
    <!--end::Third Party Plugin(OverlayScrollbars)-->

    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" crossorigin="anonymous" />
    <!--end::Third Party Plugin(Bootstrap Icons)-->

    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="{{ asset('AdminLTE-master/dist/css/adminlte.css') }}" />
    <!--end::Required Plugin(AdminLTE)-->

    <!-- apexcharts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css" crossorigin="anonymous" />

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-master/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE-master/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

    <style>
        .app-content {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }
        .small-box {
            border-radius: 10px;
        }
        /* Rapikan Logo dan Text */
        .sidebar-brand {
            padding: 0.8rem 0.5rem;
        }
        .brand-link {
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
        }
        .brand-image {
            width: 40px;
            height: 40px;
            margin-right: 0.75rem;
            object-fit: contain;
        }
        .brand-text {
            font-size: 1.1rem;
            font-weight: 600;
            line-height: 1.2;
        }
    </style>

    @stack('styles')
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <!--begin::Header-->
        <nav class="app-header navbar navbar-expand bg-body">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Start Navbar Links-->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                    
                    @if(auth()->check())
                        @if(auth()->user()->role === 'casemix')
                            <li class="nav-item d-none d-md-block">
                                <a href="{{ route('casemix.index') }}" class="nav-link">Home</a>
                            </li>
                        @elseif(auth()->user()->role === 'keuangan')
                            <li class="nav-item d-none d-md-block">
                                <a href="{{ route('keuangan.dashboard') }}" class="nav-link">Home</a>
                            </li>
                        @else
                            <li class="nav-item d-none d-md-block">
                                <a href="{{ route('admin.dashboard') }}" class="nav-link">Home</a>
                            </li>
                            <li class="nav-item d-none d-md-block">
                                <a href="#" class="nav-link">Laporan</a>
                            </li>
                            <li class="nav-item d-none d-md-block">
                                <a href="#" class="nav-link">Panduan</a>
                            </li>
                        @endif
                    @endif
                </ul>
                <!--end::Start Navbar Links-->

                <!--begin::End Navbar Links-->
                <ul class="navbar-nav ms-auto">
                    <!--begin::Notifications Dropdown Menu-->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-bs-toggle="dropdown" href="#">
                            <i class="bi bi-bell-fill"></i>
                            <span class="navbar-badge badge text-bg-warning">{{ $totalNotifications ?? 0 }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <span class="dropdown-item dropdown-header">{{ $totalNotifications ?? 0 }} Notifications</span>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="bi bi-envelope me-2"></i> {{ $totalNotifications ?? 0 > 0 ? 'Ada notifikasi baru' : 'Tidak ada notifikasi' }}
                            </a>
                        </div>
                    </li>
                    <!--end::Notifications Dropdown Menu-->

                    <!--begin::Fullscreen Toggle-->
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                            <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                            <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                        </a>
                    </li>
                    <!--end::Fullscreen Toggle-->

                    <!--begin::User Menu Dropdown-->
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img src="{{ asset('AdminLTE-master/dist/img/user2-160x160.jpg') }}" class="user-image rounded-circle shadow" alt="User Image" />
                            <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <!--begin::User Image-->
                            <li class="user-header text-bg-primary">
                                <img src="{{ asset('AdminLTE-master/dist/img/user2-160x160.jpg') }}" class="rounded-circle shadow" alt="User Image" />
                                <p>
                                    {{ auth()->user()->name }}
                                    <small>{{ ucfirst(auth()->user()->role ?? 'User') }}</small>
                                </p>
                            </li>
                            <!--end::User Image-->
                            <!--begin::Menu Footer-->
                            <li class="user-footer">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-default btn-flat float-end">Sign out</button>
                                </form>
                            </li>
                            <!--end::Menu Footer-->
                        </ul>
                    </li>
                    <!--end::User Menu Dropdown-->
                </ul>
                <!--end::End Navbar Links-->
            </div>
            <!--end::Container-->
        </nav>
        <!--end::Header-->

        <!--begin::Sidebar-->
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <!--begin::Sidebar Brand-->
            <div class="sidebar-brand">
                <!--begin::Brand Link-->
                <a href="@if(auth()->check())
                            @if(auth()->user()->role === 'casemix')
                                {{ route('casemix.index') }}
                            @elseif(auth()->user()->role === 'keuangan')
                                {{ route('keuangan.dashboard') }}
                            @else
                                {{ route('admin.dashboard') }}
                            @endif
                        @endif" class="brand-link">
                    <!--begin::Brand Image-->
                    <img src="{{ asset('AdminLTE-master/dist/assets/img/rskk.png') }}" alt="RSKK Logo" class="brand-image shadow" />
                    <!--end::Brand Image-->
                    <!--begin::Brand Text-->
                    <span class="brand-text">SIM KLAIM RSKK</span>
                    <!--end::Brand Text-->
                </a>
                <!--end::Brand Link-->
            </div>
            <!--end::Sidebar Brand-->

            <!--begin::Sidebar Wrapper-->
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <!--begin::Sidebar Menu-->
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" aria-label="Main navigation" data-accordion="false">
                        
                        <!-- Dashboard - HANYA UNTUK ADMIN -->
                        @if(auth()->check() && !in_array(auth()->user()->role, ['casemix', 'keuangan']))
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-speedometer"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        @endif

                        <!-- Header MANAJEMEN KLAIM -->
                        @if(auth()->check() && auth()->user()->role !== 'keuangan')
                        <li class="nav-header">MANAJEMEN KLAIM</li>
                        @endif

                        <!-- Data Klaim - HANYA UNTUK CASEMIX & ADMIN -->
                        @if(auth()->check() && auth()->user()->role !== 'keuangan')
                        <li class="nav-item {{ Request::is('admin/klaim*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ Request::is('admin/klaim*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-file-medical"></i>
                                <p>
                                    Data Klaim
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon bi bi-circle text-success"></i>
                                        <p>Klaim Cair</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon bi bi-circle text-warning"></i>
                                        <p>Klaim Pending</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon bi bi-circle text-danger"></i>
                                        <p>Tidak Layak</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif

                        <!-- Dashboard Casemix - HANYA UNTUK CASEMIX & ADMIN -->
                        @if(auth()->check() && auth()->user()->role !== 'keuangan')
                        <li class="nav-item">
                            <a href="{{ route('casemix.index') }}" class="nav-link {{ Request::routeIs('casemix.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-bar-chart"></i>
                                <p>Dashboard Casemix</p>
                            </a>
                        </li>
                        @endif

                        <!-- Surat Pengajuan - HANYA UNTUK ADMIN -->
                        @if(auth()->check() && auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-file-text"></i>
                                <p>Surat Pengajuan</p>
                            </a>
                        </li>
                        @endif

                        <!-- Laporan - HANYA UNTUK ADMIN -->
                        @if(auth()->check() && auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-graph-up"></i>
                                <p>Laporan</p>
                            </a>
                        </li>
                        @endif

                        <!-- Header KEUANGAN -->
                        @if(auth()->check() && in_array(auth()->user()->role, ['keuangan', 'admin']))
                        <li class="nav-header">KEUANGAN</li>
                        @endif

                        <!-- Dashboard Keuangan - UNTUK KEUANGAN & ADMIN -->
                        @if(auth()->check() && in_array(auth()->user()->role, ['keuangan', 'admin']))
                        <li class="nav-item">
                            <a href="{{ route('keuangan.dashboard') }}" class="nav-link {{ Request::routeIs('keuangan.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-cash-stack"></i>
                                <p>Dashboard Keuangan</p>
                            </a>
                        </li>
                        @endif

                        <!-- Surat Pengajuan Keuangan - UNTUK KEUANGAN & ADMIN -->
                        @if(auth()->check() && in_array(auth()->user()->role, ['keuangan', 'admin']))
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-file-earmark-text"></i>
                                <p>Surat Pengajuan</p>
                            </a>
                        </li>
                        @endif

                        <!-- Laporan Keuangan - UNTUK KEUANGAN & ADMIN -->
                        @if(auth()->check() && in_array(auth()->user()->role, ['keuangan', 'admin']))
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-graph-up-arrow"></i>
                                <p>Laporan</p>
                            </a>
                        </li>
                        @endif

                        <!-- Header PENGATURAN - UNTUK SEMUA USER -->
                        <li class="nav-header">PENGATURAN</li>

                        <!-- Manajemen User - HANYA UNTUK ADMIN -->
                        @if(auth()->check() && auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-people"></i>
                                <p>Manajemen User</p>
                            </a>
                        </li>
                        @endif

                        <!-- Pengaturan - UNTUK SEMUA USER -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-gear"></i>
                                <p>Pengaturan</p>
                            </a>
                        </li>

                    </ul>
                    <!--end::Sidebar Menu-->
                </nav>
            </div>
            <!--end::Sidebar Wrapper-->
        </aside>
        <!--end::Sidebar-->

        <!--begin::App Main-->
        <main class="app-main">
            @yield('content')
        </main>
        <!--end::App Main-->

        <!--begin::Footer-->
        <footer class="app-footer">
            <!--begin::To the end-->
            <div class="float-end d-none d-sm-inline">Version 1.0.1</div>
            <!--end::To the end-->
            <!--begin::Copyright-->
            <strong>
                Copyright &copy; 2025&nbsp;
                <a href="#" class="text-decoration-none">RSKK</a>.
            </strong>
            All rights reserved.
            <!--end::Copyright-->
        </footer>
        <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->

    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    
    <!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)-->
    
    <!--begin::Required Plugin(Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <!--end::Required Plugin(Bootstrap 5)-->
    
    <!--begin::Required Plugin(AdminLTE)-->
    <script src="{{ asset('AdminLTE-master/dist/js/adminlte.js') }}"></script>
    <!--end::Required Plugin(AdminLTE)-->

    <!--begin::OverlayScrollbars Configure-->
    <script>
        const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
        const Default = {
            scrollbarTheme: 'os-theme-light',
            scrollbarAutoHide: 'leave',
            scrollbarClickScroll: true,
        };
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            const isMobile = window.innerWidth <= 992;

            if (sidebarWrapper && typeof OverlayScrollbarsGlobal !== 'undefined' && OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined && !isMobile) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script>
    <!--end::OverlayScrollbars Configure-->

    <!-- jQuery -->
    <script src="{{ asset('AdminLTE-master/plugins/jquery/jquery.min.js') }}"></script>

    <!-- DataTables -->
    <script src="{{ asset('AdminLTE-master/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-master/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-master/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-master/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            @if(session('success'))
                setTimeout(function() {
                    alert('{{ session('success') }}');
                }, 1000);
            @endif
        });
    </script>

    @stack('scripts')
    <!--end::Script-->
</body>
</html>

