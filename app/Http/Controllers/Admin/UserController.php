<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $query = User::latest();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $roleMap = [
                'Customer' => 'customer',
                'Admin' => 'admin',
                'Staff' => 'keuangan',
            ];
            if (isset($roleMap[$request->role])) {
                $query->where('role', $roleMap[$request->role]);
            }
        }

        // Filter by status (assuming we add an is_active column or use a different approach)
        // For now, all users are "active" since there's no is_active column yet
        if ($request->filled('status') && $request->status === 'Nonaktif') {
            // Could add logic here if we add is_active column later
        }

        $users = $query->paginate(15)->withQueryString();

        // Stats
        $totalUsers = User::count();
        $activeUsers = User::count(); // all users are active for now
        $customerCount = User::where('role', 'customer')->count();
        $adminStaffCount = User::whereIn('role', ['admin', 'keuangan'])->count();

        return view('admin.users.index', compact(
            'users',
            'totalUsers',
            'activeUsers',
            'customerCount',
            'adminStaffCount'
        ));
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc', 'max:255', 'unique:users,email'],
            'role' => ['required', 'in:Customer,Admin,Staff'],
            'status' => ['required', 'in:Aktif,Nonaktif'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'role.required' => 'Role wajib dipilih.',
            'status.required' => 'Status wajib dipilih.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
        ]);

        // Map role from view values to database values
        $roleMap = [
            'Customer' => 'customer',
            'Admin' => 'admin',
            'Staff' => 'keuangan',
        ];

        User::create([
            'name' => trim($validated['name']),
            'email' => strtolower(trim($validated['email'])),
            'password' => Hash::make($validated['password']),
            'role' => $roleMap[$validated['role']],
            // Note: No is_active column in DB yet, so we ignore status for now
        ]);

        return redirect()->route('admin.users')
            ->with('success', "Pengguna '{$validated['name']}' berhasil ditambahkan!");
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:Customer,Admin,Staff'],
            'status' => ['required', 'in:Aktif,Nonaktif'],
            'password' => ['nullable', 'string', 'confirmed', Password::min(8)],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'role.required' => 'Role wajib dipilih.',
            'status.required' => 'Status wajib dipilih.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
        ]);

        $roleMap = [
            'Customer' => 'customer',
            'Admin' => 'admin',
            'Staff' => 'keuangan',
        ];

        $updateData = [
            'name' => trim($validated['name']),
            'email' => strtolower(trim($validated['email'])),
            'role' => $roleMap[$validated['role']],
        ];

        // Only update password if provided
        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->route('admin.users')
            ->with('success', "Data pengguna '{$user->name}' berhasil diperbarui!");
    }

    /**
     * Toggle user status (active/inactive).
     * Note: Currently no is_active column in users table.
     * This could be implemented by adding an is_active column via migration.
     */
    public function toggleStatus(User $user)
    {
        // For now, we'll just show a message since there's no is_active column
        // In the future, add migration for is_active column
        return redirect()->route('admin.users')
            ->with('error', 'Fitur nonaktifkan akun belum tersedia (perlu kolom is_active di database).');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('admin.users')
            ->with('success', "Pengguna '{$name}' berhasil dihapus.");
    }
}