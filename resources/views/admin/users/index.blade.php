@extends('admin.layouts.app')

@section('title', 'Mengelola Data Pengguna')

@section('content')
<section class="admin-page-heading admin-heading-with-action">
    <div class="admin-heading-accent"></div>
    <div class="admin-heading-copy">
        <p class="admin-eyebrow">MANAJEMEN AKUN / PENGGUNA</p>
        <h1>Mengelola Data Pengguna</h1>
        <p class="admin-page-subtitle">Kelola akun pelanggan dan tim yang memiliki akses ke sistem Lowkey Decoration.</p>
    </div>
    <button type="button" class="admin-primary-button" onclick="openUserModal()">＋ Tambah Pengguna</button>
</section>

{{-- NOTIFIKASI --}}
@if(session('success'))
<div style="background: #e6f4ea; border-left: 4px solid #34a853; color: #137333; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-weight: 500;">
    ✓ {{ session('success') }}
</div>
@endif

@if(session('error'))
<div style="background: #fce8e6; border-left: 4px solid #ea4335; color: #c5221f; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-weight: 500;">
    ✕ {{ session('error') }}
</div>
@endif

@if($errors->any())
<div style="background: #fce8e6; border-left: 4px solid #ea4335; color: #c5221f; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px;">
    <strong>Gagal menyimpan data:</strong>
    <ul style="margin: 6px 0 0 20px;">
        @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- STATISTIK DINAMIS --}}
<section class="admin-stats-grid admin-compact-stats">
    <article class="admin-stat-card">
        <div class="admin-stat-icon stat-icon-gold"><span>♙</span></div>
        <div class="admin-stat-content">
            <span class="admin-stat-label">Total Pengguna</span>
            <div class="admin-stat-value-row"><strong>{{ $totalUsers }}</strong></div>
            <small>Seluruh akun terdaftar</small>
        </div>
        <span class="admin-stat-decoration"></span>
    </article>

    <article class="admin-stat-card">
        <div class="admin-stat-icon stat-icon-green"><span>✓</span></div>
        <div class="admin-stat-content">
            <span class="admin-stat-label">Akun Aktif</span>
            <div class="admin-stat-value-row"><strong>{{ $activeUsers }}</strong></div>
            <small>Dapat mengakses sistem</small>
        </div>
        <span class="admin-stat-decoration"></span>
    </article>

    <article class="admin-stat-card">
        <div class="admin-stat-icon stat-icon-peach"><span>♧</span></div>
        <div class="admin-stat-content">
            <span class="admin-stat-label">Pelanggan</span>
            <div class="admin-stat-value-row"><strong>{{ $customerCount }}</strong></div>
            <small>Akun customer</small>
        </div>
        <span class="admin-stat-decoration"></span>
    </article>

    <article class="admin-stat-card">
        <div class="admin-stat-icon stat-icon-gold"><span>♙</span></div>
        <div class="admin-stat-content">
            <span class="admin-stat-label">Admin & Tim</span>
            <div class="admin-stat-value-row"><strong>{{ $adminStaffCount }}</strong></div>
            <small>Pengelola operasional</small>
        </div>
        <span class="admin-stat-decoration"></span>
    </article>
</section>

{{-- TABEL PENGGUNA --}}
<section class="admin-panel admin-feature-panel">
    <div class="admin-panel-heading admin-feature-heading">
        <div class="admin-panel-title-wrap"><span class="admin-panel-icon">♙</span><h2>Daftar Pengguna</h2></div>
    </div>

    {{-- TOOLBAR PENCARIAN & FILTER --}}
    <form method="GET" action="{{ route('admin.users') }}" class="admin-feature-toolbar">
        <div class="admin-toolbar-filters admin-toolbar-filters-full">
            <label class="admin-filter-search">
                <span>⌕</span>
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email pengguna...">
            </label>
            <select name="role" class="admin-select" onchange="this.form.submit()" aria-label="Filter role">
                <option value="">Semua Role</option>
                <option value="Customer" {{ request('role') === 'Customer' ? 'selected' : '' }}>Customer</option>
                <option value="Admin" {{ request('role') === 'Admin' ? 'selected' : '' }}>Admin</option>
                <option value="Staff" {{ request('role') === 'Staff' ? 'selected' : '' }}>Staff</option>
            </select>
            <select name="status" class="admin-select" onchange="this.form.submit()" aria-label="Filter status">
                <option value="">Semua Status</option>
                <option value="Aktif" {{ request('status') === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Nonaktif" {{ request('status') === 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
            @if(request('search') || request('role') || request('status'))
                <a href="{{ route('admin.users') }}" style="font-size: 13px; color: #888; text-decoration: underline; align-self: center;">Reset Filter</a>
            @endif
        </div>
    </form>

    <div class="admin-table-wrap">
        <table class="admin-data-table" id="userTable">
            <thead>
                <tr>
                    <th>Pengguna</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Tanggal Bergabung</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                @php
                    $roleLabel = match($user->role) {
                        'customer' => 'Customer',
                        'admin' => 'Admin',
                        'keuangan' => 'Staff',
                        default => ucfirst($user->role)
                    };
                    $roleClass = match($user->role) {
                        'customer' => 'role-customer',
                        'admin' => 'role-admin',
                        'keuangan' => 'role-staff',
                        default => ''
                    };
                    $initials = strtoupper(substr($user->name ?? 'US', 0, 2));
                @endphp
                <tr>
                    <td>
                        <span class="admin-customer-cell">
                            <span class="admin-customer-avatar">{{ $initials }}</span>
                            {{ $user->name }}
                        </span>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="admin-role-pill {{ $roleClass }}">{{ $roleLabel }}</span>
                    </td>
                    <td>{{ $user->created_at->translatedFormat('d M Y') }}</td>
                    <td>
                        <span class="admin-status status-approved"><i></i>Aktif</span>
                    </td>
                    <td>
                        <button class="admin-row-action" type="button" onclick="editUser({{ json_encode($user) }})">Edit</button>
                        @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna {{ $user->name }}?');">
                                @csrf @method('DELETE')
                                <button class="admin-row-action danger" type="submit">Hapus</button>
                            </form>
                        @else
                            <button class="admin-row-action" disabled style="opacity:0.5; cursor:not-allowed;" title="Tidak bisa hapus diri sendiri">Hapus</button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 30px; color: #777;">
                        Belum ada data pengguna. Klik <strong>＋ Tambah Pengguna</strong> untuk membuat akun baru.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div class="admin-table-footer" style="padding: 15px; display:flex; justify-content:space-between; align-items:center;">
        <span>Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} pengguna</span>
        <div>{{ $users->links() }}</div>
    </div>
    @endif
</section>

{{-- MODAL TAMBAH & EDIT PENGGUNA --}}
<div class="admin-modal" id="userModal" aria-hidden="true">
    <div class="admin-modal-backdrop" onclick="closeUserModal()"></div>
    <div class="admin-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="userModalTitle">
        <div class="admin-modal-heading">
            <div>
                <p class="admin-eyebrow">AKUN SISTEM</p>
                <h2 id="userModalTitle">Tambah Pengguna</h2>
            </div>
            <button type="button" class="admin-modal-close" onclick="closeUserModal()" aria-label="Tutup">×</button>
        </div>

        <form id="userForm" action="{{ route('admin.users.store') }}" method="POST" class="admin-demo-form" style="max-height: 85vh; overflow-y: auto;">
            @csrf
            <div id="methodContainer"></div>

            <label>
                Nama Lengkap
                <input type="text" name="name" id="modalName" placeholder="Masukkan nama lengkap" required>
            </label>

            <label>
                Alamat Email
                <input type="email" name="email" id="modalEmail" placeholder="nama@email.com" required>
            </label>

            <div class="admin-form-two">
                <label>
                    Role
                    <select name="role" id="modalRole" required>
                        <option value="">Pilih role</option>
                        <option value="Customer">Customer</option>
                        <option value="Admin">Admin</option>
                        <option value="Staff">Staff</option>
                    </select>
                </label>
                <label>
                    Status
                    <select name="status" id="modalStatus">
                        <option value="Aktif">Aktif</option>
                        <option value="Nonaktif">Nonaktif</option>
                    </select>
                </label>
            </div>

            <label id="passwordLabel">
                Kata Sandi
                <input type="password" name="password" id="modalPassword" placeholder="Minimal 8 karakter" required>
                <small style="color:#888; font-size:12px;">Biarkan kosong untuk tidak mengubah kata sandi (saat edit)</small>
            </label>

            <label>
                Konfirmasi Kata Sandi
                <input type="password" name="password_confirmation" id="modalPasswordConfirm" placeholder="Ulangi kata sandi">
            </label>

            <div class="admin-modal-actions" style="margin-top: 15px;">
                <button type="button" class="admin-secondary-button" onclick="closeUserModal()">Batal</button>
                <button type="submit" class="admin-primary-button" id="modalSubmitBtn">Simpan Pengguna</button>
            </div>
        </form>
    </div>
</div>

{{-- TOAST NOTIFICATION --}}
<div class="admin-toast" role="status" aria-live="polite"></div>

<script>
function openUserModal() {
    document.getElementById('userModalTitle').innerText = 'Tambah Pengguna';
    document.getElementById('userForm').action = "{{ route('admin.users.store') }}";
    document.getElementById('methodContainer').innerHTML = '';
    document.getElementById('modalSubmitBtn').innerText = 'Simpan Pengguna';

    document.getElementById('userForm').reset();
    document.getElementById('passwordLabel').style.display = 'block';
    document.getElementById('modalPassword').required = true;

    const modal = document.getElementById('userModal');
    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
}

function closeUserModal() {
    const modal = document.getElementById('userModal');
    modal.classList.remove('is-open');
    modal.setAttribute('aria-hidden', 'true');
}

function editUser(user) {
    document.getElementById('userModalTitle').innerText = 'Edit ' + user.name;
    document.getElementById('userForm').action = "/admin/pengguna/" + user.id;
    document.getElementById('methodContainer').innerHTML = '@method("PUT")';
    document.getElementById('modalSubmitBtn').innerText = 'Perbarui Data';

    document.getElementById('modalName').value = user.name;
    document.getElementById('modalEmail').value = user.email;

    // Map role from DB to view values
    const roleMap = { 'customer': 'Customer', 'admin': 'Admin', 'keuangan': 'Staff' };
    document.getElementById('modalRole').value = roleMap[user.role] || 'Customer';
    document.getElementById('modalStatus').value = 'Aktif'; // No is_active column yet

    // Password optional on edit
    document.getElementById('modalPassword').value = '';
    document.getElementById('modalPasswordConfirm').value = '';
    document.getElementById('passwordLabel').style.display = 'block';
    document.getElementById('modalPassword').required = false;
    document.getElementById('modalPassword').placeholder = 'Biarkan kosong untuk tidak mengubah';

    const modal = document.getElementById('userModal');
    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
}

// Toast notification
@if(session('success'))
document.addEventListener('DOMContentLoaded', function() {
    showToast('{{ session('success') }}', 'success');
});
@endif

@if(session('error'))
document.addEventListener('DOMContentLoaded', function() {
    showToast('{{ session('error') }}', 'error');
});
@endif

function showToast(message, type = 'success') {
    const toast = document.querySelector('.admin-toast');
    toast.textContent = message;
    toast.style.background = type === 'success' ? '#34a853' : '#ea4335';
    toast.style.color = 'white';
    toast.style.display = 'block';
    setTimeout(() => { toast.style.display = 'none'; }, 4000);
}
</script>
@endsection