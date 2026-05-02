<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - NEXSTYLE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.5.0/remixicon.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #fafaf9; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="text-stone-900">
    <nav class="fixed top-0 w-full bg-white/80 backdrop-blur-md border-b border-stone-300 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="/" class="text-2xl font-black tracking-tighter text-stone-900 flex items-center gap-2">
                <div class="w-8 h-8 bg-stone-900 rounded-lg flex items-center justify-center">
                    <span class="text-white text-lg">N</span>
                </div>
                NEXSTYLE
            </a>
            <div class="flex items-center gap-6">
                <a href="{{ route('cart') }}" class="text-sm font-bold text-stone-500 hover:text-stone-900 transition-colors">Back to Cart</a>
            </div>
        </div>
    </nav>

    <main class="pt-32 pb-20 px-6 max-w-7xl mx-auto">
        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Checkout Form -->
            <div class="flex-1">
                <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                    @csrf
                    
                    <div class="space-y-12">
                        <!-- Contact Information -->
                        <section>
                            <div class="flex items-center gap-4 mb-8">
                                <span class="w-8 h-8 rounded-full bg-stone-900 text-white flex items-center justify-center text-sm font-bold">1</span>
                                <h2 class="text-2xl font-bold tracking-tight">Contact Information</h2>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-stone-400 uppercase tracking-widest">Full Name</label>
                                    <input type="text" name="customer_name" value="{{ Auth::user()->name ?? old('customer_name') }}" required
                                        class="w-full bg-white border border-stone-400 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-stone-900 transition-all">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-stone-400 uppercase tracking-widest">Email Address</label>
                                    <input type="email" name="customer_email" value="{{ Auth::user()->email ?? old('customer_email') }}" required
                                        class="w-full bg-white border border-stone-400 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-stone-900 transition-all">
                                </div>
                            </div>
                        </section>

                        <!-- Shipping & Payment (Combined as requested) -->
                        <section x-data="{ paymentMethod: 'credit_card' }">
                            <div class="flex items-center gap-4 mb-8">
                                <span class="w-8 h-8 rounded-full bg-stone-900 text-white flex items-center justify-center text-sm font-bold">2</span>
                                <h2 class="text-2xl font-bold tracking-tight">Shipping & Payment</h2>
                            </div>
                            
                            <div class="bg-white rounded-3xl border-2 border-stone-300 overflow-hidden shadow-sm">
                                <!-- Shipping Address Section -->
                                <div class="p-8 border-b border-stone-200" x-data="{ editingAddress: {{ Auth::user() && Auth::user()->address_line1 ? 'false' : 'true' }} }">
                                    <div class="flex items-center justify-between mb-6">
                                        <h3 class="text-sm font-bold text-stone-900 flex items-center gap-2">
                                            <i class="ri-truck-line"></i>
                                            Shipping Address
                                        </h3>
                                        @if(Auth::user() && Auth::user()->address_line1)
                                            <button type="button" @click="editingAddress = !editingAddress" 
                                                class="text-[10px] font-black text-amber-600 uppercase tracking-widest hover:text-amber-700 transition-colors"
                                                x-text="editingAddress ? 'Cancel' : 'Change Address'">
                                                Change Address
                                            </button>
                                        @endif
                                    </div>

                                    @if(Auth::user() && Auth::user()->address_line1)
                                        <!-- Saved Address Display -->
                                        <div x-show="!editingAddress" class="p-5 bg-stone-50 rounded-2xl border-2 border-stone-300">
                                            <div class="flex items-start gap-4">
                                                <div class="w-10 h-10 rounded-xl bg-white border-2 border-stone-300 flex items-center justify-center text-stone-400">
                                                    <i class="ri-map-pin-2-line text-lg"></i>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-bold text-stone-900">{{ Auth::user()->address_line1 }}</p>
                                                    @if(Auth::user()->address_line2)
                                                        <p class="text-sm text-stone-600">{{ Auth::user()->address_line2 }}</p>
                                                    @endif
                                                    <p class="text-sm text-stone-600">{{ Auth::user()->city }}, {{ Auth::user()->state }} {{ Auth::user()->zip_code }}</p>
                                                    <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest mt-2">{{ Auth::user()->country }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <!-- No Address Prompt -->
                                        <div x-show="!editingAddress" class="p-8 text-center bg-stone-50 rounded-3xl border border-dashed border-stone-300">
                                            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 text-stone-300 shadow-sm">
                                                <i class="ri-map-pin-add-line text-2xl"></i>
                                            </div>
                                            <p class="text-sm font-bold text-stone-900 mb-1">No shipping address found</p>
                                            <p class="text-xs text-stone-500 mb-6">Please provide your delivery details to proceed.</p>
                                            <button type="button" @click="editingAddress = true" class="px-6 py-2.5 bg-stone-900 text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-stone-800 transition-all shadow-lg shadow-stone-200">
                                                Add New Address
                                            </button>
                                        </div>
                                    @endif

                                    <!-- Address Form -->
                                    <div x-show="editingAddress" x-transition class="space-y-6 mt-6">
                                        <div class="space-y-2">
                                            <label class="text-[10px] font-black text-stone-400 uppercase tracking-widest">Street Address</label>
                                            <input type="text" name="address_line1" value="{{ Auth::user()->address_line1 ?? old('address_line1') }}" required
                                                class="w-full bg-stone-50/50 border border-stone-400 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-stone-900 transition-all">
                                        </div>
                                        <div class="grid grid-cols-2 gap-6">
                                            <div class="space-y-2">
                                                <label class="text-[10px] font-black text-stone-400 uppercase tracking-widest">City</label>
                                                <input type="text" name="city" value="{{ Auth::user()->city ?? old('city') }}" required
                                                    class="w-full bg-stone-50/50 border border-stone-400 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-stone-900 transition-all">
                                            </div>
                                            <div class="space-y-2">
                                                <label class="text-[10px] font-black text-stone-400 uppercase tracking-widest">State / Province</label>
                                                <input type="text" name="state" value="{{ Auth::user()->state ?? old('state') }}" required
                                                    class="w-full bg-stone-50/50 border border-stone-400 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-stone-900 transition-all">
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-2 gap-6">
                                            <div class="space-y-2">
                                                <label class="text-[10px] font-black text-stone-400 uppercase tracking-widest">Zip / Postal Code</label>
                                                <input type="text" name="zip_code" value="{{ Auth::user()->zip_code ?? old('zip_code') }}" required
                                                    class="w-full bg-stone-50/50 border border-stone-400 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-stone-900 transition-all">
                                            </div>
                                            <div class="space-y-2">
                                                <label class="text-[10px] font-black text-stone-400 uppercase tracking-widest">Country</label>
                                                <select name="country" class="w-full bg-stone-50/50 border border-stone-400 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-stone-900 transition-all">
                                                    <option value="United States" {{ (Auth::user() && Auth::user()->country == 'United States') ? 'selected' : '' }}>United States</option>
                                                    <option value="Canada" {{ (Auth::user() && Auth::user()->country == 'Canada') ? 'selected' : '' }}>Canada</option>
                                                    <option value="United Kingdom" {{ (Auth::user() && Auth::user()->country == 'United Kingdom') ? 'selected' : '' }}>United Kingdom</option>
                                                    <option value="Australia" {{ (Auth::user() && Auth::user()->country == 'Australia') ? 'selected' : '' }}>Australia</option>
                                                    <option value="Philippines" {{ (Auth::user() && Auth::user()->country == 'Philippines') ? 'selected' : '' }}>Philippines</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-3 pt-2">
                                            <input type="checkbox" name="save_address" value="1" id="save_address" class="w-4 h-4 rounded border-stone-300 text-stone-900 focus:ring-stone-900">
                                            <label for="save_address" class="text-xs font-medium text-stone-600 cursor-pointer">Save this as my default shipping address</label>
                                        </div>
                                    </div>
                                    
                                    <!-- Billing Toggle -->
                                    <div class="mt-8 pt-8 border-t border-stone-200" x-data="{ billingSame: true }">
                                        <div class="flex items-center justify-between mb-4">
                                            <h3 class="text-sm font-bold text-stone-900 flex items-center gap-2">
                                                <i class="ri-bill-line"></i>
                                                Billing Information
                                            </h3>
                                            <button type="button" @click="billingSame = !billingSame" 
                                                class="text-[10px] font-black text-amber-600 uppercase tracking-widest hover:text-amber-700"
                                                x-text="billingSame ? 'Different Billing Address' : 'Same as Shipping'">
                                            </button>
                                        </div>
                                        <div x-show="billingSame" class="p-4 bg-emerald-50/50 border-2 border-emerald-200 rounded-xl flex items-center gap-3">
                                            <i class="ri-checkbox-circle-line text-emerald-600"></i>
                                            <p class="text-xs font-medium text-emerald-700">Billing address is the same as your shipping address.</p>
                                        </div>
                                        <div x-show="!billingSame" x-transition class="space-y-4 mt-4">
                                            <input type="text" placeholder="Billing Street Address" class="w-full bg-stone-50/50 border border-stone-400 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-stone-900 transition-all">
                                        </div>
                                    </div>
                                </div>

                                <!-- Payment Method Section -->
                                <div class="p-8 bg-stone-50/30">
                                    <h3 class="text-sm font-bold text-stone-900 mb-6 flex items-center gap-2">
                                        <i class="ri-secure-payment-line"></i>
                                        Payment Method
                                    </h3>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                                        <label class="relative flex flex-col p-4 bg-white border rounded-2xl cursor-pointer transition-all hover:border-stone-900"
                                            :class="paymentMethod === 'credit_card' ? 'border-stone-900 ring-1 ring-stone-900 shadow-md' : 'border-stone-400 border-2'">
                                            <input type="radio" name="payment_method" value="credit_card" x-model="paymentMethod" class="sr-only">
                                            <i class="ri-bank-card-line text-xl mb-2" :class="paymentMethod === 'credit_card' ? 'text-stone-900' : 'text-stone-400'"></i>
                                            <span class="text-xs font-bold text-stone-900">Credit Card</span>
                                            <span class="text-[9px] text-stone-400 uppercase tracking-tight">Visa, Master, Amex</span>
                                        </label>
                                        
                                        <label class="relative flex flex-col p-4 bg-white border rounded-2xl cursor-pointer transition-all hover:border-stone-900"
                                            :class="paymentMethod === 'cod' ? 'border-stone-900 ring-1 ring-stone-900 shadow-md' : 'border-stone-400 border-2'">
                                            <input type="radio" name="payment_method" value="cod" x-model="paymentMethod" class="sr-only">
                                            <i class="ri-hand-coin-line text-xl mb-2" :class="paymentMethod === 'cod' ? 'text-stone-900' : 'text-stone-400'"></i>
                                            <span class="text-xs font-bold text-stone-900">Cash on Delivery</span>
                                            <span class="text-[9px] text-stone-400 uppercase tracking-tight">Pay at your door</span>
                                        </label>

                                        <label class="relative flex flex-col p-4 bg-white border rounded-2xl cursor-pointer transition-all hover:border-stone-900"
                                            :class="paymentMethod === 'bank_transfer' ? 'border-stone-900 ring-1 ring-stone-900 shadow-md' : 'border-stone-400 border-2'">
                                            <input type="radio" name="payment_method" value="bank_transfer" x-model="paymentMethod" class="sr-only">
                                            <i class="ri-bank-line text-xl mb-2" :class="paymentMethod === 'bank_transfer' ? 'text-stone-900' : 'text-stone-400'"></i>
                                            <span class="text-xs font-bold text-stone-900">Bank Transfer</span>
                                            <span class="text-[9px] text-stone-400 uppercase tracking-tight">Direct Wire</span>
                                        </label>
                                    </div>

                                    <!-- Credit Card Details (Conditional) -->
                                    <div x-show="paymentMethod === 'credit_card'" x-transition class="space-y-4">
                                        <div class="space-y-2">
                                            <label class="text-[10px] font-black text-stone-400 uppercase tracking-widest">Card Number</label>
                                            <div class="relative">
                                                <input type="text" placeholder="0000 0000 0000 0000" class="w-full bg-white border border-stone-400 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-stone-900 transition-all">
                                                <i class="ri-visa-line absolute right-4 top-1/2 -translate-y-1/2 text-2xl text-stone-300"></i>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="space-y-2">
                                                <label class="text-[10px] font-black text-stone-400 uppercase tracking-widest">Expiry Date</label>
                                                <input type="text" placeholder="MM / YY" class="w-full bg-white border border-stone-400 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-stone-900 transition-all">
                                            </div>
                                            <div class="space-y-2">
                                                <label class="text-[10px] font-black text-stone-400 uppercase tracking-widest">CVC / CVV</label>
                                                <input type="text" placeholder="123" class="w-full bg-white border border-stone-400 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-stone-900 transition-all">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div x-show="paymentMethod === 'cod'" x-transition class="p-6 bg-stone-100 rounded-2xl text-center border-2 border-stone-300">
                                        <p class="text-sm text-stone-600 mb-2">You will pay for your order in cash when it is delivered to your address.</p>
                                        <div class="flex items-center justify-center gap-3 text-stone-400 mt-4">
                                            <i class="ri-truck-line text-2xl"></i>
                                            <i class="ri-arrow-right-line"></i>
                                            <i class="ri-money-dollar-circle-line text-2xl"></i>
                                        </div>
                                    </div>
                                    
                                    <div x-show="paymentMethod === 'bank_transfer'" x-transition class="p-6 bg-stone-100 rounded-2xl">
                                        <p class="text-sm font-bold text-stone-900 mb-2">Bank Details:</p>
                                        <p class="text-xs text-stone-600">Account Name: NEXSTYLE VENTURES</p>
                                        <p class="text-xs text-stone-600">Account Number: 1234-5678-9012</p>
                                        <p class="text-xs text-stone-600 italic mt-2">* Please use order number as reference.</p>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section>
                            <div class="flex items-center gap-4 mb-8">
                                <span class="w-8 h-8 rounded-full bg-stone-900 text-white flex items-center justify-center text-sm font-bold">3</span>
                                <h2 class="text-2xl font-bold tracking-tight">Additional Notes</h2>
                            </div>
                            <textarea name="notes" placeholder="Delivery instructions, gift messages, etc."
                                class="w-full bg-white border border-stone-400 rounded-2xl px-6 py-4 text-sm focus:outline-none focus:border-stone-900 transition-all h-32"></textarea>
                        </section>
                    </div>
                </form>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="lg:w-[400px]">
                <div class="bg-white rounded-3xl border-2 border-stone-300 p-8 sticky top-32 shadow-xl shadow-stone-200/50">
                    <h3 class="text-xl font-bold tracking-tight mb-8">Order Summary</h3>
                    
                    <div class="space-y-6 mb-8 max-h-[400px] overflow-y-auto pr-2 scrollbar-hide">
                        @foreach($cartItems as $item)
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-20 bg-stone-100 rounded-xl overflow-hidden flex-shrink-0">
                                    <img src="{{ $item->product->image_url }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-stone-900">{{ $item->product->name }}</p>
                                    <p class="text-[10px] text-stone-400 font-bold uppercase tracking-widest">{{ $item->color }} / {{ $item->size }}</p>
                                    <p class="text-xs text-stone-500 mt-1">Qty: {{ $item->quantity }}</p>
                                </div>
                                <p class="text-sm font-bold text-stone-900">${{ number_format($item->subtotal, 2) }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="space-y-4 border-t-2 border-stone-200 pt-6 mb-8">
                        <div class="flex justify-between">
                            <span class="text-sm text-stone-500 font-medium">Subtotal</span>
                            <span class="text-sm font-bold text-stone-900">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-stone-500 font-medium">Shipping</span>
                            <span class="text-sm font-bold text-stone-900">${{ number_format($shipping, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center border-t border-stone-200 pt-4 mt-4">
                            <span class="text-base font-black text-stone-900">Total</span>
                            <span class="text-2xl font-black text-stone-900">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <button type="submit" form="checkout-form" class="w-full bg-stone-900 text-white py-5 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-stone-800 transition-all shadow-xl shadow-stone-200">
                        Complete Purchase
                    </button>
                    
                    <div class="mt-6 flex items-center justify-center gap-2 text-stone-400">
                        <i class="ri-shield-check-line"></i>
                        <span class="text-[10px] font-bold uppercase tracking-widest">Secure Checkout</span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="fixed bottom-10 left-1/2 -translate-x-1/2 bg-rose-600 text-white px-6 py-4 rounded-2xl shadow-2xl z-[100] flex items-center gap-4">
            <i class="ri-error-warning-fill text-xl"></i>
            <span class="text-sm font-bold">{{ session('error') }}</span>
        </div>
    @endif
</body>
</html>
