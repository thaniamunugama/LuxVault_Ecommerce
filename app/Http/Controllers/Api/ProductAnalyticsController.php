<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MongoDBService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductAnalyticsController extends Controller
{
    protected $mongoService;

    public function __construct(MongoDBService $mongoService)
    {
        $this->mongoService = $mongoService;
    }

    /**
     * Track product view via API
     * POST /api/analytics/products/{id}/view
     */
    public function trackView(Request $request, $id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:products,product_id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid product ID'
            ], 400);
        }

        $tracked = $this->mongoService->trackProductView($id, $request);

        return response()->json([
            'success' => $tracked,
            'message' => $tracked ? 'View tracked successfully' : 'MongoDB not available, view not tracked',
            'mongodb_available' => $this->mongoService->isAvailable()
        ]);
    }

    /**
     * Track product search via API
     * POST /api/analytics/search
     */
    public function trackSearch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'search_term' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid search term'
            ], 400);
        }

        $tracked = $this->mongoService->trackProductSearch($request->search_term, $request);

        return response()->json([
            'success' => $tracked,
            'message' => $tracked ? 'Search tracked successfully' : 'MongoDB not available, search not tracked',
            'mongodb_available' => $this->mongoService->isAvailable()
        ]);
    }

    /**
     * Get best sellers from MongoDB analytics
     * GET /api/analytics/products/best-sellers
     */
    public function getBestSellers(Request $request)
    {
        $limit = $request->get('limit', 10);
        $productIds = $this->mongoService->getBestSellersFromAnalytics($limit);

        return response()->json([
            'success' => true,
            'data' => [
                'product_ids' => $productIds,
                'count' => count($productIds),
                'mongodb_available' => $this->mongoService->isAvailable()
            ]
        ]);
    }

    /**
     * Get popular search terms
     * GET /api/analytics/search/popular
     */
    public function getPopularSearches(Request $request)
    {
        $limit = $request->get('limit', 10);
        $searches = $this->mongoService->getPopularSearches($limit);

        return response()->json([
            'success' => true,
            'data' => [
                'searches' => $searches,
                'count' => count($searches),
                'mongodb_available' => $this->mongoService->isAvailable()
            ]
        ]);
    }

    /**
     * Get MongoDB connection status
     * GET /api/analytics/status
     */
    public function getStatus()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'mongodb_available' => $this->mongoService->isAvailable(),
                'message' => $this->mongoService->isAvailable() 
                    ? 'MongoDB is connected and ready' 
                    : 'MongoDB is not available. Please check your connection settings.'
            ]
        ]);
    }
}

