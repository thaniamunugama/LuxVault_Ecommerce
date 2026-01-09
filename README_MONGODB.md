# MongoDB Integration for API (Optional)

This project includes MongoDB integration for API analytics as per assignment requirements.

## Setup Instructions

### 1. Install MongoDB
- Download and install MongoDB from https://www.mongodb.com/try/download/community
- Or use MongoDB Atlas (cloud): https://www.mongodb.com/cloud/atlas

### 2. Install PHP MongoDB Extension
For XAMPP on Windows:
1. Download PHP MongoDB extension from https://pecl.php.net/package/mongodb
2. Or use precompiled DLL from https://github.com/mongodb/mongo-php-driver/releases
3. Add extension to `php.ini`:
   ```
   extension=mongodb
   ```
4. Restart Apache in XAMPP

### 3. Configure MongoDB Connection
Add to your `.env` file:
```env
MONGODB_DSN=mongodb://localhost:27017
MONGODB_DATABASE=luxvault_analytics
```

For MongoDB Atlas (cloud):
```env
MONGODB_DSN=mongodb+srv://username:password@cluster.mongodb.net
MONGODB_DATABASE=luxvault_analytics
```

### 4. Test MongoDB Connection
Visit: `http://127.0.0.1:8000/api/analytics/status`

## API Endpoints

All MongoDB-powered endpoints are under `/api/analytics/`:

### 1. Track Product View
**POST** `/api/analytics/products/{id}/view`
- Tracks when a product is viewed
- Stores in MongoDB collection: `product_analytics`

### 2. Track Product Search
**POST** `/api/analytics/search`
- Body: `{"search_term": "handbag"}`
- Stores in MongoDB collection: `search_analytics`

### 3. Get Best Sellers from Analytics
**GET** `/api/analytics/products/best-sellers?limit=10`
- Returns product IDs sorted by view count from MongoDB

### 4. Get Popular Searches
**GET** `/api/analytics/search/popular?limit=10`
- Returns most searched terms from MongoDB

### 5. Check MongoDB Status
**GET** `/api/analytics/status`
- Returns MongoDB connection status

## Implementation Details

### MongoDB Collections Used:
1. **product_analytics** - Stores product view tracking
2. **search_analytics** - Stores search term tracking

### MySQL Tables Used (No New Tables Added):
- `order_items` - For calculating Best Sellers (uses existing `quantity` column)
- `products` - For displaying products and New Arrivals (uses existing `created_at` column)

## Notes

- MongoDB is **optional** - the application works without it
- Best Sellers and New Products use **existing MySQL tables** (no new tables)
- MongoDB is only used for **API analytics** (view tracking, search tracking)
- If MongoDB is not available, the API endpoints will return appropriate messages

## Testing

Test MongoDB endpoints using Postman or curl:

```bash
# Track a product view
curl -X POST http://127.0.0.1:8000/api/analytics/products/1/view

# Track a search
curl -X POST http://127.0.0.1:8000/api/analytics/search \
  -H "Content-Type: application/json" \
  -d '{"search_term": "handbag"}'

# Get best sellers
curl http://127.0.0.1:8000/api/analytics/products/best-sellers

# Check status
curl http://127.0.0.1:8000/api/analytics/status
```

