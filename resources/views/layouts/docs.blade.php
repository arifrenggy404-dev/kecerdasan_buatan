<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1024">
    <title>Dokumentasi - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        html, body {
            min-width: 1024px;
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: white;
            border-right: 1px solid #e9ecef;
            padding: 2rem 1.5rem;
            overflow-y: auto;
        }
        .main-content {
            margin-left: 280px;
            padding: 4rem;
            min-height: 100vh;
        }
        .nav-link {
            color: #495057;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            margin-bottom: 0.25rem;
            transition: all 0.2s;
            display: flex;
            align-items: center;
        }
        .nav-link:hover {
            background-color: #f1f3f5;
            color: #0d6efd;
        }
        .nav-link.active {
            background-color: #e7f1ff;
            color: #0d6efd;
            font-weight: 600;
        }
        .doc-card {
            background: white;
            border-radius: 1.5rem;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.04);
            padding: 3rem;
        }
        .code-block {
            background: #212529;
            color: #f8f9fa;
            padding: 1.5rem;
            border-radius: 1rem;
            font-family: 'Courier New', Courier, monospace;
            margin: 1.5rem 0;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="mb-5 px-2">
            <h5 class="fw-bold text-dark d-flex align-items-center">
                <i class="bi bi-journal-bookmark-fill text-primary me-2"></i>
                Pusat Edukasi
            </h5>
            <p class="text-muted small">Sistem Penjadwalan AI</p>
        </div>

        <nav class="nav flex-column">
            <div class="text-uppercase small fw-bold text-muted mb-3 px-3" style="letter-spacing: 1px;">Panduan</div>
            <a class="nav-link {{ Request::routeIs('docs.index') ? 'active' : '' }}" href="{{ route('docs.index') }}">
                <i class="bi bi-house-door me-2"></i> Pengantar
            </a>
            <a class="nav-link {{ Request::routeIs('docs.usage') ? 'active' : '' }}" href="{{ route('docs.usage') }}">
                <i class="bi bi-book me-2"></i> Cara Penggunaan
            </a>

            <div class="text-uppercase small fw-bold text-muted mt-4 mb-3 px-3" style="letter-spacing: 1px;">Teknis</div>
            <a class="nav-link {{ Request::routeIs('docs.algorithm') ? 'active' : '' }}" href="{{ route('docs.algorithm') }}">
                <i class="bi bi-diagram-3 me-2"></i> Algoritma Genetika
            </a>

            <div class="mt-5 px-3">
                <a href="{{ route('schedules.index') }}" class="btn btn-primary w-100 rounded-pill shadow-sm">
                    <i class="bi bi-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </nav>
    </div>

    <main class="main-content">
        <div class="container-fluid" style="max-width: 900px; margin: 0 auto;">
            @yield('content')
        </div>
    </main>
</body>
</html>
