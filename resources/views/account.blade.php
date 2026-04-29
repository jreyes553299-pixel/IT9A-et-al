@extends('layouts.app')

@section('content')
{{-- ======================== HEADER BANNER ======================== --}}
<div class="w-full bg-stone-900 pt-24 pb-6 px-6 lg:px-12 xl:px-20">
    <p class="text-amber-400 text-[10px] font-black tracking-[0.3em] uppercase mb-4">My Account</p>
    <div class="flex items-center gap-5 mb-8">
        <div class="w-16 h-16 rounded-full bg-amber-500 flex items-center justify-center text-stone-900 text-2xl font-black flex-shrink-0">
            {{ strtoupper(substr($user->first_name, 0, 1)) }}
        </div>
        <div>
            <h1 class="text-3xl font-black text-white leading-tight">{{ $user->first_name }} {{ $user->last_name }}</h1>
            <p class="text-stone-400 text-sm mt-1">{{ $user->email }} &middot; Member since {{ $user->created_at->format('F Y') }}</p>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
        <div class="bg-stone-800/50 border border-stone-700/50 rounded-xl p-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-amber-500/10 flex items-center justify-center text-amber-500">
                <i class="ri-shopping-bag-3-fill text-xl"></i>
            </div>
            <div>
                <div class="flex items-baseline gap-1">
                    <p class="text-xl font-black text-white">{{ $orders->count() }}</p>
                </div>
                <p class="text-[9px] font-black text-stone-400 uppercase tracking-widest">Total Orders</p>
            </div>
        </div>
        <div class="bg-stone-800/50 border border-stone-700/50 rounded-xl p-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-amber-500/10 flex items-center justify-center text-amber-500">
                <i class="ri-coin-line text-xl"></i>
            </div>
            <div>
                <div class="flex items-baseline gap-1">
                    <p class="text-xl font-black text-white">${{ number_format($orders->sum('total'), 0) }}</p>
                </div>
                <p class="text-[9px] font-black text-stone-400 uppercase tracking-widest">Total Spent</p>
            </div>
        </div>
        <div class="bg-stone-800/50 border border-stone-700/50 rounded-xl p-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-amber-500/10 flex items-center justify-center text-amber-500">
                <i class="ri-heart-3-fill text-xl"></i>
            </div>
            <div>
                <div class="flex items-baseline gap-1">
                    <p class="text-xl font-black text-white">6</p>
                </div>
                <p class="text-[9px] font-black text-stone-400 uppercase tracking-widest">Wishlist Items</p>
            </div>
        </div>
        <div class="bg-stone-800/50 border border-stone-700/50 rounded-xl p-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-amber-500/10 flex items-center justify-center text-amber-500">
                <i class="ri-medal-fill text-xl"></i>
            </div>
            <div>
                <div class="flex items-baseline gap-1">
                    <p class="text-xl font-black text-white">2,840</p>
                    <p class="text-[10px] font-bold text-stone-400 uppercase">pts</p>
                </div>
                <p class="text-[9px] font-black text-stone-400 uppercase tracking-widest">Loyalty Points</p>
            </div>
        </div>
    </div>
</div>

{{-- ======================== BODY ======================== --}}
<div class="w-full px-6 lg:px-12 xl:px-20 py-10" x-data="{ activeTab: 'Addresses' }">
    <div class="flex flex-col lg:flex-row gap-10">
        {{-- Sidebar --}}
        <div class="flex-shrink-0" style="width: 220px;">
            <nav class="space-y-1 bg-white rounded-xl border border-stone-100 p-2 shadow-sm">
                <button @click="activeTab = 'Profile'"
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-bold transition-all border-l-4"
                    :class="activeTab === 'Profile' ? 'border-amber-500 text-amber-700 bg-amber-50' : 'border-transparent text-stone-400 hover:bg-stone-50'">
                    <i class="ri-user-line text-lg"></i>
                    <span>Profile</span>
                </button>
                <button @click="activeTab = 'Addresses'"
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-bold transition-all border-l-4"
                    :class="activeTab === 'Addresses' ? 'border-amber-500 text-amber-700 bg-amber-50' : 'border-transparent text-stone-400 hover:bg-stone-50'">
                    <i class="ri-map-pin-line text-lg"></i>
                    <span>Addresses</span>
                </button>
                <button @click="activeTab = 'Security'"
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-bold transition-all border-l-4"
                    :class="activeTab === 'Security' ? 'border-amber-500 text-amber-700 bg-amber-50' : 'border-transparent text-stone-400 hover:bg-stone-50'">
                    <i class="ri-shield-keyhole-line text-lg"></i>
                    <span>Security</span>
                </button>
                <button @click="activeTab = 'Preferences'"
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-bold transition-all border-l-4"
                    :class="activeTab === 'Preferences' ? 'border-amber-500 text-amber-700 bg-amber-50' : 'border-transparent text-stone-400 hover:bg-stone-50'">
                    <i class="ri-settings-3-line text-lg"></i>
                    <span>Preferences</span>
                </button>
                <div class="border-t border-stone-100 my-2"></div>
                <button @click="activeTab = 'Orders'"
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-bold transition-all border-l-4"
                    :class="activeTab === 'Orders' ? 'border-amber-500 text-amber-700 bg-amber-50' : 'border-transparent text-stone-400 hover:bg-stone-50'">
                    <i class="ri-shopping-bag-line text-lg"></i>
                    <span>My Orders</span>
                </button>
                <button @click="activeTab = 'Wishlist'"
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-bold transition-all border-l-4"
                    :class="activeTab === 'Wishlist' ? 'border-amber-500 text-amber-700 bg-amber-50' : 'border-transparent text-stone-400 hover:bg-stone-50'">
                    <i class="ri-heart-line text-lg"></i>
                    <span>Wishlist</span>
                </button>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-bold text-rose-500 hover:bg-rose-50 transition-all border-l-4 border-transparent">
                        <i class="ri-logout-box-line text-lg"></i>
                        <span>Sign Out</span>
                    </button>
                </form>
            </nav>
        </div>

        {{-- Main Content --}}
        <div class="flex-1 min-w-0">
            @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-xl flex items-center gap-3">
                <i class="ri-checkbox-circle-line text-xl"></i>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
            @endif

            {{-- ── Profile Tab ── --}}
            <div x-show="activeTab === 'Profile'" x-cloak>
                <div class="bg-white rounded-xl border border-stone-200 p-8">
                    <h2 class="text-lg font-bold text-stone-900 mb-1">Profile Information</h2>
                    <p class="text-sm text-stone-400 mb-8">Your personal details on record.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-stone-400 uppercase tracking-widest mb-2">First Name</label>
                            <input type="text" value="{{ $user->first_name }}" disabled class="w-full border border-stone-200 rounded-lg px-4 py-3 text-sm bg-stone-50 text-stone-500 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-stone-400 uppercase tracking-widest mb-2">Last Name</label>
                            <input type="text" value="{{ $user->last_name }}" disabled class="w-full border border-stone-200 rounded-lg px-4 py-3 text-sm bg-stone-50 text-stone-500 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-stone-400 uppercase tracking-widest mb-2">Email</label>
                            <input type="email" value="{{ $user->email }}" disabled class="w-full border border-stone-200 rounded-lg px-4 py-3 text-sm bg-stone-50 text-stone-500 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-stone-400 uppercase tracking-widest mb-2">Phone</label>
                            <input type="text" value="{{ $user->phone ?? 'Not set' }}" disabled class="w-full border border-stone-200 rounded-lg px-4 py-3 text-sm bg-stone-50 text-stone-500 cursor-not-allowed">
                        </div>
                    </div>
                    <p class="text-xs text-stone-400 mt-6"><i class="ri-information-line"></i> Profile editing coming soon.</p>
                </div>
            </div>

            {{-- ── Address Tab ── --}}
            <div x-show="activeTab === 'Addresses'">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-base font-bold text-stone-900 flex items-center gap-2">
                        <i class="ri-map-pin-2-fill text-amber-500"></i> Saved Addresses
                    </h2>
                    <button @click="showForm = !showForm" class="flex items-center gap-2 bg-amber-500 hover:bg-amber-400 text-stone-900 font-bold text-sm px-5 py-2.5 rounded-lg transition-colors shadow-md shadow-amber-500/20">
                        <i class="ri-add-line text-lg"></i> Add Address
                    </button>
                </div>

                {{-- Add / Edit Address Form --}}
                <div x-show="showForm" x-cloak class="bg-white rounded-xl border border-amber-200 p-6 mb-6">
                    <h3 class="text-sm font-bold text-stone-900 mb-5 flex items-center gap-2">
                        <i class="ri-map-pin-line text-amber-500"></i> New Address
                    </h3>
                    <form method="POST" action="{{ route('account.address') }}">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div class="md:col-span-2">
                                <label class="block text-[10px] font-black text-stone-400 uppercase tracking-widest mb-2">Address Line 1 <span class="text-rose-500">*</span></label>
                                <input type="text" name="address_line1" value="{{ old('address_line1', $user->address_line1) }}" placeholder="Street address, P.O. box" class="w-full border border-stone-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all" required>
                                @error('address_line1') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-[10px] font-black text-stone-400 uppercase tracking-widest mb-2">Address Line 2</label>
                                <input type="text" name="address_line2" value="{{ old('address_line2', $user->address_line2) }}" placeholder="Apartment, suite, unit, etc." class="w-full border border-stone-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-stone-400 uppercase tracking-widest mb-2">City <span class="text-rose-500">*</span></label>
                                <input type="text" name="city" value="{{ old('city', $user->city) }}" placeholder="City" class="w-full border border-stone-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all" required>
                                @error('city') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-stone-400 uppercase tracking-widest mb-2">State / Province <span class="text-rose-500">*</span></label>
                                <input type="text" name="state" value="{{ old('state', $user->state) }}" placeholder="State / Province" class="w-full border border-stone-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all" required>
                                @error('state') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-stone-400 uppercase tracking-widest mb-2">ZIP / Postal Code <span class="text-rose-500">*</span></label>
                                <input type="text" name="zip_code" value="{{ old('zip_code', $user->zip_code) }}" placeholder="ZIP / Postal code" class="w-full border border-stone-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all" required>
                                @error('zip_code') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-stone-400 uppercase tracking-widest mb-2">Country <span class="text-rose-500">*</span></label>
                                <input type="text" name="country" value="{{ old('country', $user->country) }}" placeholder="Country" class="w-full border border-stone-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all" required>
                                @error('country') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="flex justify-end gap-3">
                            <button type="button" @click="showForm = false" class="px-5 py-2.5 text-sm font-semibold text-stone-600 border border-stone-200 rounded-lg hover:bg-stone-50 transition-colors">Cancel</button>
                            <button type="submit" class="px-6 py-2.5 bg-stone-900 hover:bg-stone-800 text-white font-bold text-sm rounded-lg transition-colors flex items-center gap-2">
                                <i class="ri-save-line"></i> Save Address
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Saved address cards --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @if($user->address_line1)
                    <div class="bg-white border-2 border-amber-400 rounded-xl p-5 relative">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <i class="ri-map-pin-line text-amber-500 text-sm"></i>
                                <span class="text-[10px] font-black text-stone-500 uppercase tracking-widest">Home</span>
                            </div>
                            <span class="bg-amber-500 text-stone-900 text-[9px] font-black px-2 py-0.5 rounded-full uppercase tracking-wider">Default</span>
                        </div>
                        <p class="text-sm font-bold text-stone-900 mb-2">{{ $user->first_name }} {{ $user->last_name }}</p>
                        <p class="text-sm text-stone-500 leading-relaxed">
                            {{ $user->address_line1 }}
                            @if($user->address_line2), {{ $user->address_line2 }}@endif<br>
                            {{ $user->city }}@if($user->state), {{ $user->state }}@endif @if($user->zip_code){{ $user->zip_code }}@endif<br>
                            {{ $user->country }}<br>
                            {{ $user->phone }}
                        </p>
                        <div class="mt-4 pt-3 border-t border-stone-100">
                            <button @click="showForm = true" class="text-sm font-semibold text-amber-600 hover:text-amber-500 transition-colors">Edit</button>
                        </div>
                    </div>
                    @endif

                    {{-- Placeholder Office Card to match screenshot --}}
                    <div class="bg-white border border-stone-200 rounded-xl p-5 relative">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <i class="ri-map-pin-line text-stone-400 text-sm"></i>
                                <span class="text-[10px] font-black text-stone-500 uppercase tracking-widest">Office</span>
                            </div>
                        </div>
                        <p class="text-sm font-bold text-stone-900 mb-2">{{ $user->first_name }} {{ $user->last_name }}</p>
                        <p class="text-sm text-stone-500 leading-relaxed">
                            450 Park Avenue, Suite 1200<br>
                            New York, NY 10022<br>
                            United States<br>
                            +1 (555) 800-4400
                        </p>
                        <div class="mt-4 pt-3 border-t border-stone-100 flex gap-4">
                            <button class="text-xs font-semibold text-stone-400 hover:text-amber-600 transition-colors">Edit</button>
                            <button class="text-xs font-semibold text-stone-400 hover:text-amber-600 transition-colors">Set as Default</button>
                            <button class="text-xs font-semibold text-rose-400 hover:text-rose-600 transition-colors">Remove</button>
                        </div>
                    </div>
                </div>

                @if(!$user->address_line1)
                <div class="bg-white rounded-xl border-2 border-dashed border-stone-200 p-12 text-center mt-6">
                    <div class="w-14 h-14 bg-stone-50 rounded-full flex items-center justify-center mx-auto mb-4 text-stone-300">
                        <i class="ri-map-pin-line text-3xl"></i>
                    </div>
                    <p class="text-stone-500 font-semibold mb-1">No primary address saved</p>
                    <p class="text-xs text-stone-400 mb-4">Update your primary address using the form above.</p>
                </div>
                @endif
            </div>

            {{-- ── Orders Tab ── --}}
            <div x-show="activeTab === 'Orders'" x-cloak>
                <div class="bg-white rounded-xl border border-stone-200 p-8">
                    <h2 class="text-lg font-bold text-stone-900 mb-1">My Orders</h2>
                    <p class="text-sm text-stone-400 mb-8">Track and manage your orders.</p>
                    @if($orders->count() > 0)
                        <div class="space-y-4">
                            @foreach($orders as $order)
                            <div class="border border-stone-200 rounded-xl p-5 hover:border-amber-200 transition-colors">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-3">
                                        <span class="text-sm font-bold text-stone-900">{{ $order->order_number }}</span>
                                        @if($order->status === 'delivered')
                                            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 text-[10px] font-black rounded-full uppercase">Delivered</span>
                                        @elseif($order->status === 'pending')
                                            <span class="px-2 py-0.5 bg-amber-50 text-amber-600 text-[10px] font-black rounded-full uppercase">Pending</span>
                                        @elseif($order->status === 'shipped')
                                            <span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 text-[10px] font-black rounded-full uppercase">Shipped</span>
                                        @elseif($order->status === 'cancelled')
                                            <span class="px-2 py-0.5 bg-rose-50 text-rose-600 text-[10px] font-black rounded-full uppercase">Cancelled</span>
                                        @else
                                            <span class="px-2 py-0.5 bg-blue-50 text-blue-600 text-[10px] font-black rounded-full uppercase">{{ ucfirst($order->status) }}</span>
                                        @endif
                                    </div>
                                    <span class="text-sm font-bold text-stone-900">${{ number_format($order->total, 2) }}</span>
                                </div>
                                <div class="flex items-center justify-between text-xs text-stone-400">
                                    <span>{{ $order->created_at->format('M d, Y') }}</span>
                                    <span>{{ $order->items->count() }} item(s)</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-stone-50 rounded-full flex items-center justify-center mx-auto mb-4 text-stone-300">
                                <i class="ri-shopping-bag-line text-3xl"></i>
                            </div>
                            <p class="text-stone-500 font-semibold mb-1">No orders yet</p>
                            <p class="text-xs text-stone-400 mb-4">Your order history will appear here.</p>
                            <a href="{{ url('/gallery') }}" class="inline-flex items-center gap-2 bg-stone-900 text-white text-sm font-bold px-6 py-2.5 rounded-lg hover:bg-stone-800 transition-colors">Start Shopping</a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ── Wishlist Tab ── --}}
            <div x-show="activeTab === 'Wishlist'" x-cloak>
                <div class="bg-white rounded-xl border border-stone-200 p-8 text-center">
                    <h2 class="text-lg font-bold text-stone-900 mb-1">Wishlist</h2>
                    <p class="text-sm text-stone-400 mb-8">Items you've saved for later.</p>
                    <div class="py-8">
                        <div class="w-16 h-16 bg-stone-50 rounded-full flex items-center justify-center mx-auto mb-4 text-stone-300">
                            <i class="ri-heart-line text-3xl"></i>
                        </div>
                        <p class="text-stone-500 font-semibold mb-1">No saved items</p>
                        <p class="text-xs text-stone-400">Tap the heart icon on any product to save it here.</p>
                    </div>
                </div>
            </div>

            {{-- ── Security Tab ── --}}
            <div x-show="activeTab === 'Security'" x-cloak>
                <div class="bg-white rounded-xl border border-stone-200 p-8 text-center">
                    <h2 class="text-lg font-bold text-stone-900 mb-1">Security</h2>
                    <p class="text-sm text-stone-400 mb-8">Manage your password and account security.</p>
                    <div class="py-8">
                        <div class="w-16 h-16 bg-stone-50 rounded-full flex items-center justify-center mx-auto mb-4 text-stone-300">
                            <i class="ri-shield-check-line text-3xl"></i>
                        </div>
                        <p class="text-stone-500 font-semibold mb-1">Coming soon</p>
                        <p class="text-xs text-stone-400">Password change & 2FA will be available here.</p>
                    </div>
                </div>
            </div>

            {{-- ── Notifications Tab ── --}}
            <div x-show="activeTab === 'Preferences'" x-cloak>
                <div class="bg-white rounded-xl border border-stone-200 p-8 text-center">
                    <h2 class="text-lg font-bold text-stone-900 mb-1">Preferences</h2>
                    <p class="text-sm text-stone-400 mb-8">Control your notification and display preferences.</p>
                    <div class="py-8">
                        <div class="w-16 h-16 bg-stone-50 rounded-full flex items-center justify-center mx-auto mb-4 text-stone-300">
                            <i class="ri-settings-3-line text-3xl"></i>
                        </div>
                        <p class="text-stone-500 font-semibold mb-1">Coming soon</p>
                        <p class="text-xs text-stone-400">Your preferences will be configurable here.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
