<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// API route for authenticated user (works with Customer or Seller via Sanctum/Jetstream)
Route::get('/user', function (Request $request) {
    $user = $request->user();
    if ($user) {
        return response()->json([
            'id' => $user->customer_id ?? $user->seller_id ?? $user->id,
            'name' => ($user->fname ?? '') . ' ' . ($user->lname ?? ''),
            'email' => $user->email,
            'type' => $user instanceof \App\Models\Seller ? 'seller' : 'customer',
            'profile_photo_url' => $user->profile_photo_url ?? null,
        ]);
    }
    return response()->json(['message' => 'Unauthenticated'], 401);
})->middleware('auth:sanctum');

// Jetstream API token management routes (protected by Sanctum)
Route::middleware(['auth:sanctum'])->group(function () {
    // These routes are handled by Jetstream, but we ensure they're protected
});

// MongoDB-powered Analytics API endpoints (Optional - for assignment requirement)
Route::prefix('analytics')->group(function () {
    // Track product views (stores in MongoDB)
    Route::post('/products/{id}/view', [\App\Http\Controllers\Api\ProductAnalyticsController::class, 'trackView']);
    
    // Track product searches (stores in MongoDB)
    Route::post('/search', [\App\Http\Controllers\Api\ProductAnalyticsController::class, 'trackSearch']);
    
    // Get best sellers from MongoDB analytics
    Route::get('/products/best-sellers', [\App\Http\Controllers\Api\ProductAnalyticsController::class, 'getBestSellers']);
    
    // Get popular search terms from MongoDB
    Route::get('/search/popular', [\App\Http\Controllers\Api\ProductAnalyticsController::class, 'getPopularSearches']);
    
    // Get MongoDB connection status
    Route::get('/status', [\App\Http\Controllers\Api\ProductAnalyticsController::class, 'getStatus']);
});
