<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

// =============================
// Public Site - Home & Pages
// =============================

Route::get('/', function () {
    $productController = new \App\Http\Controllers\ProductController();
    $bestSellers = $productController->getBestSellers(4);
    $newProducts = $productController->getNewProducts(4);
    
    return view('home', compact('bestSellers', 'newProducts'));
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

// Products page now uses Livewire component for filtering
Route::get('/products', function () {
    return view('products');
})->name('products');

Route::get('/product/{id}', [\App\Http\Controllers\ProductController::class, 'show'])->name('product.detail');

// Brand pages
Route::get('/brands/chanel', function() {
    return app(\App\Http\Controllers\ProductController::class)->byBrand('chanel');
})->name('brands.chanel');

Route::get('/brands/hermes', function() {
    return app(\App\Http\Controllers\ProductController::class)->byBrand('hermes');
})->name('brands.hermes');

Route::get('/brands/ysl', function() {
    return app(\App\Http\Controllers\ProductController::class)->byBrand('ysl');
})->name('brands.ysl');

Route::get('/brands/coach', function() {
    return app(\App\Http\Controllers\ProductController::class)->byBrand('coach');
})->name('brands.coach');


// Cart & Checkout
Route::get('/cart', [CartController::class, 'index'])->name('cart');
// GET route to handle accidental navigation or redirects - redirects to cart page
Route::get('/cart/add', function() {
    return redirect()->route('cart');
})->name('cart.add.get');
Route::post('/cart/add', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add')->middleware('auth');
Route::post('/cart/update', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update')->middleware('auth');
Route::post('/cart/remove', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove')->middleware('auth');
Route::post('/cart/clear', [\App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear')->middleware('auth');

Route::get('/checkout', [\App\Http\Controllers\OrderController::class, 'checkout'])->name('checkout')->middleware('auth');
Route::post('/checkout', [\App\Http\Controllers\OrderController::class, 'processCheckout'])->name('checkout.process')->middleware('auth');
Route::get('/order/{id}', [\App\Http\Controllers\OrderController::class, 'show'])->name('order.show')->middleware('auth');
Route::get('/order/{id}/download', [\App\Http\Controllers\OrderController::class, 'downloadInvoice'])->name('order.download')->middleware('auth');
Route::get('/orders/history', [\App\Http\Controllers\OrderController::class, 'history'])->name('orders.history')->middleware('auth');

Route::get('/order-confirmation', function () {
    return view('order-confirmation');
})->name('order-confirmation');

Route::get('/wishlist', function () {
    return view('customer.wishlist');
})->name('wishlist');

// =============================
// Authentication Pages
// =============================

Route::get('/login', function () {
    return redirect()->route('home');
})->name('login');

Route::get('/register', function () {
    return redirect()->route('home');
})->name('register');

Route::get('/register-selection', function () {
    return redirect()->route('home');
})->name('register-selection');

// Customer Auth
Route::get('/customer/login', function () {
    return redirect()->route('home')->with('open_modal', 'login');
})->name('customer.login');

Route::post('/customer/login', [AuthController::class, 'loginCustomer'])->name('customer.login.submit');

Route::get('/customer/register', function () {
    return redirect()->route('home')->with('open_modal', 'register');
})->name('customer.register');

Route::post('/customer/register', [AuthController::class, 'registerCustomer'])->name('customer.register.submit');

// Seller Auth
Route::get('/seller/login', function () {
    return redirect()->route('home');
})->name('seller.login');

Route::post('/seller/login', [AuthController::class, 'loginSeller'])->name('seller.login.submit');

Route::get('/seller/register', function () {
    return redirect()->route('home');
})->name('seller.register');

Route::post('/seller/register', [AuthController::class, 'registerSeller'])->name('seller.register.submit');

Route::post('/customer/logout', [AuthController::class, 'logout'])->name('customer.logout');
Route::post('/seller/logout', [AuthController::class, 'logout'])->name('seller.logout');

Route::get('/direct-seller-register', function () {
    return view('direct.seller-register');
})->name('direct.seller.register.form');

// Other Auth Pages
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->name('password.reset');

Route::get('/verify-email', function () {
    return view('auth.verify-email');
})->name('verification.notice');

Route::get('/confirm-password', function () {
    return view('auth.confirm-password');
})->name('password.confirm');

Route::get('/two-factor-challenge', function () {
    return view('auth.two-factor-challenge');
})->name('two-factor.login');

// =============================
// Customer Dashboard
// =============================

Route::prefix('customer')->name('customer.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        // Redirect to home instead of showing dashboard
        return redirect()->route('home');
    })->name('dashboard');

    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'customerOrders'])->name('orders');

    Route::get('/orders/{id}', function ($id) {
        return view('customer.order-detail', ['id' => $id]);
    })->name('orders.detail');

    Route::get('/review/create', function () {
        return view('customer.create-review');
    })->name('review.create');

    Route::get('/profile', function () {
        return view('customer.profile');
    })->name('profile');
});

// =============================
// Seller Dashboard
// =============================

Route::prefix('seller')->name('seller.')->middleware(['auth:seller'])->group(function () {
    Route::get('/dashboard', function () {
        return view('seller.dashboard');
    })->name('dashboard');

    Route::get('/dashboard-home', function () {
        return view('seller.dashboard-home');
    })->name('dashboard-home');

    Route::get('/analytics', function () {
        return view('seller.analytics');
    })->name('analytics');

    Route::get('/revenue', function () {
        return view('seller.revenue');
    })->name('revenue');

    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'sellerOrders'])->name('orders');
    Route::get('/orders/{id}/details', [\App\Http\Controllers\OrderController::class, 'sellerOrderDetails'])->name('orders.details');
    Route::post('/orders/{id}/status', [\App\Http\Controllers\OrderController::class, 'updateOrderStatus'])->name('orders.status');

    Route::get('/products', function () {
        $seller = Auth::guard('seller')->user();
        
        if (!$seller) {
            return redirect()->route('home')
                ->withErrors(['error' => 'You must be logged in as a seller.']);
        }
        
        $products = \App\Models\Product::where('seller_id', $seller->seller_id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('seller.products.index', compact('products'));
    })->name('products');

    Route::get('/products/create', function () {
        return view('seller.products.create');
    })->name('products.create');

    Route::post('/products', [\App\Http\Controllers\ProductController::class, 'store'])->name('products.store');

    Route::get('/products/{id}/edit', function ($id) {
        $seller = Auth::guard('seller')->user();
        
        if (!$seller) {
            return redirect()->route('home')
                ->withErrors(['error' => 'You must be logged in as a seller.']);
        }
        
        $product = \App\Models\Product::where('product_id', $id)
            ->where('seller_id', $seller->seller_id)
            ->first();
        
        if (!$product) {
            return redirect()->route('seller.products')
                ->withErrors(['error' => 'Product not found or you do not have permission to edit it.']);
        }
        
        return view('seller.products.edit', compact('product'));
    })->name('products.edit');

    Route::put('/products/{id}', [\App\Http\Controllers\ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [\App\Http\Controllers\ProductController::class, 'destroy'])->name('products.destroy');

    // Legacy listings routes
    Route::get('/listings', [\App\Http\Controllers\ProductController::class, 'index'])->name('listings');

    Route::get('/listings/create', function () {
        return view('seller.add-listing');
    })->name('listings.create');

    Route::get('/listings/add', function () {
        return view('seller.add-listing');
    })->name('listings.add');

    Route::get('/profile', function () {
        return view('seller.profile');
    })->name('profile');
});

// =============================
// Admin Dashboard
// =============================

Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login');

Route::post('/admin/login', [\App\Http\Controllers\AuthController::class, 'loginSeller'])->name('admin.login.submit');

Route::prefix('admin')->name('admin.')->middleware(['auth:seller', \App\Http\Middleware\EnsureUserIsAdmin::class])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('admin.products.index');
    })->name('dashboard');

    Route::get('/dashboard-home', function () {
        return view('admin.dashboard-home');
    })->name('dashboard-home');

    Route::get('/dashboard-simple', function () {
        return view('admin.dashboard-simple');
    })->name('dashboard-simple');

    Route::get('/direct-dashboard', function () {
        return view('admin.direct-dashboard');
    })->name('direct-dashboard');

    // Products
    Route::get('/products', [\App\Http\Controllers\AdminController::class, 'products'])->name('products');
    Route::get('/products/index', [\App\Http\Controllers\AdminController::class, 'products'])->name('products.index');
    Route::delete('/products/{id}', [\App\Http\Controllers\AdminController::class, 'deleteProduct'])->name('products.delete');

    // Brands routes removed - brands are managed as enum in products table

    // Users
    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('users');
    Route::get('/users/index', [\App\Http\Controllers\AdminController::class, 'users'])->name('users.index');
    Route::delete('/customers/{id}', [\App\Http\Controllers\AdminController::class, 'removeCustomer'])->name('customers.remove');
    Route::delete('/sellers/{id}', [\App\Http\Controllers\AdminController::class, 'removeSeller'])->name('sellers.remove');

    // Logout
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

    // Settings
    Route::get('/settings', function () {
        return view('admin.settings');
    })->name('settings');
});

// =============================
// Other Pages
// =============================

Route::get('/terms', function () {
    return view('terms');
})->name('terms');

Route::get('/policy', function () {
    return view('policy');
})->name('policy');

Route::get('/placeholder', function () {
    return view('placeholder');
})->name('placeholder');
