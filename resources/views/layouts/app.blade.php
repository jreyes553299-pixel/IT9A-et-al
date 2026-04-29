<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'NEXSTYLE') }}</title>
    
    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="" />
    <link
      href="https://fonts.googleapis.com/css2?family=Pacifico&amp;display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.5.0/remixicon.min.css"
    />
    <!-- Removed React scripts and CSS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link
      type="image/png"
      rel="icon"
      href="{{ asset('images/logo.png') }}"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Geist:wght@600&amp;display=swap"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/posthog-js@1.96.1/dist/array.full.min.js"
      async=""
    ></script>
  
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
    <body class="antialiased font-sans text-gray-900 bg-white" x-data="{ scrolled: false, mobileMenuOpen: false }" @scroll.window="scrolled = (window.pageYOffset > 50)">
    <div class="min-h-screen bg-white">
        <header 
            class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
            :class="scrolled ? 'bg-white shadow-md py-2' : 'bg-transparent py-4'"
        >
          <div class="w-full px-6 lg:px-12 xl:px-20">
            <div class="flex items-center justify-between h-16 lg:h-20">
              <a
                class="flex items-center gap-3 flex-shrink-0"
                href="{{ url('/') }}"
                data-discover="true"
                ><img
                  alt="Fashion &amp; Tech Hub Logo"
                  class="w-10 h-10 lg:w-12 lg:h-12 rounded-full object-cover"
                  src="{{ asset('images/logo.png') }}"
                />
                <div class="hidden sm:block">
                  <span
                    class="font-bold text-base lg:text-lg tracking-tight transition-colors"
                    :class="scrolled ? 'text-gray-900' : 'text-white'"
                    >NEXSTYLE</span
                  ><span
                    class="block text-xs tracking-widest transition-colors"
                    :class="scrolled ? 'text-gray-500' : 'text-white/70'"
                    >FASHION &amp; TECH</span
                  >
                </div></a
              >
              <nav class="hidden md:flex items-center gap-8">
                <a
                  class="text-sm font-medium tracking-wide transition-colors whitespace-nowrap hover:opacity-70 {{ request()->is('/') ? 'text-white border-b-2 border-current pb-0.5' : (request()->is('gallery') ? 'text-white' : 'text-white') }}"
                  :class="scrolled ? 'text-gray-900 {{ request()->is('/') ? 'border-gray-900' : 'border-transparent' }}' : 'text-white {{ request()->is('/') ? 'border-white' : 'border-transparent' }}'"
                  href="{{ url('/') }}"
                  data-discover="true"
                  >Home</a
                ><a
                  class="text-sm font-medium tracking-wide transition-colors whitespace-nowrap hover:opacity-70 {{ request()->is('gallery') ? 'text-white border-b-2 border-current pb-0.5' : '' }}"
                  :class="scrolled ? 'text-gray-700 {{ request()->is('gallery') ? 'border-gray-900' : 'border-transparent' }}' : 'text-white {{ request()->is('gallery') ? 'border-white' : 'border-transparent' }}'"
                  href="{{ url('/gallery') }}"
                  data-discover="true"
                  >Gallery</a
                ><a
                  class="text-sm font-medium tracking-wide transition-colors whitespace-nowrap hover:opacity-70"
                  :class="scrolled ? 'text-gray-700' : 'text-white'"
                  href="{{ url('/gallery?category=fashion') }}"
                  data-discover="true"
                  >Fashion</a
                ><a
                  class="text-sm font-medium tracking-wide transition-colors whitespace-nowrap hover:opacity-70"
                  :class="scrolled ? 'text-gray-700' : 'text-white'"
                  href="{{ url('/gallery?category=tech') }}"
                  data-discover="true"
                  >Tech</a
                >
              </nav>
                <div class="hidden md:flex items-center gap-4">
                    <a
                        class="transition-colors"
                        :class="scrolled ? 'text-gray-600 hover:text-gray-900' : 'text-white/80 hover:text-white'"
                        href="{{ url('/gallery') }}"
                        data-discover="true"
                        ><div class="w-10 h-10 flex items-center justify-center">
                            <i class="ri-search-line text-xl"></i></div
                    ></a>
                    <a
                        class="relative transition-colors"
                        :class="scrolled ? 'text-gray-600 hover:text-gray-900' : 'text-white/80 hover:text-white'"
                        href="{{ route('cart') }}"
                        data-discover="true"
                        ><div class="w-10 h-10 flex items-center justify-center">
                            <i class="ri-shopping-bag-line text-2xl"></i></div>
                        @if(count(session('cart', [])) > 0)
                        <span class="absolute top-0 right-0 w-5 h-5 bg-amber-500 text-white text-[11px] rounded-full flex items-center justify-center font-bold border-2 border-stone-900/10">
                            {{ count(session('cart', [])) }}
                        </span>
                        @endif
                    </a>
                    @guest
                    <a
                        class="flex items-center gap-2 text-sm font-semibold px-5 py-2.5 rounded-md transition-colors whitespace-nowrap"
                        :class="scrolled ? 'bg-stone-900 text-white hover:bg-stone-800' : 'bg-white/15 text-white hover:bg-white/25 border border-white/30'"
                        href="{{ route('login') }}"
                        data-discover="true"
                        ><i class="ri-user-line text-base"></i>
                        Sign In</a
                    >
                    @endguest

                    @auth
                    <div class="relative flex items-center" x-data="{ open: false }" @click.away="open = false">
                        <button
                            @click="open = !open"
                            class="flex items-center gap-3 transition-opacity hover:opacity-80 focus:outline-none"
                        >
                            <div class="w-10 h-10 rounded-full bg-amber-500 flex items-center justify-center text-stone-900 font-bold text-sm">
                                {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}
                            </div>
                            <span class="text-sm font-medium transition-colors" :class="scrolled ? 'text-stone-900' : 'text-white'">
                                {{ Auth::user()->email }}
                            </span>
                            <i class="ri-arrow-down-s-line text-lg transition-transform" :class="[open ? 'rotate-180' : '', scrolled ? 'text-stone-400' : 'text-white/60']"></i>
                        </button>
                        
                        <div
                            x-show="open"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            class="absolute right-0 top-full mt-3 w-64 bg-white rounded-xl shadow-2xl overflow-hidden z-50 border border-stone-100"
                            style="display: none;"
                        >
                            <div class="px-5 py-4 border-b border-stone-50">
                                <p class="text-sm font-bold text-stone-900 leading-none mb-1">{{ Auth::user()->email }}</p>
                                <p class="text-xs text-stone-400 mb-3">{{ Auth::user()->email }}</p>
                                <span class="inline-block px-3 py-1 bg-stone-100 text-stone-600 text-[10px] font-bold uppercase tracking-wider rounded-full">
                                    {{ Auth::user()->account_type ?? 'Buyer' }}
                                </span>
                            </div>
                            
                            <div class="py-2">
                                <a href="{{ route('account') }}" class="group px-5 py-2.5 text-sm text-stone-700 hover:bg-stone-50 flex items-center gap-3 transition-colors">
                                    <div class="w-8 h-8 flex items-center justify-center text-stone-400 group-hover:text-amber-500 transition-colors">
                                        <i class="ri-user-line text-lg"></i>
                                    </div>
                                    <span class="font-medium">My Profile</span>
                                </a>
                                <a href="{{ route('account') }}" class="group px-5 py-2.5 text-sm text-stone-700 hover:bg-stone-50 flex items-center gap-3 transition-colors">
                                    <div class="w-8 h-8 flex items-center justify-center text-stone-400 group-hover:text-amber-500 transition-colors">
                                        <i class="ri-shopping-bag-line text-lg"></i>
                                    </div>
                                    <span class="font-medium">My Orders</span>
                                </a>
                                <a href="{{ route('account') }}" class="group px-5 py-2.5 text-sm text-stone-700 hover:bg-stone-50 flex items-center gap-3 transition-colors">
                                    <div class="w-8 h-8 flex items-center justify-center text-stone-400 group-hover:text-amber-500 transition-colors">
                                        <i class="ri-heart-line text-lg"></i>
                                    </div>
                                    <span class="font-medium">Wishlist</span>
                                </a>
                            </div>

                            <div class="border-t border-stone-50 my-1"></div>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-5 py-4 text-sm text-red-500 hover:bg-rose-50 flex items-center gap-3 transition-colors">
                                    <div class="w-8 h-8 flex items-center justify-center text-red-400">
                                        <i class="ri-logout-box-line text-lg"></i>
                                    </div>
                                    <span class="font-bold">Sign Out</span>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endauth
                </div>
              <button
                @click="mobileMenuOpen = true"
                class="md:hidden w-9 h-9 flex items-center justify-center transition-colors"
                :class="scrolled ? 'text-gray-900' : 'text-white'"
              >
                <i class="text-xl ri-menu-line"></i>
              </button>
            </div>
          </div>

          <!-- Mobile Menu Overlay -->
          <div x-show="mobileMenuOpen" 
               x-transition:enter="transition ease-out duration-300"
               x-transition:enter-start="opacity-0 translate-x-full"
               x-transition:enter-end="opacity-100 translate-x-0"
               x-transition:leave="transition ease-in duration-200"
               x-transition:leave-start="opacity-100 translate-x-0"
               x-transition:leave-end="opacity-0 translate-x-full"
               class="fixed inset-0 z-[60] bg-white flex flex-col p-6"
               style="display: none;">
               <div class="flex items-center justify-between mb-8">
                   <div class="flex items-center gap-3">
                       <img src="{{ asset('images/logo.png') }}" class="w-8 h-8 rounded-full">
                       <span class="font-bold">NEXSTYLE</span>
                   </div>
                   <button @click="mobileMenuOpen = false" class="text-2xl"><i class="ri-close-line"></i></button>
               </div>
               <nav class="flex flex-col gap-6">
                   <a href="{{ url('/') }}" class="text-xl font-medium border-b border-gray-100 pb-2">Home</a>
                   <a href="{{ url('/gallery') }}" class="text-xl font-medium border-b border-gray-100 pb-2">Gallery</a>
                   <a href="{{ url('/gallery?category=fashion') }}" class="text-xl font-medium border-b border-gray-100 pb-2">Fashion</a>
                   <a href="{{ url('/gallery?category=tech') }}" class="text-xl font-medium border-b border-gray-100 pb-2">Tech</a>
               </nav>
                <div class="mt-auto flex flex-col gap-4">
                    @guest
                        <a href="{{ route('login') }}" class="bg-stone-900 text-white text-center py-4 rounded-md font-bold">Sign In</a>
                    @endguest

                    @auth
                        <div class="flex items-center gap-3 p-4 bg-stone-50 rounded-md mb-2">
                            <div class="w-10 h-10 rounded-full bg-amber-500 flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-bold text-gray-900">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full bg-rose-50 text-red-600 text-center py-4 rounded-md font-bold flex items-center justify-center gap-2">
                                <i class="ri-logout-box-line"></i> Logout
                            </button>
                        </form>
                    @endauth
                   <div class="flex justify-center gap-6 text-2xl text-gray-400">
                       <i class="ri-instagram-line"></i>
                       <i class="ri-twitter-x-line"></i>
                       <i class="ri-facebook-line"></i>
                   </div>
               </div>
          </div>
        </header>

        <!-- Global Notifications -->
        @if(session('success'))
        <div 
            x-data="{ show: true }" 
            x-show="show" 
            x-init="setTimeout(() => show = false, 5000)"
            class="fixed bottom-10 right-10 z-[100] bg-stone-900 text-white px-6 py-4 rounded-lg shadow-2xl flex items-center gap-3 border border-stone-800"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-10"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-10"
        >
            <div class="w-6 h-6 bg-amber-500 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="ri-check-line text-stone-900 text-sm"></i>
            </div>
            <p class="text-sm font-semibold tracking-wide">{{ session('success') }}</p>
            <button @click="show = false" class="ml-4 text-stone-500 hover:text-white transition-colors">
                <i class="ri-close-line"></i>
            </button>
        </div>
        @endif
        
        @yield('content')
        
        <footer class="bg-stone-900 text-stone-300">
          <div class="w-full px-6 lg:px-12 xl:px-20 py-16">
            <div
              class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-16"
            >
              <div class="lg:col-span-1">
                <div class="flex items-center gap-3 mb-5">
                  <img
                    alt="NEXSTYLE Logo"
                    class="w-10 h-10 rounded-full object-cover"
                    src="{{ asset('images/logo.png') }}"
                  />
                  <div>
                    <span class="font-bold text-white text-base tracking-tight"
                      >NEXSTYLE</span
                    ><span class="block text-xs tracking-widest text-stone-500"
                      >FASHION &amp; TECH</span
                    >
                  </div>
                </div>
                <p class="text-sm text-stone-400 leading-relaxed mb-6">
                  Where premium fashion meets cutting-edge technology. Curated
                  collections for the modern lifestyle.
                </p>
                <div class="flex items-center gap-3">
                  <a
                    href="#"
                    class="w-9 h-9 flex items-center justify-center rounded-full border border-stone-700 text-stone-400 hover:border-amber-500 hover:text-amber-500 transition-colors"
                    ><i class="ri-instagram-line"></i></a
                  ><a
                    href="#"
                    class="w-9 h-9 flex items-center justify-center rounded-full border border-stone-700 text-stone-400 hover:border-amber-500 hover:text-amber-500 transition-colors"
                    ><i class="ri-twitter-x-line"></i></a
                  ><a
                    href="#"
                    class="w-9 h-9 flex items-center justify-center rounded-full border border-stone-700 text-stone-400 hover:border-amber-500 hover:text-amber-500 transition-colors"
                    ><i class="ri-facebook-line"></i></a
                  ><a
                    href="#"
                    class="w-9 h-9 flex items-center justify-center rounded-full border border-stone-700 text-stone-400 hover:border-amber-500 hover:text-amber-500 transition-colors"
                    ><i class="ri-pinterest-line"></i
                  ></a>
                </div>
              </div>
              <div>
                <h4
                  class="text-white font-semibold text-sm tracking-widest uppercase mb-5"
                >
                  Shop
                </h4>
                <ul class="space-y-3">
                  <li>
                    <a
                      class="text-sm text-stone-400 hover:text-white transition-colors"
                      href="/gallery"
                      data-discover="true"
                      >New Arrivals</a
                    >
                  </li>
                  <li>
                    <a
                      class="text-sm text-stone-400 hover:text-white transition-colors"
                      href="/gallery"
                      data-discover="true"
                      >Fashion</a
                    >
                  </li>
                  <li>
                    <a
                      class="text-sm text-stone-400 hover:text-white transition-colors"
                      href="/gallery"
                      data-discover="true"
                      >Tech &amp; Electronics</a
                    >
                  </li>
                  <li>
                    <a
                      class="text-sm text-stone-400 hover:text-white transition-colors"
                      href="/gallery"
                      data-discover="true"
                      >Sale</a
                    >
                  </li>
                  <li>
                    <a
                      class="text-sm text-stone-400 hover:text-white transition-colors"
                      href="/gallery"
                      data-discover="true"
                      >Gift Cards</a
                    >
                  </li>
                  <li>
                    <a
                      class="text-sm text-stone-400 hover:text-white transition-colors"
                      href="/gallery"
                      data-discover="true"
                      >Lookbook</a
                    >
                  </li>
                </ul>
              </div>
              <div>
                <h4
                  class="text-white font-semibold text-sm tracking-widest uppercase mb-5"
                >
                  Support
                </h4>
                <ul class="space-y-3">
                  <li>
                    <a
                      href="#"
                      class="text-sm text-stone-400 hover:text-white transition-colors"
                      >Order Tracking</a
                    >
                  </li>
                  <li>
                    <a
                      href="#"
                      class="text-sm text-stone-400 hover:text-white transition-colors"
                      >Returns &amp; Exchanges</a
                    >
                  </li>
                  <li>
                    <a
                      href="#"
                      class="text-sm text-stone-400 hover:text-white transition-colors"
                      >Shipping Policy</a
                    >
                  </li>
                  <li>
                    <a
                      href="#"
                      class="text-sm text-stone-400 hover:text-white transition-colors"
                      >Size Guide</a
                    >
                  </li>
                  <li>
                    <a
                      href="#"
                      class="text-sm text-stone-400 hover:text-white transition-colors"
                      >Warranty Info</a
                    >
                  </li>
                  <li>
                    <a
                      href="#"
                      class="text-sm text-stone-400 hover:text-white transition-colors"
                      >Contact Us</a
                    >
                  </li>
                </ul>
              </div>
              <div>
                <h4
                  class="text-white font-semibold text-sm tracking-widest uppercase mb-5"
                >
                  Newsletter
                </h4>
                <p class="text-sm text-stone-400 mb-4 leading-relaxed">
                  Get early access to new drops, exclusive offers, and style
                  guides.
                </p>
                <form
                  method="POST"
                  action="/api/newsletter"
                  class="flex flex-col gap-3"
                >
                  <input
                    placeholder="Your email address"
                    class="w-full bg-stone-800 border border-stone-700 rounded-md px-4 py-2.5 text-sm text-white placeholder-stone-500 focus:outline-none focus:border-amber-500 transition-colors"
                    type="email"
                    name="email"
                  /><button
                    type="submit"
                    class="w-full bg-amber-500 hover:bg-amber-400 text-stone-900 font-semibold text-sm py-2.5 rounded-md transition-colors whitespace-nowrap cursor-pointer"
                  >
                    Subscribe
                  </button>
                </form>
              </div>
            </div>
          </div>
          <div class="border-t border-stone-800 px-6 lg:px-12 xl:px-20 py-5">
            <div
              class="flex flex-col sm:flex-row items-center justify-between gap-3"
            >
              <p class="text-xs text-stone-500">
                © 2026 NEXSTYLE Fashion &amp; Tech Hub. All rights reserved.
              </p>
              <div class="flex items-center gap-5">
                <a
                  href="#"
                  class="text-xs text-stone-500 hover:text-stone-300 transition-colors whitespace-nowrap"
                  >Privacy Policy</a
                ><a
                  href="#"
                  class="text-xs text-stone-500 hover:text-stone-300 transition-colors whitespace-nowrap"
                  >Terms of Service</a
                ><a
                  href="#"
                  class="text-xs text-stone-500 hover:text-stone-300 transition-colors whitespace-nowrap"
                  >Cookie Policy</a
                >
              </div>
            </div>
          </div>
        </footer>
    </div>
</body>
</html>