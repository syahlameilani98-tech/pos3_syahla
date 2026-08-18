<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'POS Application')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
          rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f8f9fa;
            color: #212529;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto,
                         "Helvetica Neue", Arial, sans-serif;
            min-height: 100vh;
        }

        .navbar-brand {
            font-weight: bold;
        }

        .navbar .nav-link {
            color: white !important;
            margin-right: 10px;
        }

        .navbar .nav-link:hover {
            color: #cfe2ff !important;
        }

        .btn-primary {
            background-color: #0d6efd !important;
            border-color: #0d6efd !important;
        }

        .btn-primary:hover {
            background-color: #0b5ed7 !important;
            border-color: #0a58ca !important;
        }

        .card {
            border-radius: 8px;
            border: 1px solid rgba(0, 0, 0, .125);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .card-header-blue {
            background-color: #0d6efd !important;
            color: #ffffff !important;
        }

        .table thead {
            background-color: #f1f3f5;
        }

        .alert-success {
            background-color: #d1e7dd !important;
            border-color: #badbcc !important;
            color: #0f5132 !important;
        }
    </style>
</head>

<body>

    {{-- ================= NAVBAR ================= --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">

        {{-- Full Width Navbar --}}
        <div class="container-fluid px-4">

            {{-- LOGO --}}
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="bi bi-shop me-2"></i>
                Point Of Sale
            </a>

            {{-- TOMBOL MENU MOBILE --}}
            <button class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarMenu"
                    aria-controls="navbarMenu"
                    aria-expanded="false"
                    aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- MENU NAVBAR --}}
            <div class="collapse navbar-collapse" id="navbarMenu">

                {{-- MENU KIRI --}}
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    {{-- DASHBOARD --}}
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('dashboard') ? 'active fw-bold' : '' }}"
                           href="{{ route('dashboard') }}">

                            <i class="bi bi-speedometer2 me-1"></i>
                            Dashboard

                        </a>
                    </li>

                    {{-- USERS --}}
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('admin/users*') ? 'active fw-bold' : '' }}"
                           href="{{ route('admin.users.index') }}">

                            <i class="bi bi-people me-1"></i>
                            Users

                        </a>
                    </li>

                    {{-- PRODUK --}}
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('produk*') ? 'active fw-bold' : '' }}"
                           href="{{ route('produk.index') }}">

                            <i class="bi bi-box-seam me-1"></i>
                            Produk

                        </a>
                    </li>

                    {{-- PENJUALAN --}}
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('penjualan*') ? 'active fw-bold' : '' }}"
                           href="{{ route('penjualan.index') }}">

                            <i class="bi bi-cart-check me-1"></i>
                            Penjualan

                        </a>
                    </li>

                </ul>

                {{-- ================= LOGOUT ================= --}}
                <form action="{{ route('logout') }}"
                      method="POST"
                      class="d-flex mb-0">

                    @csrf

                    <button type="submit"
                            class="btn btn-danger btn-sm px-3 fw-semibold">

                        <i class="bi bi-box-arrow-right me-1"></i>
                        Logout

                    </button>

                </form>

            </div>
        </div>
    </nav>


    {{-- ================= KONTEN ================= --}}
    <div class="container py-4">

        {{-- NOTIFIKASI SUCCESS --}}
        @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show shadow-sm"
                 role="alert">

                <i class="bi bi-check-circle-fill me-2"></i>

                {{ session('success') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close">
                </button>

            </div>

        @endif

        {{-- KONTEN HALAMAN --}}
        @yield('content')

    </div>


    {{-- ================= BOOTSTRAP JS ================= --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>