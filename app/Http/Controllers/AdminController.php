<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Seller;
use App\Models\TerminatedEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        $admin = Auth::guard('seller')->user();
        
        if (!$admin || !$admin->isAdmin()) {
            return redirect()->route('admin.login')
                ->withErrors(['error' => 'You must be logged in as an admin.']);
        }

        $stats = [
            'total_products' => Product::count(),
            'total_customers' => Customer::count(),
            'total_sellers' => Seller::where('is_admin', false)->count(),
            'terminated_users' => TerminatedEmail::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Show all products for admin
     */
    public function products()
    {
        $admin = Auth::guard('seller')->user();
        
        if (!$admin || !$admin->isAdmin()) {
            return redirect()->route('admin.login')
                ->withErrors(['error' => 'You must be logged in as an admin.']);
        }

        $products = Product::with('seller')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.products.index', compact('products'));
    }

    /**
     * Delete a product
     */
    public function deleteProduct($id)
    {
        $admin = Auth::guard('seller')->user();
        
        if (!$admin || !$admin->isAdmin()) {
            return redirect()->route('admin.login')
                ->withErrors(['error' => 'You must be logged in as an admin.']);
        }

        $product = Product::find($id);
        
        if (!$product) {
            return redirect()->route('admin.products')
                ->withErrors(['error' => 'Product not found.']);
        }

        // Delete product image if exists
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        // Delete the product
        $product->delete();

        return redirect()->route('admin.products')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Show all users (customers and sellers)
     */
    public function users()
    {
        $admin = Auth::guard('seller')->user();
        
        if (!$admin || !$admin->isAdmin()) {
            return redirect()->route('admin.login')
                ->withErrors(['error' => 'You must be logged in as an admin.']);
        }

        $customers = Customer::orderBy('customer_id', 'desc')->get();
        $sellers = Seller::where('is_admin', false)
            ->orderBy('seller_id', 'desc')
            ->get();
        $terminatedEmails = TerminatedEmail::orderBy('terminated_at', 'desc')->get();

        return view('admin.users.index', compact('customers', 'sellers', 'terminatedEmails'));
    }

    /**
     * Remove/terminate a customer
     */
    public function removeCustomer($id)
    {
        $admin = Auth::guard('seller')->user();
        
        if (!$admin || !$admin->isAdmin()) {
            return redirect()->route('admin.login')
                ->withErrors(['error' => 'You must be logged in as an admin.']);
        }

        $customer = Customer::find($id);
        
        if (!$customer) {
            return redirect()->route('admin.users')
                ->withErrors(['error' => 'Customer not found.']);
        }

        DB::beginTransaction();
        try {
            // Add email to terminated emails table
            TerminatedEmail::updateOrCreate(
                ['email' => $customer->email],
                [
                    'reason' => 'Account terminated by admin',
                    'terminated_at' => now(),
                ]
            );

            // Delete customer's cart items
            DB::table('cart')->where('customer_id', $customer->customer_id)->delete();

            // Delete customer's orders and order items
            $orderIds = DB::table('orders')
                ->where('customer_id', $customer->customer_id)
                ->pluck('order_id');
            
            if ($orderIds->isNotEmpty()) {
                DB::table('order_items')->whereIn('order_id', $orderIds)->delete();
                DB::table('orders')->whereIn('order_id', $orderIds)->delete();
            }

            // Delete the customer
            $customer->delete();

            DB::commit();

            return redirect()->route('admin.users')
                ->with('success', 'Customer removed successfully. Their email has been terminated.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.users')
                ->withErrors(['error' => 'Failed to remove customer: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove/terminate a seller
     */
    public function removeSeller($id)
    {
        $admin = Auth::guard('seller')->user();
        
        if (!$admin || !$admin->isAdmin()) {
            return redirect()->route('admin.login')
                ->withErrors(['error' => 'You must be logged in as an admin.']);
        }

        $seller = Seller::find($id);
        
        if (!$seller) {
            return redirect()->route('admin.users')
                ->withErrors(['error' => 'Seller not found.']);
        }

        // Prevent admin from deleting themselves
        if ($seller->is_admin) {
            return redirect()->route('admin.users')
                ->withErrors(['error' => 'Cannot remove admin account.']);
        }

        DB::beginTransaction();
        try {
            // Add email to terminated emails table
            TerminatedEmail::updateOrCreate(
                ['email' => $seller->email],
                [
                    'reason' => 'Account terminated by admin',
                    'terminated_at' => now(),
                ]
            );

            // Get all products from this seller
            $products = Product::where('seller_id', $seller->seller_id)->get();

            // Delete product images and products
            foreach ($products as $product) {
                if ($product->image && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }
            }

            // Delete all products from this seller
            Product::where('seller_id', $seller->seller_id)->delete();

            // Delete seller's order items (orders remain but items are removed)
            $orderItemIds = DB::table('order_items')
                ->where('seller_id', $seller->seller_id)
                ->pluck('order_item_id');
            
            if ($orderItemIds->isNotEmpty()) {
                DB::table('order_items')->whereIn('order_item_id', $orderItemIds)->delete();
            }

            // Delete the seller
            $seller->delete();

            DB::commit();

            return redirect()->route('admin.users')
                ->with('success', 'Seller removed successfully. All their products have been deleted and their email has been terminated.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.users')
                ->withErrors(['error' => 'Failed to remove seller: ' . $e->getMessage()]);
        }
    }
}

