<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Inspiration;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    /**
     * Display a listing of portfolio items.
     */
    public function index(Request $request)
    {
        $query = Inspiration::with(['category', 'package'])->latest();

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('venue_type', 'like', "%{$search}%");
            });
        }

        $inspirations = $query->paginate(12)->withQueryString();

        // Stats
        $totalCount = Inspiration::count();
        $publishedCount = Inspiration::where('is_featured', true)->count();
        $draftCount = Inspiration::where('is_featured', false)->count();
        $categoriesCount = Category::count();

        // Categories for filter tabs
        $categories = Category::orderBy('name')->pluck('name')->toArray();

        return view('admin.portfolio.index', compact(
            'inspirations',
            'totalCount',
            'publishedCount',
            'draftCount',
            'categoriesCount',
            'categories'
        ));
    }

    /**
     * Store a newly created portfolio item.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'package_id' => ['nullable', 'exists:packages,id'],
            'venue_type' => ['nullable', 'string', 'max:255'],
            'guest_capacity' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'is_featured' => ['required', 'boolean'],
            'image' => ['required', 'image', 'max:5120'], // 5MB max
        ]);

        // Handle image upload
        $imagePath = $request->file('image')->store('portfolio', 'public');

        // Generate unique slug
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;
        while (Inspiration::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        Inspiration::create([
            'category_id' => $validated['category_id'] ?? null,
            'package_id' => $validated['package_id'] ?? null,
            'title' => $validated['title'],
            'slug' => $slug,
            'venue_type' => $validated['venue_type'] ?? null,
            'guest_capacity' => $validated['guest_capacity'] ?? null,
            'description' => $validated['description'] ?? null,
            'image_path' => $imagePath,
            'is_featured' => $validated['is_featured'],
        ]);

        return redirect()->route('admin.portfolio')
            ->with('success', "Dokumentasi '{$validated['title']}' berhasil ditambahkan!");
    }

    /**
     * Update the specified portfolio item.
     */
    public function update(Request $request, Inspiration $inspiration)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'package_id' => ['nullable', 'exists:packages,id'],
            'venue_type' => ['nullable', 'string', 'max:255'],
            'guest_capacity' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'is_featured' => ['required', 'boolean'],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);

        // Update slug if title changed
        if ($inspiration->title !== $validated['title']) {
            $baseSlug = Str::slug($validated['title']);
            $slug = $baseSlug;
            $counter = 1;
            while (Inspiration::where('slug', $slug)->where('id', '!=', $inspiration->id)->exists()) {
                $slug = "{$baseSlug}-{$counter}";
                $counter++;
            }
            $inspiration->slug = $slug;
        }

        // Handle new image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($inspiration->image_path && Storage::disk('public')->exists($inspiration->image_path)) {
                Storage::disk('public')->delete($inspiration->image_path);
            }
            $imagePath = $request->file('image')->store('portfolio', 'public');
            $inspiration->image_path = $imagePath;
        }

        $inspiration->update([
            'category_id' => $validated['category_id'] ?? null,
            'package_id' => $validated['package_id'] ?? null,
            'title' => $validated['title'],
            'venue_type' => $validated['venue_type'] ?? null,
            'guest_capacity' => $validated['guest_capacity'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_featured' => $validated['is_featured'],
        ]);

        return redirect()->route('admin.portfolio')
            ->with('success', "Dokumentasi '{$inspiration->title}' berhasil diperbarui!");
    }

    /**
     * Toggle featured/published status.
     */
    public function toggleFeatured(Inspiration $inspiration)
    {
        $inspiration->is_featured = !$inspiration->is_featured;
        $inspiration->save();

        $status = $inspiration->is_featured ? 'dipublikasikan' : 'draft';
        return redirect()->route('admin.portfolio')
            ->with('success', "Dokumentasi '{$inspiration->title}' berhasil {$status}.");
    }

    /**
     * Remove the specified portfolio item.
     */
    public function destroy(Inspiration $inspiration)
    {
        // Delete image file
        if ($inspiration->image_path && Storage::disk('public')->exists($inspiration->image_path)) {
            Storage::disk('public')->delete($inspiration->image_path);
        }

        $title = $inspiration->title;
        $inspiration->delete();

        return redirect()->route('admin.portfolio')
            ->with('success', "Dokumentasi '{$title}' berhasil dihapus.");
    }
}