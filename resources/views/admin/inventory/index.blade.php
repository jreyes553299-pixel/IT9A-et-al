@extends('layouts.admin')

@section('title', 'Inventory')
@section('page_title', 'Product Inventory')

@section('content')
    <div x-data="{ 
        drawerOpen: false, 
        product: null,
        loading: false,
        async openDetails(id) {
            this.drawerOpen = true;
            this.loading = true;
            try {
                const response = await fetch(`/admin/inventory/${id}`);
                this.product = await response.json();
            } catch (error) {
                console.error('Error fetching product:', error);
            } finally {
                this.loading = false;
            }
        }
    }">
        <!-- Top Metric Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl border border-stone-300 shadow-md">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 rounded-lg bg-stone-50 flex items-center justify-center text-stone-500">
                        <i class="ri-box-3-line text-xl"></i>
                    </div>
                </div>
                <p class="text-[10px] font-bold text-stone-500 uppercase tracking-widest mb-1">Total Products</p>
                <p class="text-2xl font-bold text-stone-900">{{ $metrics['total'] }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl border border-stone-300 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 rounded-lg bg-stone-50 flex items-center justify-center text-amber-500">
                        <i class="ri-alert-line text-xl"></i>
                    </div>
                </div>
                <p class="text-[10px] font-bold text-stone-500 uppercase tracking-widest mb-1">Low Stock</p>
                <p class="text-2xl font-bold text-stone-900">{{ $metrics['low_stock'] }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl border border-stone-300 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 rounded-lg bg-stone-50 flex items-center justify-center text-rose-500">
                        <i class="ri-error-warning-line text-xl"></i>
                    </div>
                </div>
                <p class="text-[10px] font-bold text-stone-500 uppercase tracking-widest mb-1">Out of Stock</p>
                <p class="text-2xl font-bold text-stone-900">{{ $metrics['out_of_stock'] }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl border border-stone-300 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 rounded-lg bg-stone-50 flex items-center justify-center text-emerald-500">
                        <i class="ri-money-dollar-circle-line text-xl"></i>
                    </div>
                </div>
                <p class="text-[10px] font-bold text-stone-500 uppercase tracking-widest mb-1">Total Value</p>
                <p class="text-2xl font-bold text-stone-900">${{ number_format($metrics['total_value'], 2) }}</p>
            </div>
        </div>

        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-stone-900">All Products</h3>
            <a href="{{ route('admin.inventory.create') }}"
                class="bg-stone-900 text-white px-6 py-2.5 rounded-xl text-xs font-bold flex items-center gap-2 hover:bg-stone-800 transition-colors shadow-lg shadow-stone-200">
                <i class="ri-add-line text-lg"></i> Add New Product
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-stone-300 shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-stone-100/50">
                            <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-[0.2em] border-b border-stone-300">Product</th>
                            <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-[0.2em] border-b border-stone-300">Category</th>
                            <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-[0.2em] border-b border-stone-300">Price</th>
                            <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-[0.2em] border-b border-stone-300">Stock</th>
                            <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-[0.2em] border-b border-stone-300 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-300">
                        @forelse($products as $item)
                            <tr class="hover:bg-amber-50/30 transition-colors group cursor-pointer" @click="openDetails({{ $item->id }})">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-lg bg-stone-100 overflow-hidden border-2 border-stone-400">
                                            <img src="{{ $item->image_url }}" alt="" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-stone-900">{{ $item->name }}</p>
                                            <p class="text-xs text-stone-500">{{ $item->brand }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="px-2.5 py-1 bg-stone-100 text-stone-600 rounded-full text-[10px] font-black uppercase tracking-wider">
                                        {{ $item->category->name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-sm font-bold text-stone-900">${{ number_format($item->price, 2) }}</td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-bold {{ $item->stock <= 5 ? 'text-rose-500' : ($item->stock <= 15 ? 'text-amber-500' : 'text-stone-900') }}">
                                            {{ $item->stock }}
                                        </span>
                                        @if($item->stock <= 5)
                                            <span class="px-2 py-0.5 bg-rose-50 text-rose-600 text-[9px] font-black rounded uppercase">Critical</span>
                                        @elseif($item->stock <= 15)
                                            <span class="px-2 py-0.5 bg-amber-50 text-amber-600 text-[9px] font-black rounded uppercase">Low</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-right" @click.stop>
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('admin.inventory.edit', $item) }}" class="w-9 h-9 flex items-center justify-center text-stone-500 hover:text-stone-900 hover:bg-stone-100 rounded-xl transition-all">
                                            <i class="ri-edit-line text-lg"></i>
                                        </a>
                                        <form action="{{ route('admin.inventory.destroy', $item) }}" method="POST" onsubmit="return confirm('Remove this product?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-9 h-9 flex items-center justify-center text-stone-500 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all">
                                                <i class="ri-delete-bin-line text-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-12 text-center text-stone-500">
                                    No products in inventory yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Side Drawer -->
        <template x-teleport="body">
            <div x-show="drawerOpen" x-cloak class="fixed inset-0 z-[100] flex justify-end">
                <div x-show="drawerOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute inset-0 bg-stone-900/40 backdrop-blur-sm" @click="drawerOpen = false"></div>
                <div x-show="drawerOpen" x-transition:enter="transition ease-out duration-400 transform" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="relative w-full max-w-xl bg-white h-full shadow-2xl overflow-y-auto">
                    <div x-show="loading" class="absolute inset-0 bg-white/80 backdrop-blur-sm z-50 flex items-center justify-center">
                        <div class="w-8 h-8 border-4 border-amber-500 border-t-transparent rounded-full animate-spin"></div>
                    </div>
                    <div x-show="product" class="p-8">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-xl font-bold text-stone-900" x-text="product?.name"></h3>
                            <button @click="drawerOpen = false" class="text-stone-500 hover:text-stone-900"><i class="ri-close-line text-2xl"></i></button>
                        </div>
                        <img :src="product?.image_url" class="w-full aspect-square object-cover rounded-2xl border-2 border-stone-400">
                        <div class="space-y-6">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="p-4 bg-stone-100 rounded-xl border-2 border-stone-400 shadow-md">
                                    <p class="text-[10px] font-bold text-stone-500 uppercase tracking-widest mb-1">Price</p>
                                    <p class="text-lg font-bold text-stone-900" x-text="'$' + Number(product?.price).toFixed(2)"></p>
                                </div>
                                <div class="p-4 bg-stone-50 rounded-xl border-2 border-stone-400 shadow-sm">
                                    <p class="text-[10px] font-bold text-stone-500 uppercase tracking-widest mb-1">Stock Level</p>
                                    <p class="text-lg font-bold text-stone-900" x-text="product?.stock"></p>
                                </div>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-stone-500 uppercase tracking-widest mb-2">Description</p>
                                <p class="text-sm text-stone-600 leading-relaxed" x-text="product?.description || 'No description provided.'"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
@endsection
