@extends('layouts.app')

@section('content')
<main>
    <section class="relative w-full h-[520px] md:h-[700px] lg:h-screen min-h-[600px] overflow-hidden">
        <div class="absolute inset-0">
            <img alt="Hero" class="w-full h-full object-cover object-top" src="https://readdy.ai/api/search-image?query=luxury%20fashion%20editorial%20widescreen%20hero%20image%20model%20wearing%20elegant%20structured%20coat%20in%20minimalist%20modern%20interior%20architectural%20space%20dramatic%20lighting%20high%20contrast%20black%20and%20white%20tones%20premium%20retail%20atmosphere&amp;width=1920&amp;height=1080&amp;seq=hero1&amp;orientation=landscape" />
            <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-black/20"></div>
        </div>
        <div class="relative z-10 w-full h-full flex items-center px-6 lg:px-12 xl:px-20">
            <div class="max-w-2xl">
                <span class="inline-block text-amber-400 text-xs font-semibold tracking-[0.3em] uppercase mb-4">Spring / Summer 2026</span>
                <h1 class="text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-bold text-white leading-tight mb-6">
                    Where Style<br /><span class="text-amber-400">Meets</span><br />Innovation
                </h1>
                <p class="text-white/70 text-base md:text-lg mb-8 leading-relaxed max-w-lg">
                    Discover curated fashion collections and cutting-edge tech — all in one premium destination.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a class="inline-flex items-center justify-center gap-2 bg-white text-gray-900 font-semibold text-sm px-8 py-3.5 rounded-md hover:bg-amber-400 transition-colors whitespace-nowrap cursor-pointer" href="/gallery?category=fashion" data-discover="true">Shop Fashion<i class="ri-arrow-right-line"></i></a>
                    <a class="inline-flex items-center justify-center gap-2 border border-white/50 text-white font-semibold text-sm px-8 py-3.5 rounded-md hover:bg-white/10 transition-colors whitespace-nowrap cursor-pointer" href="/gallery?category=tech" data-discover="true">Explore Tech<i class="ri-arrow-right-line"></i></a>
                </div>
            </div>
        </div>
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-white/50">
            <span class="text-xs tracking-widest uppercase">Scroll</span>
            <div class="w-px h-10 bg-white/30 animate-pulse"></div>
        </div>
    </section>

    <section class="w-full bg-amber-500 px-6 lg:px-12 xl:px-20 py-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 flex items-center justify-center flex-shrink-0"><i class="ri-truck-line text-2xl text-stone-900"></i></div>
                <div><p class="text-stone-900 font-bold text-sm">Free Shipping</p><p class="text-stone-700 text-xs">On orders over $150</p></div>
            </div>
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 flex items-center justify-center flex-shrink-0"><i class="ri-shield-check-line text-2xl text-stone-900"></i></div>
                <div><p class="text-stone-900 font-bold text-sm">2-Year Warranty</p><p class="text-stone-700 text-xs">On all tech products</p></div>
            </div>
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 flex items-center justify-center flex-shrink-0"><i class="ri-refresh-line text-2xl text-stone-900"></i></div>
                <div><p class="text-stone-900 font-bold text-sm">30-Day Returns</p><p class="text-stone-700 text-xs">Hassle-free exchanges</p></div>
            </div>
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 flex items-center justify-center flex-shrink-0"><i class="ri-customer-service-2-line text-2xl text-stone-900"></i></div>
                <div><p class="text-stone-900 font-bold text-sm">24/7 Support</p><p class="text-stone-700 text-xs">Dedicated assistance</p></div>
            </div>
        </div>
    </section>

    <section class="w-full px-6 lg:px-12 xl:px-20 py-16 lg:py-24">
        <div class="text-center mb-12">
            <span class="text-xs font-semibold tracking-[0.3em] uppercase text-amber-500 mb-3 block">Collections</span>
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900">Shop by Category</h2>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
            @foreach($categories as $category)
            <a class="group relative overflow-hidden rounded-lg h-64 lg:h-80 xl:h-96 cursor-pointer block" href="/gallery?category={{ $category->slug }}" data-discover="true">
                <img alt="{{ $category->name }}" class="w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-105" src="{{ $category->image_url }}" />
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-8">
                    <span class="text-white/60 text-xs tracking-widest uppercase mb-1 block">{{ $category->subtitle }}</span>
                    <h3 class="text-white text-3xl font-bold mb-3">{{ $category->name }}</h3>
                    <span class="inline-flex items-center gap-2 text-white text-sm font-medium border-b border-white/40 pb-0.5 group-hover:border-amber-400 group-hover:text-amber-400 transition-colors">
                        Explore Collection<i class="ri-arrow-right-line transition-transform group-hover:translate-x-1"></i>
                    </span>
                </div>
            </a>
            @endforeach
        </div>
    </section>

    <section class="w-full px-6 lg:px-12 xl:px-20 py-16 lg:py-24 bg-stone-50">
        <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between mb-12 gap-4">
            <div>
                <span class="text-xs font-semibold tracking-[0.3em] uppercase text-amber-500 mb-3 block">Handpicked</span>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900">Featured Products</h2>
            </div>
            <a class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors whitespace-nowrap" href="/gallery" data-discover="true">
                View All<i class="ri-arrow-right-line"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-5 lg:gap-6">
            @foreach($products as $product)
            <a class="group bg-white rounded-lg overflow-hidden cursor-pointer block" href="{{ route('product.show', $product->id) }}" data-discover="true">
                <div class="relative w-full h-64 lg:h-72 overflow-hidden bg-stone-100">
                    <img alt="{{ $product->name }}" class="w-full h-full object-cover object-top transition-transform duration-500 group-hover:scale-105" src="{{ $product->image_url }}" />
                    
                    @if($product->badge)
                    <span class="absolute top-3 left-3 text-xs font-bold px-2.5 py-1 rounded-full {{ $product->badge == 'SALE' ? 'bg-red-500 text-white' : ($product->badge == 'NEW' ? 'bg-amber-500 text-white' : 'bg-stone-800 text-white') }}">
                        {{ $product->badge }}
                    </span>
                    @endif
                    
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300"></div>
                    <div class="absolute bottom-3 left-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <span class="block text-center bg-white text-gray-900 text-xs font-semibold py-2 rounded-md">Quick View</span>
                    </div>
                </div>
                <div class="p-4">
                    <span class="text-xs text-amber-600 font-semibold tracking-wide uppercase">{{ $product->brand }}</span>
                    <h3 class="text-sm font-semibold text-gray-900 mt-1 mb-2 leading-snug">{{ $product->name }}</h3>
                    
                    <div class="flex items-center gap-1 mb-2">
                        <i class="text-xs ri-star-fill text-amber-400"></i>
                        <i class="text-xs ri-star-fill text-amber-400"></i>
                        <i class="text-xs ri-star-fill text-amber-400"></i>
                        <i class="text-xs ri-star-fill text-amber-400"></i>
                        <i class="text-xs ri-star-line text-gray-300"></i>
                        <span class="text-xs text-gray-400 ml-1">({{ $product->reviews_count }})</span>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <span class="text-base font-bold text-gray-900">${{ number_format($product->price, 0) }}</span>
                        @if($product->original_price)
                        <span class="text-sm text-gray-400 line-through">${{ number_format($product->original_price, 0) }}</span>
                        @endif
                    </div>
                    
                    @if($product->colors)
                    <div class="flex items-center gap-1.5 mt-2">
                        @foreach($product->colors as $color)
                        <span class="w-3.5 h-3.5 rounded-full border border-gray-200" style="background-color: {{ is_array($color) ? $color['hex'] : $color }}"></span>
                        @endforeach
                    </div>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
    </section>

    <section class="w-full px-6 lg:px-12 xl:px-20 py-16 lg:py-24">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
            <div class="lg:col-span-2 relative overflow-hidden rounded-lg h-72 lg:h-96 group cursor-pointer">
                <img alt="New Season Arrivals" class="w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-105" src="https://readdy.ai/api/search-image?query=fashion%20editorial%20spread%20widescreen%20two%20models%20wearing%20coordinated%20minimalist%20outfits%20in%20modern%20architectural%20space%20neutral%20tones%20premium%20lifestyle%20photography&amp;width=1200&amp;height=700&amp;seq=trend1&amp;orientation=landscape" />
                <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-transparent"></div>
                <div class="absolute inset-0 flex items-center p-10">
                    <div>
                        <span class="text-amber-400 text-xs font-semibold tracking-[0.3em] uppercase mb-3 block">New Season</span>
                        <h3 class="text-white text-3xl lg:text-4xl font-bold mb-4">SS26 Arrivals</h3>
                        <a class="inline-flex items-center gap-2 bg-white text-gray-900 text-sm font-semibold px-6 py-2.5 rounded-md hover:bg-amber-400 transition-colors whitespace-nowrap" href="/gallery?category=fashion" data-discover="true">
                            Shop Now <i class="ri-arrow-right-line"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-6">
                <div class="relative overflow-hidden rounded-lg h-44 group cursor-pointer">
                    <img alt="Tech Accessories" class="w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-105" src="https://readdy.ai/api/search-image?query=premium%20wireless%20earbuds%20and%20smartwatch%20flat%20lay%20on%20white%20marble%20surface%20tech%20accessories%20luxury%20product%20photography%20minimal&amp;width=600&amp;height=400&amp;seq=trend2&amp;orientation=landscape" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-5">
                        <span class="text-white/60 text-xs tracking-widest uppercase">Tech</span>
                        <h4 class="text-white font-bold text-lg">Wearables &amp; Audio</h4>
                    </div>
                </div>
                <div class="relative overflow-hidden rounded-lg h-44 group cursor-pointer">
                    <img alt="Accessories" class="w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-105" src="https://readdy.ai/api/search-image?query=luxury%20leather%20handbag%20and%20accessories%20flat%20lay%20on%20cream%20background%20fashion%20accessories%20premium%20product%20photography%20minimal%20elegant&amp;width=600&amp;height=400&amp;seq=trend3&amp;orientation=landscape" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-5">
                        <span class="text-white/60 text-xs tracking-widest uppercase">Fashion</span>
                        <h4 class="text-white font-bold text-lg">Bags &amp; Accessories</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="w-full bg-stone-50 px-6 lg:px-12 xl:px-20 py-16 lg:py-24">
        <div class="text-center mb-12">
            <span class="text-xs font-semibold tracking-[0.3em] uppercase text-amber-500 mb-3 block">Reviews</span>
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900">What Our Customers Say</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
            @foreach($reviews as $review)
            <div class="bg-white rounded-lg p-7">
                <div class="flex items-center gap-1 mb-4">
                    @for($i=0; $i<$review->rating; $i++)
                    <i class="ri-star-fill text-amber-400 text-sm"></i>
                    @endfor
                </div>
                <p class="text-gray-600 text-sm leading-relaxed mb-6 italic">“{{ $review->content }}”</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full overflow-hidden flex-shrink-0">
                        <img alt="{{ $review->customer_name }}" class="w-full h-full object-cover" src="{{ $review->avatar_url }}" />
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">{{ $review->customer_name }}</p>
                        <p class="text-xs text-gray-400">{{ $review->customer_title }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
</main>
@endsection
