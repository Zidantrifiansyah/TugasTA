<?php

namespace App\Http\Controllers;

use App\Models\CupangProduct;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // 1. Menampilkan halaman Beranda
    public function index()
    {
        $products = CupangProduct::all();
        return view('index', compact('products'));
    }

    // 2. Menampilkan halaman Kelola Data
    public function kelola()
    {
        if (!session()->has('login')) {
            return redirect('/login');
        }
        return view('kelola');
    }

    // 3. Menampilkan form Login
    public function showLogin()
    {
        // Jika sudah login, jangan biarkan masuk ke halaman login lagi
        if (session()->has('login')) {
            return redirect('/');
        }
        return view('login');
    }

    // 4. Memproses data dari form Login (POST)
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        // Kredensial untuk Dan's Cupang
        $validUsers = [
            'admin' => 'cupang123',
            'dan'   => 'betta2024',
        ];

        if (isset($validUsers[$username]) && $validUsers[$username] === $password) {

            // Set Session di Laravel
            session(['login' => true, 'username' => $username]);

            // Jika "Remember Me" dicentang, buat cookie selama 30 hari (43200 menit)
            if ($request->has('remember')) {
                $cookie = cookie('remember_username', $username, 43200);
                return redirect('/')->withCookie($cookie);
            } else {
                // Jika tidak dicentang, hapus cookie (set waktu ke masa lalu)
                $cookie = cookie()->forget('remember_username');
                return redirect('/')->withCookie($cookie);
            }
        }

        // Jika gagal login, kembalikan ke halaman login dengan pesan error (Flash Session)
        return redirect('/login')->with('error', 'Username atau password salah!');
    }

    // 5. Menghancurkan sesi (Logout)
    public function logout()
    {
        // Hapus seluruh session
        session()->flush();

        return redirect('/login');
    }
}
