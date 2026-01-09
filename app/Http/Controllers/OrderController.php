<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    /**
     * Show checkout page
     */
    public function checkout()
    {
        $user = Auth::user();
        
        if (!$user || !($user instanceof Customer)) {
            return redirect()->route('home')
                ->with('open_modal', 'login')
                ->with('active_tab', 'customer')
                ->with('error', 'Please log in to checkout.');
        }

        $cartItems = Cart::where('customer_id', $user->customer_id)
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')
                ->with('error', 'Your cart is empty.');
        }

        // Calculate subtotal using quantity field
        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
        $total = $subtotal;

        return view('checkout', compact('cartItems', 'subtotal', 'total', 'user'));
    }

    /**
     * Process checkout and create order
     */
    public function processCheckout(Request $request)
    {
        $user = Auth::user();
        
        if (!$user || !($user instanceof Customer)) {
            return redirect()->route('home')
                ->with('open_modal', 'login')
                ->with('active_tab', 'customer');
        }

        $validated = $request->validate([
            'firstName' => 'required|string|max:100',
            'lastName' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postalCode' => 'required|string|max:20',
            'country' => 'required|string|max:100',
        ]);

        // Validation passed, continue with order processing

        $cartItems = Cart::where('customer_id', $user->customer_id)
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')
                ->with('error', 'Your cart is empty.');
        }

        // Validate quantities are still available
        foreach ($cartItems as $cartItem) {
            $product = $cartItem->product;
            $quantity = $cartItem->quantity;
            
            if ($product->quantity < $quantity) {
                return redirect()->route('cart')
                    ->with('error', $product->name . ' only has ' . $product->quantity . ' item(s) available.');
            }
        }

        DB::beginTransaction();

        try {
            // Update customer information (if you add address field to customers table)
            // For now, we'll just use the checkout form data

            // Calculate total using quantity field
            $total = $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

            // Create order
            $order = Order::create([
                'customer_id' => $user->customer_id,
                'total_price' => $total,
                'status' => 'pending',
                'shipping_first_name' => $request->firstName,
                'shipping_last_name' => $request->lastName,
                'shipping_phone' => $request->phone,
                'shipping_address' => $request->address,
                'shipping_city' => $request->city,
                'shipping_state' => $request->state,
                'shipping_postal_code' => $request->postalCode,
                'shipping_country' => $request->country,
            ]);

            // Create order items and reduce product quantities
            foreach ($cartItems as $cartItem) {
                $product = $cartItem->product;
                $quantity = $cartItem->quantity;
                
                OrderItem::create([
                    'order_id' => $order->order_id,
                    'product_id' => $product->product_id,
                    'seller_id' => $product->seller_id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'image' => $product->image,
                    'status' => 'pending',
                ]);

                // Reduce product quantity
                $product->quantity -= $quantity;
                $product->save();
            }

            // Clear cart
            Cart::where('customer_id', $user->customer_id)->delete();

            DB::commit();

            return redirect()->route('order.show', $order->order_id)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Order creation failed: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->route('checkout')
                ->with('error', 'Failed to process order: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show order details and invoice
     */
    public function show($id)
    {
        $user = Auth::user();
        
        if (!$user || !($user instanceof Customer)) {
            return redirect()->route('home')
                ->with('open_modal', 'login')
                ->with('active_tab', 'customer');
        }

        $order = Order::where('order_id', $id)
            ->where('customer_id', $user->customer_id)
            ->with('orderItems.product', 'orderItems.seller')
            ->firstOrFail();

        return view('order-detail', compact('order'));
    }

    /**
     * Download order invoice as PDF
     */
    public function downloadInvoice($id)
    {
        $user = Auth::user();
        
        if (!$user || !($user instanceof Customer)) {
            abort(403);
        }

        $order = Order::where('order_id', $id)
            ->where('customer_id', $user->customer_id)
            ->with('orderItems.product', 'orderItems.seller', 'customer')
            ->firstOrFail();

        $pdf = Pdf::loadView('invoice', compact('order'));
        return $pdf->download('invoice-' . $order->order_id . '.pdf');
    }

    /**
     * Show customer order history
     */
    public function customerOrders()
    {
        $user = Auth::user();
        
        if (!$user || !($user instanceof Customer)) {
            return redirect()->route('home')
                ->with('open_modal', 'login')
                ->with('active_tab', 'customer');
        }

        $allOrders = Order::where('customer_id', $user->customer_id)
            ->with('orderItems.product', 'orderItems.seller')
            ->orderBy('order_date', 'desc')
            ->get();
        
        // Separate delivered orders from active orders
        $orders = $allOrders->filter(function ($order) {
            // Check if all items in the order are delivered
            return !$order->orderItems->every(function ($item) {
                return $item->status === 'delivered';
            });
        })->values();
        
        $deliveredOrders = $allOrders->filter(function ($order) {
            // Check if all items in the order are delivered
            return $order->orderItems->every(function ($item) {
                return $item->status === 'delivered';
            });
        })->values();

        return view('customer.orders', compact('orders', 'deliveredOrders'));
    }

    /**
     * Show order history (only delivered orders)
     * Note: Since orders table doesn't have status anymore, we'll show all orders
     */
    public function history()
    {
        $user = Auth::user();
        
        if (!$user || !($user instanceof Customer)) {
            return redirect()->route('home')
                ->with('open_modal', 'login')
                ->with('active_tab', 'customer');
        }

        $orders = Order::where('customer_id', $user->customer_id)
            ->with('orderItems.product', 'orderItems.seller')
            ->orderBy('order_date', 'desc')
            ->get();

        return view('order-history', compact('orders'));
    }

    /**
     * Show seller orders (orders containing seller's products)
     */
    public function sellerOrders()
    {
        $seller = Auth::guard('seller')->user();
        
        if (!$seller || !($seller instanceof Seller)) {
            return redirect()->route('home')
                ->with('error', 'You must be logged in as a seller.');
        }

        // Get all orders that contain products from this seller
        $orders = Order::whereHas('orderItems', function ($query) use ($seller) {
            $query->where('seller_id', $seller->seller_id);
        })
        ->with(['orderItems' => function ($query) use ($seller) {
            $query->where('seller_id', $seller->seller_id)->with('product');
        }, 'customer'])
        ->orderBy('order_date', 'desc')
        ->get();

        return view('seller.orders.index', compact('orders'));
    }

    /**
     * Get order details for seller (AJAX)
     */
    public function sellerOrderDetails($id)
    {
        $seller = Auth::guard('seller')->user();
        
        if (!$seller || !($seller instanceof Seller)) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $order = Order::where('order_id', $id)
            ->whereHas('orderItems', function ($query) use ($seller) {
                $query->where('seller_id', $seller->seller_id);
            })
            ->with(['orderItems' => function ($query) use ($seller) {
                $query->where('seller_id', $seller->seller_id)->with('product');
            }, 'customer'])
            ->first();

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        $sellerItems = $order->orderItems->where('seller_id', $seller->seller_id);
        $totalProfit = $sellerItems->sum(function($item) {
            return $item->price * $item->quantity;
        });

        $html = view('seller.orders.details-modal', compact('order', 'sellerItems', 'totalProfit', 'seller'))->render();
        
        return response()->json(['success' => true, 'html' => $html]);
    }

    /**
     * Update order status
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $seller = Auth::guard('seller')->user();
        
        if (!$seller || !($seller instanceof Seller)) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'status' => 'required|in:pending,received,processing,delivered',
        ]);

        $order = Order::where('order_id', $id)
            ->whereHas('orderItems', function ($query) use ($seller) {
                $query->where('seller_id', $seller->seller_id);
            })
            ->first();

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        // Update status for all order items from this seller
        $updatedItems = \App\Models\OrderItem::where('order_id', $order->order_id)
            ->where('seller_id', $seller->seller_id)
            ->update(['status' => $request->status]);

        // Update order status only if all items are delivered
        $allItems = \App\Models\OrderItem::where('order_id', $order->order_id)->get();
        $allDelivered = $allItems->every(function ($item) {
            return $item->status === 'delivered';
        });
        
        if ($allDelivered) {
            $order->status = 'delivered';
            $order->save();
        }

        \Log::info('Order item status updated', [
            'order_id' => $order->order_id,
            'new_status' => $request->status,
            'seller_id' => $seller->seller_id,
            'items_updated' => $updatedItems
        ]);

        return response()->json([
            'success' => true, 
            'message' => 'Order status updated successfully',
            'status' => $request->status
        ]);
    }
}
