<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display the cart page
     */
    public function index()
    {
        $user = Auth::user();
        
        if (!$user || !($user instanceof Customer)) {
            return redirect()->route('home')
                ->with('open_modal', 'login')
                ->with('active_tab', 'customer')
                ->with('error', 'Please log in to view your cart.');
        }

        $cartItems = Cart::where('customer_id', $user->customer_id)
            ->with('product')
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $total = $subtotal; // No shipping for now

        return view('cart', compact('cartItems', 'subtotal', 'total'));
    }

    /**
     * Add item to cart (requires authentication)
     */
    public function add(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'login_required' => true,
                    'message' => 'Please log in to add items to cart.'
                ], 401);
            }
            
            // Store intended URL for redirect after login
            $intendedUrl = $request->headers->get('referer') ?: route('products');
            session(['url.intended' => $intendedUrl]);
            
            return redirect()->to($intendedUrl)
                ->with('open_modal', 'login')
                ->with('active_tab', 'customer')
                ->with('error', 'Please log in to add items to cart.');
        }

        $user = Auth::user();
        if (!($user instanceof Customer)) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You must be logged in as a customer.'
                ], 403);
            }
            
            return redirect()->back()
                ->with('error', 'You must be logged in as a customer.');
        }

        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check if product is available
        if ($product->quantity < $request->quantity) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient quantity available. Only ' . $product->quantity . ' item(s) in stock.'
                ], 400);
            }
            
            return redirect()->back()
                ->with('error', 'Insufficient quantity available. Only ' . $product->quantity . ' item(s) in stock.');
        }

        // Check if item already exists in cart
        $cartItem = Cart::where('customer_id', $user->customer_id)
            ->where('product_id', $product->product_id)
            ->first();

        if ($cartItem) {
            // Update quantity if item already exists
            $newQuantity = $cartItem->quantity + $request->quantity;
            
            // Check if new quantity exceeds available stock
            if ($newQuantity > $product->quantity) {
                if ($request->expectsJson() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cannot add more items. Only ' . $product->quantity . ' item(s) in stock. You already have ' . $cartItem->quantity . ' in your cart.'
                    ], 400);
                }
                
                return redirect()->back()
                    ->with('error', 'Cannot add more items. Only ' . $product->quantity . ' item(s) in stock. You already have ' . $cartItem->quantity . ' in your cart.');
            }
            
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            // Create new cart item
            Cart::create([
                'customer_id' => $user->customer_id,
                'product_id' => $product->product_id,
                'quantity' => $request->quantity,
                'image' => $product->image,
            ]);
        }

        if ($request->expectsJson() || $request->wantsJson()) {
            $cartCount = Cart::where('customer_id', $user->customer_id)->sum('quantity');
            return response()->json([
                'success' => true,
                'message' => 'Item added to cart!',
                'cart_count' => $cartCount
            ]);
        }

        return redirect()->back()->with('success', 'Item added to cart!');
    }

    /**
     * Update cart item quantity (remove old, add new)
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        if (!$user || !($user instanceof Customer)) {
            return redirect()->route('home')
                ->with('open_modal', 'login')
                ->with('active_tab', 'customer');
        }

        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->quantity < $request->quantity) {
            return redirect()->back()
                ->with('error', 'Insufficient quantity available. Only ' . $product->quantity . ' item(s) in stock.');
        }

        // Update quantity for existing cart item
        $cartItem = Cart::where('customer_id', $user->customer_id)
            ->where('product_id', $product->product_id)
            ->first();

        if ($cartItem) {
            $cartItem->update(['quantity' => $request->quantity]);
        } else {
            Cart::create([
                'customer_id' => $user->customer_id,
                'product_id' => $product->product_id,
                'quantity' => $request->quantity,
                'image' => $product->image,
            ]);
        }

        return redirect()->route('cart')->with('success', 'Cart updated!');
    }

    /**
     * Remove item from cart
     */
    public function remove(Request $request)
    {
        $user = Auth::user();
        if (!$user || !($user instanceof Customer)) {
            return redirect()->route('home')
                ->with('open_modal', 'login')
                ->with('active_tab', 'customer');
        }
        
        Cart::where('customer_id', $user->customer_id)
            ->where('product_id', $request->product_id)
            ->delete();

        return redirect()->route('cart')->with('success', 'Item removed from cart!');
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        $user = Auth::user();
        if (!$user || !($user instanceof Customer)) {
            return redirect()->route('home')
                ->with('open_modal', 'login')
                ->with('active_tab', 'customer');
        }

        Cart::where('customer_id', $user->customer_id)->delete();

        return redirect()->route('cart')->with('success', 'Cart cleared!');
    }
}
