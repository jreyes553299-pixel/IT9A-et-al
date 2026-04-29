<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Supplier;
use App\Models\Product;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $orders = PurchaseOrder::with('supplier', 'items.product')->latest()->get();
        $metrics = [
            'total' => PurchaseOrder::count(),
            'pending' => PurchaseOrder::where('status', 'pending')->count(),
            'received' => PurchaseOrder::where('status', 'received')->count(),
            'total_spent' => PurchaseOrder::where('status', 'received')->sum('total_amount'),
        ];
        return view('admin.purchase-orders.index', compact('orders', 'metrics'));
    }

    public function create()
    {
        $suppliers = Supplier::where('is_active', true)->get();
        $products = Product::all();
        $poNumber = PurchaseOrder::generatePoNumber();
        return view('admin.purchase-orders.create', compact('suppliers', 'products', 'poNumber'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'order_date' => 'required|date',
            'expected_delivery' => 'nullable|date|after_or_equal:order_date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_cost' => 'required|numeric|min:0',
        ]);

        $totalAmount = 0;
        foreach ($validated['items'] as $item) {
            $totalAmount += $item['quantity'] * $item['unit_cost'];
        }

        $po = PurchaseOrder::create([
            'po_number' => PurchaseOrder::generatePoNumber(),
            'supplier_id' => $validated['supplier_id'],
            'order_date' => $validated['order_date'],
            'expected_delivery' => $validated['expected_delivery'] ?? null,
            'status' => 'pending',
            'total_amount' => $totalAmount,
            'notes' => $validated['notes'] ?? null,
        ]);

        foreach ($validated['items'] as $item) {
            PurchaseOrderItem::create([
                'purchase_order_id' => $po->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_cost' => $item['unit_cost'],
                'subtotal' => $item['quantity'] * $item['unit_cost'],
            ]);
        }

        return redirect()->route('admin.purchase-orders.index')->with('success', 'Purchase Order ' . $po->po_number . ' created successfully!');
    }

    public function show(PurchaseOrder $purchase_order)
    {
        $purchase_order->load('supplier', 'items.product');
        return response()->json($purchase_order);
    }

    public function updateStatus(Request $request, PurchaseOrder $purchase_order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,received,cancelled',
        ]);

        $purchase_order->update([
            'status' => $validated['status'],
            'received_date' => $validated['status'] === 'received' ? now() : $purchase_order->received_date,
        ]);

        // If received, update the stock of products and supplier's total spent
        if ($validated['status'] === 'received') {
            foreach ($purchase_order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }
            $purchase_order->supplier->increment('total_spent', $purchase_order->total_amount);
        }

        return redirect()->route('admin.purchase-orders.index')->with('success', 'Purchase Order status updated to ' . ucfirst($validated['status']) . '!');
    }

    public function destroy(PurchaseOrder $purchase_order)
    {
        try {
            // Manually delete items first to avoid foreign key constraint errors 
            // in case the database doesn't have onDelete('cascade') set up properly
            $purchase_order->items()->delete();
            
            $purchase_order->delete();
            return redirect()->route('admin.purchase-orders.index')->with('success', 'Purchase Order deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.purchase-orders.index')->with('error', 'Error deleting Purchase Order: ' . $e->getMessage());
        }
    }
}
