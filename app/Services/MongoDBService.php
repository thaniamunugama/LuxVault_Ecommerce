<?php

namespace App\Services;

use MongoDB\Client;
use MongoDB\Exception\Exception;

class MongoDBService
{
    protected $client;
    protected $database;
    protected $collection;

    public function __construct()
    {
        try {
            $dsn = env('MONGODB_DSN', 'mongodb://localhost:27017');
            $database = env('MONGODB_DATABASE', 'luxvault_analytics');
            
            $this->client = new Client($dsn);
            $this->database = $this->client->selectDatabase($database);
            $this->collection = $this->database->selectCollection('product_analytics');
        } catch (Exception $e) {
            \Log::warning('MongoDB connection failed: ' . $e->getMessage());
            $this->client = null;
        }
    }

    /**
     * Check if MongoDB is available
     */
    public function isAvailable()
    {
        return $this->client !== null;
    }

    /**
     * Track product view in MongoDB
     */
    public function trackProductView($productId, $request)
    {
        if (!$this->isAvailable()) {
            return false;
        }

        try {
            $this->collection->insertOne([
                'product_id' => (int)$productId,
                'viewed_at' => new \MongoDB\BSON\UTCDateTime(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'type' => 'view'
            ]);
            return true;
        } catch (Exception $e) {
            \Log::error('MongoDB track view failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Track product search in MongoDB
     */
    public function trackProductSearch($searchTerm, $request)
    {
        if (!$this->isAvailable()) {
            return false;
        }

        try {
            $searchCollection = $this->database->selectCollection('search_analytics');
            $searchCollection->insertOne([
                'search_term' => $searchTerm,
                'searched_at' => new \MongoDB\BSON\UTCDateTime(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'type' => 'search'
            ]);
            return true;
        } catch (Exception $e) {
            \Log::error('MongoDB track search failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get best sellers from MongoDB analytics
     */
    public function getBestSellersFromAnalytics($limit = 10)
    {
        if (!$this->isAvailable()) {
            return [];
        }

        try {
            $pipeline = [
                ['$match' => ['type' => 'view']],
                ['$group' => [
                    '_id' => '$product_id',
                    'total_views' => ['$sum' => 1],
                    'last_viewed' => ['$max' => '$viewed_at']
                ]],
                ['$sort' => ['total_views' => -1]],
                ['$limit' => $limit]
            ];

            $results = $this->collection->aggregate($pipeline);
            $productIds = [];
            
            foreach ($results as $result) {
                $productIds[] = $result['_id'];
            }
            
            return $productIds;
        } catch (Exception $e) {
            \Log::error('MongoDB get best sellers failed: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get popular search terms from MongoDB
     */
    public function getPopularSearches($limit = 10)
    {
        if (!$this->isAvailable()) {
            return [];
        }

        try {
            $searchCollection = $this->database->selectCollection('search_analytics');
            $pipeline = [
                ['$match' => ['type' => 'search']],
                ['$group' => [
                    '_id' => '$search_term',
                    'count' => ['$sum' => 1],
                    'last_searched' => ['$max' => '$searched_at']
                ]],
                ['$sort' => ['count' => -1]],
                ['$limit' => $limit]
            ];

            $results = $searchCollection->aggregate($pipeline);
            $searches = [];
            
            foreach ($results as $result) {
                $searches[] = [
                    'term' => $result['_id'],
                    'count' => $result['count']
                ];
            }
            
            return $searches;
        } catch (Exception $e) {
            \Log::error('MongoDB get popular searches failed: ' . $e->getMessage());
            return [];
        }
    }
}

