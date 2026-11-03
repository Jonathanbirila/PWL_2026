<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Inventaris & Transaksi') - PWL 2026</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --bs-font-sans-serif: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            --teal-primary: #0d9488;
            --teal-dark: #0f766e;
            --teal-light: #f0fdfa;
            --teal-border: #99f6e4;
            --primary-gradient: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
            --sidebar-width: 260px;
        }

        body {
            font-family: var(--bs-font-sans-serif);
            background-color: #f8fafc;
            color: #1e293b;
            min-height: 100vh;
            margin: 0;
            overflow-x: hidden;
        }

        /* Layout Structure */
        .app-layout {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* Sidebar Styling */
        .app-sidebar {
            width: var(--sidebar-width);
            background-color: #ffffff;
            border-right: 1px solid #e2e8f0;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
        }

        .sidebar-header {
            padding: 1.15rem 1.25rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .navbar-brand-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: var(--primary-gradient);
            color: #ffffff;
            margin-right: 0.75rem;
            font-size: 1.15rem;
            box-shadow: 0 3px 8px rgba(13, 148, 136, 0.25);
            flex-shrink: 0;
        }

        .sidebar-menu {
            flex: 1;
            overflow-y: auto;
            padding: 1rem 0.85rem;
        }

        .menu-label {
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #94a3b8;
            padding: 0.5rem 0.75rem 0.25rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 0.85rem;
            color: #475569;
            font-weight: 500;
            font-size: 0.92rem;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 0.25rem;
            transition: all 0.2s ease;
        }

        .sidebar-link i {
            font-size: 1.2rem;
            width: 22px;
            text-align: center;
            color: #64748b;
            transition: color 0.2s ease;
        }

        .sidebar-link:hover {
            color: var(--teal-primary);
            background-color: var(--teal-light);
        }

        .sidebar-link:hover i {
            color: var(--teal-primary);
        }

        .sidebar-link.active {
            color: var(--teal-dark) !important;
            background-color: var(--teal-light);
            border: 1px solid var(--teal-border);
            font-weight: 600;
        }

        .sidebar-link.active i {
            color: var(--teal-dark) !important;
        }

        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid #f1f5f9;
            background-color: #ffffff;
        }

        /* Main Content Wrapper */
        .app-main {
            flex: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            min-width: 0;
            transition: margin-left 0.3s ease;
        }

        /* Topbar Header */
        .app-topbar {
            height: 64px;
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 1020;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
        }

        .content-body {
            flex: 1;
            padding: 2rem 2.25rem;
        }

        /* Backdrop on Mobile */
        .sidebar-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(15, 23, 42, 0.5);
            z-index: 1035;
            display: none;
        }

        /* Responsive Mobile Behavior */
        @media (max-width: 991.98px) {
            .app-sidebar {
                transform: translateX(-100%);
            }

            .app-sidebar.show {
                transform: translateX(0);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            }

            .sidebar-backdrop.show {
                display: block;
            }

            .app-main {
                margin-left: 0;
            }

            .content-body {
                padding: 1.25rem 1rem;
            }
        }

        /* Guest Layout (Login / Register without Sidebar) */
        .guest-layout {
            background-color: #f8fafc;
        }

        /* Card Custom */
        .card-custom {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04);
            background: #ffffff;
        }

        .card-header-custom {
            background: #ffffff;
            border-bottom: 1px solid #f1f5f9;
            border-left: 4px solid var(--teal-primary);
            padding: 1.1rem 1.35rem;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .page-header {
            margin-bottom: 1.75rem;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.25rem;
            letter-spacing: -0.02em;
        }

        .page-subtitle {
            color: #64748b;
            font-size: 0.92rem;
            margin-bottom: 0;
        }

        /* Teal Buttons */
        .btn-teal {
            background: var(--primary-gradient);
            color: #ffffff !important;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            padding: 0.55rem 1.15rem;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            box-shadow: 0 2px 6px rgba(13, 148, 136, 0.25);
            transition: all 0.2s ease;
        }

        .btn-teal:hover {
            background: linear-gradient(135deg, #0f766e 0%, #115e59 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(13, 148, 136, 0.35);
        }

        .btn-outline-teal {
            color: var(--teal-primary);
            border: 1px solid var(--teal-primary);
            background: transparent;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .btn-outline-teal:hover {
            background-color: var(--teal-primary);
            color: #ffffff;
        }

        .text-teal {
            color: var(--teal-primary) !important;
        }

        /* Table Styling */
        .table-custom {
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-custom thead th {
            background-color: #f1f5f9;
            color: #334155;
            font-weight: 600;
            font-size: 0.82rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            padding: 0.85rem 1.15rem;
            border-top: none;
            border-bottom: 1px solid #e2e8f0;
        }

        .table-custom tbody td {
            padding: 0.95rem 1.15rem;
            vertical-align: middle;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
        }

        .table-custom tbody tr:hover td {
            background-color: #f8fafc;
        }

        /* Badges */
        .badge-barcode {
            font-family: ui-monospace, SFMono-Regular, monospace;
            background-color: #f8fafc;
            color: #0f766e;
            padding: 0.35rem 0.65rem;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
            border: 1px solid var(--teal-border);
        }

        .badge-supplier {
            background-color: var(--teal-light);
            color: var(--teal-dark);
            border: 1px solid var(--teal-border);
            padding: 0.3rem 0.65rem;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.85rem;
        }

        /* Form Controls */
        .form-label {
            font-weight: 600;
            color: #334155;
            font-size: 0.88rem;
            margin-bottom: 0.4rem;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            padding: 0.65rem 0.9rem;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--teal-primary);
            box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15);
        }

        footer {
            background-color: #ffffff;
            border-top: 1px solid #e2e8f0;
            padding: 1.25rem 0;
            font-size: 0.85rem;
            color: #64748b;
        }

        /* Print styles */
        @media print {
            .app-sidebar,
            .app-topbar,
            footer,
            .sidebar-backdrop,
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
            }

            .app-main {
                margin-left: 0 !important;
                padding: 0 !important;
            }

            .content-body {
                padding: 0 !important;
            }

            .card-custom {
                border: 1px solid #ccc !important;
                box-shadow: none !important;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    @auth
        {{-- LAYOUT UTAMA DENGAN SIDEBAR (KHUSUS SETELAH LOGIN) --}}
        <div class="app-layout">
            <!-- Backdrop untuk layar mobile -->
            <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

            <!-- Sidebar Navigasi -->
            <aside class="app-sidebar" id="appSidebar">
                @php
                    $brandRoute = Auth::user()->isAdmin() ? route('admin.dashboard') : route('pembeli.shop');
                @endphp

                <!-- Header Brand -->
                <div class="sidebar-header d-flex align-items-center justify-content-between">
                    <a href="{{ $brandRoute }}" class="d-flex align-items-center text-decoration-none">
                        <span class="navbar-brand-icon">
                            <i class="bi bi-shop"></i>
                        </span>
                        <div>
                            <div class="fw-bold text-dark fs-5 lh-1">PWL Store</div>
                            <small class="text-muted" style="font-size: 0.72rem;">Inventaris & Transaksi</small>
                        </div>
                    </a>
                    <button class="btn btn-sm btn-light border-0 d-lg-none text-secondary" id="sidebarCloseBtn" type="button">
                        <i class="bi bi-x-lg fs-5"></i>
                    </button>
                </div>

                <!-- Info User di Sidebar -->
                <div class="p-3 mx-3 my-3 rounded-3 bg-light border">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle text-white d-flex align-items-center justify-content-center shadow-sm flex-shrink-0"
                            style="width: 38px; height: 38px; background: var(--primary-gradient);">
                            <i class="bi bi-person-fill fs-5"></i>
                        </div>
                        <div class="overflow-hidden" style="min-width: 0;">
                            <div class="fw-bold text-dark text-truncate small" title="{{ Auth::user()->name }}">{{ Auth::user()->name }}</div>
                            <span class="badge {{ Auth::user()->isAdmin() ? 'bg-danger' : 'bg-success' }} text-uppercase"
                                style="font-size: 0.65rem;">
                                {{ Auth::user()->role }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Link Menu Navigasi -->
                <div class="sidebar-menu">
                    @if (Auth::user()->isAdmin())
                        {{-- Menu Khusus Admin --}}
                        <div class="menu-label">Menu Admin</div>
                        <a href="{{ route('admin.dashboard') }}"
                            class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('product.index') }}"
                            class="sidebar-link {{ request()->routeIs('product.*') ? 'active' : '' }}">
                            <i class="bi bi-box-seam"></i>
                            <span>Data Produk</span>
                        </a>
                        <a href="{{ route('supplier.index') }}"
                            class="sidebar-link {{ request()->routeIs('supplier.*') ? 'active' : '' }}">
                            <i class="bi bi-truck"></i>
                            <span>Data Supplier</span>
                        </a>
                        <a href="{{ route('transactions.index') }}"
                            class="sidebar-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                            <i class="bi bi-receipt"></i>
                            <span>Data Transaksi</span>
                        </a>
                    @else
                        {{-- Menu Khusus Pembeli --}}
                        <div class="menu-label">Menu Pembeli</div>
                        <a href="{{ route('pembeli.shop') }}"
                            class="sidebar-link {{ request()->routeIs('pembeli.shop') ? 'active' : '' }}">
                            <i class="bi bi-grid"></i>
                            <span>Katalog Belanja</span>
                        </a>
                        <a href="{{ route('pembeli.transactions') }}"
                            class="sidebar-link {{ request()->routeIs('pembeli.transactions') || request()->routeIs('pembeli.transaction.detail') ? 'active' : '' }}">
                            <i class="bi bi-clock-history"></i>
                            <span>Riwayat Belanja</span>
                        </a>
                    @endif
                </div>

                <!-- Bagian Bawah Sidebar: Tombol Logout -->
                <div class="sidebar-footer">
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center gap-2 py-2">
                            <i class="bi bi-box-arrow-right"></i>
                            <span class="fw-semibold small">Logout (Keluar)</span>
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Area Konten Utama -->
            <div class="app-main">
                <!-- Topbar -->
                <header class="app-topbar d-flex align-items-center justify-content-between px-3 px-md-4">
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-light border d-lg-none shadow-none py-1 px-2" id="sidebarToggleBtn" type="button">
                            <i class="bi bi-list fs-5"></i>
                        </button>
                        <div class="fw-semibold text-secondary small d-none d-sm-flex align-items-center gap-1">
                            <i class="bi bi-grid-fill text-teal"></i>
                            <span>Sistem Manajemen Inventaris & Transaksi PWL</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <div class="d-flex align-items-center gap-2 text-end">
                            <div class="d-none d-md-block">
                                <div class="fw-bold text-dark small lh-1 mb-1">{{ Auth::user()->name }}</div>
                                <div class="text-muted" style="font-size: 0.72rem;">{{ Auth::user()->email }}</div>
                            </div>
                            <span class="badge {{ Auth::user()->isAdmin() ? 'bg-danger-subtle text-danger border border-danger-subtle' : 'bg-success-subtle text-success border border-success-subtle' }} rounded-pill px-3 py-1">
                                {{ ucfirst(Auth::user()->role) }}
                            </span>
                        </div>
                    </div>
                </header>

                <!-- Konten Halaman -->
                <main class="content-body">
                    <!-- Notifikasi Alert -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center shadow-sm rounded-3 border-0 mb-4"
                            role="alert">
                            <i class="bi bi-check-circle-fill fs-5 text-success me-2"></i>
                            <div>{{ session('success') }}</div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center shadow-sm rounded-3 border-0 mb-4"
                            role="alert">
                            <i class="bi bi-exclamation-triangle-fill fs-5 text-danger me-2"></i>
                            <div>{{ session('error') }}</div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3 border-0 mb-4"
                            role="alert">
                            <div class="d-flex align-items-center mb-1">
                                <i class="bi bi-exclamation-circle-fill fs-5 me-2"></i>
                                <strong>Terdapat beberapa kesalahan:</strong>
                            </div>
                            <ul class="mb-0 ps-4 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @yield('content')
                </main>

                <!-- Footer -->
                <footer class="text-center py-3">
                    <div class="container-fluid text-center">
                        <span>&copy; {{ date('Y') }} PWL Store & Inventaris • Praktikum Pemrograman Web Lanjut</span>
                    </div>
                </footer>
            </div>
        </div>
    @else
        {{-- LAYOUT TAMU: LOGIN & REGISTER (TANPA SIDEBAR & TANPA TOPBAR) --}}
        <div class="guest-layout d-flex flex-column justify-content-center align-items-center min-vh-100 py-4 px-3">
            <div class="w-100" style="max-width: 440px;">
                <!-- Notifikasi Alert -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center shadow-sm rounded-3 border-0 mb-3"
                        role="alert">
                        <i class="bi bi-check-circle-fill fs-5 text-success me-2"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center shadow-sm rounded-3 border-0 mb-3"
                        role="alert">
                        <i class="bi bi-exclamation-triangle-fill fs-5 text-danger me-2"></i>
                        <div>{{ session('error') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3 border-0 mb-3"
                        role="alert">
                        <div class="d-flex align-items-center mb-1">
                            <i class="bi bi-exclamation-circle-fill fs-5 me-2"></i>
                            <strong>Terdapat kesalahan:</strong>
                        </div>
                        <ul class="mb-0 ps-4 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')

                <div class="text-center text-muted small mt-4">
                    &copy; {{ date('Y') }} PWL Store • Praktikum Pemrograman Web Lanjut
                </div>
            </div>
        </div>
    @endauth

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    @auth
        <!-- Script Toggle Sidebar untuk Mobile -->
        <script>
            const sidebar = document.getElementById('appSidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            const toggleBtn = document.getElementById('sidebarToggleBtn');
            const closeBtn = document.getElementById('sidebarCloseBtn');

            function openSidebar() {
                sidebar.classList.add('show');
                backdrop.classList.add('show');
            }

            function closeSidebar() {
                sidebar.classList.remove('show');
                backdrop.classList.remove('show');
            }

            if (toggleBtn) {
                toggleBtn.addEventListener('click', openSidebar);
            }
            if (closeBtn) {
                closeBtn.addEventListener('click', closeSidebar);
            }
            if (backdrop) {
                backdrop.addEventListener('click', closeSidebar);
            }
        </script>
    @endauth

    @stack('scripts')
</body>

</html>
