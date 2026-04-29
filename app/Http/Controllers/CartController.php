<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        
        // We'll hydrate the cart items with the actual Product models so we can display them easily
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
                'price' => $item['price']
            ];
        })->filter();

        return view('cart', compact('cartItems'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'color' => 'nullable|string',
            'size' => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);
        
        $cart = session()->get('cart', []);
        
        $cartItemId = $product->id . '_' . ($request->color ?? 'no_color') . '_' . ($request->size ?? 'no_size');
        
        $currentQuantity = isset($cart[$cartItemId]) ? $cart[$cartItemId]['quantity'] : 0;
        $newQuantity = $currentQuantity + $request->quantity;

        if ($newQuantity > $product->stock) {
            return back()->with('error', 'Cannot add to cart. Only ' . $product->stock . ' items available in stock.');
        }
        
        if (isset($cart[$cartItemId])) {
            $cart[$cartItemId]['quantity'] = $newQuantity;
        } else {
            $cart[$cartItemId] = [
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'color' => $request->color,
                'size' => $request->size,
                'price' => $product->price // Snapshot price at time of adding
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart')->with('success', 'Product added to cart!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'quantities' => 'required|array',
            'quantities.*' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);
        
        foreach ($request->quantities as $id => $quantity) {
            if (isset($cart[$id])) {
                $product = Product::find($cart[$id]['product_id']);
                if ($product && $quantity > $product->stock) {
                    return back()->with('error', 'Cannot update cart. Only ' . $product->stock . ' items available for ' . $product->name . '.');
                }
                $cart[$id]['quantity'] = $quantity;
            }
        }
        
        session()->put('cart', $cart);
        
        return redirect()->route('cart')->with('success', 'Cart updated successfully!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        
        return redirect()->route('cart')->with('success', 'Item removed from cart!');
    }
}
