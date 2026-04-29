@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Admin Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Stat Card -->
        <div class="bg-white p-6 rounded-xl border border-stone-300 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600">
                    <i class="ri-box-3-line text-2xl"></i>
                </div>
                <span class="text-xs font-bold text-emerald-500 bg-emerald-50 px-2 py-1 rounded">+12%</span>
            </div>
            <p class="text-stone-500 text-xs font-bold uppercase tracking-widest mb-1">Total Products</p>
            <h3 class="text-2xl font-bold text-stone-900">{{ \App\Models\Product::count() }}</h3>
        </div>

        <!-- Stat Card -->
        <div class="bg-white p-6 rounded-xl border border-stone-300 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-lg bg-stone-50 flex items-center justify-center text-stone-600">
                    <i class="ri-truck-line text-2xl"></i>
                </div>
                <span class="text-xs font-bold text-stone-500 bg-stone-50 px-2 py-1 rounded">Active</span>
            </div>
            <p class="text-stone-500 text-xs font-bold uppercase tracking-widest mb-1">Suppliers</p>
            <h3 class="text-2xl font-bold text-stone-900">{{ \App\Models\Supplier::count() }}</h3>
        </div>

        <!-- Stat Card -->
        <div class="bg-white p-6 rounded-xl border border-stone-300 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-lg bg-rose-50 flex items-center justify-center text-rose-600">
                    <i class="ri-error-warning-line text-2xl"></i>
                </div>
                <span class="text-xs font-bold text-rose-500 bg-rose-50 px-2 py-1 rounded">Critical</span>
            </div>
            <p class="text-stone-500 text-xs font-bold uppercase tracking-widest mb-1">Low Stock</p>
            <h3 class="text-2xl font-bold text-stone-900">{{ \App\Models\Product::where('stock', '<=', 5)->count() }}</h3>
        </div>

        <!-- Stat Card -->
        <div class="bg-white p-6 rounded-xl border border-stone-300 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                    <i class="ri-shopping-cart-line text-2xl"></i>
                </div>
                <span class="text-xs font-bold text-indigo-500 bg-indigo-50 px-2 py-1 rounded">Live</span>
            </div>
            <p class="text-stone-500 text-xs font-bold uppercase tracking-widest mb-1">Total Categories</p>
            <h3 class="text-2xl font-bold text-stone-900">{{ \App\Models\Category::count() }}</h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Activity -->
        <div class="bg-white rounded-xl border border-stone-300 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-stone-100 flex items-center justify-between bg-stone-50/50">
                <h4 class="font-bold text-stone-900">Inventory Overview</h4>
                <a href="{{ route('admin.inventory.index') }}" class="text-xs font-bold text-amber-600 hover:text-amber-700 uppercase tracking-widest">View
                    All</a>
            </div>
            <div class="p-6">
                @php $recentProducts = \App\Models\Product::latest()->limit(5)->get(); @endphp
                @forelse($recentProducts as $p)
                    <div class="flex items-center justify-between py-3 border-b border-stone-50 last:border-0">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded bg-stone-100 overflow-hidden border border-stone-300">
                                <img src="{{ $p->image_url }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <p class="text-xs font-bold text-stone-900">{{ $p->name }}</p>
                                <p class="text-[10px] text-stone-500">{{ $p->brand }}</p>
                            </div>
                        </div>
                        <span class="text-xs font-bold text-stone-900">${{ number_format($p->price, 2) }}</span>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <div class="w-16 h-16 rounded-full bg-stone-50 flex items-center justify-center mx-auto mb-4 text-stone-300">
                            <i class="ri-inbox-line text-3xl"></i>
                        </div>
                        <p class="text-stone-500 text-sm">No products in inventory yet</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl border border-stone-300 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-stone-100 bg-stone-50/50">
                <h4 class="font-bold text-stone-900">System Quick Actions</h4>
            </div>
            <div class="p-6 grid grid-cols-2 gap-4">
                <a href="{{ route('admin.inventory.create') }}"
                    class="p-4 border border-stone-300 rounded-xl hover:bg-amber-50 hover:border-amber-200 transition-all flex flex-col items-center text-center gap-2 group">
                    <div class="w-10 h-10 rounded-lg bg-stone-50 flex items-center justify-center group-hover:bg-white transition-colors shadow-sm">
                        <i class="ri-add-box-line text-xl text-amber-500"></i>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-stone-600">New Product</span>
                </a>
                <a href="{{ route('admin.suppliers.create') }}"
                    class="p-4 border border-stone-300 rounded-xl hover:bg-stone-50 transition-all flex flex-col items-center text-center gap-2 group">
                    <div class="w-10 h-10 rounded-lg bg-stone-50 flex items-center justify-center group-hover:bg-white transition-colors shadow-sm">
                        <i class="ri-user-add-line text-xl text-stone-900"></i>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-stone-600">New Supplier</span>
                </a>
                <a href="{{ route('admin.categories.index') }}"
                    class="p-4 border border-stone-300 rounded-xl hover:bg-stone-50 transition-all flex flex-col items-center text-center gap-2 group">
                    <div class="w-10 h-10 rounded-lg bg-stone-50 flex items-center justify-center group-hover:bg-white transition-colors shadow-sm">
                        <i class="ri-price-tag-3-line text-xl text-stone-500"></i>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-stone-600">Categories</span>
                </a>
                <a href="{{ url('/') }}" target="_blank"
                    class="p-4 border border-stone-300 rounded-xl hover:bg-stone-50 transition-all flex flex-col items-center text-center gap-2 group">
                    <div class="w-10 h-10 rounded-lg bg-stone-50 flex items-center justify-center group-hover:bg-white transition-colors shadow-sm">
                        <i class="ri-external-link-line text-xl text-stone-500"></i>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-stone-600">Storefront</span>
                </a>
            </div>
        </div>
    </div>
@endsection
