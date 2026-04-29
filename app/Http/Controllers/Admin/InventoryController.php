<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;

class InventoryController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'supplier')->latest()->get();
        $metrics = [
            'total' => Product::count(),
            'low_stock' => Product::where('stock', '<', 10)->where('stock', '>', 0)->count(),
            'out_of_stock' => Product::where('stock', 0)->count(),
            'total_value' => Product::sum(\DB::raw('price * stock'))
        ];
        return view('admin.inventory.index', compact('products', 'metrics'));
    }

    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('admin.inventory.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'brand' => 'nullable|string|max:255',
            'name' => 'required|string|max:255|unique:products,name',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'badge' => 'nullable|string|max:50',
            'image_url' => 'required_without:image_file|nullable|string',
            'image_file' => 'nullable|image|max:5120',
            'additional_images' => 'nullable|array',
            'additional_images.*' => 'nullable|string',
            'additional_images_files' => 'nullable|array',
            'additional_images_files.*' => 'nullable|image|max:5120',
            'colors' => 'nullable|array',
            'sizes' => 'nullable|array',
            'stock' => 'required|integer|min:0',
            'is_featured' => 'nullable|boolean',
        ]);

        // Handle Main Image Upload
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('products', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        // Handle Additional Images Uploads
        $additional_images = isset($validated['additional_images']) ? array_filter($validated['additional_images']) : [];
        if ($request->hasFile('additional_images_files')) {
            foreach ($request->file('additional_images_files') as $file) {
                $path = $file->store('products', 'public');
                $additional_images[] = '/storage/' . $path;
            }
        }
        $validated['additional_images'] = $additional_images;

        $validated['is_featured'] = $request->has('is_featured');
        
        // Remove temporary file fields before saving to DB
        unset($validated['image_file']);
        unset($validated['additional_images_files']);

        Product::create($validated);

        return redirect()->route('admin.inventory.index')->with('success', 'Product added to inventory successfully!');
    }

    public function show(Product $inventory)
    {
        $inventory->load('category', 'supplier');
        return response()->json($inventory);
    }

    public function edit(Product $inventory)
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('admin.inventory.edit', ['product' => $inventory, 'categories' => $categories, 'suppliers' => $suppliers]);
    }

    public function update(Request $request, Product $inventory)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'brand' => 'nullable|string|max:255',
            'name' => 'required|string|max:255|unique:products,name,' . $inventory->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'badge' => 'nullable|string|max:50',
            'image_url' => 'required_without:image_file|nullable|string',
            'image_file' => 'nullable|image|max:5120',
            'additional_images' => 'nullable|array',
            'additional_images.*' => 'nullable|string',
            'additional_images_files' => 'nullable|array',
            'additional_images_files.*' => 'nullable|image|max:5120',
            'colors' => 'nullable|array',
            'sizes' => 'nullable|array',
            'stock' => 'required|integer|min:0',
            'is_featured' => 'nullable|boolean',
        ]);

        // Handle Main Image Upload
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('products', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        // Handle Additional Images Uploads
        $additional_images = isset($validated['additional_images']) ? array_filter($validated['additional_images']) : [];
        if ($request->hasFile('additional_images_files')) {
            foreach ($request->file('additional_images_files') as $file) {
                $path = $file->store('products', 'public');
                $additional_images[] = '/storage/' . $path;
            }
        }
        $validated['additional_images'] = $additional_images;

        $validated['is_featured'] = $request->has('is_featured');
        
        // Remove temporary file fields before updating DB
        unset($validated['image_file']);
        unset($validated['additional_images_files']);

        $inventory->update($validated);

        return redirect()->route('admin.inventory.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $inventory)
    {
        $inventory->delete();
        return redirect()->route('admin.inventory.index')->with('success', 'Product removed from inventory!');
    }
}
