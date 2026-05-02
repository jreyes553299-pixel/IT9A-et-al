@extends('layouts.admin')

@section('title', 'Sales & Orders')
@section('page_title', 'Sales & Orders')

@section('content')
    <div x-data="{
        drawerOpen: false,
        order: null,
        loading: false,
        async openDetails(id) {
            this.drawerOpen = true;
            this.loading = true;
            try {
                const response = await fetch(`/admin/sales/${id}`);
                this.order = await response.json();
            } catch (error) {
                console.error('Error:', error);
            } finally {
                this.loading = false;
            }
        }
    }">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <!-- Revenue -->
            <div class="bg-white p-6 rounded-2xl border border-stone-300 shadow-md hover:shadow-lg transition-shadow group">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-12 h-12 rounded-xl bg-stone-900 flex items-center justify-center text-amber-500 shadow-lg shadow-stone-200">
                        <i class="ri-money-dollar-box-line text-2xl"></i>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="text-[10px] font-black text-stone-400 uppercase tracking-widest">Revenue</span>
                        <div class="flex items-center gap-1 text-emerald-500">
                            <i class="ri-arrow-right-up-line text-sm"></i>
                            <span class="text-[10px] font-bold">+12.5%</span>
                        </div>
                    </div>
                </div>
                <p class="text-3xl font-bold text-stone-900">${{ number_format($metrics['total_revenue'], 2) }}</p>
                <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest mt-1">Life-time Earnings</p>
            </div>

            <!-- Orders -->
            <div class="bg-white p-6 rounded-2xl border border-stone-300 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-12 h-12 rounded-xl bg-stone-100 flex items-center justify-center text-stone-600">
                        <i class="ri-shopping-cart-2-line text-2xl"></i>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="text-[10px] font-black text-stone-400 uppercase tracking-widest">Orders</span>
                        <div class="flex items-center gap-1 text-amber-500">
                            <i class="ri-time-line text-sm"></i>
                            <span class="text-[10px] font-bold">{{ $metrics['pending_orders'] }} New</span>
                        </div>
                    </div>
                </div>
                <p class="text-3xl font-bold text-stone-900">{{ $metrics['total_orders'] }}</p>
                <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest mt-1">Total Transactions</p>
            </div>

            <!-- Pending -->
            <div class="bg-white p-6 rounded-2xl border border-stone-300 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600">
                        <i class="ri-error-warning-line text-2xl"></i>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="text-[10px] font-black text-stone-400 uppercase tracking-widest">Priority</span>
                        <span class="text-[10px] font-bold text-amber-600 px-2 py-0.5 bg-amber-50 rounded-full uppercase tracking-tighter">Action Required</span>
                    </div>
                </div>
                <p class="text-3xl font-bold text-stone-900">{{ $metrics['pending_orders'] }}</p>
                <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest mt-1">Pending Processing</p>
            </div>

            <!-- Avg Order -->
            <div class="bg-white p-6 rounded-2xl border border-stone-300 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-12 h-12 rounded-xl bg-stone-100 flex items-center justify-center text-stone-600">
                        <i class="ri-scales-3-line text-2xl"></i>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="text-[10px] font-black text-stone-400 uppercase tracking-widest">AOV</span>
                        <span class="text-[10px] font-bold text-stone-500 italic">Global Avg</span>
                    </div>
                </div>
                <p class="text-3xl font-bold text-stone-900">${{ number_format($metrics['avg_order'], 2) }}</p>
                <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest mt-1">Average Order Value</p>
            </div>
        </div>

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
            <h3 class="text-xl font-bold text-stone-900">Order Management</h3>
            
            <div class="flex flex-col sm:flex-row items-center gap-4">
                <!-- Date Filter -->
                <div class="relative group">
                    <i class="ri-calendar-line absolute left-4 top-1/2 -translate-y-1/2 text-stone-400"></i>
                    <button class="bg-white border border-stone-300 rounded-xl pl-11 pr-4 py-2.5 text-xs font-bold text-stone-600 hover:border-stone-400 transition-all shadow-sm">
                        Select Date Range
                    </button>
                </div>

                <!-- Export Menu -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center gap-2 px-4 py-2.5 bg-stone-900 text-white rounded-xl text-xs font-bold hover:bg-stone-800 transition-all shadow-xl shadow-stone-200">
                        <i class="ri-download-line leading-none"></i>
                        Export
                        <i class="ri-arrow-down-s-line leading-none"></i>
                    </button>
                    <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-48 bg-white border border-stone-200 rounded-xl shadow-xl z-50 py-2">
                        <button class="w-full text-left px-4 py-2 text-xs font-bold text-stone-600 hover:bg-stone-50 transition-all flex items-center gap-2">
                            <i class="ri-file-excel-2-line text-emerald-500"></i> Export to Excel
                        </button>
                        <button class="w-full text-left px-4 py-2 text-xs font-bold text-stone-600 hover:bg-stone-50 transition-all flex items-center gap-2">
                            <i class="ri-file-pdf-line text-rose-500"></i> Export to PDF
                        </button>
                        <button class="w-full text-left px-4 py-2 text-xs font-bold text-stone-600 hover:bg-stone-50 transition-all flex items-center gap-2 border-t border-stone-100 mt-2 pt-2">
                            <i class="ri-printer-line text-stone-400"></i> Print Invoices
                        </button>
                    </div>
                </div>

                <!-- Search Bar -->
                <form action="{{ route('admin.sales.index') }}" method="GET" class="relative group w-full sm:w-80">
                    <i class="ri-search-line absolute left-4 top-1/2 -translate-y-1/2 text-stone-400 group-focus-within:text-amber-500 transition-colors"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search order, customer..." 
                        class="w-full bg-white border border-stone-300 rounded-xl pl-11 pr-4 py-2.5 text-sm focus:outline-none focus:border-amber-500 transition-all shadow-sm">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                </form>
            </div>
        </div>

        <!-- Status Filter Tabs -->
        <div class="flex items-center gap-2 mb-6 overflow-x-auto pb-2 scrollbar-hide">
            @php
                $currentStatus = request('status', 'all');
                $statuses = [
                    'all' => ['label' => 'All Orders', 'icon' => 'ri-list-check'],
                    'pending' => ['label' => 'Pending', 'icon' => 'ri-time-line'],
                    'processing' => ['label' => 'Processing', 'icon' => 'ri-loader-2-line'],
                    'shipped' => ['label' => 'Shipped', 'icon' => 'ri-truck-line'],
                    'delivered' => ['label' => 'Delivered', 'icon' => 'ri-checkbox-circle-line'],
                    'cancelled' => ['label' => 'Cancelled', 'icon' => 'ri-close-circle-line'],
                ];
            @endphp

            @foreach($statuses as $value => $data)
                <a href="{{ route('admin.sales.index', ['status' => $value, 'search' => request('search')]) }}" 
                    class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all whitespace-nowrap
                    {{ $currentStatus === $value ? 'bg-stone-900 text-white shadow-lg shadow-stone-200' : 'bg-white text-stone-500 border border-stone-300 hover:border-stone-400 hover:text-stone-700' }}">
                    <i class="{{ $data['icon'] }} text-sm leading-none"></i>
                    {{ $data['label'] }}
                    @if($value === 'pending' && $metrics['pending_orders'] > 0)
                        <span class="w-5 h-5 flex items-center justify-center bg-amber-500 text-stone-900 rounded-full text-[10px] leading-none">{{ $metrics['pending_orders'] }}</span>
                    @endif
                </a>
            @endforeach
        </div>

        <div class="bg-white rounded-2xl border border-stone-300 shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-stone-100/50">
                            <th class="px-8 py-5 border-b border-stone-300 w-10">
                                <input type="checkbox" class="rounded border-stone-300 text-amber-500 focus:ring-amber-500">
                            </th>
                            <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-[0.2em] border-b border-stone-300">Order #</th>
                            <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-[0.2em] border-b border-stone-300">Customer</th>
                            <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-[0.2em] border-b border-stone-300">Date</th>
                            <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-[0.2em] border-b border-stone-300">Items</th>
                            <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-[0.2em] border-b border-stone-300 text-right">Total</th>
                            <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-[0.2em] border-b border-stone-300">Status</th>
                            <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-[0.2em] border-b border-stone-300 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse($orders as $order)
                            <tr class="hover:bg-stone-50 transition-all group cursor-pointer" @click="openDetails({{ $order->id }})">
                                <td class="px-8 py-5" @click.stop>
                                    <input type="checkbox" class="rounded border-stone-300 text-amber-500 focus:ring-amber-500">
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-stone-900 group-hover:text-amber-600 transition-colors">{{ $order->order_number }}</span>
                                        <span class="text-[10px] font-medium text-stone-400 uppercase tracking-tighter">Reference ID</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-stone-900 flex items-center justify-center text-amber-500 flex-shrink-0 text-sm font-black shadow-sm group-hover:scale-110 transition-transform">
                                            {{ strtoupper(substr($order->customer_name, 0, 1)) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-stone-800">{{ $order->customer_name }}</span>
                                            <span class="text-xs text-stone-400 font-medium italic">{{ $order->customer_email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-stone-700">{{ $order->created_at->format('M d, Y') }}</span>
                                        <span class="text-[10px] text-stone-400 font-bold uppercase tracking-widest">{{ $order->created_at->format('h:i A') }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-sm font-bold text-stone-900">{{ $order->items->count() }}</span>
                                        <span class="text-[10px] font-black text-stone-400 uppercase tracking-widest">Items</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <span class="text-base font-black text-stone-900 tracking-tight">${{ number_format($order->total, 2) }}</span>
                                </td>
                                <td class="px-8 py-5">
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                            'processing' => 'bg-blue-50 text-blue-600 border-blue-100',
                                            'shipped' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                            'delivered' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                            'cancelled' => 'bg-rose-50 text-rose-600 border-rose-100',
                                        ];
                                        $class = $statusClasses[$order->status] ?? 'bg-stone-50 text-stone-600 border-stone-100';
                                    @endphp
                                    <span class="px-3 py-1.5 {{ $class }} border text-[9px] font-black rounded-lg uppercase tracking-widest inline-block shadow-sm">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right" @click.stop>
                                    <div class="flex items-center justify-end gap-2">
                                        @if($order->status === 'pending')
                                            <form action="{{ route('admin.sales.update-status', $order) }}" method="POST" @submit.stop class="m-0">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="processing">
                                                <button type="submit" @click.stop class="w-9 h-9 flex items-center justify-center text-blue-600 bg-blue-50 border border-blue-100 rounded-xl hover:bg-blue-600 hover:text-white transition-all shadow-sm" title="Start Processing">
                                                    <i class="ri-play-circle-line text-lg leading-none"></i>
                                                </button>
                                            </form>
                                        @elseif($order->status === 'processing')
                                            <form action="{{ route('admin.sales.update-status', $order) }}" method="POST" @submit.stop class="m-0">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="shipped">
                                                <button type="submit" @click.stop class="w-9 h-9 flex items-center justify-center text-indigo-600 bg-indigo-50 border border-indigo-100 rounded-xl hover:bg-indigo-600 hover:text-white transition-all shadow-sm" title="Mark Shipped">
                                                    <i class="ri-truck-line text-lg leading-none"></i>
                                                </button>
                                            </form>
                                        @elseif($order->status === 'shipped')
                                            <form action="{{ route('admin.sales.update-status', $order) }}" method="POST" @submit.stop class="m-0">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="delivered">
                                                <button type="submit" @click.stop class="w-9 h-9 flex items-center justify-center text-emerald-600 bg-emerald-50 border border-emerald-100 rounded-xl hover:bg-emerald-600 hover:text-white transition-all shadow-sm" title="Mark Delivered">
                                                    <i class="ri-checkbox-circle-line text-lg leading-none"></i>
                                                </button>
                                            </form>
                                        @endif

                                        <button type="button" @click.stop="openDetails({{ $order->id }})" class="w-9 h-9 flex items-center justify-center text-stone-500 bg-stone-50 border border-stone-200 rounded-xl hover:bg-stone-900 hover:text-white transition-all shadow-sm">
                                            <i class="ri-eye-line text-lg leading-none"></i>
                                        </button>

                                        <form action="{{ route('admin.sales.destroy', $order) }}" method="POST" @submit.stop onsubmit="return confirm('Delete this order permanently?')" class="m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" @click.stop class="w-9 h-9 flex items-center justify-center text-rose-400 bg-rose-50 border border-rose-100 rounded-xl hover:bg-rose-500 hover:text-white transition-all shadow-sm">
                                                <i class="ri-delete-bin-line text-lg leading-none"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-8 py-12 text-center text-stone-500">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-16 h-16 rounded-full bg-stone-100 flex items-center justify-center text-stone-300">
                                            <i class="ri-shopping-bag-line text-3xl"></i>
                                        </div>
                                        <p class="font-medium">No orders yet</p>
                                        <p class="text-xs text-stone-400">Customer orders will appear here once they start purchasing.</p>
                                    </div>
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
                    <div x-show="order" class="p-8">
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h3 class="text-xl font-bold text-stone-900" x-text="order?.order_number"></h3>
                                <p class="text-sm text-stone-500" x-text="order?.customer_name"></p>
                            </div>
                            <button @click="drawerOpen = false" class="text-stone-500 hover:text-stone-900"><i class="ri-close-line text-2xl"></i></button>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-8">
                            <div class="p-4 bg-stone-100 rounded-xl border border-stone-300 shadow-sm">
                                <p class="text-[10px] font-bold text-stone-500 uppercase tracking-widest mb-1">Customer</p>
                                <p class="text-sm font-bold text-stone-900" x-text="order?.customer_name"></p>
                                <p class="text-xs text-stone-500" x-text="order?.customer_email"></p>
                            </div>
                            <div class="p-4 bg-stone-50 rounded-xl border border-stone-300">
                                <p class="text-[10px] font-bold text-stone-500 uppercase tracking-widest mb-1">Total</p>
                                <p class="text-sm font-bold text-emerald-600" x-text="'$' + Number(order?.total || 0).toLocaleString(undefined, {minimumFractionDigits: 2})"></p>
                            </div>
                        </div>

                        <h4 class="text-xs font-bold text-stone-900 uppercase tracking-widest mb-4">Order Items</h4>
                        <div class="space-y-3">
                            <template x-for="item in order?.items || []" :key="item.id">
                                <div class="flex items-center justify-between p-4 bg-stone-50 rounded-xl border border-stone-200">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-stone-200 overflow-hidden">
                                            <img :src="item.product?.image_url" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-stone-900" x-text="item.product_name"></p>
                                            <p class="text-xs text-stone-500" x-text="'Qty: ' + item.quantity + ' × $' + Number(item.price).toFixed(2)"></p>
                                        </div>
                                    </div>
                                    <span class="text-sm font-bold text-stone-900" x-text="'$' + Number(item.subtotal).toFixed(2)"></span>
                                </div>
                            </template>
                        </div>

                        <template x-if="order?.shipping_address">
                            <div class="mt-8 p-4 bg-stone-50 rounded-xl border border-stone-300">
                                <p class="text-[10px] font-bold text-stone-500 uppercase tracking-widest mb-2">Shipping Address</p>
                                <p class="text-sm text-stone-600" x-text="order?.shipping_address"></p>
                            </div>
                        </template>

                        <template x-if="order?.notes">
                            <div class="mt-4 p-4 bg-stone-50 rounded-xl border border-stone-300">
                                <p class="text-[10px] font-bold text-stone-500 uppercase tracking-widest mb-2">Notes</p>
                                <p class="text-sm text-stone-600" x-text="order?.notes"></p>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </template>
    </div>
@endsection