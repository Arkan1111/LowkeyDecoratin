<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
  
public function index()
{
    $totalProducts = Product::count();

    $totalCategories = Category::count();

    $totalStock = Product::sum('stock');

    return view('admin.dashboard', compact(
        'totalProducts',
        'totalCategories',
        'totalStock'
    ));
}

    // Menampilkan kategori
    public function categories()
    {
        $categories = Category::latest()->get();

        return view('admin.categories', compact('categories'));
    }

    // Menyimpan kategori
    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        Category::create($data);

        return back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    // Mengubah kategori
    public function updateCategory(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $category->update($data);

        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    // Menghapus kategori
    public function destroyCategory(Category $category)
    {
        $category->delete();

        return back()->with('success', 'Kategori berhasil dihapus.');
    }

    // Menampilkan produk
    public function products()
    {
        $products = Product::with('category')->latest()->get();
        $categories = Category::orderBy('name')->get();

        return view('admin.products', compact('products', 'categories'));
    }

    // Menyimpan produk
    public function storeProduct(Request $request)
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        Product::create($data);

        return back()->with('success', 'Produk berhasil ditambahkan.');
    }

    // Mengubah produk
    public function updateProduct(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        $product->update($data);

        return back()->with('success', 'Produk berhasil diperbarui.');
    }

    // Menghapus produk
    public function destroyProduct(Product $product)
    {
        $product->delete();

        return back()->with('success', 'Produk berhasil dihapus.');
    }
}
