<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'image_url' => 'required_without:image_file|nullable|string',
            'image_file' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('categories', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        $validated['slug'] = Str::slug($validated['name']);
        
        // Remove temporary file field before saving to DB
        unset($validated['image_file']);
        
        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'image_url' => 'required_without:image_file|nullable|string',
            'image_file' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('categories', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        $validated['slug'] = Str::slug($validated['name']);
        
        // Remove temporary file field before updating DB
        unset($validated['image_file']);
        
        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        try {
            // Note: Database is set to CASCADE delete products in this category
            $category->delete();
            return redirect()->route('admin.categories.index')->with('success', 'Category removed successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.categories.index')->with('error', 'Error deleting category: ' . $e->getMessage());
        }
    }
}
