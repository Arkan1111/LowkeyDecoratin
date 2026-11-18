<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class CustomerLoginController extends Controller
{
    // Menampilkan halaman login klien
    public function create()
    {
        return view('auth.login');
    }

    // Memproses login klien
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email:rfc', 'max:255'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Cari akun dengan role customer
        $user = User::where('email', strtolower(trim($validated['email'])))
            ->where('role', 'customer')
            ->first();

        // Periksa akun dan password
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return back()
                ->withErrors([
                    'login' => 'Email atau password klien tidak sesuai.'
                ])
                ->onlyInput('email');
        }

        // Login klien
        Auth::login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        return redirect()->intended('/');
    }
}
