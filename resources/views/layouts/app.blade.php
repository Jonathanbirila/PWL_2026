<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Manajemen Produk & Supplier') - PWL 2026</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --bs-font-sans-serif: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            --teal-primary: #0d9488;
            --teal-dark: #0f766e;
            --teal-light: #f0fdfa;
            --teal-border: #99f6e4;
            --primary-gradient: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
        }

        body {
            font-family: var(--bs-font-sans-serif);
            background-color: #f8fafc;
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar Styling */
        .navbar-custom {
            background-color: #ffffff;
            border-bottom: 2px solid #e2e8f0;
            padding: 0.75rem 0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.2rem;
            color: #0f172a !important;
            letter-spacing: -0.02em;
        }

        .navbar-brand-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: var(--primary-gradient);
            color: #ffffff;
            margin-right: 0.6rem;
            font-size: 1.05rem;
            box-shadow: 0 3px 8px rgba(13, 148, 136, 0.25);
        }

        .nav-link {
            font-weight: 500;
            color: #64748b;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .nav-link:hover {
            color: var(--teal-primary);
            background-color: var(--teal-light);
        }

        .nav-link.active {
            color: var(--teal-dark) !important;
            background-color: var(--teal-light);
            border: 1px solid var(--teal-border);
            font-weight: 600;
        }

        .main-content {
            flex: 1;
            padding: 2rem 0;
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

        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            padding: 0.65rem 0.9rem;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--teal-primary);
            box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15);
        }

        .input-group-text {
            border-radius: 8px 0 0 8px;
            background-color: #f8fafc;
            border-color: #cbd5e1;
            color: #64748b;
        }

        .input-group .form-control {
            border-radius: 0 8px 8px 0;
        }

        footer {
            background-color: #ffffff;
            border-top: 1px solid #e2e8f0;
            padding: 1.25rem 0;
            font-size: 0.85rem;
            color: #64748b;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Top Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('product.index') }}">
                <span class="navbar-brand-icon">
                    <i class="bi bi-grid-fill"></i>
                </span>
                <span>PWL Inventaris</span>
            </a>
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list fs-2 text-dark"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-3">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('product.*') ? 'active' : '' }}" href="{{ route('product.index') }}">
                            <i class="bi bi-box-seam me-1"></i> Data Produk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('supplier.*') ? 'active' : '' }}" href="{{ route('supplier.index') }}">
                            <i class="bi bi-truck me-1"></i> Data Supplier
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <!-- Flash Message Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center shadow-sm rounded-3 border-0 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill fs-5 text-success me-2"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center shadow-sm rounded-3 border-0 mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill fs-5 text-danger me-2"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3 border-0 mb-4" role="alert">
                    <div class="d-flex align-items-center mb-1">
                        <i class="bi bi-exclamation-circle-fill fs-5 me-2"></i>
                        <strong>Terdapat beberapa kesalahan input:</strong>
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
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <span>&copy; {{ date('Y') }} PWL Inventaris • Praktikum Pemrograman Web Lanjut</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    @stack('scripts')
</body>
</html>
