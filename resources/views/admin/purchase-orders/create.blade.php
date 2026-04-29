@extends('layouts.admin')

@section('title', 'New Purchase Order')
@section('page_title', 'Create Purchase Order')

@section('content')
<div class="max-w-5xl mx-auto" x-data="{
    items: [{ product_id: '', quantity: 1, unit_cost: 0 }],
    products: {{ Js::from($products) }},
    supplier_id: '',
    addItem() { this.items.push({ product_id: '', quantity: 1, unit_cost: 0 }) },
    removeItem(index) { if (this.items.length > 1) this.items.splice(index, 1) },
    getSubtotal(item) { return (item.quantity * item.unit_cost).toFixed(2) },
    get grandTotal() { return this.items.reduce((sum, item) => sum + (item.quantity * item.unit_cost), 0).toFixed(2) },
    selectProduct(item) {
        const product = this.products.find(p => p.id == item.product_id);
        if (product) { item.unit_cost = product.price; }
    },
    getFilteredProducts() {
        if (!this.supplier_id) return [];
        return this.products.filter(p => p.supplier_id == this.supplier_id);
    },
    init() {
        this.$watch('supplier_id', (value) => {
            this.items = [{ product_id: '', quantity: 1, unit_cost: 0 }];
        });
    }
}">
    <a href="{{ route('admin.purchase-orders.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-stone-500 hover:text-stone-900 mb-6 transition-colors">
        <i class="ri-arrow-left-line"></i> Back to Purchase Orders
    </a>

    <form action="{{ route('admin.purchase-orders.store') }}" method="POST" class="space-y-8">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Order Details -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Header Info -->
                <div class="bg-white p-8 rounded-xl border border-stone-300 shadow-sm space-y-6">
                    <h3 class="text-sm font-bold text-stone-900 uppercase tracking-widest border-b border-stone-100 pb-4 mb-6">Order Details</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-stone-500 uppercase tracking-widest mb-2">PO Number</label>
                            <input type="text" value="{{ $poNumber }}" disabled
                                class="w-full bg-stone-100 border border-stone-300 rounded-lg px-4 py-3 text-sm font-bold text-stone-600">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-stone-500 uppercase tracking-widest mb-2">Supplier</label>
                            <select name="supplier_id" x-model="supplier_id" required class="w-full bg-stone-50 border border-stone-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-amber-500 transition-colors">
                                <option value="">Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-stone-500 uppercase tracking-widest mb-2">Order Date</label>
                            <input type="date" name="order_date" required value="{{ date('Y-m-d') }}"
                                class="w-full bg-stone-50 border border-stone-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-amber-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-stone-500 uppercase tracking-widest mb-2">Expected Delivery</label>
                            <input type="date" name="expected_delivery"
                                class="w-full bg-stone-50 border border-stone-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-amber-500 transition-colors">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-500 uppercase tracking-widest mb-2">Notes</label>
                        <textarea name="notes" rows="3" placeholder="Any notes for this order..."
                            class="w-full bg-stone-50 border border-stone-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-amber-500 transition-colors resize-none"></textarea>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="bg-white p-8 rounded-xl border border-stone-300 shadow-sm">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-sm font-bold text-stone-900 uppercase tracking-widest">Order Items</h3>
                        <button type="button" @click="addItem()" class="text-xs font-bold text-amber-600 hover:text-amber-700 uppercase tracking-widest flex items-center gap-1">
                            <i class="ri-add-line"></i> Add Item
                        </button>
                    </div>

                    <div class="space-y-4">
                        <template x-for="(item, index) in items" :key="index">
                            <div class="flex items-start gap-4 p-4 bg-stone-50 rounded-xl border border-stone-200">
                                <div class="flex-1">
                                    <label class="block text-[10px] font-bold text-stone-500 uppercase tracking-widest mb-1">Product</label>
                                    <select :name="`items[${index}][product_id]`" x-model="item.product_id" @change="selectProduct(item)" required
                                        class="w-full bg-white border border-stone-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-amber-500 transition-colors">
                                        <option value="">Select Product</option>
                                        <template x-for="product in getFilteredProducts()" :key="product.id">
                                            <option :value="product.id" x-text="product.name + ' (' + (product.brand || 'No Brand') + ')'"></option>
                                        </template>
                                    </select>
                                </div>
                                <div class="w-24">
                                    <label class="block text-[10px] font-bold text-stone-500 uppercase tracking-widest mb-1">Qty</label>
                                    <input type="number" :name="`items[${index}][quantity]`" x-model.number="item.quantity" min="1" required
                                        class="w-full bg-white border border-stone-300 rounded-lg px-3 py-2.5 text-sm font-bold focus:outline-none focus:border-amber-500 transition-colors">
                                </div>
                                <div class="w-32">
                                    <label class="block text-[10px] font-bold text-stone-500 uppercase tracking-widest mb-1">Unit Cost ($)</label>
                                    <input type="number" step="0.01" :name="`items[${index}][unit_cost]`" x-model.number="item.unit_cost" min="0" required
                                        class="w-full bg-white border border-stone-300 rounded-lg px-3 py-2.5 text-sm font-bold focus:outline-none focus:border-amber-500 transition-colors">
                                </div>
                                <div class="w-28 text-right pt-5">
                                    <p class="text-sm font-bold text-stone-900" x-text="'$' + getSubtotal(item)"></p>
                                </div>
                                <button type="button" @click="removeItem(index)" class="mt-5 text-rose-400 hover:text-rose-600 p-1" x-show="items.length > 1">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Right: Summary -->
            <div class="space-y-8">
                <div class="bg-white p-8 rounded-xl border border-stone-300 shadow-sm sticky top-8">
                    <h3 class="text-sm font-bold text-stone-900 uppercase tracking-widest border-b border-stone-100 pb-4 mb-6">Order Summary</h3>

                    <div class="space-y-4 mb-8">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-stone-500 uppercase tracking-widest">Items</span>
                            <span class="text-sm font-bold text-stone-900" x-text="items.length"></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-stone-500 uppercase tracking-widest">Total Qty</span>
                            <span class="text-sm font-bold text-stone-900" x-text="items.reduce((sum, i) => sum + (Number(i.quantity) || 0), 0)"></span>
                        </div>
                        <div class="border-t border-stone-100 pt-4 flex items-center justify-between">
                            <span class="text-xs font-black text-stone-900 uppercase tracking-widest">Grand Total</span>
                            <span class="text-xl font-black text-emerald-600" x-text="'$' + grandTotal"></span>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-stone-900 text-white py-4 rounded-xl font-bold hover:bg-stone-800 transition-all shadow-xl shadow-stone-200 flex items-center justify-center gap-2">
                        <i class="ri-save-line text-lg"></i> Submit Purchase Order
                    </button>
                    <a href="{{ route('admin.purchase-orders.index') }}" class="block text-center mt-4 text-xs font-bold text-stone-500 hover:text-stone-900 uppercase tracking-widest transition-colors">Discard</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
