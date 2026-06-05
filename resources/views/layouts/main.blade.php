<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title') - Dan's Cupang</title>

    <link rel="icon" type="image/jpeg" href="{{ asset('assets/favicon.jpeg') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>

<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark bg-info shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                <i class="bi bi-droplet me-2"></i>Dan's Cupang
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                            <i class="bi bi-house-door me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('order') ? 'active' : '' }}" href="{{ url('/order') }}">
                            <i class="bi bi-cart-plus me-1"></i>Pesan
                        </a>
                    </li>
                    @if(session()->has('login'))
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('products*') ? 'active' : '' }}" href="{{ url('/products') }}">
                            <i class="bi bi-box me-1"></i>Produk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('orders*') ? 'active' : '' }}" href="{{ url('/orders') }}">
                            <i class="bi bi-clipboard-check me-1"></i>Pesanan
                        </a>
                    </li>
                    @endif
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        <button id="btnTema" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-moon-fill" id="ikonTema"></i>
                        </button>
                    </li>
                    @if(session()->has('login'))
                    <li class="nav-item ms-lg-3 me-lg-3 mt-2 mt-lg-0 d-flex align-items-center">
                        <span class="text-white fw-medium">
                            <i class="bi bi-person-circle me-1"></i> {{ session('username') }}
                        </span>
                    </li>
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        <a href="{{ url('/logout') }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin keluar?');">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="bg-info text-white text-center py-3 mt-auto shadow-sm">
        <div class="container">
            <p class="mb-0">&copy; 2026 Dan's Cupang - Penjualan Ikan Cupang Berkualitas</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>