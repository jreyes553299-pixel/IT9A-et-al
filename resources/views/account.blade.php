@extends('layouts.app')

@section('content')
{{-- ======================== HEADER BANNER ======================== --}}
<div class="w-full bg-stone-900 pt-24 pb-6 px-6 lg:px-12 xl:px-20">
    <p class="text-amber-400 text-[10px] font-black tracking-[0.3em] uppercase mb-4">My Account</p>
    <div class="flex items-center gap-5 mb-8">
        <div class="w-16 h-16 rounded-full bg-amber-500 flex items-center justify-center text-stone-900 text-2xl font-black flex-shrink-0 overflow-hidden border-2 border-amber-400/50 shadow-lg">
            @if($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover">
            @else
                {{ strtoupper(substr($user->first_name, 0, 1)) }}
            @endif
        </div>
        <div>
            <h1 class="text-3xl font-black text-white leading-tight">{{ $user->first_name }} {{ $user->last_name }}</h1>
            <p class="text-stone-400 text-sm mt-1">{{ $user->email }} &middot; Member since {{ $user->created_at->format('F Y') }}</p>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
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
<div class="w-full px-6 lg:px-12 xl:px-20 py-10" x-data="{ activeTab: '{{ request('tab', 'Profile') }}', showForm: false }">
    <div class="flex flex-col lg:flex-row gap-10">
        <div class="flex-shrink-0" style="width: 250px;">
            <nav class="space-y-1 bg-white rounded-2xl border-2 border-stone-400 p-2.5 shadow-2xl">
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
                <div class="border-t border-stone-200 my-2"></div>
                <button @click="activeTab = 'Orders'"
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-bold transition-all border-l-4"
                    :class="activeTab === 'Orders' ? 'border-amber-500 text-amber-700 bg-amber-50' : 'border-transparent text-stone-400 hover:bg-stone-50'">
                    <i class="ri-shopping-bag-line text-lg"></i>
                    <span>My Orders</span>
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

            @if($errors->any())
            <div class="mb-6 p-4 bg-rose-50 border border-rose-100 text-rose-700 rounded-xl">
                <div class="flex items-center gap-3 mb-2">
                    <i class="ri-error-warning-line text-xl"></i>
                    <p class="text-sm font-bold">Please correct the following errors:</p>
                </div>
                <ul class="list-disc list-inside text-xs space-y-1 ml-7">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div x-show="activeTab === 'Profile'" x-cloak>
                <div class="bg-white rounded-2xl border-2 border-stone-400 shadow-2xl overflow-hidden">
                    <div class="p-8 border-b-2 border-stone-200 bg-stone-50/50">
                        <h2 class="text-lg font-bold text-stone-900 mb-1">Profile Information</h2>
                        <p class="text-sm text-stone-400">Update your personal details and how others see you.</p>
                    </div>
                    <form method="POST" action="{{ route('account.profile') }}" class="p-8" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="flex flex-col md:flex-row gap-10">
                            {{-- Avatar --}}
                            <div class="flex-shrink-0 flex flex-col items-center gap-4">
                                <div x-data="{ photoPreview: null }" class="text-center">
                                    <input type="file" name="avatar" class="hidden" x-ref="photo"
                                        @change="
                                            const file = $event.target.files[0];
                                            if (!file) return;
                                            const reader = new FileReader();
                                            reader.onload = (e) => {
                                                photoPreview = e.target.result;
                                            };
                                            reader.readAsDataURL(file);
                                        ">
                                    
                                    <div class="relative group cursor-pointer" @click="$refs.photo.click()">
                                        <div class="w-32 h-32 rounded-2xl bg-stone-100 border-2 border-stone-300 flex items-center justify-center text-stone-300 overflow-hidden shadow-sm group-hover:border-amber-400 transition-all">
                                            {{-- Existing Avatar or Preview --}}
                                            <template x-if="!photoPreview">
                                                @if($user->avatar)
                                                    <img src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover">
                                                @else
                                                    <i class="ri-user-line text-4xl"></i>
                                                @endif
                                            </template>
                                            
                                            <template x-if="photoPreview">
                                                <img :src="photoPreview" class="w-full h-full object-cover">
                                            </template>

                                            <div class="absolute inset-0 bg-stone-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-[2px]">
                                                <div class="text-white text-xs font-bold bg-stone-900/60 px-4 py-2 rounded-full border border-white/20">
                                                    Change Photo
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-[10px] font-bold text-stone-400 uppercase mt-4 tracking-widest">Profile Photo</p>
                                </div>
                            </div>

                            {{-- Fields --}}
                            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[10px] font-black text-stone-400 uppercase tracking-widest mb-2">First Name</label>
                                    <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" class="w-full border border-stone-400 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition-all" required>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-stone-400 uppercase tracking-widest mb-2">Last Name</label>
                                    <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" class="w-full border border-stone-400 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition-all" required>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-stone-400 uppercase tracking-widest mb-2">Username</label>
                                    <input type="text" name="username" value="{{ old('username', $user->username) }}" class="w-full border border-stone-400 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition-all" required>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-stone-400 uppercase tracking-widest mb-2">Email Address</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border border-stone-400 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition-all" required>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-stone-400 uppercase tracking-widest mb-2">Phone Number</label>
                                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+1 (555) 000-0000" class="w-full border border-stone-400 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-stone-400 uppercase tracking-widest mb-2">Date of Birth</label>
                                    <input type="date" name="dob" value="{{ old('dob', $user->dob) }}" class="w-full border border-stone-400 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-stone-400 uppercase tracking-widest mb-2">Gender</label>
                                    <select name="gender" class="w-full border border-stone-400 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition-all">
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                        <option value="prefer_not_to_say" {{ old('gender', $user->gender) == 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                                    </select>
                                </div>
{{-- Hidden account type as requested --}}                            </div>
                        </div>
                        <div class="mt-10 pt-6 border-t border-stone-200 flex justify-end">
                            <button type="submit" class="bg-stone-900 hover:bg-stone-800 text-white font-bold text-sm px-8 py-3 rounded-lg transition-all shadow-lg shadow-stone-900/10">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ── Address Tab ── --}}
            <div x-show="activeTab === 'Addresses'" x-cloak>
                <div class="bg-white rounded-2xl border-2 border-stone-400 shadow-2xl overflow-hidden p-8">
                    <div class="flex items-center justify-between mb-8">
                    <h2 class="text-base font-bold text-stone-900 flex items-center gap-2">
                        <i class="ri-map-pin-2-fill text-amber-500"></i> Saved Addresses
                    </h2>
                    <button @click="showForm = !showForm" class="flex items-center gap-2 bg-amber-500 hover:bg-amber-400 text-stone-900 font-bold text-sm px-5 py-2.5 rounded-lg transition-colors shadow-md shadow-amber-500/20">
                        <i class="ri-add-line text-lg"></i> Add Address
                    </button>
                </div>

                {{-- Add / Edit Address Form --}}
                <div x-show="showForm" x-cloak class="bg-white rounded-xl border-2 border-amber-300 p-6 mb-6 shadow-md">
                    <h3 class="text-sm font-bold text-stone-900 mb-5 flex items-center gap-2">
                        <i class="ri-map-pin-line text-amber-500"></i> New Address
                    </h3>
                    <form method="POST" action="{{ route('account.address') }}">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div class="md:col-span-2">
                                <label class="block text-[10px] font-black text-stone-400 uppercase tracking-widest mb-2">Address Line 1 <span class="text-rose-500">*</span></label>
                                <input type="text" name="address_line1" value="{{ old('address_line1', $user->address_line1) }}" placeholder="Street address, P.O. box" class="w-full border border-stone-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all" required>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-[10px] font-black text-stone-400 uppercase tracking-widest mb-2">Address Line 2</label>
                                <input type="text" name="address_line2" value="{{ old('address_line2', $user->address_line2) }}" placeholder="Apartment, suite, unit, etc." class="w-full border border-stone-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-stone-400 uppercase tracking-widest mb-2">City <span class="text-rose-500">*</span></label>
                                <input type="text" name="city" value="{{ old('city', $user->city) }}" placeholder="City" class="w-full border border-stone-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all" required>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-stone-400 uppercase tracking-widest mb-2">State / Province <span class="text-rose-500">*</span></label>
                                <input type="text" name="state" value="{{ old('state', $user->state) }}" placeholder="State / Province" class="w-full border border-stone-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all" required>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-stone-400 uppercase tracking-widest mb-2">ZIP / Postal Code <span class="text-rose-500">*</span></label>
                                <input type="text" name="zip_code" value="{{ old('zip_code', $user->zip_code) }}" placeholder="ZIP / Postal code" class="w-full border border-stone-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all" required>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-stone-400 uppercase tracking-widest mb-2">Country <span class="text-rose-500">*</span></label>
                                <input type="text" name="country" value="{{ old('country', $user->country) }}" placeholder="Country" class="w-full border border-stone-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all" required>
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
                    <div class="bg-white border-2 border-amber-400 rounded-xl p-5 relative shadow-md">
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
                        <div class="mt-4 pt-3 border-t border-stone-200">
                            <button @click="showForm = true" class="text-sm font-semibold text-amber-600 hover:text-amber-500 transition-colors">Edit</button>
                        </div>
                    </div>
                    @endif

                    {{-- Placeholder Office Card to match screenshot --}}
                    <div class="bg-white border-2 border-stone-300 rounded-xl p-5 relative shadow-md">
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
                        <div class="mt-4 pt-3 border-t border-stone-200 flex gap-4">
                            <button class="text-xs font-semibold text-stone-400 hover:text-amber-600 transition-colors">Edit</button>
                            <button class="text-xs font-semibold text-stone-400 hover:text-amber-600 transition-colors">Set as Default</button>
                            <button class="text-xs font-semibold text-rose-400 hover:text-rose-600 transition-colors">Remove</button>
                        </div>
                    </div>
                </div>

                @if(!$user->address_line1)
                <div class="bg-white rounded-xl border-2 border-dashed border-stone-300 p-12 text-center mt-6">
                    <div class="w-14 h-14 bg-stone-50 rounded-full flex items-center justify-center mx-auto mb-4 text-stone-300">
                        <i class="ri-map-pin-line text-3xl"></i>
                    </div>
                    <p class="text-stone-500 font-semibold mb-1">No primary address saved</p>
                    <p class="text-xs text-stone-400 mb-4">Update your primary address using the form above.</p>
                </div>
                @endif
                </div>
            </div>

            {{-- ── Orders Tab ── --}}
            <div x-show="activeTab === 'Orders'" x-cloak x-data="{ orderFilter: 'all' }">
                <div class="bg-white rounded-2xl border-2 border-stone-400 shadow-2xl overflow-hidden">
                    <div class="p-8 border-b border-stone-200">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                            <div>
                                <h2 class="text-lg font-bold text-stone-900 mb-1">My Orders</h2>
                                <p class="text-sm text-stone-400">Track and manage your recent purchases.</p>
                            </div>
                            
                            <div class="flex items-center gap-1 p-1.5 bg-stone-100 border-2 border-stone-200 rounded-2xl shadow-inner">
                                <button @click="orderFilter = 'all'" 
                                    :class="orderFilter === 'all' ? 'bg-white text-stone-900 shadow-md border-stone-200' : 'text-stone-500 hover:text-stone-700 hover:bg-white/50'"
                                    class="px-5 py-2.5 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all border border-transparent">
                                    All
                                </button>
                                <button @click="orderFilter = 'pending'" 
                                    :class="orderFilter === 'pending' ? 'bg-white text-stone-900 shadow-md border-stone-200' : 'text-stone-500 hover:text-stone-700 hover:bg-white/50'"
                                    class="px-5 py-2.5 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all border border-transparent">
                                    Processing
                                </button>
                                <button @click="orderFilter = 'shipped'" 
                                    :class="orderFilter === 'shipped' ? 'bg-white text-stone-900 shadow-md border-stone-200' : 'text-stone-500 hover:text-stone-700 hover:bg-white/50'"
                                    class="px-5 py-2.5 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all border border-transparent">
                                    Shipped
                                </button>
                                <button @click="orderFilter = 'delivered'" 
                                    :class="orderFilter === 'delivered' ? 'bg-white text-stone-900 shadow-md border-stone-200' : 'text-stone-500 hover:text-stone-700 hover:bg-white/50'"
                                    class="px-5 py-2.5 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all border border-transparent">
                                    Delivered
                                </button>
                            </div>
                        </div>
                    </div>
                    @if($orders->count() > 0)
                        <div class="p-8 space-y-4">
                            @foreach($orders as $order)
                            <div x-show="orderFilter === 'all' || orderFilter === '{{ $order->status }}'"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 translate-y-4"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="border-2 border-stone-300 rounded-2xl p-6 shadow-md hover:border-amber-400 hover:shadow-xl transition-all group bg-white">
                                    <div class="flex items-center justify-between gap-4 mb-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 rounded-xl bg-stone-900 flex items-center justify-center text-amber-500 shadow-lg shadow-stone-200 group-hover:scale-110 transition-transform">
                                                <i class="ri-shopping-bag-3-line text-2xl"></i>
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-2 mb-0.5">
                                                    <span class="text-sm font-black text-stone-900">{{ $order->order_number }}</span>
                                                    @if($order->status === 'delivered')
                                                        <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 text-[8px] font-black rounded-full border border-emerald-100 uppercase tracking-widest">Delivered</span>
                                                    @elseif($order->status === 'pending')
                                                        <span class="px-2 py-0.5 bg-amber-50 text-amber-600 text-[8px] font-black rounded-full border border-amber-100 uppercase tracking-widest">Processing</span>
                                                    @elseif($order->status === 'shipped')
                                                        <span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 text-[8px] font-black rounded-full border border-indigo-100 uppercase tracking-widest">In Transit</span>
                                                    @endif
                                                </div>
                                                <span class="text-[10px] text-stone-400 font-bold uppercase tracking-wider">{{ $order->created_at->format('M d, Y') }} • {{ $order->items->count() }} Items</span>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-lg font-black text-stone-900 block leading-tight">${{ number_format($order->total, 2) }}</span>
                                            <span class="text-[9px] text-stone-400 font-bold uppercase">Total Amount</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3 overflow-x-auto pb-4 scrollbar-hide">
                                        @foreach($order->items as $item)
                                            <div class="flex-shrink-0 group/item relative">
                                                @if($item->product)
                                                    <img src="{{ $item->product->image_url }}" class="w-16 h-16 rounded-xl border-2 border-stone-100 object-cover transition-all group-hover/item:border-amber-400 group-hover/item:scale-105" title="{{ $item->product_name }}">
                                                @else
                                                    <div class="w-16 h-16 rounded-xl bg-stone-50 border-2 border-stone-100 flex items-center justify-center text-stone-300">
                                                        <i class="ri-image-line text-xl"></i>
                                                    </div>
                                                @endif
                                                <span class="absolute -bottom-1 -right-1 bg-stone-900 text-white text-[9px] font-black px-1.5 py-0.5 rounded-full border-2 border-white">x{{ $item->quantity }}</span>
                                            </div>
                                        @endforeach
                                        @if($order->items->count() > 4)
                                            <div class="flex-shrink-0 w-16 h-16 rounded-xl bg-stone-50 border-2 border-stone-100 flex flex-col items-center justify-center text-stone-400">
                                                <span class="text-xs font-black">+{{ $order->items->count() - 4 }}</span>
                                                <span class="text-[8px] uppercase font-bold">More</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mt-4 flex items-center justify-between text-xs text-stone-400">
                                        <div class="flex items-center gap-4">
                                            <span class="flex items-center gap-1.5">
                                                <i class="ri-calendar-event-line text-amber-500"></i>
                                                Est. Delivery: <span class="text-stone-700 font-bold">{{ $order->created_at->addDays(5)->format('M d') }}</span>
                                            </span>
                                            <span class="flex items-center gap-1.5">
                                                <i class="ri-map-pin-line text-amber-500"></i>
                                                Shipping to: <span class="text-stone-700 font-bold">{{ $user->city ?? 'Manila' }}</span>
                                            </span>
                                        </div>
                                    </div>
                                <div class="mt-6 pt-6 border-t border-stone-100 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        @if($order->status === 'delivered')
                                            <span class="flex items-center gap-1.5 text-[10px] font-black text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full uppercase tracking-widest">
                                                <i class="ri-checkbox-circle-fill"></i> Delivered on {{ $order->updated_at->format('M d') }}
                                            </span>
                                        @elseif($order->status === 'shipped')
                                            <span class="flex items-center gap-1.5 text-[10px] font-black text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full uppercase tracking-widest">
                                                <i class="ri-truck-fill"></i> Arriving in 2 days
                                            </span>
                                        @else
                                            <span class="flex items-center gap-1.5 text-[10px] font-black text-amber-600 bg-amber-50 px-3 py-1 rounded-full uppercase tracking-widest">
                                                <i class="ri-time-fill"></i> Order is being prepared
                                            </span>
                                        @endif
                                    </div>
                                    @if($order->status === 'delivered')
                                    <div class="flex items-center gap-3">
                                        <form method="POST" action="{{ route('account.order-again', $order->id) }}" class="m-0 p-0">
                                            @csrf
                                            <button type="submit" class="text-xs font-bold text-white bg-stone-900 hover:bg-stone-800 px-6 py-2.5 rounded-lg shadow-lg shadow-stone-900/10 transition-all flex items-center gap-2 active:scale-95">
                                                Order Again <i class="ri-refresh-line text-sm"></i>
                                            </button>
                                        </form>
                                        @php
                                            $hasReviewedAny = $order->items->filter(fn($i) => $i->product && $i->product->reviews->count() > 0)->count() > 0;
                                        @endphp
                                        <button @click="$dispatch('open-review-modal', { items: {{ $order->items->filter(fn($i) => $i->product)->map(function($i) { $r = $i->product->reviews->first(); return ['id' => $i->product_id, 'name' => $i->product_name, 'image' => $i->product->image_url, 'rating' => $r ? $r->rating : 5, 'comment' => $r ? $r->comment : '']; })->values()->toJson() }} })" class="text-xs font-bold text-stone-900 bg-amber-400 hover:bg-amber-300 px-6 py-2.5 rounded-lg shadow-lg shadow-amber-500/20 transition-all flex items-center gap-2 active:scale-95">
                                            {{ $hasReviewedAny ? 'Edit Reviews' : 'Leave a Review' }} <i class="ri-star-fill text-sm"></i>
                                        </button>
                                    </div>
                                    @else
                                    <div class="flex items-center gap-3 opacity-50 cursor-not-allowed">
                                        <span class="text-[10px] font-bold text-stone-400 italic">Options available after delivery</span>
                                    </div>  
                                    @endif
                                </div>
                            </div>
                            @endforeach
                            
                            {{-- Filtered Empty State --}}
                            <div x-show="[...$el.parentElement.children].filter(child => child.style.display !== 'none' && child.tagName === 'DIV').length === 0" 
                                 class="py-12 text-center" x-cloak>
                                <div class="w-16 h-16 bg-stone-50 rounded-full flex items-center justify-center mx-auto mb-4 text-stone-200">
                                    <i class="ri-shopping-bag-line text-3xl"></i>
                                </div>
                                <p class="text-stone-500 font-bold">No <span x-text="orderFilter"></span> orders found</p>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-20 p-8">
                            <div class="w-20 h-20 bg-stone-50 rounded-full flex items-center justify-center mx-auto mb-6 text-stone-200">
                                <i class="ri-shopping-bag-line text-4xl"></i>
                            </div>
                            <p class="text-stone-900 font-bold mb-2">No orders yet</p>
                            <p class="text-sm text-stone-400 mb-8 max-w-xs mx-auto">Looks like you haven't made any purchases yet. Explore our collection and find something you love!</p>
                            <a href="{{ url('/gallery') }}" class="inline-flex items-center gap-2 bg-stone-900 text-white text-sm font-bold px-8 py-3 rounded-lg hover:bg-stone-800 transition-all shadow-lg shadow-stone-900/10">
                                Start Shopping
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div x-show="activeTab === 'Security'" x-cloak>
                <div class="bg-white rounded-2xl border-2 border-stone-400 shadow-2xl overflow-hidden">
                    <div class="p-8 border-b-2 border-stone-200 bg-stone-50/50">
                        <h2 class="text-lg font-bold text-stone-900 mb-1">Account Security</h2>
                        <p class="text-sm text-stone-400">Manage your password and protect your account.</p>
                    </div>
                    <div class="p-8 space-y-10">
                        {{-- Password Change --}}
                        <div class="max-w-2xl">
                            <h3 class="text-xs font-black text-stone-400 uppercase tracking-widest mb-6">Change Password</h3>
                            <form method="POST" action="{{ route('account.security') }}">
                                @csrf
                                @method('PUT')
                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-[10px] font-black text-stone-400 uppercase tracking-widest mb-2">Current Password</label>
                                        <div class="relative">
                                            <input type="password" name="current_password" class="w-full border border-stone-400 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition-all" required>
                                            <i class="ri-lock-line absolute right-4 top-1/2 -translate-y-1/2 text-stone-300"></i>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-[10px] font-black text-stone-400 uppercase tracking-widest mb-2">New Password</label>
                                            <div class="relative">
                                                <input type="password" name="new_password" class="w-full border border-stone-400 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition-all" required>
                                                <i class="ri-key-2-line absolute right-4 top-1/2 -translate-y-1/2 text-stone-300"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-black text-stone-400 uppercase tracking-widest mb-2">Confirm Password</label>
                                            <div class="relative">
                                                <input type="password" name="new_password_confirmation" class="w-full border border-stone-400 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition-all" required>
                                                <i class="ri-checkbox-circle-line absolute right-4 top-1/2 -translate-y-1/2 text-stone-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex justify-end">
                                        <button type="submit" class="bg-stone-900 hover:bg-stone-800 text-white font-bold text-sm px-8 py-3 rounded-lg transition-all shadow-lg shadow-stone-900/10">
                                            Update Password
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>


                        {{-- Login History --}}
                        <div>
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xs font-black text-stone-400 uppercase tracking-widest">Recent Activity</h3>
                                <button class="text-[10px] font-black text-amber-600 hover:text-amber-500 uppercase tracking-widest transition-colors">Sign out all devices</button>
                            </div>
                            <div class="bg-stone-50 rounded-2xl border-2 border-stone-200 overflow-hidden shadow-inner">
                                <table class="w-full text-left text-xs">
                                    <thead class="bg-stone-100 border-b-2 border-stone-200 text-stone-400 uppercase tracking-widest font-black">
                                        <tr>
                                            <th class="px-6 py-4">Device</th>
                                            <th class="px-6 py-4">Location</th>
                                            <th class="px-6 py-4">Time</th>
                                            <th class="px-6 py-4 text-right">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-stone-200">
                                        <tr>
                                            <td class="px-6 py-4 flex items-center gap-2">
                                                <i class="ri-macbook-line text-lg text-stone-900"></i>
                                                <span class="font-bold text-stone-900">Chrome on macOS</span>
                                            </td>
                                            <td class="px-6 py-4 text-stone-500">Manila, Philippines</td>
                                            <td class="px-6 py-4 text-stone-500 font-bold">Current Session</td>
                                            <td class="px-6 py-4 text-right">
                                                <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
                                                <span class="text-emerald-600 font-black uppercase tracking-wider text-[9px]">Active Now</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 flex items-center gap-2">
                                                <i class="ri-smartphone-line text-lg text-stone-400"></i>
                                                <span class="font-bold text-stone-700">iPhone 14 Pro</span>
                                            </td>
                                            <td class="px-6 py-4 text-stone-500">Manila, Philippines</td>
                                            <td class="px-6 py-4 text-stone-400">Yesterday, 10:45 PM</td>
                                            <td class="px-6 py-4 text-right">
                                                <span class="text-stone-400 font-bold uppercase tracking-wider text-[9px]">Logged Out</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>

<!-- Review Modal -->
<div x-data="{ 
        open: false, 
        items: [], 
        activeProduct: null,
        rating: 5,
        comment: ''
    }" 
    @open-review-modal.window="
        open = true; 
        items = $event.detail.items; 
        if(items.length > 0) {
            activeProduct = items[0];
            rating = activeProduct.rating;
            comment = activeProduct.comment;
        }
    "
    x-show="open" 
    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-stone-900/80 backdrop-blur-sm"
    x-cloak>
    <div @click.away="open = false" class="bg-white rounded-2xl w-full max-w-lg overflow-hidden shadow-2xl relative">
        <div class="p-6 border-b border-stone-200 flex justify-between items-center">
            <h3 class="text-lg font-bold text-stone-900">Leave a Review</h3>
            <button @click="open = false" class="text-stone-400 hover:text-stone-600"><i class="ri-close-line text-2xl"></i></button>
        </div>
        <form method="POST" action="{{ route('account.review') }}" class="p-6">
            @csrf
            <input type="hidden" name="product_id" :value="activeProduct?.id">
            
            <div class="flex items-center gap-4 mb-6">
                <img :src="activeProduct?.image" class="w-16 h-16 rounded-xl border-2 border-stone-100 object-cover">
                <div class="flex-1 min-w-0">
                    <h4 class="font-bold text-stone-900 truncate" x-text="activeProduct?.name"></h4>
                    <div class="flex items-center gap-2 mt-2 overflow-x-auto pb-2 scrollbar-hide">
                        <template x-for="item in items">
                            <button type="button" @click="activeProduct = item; rating = item.rating; comment = item.comment" 
                                class="flex-shrink-0 text-[10px] font-bold px-3 py-1.5 rounded-md border transition-colors truncate max-w-[120px]"
                                :class="activeProduct?.id === item.id ? 'bg-amber-500 text-stone-900 border-amber-500' : 'bg-white text-stone-500 border-stone-200 hover:border-amber-500'">
                                <span x-text="item.name"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-[10px] font-black text-stone-400 uppercase tracking-widest mb-2">Rating</label>
                <div class="flex items-center gap-2">
                    <template x-for="i in 5">
                        <button type="button" @click="rating = i" class="text-2xl transition-colors"
                            :class="i <= rating ? 'text-amber-400 ri-star-fill' : 'text-stone-300 ri-star-line'">
                        </button>
                    </template>
                </div>
                <input type="hidden" name="rating" :value="rating">
            </div>

            <div class="mb-6">
                <label class="block text-[10px] font-black text-stone-400 uppercase tracking-widest mb-2">Comment (Optional)</label>
                <textarea name="comment" x-model="comment" rows="3" class="w-full border border-stone-200 rounded-xl p-4 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all outline-none" placeholder="What did you think about this product?"></textarea>
            </div>

            <button type="submit" class="w-full bg-stone-900 hover:bg-stone-800 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-stone-900/10">Submit Review</button>
        </form>
    </div>
</div>
@endsection
