<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminLoginController extends Controller
{
    // Menampilkan halaman login admin
    public function create()
    {
        return view('auth.admin.login');
    }

    // Memproses login admin dan tim
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

        // Cari akun admin atau staff
        $user = User::where('email', strtolower(trim($validated['email'])))
            ->whereIn('role', ['admin', 'staff'])
            ->first();

        // Periksa akun dan password
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return back()
                ->withErrors([
                    'login' => 'Email atau password Admin/Tim tidak sesuai.'
                ])
                ->onlyInput('email');
        }

        // Login admin atau staff
        Auth::login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        return redirect()->intended('/admin/dashboard');
    }
}
