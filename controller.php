<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('COOKIE_NAME',     'danscupang_remember');
define('COOKIE_DURATION', 30 * 24 * 60 * 60);   // 30 hari (detik)
define('COOKIE_PATH',     '/');

$USERS = [
    'admin' => [
        'password' => password_hash('cupang123', PASSWORD_BCRYPT),
        'nama'     => 'Administrator',
    ],
    'dan'   => [
        'password' => password_hash('betta2024', PASSWORD_BCRYPT),
        'nama'     => 'Dan Owner',
    ],
];


function setRememberMe(string $username): void {
    $token = base64_encode($username . ':' . hash('sha256', $username . SECRET_KEY . time()));
    setcookie(
        COOKIE_NAME,
        $token,
        [
            'expires'  => time() + COOKIE_DURATION,
            'path'     => COOKIE_PATH,
            'httponly' => true,        
            'samesite' => 'Lax',
        ]
    );
}


function getRememberMe(): ?string {
    if (!isset($_COOKIE[COOKIE_NAME])) return null;

    $decoded = base64_decode($_COOKIE[COOKIE_NAME]);
    if ($decoded === false) return null;

    // Ambil bagian username (sebelum ":")
    $parts = explode(':', $decoded, 2);
    return $parts[0] ?? null;
}

/**
 * Hapus cookie remember me
 */
function clearRememberMe(): void {
    setcookie(COOKIE_NAME, '', [
        'expires'  => time() - 3600,
        'path'     => COOKIE_PATH,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
}

/**
 * Redirect ke halaman tertentu
 */
function redirect(string $url): void {
    header("Location: $url");
    exit;
}

// ---------- SECRET KEY (ganti di production) ----------
define('SECRET_KEY', 'danscupang_secret_2026_abc');

// ============================================================
//  ROUTING — tentukan action dari POST/GET
// ============================================================
$action = $_POST['action'] ?? $_GET['action'] ?? '';

// ---- CEK AUTO-LOGIN via Cookie (sebelum routing) ----
if (!isset($_SESSION['logged_in']) && $action === '') {
    $cookieUser = getRememberMe();
    if ($cookieUser && isset($USERS[$cookieUser])) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username']  = $cookieUser;
        $_SESSION['nama']      = $USERS[$cookieUser]['nama'];
        // Perbarui cookie agar tidak expired
        setRememberMe($cookieUser);
    }
}

// ============================================================
switch ($action) {

    // ----------------------------------------------------------
    case 'login':
    // ----------------------------------------------------------
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('login.php');
        }

        $username   = trim($_POST['username'] ?? '');
        $password   = $_POST['password'] ?? '';
        $rememberMe = isset($_POST['remember_me']);

        // Validasi input kosong
        if ($username === '' || $password === '') {
            redirect('login.php?error=empty');
        }

        // Cek user & verifikasi password
        if (isset($USERS[$username]) &&
            password_verify($password, $USERS[$username]['password']))
        {
            // ✅ Login berhasil — buat session
            session_regenerate_id(true);   // cegah session fixation
            $_SESSION['logged_in'] = true;
            $_SESSION['username']  = $username;
            $_SESSION['nama']      = $USERS[$username]['nama'];

            // ✅ Remember Me — simpan cookie 30 hari
            // Simpan cookie selalu agar session dapat dipulihkan setelah tab/servidor direstart
            setRememberMe($username);

            redirect('../index.php?login=success');

        } else {
            // ❌ Login gagal
            redirect('login.php?error=invalid');
        }
        break;

    // ----------------------------------------------------------
    case 'logout':
    // ----------------------------------------------------------
        // Hapus semua data session
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(
                session_name(), '',
                [
                    'expires'  => time() - 42000,
                    'path'     => $p['path'],
                    'domain'   => $p['domain'],
                    'secure'   => $p['secure'],
                    'httponly' => $p['httponly'],
                    'samesite' => 'Lax',
                ]
            );
        }
        session_destroy();

        // Hapus cookie remember me
        clearRememberMe();

        redirect('login.php?logout=1');
        break;

    // ----------------------------------------------------------
    case 'check':
    // ----------------------------------------------------------
        // Endpoint JSON — cek apakah user sedang login
        // Dipakai oleh JavaScript (fetch/AJAX) jika dibutuhkan
        header('Content-Type: application/json');
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            echo json_encode([
                'logged_in' => true,
                'username'  => $_SESSION['username'],
                'nama'      => $_SESSION['nama'],
            ]);
        } else {
            echo json_encode(['logged_in' => false]);
        }
        exit;

    // ----------------------------------------------------------
    case 'status':
    // ----------------------------------------------------------
        // Debug endpoint: tampilkan status session & cookie (debug lokal saja)
        header('Content-Type: application/json');
        $cookie = $_COOKIE[COOKIE_NAME] ?? null;
        $decoded = $cookie ? base64_decode($cookie) : null;
        $cookieUser = null;
        if ($decoded !== false && $decoded !== null) {
            $parts = explode(':', $decoded, 2);
            $cookieUser = $parts[0] ?? null;
        }

        echo json_encode([
            'session_status' => session_status(),
            'session' => $_SESSION,
            'cookie_raw' => $cookie,
            'cookie_user' => $cookieUser,
        ], JSON_PRETTY_PRINT);
        exit;

    // ----------------------------------------------------------
    default:
    // ----------------------------------------------------------
        // Tidak ada action — redirect ke index atau login
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            redirect('../index.php');
        } else {
            redirect('login.php');
        }
        break;
}