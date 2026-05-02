@extends('layouts.app')

@section('content')
<div class="w-full px-6 lg:px-12 xl:px-20 pt-24 pb-4">
    <nav class="flex items-center gap-2 text-xs text-gray-400">
        <a class="hover:text-gray-700 transition-colors" href="{{ url('/') }}">Home</a>
        <i class="ri-arrow-right-s-line"></i>
        <a class="hover:text-gray-700 transition-colors" href="{{ url('/gallery') }}">Gallery</a>
        <i class="ri-arrow-right-s-line"></i>
        <a class="hover:text-gray-700 transition-colors capitalize" href="{{ url('/gallery?category='.optional($product->category)->slug) }}">{{ optional($product->category)->name }}</a>
        <i class="ri-arrow-right-s-line"></i>
        <span class="text-gray-700">{{ $product->name }}</span>
    </nav>
</div>

<div class="w-full px-6 lg:px-12 xl:px-20 py-8" x-data="{ mainImage: '{{ $product->image_url }}', selectedColor: '', selectedSize: '' }">
    <div class="flex flex-col lg:flex-row gap-10 xl:gap-16">
        <!-- Image Gallery -->
        <div class="w-full lg:w-[45%] xl:w-[40%] flex-shrink-0">
            <div class="w-full h-[420px] lg:h-[580px] rounded-lg overflow-hidden bg-stone-50">
                <img :src="mainImage" alt="{{ $product->name }}" class="w-full h-full object-cover object-top transition-all duration-500">
            </div>
            @if($product->additional_images && count($product->additional_images) > 0)
            <div class="flex gap-3 mt-3 overflow-x-auto pb-2 scrollbar-hide">
                <div 
                    @click="mainImage = '{{ $product->image_url }}'"
                    class="w-20 h-20 rounded-md overflow-hidden bg-stone-100 border-2 cursor-pointer transition-all flex-shrink-0"
                    :class="mainImage === '{{ $product->image_url }}' ? 'border-amber-500' : 'border-transparent'"
                >
                    <img src="{{ $product->image_url }}" alt="" class="w-full h-full object-cover object-top">
                </div>
                @foreach($product->additional_images as $img)
                <div 
                    @click="mainImage = '{{ $img }}'"
                    class="w-20 h-20 rounded-md overflow-hidden bg-stone-100 border-2 cursor-pointer transition-all flex-shrink-0"
                    :class="mainImage === '{{ $img }}' ? 'border-amber-500' : 'border-transparent'"
                >
                    <img src="{{ $img }}" alt="" class="w-full h-full object-cover object-top opacity-80 hover:opacity-100 transition-opacity">
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Product Info -->
        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-3 mb-3">
                <span class="text-xs font-bold tracking-widest uppercase text-amber-600">{{ $product->brand }}</span>
                @if($product->badge)
                <span class="text-xs font-bold px-2.5 py-1 rounded-full {{ $product->badge == 'SALE' ? 'bg-red-500' : ($product->badge == 'NEW' ? 'bg-amber-500' : 'bg-stone-800') }} text-white">{{ $product->badge }}</span>
                @endif
            </div>
            <h1 class="text-2xl lg:text-3xl xl:text-4xl font-bold text-gray-900 mb-3 leading-tight">{{ $product->name }}</h1>
            
            <div class="flex items-center gap-2 mb-5">
                <div class="flex items-center gap-0.5">
                    <i class="text-sm ri-star-fill text-amber-400"></i>
                    <i class="text-sm ri-star-fill text-amber-400"></i>
                    <i class="text-sm ri-star-fill text-amber-400"></i>
                    <i class="text-sm ri-star-fill text-amber-400"></i>
                    <i class="text-sm ri-star-line text-gray-300"></i>
                </div>
                <span class="text-sm font-semibold text-gray-700">4.8</span>
                <span class="text-sm text-gray-400">({{ $product->reviews_count }} reviews)</span>
            </div>

            <div class="flex items-baseline gap-3 mb-6">
                <span class="text-3xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                @if($product->original_price)
                <span class="text-lg text-gray-400 line-through">${{ number_format($product->original_price, 2) }}</span>
                <span class="text-sm font-semibold text-red-500">-{{ round((1 - ($product->price / $product->original_price)) * 100) }}% OFF</span>
                @endif
            </div>

            <div class="prose prose-stone prose-sm mb-7 max-w-none">
                <p class="text-gray-500 leading-relaxed">{{ $product->description }}</p>
            </div>

            <form method="POST" action="{{ route('cart.add') }}" class="space-y-5">
                @csrf
                <input type="hidden" value="{{ $product->id }}" name="product_id">
                <input type="hidden" name="color" x-model="selectedColor">
                <input type="hidden" name="size" x-model="selectedSize">
                
                @if($product->colors && count($product->colors) > 0)
                <div>
                    <label class="block text-xs font-bold tracking-widest uppercase text-gray-500 mb-3">Color: <span class="text-gray-900" x-text="selectedColor"></span></label>
                    <div class="flex items-center gap-3 flex-wrap">
                        @foreach($product->colors as $color)
                        <button 
                            type="button" 
                            @click="selectedColor = '{{ $color['name'] }}'"
                            class="w-10 h-10 rounded-full border-2 transition-all p-0.5"
                            :class="selectedColor === '{{ $color['name'] }}' ? 'border-amber-500 scale-110 shadow-lg shadow-amber-500/20' : 'border-transparent hover:border-gray-200'"
                            title="{{ $color['name'] }}"
                        >
                            <div class="w-full h-full rounded-full border border-stone-300" style="background-color: {{ $color['hex'] }};"></div>
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($product->sizes && count($product->sizes) > 0)
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <label class="text-xs font-bold tracking-widest uppercase text-gray-500">Size</label>
                        <a href="#" class="text-xs text-amber-600 hover:underline">Size Guide</a>
                    </div>
                    <div class="flex items-center gap-2 flex-wrap">
                        @foreach($product->sizes as $size)
                        <button 
                            type="button" 
                            @click="selectedSize = '{{ $size }}'"
                            class="min-w-[50px] h-11 px-4 rounded-lg text-sm font-bold border transition-all whitespace-nowrap"
                            :class="selectedSize === '{{ $size }}' ? 'bg-stone-900 text-white border-stone-900 shadow-lg shadow-stone-200' : 'bg-white border-stone-200 text-gray-700 hover:border-stone-400'"
                        >
                            {{ $size }}
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif

                <div>
                    <label class="block text-xs font-bold tracking-widest uppercase text-gray-500 mb-3">Quantity</label>
                    <div class="flex items-center gap-0" x-data="{ qty: 1 }">
                        <button type="button" @click="if(qty > 1) qty--" class="w-11 h-11 flex items-center justify-center border border-stone-300 rounded-l-lg text-gray-600 hover:bg-stone-50 transition-colors"><i class="ri-subtract-line"></i></button>
                        <input x-model="qty" max="{{ $product->stock }}" class="w-16 h-11 border-t border-b border-stone-300 text-center text-sm font-bold text-gray-900 focus:outline-none" type="number" name="quantity">
                        <button type="button" @click="if(qty < {{ $product->stock }}) qty++" class="w-11 h-11 flex items-center justify-center border border-stone-300 rounded-r-lg text-gray-600 hover:bg-stone-50 transition-colors"><i class="ri-add-line"></i></button>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    @if($product->stock > 0)
                    <button type="submit" class="flex-1 bg-stone-900 hover:bg-stone-800 text-white font-bold text-sm py-4 rounded-xl transition-all shadow-xl shadow-stone-200 flex items-center justify-center gap-3 group">
                        <i class="ri-shopping-bag-line text-lg group-hover:scale-110 transition-transform"></i>Add to Cart
                    </button>
                    @else
                    <button type="button" disabled class="flex-1 bg-stone-300 text-stone-500 font-bold text-sm py-4 rounded-xl cursor-not-allowed flex items-center justify-center gap-3">
                        <i class="ri-forbid-line text-lg"></i>Out of Stock
                    </button>
                    @endif
                </div>
            </form>

            <div class="flex flex-wrap gap-4 mt-7 pt-7 border-t border-stone-200">
                <div class="flex items-center gap-2 text-xs text-gray-500"><div class="w-5 h-5 flex items-center justify-center"><i class="ri-truck-line text-amber-500"></i></div>Free shipping over $150</div>
                <div class="flex items-center gap-2 text-xs text-gray-500"><div class="w-5 h-5 flex items-center justify-center"><i class="ri-shield-check-line text-amber-500"></i></div>Secure checkout</div>
                <div class="flex items-center gap-2 text-xs text-gray-500"><div class="w-5 h-5 flex items-center justify-center"><i class="ri-refresh-line text-amber-500"></i></div>30-day returns</div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <div class="mt-16">
        <h2 class="text-xl font-bold text-gray-900 mb-6">You May Also Like</h2>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($relatedProducts as $rel)
            <a class="group block bg-stone-50 rounded-lg overflow-hidden cursor-pointer" href="{{ route('product.show', $rel->id) }}">
                <div class="w-full h-48 overflow-hidden">
                    <img alt="{{ $rel->name }}" class="w-full h-full object-cover object-top transition-transform duration-500 group-hover:scale-105" src="{{ $rel->image_url }}">
                </div>
                <div class="p-4">
                    <span class="text-xs text-amber-600 font-semibold">{{ $rel->brand }}</span>
                    <p class="text-sm font-semibold text-gray-900 mt-1">{{ $rel->name }}</p>
                    <p class="text-sm font-bold text-gray-900 mt-1">${{ number_format($rel->price, 0) }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
