<!DOCTYPE html>
<html lang="id" id="main-html" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - SIDAWAI BKK Pontianak</title>

    <!-- Bootstrap 5 & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
        })();
    </script>
    @vite(['resources/css/admin-layout.css'])
</head>

<body>
    <div class="sidebar-backdrop" onclick="toggleSidebar()"></div>
    <div class="theme-toggle-admin" onclick="toggleTheme()" title="Ganti Mode Tampilan">
        <i id="theme-icon" class="bi bi-moon-stars-fill"></i>
    </div>

    <nav class="sidebar" id="sidebar">
        <div class="sidebar-wrapper">
            <div>
                <div class="sidebar-brand-container">
                    <div class="logo-wrapper d-flex justify-content-center mb-2">
                        <img src="{{ asset('assets/logo/kemenkes_bkk.png') }}" alt="Logo Kemenkes BKK Pontianak" class="logo-img img-fluid" style="max-height: 50px; width: auto;">
                    </div>
                    <h5 class="fw-bold m-0">SIDAWAI</h5>
                    <span class="agency-name" style="font-size: 0.8rem; opacity: 0.9;">BKK Kelas I Pontianak</span>
                </div>

                <ul class="nav flex-column mt-2">
                    @if (auth()->user()->isAdmin())

                        @if (auth()->user()->hasPermission('access_dashboard'))
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2 me-2"></i> Dashboard Admin
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->hasPermission('manage_users'))
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                                    <i class="bi bi-people me-2"></i> Data Pegawai
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->isSuperadmin())
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}" href="{{ route('admin.admins.index') }}">
                                    <i class="bi bi-shield-lock me-2"></i> Kelola Hak Akses Admin
                                </a>
                            </li>
                        @endif

                        <!-- 4. Dokumen Pegawai -->
                        @if (auth()->user()->hasPermission('manage_documents'))
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.documents.*') ? 'active' : '' }}" href="{{ route('admin.documents.index') }}">
                                    <i class="bi bi-folder-check me-2"></i> Dokumen Pegawai
                                </a>
                            </li>
                        @endif
                    @endif
                </ul>
            </div>

            <div class="sidebar-footer">
                <div class="user-info-box d-flex align-items-center">
                    <div class="me-2 fs-3 text-white">
                        <i class="bi bi-person-circle"></i>
                    </div>
                    <div class="overflow-hidden">
                        <div class="fw-bold text-white text-truncate" style="font-size: 0.85rem;" title="{{ auth()->user()->name }}">
                            {{ auth()->user()->name }}
                        </div>
                        <div class="text-white-50 text-uppercase fw-extrabold" style="font-size: 0.68rem; letter-spacing: 0.5px;">
                            @if(auth()->user()->isSuperadmin())
                                <span class="badge bg-danger p-1">Superadmin</span>
                            @elseif(auth()->user()->isAdmin())
                                <span class="badge bg-dark p-1">Admin</span>
                            @else
                                <span class="badge bg-secondary p-1">Pegawai</span>
                            @endif
                        </div>
                    </div>
                </div>

                <a class="nav-link text-danger-custom" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-power me-2"></i> Logout (Keluar)
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>

        </div>
    </nav>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <header class="top-navbar shadow-sm">
            <div class="d-flex align-items-center">
                <button class="btn-hamburger me-3" onclick="toggleSidebar()" title="Sembunyikan / Tampilkan Sidebar">
                    <i class="bi bi-list"></i>
                </button>
                <span class="fw-bold fs-5 text-body">Panel Admin SIDAWAI</span>
            </div>

            <div class="text-muted small font-bold d-none d-sm-block">
                <i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="content-area">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
                <h1 class="h2 main-header">@yield('header', 'Admin Dashboard')</h1>
            </div>

            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const body = document.body;
            if (window.innerWidth < 992) {
                body.classList.toggle('sidebar-mobile-open');
            } else {
                body.classList.toggle('sidebar-toggled');
            }
        }

        function toggleTheme() {
            const htmlTag = document.getElementById('main-html');
            const currentTheme = htmlTag.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';

            htmlTag.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon(newTheme);
        }

        function updateThemeIcon(theme) {
            const icon = document.getElementById('theme-icon');
            if (icon) {
                icon.className = theme === 'light' ? 'bi bi-moon-stars-fill' : 'bi bi-sun-fill';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const savedTheme = localStorage.getItem('theme') || 'light';
            updateThemeIcon(savedTheme);
        });
    </script>
    @stack('scripts')
</body>
</html>