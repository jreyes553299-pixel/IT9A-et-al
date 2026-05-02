<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed - NEXSTYLE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.5.0/remixicon.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .amber-icon { color: #f59e0b; }
        .tech-box { background-color: #f0f9ff; border: 1px solid #e0f2fe; color: #0369a1; }
        .status-badge { background-color: #f3f4f6; color: #4b5563; }
        .btn-black { background-color: #1a1a1a; color: #ffffff; }
        .btn-white { background-color: #ffffff; border: 1px solid #e5e7eb; color: #1a1a1a; }
        .tracking-bar { height: 4px; background-color: #e5e7eb; border-radius: 2px; overflow: hidden; }
        .tracking-progress { height: 100%; background-color: #f59e0b; width: 65%; }
    </style>
</head>
<body class="text-gray-900 pb-20">
    <div class="max-w-4xl mx-auto px-6 pt-12">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <div class="w-10 h-10 bg-emerald-500 rounded-full flex items-center justify-center mx-auto mb-6 text-white shadow-lg shadow-emerald-100">
                <i class="ri-check-line text-2xl"></i>
            </div>
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 mb-4">Order Confirmed!</h1>
            <p class="text-gray-500 text-sm mb-1">Thank you for your purchase. Your order has been received and is being processed.</p>
            <p class="text-gray-400 text-xs">A confirmation email has been sent to <span class="text-gray-900 font-semibold">{{ $order->customer_email }}</span></p>
        </div>

        <!-- Metadata Row -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-8 grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="flex flex-col">
                <div class="flex items-center gap-2 mb-1">
                    <i class="ri-hashtag amber-icon text-sm"></i>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Order ID</span>
                </div>
                <p class="text-sm font-bold text-gray-900">{{ $order->order_number }}</p>
            </div>
            <div class="flex flex-col">
                <div class="flex items-center gap-2 mb-1">
                    <i class="ri-calendar-line amber-icon text-sm"></i>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Order Date</span>
                </div>
                <p class="text-sm font-bold text-gray-900">{{ $order->created_at->format('F d, Y') }}</p>
            </div>
            <div class="flex flex-col">
                <div class="flex items-center gap-2 mb-1">
                    <i class="ri-bank-card-line amber-icon text-sm"></i>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Payment</span>
                </div>
                <p class="text-sm font-bold text-gray-900">{{ ucwords(str_replace('_', ' ', $order->payment_method ?? 'Visa')) }} ****4242</p>
            </div>
            <div class="flex flex-col">
                <div class="flex items-center gap-2 mb-1">
                    <i class="ri-truck-line amber-icon text-sm"></i>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Shipping</span>
                </div>
                <p class="text-sm font-bold text-gray-900">Standard (5-7 days)</p>
            </div>
        </div>

        <!-- Order Items Section -->
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 mb-8">
            <h2 class="text-lg font-extrabold text-gray-900 mb-8">Order Items</h2>
            
            <div class="space-y-8">
                @foreach($order->items as $item)
                    <div class="flex gap-6 pb-8 border-b border-gray-50 last:border-0 last:pb-0">
                        <div class="w-20 h-24 bg-gray-50 rounded-xl overflow-hidden flex-shrink-0">
                            <img src="{{ $item->product->image_url }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <span class="text-[10px] font-black text-amber-500 uppercase tracking-widest">{{ $item->product->brand ?? 'NEXSTYLE' }}</span>
                                    <h3 class="text-base font-bold text-gray-900 mt-0.5">{{ $item->product_name }}</h3>
                                    <div class="flex gap-2 mt-2">
                                        <span class="px-2 py-0.5 status-badge rounded text-[10px] font-bold">Size: M</span>
                                        <span class="px-2 py-0.5 status-badge rounded text-[10px] font-bold">Obsidian Black</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-black text-gray-900">${{ number_format($item->price, 2) }}</p>
                                    <p class="text-[10px] text-gray-400 font-bold mt-1">Qty: {{ $item->quantity }}</p>
                                </div>
                            </div>

                            @if($loop->index == 1) {{-- Simulated Tech Item Details --}}
                                <div class="mt-4 p-4 tech-box rounded-xl flex items-start gap-3">
                                    <i class="ri-shield-check-line text-lg"></i>
                                    <div>
                                        <p class="text-[10px] font-black uppercase tracking-widest mb-1">Tech Item — Serial & Warranty Details</p>
                                        <p class="text-[11px] font-medium opacity-80">Serial No: <span class="font-bold">AX-551-2026-00289</span></p>
                                        <p class="text-[11px] font-medium opacity-80">Warranty: <span class="font-bold">24 months</span> — Expires April 4, 2028</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Totals -->
            <div class="mt-10 pt-8 border-t border-gray-100 space-y-3 max-w-xs ml-auto">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Subtotal</span>
                    <span class="font-bold text-gray-900">${{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Tax (8%)</span>
                    <span class="font-bold text-gray-900">${{ number_format($order->subtotal * 0.08, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Shipping</span>
                    <span class="font-black text-emerald-500">FREE</span>
                </div>
                <div class="flex justify-between items-center pt-4 border-t border-gray-100 mt-4">
                    <span class="text-base font-extrabold text-gray-900">Total Charged</span>
                    <span class="text-2xl font-black text-gray-900">${{ number_format($order->total + ($order->subtotal * 0.08), 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Bottom Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <!-- Shipping Address -->
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
                <h3 class="text-xs font-black text-amber-500 uppercase tracking-[0.2em] flex items-center gap-2 mb-6">
                    <i class="ri-map-pin-2-line"></i>
                    Shipping Address
                </h3>
                <div class="space-y-1 text-sm text-gray-500 leading-relaxed">
                    <p class="font-bold text-gray-900">{{ $order->customer_name }}</p>
                    <p>{{ explode(',', $order->shipping_address)[0] ?? '123 Fashion Avenue' }}</p>
                    <p>{{ explode(',', $order->shipping_address)[1] ?? 'New York, NY 10001' }}</p>
                    <p>{{ explode(',', $order->shipping_address)[2] ?? 'United States' }}</p>
                </div>
            </div>

            <!-- Tracking -->
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
                <h3 class="text-xs font-black text-amber-500 uppercase tracking-[0.2em] flex items-center gap-2 mb-6">
                    <i class="ri-gift-line"></i>
                    Tracking
                </h3>
                <p class="text-xs text-gray-500 mb-1">Estimated delivery: <span class="text-gray-900 font-bold">April 9–11, 2026</span></p>
                <p class="text-[10px] text-gray-400 mb-6 italic">Tracking number will be emailed once your order ships.</p>
                
                <div class="flex justify-between items-center mb-2">
                    <div class="tracking-bar flex-1 mr-4">
                        <div class="tracking-progress"></div>
                    </div>
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Processing</span>
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex flex-col md:flex-row items-center justify-center gap-4">
            <button onclick="window.print()" class="w-full md:w-auto px-8 py-4 btn-black rounded-xl font-black text-xs uppercase tracking-widest flex items-center justify-center gap-3 hover:opacity-90 transition-all">
                <i class="ri-download-line text-lg"></i>
                Download PDF Receipt
            </button>
            <a href="/" class="w-full md:w-auto px-8 py-4 btn-white rounded-xl font-black text-xs uppercase tracking-widest flex items-center justify-center gap-3 hover:bg-gray-50 transition-all">
                <i class="ri-home-4-line text-lg"></i>
                Back to Home
            </a>
            <a href="{{ url('/gallery') }}" class="text-xs font-black text-amber-500 uppercase tracking-widest flex items-center gap-1 hover:text-amber-600 ml-4">
                Continue Shopping
                <i class="ri-arrow-right-line"></i>
            </a>
        </div>
    </div>
</body>
</html>
