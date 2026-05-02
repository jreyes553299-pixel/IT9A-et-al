<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - NEXSTYLE</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.5.0/remixicon.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body>
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
    <div id="root">
        <div class="min-h-screen flex">
            <!-- Left Side: Image & Branding -->
            <div class="hidden lg:flex lg:w-[55%] xl:w-[60%] relative overflow-hidden flex-col">
                <div class="absolute inset-0">
                    <img alt="NEXSTYLE Fashion & Tech" class="w-full h-full object-cover object-top"
                        src="https://readdy.ai/api/search-image?query=high%20fashion%20editorial%20photography%20luxury%20clothing%20rack%20with%20designer%20garments%20in%20a%20minimalist%20studio%20space%20warm%20amber%20lighting%20elegant%20atmosphere%20premium%20retail%20environment&width=1200&height=900&seq=login-bg&orientation=landscape">
                    <div class="absolute inset-0 bg-stone-900/40"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-stone-900 via-stone-900/60 to-transparent">
                    </div>
                </div>
                <div class="relative z-10 flex flex-col h-full p-12 xl:p-16">
                    <a class="flex items-center gap-3 flex-shrink-0" href="{{ url('/') }}">
                        <img alt="NEXSTYLE" class="w-11 h-11 rounded-full object-cover"
                            src="{{ asset('images/logo.png') }}">
                        <div>
                            <span class="font-bold text-white text-lg tracking-tight">NEXSTYLE</span>
                            <span class="block text-xs text-amber-400 tracking-widest font-semibold">FASHION &
                                TECH</span>
                        </div>
                    </a>
                    <div class="flex-1 flex flex-col justify-center max-w-md">
                        <span class="text-amber-400 text-xs font-bold tracking-[0.3em] uppercase mb-4 block">Welcome
                            Back</span>
                        <h1 class="text-4xl xl:text-5xl font-bold text-white leading-tight mb-6">Your style,<br>your
                            tech,<br>your world.</h1>
                        <p class="text-stone-300 text-base leading-relaxed">Sign in to access your personalized shopping
                            experience, track orders, and manage your account.</p>
                    </div>
                    <div class="flex items-center gap-6">
                        <div class="flex items-center gap-2 text-xs text-stone-400">
                            <div class="w-4 h-4 flex items-center justify-center"><i
                                    class="ri-shield-check-line text-amber-400"></i></div>Secure Login
                        </div>
                        <div class="flex items-center gap-2 text-xs text-stone-400">
                            <div class="w-4 h-4 flex items-center justify-center"><i
                                    class="ri-lock-line text-amber-400"></i></div>SSL Encrypted
                        </div>
                        <div class="flex items-center gap-2 text-xs text-stone-400">
                            <div class="w-4 h-4 flex items-center justify-center"><i
                                    class="ri-customer-service-2-line text-amber-400"></i></div>24/7 Support
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Form -->
            <div class="flex-1 flex flex-col justify-center px-6 sm:px-10 lg:px-14 xl:px-20 py-12 bg-white">
                <div class="lg:hidden flex items-center gap-3 mb-10">
                    <a class="flex items-center gap-3" href="{{ url('/') }}">
                        <img alt="NEXSTYLE" class="w-10 h-10 rounded-full object-cover"
                            src="{{ asset('images/logo.png') }}">
                        <div>
                            <span class="font-bold text-gray-900 text-base tracking-tight">NEXSTYLE</span>
                            <span class="block text-xs text-amber-500 tracking-widest font-semibold">FASHION &
                                TECH</span>
                        </div>
                    </a>
                </div>
                <div class="w-full max-w-md mx-auto lg:mx-0">
                    <div class="mb-8">
                        <h2 class="text-2xl xl:text-3xl font-bold text-gray-900 mb-2">Sign in to your account</h2>
                        <p class="text-gray-400 text-sm">Don't have an account? <a
                                class="text-amber-600 font-semibold hover:text-amber-700 transition-colors"
                                href="{{ route('register') }}">Create one free</a></p>
                    </div>



                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf
                        <div>
                            <label for="login"
                                class="block text-xs font-bold tracking-widest uppercase text-gray-500 mb-2">Username or
                                Email</label>
                            <div class="relative">
                                <div
                                    class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 flex items-center justify-center pointer-events-none">
                                    <i class="ri-user-line text-gray-400 text-sm"></i>
                                </div>
                                <input id="login" required autocomplete="username"
                                    placeholder="your@email.com or username"
                                    class="w-full border border-stone-200 rounded-md pl-10 pr-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500/20 transition-colors"
                                    type="text" name="login" value="{{ old('login') }}">
                            </div>
                            @error('login')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label for="password"
                                    class="block text-xs font-bold tracking-widest uppercase text-gray-500">Password</label>
                                <a class="text-xs text-amber-600 font-semibold hover:text-amber-700 transition-colors whitespace-nowrap"
                                    href="#">Forgot password?</a>
                            </div>
                            <div class="relative">
                                <div
                                    class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 flex items-center justify-center pointer-events-none">
                                    <i class="ri-lock-line text-gray-400 text-sm"></i>
                                </div>
                                <input id="password" required autocomplete="current-password"
                                    placeholder="Enter your password"
                                    class="w-full border border-stone-200 rounded-md pl-10 pr-11 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500/20 transition-colors"
                                    type="password" name="password">
                                <button type="button"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 flex items-center justify-center text-gray-400 hover:text-gray-700 cursor-pointer transition-colors">
                                    <i class="ri-eye-line text-sm"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                <input class="w-4 h-4 accent-amber-500 cursor-pointer rounded" type="checkbox"
                                    name="remember_me">
                                <span class="text-sm text-gray-600">Remember me for 30 days</span>
                            </label>
                        </div>

                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 bg-stone-900 hover:bg-stone-700 text-white font-bold text-sm py-3.5 rounded-md transition-colors whitespace-nowrap cursor-pointer">
                            <i class="ri-login-box-line"></i>Sign In
                        </button>

                        <div class="flex items-center gap-4">
                            <div class="flex-1 h-px bg-stone-100"></div>
                            <span class="text-xs text-gray-400 whitespace-nowrap">or continue with</span>
                            <div class="flex-1 h-px bg-stone-100"></div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <button type="button"
                                class="flex items-center justify-center gap-2 border border-stone-200 rounded-md py-2.5 text-sm font-semibold text-gray-700 hover:bg-stone-50 transition-colors cursor-pointer whitespace-nowrap">
                                <i class="ri-google-line text-base"></i>Google
                            </button>
                            <button type="button"
                                class="flex items-center justify-center gap-2 border border-stone-200 rounded-md py-2.5 text-sm font-semibold text-gray-700 hover:bg-stone-50 transition-colors cursor-pointer whitespace-nowrap">
                                <i class="ri-facebook-circle-line text-base"></i>Facebook
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</body>

</html>