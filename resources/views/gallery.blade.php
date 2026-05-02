@extends('layouts.app')

@section('content')
<div class="w-full bg-stone-900 pt-24 pb-12 px-6 lg:px-12 xl:px-20">
    <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between gap-4">
        <div>
            <span class="text-amber-400 text-xs font-semibold tracking-[0.3em] uppercase mb-2 block">Browse</span>
            <h1 class="text-3xl lg:text-4xl font-bold text-white">Product Gallery</h1>
            <p class="text-stone-400 text-sm mt-2">{{ $products->total() }} products found</p>
        </div>
        <div class="relative w-full sm:w-72">
            <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-stone-400 text-sm"></i>
            <form action="{{ url('/gallery') }}" method="GET">
                <input placeholder="Search products..." class="w-full bg-stone-800 border border-stone-700 rounded-md pl-9 pr-4 py-2.5 text-sm text-white placeholder-stone-500 focus:outline-none focus:border-amber-500 transition-colors" type="text" value="{{ request('search') }}" name="search">
                @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
            </form>
        </div>
    </div>
</div>

<div class="w-full pl-2 lg:pl-2 xl:pl-4 pr-6 lg:pr-12 xl:pr-20 py-10">
    <div class="flex flex-col lg:flex-row gap-8">
        <aside class="w-full lg:w-56 xl:w-64 flex-shrink-0">
            <div class="bg-stone-50 rounded-lg p-6 sticky top-24">
                <h3 class="text-xs font-bold tracking-widest uppercase text-gray-500 mb-4">Category</h3>
                <div class="flex flex-col gap-1 mb-6">
                    <a href="{{ request()->fullUrlWithQuery(['category' => 'all', 'page' => null]) }}" class="text-left text-sm px-3 py-2 rounded-md transition-colors cursor-pointer whitespace-nowrap {{ !request('category') || request('category') == 'all' ? 'bg-amber-500 text-white font-semibold' : 'text-gray-600 hover:bg-stone-100' }}">All Products</a>
                    @foreach($categories as $cat)
                    <a href="{{ request()->fullUrlWithQuery(['category' => $cat->slug, 'page' => null]) }}" class="text-left text-sm px-3 py-2 rounded-md transition-colors cursor-pointer whitespace-nowrap {{ request('category') == $cat->slug ? 'bg-amber-500 text-white font-semibold' : 'text-gray-600 hover:bg-stone-100' }}">{{ $cat->name }}</a>
                    @endforeach
                </div>
                
                <h3 class="text-xs font-bold tracking-widest uppercase text-gray-500 mb-4">Price Range</h3>
                <form method="GET" action="{{ url('/gallery') }}" class="flex flex-col gap-3">
                    @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <div class="flex items-center gap-2">
                        <input placeholder="Min" class="w-full border border-stone-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:border-amber-500" type="number" name="min_price" value="{{ request('min_price') }}">
                        <span class="text-gray-400 text-sm">–</span>
                        <input placeholder="Max" class="w-full border border-stone-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:border-amber-500" type="number" name="max_price" value="{{ request('max_price') }}">
                    </div>
                    <button type="submit" class="w-full bg-stone-800 text-white text-sm font-semibold py-2 rounded-md hover:bg-stone-700 transition-colors cursor-pointer whitespace-nowrap">Apply Filter</button>
                </form>
            </div>
        </aside>
        
        <div class="flex-1 min-w-0">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 mb-6">
                <p class="text-sm text-gray-500">Showing <strong class="text-gray-900">{{ $products->count() }}</strong> of <strong class="text-gray-900">{{ $products->total() }}</strong> results</p>
                <div class="flex items-center gap-2">
                    <label class="text-sm text-gray-500 whitespace-nowrap">Sort by:</label>
                    <form action="{{ url('/gallery') }}" method="GET" id="sortForm">
                        @foreach(request()->except('sort') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <select name="sort" onchange="this.form.submit()" class="border border-stone-300 rounded-md px-3 py-2 text-sm text-gray-700 focus:outline-none focus:border-amber-500 cursor-pointer">
                            <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Featured</option>
                            <option value="price-asc" {{ request('sort') == 'price-asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price-desc" {{ request('sort') == 'price-desc' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Top Rated</option>
                        </select>
                    </form>
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 lg:gap-6">
                @forelse($products as $product)
                <a class="group bg-white border-2 border-stone-300 shadow-md transition-all hover:border-amber-400" href="{{ route('product.show', $product->id) }}">
                    <div class="relative w-full h-64 overflow-hidden bg-stone-50">
                        <img alt="{{ $product->name }}" class="w-full h-full object-cover object-top transition-transform duration-500 group-hover:scale-105" src="{{ $product->image_url }}">
                        @if($product->badge)
                        <span class="absolute top-3 left-3 text-xs font-bold px-2.5 py-1 rounded-full {{ $product->badge == 'SALE' ? 'bg-red-500' : ($product->badge == 'NEW' ? 'bg-amber-500' : 'bg-stone-800') }} text-white">{{ $product->badge }}</span>
                        @endif
                        <span class="absolute top-3 right-3 text-xs font-semibold px-2 py-1 rounded-full bg-stone-100 text-stone-600">{{ optional($product->category)->name }}</span>
                    </div>
                    <div class="p-4">
                        <span class="text-xs text-amber-600 font-semibold tracking-wide uppercase">{{ $product->brand }}</span>
                        <h3 class="text-sm font-semibold text-gray-900 mt-1 mb-2 leading-snug">{{ $product->name }}</h3>
                        <div class="flex items-center gap-1 mb-3">
                            <i class="text-xs ri-star-fill text-amber-400"></i>
                            <i class="text-xs ri-star-fill text-amber-400"></i>
                            <i class="text-xs ri-star-fill text-amber-400"></i>
                            <i class="text-xs ri-star-fill text-amber-400"></i>
                            <i class="text-xs ri-star-line text-gray-300"></i>
                            <span class="text-xs text-gray-400 ml-1">({{ $product->reviews_count }})</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="text-base font-bold text-gray-900">$\{{ number_format($product->price, 0) }}</span>
                                @if($product->original_price)
                                <span class="text-xs text-gray-400 line-through">$\{{ number_format($product->original_price, 0) }}</span>
                                @endif
                            </div>
                            @if($product->colors)
                            <div class="flex items-center gap-1">
                                @foreach($product->colors as $color)
                                <span class="w-3 h-3 rounded-full border border-gray-200" style="background-color: {{ is_array($color) ? $color['hex'] : $color }};"></span>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                </a>
                @empty
                <div class="col-span-full py-20 text-center">
                    <p class="text-gray-500">No products found matching your criteria.</p>
                </div>
                @endforelse
            </div>
            
            @if($products->hasPages())
            <div class="flex items-center justify-center gap-2 mt-12">
                @if($products->onFirstPage())
                    <button disabled class="w-9 h-9 flex items-center justify-center rounded-md border border-stone-300 text-gray-600 opacity-40 cursor-not-allowed transition-colors"><i class="ri-arrow-left-s-line"></i></button>
                @else
                    <a href="{{ $products->previousPageUrl() }}" class="w-9 h-9 flex items-center justify-center rounded-md border border-stone-300 text-gray-600 hover:bg-stone-50 transition-colors"><i class="ri-arrow-left-s-line"></i></a>
                @endif

                @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                    @if($page == $products->currentPage())
                        <button class="w-9 h-9 flex items-center justify-center rounded-md text-sm font-medium transition-colors bg-stone-900 text-white">{{ $page }}</button>
                    @else
                        <a href="{{ $url }}" class="w-9 h-9 flex items-center justify-center rounded-md text-sm font-medium transition-colors border border-stone-300 text-gray-600 hover:bg-stone-50">{{ $page }}</a>
                    @endif
                @endforeach

                @if($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}" class="w-9 h-9 flex items-center justify-center rounded-md border border-stone-300 text-gray-600 hover:bg-stone-50 transition-colors"><i class="ri-arrow-right-s-line"></i></a>
                @else
                    <button disabled class="w-9 h-9 flex items-center justify-center rounded-md border border-stone-200 text-gray-600 opacity-40 cursor-not-allowed transition-colors"><i class="ri-arrow-right-s-line"></i></a>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
