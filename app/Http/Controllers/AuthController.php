<?php

namespace App\Http\Controllers;

use App\Models\CupangProduct;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        if (!session()->has('login')) {
            return redirect('/login');
        }

        $products = CupangProduct::all();

        return view('index', compact('products'));
    }

    public function kelola()
    {
        if (!session()->has('login')) {
            return redirect('/login');
        }

        return view('kelola');
    }

    public function showLogin()
    {
        if (session()->has('login')) {
            return redirect('/');
        }

        return view('login');
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $validUsers = [
            'admin' => 'cupang123',
            'dan'   => 'betta2024',
        ];

        if (
            isset($validUsers[$username]) &&
            $validUsers[$username] === $password
        ) {

            session([
                'login' => true,
                'username' => $username
            ]);

            return redirect('/');
        }

        return redirect('/login')
            ->with('error', 'Username atau password salah!');
    }

    public function logout()
    {
        session()->flush();

        return redirect('/login');
    }
}