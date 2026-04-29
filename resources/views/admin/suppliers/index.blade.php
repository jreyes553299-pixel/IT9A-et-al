@extends('layouts.admin')

@section('title', 'Suppliers')
@section('page_title', 'Supplier Network')

@section('content')
    <div x-data="{ 
        drawerOpen: false, 
        supplier: null,
        loading: false,
        async openDetails(id) {
            this.drawerOpen = true;
            this.loading = true;
            try {
                const response = await fetch(`/admin/suppliers/${id}`);
                this.supplier = await response.json();
            } catch (error) {
                console.error('Error fetching supplier:', error);
            } finally {
                this.loading = false;
            }
        },
        async toggleStatus(id) {
            try {
                await fetch(`/admin/suppliers/${id}/toggle-status`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
            } catch (error) { console.error(error); }
        }
    }">
        <!-- Top Metric Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl border border-stone-300 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 rounded-lg bg-stone-50 flex items-center justify-center text-stone-500">
                        <i class="ri-truck-line text-xl"></i>
                    </div>
                    <span class="text-[10px] font-bold text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-full">Active Status</span>
                </div>
                <p class="text-[10px] font-bold text-stone-500 uppercase tracking-widest mb-1">Total Suppliers</p>
                <p class="text-2xl font-bold text-stone-900">{{ $metrics['total'] }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl border border-stone-300 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 rounded-lg bg-stone-50 flex items-center justify-center text-stone-500">
                        <i class="ri-checkbox-circle-line text-xl"></i>
                    </div>
                    <span class="text-[10px] font-bold text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-full">Operational</span>
                </div>
                <p class="text-[10px] font-bold text-stone-500 uppercase tracking-widest mb-1">Active Partners</p>
                <p class="text-2xl font-bold text-stone-900">{{ $metrics['active'] }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl border border-stone-300 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 rounded-lg bg-stone-50 flex items-center justify-center text-stone-500">
                        <i class="ri-money-dollar-circle-line text-xl"></i>
                    </div>
                    <span class="text-[10px] font-bold text-stone-500 bg-stone-50 px-2 py-0.5 rounded-full">Lifetime Spend</span>
                </div>
                <p class="text-[10px] font-bold text-stone-500 uppercase tracking-widest mb-1">Total Spend</p>
                <p class="text-2xl font-bold text-stone-900">${{ number_format($metrics['total_spend'], 2) }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl border border-stone-300 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 rounded-lg bg-stone-50 flex items-center justify-center text-stone-500">
                        <i class="ri-speed-up-line text-xl"></i>
                    </div>
                    <span class="text-[10px] font-bold text-amber-500 bg-amber-50 px-2 py-0.5 rounded-full">Network Avg</span>
                </div>
                <p class="text-[10px] font-bold text-stone-500 uppercase tracking-widest mb-1">Avg Lead Time</p>
                <p class="text-2xl font-bold text-stone-900">{{ $metrics['avg_lead_time'] }}</p>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="flex flex-wrap items-center justify-between gap-6 mb-6">
            <div class="flex items-center gap-1 p-1 bg-stone-100 rounded-xl">
                <button class="px-6 py-2 text-xs font-bold text-stone-900 bg-white rounded-lg shadow-sm transition-all">All
                    Suppliers</button>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.suppliers.create') }}"
                    class="bg-stone-900 text-white px-6 py-2.5 rounded-xl text-xs font-bold flex items-center gap-2 hover:bg-stone-800 transition-colors shadow-lg shadow-stone-200">
                    <i class="ri-add-line text-lg"></i> Register Vendor
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-stone-300 shadow-sm overflow-hidden">
            <div class="px-8 py-6 border-b border-stone-100 flex items-center justify-between bg-stone-50/50">
                <div class="relative">
                    <input type="text" placeholder="Search vendor network..."
                        class="pl-10 pr-4 py-2.5 bg-white border border-stone-300 rounded-xl text-xs focus:outline-none focus:border-amber-500 w-80 transition-all">
                    <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-stone-500"></i>
                </div>
                <button class="text-xs font-bold text-stone-500 hover:text-stone-900 flex items-center gap-2">
                    <i class="ri-filter-3-line text-lg"></i> Advanced Filter
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-stone-50/30">
                            <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-[0.2em] border-b border-stone-300">Supplier & Rating</th>
                            <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-[0.2em] border-b border-stone-300">Contact</th>
                            <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-[0.2em] border-b border-stone-300">Country & Tags</th>
                            <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-[0.2em] border-b border-stone-300 text-right">Total Spent</th>
                            <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-[0.2em] border-b border-stone-300 text-center">Status</th>
                            <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-[0.2em] border-b border-stone-300 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse($suppliers as $item)
                            <tr class="hover:bg-amber-50/30 transition-colors group cursor-pointer"
                                @click="openDetails({{ $item->id }})">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-stone-100 border border-stone-200 flex items-center justify-center text-stone-500 group-hover:scale-110 transition-transform">
                                            <i class="ri-building-4-line text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-stone-900">{{ $item->name }}</p>
                                            <div class="flex items-center gap-1 mt-0.5">
                                                <i class="ri-star-fill text-[10px] text-amber-500"></i>
                                                <span class="text-[11px] font-bold text-stone-500">{{ $item->rating ?? '0.0' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <p class="text-xs font-bold text-stone-900 mb-0.5">{{ $item->contact_person ?? 'N/A' }}</p>
                                    <p class="text-[11px] text-stone-500">{{ $item->email ?? 'No email' }}</p>
                                </td>
                                <td class="px-8 py-5">
                                    <p class="text-sm font-bold text-stone-900 mb-1">{{ $item->country ?? 'Global' }}</p>
                                    <div class="flex items-center gap-1 flex-wrap">
                                        @if($item->categories)
                                            @foreach($item->categories as $cat)
                                                <span class="px-2 py-0.5 bg-rose-50 text-rose-600 text-[9px] font-bold rounded-full">{{ $cat }}</span>
                                            @endforeach
                                        @endif
                                        @if($item->brands)
                                            @foreach($item->brands as $brand)
                                                <span class="px-2 py-0.5 bg-stone-100 text-stone-600 text-[9px] font-bold rounded-full uppercase">{{ $brand }}</span>
                                            @endforeach
                                        @endif
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-right font-black text-stone-900">${{ number_format($item->total_spent, 2) }}</td>
                                <td class="px-8 py-5 text-center" @click.stop>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer" @change="toggleStatus({{ $item->id }})" {{ $item->is_active ? 'checked' : '' }}>
                                        <div class="w-9 h-5 bg-stone-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-stone-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500"></div>
                                    </label>
                                </td>
                                <td class="px-8 py-5 text-right" @click.stop>
                                    <div class="flex items-center justify-end gap-2">
                                        <button @click="openDetails({{ $item->id }})" class="w-8 h-8 flex items-center justify-center text-stone-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all" title="View Details">
                                            <i class="ri-eye-line text-lg"></i>
                                        </button>
                                        <a href="{{ route('admin.suppliers.edit', $item) }}" class="w-8 h-8 flex items-center justify-center text-stone-400 hover:text-stone-900 hover:bg-stone-100 rounded-lg transition-all" title="Edit">
                                            <i class="ri-edit-line text-lg"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-8 py-12 text-center">
                                    <div class="w-16 h-16 rounded-full bg-stone-50 flex items-center justify-center mx-auto mb-4 text-stone-300">
                                        <i class="ri-truck-line text-3xl"></i>
                                    </div>
                                    <p class="text-stone-500 text-sm mb-4">No suppliers registered yet</p>
                                    <a href="{{ route('admin.suppliers.create') }}" class="inline-flex items-center gap-2 text-sm font-bold text-amber-600 hover:text-amber-700 transition-colors">
                                        <i class="ri-add-line"></i> Add your first supplier
                                    </a>
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
                <!-- Backdrop -->
                <div x-show="drawerOpen" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" class="absolute inset-0 bg-stone-900/40 backdrop-blur-sm"
                    @click="drawerOpen = false"></div>

                <!-- Drawer Content -->
                <div x-show="drawerOpen" x-transition:enter="transition ease-out duration-400 transform"
                    x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                    x-transition:leave="transition ease-in duration-300 transform" x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="translate-x-full"
                    class="relative w-full max-w-[500px] bg-white h-full shadow-2xl overflow-y-auto flex flex-col">
                    
                    <!-- Loading State -->
                    <div x-show="loading" class="absolute inset-0 bg-white/80 backdrop-blur-sm z-50 flex items-center justify-center">
                        <div class="w-8 h-8 border-4 border-amber-500 border-t-transparent rounded-full animate-spin"></div>
                    </div>

                    <div x-show="supplier" class="flex flex-col flex-1">
                        <!-- Drawer Header matching preview -->
                        <div class="px-8 pt-8 pb-6 bg-white relative">
                            <button @click="drawerOpen = false" class="absolute top-6 right-6 w-8 h-8 flex items-center justify-center text-stone-400 hover:bg-stone-50 rounded-lg transition-all">
                                <i class="ri-close-line text-xl"></i>
                            </button>
                            
                            <h3 class="text-xl font-bold text-stone-900 leading-tight" x-text="supplier?.name"></h3>
                            <p class="text-xs font-medium text-stone-400 mt-1" x-text="supplier?.country || 'Global'"></p>

                            <!-- Tags matching preview -->
                            <div class="flex items-center gap-2 mt-4 flex-wrap">
                                <span class="px-3 py-1 text-[10px] font-bold rounded-full" :class="supplier?.is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600'" x-text="supplier?.is_active ? 'Active' : 'Inactive'"></span>
                                
                                <template x-for="cat in supplier?.categories || []">
                                    <span class="px-3 py-1 bg-rose-50 text-rose-600 text-[10px] font-bold rounded-full capitalize" x-text="cat"></span>
                                </template>
                                
                                <template x-for="brand in supplier?.brands || []">
                                    <span class="px-3 py-1 bg-stone-100 text-stone-600 text-[10px] font-bold rounded-full uppercase tracking-wider" x-text="brand"></span>
                                </template>
                            </div>
                        </div>

                        <div class="px-8 pb-8 space-y-8 flex-1">
                            <!-- Advanced Scorecards (orders, spend, lead time) -->
                            <div class="grid grid-cols-3 gap-3">
                                <div class="bg-stone-50 rounded-xl p-4 flex flex-col items-center justify-center text-center border border-stone-200">
                                    <div class="text-amber-500 mb-2"><i class="ri-shopping-bag-3-line text-lg"></i></div>
                                    <p class="text-lg font-black text-stone-900 leading-none mb-1" x-text="supplier?.purchase_orders?.length || 0"></p>
                                    <p class="text-[9px] font-bold text-stone-400 uppercase tracking-widest">Total Orders</p>
                                </div>
                                <div class="bg-stone-50 rounded-xl p-4 flex flex-col items-center justify-center text-center border border-stone-200">
                                    <div class="text-amber-500 mb-2"><i class="ri-money-dollar-circle-line text-lg"></i></div>
                                    <p class="text-lg font-black text-stone-900 leading-none mb-1" x-text="'$' + (Number(supplier?.total_spent) >= 1000 ? (Number(supplier?.total_spent)/1000).toFixed(0) + 'k' : (Number(supplier?.total_spent)||0))"></p>
                                    <p class="text-[9px] font-bold text-stone-400 uppercase tracking-widest">Total Spend</p>
                                </div>
                                <div class="bg-stone-50 rounded-xl p-4 flex flex-col items-center justify-center text-center border border-stone-200">
                                    <div class="text-amber-500 mb-2"><i class="ri-timer-line text-lg"></i></div>
                                    <p class="text-lg font-black text-stone-900 leading-none mb-1" x-text="supplier?.lead_time ? parseInt(supplier.lead_time) + 'd' : 'N/A'"></p>
                                    <p class="text-[9px] font-bold text-stone-400 uppercase tracking-widest">Lead Time</p>
                                </div>
                            </div>

                            <!-- Rating -->
                            <div>
                                <h4 class="text-[10px] font-black text-stone-400 uppercase tracking-widest mb-3">Supplier Rating</h4>
                                <div class="flex items-center gap-2">
                                    <div class="flex items-center text-amber-500 text-sm gap-0.5">
                                        <i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-half-fill"></i>
                                    </div>
                                    <span class="text-xs font-bold text-stone-600" x-text="supplier?.rating || '0.0'"></span>
                                </div>
                            </div>

                            <!-- Contact Grid -->
                            <div>
                                <h4 class="text-[10px] font-black text-stone-400 uppercase tracking-widest mb-4">Contact Information</h4>
                                <div class="space-y-4">
                                    <div class="flex items-center gap-4 text-sm">
                                        <i class="ri-user-line text-stone-400 text-lg w-5 text-center"></i>
                                        <span class="font-medium text-stone-700" x-text="supplier?.contact_person || 'N/A'"></span>
                                    </div>
                                    <div class="flex items-center gap-4 text-sm">
                                        <i class="ri-mail-line text-stone-400 text-lg w-5 text-center"></i>
                                        <span class="font-medium text-stone-700" x-text="supplier?.email || 'N/A'"></span>
                                    </div>
                                    <div class="flex items-center gap-4 text-sm">
                                        <i class="ri-phone-line text-stone-400 text-lg w-5 text-center"></i>
                                        <span class="font-medium text-stone-700" x-text="supplier?.phone || 'N/A'"></span>
                                    </div>
                                    <div class="flex items-start gap-4 text-sm">
                                        <i class="ri-map-pin-line text-stone-400 text-lg w-5 text-center mt-0.5"></i>
                                        <span class="font-medium text-stone-700 leading-relaxed" x-text="supplier?.address || 'N/A'"></span>
                                    </div>
                                    <div class="flex items-center gap-4 text-sm">
                                        <i class="ri-global-line text-stone-400 text-lg w-5 text-center"></i>
                                        <span class="font-medium text-stone-700" x-text="supplier?.website || 'N/A'"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Commercial Terms -->
                            <div>
                                <h4 class="text-[10px] font-black text-stone-400 uppercase tracking-widest mb-4">Commercial Terms</h4>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-stone-50 rounded-xl p-4 border border-stone-200">
                                        <p class="text-[10px] font-bold text-stone-400 mb-1">Payment Terms</p>
                                        <p class="text-sm font-bold text-stone-900" x-text="supplier?.payment_terms || 'N/A'"></p>
                                    </div>
                                    <div class="bg-stone-50 rounded-xl p-4 border border-stone-200">
                                        <p class="text-[10px] font-bold text-stone-400 mb-1">Lead Time</p>
                                        <p class="text-sm font-bold text-stone-900" x-text="supplier?.lead_time || 'N/A'"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes Section -->
                            <div x-show="supplier?.notes">
                                <h4 class="text-[10px] font-black text-stone-400 uppercase tracking-widest mb-3">Internal Notes</h4>
                                <div class="bg-amber-50/50 border border-amber-200 p-5 rounded-xl">
                                    <p class="text-sm font-medium text-amber-900 leading-relaxed" x-text="supplier?.notes"></p>
                                </div>
                            </div>

                            <!-- Recent Purchase Orders -->
                            <div x-show="supplier?.purchase_orders?.length > 0">
                                <h4 class="text-[10px] font-black text-stone-400 uppercase tracking-widest mb-4">Recent Purchase Orders</h4>
                                <div class="space-y-3">
                                    <template x-for="po in supplier?.purchase_orders || []" :key="po.id">
                                        <div class="bg-stone-50 border border-stone-200 rounded-xl p-4 flex items-center justify-between">
                                            <div>
                                                <p class="text-xs font-bold text-stone-900 mb-1" x-text="po.po_number"></p>
                                                <p class="text-[10px] font-medium text-stone-500" x-text="(po.order_date ? new Date(po.order_date).toLocaleDateString() : '')"></p>
                                            </div>
                                            <div class="flex items-center gap-4">
                                                <span class="text-sm font-black text-stone-900" x-text="'$' + Number(po.total_amount).toLocaleString()"></span>
                                                <span class="flex items-center gap-1 text-[10px] font-bold" :class="po.status === 'received' ? 'text-emerald-600' : 'text-stone-500'">
                                                    <i :class="po.status === 'received' ? 'ri-checkbox-circle-line' : 'ri-time-line'"></i>
                                                    <span x-text="po.status === 'received' ? 'Delivered' : 'Pending'"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- Action Bar -->
                        <div class="p-6 border-t border-stone-200 bg-white grid grid-cols-2 gap-4 mt-auto">
                            <a :href="'mailto:' + supplier?.email" class="bg-stone-900 text-white py-3.5 rounded-xl text-xs font-bold transition-all shadow-md flex items-center justify-center gap-2 hover:bg-stone-800">
                                <i class="ri-mail-send-line text-lg"></i> Email Supplier
                            </a>
                            <a href="{{ route('admin.purchase-orders.create') }}" class="bg-white border border-stone-300 text-stone-900 py-3.5 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-2 hover:bg-stone-50">
                                <i class="ri-file-add-line text-lg"></i> New PO
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
@endsection
