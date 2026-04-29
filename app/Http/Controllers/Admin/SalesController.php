<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user', 'items.product')->latest();

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        $orders = $query->get();

        $metrics = [
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total'),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'avg_order' => Order::where('payment_status', 'paid')->avg('total') ?? 0,
        ];

        return view('admin.sales.index', compact('orders', 'metrics'));
    }

    public function trends()
    {
        $metrics = [
            'total_revenue' => Order::sum('total'),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'avg_order' => Order::avg('total') ?? 0,
        ];

        $trendData = Order::where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, SUM(total) as revenue, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top Performing Products
        $topProducts = \App\Models\OrderItem::selectRaw('product_name, SUM(quantity) as units_sold, SUM(subtotal) as revenue')
            ->groupBy('product_name')
            ->orderByDesc('revenue')
            ->limit(5)
            ->get();

        // Revenue Split by Category (Total Volume)
        $revenueSplit = \App\Models\OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->selectRaw('categories.name as label, SUM(order_items.subtotal) as value')
            ->groupBy('categories.name')
            ->get()
            ->map(function ($item, $index) {
                $colors = ['#f59e0b', '#78716c', '#d6d3d1', '#1c1917', '#44403c'];
                $item->color = $colors[$index % count($colors)];
                return $item;
            });

        // Fallback for demonstration if no orders exist
        if ($revenueSplit->isEmpty()) {
            $revenueSplit = collect([
                (object) ['label' => 'No Data', 'value' => 1, 'color' => '#f5f5f4']
            ]);
        }

        return view('admin.sales.trends', compact('metrics', 'trendData', 'topProducts', 'revenueSplit'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'items.product');
        return response()->json($order);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order->update(['status' => $validated['status']]);

        // If delivered, mark as paid
        if ($validated['status'] === 'delivered' && $order->payment_status !== 'paid') {
            $order->update(['payment_status' => 'paid']);
        }

        // If cancelled, mark as refunded if was paid
        if ($validated['status'] === 'cancelled' && $order->payment_status === 'paid') {
            $order->update(['payment_status' => 'refunded']);
        }

        return redirect()->route('admin.sales.index')->with('success', 'Order status updated to ' . ucfirst($validated['status']) . '!');
    }

    public function destroy(Order $order)
    {
        try {
            $order->items()->delete();
            $order->delete();
            return redirect()->route('admin.sales.index')->with('success', 'Order deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.sales.index')->with('error', 'Error deleting order: ' . $e->getMessage());
        }
    }
}
