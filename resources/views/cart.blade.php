@extends('layouts.app')

@section('content')
<div class="w-full bg-stone-900 pt-24 pb-10 px-6 lg:px-12 xl:px-20">
    <span class="text-amber-400 text-xs font-semibold tracking-[0.3em] uppercase mb-2 block">Review</span>
    <h1 class="text-3xl lg:text-4xl font-bold text-white">Shopping Cart</h1>
    <p class="text-stone-400 text-sm mt-2">{{ $cartItems->count() }} items in your cart</p>
</div>

<div class="w-full px-6 lg:px-12 xl:px-20 py-10" x-data="{ 
    selectedItems: [@foreach($cartItems as $item) '{{ $item->id }}'{{ !$loop->last ? ',' : '' }} @endforeach],
    cartData: {
        @foreach($cartItems as $item)
            '{{ $item->id }}': {
                price: {{ $item->price }},
                quantity: {{ $item->quantity }},
                subtotal: {{ $item->price * $item->quantity }},
                name: '{{ addslashes($item->product->name) }}',
                image: '{{ $item->product->image_url }}'
            }{{ !$loop->last ? ',' : '' }}
        @endforeach
    },
    get selectedCount() {
        return this.selectedItems.length;
    },
    get subtotal() {
        return this.selectedItems.reduce((acc, id) => acc + (this.cartData[id] ? this.cartData[id].subtotal : 0), 0);
    },
    get grandTotal() {
        return this.subtotal; // Shipping is FREE
    },
    toggleAll() {
        if (this.selectedItems.length === Object.keys(this.cartData).length) {
            this.selectedItems = [];
        } else {
            this.selectedItems = Object.keys(this.cartData);
        }
    }
}">
    @if($cartItems->count() > 0)
    <div class="flex flex-col xl:flex-row gap-10">
        <div class="flex-1 min-w-0">
            @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-lg flex items-center gap-3">
                <i class="ri-checkbox-circle-line text-xl"></i>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 p-4 bg-rose-50 border border-rose-100 text-rose-700 rounded-lg flex items-center gap-3">
                <i class="ri-error-warning-line text-xl"></i>
                <p class="text-sm font-medium">{{ session('error') }}</p>
            </div>
            @endif

            <form method="POST" action="{{ route('cart.update') }}">
                @csrf
                <!-- Table Header -->
                <div class="hidden lg:grid grid-cols-12 gap-4 pb-3 border-b border-stone-200 text-xs font-bold tracking-widest uppercase text-gray-400 mb-2 items-center">
                    <div class="col-span-1 flex items-center justify-center">
                        <label class="flex items-center cursor-pointer">
                            <input class="w-4 h-4 accent-amber-500 cursor-pointer" type="checkbox" 
                                @click="toggleAll()" 
                                :checked="selectedItems.length === Object.keys(cartData).length">
                        </label>
                    </div>
                    <div class="col-span-5">Product</div>
                    <div class="col-span-2 text-center">Price</div>
                    <div class="col-span-2 text-center">Quantity</div>
                    <div class="col-span-2 text-right">Total</div>
                </div>

                <!-- Cart Items -->
                @foreach($cartItems as $item)
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 py-6 border-b border-stone-100 items-center transition-all duration-200"
                    :class="!selectedItems.includes('{{ $item->id }}') ? 'opacity-50 grayscale-[0.5]' : ''">
                    <div class="hidden lg:flex col-span-1 items-center justify-center">
                        <input class="w-4 h-4 accent-amber-500 cursor-pointer" type="checkbox" 
                            value="{{ $item->id }}" x-model="selectedItems" name="select_{{ $item->id }}">
                    </div>
                    <div class="lg:col-span-5 flex items-start gap-4">
                        <div class="w-20 h-24 lg:w-24 lg:h-28 rounded-md overflow-hidden bg-stone-50 flex-shrink-0">
                            <img alt="{{ $item->product->name }}" class="w-full h-full object-cover object-top" src="{{ $item->product->image_url }}">
                        </div>
                        <div class="flex-1 min-w-0">
                            <span class="text-xs font-semibold text-amber-600 uppercase tracking-wide">{{ $item->product->brand }}</span>
                            <h3 class="text-sm font-semibold text-gray-900 mt-0.5 mb-2">{{ $item->product->name }}</h3>
                            <div class="flex flex-wrap gap-2 mb-2">
                                @if($item->size)
                                <span class="text-xs bg-stone-100 text-gray-600 px-2 py-0.5 rounded-full">Size: {{ $item->size }}</span>
                                @endif
                                @if($item->color)
                                <span class="text-xs bg-stone-100 text-gray-600 px-2 py-0.5 rounded-full flex items-center gap-1">
                                    <span class="w-2.5 h-2.5 rounded-full" style="background-color: {{ $item->color }};"></span>
                                    Color
                                </span>
                                @endif
                            </div>
                            <button type="submit" formaction="{{ route('cart.remove', $item->id) }}" class="mt-2 text-xs text-red-400 hover:text-red-600 transition-colors flex items-center gap-1 cursor-pointer">
                                <i class="ri-delete-bin-line"></i> Remove
                            </button>
                        </div>
                    </div>
                    <div class="lg:col-span-2 flex lg:justify-center items-center gap-2">
                        <span class="lg:hidden text-xs text-gray-400 font-semibold uppercase">Price:</span>
                        <span class="text-sm font-bold text-gray-900">${{ number_format($item->price, 2) }}</span>
                    </div>
                    <div class="lg:col-span-2 flex lg:justify-center items-center gap-2">
                        <span class="lg:hidden text-xs text-gray-400 font-semibold uppercase">Qty:</span>
                        <div class="flex items-center">
                            <button type="button" onclick="this.nextElementSibling.stepDown()" class="w-8 h-8 flex items-center justify-center border border-stone-200 rounded-l-md text-gray-600 hover:bg-stone-50"><i class="ri-subtract-line text-xs"></i></button>
                            <input class="w-10 h-8 border-t border-b border-stone-200 text-center text-sm font-semibold text-gray-900 focus:outline-none" type="number" name="quantities[{{ $item->id }}]" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}">
                            <button type="button" onclick="if(this.previousElementSibling.value < {{ $item->product->stock }}) this.previousElementSibling.stepUp()" class="w-8 h-8 flex items-center justify-center border border-stone-200 rounded-r-md text-gray-600 hover:bg-stone-50"><i class="ri-add-line text-xs"></i></button>
                        </div>
                    </div>
                    <div class="lg:col-span-2 flex lg:justify-end items-center gap-2">
                        <span class="lg:hidden text-xs text-gray-400 font-semibold uppercase">Total:</span>
                        <span class="text-sm font-bold text-gray-900">${{ number_format($item->price * $item->quantity, 2) }}</span>
                    </div>
                </div>
                @endforeach

                <div class="flex items-center justify-between mt-6">
                    <a class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-900 transition-colors" href="{{ url('/gallery') }}">
                        <i class="ri-arrow-left-line"></i> Continue Shopping
                    </a>
                    <button type="submit" class="inline-flex items-center gap-2 border border-stone-300 text-gray-700 font-semibold text-sm px-6 py-2.5 rounded-md hover:bg-stone-50 transition-colors whitespace-nowrap cursor-pointer">
                        <i class="ri-refresh-line"></i> Update Cart
                    </button>
                </div>
            </form>
        </div>

        <!-- Sidebar Summary -->
        <div class="w-full xl:w-80 flex-shrink-0">
            <div class="bg-stone-50 rounded-lg p-6 sticky top-24">
                <div class="flex justify-between items-baseline mb-4">
                    <h3 class="text-base font-bold text-gray-900">Order Summary</h3>
                    <span class="text-xs text-stone-500"><span x-text="selectedCount"></span> of {{ $cartItems->count() }} items selected</span>
                </div>
                
                <div class="space-y-4 mb-6 max-h-[250px] overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-stone-200">
                    <template x-for="id in selectedItems" :key="id">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-md overflow-hidden bg-stone-200 flex-shrink-0">
                                <img :src="cartData[id].image" :alt="cartData[id].name" class="w-full h-full object-cover object-top">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold text-gray-900 truncate" x-text="cartData[id].name"></p>
                                <p class="text-[10px] text-stone-500" x-text="'×' + cartData[id].quantity + ' · $' + cartData[id].price"></p>
                            </div>
                            <span class="text-xs font-bold text-gray-900" x-text="'$' + cartData[id].subtotal.toFixed(2)"></span>
                        </div>
                    </template>
                    <template x-if="selectedItems.length === 0">
                        <div class="py-4 text-center">
                            <p class="text-xs text-stone-400 italic">No items selected</p>
                        </div>
                    </template>
                </div>

                <div class="space-y-3 mb-6 border-t border-stone-200 pt-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Subtotal (<span x-text="selectedCount"></span> items)</span>
                        <span class="font-semibold text-gray-900" x-text="'$' + subtotal.toFixed(2)"></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Shipping</span>
                        <span class="font-semibold text-green-600 uppercase">FREE</span>
                    </div>
                    <div class="border-t border-stone-200 pt-3 flex justify-between items-center">
                        <span class="font-bold text-gray-900">Grand Total</span>
                        <span class="font-bold text-xl text-gray-900" x-text="'$' + grandTotal.toFixed(2)"></span>
                    </div>
                </div>
                
                <div class="mb-6">
                    <label class="block text-[10px] font-bold tracking-widest uppercase text-gray-500 mb-2">PROMO CODE</label>
                    <div class="flex gap-2">
                        <input type="text" placeholder="Enter code" class="w-full bg-white border border-stone-200 rounded-md px-3 py-2 text-sm focus:outline-none focus:border-amber-500">
                        <button type="button" class="bg-stone-900 hover:bg-stone-800 text-white font-semibold text-sm px-4 py-2 rounded-md transition-colors">
                            Apply
                        </button>
                    </div>
                </div>

                <a class="w-full flex items-center justify-center gap-2 bg-amber-500 hover:bg-amber-400 text-stone-900 font-bold text-sm py-3.5 rounded-md transition-colors whitespace-nowrap cursor-pointer shadow-lg shadow-amber-500/20" 
                    :class="selectedItems.length === 0 ? 'opacity-50 pointer-events-none cursor-not-allowed' : ''"
                    href="{{ route('checkout') }}">
                    Checkout <i class="ri-arrow-right-line text-lg"></i>
                </a>
            </div>
        </div>
    </div>
    @else
    <!-- Empty Cart State -->
    <div class="py-20 text-center">
        <div class="w-20 h-20 bg-stone-50 rounded-full flex items-center justify-center mx-auto mb-6 text-stone-300">
            <i class="ri-shopping-bag-line text-4xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Your cart is empty</h2>
        <p class="text-gray-500 mb-8 max-w-sm mx-auto">Looks like you haven't added anything to your cart yet. Explore our latest collections to find something you love.</p>
        <a href="{{ url('/gallery') }}" class="inline-flex items-center gap-2 bg-stone-900 text-white font-bold text-sm px-8 py-3.5 rounded-md hover:bg-stone-700 transition-colors">
            Start Shopping
        </a>
    </div>
    @endif
</div>
@endsection
