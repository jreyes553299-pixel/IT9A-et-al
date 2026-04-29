<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - NEXSTYLE Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.5.0/remixicon.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
    </style>
</head>
<body class="bg-stone-50 font-sans text-stone-900">
    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: true }">
        <!-- Sidebar -->
        <aside 
            class="bg-stone-900 text-white flex-shrink-0 transition-all duration-300 overflow-y-auto sidebar-scroll"
            :class="sidebarOpen ? 'w-64' : 'w-20'"
        >
            <!-- Logo Area -->
            <div class="h-20 flex items-center px-6 border-b border-white/5">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" class="w-8 h-8 rounded-full object-cover flex-shrink-0" alt="Logo">
                    <span class="font-bold tracking-tight transition-opacity duration-300" x-show="sidebarOpen">NEXSTYLE</span>
                </div>
            </div>

            <!-- Nav Items -->
            <nav class="p-4 space-y-2">
                <p class="text-[10px] font-bold text-stone-500 uppercase tracking-widest px-2 mb-4" x-show="sidebarOpen">Main Menu</p>
                
                <a href="{{ route('admin.dashboard') }}" 
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-amber-500 text-stone-900' : 'text-stone-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="ri-dashboard-line text-lg"></i>
                    <span class="text-sm font-medium" x-show="sidebarOpen">Dashboard</span>
                </a>

                <a href="{{ route('admin.inventory.index') }}" 
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.inventory.*') ? 'bg-amber-500 text-stone-900' : 'text-stone-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="ri-box-3-line text-lg"></i>
                    <span class="text-sm font-medium" x-show="sidebarOpen">Inventory</span>
                </a>

                <a href="{{ route('admin.suppliers.index') }}" 
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.suppliers.*') ? 'bg-amber-500 text-stone-900' : 'text-stone-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="ri-truck-line text-lg"></i>
                    <span class="text-sm font-medium" x-show="sidebarOpen">Suppliers</span>
                </a>

                <a href="{{ route('admin.purchase-orders.index') }}" 
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.purchase-orders.*') ? 'bg-amber-500 text-stone-900' : 'text-stone-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="ri-file-list-3-line text-lg"></i>
                    <span class="text-sm font-medium" x-show="sidebarOpen">Purchase Orders</span>
                </a>

                <a href="{{ route('admin.categories.index') }}" 
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-amber-500 text-stone-900' : 'text-stone-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="ri-price-tag-3-line text-lg"></i>
                    <span class="text-sm font-medium" x-show="sidebarOpen">Categories</span>
                </a>

                <a href="{{ route('admin.sales.index') }}" 
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.sales.index') ? 'bg-amber-500 text-stone-900' : 'text-stone-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="ri-shopping-cart-line text-lg"></i>
                    <span class="text-sm font-medium" x-show="sidebarOpen">Sales & Orders</span>
                </a>

                <a href="{{ route('admin.sales.trends') }}" 
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.sales.trends') ? 'bg-amber-500 text-stone-900' : 'text-stone-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="ri-line-chart-line text-lg"></i>
                    <span class="text-sm font-medium" x-show="sidebarOpen">Sales Trends</span>
                </a>

                <div class="pt-4 mt-4 border-t border-white/5">
                    <p class="text-[10px] font-bold text-stone-500 uppercase tracking-widest px-2 mb-4" x-show="sidebarOpen">System</p>
                    
                    <a href="{{ url('/') }}" target="_blank" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-stone-400 hover:bg-white/5 hover:text-white transition-colors">
                        <i class="ri-external-link-line text-lg"></i>
                        <span class="text-sm font-medium" x-show="sidebarOpen">View Website</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-rose-400 hover:bg-rose-500/10 transition-colors">
                            <i class="ri-logout-box-line text-lg"></i>
                            <span class="text-sm font-medium" x-show="sidebarOpen">Sign Out</span>
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="h-20 bg-white border-b border-stone-200 flex items-center justify-between px-8 flex-shrink-0">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="w-10 h-10 flex items-center justify-center text-stone-400 hover:bg-stone-50 rounded-lg transition-colors">
                        <i class="ri-menu-2-line text-xl"></i>
                    </button>
                    <h2 class="text-xl font-bold text-stone-900">@yield('page_title')</h2>
                </div>

                <div class="flex items-center gap-6">
                    <div class="relative">
                        <i class="ri-notification-3-line text-xl text-stone-400"></i>
                        <span class="absolute -top-1 -right-1 w-2 h-2 bg-amber-500 rounded-full"></span>
                    </div>
                    <div class="flex items-center gap-3 pl-6 border-l border-stone-200">
                        <div class="text-right">
                            <p class="text-sm font-bold text-stone-900">{{ optional(Auth::user())->first_name ?? 'Admin' }}</p>
                            <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest">Administrator</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-stone-100 flex items-center justify-center text-stone-400 font-bold">
                            {{ strtoupper(substr(optional(Auth::user())->first_name ?? 'A', 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-8">
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

                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
