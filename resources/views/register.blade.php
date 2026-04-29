<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - NEXSTYLE</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.5.0/remixicon.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div id="root">
        <div class="min-h-screen flex">
            <!-- Left Side: Features & Branding -->
            <div class="hidden lg:flex lg:w-[42%] xl:w-[45%] relative overflow-hidden flex-col">
                <div class="absolute inset-0">
                    <img alt="NEXSTYLE" class="w-full h-full object-cover object-top" src="https://readdy.ai/api/search-image?query=luxury%20fashion%20boutique%20interior%20with%20premium%20clothing%20displays%20warm%20lighting%20elegant%20minimalist%20design%20high%20end%20retail%20store%20atmosphere%20modern%20aesthetic&width=900&height=1100&seq=register-bg&orientation=portrait">
                    <div class="absolute inset-0 bg-stone-900/40"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-stone-900 via-stone-900/60 to-transparent"></div>
                </div>
                <div class="relative z-10 flex flex-col h-full p-12 xl:p-14">
                    <a class="flex items-center gap-3 flex-shrink-0" href="{{ url('/') }}">
                        <img alt="NEXSTYLE" class="w-11 h-11 rounded-full object-cover" src="{{ asset('images/logo.png') }}">
                        <div>
                            <span class="font-bold text-white text-lg tracking-tight">NEXSTYLE</span>
                            <span class="block text-xs text-amber-400 tracking-widest font-semibold">FASHION & TECH</span>
                        </div>
                    </a>
                    <div class="flex-1 flex flex-col justify-center max-w-xs">
                        <span class="text-amber-400 text-xs font-bold tracking-[0.3em] uppercase mb-4 block">Join Us</span>
                        <h2 class="text-3xl xl:text-4xl font-bold text-white leading-tight mb-5">Create your<br>free account</h2>
                        <p class="text-stone-300 text-sm leading-relaxed mb-8">Join thousands of shoppers who trust NEXSTYLE for premium fashion and cutting-edge tech.</p>
                        
                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 flex items-center justify-center bg-amber-500/20 rounded-lg flex-shrink-0"><i class="ri-gift-line text-amber-400 text-sm"></i></div>
                                <div><p class="text-sm font-semibold text-white">Welcome Offer</p><p class="text-xs text-stone-400">10% off your first order</p></div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 flex items-center justify-center bg-amber-500/20 rounded-lg flex-shrink-0"><i class="ri-truck-line text-amber-400 text-sm"></i></div>
                                <div><p class="text-sm font-semibold text-white">Free Shipping</p><p class="text-xs text-stone-400">On orders over $150</p></div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 flex items-center justify-center bg-amber-500/20 rounded-lg flex-shrink-0"><i class="ri-history-line text-amber-400 text-sm"></i></div>
                                <div><p class="text-sm font-semibold text-white">Order Tracking</p><p class="text-xs text-stone-400">Real-time status updates</p></div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 flex items-center justify-center bg-amber-500/20 rounded-lg flex-shrink-0"><i class="ri-shield-check-line text-amber-400 text-sm"></i></div>
                                <div><p class="text-sm font-semibold text-white">Warranty Portal</p><p class="text-xs text-stone-400">Manage tech warranties</p></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Registration Form -->
            <div class="flex-1 flex flex-col justify-center px-6 sm:px-10 lg:px-12 xl:px-16 py-10 bg-white overflow-y-auto">
                <div class="lg:hidden flex items-center gap-3 mb-8">
                    <a class="flex items-center gap-3" href="{{ url('/') }}">
                        <img alt="NEXSTYLE" class="w-10 h-10 rounded-full object-cover" src="{{ asset('images/logo.png') }}">
                        <div>
                            <span class="font-bold text-gray-900 text-base tracking-tight">NEXSTYLE</span>
                            <span class="block text-xs text-amber-500 tracking-widest font-semibold">FASHION & TECH</span>
                        </div>
                    </a>
                </div>
                <div class="w-full max-w-lg mx-auto lg:mx-0">
                    <div class="mb-7">
                        <h1 class="text-2xl xl:text-3xl font-bold text-gray-900 mb-2">Create your account</h1>
                        <p class="text-gray-400 text-sm">Already have an account? <a class="text-amber-600 font-semibold hover:text-amber-700 transition-colors" href="{{ route('login') }}">Sign in</a></p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold tracking-widest uppercase text-gray-500 mb-2">First Name *</label>
                                <input required name="first_name" placeholder="Alexandra" class="w-full border rounded-md px-4 py-2.5 text-sm focus:outline-none focus:ring-1 transition-colors border-stone-200 focus:border-amber-500 focus:ring-amber-500/20" type="text">
                                @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold tracking-widest uppercase text-gray-500 mb-2">Last Name *</label>
                                <input required name="last_name" placeholder="Chen" class="w-full border rounded-md px-4 py-2.5 text-sm focus:outline-none focus:ring-1 transition-colors border-stone-200 focus:border-amber-500 focus:ring-amber-500/20" type="text">
                                @error('last_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold tracking-widest uppercase text-gray-500 mb-2">Username *</label>
                            <div class="relative">
                                <div class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 flex items-center justify-center pointer-events-none">
                                    <i class="ri-at-line text-gray-400 text-sm"></i>
                                </div>
                                <input required name="username" placeholder="alex_chen" class="w-full border rounded-md pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-1 transition-colors border-stone-200 focus:border-amber-500 focus:ring-amber-500/20" type="text">
                            </div>
                            @error('username') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold tracking-widest uppercase text-gray-500 mb-2">Email Address *</label>
                            <div class="relative">
                                <div class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 flex items-center justify-center pointer-events-none">
                                    <i class="ri-mail-line text-gray-400 text-sm"></i>
                                </div>
                                <input required name="email" autocomplete="email" placeholder="your@email.com" class="w-full border rounded-md pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-1 transition-colors border-stone-200 focus:border-amber-500 focus:ring-amber-500/20" type="email">
                            </div>
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold tracking-widest uppercase text-gray-500 mb-2">Phone Number <span class="text-gray-300 normal-case font-normal tracking-normal">(optional)</span></label>
                            <div class="relative">
                                <div class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 flex items-center justify-center pointer-events-none">
                                    <i class="ri-phone-line text-gray-400 text-sm"></i>
                                </div>
                                <input name="phone" placeholder="+1 (555) 000-0000" class="w-full border border-stone-200 rounded-md pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500/20 transition-colors" type="tel">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold tracking-widest uppercase text-gray-500 mb-2">Password *</label>
                            <div class="relative">
                                <div class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 flex items-center justify-center pointer-events-none">
                                    <i class="ri-lock-line text-gray-400 text-sm"></i>
                                </div>
                                <input required name="password" minlength="8" autocomplete="new-password" placeholder="Minimum 8 characters" class="w-full border rounded-md pl-10 pr-11 py-2.5 text-sm focus:outline-none focus:ring-1 transition-colors border-stone-200 focus:border-amber-500 focus:ring-amber-500/20" type="password">
                                <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 flex items-center justify-center text-gray-400 hover:text-gray-700 cursor-pointer transition-colors">
                                    <i class="ri-eye-line text-sm"></i>
                                </button>
                            </div>
                            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-3 pt-1">
                            <label class="flex items-start gap-3 cursor-pointer">
                                <input required class="w-4 h-4 accent-amber-500 cursor-pointer mt-0.5 flex-shrink-0" type="checkbox" name="agree_terms">
                                <span class="text-xs text-gray-500 leading-relaxed">I agree to the <a href="#" class="text-amber-600 hover:underline font-semibold">Terms of Service</a> and <a href="#" class="text-amber-600 hover:underline font-semibold">Privacy Policy</a>. *</span>
                            </label>
                            <label class="flex items-start gap-3 cursor-pointer">
                                <input class="w-4 h-4 accent-amber-500 cursor-pointer mt-0.5 flex-shrink-0" type="checkbox" checked name="subscribe_newsletter">
                                <span class="text-xs text-gray-500 leading-relaxed">Subscribe to our newsletter for exclusive deals, new arrivals, and style tips.</span>
                            </label>
                        </div>

                        <button type="submit" class="w-full flex items-center justify-center gap-2 bg-stone-900 hover:bg-stone-700 text-white font-bold text-sm py-3.5 rounded-md transition-colors whitespace-nowrap cursor-pointer mt-2">
                            <i class="ri-user-add-line"></i> Create Account
                        </button>
                    </form>
                    <p class="mt-5 text-center text-xs text-gray-400">Already have an account? <a class="text-amber-600 font-semibold hover:text-amber-700 transition-colors" href="{{ route('login') }}">Sign in here</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
