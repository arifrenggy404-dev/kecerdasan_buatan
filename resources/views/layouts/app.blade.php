<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1024">
    <title>Algoritma Genetik - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        html, body {
            min-width: 1024px;
            overflow-x: auto;
        }
        .loading-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .dna-loader {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .dna-dots {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
        }

        .dna-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #0d6efd;
            animation: dna-bounce 1.5s infinite ease-in-out;
        }

        .dna-dot:nth-child(2) { animation-delay: 0.2s; background-color: #0dcaf0; }
        .dna-dot:nth-child(3) { animation-delay: 0.4s; background-color: #198754; }
        .dna-dot:nth-child(4) { animation-delay: 0.6s; background-color: #ffc107; }

        @keyframes dna-bounce {
            0%, 80%, 100% { transform: scale(0); opacity: 0.3; }
            40% { transform: scale(1); opacity: 1; }
        }

        .loading-card {
            background: white;
            padding: 3rem;
            border-radius: 2rem;
            box-shadow: 0 20px 50px rgba(0,0,0,0.1);
            border: 1px solid rgba(0,0,0,0.05);
            max-width: 400px;
            width: 90%;
            text-align: center;
            animation: fadeInScale 0.5s ease-out;
        }

        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }

        .pulse-text {
            animation: pulse 2s infinite;
            letter-spacing: 0.5px;
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.6; }
            100% { opacity: 1; }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <div id="loading" class="loading-overlay">
        <div class="loading-card">
            <div class="dna-loader">
                <div class="dna-dots">
                    <div class="dna-dot"></div>
                    <div class="dna-dot"></div>
                    <div class="dna-dot"></div>
                    <div class="dna-dot"></div>
                </div>
                <h4 class="fw-bold text-dark mb-2 pulse-text">Menghitung Evolusi...</h4>
                <p class="text-muted mb-0 small px-3">Algoritma Genetika sedang mencari kombinasi jadwal terbaik yang bebas bentrok.</p>
                <div class="mt-4">
                    <div class="progress" style="height: 6px; border-radius: 10px; background-color: #f0f2f5;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="cleaning" class="loading-overlay">
        <div class="loading-card">
            <div class="dna-loader">
                <div class="text-danger mb-4" style="font-size: 3rem;">
                    <i class="bi bi-trash3-fill"></i>
                </div>
                <h4 class="fw-bold text-dark mb-2 pulse-text">Membersihkan Data...</h4>
                <p class="text-muted mb-0 small px-3">Menghapus seluruh rekaman jadwal dari database sistem.</p>
                <div class="mt-4">
                    <div class="progress" style="height: 6px; border-radius: 10px; background-color: #f0f2f5;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <main class="py-5">
        <div class="container-fluid px-md-5">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show rounded-3">
                    <div class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill me-2" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show rounded-3">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    @stack('modals')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
