<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        $cartItems = collect($cart)->map(function ($item, $id) {
            $product = Product::find($item['product_id']);
            if (!$product) return null;
            
            return (object)[
                'id' => $id,
                'product_id' => $item['product_id'],
                'product' => $product,
                'quantity' => $item['quantity'],
                'color' => $item['color'] ?? null,
                'size' => $item['size'] ?? null,
                'price' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity']
            ];
        })->filter();

        $subtotal = $cartItems->sum('subtotal');
        $shipping = 15.00; // Flat rate for now
        $total = $subtotal + $shipping;

        return view('checkout', compact('cartItems', 'subtotal', 'shipping', 'total'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'address_line1' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'payment_method' => 'required|string|in:credit_card,cod,bank_transfer',
        ]);

        try {
            DB::beginTransaction();

            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }
            $shipping = 15.00;
            $total = $subtotal + $shipping;

            $fullAddress = $request->address_line1 . ($request->address_line2 ? ', ' . $request->address_line2 : '') . 
                           ', ' . $request->city . ', ' . $request->state . ' ' . $request->zip_code . ', ' . $request->country;

            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => Auth::id(),
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'total' => $total,
                'shipping_address' => $fullAddress,
                'notes' => $request->notes,
            ]);

            foreach ($cart as $item) {
                $product = Product::find($item['product_id']);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $product->name,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);

                // Deduct stock
                if ($product) {
                    $product->decrement('stock', $item['quantity']);
                }
            }

            if ($request->has('save_address') && $request->save_address) {
                $user = Auth::user();
                $user->update([
                    'address_line1' => $request->address_line1,
                    'address_line2' => $request->address_line2,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip_code' => $request->zip_code,
                    'country' => $request->country,
                ]);
            }

            DB::commit();

            session()->forget('cart');

            return redirect()->route('checkout.success', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function success($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        
        // Ensure user can only see their own order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('order-confirmation', compact('order'));
    }
}
