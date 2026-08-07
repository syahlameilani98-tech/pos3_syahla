<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'POS Application')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f8f9fa;
            color: #212529;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            min-height: 100vh;
        }

        /* Standardized Buttons */
        .btn-primary {
            background-color: #0d6efd !important;
            border-color: #0d6efd !important;
        }
        .btn-primary:hover {
            background-color: #0b5ed7 !important;
            border-color: #0a58ca !important;
        }

        /* Card & Table Styling */
        .card {
            border-radius: 8px;
            border: 1px solid rgba(0,0,0,.125);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }
        .card-header-blue {
            background-color: #0d6efd !important;
            color: #ffffff !important;
        }

        .table thead {
            background-color: #f1f3f5;
        }

        /* Alert Styling */
        .alert-success {
            background-color: #d1e7dd !important;
            border-color: #badbcc !important;
            color: #0f5132 !important;
        }
    </style>
</head>
<body>



    <div class="container py-4">
        {{-- Pesan Notifikasi --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Konten Utama --}}
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>