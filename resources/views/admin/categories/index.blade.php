@extends('layouts.admin')

@section('title', 'Categories')
@section('page_title', 'Product Categories')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8" x-data="{ main_image_type: 'link' }">
    <!-- Add Category Form -->
    <div class="lg:col-span-1">
        <div class="bg-white p-8 rounded-2xl border border-stone-300 shadow-sm sticky top-8">
            <h3 class="text-sm font-bold text-stone-900 uppercase tracking-widest border-b border-stone-100 pb-4 mb-6">Create Category</h3>
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-stone-500 uppercase tracking-widest mb-2">Category Name</label>
                    <input type="text" name="name" required placeholder="e.g. Modern Minimalist"
                        class="w-full bg-stone-50 border border-stone-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-amber-500 transition-all">
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-bold text-stone-500 uppercase tracking-widest">Thumbnail</label>
                        <div class="flex items-center gap-1 p-1 bg-stone-100 rounded-lg">
                            <button type="button" @click="main_image_type = 'link'" 
                                :class="main_image_type === 'link' ? 'bg-white text-stone-900 shadow-sm' : 'text-stone-500'"
                                class="px-2 py-1 text-[10px] font-bold rounded transition-all">Link</button>
                            <button type="button" @click="main_image_type = 'upload'" 
                                :class="main_image_type === 'upload' ? 'bg-white text-stone-900 shadow-sm' : 'text-stone-500'"
                                class="px-2 py-1 text-[10px] font-bold rounded transition-all">File</button>
                        </div>
                    </div>

                    <div x-show="main_image_type === 'link'">
                        <input type="text" name="image_url" placeholder="https://..."
                            class="w-full bg-stone-50 border border-stone-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-amber-500 transition-all">
                    </div>
                    <div x-show="main_image_type === 'upload'">
                        <input type="file" name="image_file" accept="image/*"
                            class="w-full bg-stone-50 border border-stone-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:border-amber-500 transition-all">
                    </div>
                </div>

                <button type="submit" class="w-full bg-stone-900 text-white py-4 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-stone-800 transition-all shadow-xl shadow-stone-200">
                    Add Category
                </button>
            </form>
        </div>
    </div>

    <!-- Category List -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border border-stone-300 shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-stone-50/30">
                        <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-[0.2em] border-b border-stone-300">Category</th>
                        <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-[0.2em] border-b border-stone-300">Slug</th>
                        <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-[0.2em] border-b border-stone-300">Products</th>
                        <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-[0.2em] border-b border-stone-300 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($categories as $category)
                    <tr class="hover:bg-stone-50/50 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-lg bg-stone-100 overflow-hidden border border-stone-300">
                                    <img src="{{ $category->image_url ?? 'https://readdy.ai/api/search-image?query=minimalist%20aesthetic%20texture&width=100&height=100' }}" alt="" class="w-full h-full object-cover">
                                </div>
                                <span class="text-sm font-bold text-stone-900">{{ $category->name }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <code class="text-[10px] font-bold text-stone-500 bg-stone-50 px-2 py-1 rounded">{{ $category->slug }}</code>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-xs font-bold text-stone-600">{{ $category->products_count }} items</span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex justify-end">
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-10 h-10 flex items-center justify-center text-stone-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all shadow-sm">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-12 text-center text-stone-500 text-sm">
                            No categories created yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
