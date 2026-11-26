<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    /**
     * Menampilkan daftar paket & add-on beserta kalkulasi statistik dinamis.
     */
    public function index()
    {
        $packages = Package::with('category')
            ->where('type', 'package')
            ->latest()
            ->get();

        $addons = Package::with('category')
            ->where('type', 'addon')
            ->latest()
            ->get();

        $categories = Category::all();

        // Hitung statistik dinamis
        $totalPackages = $packages->count();
        $activePackages = $packages->where('is_active', true)->count();
        $totalAddons = $addons->count();
        $minPrice = $packages->min('price') ?? 0;
        $maxPrice = $packages->max('price') ?? 0;

        return view('admin.packages.index', compact(
            'packages',
            'addons',
            'categories',
            'totalPackages',
            'activePackages',
            'totalAddons',
            'minPrice',
            'maxPrice'
        ));
    }

    /**
     * Menyimpan paket atau add-on baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:package,addon'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'normal_price' => ['nullable', 'numeric', 'min:0'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'features' => ['nullable', 'string'], // dipisahkan baris baru
            'is_active' => ['required', 'boolean'],
        ]);

        // Buat slug otomatis yang unik
        $baseSlug = Str::slug($validated['name']);
        $slug = $baseSlug;
        $counter = 1;
        while (Package::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        // Parse fitur dari textarea (per baris enter)
        $featuresArray = null;
        if (!empty($validated['features'])) {
            $featuresArray = array_values(array_filter(
                array_map('trim', explode("\n", str_replace("\r", "", $validated['features'])))
            ));
        }

        Package::create([
            'category_id' => $validated['category_id'] ?? null,
            'type' => $validated['type'],
            'name' => $validated['name'],
            'slug' => $slug,
            'tagline' => $validated['tagline'] ?? null,
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'normal_price' => $validated['normal_price'] ?? null,
            'features' => $featuresArray,
            'is_active' => $validated['is_active'],
        ]);

        $label = $validated['type'] === 'package' ? 'Paket dekorasi' : 'Add-on layanan';
        return redirect()->route('admin.packages')
            ->with('success', "{$label} '{$validated['name']}' berhasil ditambahkan ke database!");
    }

    /**
     * Memperbarui data paket atau add-on.
     */
    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:package,addon'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'normal_price' => ['nullable', 'numeric', 'min:0'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'features' => ['nullable', 'string'],
            'is_active' => ['required', 'boolean'],
        ]);

        // Perbarui slug jika nama berubah
        if ($package->name !== $validated['name']) {
            $baseSlug = Str::slug($validated['name']);
            $slug = $baseSlug;
            $counter = 1;
            while (Package::where('slug', $slug)->where('id', '!=', $package->id)->exists()) {
                $slug = "{$baseSlug}-{$counter}";
                $counter++;
            }
            $package->slug = $slug;
        }

        $featuresArray = null;
        if (!empty($validated['features'])) {
            $featuresArray = array_values(array_filter(
                array_map('trim', explode("\n", str_replace("\r", "", $validated['features'])))
            ));
        }

        $package->update([
            'category_id' => $validated['category_id'] ?? null,
            'type' => $validated['type'],
            'name' => $validated['name'],
            'tagline' => $validated['tagline'] ?? null,
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'normal_price' => $validated['normal_price'] ?? null,
            'features' => $featuresArray,
            'is_active' => $validated['is_active'],
        ]);

        return redirect()->route('admin.packages')
            ->with('success', "Perubahan data '{$package->name}' berhasil disimpan!");
    }

    /**
     * Menghapus paket atau add-on.
     */
    public function destroy(Package $package)
    {
        if ($package->reservationDetails()->exists()) {
            return redirect()->route('admin.packages')
                ->with('error', "Paket '{$package->name}' tidak dapat dihapus karena sudah memiliki riwayat pemesanan. Cukup nonaktifkan statusnya.");
        }

        $name = $package->name;
        $package->delete();

        return redirect()->route('admin.packages')
            ->with('success', "Data '{$name}' berhasil dihapus dari sistem.");
    }

    /**
     * Mengubah status aktif/nonaktif cepat.
     */
    public function toggleStatus(Package $package)
    {
        $package->is_active = !$package->is_active;
        $package->save();

        $statusLabel = $package->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.packages')
            ->with('success', "Status '{$package->name}' berhasil {$statusLabel}.");
    }
}