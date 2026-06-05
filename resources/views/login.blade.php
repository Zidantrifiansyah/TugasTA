<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dan's Cupang</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/favicon.jpeg') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>

<body class="d-flex align-items-center min-vh-100 hero-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card shadow border-info border-opacity-25 rounded-4">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <i class="bi bi-droplet display-4 text-info"></i>
                            <h2 class="fw-bold mt-2 text-info">Dan's Cupang</h2>
                            <p class="text-muted small">Silakan masuk untuk mengelola sistem</p>
                        </div>

                        @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <form action="{{ url('/login') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="username" class="form-label fw-bold text-secondary">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" value="{{ request()->cookie('remember_username') }}" required autofocus>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold text-secondary">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                                </div>
                            </div>
                            <div class="mb-4 form-check">
                                <input type="checkbox" class="form-check-input border-info" id="remember" name="remember" {{ request()->hasCookie('remember_username') ? 'checked' : '' }}>
                                <label class="form-check-label text-muted" for="remember">Remember Me</label>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-info btn-lg rounded-pill shadow-sm">
                                    <i class="bi bi-box-arrow-in-right me-2"></i> Masuk
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>