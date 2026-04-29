@extends('layouts.admin')

@section('title', 'Purchase Orders')
@section('page_title', 'Purchase Orders')

@section('content')
    <div x-data="{
        drawerOpen: false,
        order: null,
        loading: false,
        async openDetails(id) {
            this.drawerOpen = true;
            this.loading = true;
            try {
                const response = await fetch(`/admin/purchase-orders/${id}`);
                this.order = await response.json();
            } catch (error) {
                console.error('Error:', error);
            } finally {
                this.loading = false;
            }
        }
    }">
        <!-- Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl border border-stone-300 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 rounded-lg bg-stone-50 flex items-center justify-center text-stone-500">
                        <i class="ri-file-list-3-line text-xl"></i>
                    </div>
                </div>
                <p class="text-[10px] font-bold text-stone-500 uppercase tracking-widest mb-1">Total Orders</p>
                <p class="text-2xl font-bold text-stone-900">{{ $metrics['total'] }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl border border-stone-300 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center text-amber-500">
                        <i class="ri-time-line text-xl"></i>
                    </div>
                </div>
                <p class="text-[10px] font-bold text-stone-500 uppercase tracking-widest mb-1">Pending</p>
                <p class="text-2xl font-bold text-stone-900">{{ $metrics['pending'] }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl border border-stone-300 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-500">
                        <i class="ri-checkbox-circle-line text-xl"></i>
                    </div>
                </div>
                <p class="text-[10px] font-bold text-stone-500 uppercase tracking-widest mb-1">Received</p>
                <p class="text-2xl font-bold text-stone-900">{{ $metrics['received'] }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl border border-stone-300 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 rounded-lg bg-stone-50 flex items-center justify-center text-emerald-500">
                        <i class="ri-money-dollar-circle-line text-xl"></i>
                    </div>
                </div>
                <p class="text-[10px] font-bold text-stone-500 uppercase tracking-widest mb-1">Total Spent</p>
                <p class="text-2xl font-bold text-stone-900">${{ number_format($metrics['total_spent'], 2) }}</p>
            </div>
        </div>

        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-stone-900">All Purchase Orders</h3>
            <a href="{{ route('admin.purchase-orders.create') }}"
                class="bg-stone-900 text-white px-6 py-2.5 rounded-xl text-xs font-bold flex items-center gap-2 hover:bg-stone-800 transition-colors shadow-lg shadow-stone-200">
                <i class="ri-add-line text-lg"></i> New Purchase Order
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-stone-300 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-stone-50/30">
                            <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-[0.2em] border-b border-stone-300">PO Number</th>
                            <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-[0.2em] border-b border-stone-300">Supplier</th>
                            <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-[0.2em] border-b border-stone-300">Date</th>
                            <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-[0.2em] border-b border-stone-300">Items</th>
                            <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-[0.2em] border-b border-stone-300 text-right">Total</th>
                            <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-[0.2em] border-b border-stone-300">Status</th>
                            <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-[0.2em] border-b border-stone-300 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse($orders as $order)
                            <tr class="hover:bg-amber-50/30 transition-colors group cursor-pointer" @click="openDetails({{ $order->id }})">
                                <td class="px-8 py-5">
                                    <span class="text-sm font-bold text-stone-900">{{ $order->po_number }}</span>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-stone-900 flex items-center justify-center text-amber-500 flex-shrink-0">
                                            <i class="ri-truck-line text-sm"></i>
                                        </div>
                                        <span class="text-sm font-medium text-stone-700">{{ $order->supplier->name }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-sm text-stone-600">{{ $order->order_date->format('M d, Y') }}</td>
                                <td class="px-8 py-5">
                                    <span class="text-sm font-bold text-stone-900">{{ $order->items->count() }}</span>
                                    <span class="text-xs text-stone-500">items</span>
                                </td>
                                <td class="px-8 py-5 text-right text-sm font-bold text-stone-900">${{ number_format($order->total_amount, 2) }}</td>
                                <td class="px-8 py-5">
                                    @if($order->status === 'pending')
                                        <span class="px-2.5 py-1 bg-amber-50 text-amber-600 text-[10px] font-black rounded-full uppercase tracking-wider">Pending</span>
                                    @elseif($order->status === 'received')
                                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black rounded-full uppercase tracking-wider">Received</span>
                                    @else
                                        <span class="px-2.5 py-1 bg-rose-50 text-rose-600 text-[10px] font-black rounded-full uppercase tracking-wider">Cancelled</span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-right" @click.stop>
                                    <div class="flex items-center justify-end gap-2">
                                        @if($order->status === 'pending')
                                            <form action="{{ route('admin.purchase-orders.update-status', $order) }}" method="POST" @submit.stop>
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="received">
                                                <button type="submit" @click.stop class="w-8 h-8 flex items-center justify-center text-emerald-500 hover:bg-emerald-50 rounded-lg transition-all" title="Mark Received" onclick="return confirm('Mark as received? This will add stock to the products.')">
                                                    <i class="ri-checkbox-circle-line text-lg"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.purchase-orders.update-status', $order) }}" method="POST" @submit.stop>
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit" @click.stop class="w-8 h-8 flex items-center justify-center text-rose-400 hover:bg-rose-50 rounded-lg transition-all" title="Cancel" onclick="return confirm('Cancel this PO?')">
                                                    <i class="ri-close-circle-line text-lg"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.purchase-orders.destroy', $order) }}" method="POST" @submit.stop onsubmit="return confirm('Delete this purchase order?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" @click.stop class="w-8 h-8 flex items-center justify-center text-stone-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all">
                                                <i class="ri-delete-bin-line text-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-8 py-12 text-center text-stone-500">
                                    No purchase orders yet. Create your first one!
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
                                <h3 class="text-xl font-bold text-stone-900" x-text="order?.po_number"></h3>
                                <p class="text-sm text-stone-500" x-text="order?.supplier?.name"></p>
                            </div>
                            <button @click="drawerOpen = false" class="text-stone-500 hover:text-stone-900"><i class="ri-close-line text-2xl"></i></button>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-8">
                            <div class="p-4 bg-stone-50 rounded-xl border border-stone-300">
                                <p class="text-[10px] font-bold text-stone-500 uppercase tracking-widest mb-1">Order Date</p>
                                <p class="text-sm font-bold text-stone-900" x-text="order?.order_date ? new Date(order.order_date).toLocaleDateString('en-US', {month: 'short', day: 'numeric', year: 'numeric'}) : 'N/A'"></p>
                            </div>
                            <div class="p-4 bg-stone-50 rounded-xl border border-stone-300">
                                <p class="text-[10px] font-bold text-stone-500 uppercase tracking-widest mb-1">Total Amount</p>
                                <p class="text-sm font-bold text-emerald-600" x-text="'$' + Number(order?.total_amount || 0).toLocaleString(undefined, {minimumFractionDigits: 2})"></p>
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
                                            <p class="text-sm font-bold text-stone-900" x-text="item.product?.name"></p>
                                            <p class="text-xs text-stone-500" x-text="'Qty: ' + item.quantity + ' × $' + Number(item.unit_cost).toFixed(2)"></p>
                                        </div>
                                    </div>
                                    <span class="text-sm font-bold text-stone-900" x-text="'$' + Number(item.subtotal).toFixed(2)"></span>
                                </div>
                            </template>
                        </div>

                        <template x-if="order?.notes">
                            <div class="mt-8 p-4 bg-stone-50 rounded-xl border border-stone-300">
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
