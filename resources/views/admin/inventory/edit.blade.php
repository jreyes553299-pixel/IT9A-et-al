@extends('layouts.admin')

@section('title', 'Edit Product')
@section('page_title', 'Update Inventory Item')

@section('content')
<div class="max-w-6xl mx-auto" x-data="{ 
    colors: {{ json_encode($product->colors ?? []) }},
    sizes: {{ json_encode($product->sizes ?? []) }},
    additional_images: {{ json_encode($product->additional_images ?? []) }},
    main_image_type: '{{ str_starts_with($product->image_url, '/storage/') ? 'upload' : 'link' }}',
    addColor() { this.colors.push({ name: '', hex: '#000000' }) },
    removeColor(index) { this.colors.splice(index, 1) },
    addImage() { this.additional_images.push('') },
    removeImage(index) { this.additional_images.splice(index, 1) }
}">
    <a href="{{ route('admin.inventory.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-stone-500 hover:text-stone-900 mb-6 transition-colors">
        <i class="ri-arrow-left-line"></i> Back to Inventory
    </a>

    <form action="{{ route('admin.inventory.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Side: Main Details -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Basic Info -->
                <div class="bg-white p-8 rounded-xl border border-stone-100 shadow-sm space-y-6">
                    <h3 class="text-sm font-bold text-stone-900 uppercase tracking-widest border-b border-stone-50 pb-4 mb-6">Product Details</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-stone-500 uppercase tracking-widest mb-2">Product Name</label>
                            <input type="text" name="name" required value="{{ old('name', $product->name) }}" placeholder="e.g. Obsidian Structured Blazer"
                                class="w-full bg-stone-50 border @error('name') border-rose-500 @else border-stone-300 @enderror rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-amber-500 transition-colors">
                            @error('name')
                                <p class="text-rose-500 text-[10px] font-bold mt-1 uppercase tracking-wider">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-stone-500 uppercase tracking-widest mb-2">Brand</label>
                            <input type="text" name="brand" value="{{ old('brand', $product->brand) }}" placeholder="e.g. MAISON NOIR"
                                class="w-full bg-stone-50 border border-stone-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-amber-500 transition-colors">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-stone-500 uppercase tracking-widest mb-2">Category</label>
                            <select name="category_id" required class="w-full bg-stone-50 border border-stone-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-amber-500 transition-colors">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-500 uppercase tracking-widest mb-2">Description</label>
                        <textarea name="description" rows="6" placeholder="Write a detailed product description..."
                            class="w-full bg-stone-50 border border-stone-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-amber-500 transition-colors resize-none">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>

                <!-- Attributes: Colors & Sizes -->
                <div class="bg-white p-8 rounded-xl border border-stone-100 shadow-sm space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                        <!-- Colors -->
                        <div>
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-sm font-bold text-stone-900 uppercase tracking-widest">Available Colors</h3>
                                <button type="button" @click="addColor()" class="text-xs font-bold text-amber-600 hover:text-amber-700 uppercase tracking-widest flex items-center gap-1">
                                    <i class="ri-add-line"></i> Add Color
                                </button>
                            </div>
                            <div class="space-y-3">
                                <template x-for="(color, index) in colors" :key="index">
                                    <div class="flex items-center gap-2">
                                        <input type="color" x-model="color.hex" class="w-10 h-10 rounded border border-stone-300 p-1 bg-white cursor-pointer">
                                        <input type="text" x-model="color.name" placeholder="Color Name" class="flex-1 bg-stone-50 border border-stone-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-amber-500 transition-colors">
                                        <button type="button" @click="removeColor(index)" class="text-rose-400 hover:text-rose-600 p-2">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                        <!-- Hidden inputs for form submission -->
                                        <input type="hidden" :name="`colors[${index}][name]`" :value="color.name">
                                        <input type="hidden" :name="`colors[${index}][hex]`" :value="color.hex">
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Sizes -->
                        <div>
                            <h3 class="text-sm font-bold text-stone-900 uppercase tracking-widest mb-6">Available Sizes</h3>
                            <div class="flex flex-wrap gap-3">
                                <template x-for="size in ['XS', 'S', 'M', 'L', 'XL', 'XXL']">
                                    <label class="cursor-pointer">
                                        <input type="checkbox" name="sizes[]" :value="size" class="hidden peer" :checked="sizes.includes(size)">
                                        <span class="w-12 h-12 flex items-center justify-center rounded-lg border border-stone-300 text-sm font-bold text-stone-500 peer-checked:border-amber-500 peer-checked:bg-amber-50 peer-checked:text-amber-600 transition-all">
                                            <span x-text="size"></span>
                                        </span>
                                    </label>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Media -->
                <div class="bg-white p-8 rounded-xl border border-stone-100 shadow-sm space-y-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-sm font-bold text-stone-900 uppercase tracking-widest">Product Gallery</h3>
                        <button type="button" @click="addImage()" class="text-xs font-bold text-amber-600 hover:text-amber-700 uppercase tracking-widest flex items-center gap-1">
                            <i class="ri-add-line"></i> Add Image
                        </button>
                    </div>
                    
                    <div class="space-y-6">
                        <!-- Main Image Toggle -->
                        <div class="bg-stone-50 p-6 rounded-xl border border-stone-200">
                            <div class="flex items-center justify-between mb-4">
                                <label class="block text-[10px] font-black text-stone-500 uppercase tracking-[0.2em]">Main Product Image</label>
                                <div class="flex items-center gap-1 p-1 bg-stone-200 rounded-lg">
                                    <button type="button" @click="main_image_type = 'link'" 
                                        :class="main_image_type === 'link' ? 'bg-white text-stone-900' : 'text-stone-500'"
                                        class="px-3 py-1 text-[10px] font-bold rounded transition-all">URL Link</button>
                                    <button type="button" @click="main_image_type = 'upload'" 
                                        :class="main_image_type === 'upload' ? 'bg-white text-stone-900' : 'text-stone-500'"
                                        class="px-3 py-1 text-[10px] font-bold rounded transition-all">Upload File</button>
                                </div>
                            </div>
                            
                            <div x-show="main_image_type === 'link'">
                                <input type="text" name="image_url" value="{{ old('image_url', $product->image_url) }}" placeholder="https://..."
                                    class="w-full bg-white border border-stone-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-amber-500 transition-colors">
                            </div>
                            <div x-show="main_image_type === 'upload'">
                                @if(str_starts_with($product->image_url, '/storage/'))
                                    <div class="mb-4 flex items-center gap-4">
                                        <img src="{{ $product->image_url }}" alt="Current" class="w-20 h-20 object-cover rounded-lg border border-stone-200 shadow-sm">
                                        <p class="text-xs text-stone-500 font-medium italic">Current local file. Upload a new one to replace it.</p>
                                    </div>
                                @endif
                                <input type="file" name="image_file" accept="image/*"
                                    class="w-full bg-white border border-stone-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-amber-500 transition-colors">
                            </div>
                        </div>

                        <!-- Additional Images -->
                        <div class="space-y-3 pt-4">
                            <label class="block text-[10px] font-black text-stone-500 uppercase tracking-[0.2em] mb-4">Additional Images (Gallery)</label>
                            <template x-for="(img, index) in additional_images" :key="index">
                                <div class="flex items-start gap-4 p-4 bg-stone-50 rounded-xl border border-stone-200">
                                    <div class="flex-1 space-y-3">
                                        <div class="flex items-center justify-between">
                                            <span class="text-[9px] font-bold text-stone-400 uppercase tracking-widest" x-text="'Image #' + (index + 1)"></span>
                                            <template x-if="img && img.startsWith('/storage/')">
                                                <img :src="img" class="w-8 h-8 object-cover rounded border border-stone-300">
                                            </template>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-[10px] font-bold text-stone-500 mb-1">URL Link</label>
                                                <input type="text" name="additional_images[]" x-model="additional_images[index]" placeholder="https://..."
                                                    class="w-full bg-white border border-stone-300 rounded-lg px-4 py-2 text-xs focus:outline-none focus:border-amber-500 transition-colors">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-bold text-stone-500 mb-1">Or Upload New</label>
                                                <input type="file" name="additional_images_files[]" accept="image/*"
                                                    class="w-full bg-white border border-stone-300 rounded-lg px-4 py-1.5 text-xs focus:outline-none focus:border-amber-500 transition-colors">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" @click="removeImage(index)" class="mt-8 text-rose-400 hover:text-rose-600 p-2">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Inventory & Pricing -->
            <div class="space-y-8">
                <!-- Pricing -->
                <div class="bg-white p-8 rounded-xl border border-stone-100 shadow-sm space-y-6">
                    <h3 class="text-sm font-bold text-stone-900 uppercase tracking-widest border-b border-stone-50 pb-4 mb-6">Pricing</h3>
                    
                    <div>
                        <label class="block text-xs font-bold text-stone-500 uppercase tracking-widest mb-2">Regular Price ($)</label>
                        <input type="number" step="0.01" name="price" required value="{{ old('price', $product->price) }}" placeholder="0.00"
                            class="w-full bg-stone-50 border border-stone-300 rounded-lg px-4 py-3 text-sm font-bold focus:outline-none focus:border-amber-500 transition-colors">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-500 uppercase tracking-widest mb-2">Original Price ($)</label>
                        <input type="number" step="0.01" name="original_price" value="{{ old('original_price', $product->original_price) }}" placeholder="0.00 (Optional)"
                            class="w-full bg-stone-50 border border-stone-300 rounded-lg px-4 py-3 text-sm text-stone-500 focus:outline-none focus:border-amber-500 transition-colors">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-500 uppercase tracking-widest mb-2">Promotion Badge</label>
                        <select name="badge" class="w-full bg-stone-50 border border-stone-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-amber-500 transition-colors">
                            <option value="">No Badge</option>
                            <option value="SALE" {{ $product->badge == 'SALE' ? 'selected' : '' }}>SALE</option>
                            <option value="NEW" {{ $product->badge == 'NEW' ? 'selected' : '' }}>NEW</option>
                            <option value="BESTSELLER" {{ $product->badge == 'BESTSELLER' ? 'selected' : '' }}>BESTSELLER</option>
                        </select>
                    </div>
                </div>

                <!-- Inventory -->
                <div class="bg-white p-8 rounded-xl border border-stone-100 shadow-sm space-y-6">
                    <h3 class="text-sm font-bold text-stone-900 uppercase tracking-widest border-b border-stone-50 pb-4 mb-6">Inventory</h3>
                    
                    <div>
                        <label class="block text-xs font-bold text-stone-500 uppercase tracking-widest mb-2">Supplier</label>
                        <select name="supplier_id" required class="w-full bg-stone-50 border border-stone-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-amber-500 transition-colors">
                            <option value="">Select Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ $product->supplier_id == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-500 uppercase tracking-widest mb-2">Stock Quantity</label>
                        <input type="number" name="stock" required value="{{ old('stock', $product->stock) }}"
                            class="w-full bg-stone-50 border border-stone-300 rounded-lg px-4 py-3 text-sm font-bold focus:outline-none focus:border-amber-500 transition-colors">
                    </div>

                    <div class="flex items-center justify-between p-4 bg-stone-50 rounded-lg">
                        <span class="text-xs font-bold text-stone-600 uppercase tracking-widest">Featured Product</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" class="sr-only peer" {{ $product->is_featured ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-stone-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-stone-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                        </label>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-stone-900 text-white py-4 rounded-xl font-bold hover:bg-stone-800 transition-all shadow-xl shadow-stone-200 flex items-center justify-center gap-2">
                        <i class="ri-save-line text-lg"></i> Update Product
                    </button>
                    <a href="{{ route('admin.inventory.index') }}" class="block text-center mt-4 text-xs font-bold text-stone-500 hover:text-stone-900 uppercase tracking-widest transition-colors">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
