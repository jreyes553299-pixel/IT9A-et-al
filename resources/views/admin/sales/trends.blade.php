@extends('layouts.admin')

@section('title', 'Sales Trends')
@section('page_title', 'Sales Trends')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Metric Cards with themed backgrounds matching preview -->
        <div class="bg-amber-50/50 p-6 rounded-2xl border border-amber-100 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-center justify-between mb-6">
                <div class="w-12 h-12 rounded-xl bg-stone-900 flex items-center justify-center text-amber-500 shadow-lg shadow-stone-200">
                    <i class="ri-money-dollar-box-line text-2xl"></i>
                </div>
                <div class="flex flex-col items-end">
                    <span class="text-[10px] font-black text-stone-500 uppercase tracking-widest">Revenue</span>
                    <div class="flex items-center gap-1 text-emerald-500">
                        <i class="ri-arrow-right-up-line text-sm"></i>
                        <span class="text-[10px] font-bold">+12.5%</span>
                    </div>
                </div>
            </div>
            <p class="text-3xl font-bold text-stone-900">${{ number_format($metrics['total_revenue'], 2) }}</p>
            <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest mt-1">Life-time Earnings</p>
        </div>

        <div class="bg-rose-50/30 p-6 rounded-2xl border border-rose-100 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between mb-6">
                <div class="w-12 h-12 rounded-xl bg-stone-100 flex items-center justify-center text-stone-600">
                    <i class="ri-shopping-cart-2-line text-2xl"></i>
                </div>
                <div class="flex flex-col items-end">
                    <span class="text-[10px] font-black text-stone-500 uppercase tracking-widest">Orders</span>
                    <span class="text-[10px] font-bold text-stone-400 italic">30 Day Window</span>
                </div>
            </div>
            <p class="text-3xl font-bold text-stone-900">{{ $metrics['total_orders'] }}</p>
            <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest mt-1">Total Transactions</p>
        </div>

        <div class="bg-blue-50/30 p-6 rounded-2xl border border-blue-100 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between mb-6">
                <div class="w-12 h-12 rounded-xl bg-stone-100 flex items-center justify-center text-stone-600">
                    <i class="ri-scales-3-line text-2xl"></i>
                </div>
                <div class="flex flex-col items-end">
                    <span class="text-[10px] font-black text-stone-500 uppercase tracking-widest">AOV</span>
                    <span class="text-[10px] font-bold text-stone-400 italic">Global Avg</span>
                </div>
            </div>
            <p class="text-3xl font-bold text-stone-900">${{ number_format($metrics['avg_order'], 2) }}</p>
            <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest mt-1">Average Order Value</p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-stone-300 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between mb-6">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <i class="ri-checkbox-circle-line text-2xl"></i>
                </div>
                <div class="flex flex-col items-end">
                    <span class="text-[10px] font-black text-stone-500 uppercase tracking-widest">Fulfillment</span>
                    <span class="text-[10px] font-bold text-emerald-600 px-2 py-0.5 bg-emerald-50 rounded-full uppercase tracking-tighter">Healthy</span>
                </div>
            </div>
            <p class="text-3xl font-bold text-stone-900">98.2%</p>
            <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest mt-1">Success Rate</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
        <!-- Main Chart -->
        <div class="lg:col-span-2 bg-white p-8 rounded-2xl border border-stone-300 shadow-sm">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-xl font-bold text-stone-900">Revenue Breakdown</h3>
                    <p class="text-sm text-stone-500">Monthly financial performance summary</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-amber-500 rounded-full"></span>
                        <span class="text-[10px] font-bold text-stone-500 uppercase tracking-widest">Current Period</span>
                    </div>
                </div>
            </div>
            <div class="h-[400px]">
                <canvas id="salesTrendChart"></canvas>
            </div>
        </div>

        <!-- Revenue Split (Donut) -->
        <div class="bg-white p-8 rounded-2xl border border-stone-300 shadow-sm">
            <h3 class="text-xl font-bold text-stone-900 mb-2">Revenue Split</h3>
            <p class="text-sm text-stone-500 mb-8">Distribution by product category</p>
            
            <div class="relative h-64 mb-8">
                <canvas id="revenueSplitChart"></canvas>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest">Total</p>
                    <p class="text-2xl font-black text-stone-900">${{ number_format($metrics['total_revenue'] / 1000, 1) }}k</p>
                </div>
            </div>

            <div class="space-y-4">
                @foreach($revenueSplit as $item)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-3 h-3 rounded-full" style="background-color: {{ $item->color }}"></span>
                            <span class="text-sm font-bold text-stone-600">{{ $item->label }}</span>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-black text-stone-900">${{ number_format($item->value, 0) }}</p>
                            <p class="text-[10px] font-bold text-stone-400">{{ $metrics['total_revenue'] > 0 ? round(($item->value / $metrics['total_revenue']) * 100, 1) : 0 }}%</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Top Performing Products -->
    <div class="bg-white rounded-2xl border border-stone-300 shadow-sm overflow-hidden mb-10">
        <div class="p-8 border-b border-stone-100 flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold text-stone-900">Top Performing Products</h3>
                <p class="text-sm text-stone-500">Based on total revenue generated</p>
            </div>
            <button class="px-4 py-2 bg-stone-50 text-stone-600 rounded-xl text-xs font-bold border border-stone-200 hover:bg-stone-900 hover:text-white transition-all">View All Reports</button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-stone-50/30">
                        <th class="px-8 py-5 text-[10px] font-black text-stone-400 uppercase tracking-widest">#</th>
                        <th class="px-8 py-5 text-[10px] font-black text-stone-400 uppercase tracking-widest">Product</th>
                        <th class="px-8 py-5 text-[10px] font-black text-stone-400 uppercase tracking-widest text-center">Units Sold</th>
                        <th class="px-8 py-5 text-[10px] font-black text-stone-400 uppercase tracking-widest text-right">Revenue</th>
                        <th class="px-8 py-5 text-[10px] font-black text-stone-400 uppercase tracking-widest">Performance</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @php $maxRevenue = $topProducts->max('revenue') ?: 1; @endphp
                    @foreach($topProducts as $index => $product)
                        <tr class="hover:bg-stone-50 transition-all">
                            <td class="px-8 py-5">
                                <span class="text-sm font-bold text-stone-400">{{ sprintf('%02d', $index + 1) }}</span>
                            </td>
                            <td class="px-8 py-5">
                                <span class="text-sm font-bold text-stone-900">{{ $product->product_name }}</span>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <span class="text-sm font-bold text-stone-600">{{ $product->units_sold }}</span>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <span class="text-sm font-black text-stone-900">${{ number_format($product->revenue, 2) }}</span>
                            </td>
                            <td class="px-8 py-5 w-64">
                                <div class="flex items-center gap-4">
                                    <div class="flex-1 h-2 bg-stone-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-amber-500 rounded-full" style="width: {{ ($product->revenue / $maxRevenue) * 100 }}%"></div>
                                    </div>
                                    <span class="text-[10px] font-bold text-stone-400">{{ round(($product->revenue / $maxRevenue) * 100) }}%</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    <!-- Category Trend Lines (Sparklines) -->
    <div class="bg-white p-8 rounded-2xl border border-stone-300 shadow-sm mb-10">
        <h3 class="text-xl font-bold text-stone-900 mb-2">Category Performance</h3>
        <p class="text-sm text-stone-500 mb-8">Monthly growth trends across primary categories</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
                $categories = [
                    ['name' => 'Fashion & Apparel', 'revenue' => '$158k', 'growth' => '+12%', 'color' => 'amber'],
                    ['name' => 'Electronics & Tech', 'revenue' => '$210k', 'growth' => '+8%', 'color' => 'blue'],
                    ['name' => 'Home & Living', 'revenue' => '$45k', 'growth' => '-3%', 'color' => 'rose'],
                    ['name' => 'Accessories', 'revenue' => '$92k', 'growth' => '+15%', 'color' => 'emerald'],
                ];
            @endphp

            @foreach($categories as $cat)
                <div class="p-4 rounded-xl bg-stone-50 border border-stone-200">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-[10px] font-black text-stone-400 uppercase tracking-widest">{{ $cat['name'] }}</span>
                        <span class="text-xs font-bold text-{{ $cat['color'] }}-600">{{ $cat['growth'] }}</span>
                    </div>
                    <p class="text-xl font-black text-stone-900 mb-4">{{ $cat['revenue'] }}</p>
                    <div class="flex items-end gap-1 h-8">
                        @foreach([40, 70, 50, 90, 60, 80, 100] as $h)
                            <div class="flex-1 bg-{{ $cat['color'] }}-500/20 rounded-t-sm hover:bg-{{ $cat['color'] }}-500 transition-all" style="height: {{ $h }}%"></div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Trend Chart
        const trendCtx = document.getElementById('salesTrendChart')?.getContext('2d');
        if (trendCtx) {
            const data = @json($trendData);
            new Chart(trendCtx, {
                type: 'bar', // Switched to Bar to match preview better or keep as line if preferred
                data: {
                    labels: data.map(d => new Date(d.date).toLocaleDateString('en-US', { month: 'short', day: 'numeric' })),
                    datasets: [{
                        label: 'Revenue',
                        data: data.map(d => d.revenue),
                        backgroundColor: '#f59e0b',
                        borderRadius: 6,
                        hoverBackgroundColor: '#d97706'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false }, ticks: { color: '#78716c', font: { weight: '600' } } },
                        y: { 
                            beginAtZero: true, 
                            grid: { color: '#f5f5f4', drawBorder: false },
                            ticks: { callback: v => '$' + v.toLocaleString(), color: '#78716c' }
                        }
                    }
                }
            });
        }

        // Split Chart
        const splitCtx = document.getElementById('revenueSplitChart')?.getContext('2d');
        if (splitCtx) {
            const splitData = @json($revenueSplit);
            new Chart(splitCtx, {
                type: 'doughnut',
                data: {
                    labels: splitData.map(d => d.label),
                    datasets: [{
                        data: splitData.map(d => d.value),
                        backgroundColor: splitData.map(d => d.color),
                        borderWidth: 0,
                        cutout: '80%'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } }
                }
            });
        }
    });
</script>
@endpush
