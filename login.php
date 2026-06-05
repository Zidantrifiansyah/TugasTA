<?php
// login.php — Halaman form login Dan's Cupang
session_start();

// Jika sudah login, langsung ke index
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: index.php');
    exit;
}

// Ambil pesan error dari query string
$error  = $_GET['error']  ?? '';
$logout = $_GET['logout'] ?? '';

$errorMsg = match($error) {
    'empty'   => 'Username dan password tidak boleh kosong.',
    'invalid' => 'Username atau password salah. Coba lagi.',
    default   => '',
};

// Pre-fill username dari cookie jika ada
$cookieName       = 'danscupang_remember';
$savedUsername    = '';
$savedRememberMe  = false;
if (isset($_COOKIE[$cookieName])) {
    $decoded = base64_decode($_COOKIE[$cookieName]);
    if ($decoded !== false) {
        $parts         = explode(':', $decoded, 2);
        $savedUsername = htmlspecialchars($parts[0] ?? '');
        $savedRememberMe = true;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login — Dan's Cupang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet" />
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0d2233 0%, #1a4a5a 50%, #0d2233 100%);
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse at 25% 50%, rgba(0,201,177,0.15) 0%, transparent 60%),
                radial-gradient(ellipse at 75% 20%, rgba(240,192,64,0.08) 0%, transparent 50%);
            pointer-events: none;
        }

        /* Dekorasi ikan melayang */
        .fish {
            position: absolute;
            pointer-events: none;
            opacity: 0.07;
            animation: floatFish 8s ease-in-out infinite;
            font-size: 3rem;
            user-select: none;
        }
        .fish:nth-child(1) { top: 8%;  left: 4%;  font-size: 3.5rem; animation-delay: 0s; }
        .fish:nth-child(2) { top: 55%; left: 6%;  font-size: 2rem;   animation-delay: 2s; }
        .fish:nth-child(3) { top: 20%; right: 5%; font-size: 4.5rem; animation-delay: 1s; }
        .fish:nth-child(4) { bottom: 12%; right: 8%; font-size: 2.5rem; animation-delay: 3s; }
        .fish:nth-child(5) { bottom: 35%; left: 14%; font-size: 1.8rem; animation-delay: 1.5s; }

        @keyframes floatFish {
            0%, 100% { transform: translateY(0)    rotate(-5deg); }
            50%       { transform: translateY(-22px) rotate(5deg); }
        }

        /* Card login */
        .login-card {
            position: relative;
            z-index: 10;
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 24px;
            padding: 48px 40px 40px;
            width: 100%;
            max-width: 420px;
            box-shadow:
                0 24px 80px rgba(0, 0, 0, 0.5),
                inset 0 1px 0 rgba(255, 255, 255, 0.18);
            animation: slideUp 0.55s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(36px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0)    scale(1); }
        }

        .brand {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: #fff;
            text-align: center;
            letter-spacing: 1px;
        }
        .brand span { color: #00c9b1; }

        .tagline {
            text-align: center;
            color: rgba(255,255,255,0.4);
            font-size: 0.78rem;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            margin: 6px 0 32px;
        }

        label {
            display: block;
            color: rgba(255,255,255,0.65);
            font-size: 0.82rem;
            font-weight: 500;
            letter-spacing: 0.4px;
            margin-bottom: 7px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 11px;
            color: #fff;
            padding: 13px 16px;
            font-size: 0.95rem;
            font-family: 'DM Sans', sans-serif;
            transition: border-color 0.25s, box-shadow 0.25s, background 0.25s;
            outline: none;
            margin-bottom: 18px;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            background: rgba(255,255,255,0.12);
            border-color: #00c9b1;
            box-shadow: 0 0 0 3px rgba(0,201,177,0.2);
        }

        input::placeholder { color: rgba(255,255,255,0.28); }

        /* Remember Me */
        .remember-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
        }

        .remember-row input[type="checkbox"] {
            width: 17px; height: 17px;
            accent-color: #00c9b1;
            cursor: pointer;
            margin: 0;
            flex-shrink: 0;
        }

        .remember-row label {
            color: rgba(255,255,255,0.6);
            font-size: 0.875rem;
            margin: 0;
            cursor: pointer;
        }

        .cookie-info {
            font-size: 0.74rem;
            color: rgba(255,255,255,0.28);
            margin-bottom: 20px;
            padding-left: 27px;
        }

        /* Alert error */
        .alert-error {
            background: rgba(220,53,69,0.15);
            border: 1px solid rgba(220,53,69,0.4);
            border-radius: 11px;
            color: #ff9090;
            padding: 11px 15px;
            font-size: 0.875rem;
            margin-bottom: 16px;
            animation: shake 0.4s ease;
        }

        /* Alert sukses (setelah logout) */
        .alert-success-custom {
            background: rgba(0,201,177,0.12);
            border: 1px solid rgba(0,201,177,0.3);
            border-radius: 11px;
            color: #00c9b1;
            padding: 11px 15px;
            font-size: 0.875rem;
            margin-bottom: 16px;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%       { transform: translateX(-8px); }
            40%       { transform: translateX(8px); }
            60%       { transform: translateX(-5px); }
            80%       { transform: translateX(5px); }
        }

        /* Tombol login */
        .btn-login {
            display: block;
            width: 100%;
            background: linear-gradient(135deg, #00c9b1, #00a896);
            color: #0d2233;
            font-weight: 700;
            font-family: 'DM Sans', sans-serif;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-size: 1rem;
            letter-spacing: 0.4px;
            cursor: pointer;
            transition: transform 0.25s, box-shadow 0.25s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 26px rgba(0,201,177,0.38);
        }

        .btn-login:active { transform: translateY(0); }

        /* Demo hint */
        .demo-hint {
            text-align: center;
            color: rgba(255,255,255,0.25);
            font-size: 0.76rem;
            margin-top: 22px;
            line-height: 1.6;
        }

        .demo-hint strong { color: rgba(255,255,255,0.45); }

        @media (max-width: 480px) {
            .login-card { margin: 16px; padding: 36px 24px 32px; }
        }
    </style>
</head>
<body>

    <!-- Dekorasi -->
    <span class="fish">🐠</span>
    <span class="fish">🐡</span>
    <span class="fish">🐟</span>
    <span class="fish">🐠</span>
    <span class="fish">🐡</span>

    <div class="login-card">
        <div class="brand">DAN'S <span>CUPANG</span></div>
        <div class="tagline">🐟Cupang berkualitas tinggi dengan harga murah</div>

        <!-- Pesan logout berhasil -->
        <?php if ($logout === '1'): ?>
            <div class="alert-success-custom">✅ Kamu berhasil keluar. Sampai jumpa!</div>
        <?php endif; ?>

        <!-- Pesan error -->
        <?php if ($errorMsg !== ''): ?>
            <div class="alert-error">⚠️ <?= htmlspecialchars($errorMsg) ?></div>
        <?php endif; ?>

        <!-- Form — action ke controller.php -->
        <form method="POST" action="controller.php?action=login" novalidate>

            <label for="username">Username</label>
            <input
                type="text"
                id="username"
                name="username"
                placeholder="Masukkan username"
                autocomplete="username"
                value="<?= $savedUsername ?>"
                required
            />

            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Masukkan password"
                autocomplete="current-password"
                required
            />

            <!-- Remember Me -->
            <div class="remember-row">
                <input
                    type="checkbox"
                    id="remember_me"
                    name="remember_me"
                    <?= $savedRememberMe ? 'checked' : '' ?>
                />
                <label for="remember_me">Ingat saya (Remember Me)</label>
            </div>
            <p class="cookie-info">🍪 Cookie tersimpan selama 30 hari di browser kamu</p>

            <button type="submit" class="btn-login">Masuk →</button>
        </form>

        <p class="demo-hint">
            Akun demo:<br>
            <strong>admin</strong> / <strong>cupang123</strong> &nbsp;·&nbsp;
            <strong>dan</strong> / <strong>betta2024</strong>
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>