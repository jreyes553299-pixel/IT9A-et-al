<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->with(['items.product.reviews' => function($q) use ($user) {
            $q->where('user_id', $user->id);
        }])->latest()->get();
        return view('account', compact('user', 'orders'));
    }

    public function updateAddress(Request $request)
    {
        $validated = $request->validate([
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
        ]);

        Auth::user()->update($validated);

        return redirect()->route('account')->with('success', 'Address updated successfully!');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string|in:male,female,other,prefer_not_to_say',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
            $user->save();
        }

        $user->update(collect($validated)->except('avatar')->toArray());

        return redirect()->route('account', ['tab' => 'Profile'])->with('success', 'Profile updated successfully!');
    }

    public function updateSecurity(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('account', ['tab' => 'Security'])->with('success', 'Password updated successfully!');
    }

    public function storeReview(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        \App\Models\ProductReview::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $validated['product_id']
            ],
            [
                'rating' => $validated['rating'],
                'comment' => $validated['comment']
            ]
        );

        return redirect()->route('account', ['tab' => 'Orders'])->with('success', 'Thank you for your review!');
    }

    public function orderAgain(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $cart = session()->get('cart', []);
        
        foreach ($order->items as $item) {
            $product = $item->product;
            if (!$product || $product->stock < 1) continue;
            
            $cartItemId = $product->id . '_' . ($item->color ?? 'no_color') . '_' . ($item->size ?? 'no_size');
            
            $currentQuantity = isset($cart[$cartItemId]) ? $cart[$cartItemId]['quantity'] : 0;
            $newQuantity = $currentQuantity + $item->quantity;

            if ($newQuantity <= $product->stock) {
                if (isset($cart[$cartItemId])) {
                    $cart[$cartItemId]['quantity'] = $newQuantity;
                } else {
                    $cart[$cartItemId] = [
                        'product_id' => $product->id,
                        'quantity' => $item->quantity,
                        'color' => $item->color,
                        'size' => $item->size,
                        'price' => $product->price
                    ];
                }
            }
        }
        
        session()->put('cart', $cart);

        return redirect()->route('checkout')->with('success', 'Items from your previous order have been added to your cart.');
    }
}
