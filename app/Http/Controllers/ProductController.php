<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the seller's products
     */
    public function index()
    {
        $user = Auth::guard('seller')->user();
        if (!$user || !($user instanceof Seller)) {
            return redirect()->route('home')
                ->withErrors(['error' => 'You must be logged in as a seller.']);
        }

        $products = Product::where('seller_id', $user->seller_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('seller.listings', compact('products'));
    }

    /**
     * Store a newly created product
     */
    public function store(Request $request)
    {
        \Log::info('Product store method called', ['request_data' => $request->except(['_token', 'image'])]);
        
        // Map brand names to database values
        $brandMap = [
            'Hermes' => 'Hermes',
            'Chanel' => 'Chanel',
            'Coach' => 'Coach',
            'YSL' => 'YSL',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'brand_name' => 'required|in:Hermes,Chanel,Coach,YSL',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            \Log::error('Product validation failed', ['errors' => $validator->errors()->all()]);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Get the authenticated seller using seller guard
        $user = Auth::guard('seller')->user();
        if (!$user || !($user instanceof Seller)) {
            \Log::error('User not authenticated or not a seller', ['user' => $user ? get_class($user) : 'null']);
            return redirect()->back()
                ->withErrors(['error' => 'You must be logged in as a seller to create products.'])
                ->withInput();
        }

        \Log::info('Seller found', ['seller_id' => $user->seller_id]);

        try {
            DB::beginTransaction();

            // Map brand name to database value
            $brand = $brandMap[$request->brand_name] ?? $request->brand_name;

            \Log::info('Creating product', [
                'seller_id' => $user->seller_id,
                'brand' => $brand,
                'name' => $request->name,
                'price' => $request->price,
                'quantity' => $request->quantity,
            ]);

            // Create the product
            $product = Product::create([
                'seller_id' => $user->seller_id,
                'brand' => $brand,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'quantity' => $request->quantity,
            ]);

            \Log::info('Product created', ['product_id' => $product->product_id]);

            // Handle image upload if provided
            if ($request->hasFile('image')) {
                try {
                    $image = $request->file('image');
                    
                    // Ensure products directory exists
                    $productsDir = storage_path('app/public/products');
                    if (!file_exists($productsDir)) {
                        mkdir($productsDir, 0755, true);
                    }
                    
                    // Generate unique filename
                    $imageName = $product->product_id . '_' . time() . '.' . $image->getClientOriginalExtension();
                    
                    // Store image in public disk (storage/app/public/products/)
                    $imagePath = $image->storeAs('products', $imageName, 'public');
                    
                    \Log::info('Image uploaded', [
                        'image_path' => $imagePath,
                        'full_path' => storage_path('app/public/' . $imagePath),
                        'file_exists' => file_exists(storage_path('app/public/' . $imagePath))
                    ]);
                    
                    // Store path relative to storage/app/public (e.g., "products/1_123456.jpg")
                    $product->image = $imagePath;
                    $product->save();
                    
                    \Log::info('Product image saved to database', [
                        'product_id' => $product->product_id,
                        'image_path' => $product->image,
                        'url_path' => asset('storage/' . $product->image)
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Image upload failed: ' . $e->getMessage());
                    // Don't fail the entire product creation if image fails
                }
            }

            DB::commit();

            \Log::info('Product creation successful', ['product_id' => $product->product_id]);

            return redirect()->route('seller.listings')
                ->with('success', 'Product created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Product Creation Error: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
            return redirect()->back()
                ->withErrors(['error' => 'Failed to create product: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::guard('seller')->user();
        if (!$user || !($user instanceof Seller)) {
            return redirect()->route('home')
                ->withErrors(['error' => 'You must be logged in as a seller.']);
        }

        $product = Product::where('product_id', $id)
            ->where('seller_id', $user->seller_id)
            ->first();

        if (!$product) {
            return redirect()->route('seller.products')
                ->withErrors(['error' => 'Product not found or you do not have permission to edit it.']);
        }

        // Validate the request
        $validationRules = [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ];
        
        // Add brand_name validation if it's provided (from edit-listing form)
        if ($request->has('brand_name')) {
            $validationRules['brand_name'] = 'required|in:Hermes,Chanel,Coach,YSL';
        }
        
        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Map brand name to database value if provided
            $brandMap = [
                'Hermes' => 'Hermes',
                'Chanel' => 'Chanel',
                'Coach' => 'Coach',
                'YSL' => 'YSL',
            ];
            
            // Update the product
            $updateData = [
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'quantity' => $request->quantity,
            ];
            
            // Update brand if brand_name is provided
            if ($request->has('brand_name')) {
                $brand = $brandMap[$request->brand_name] ?? $request->brand_name;
                $updateData['brand'] = $brand;
            }

            // Handle image upload if provided
            if ($request->hasFile('image')) {
                try {
                    // Delete old image if exists
                    if ($product->image && \Storage::disk('public')->exists($product->image)) {
                        \Storage::disk('public')->delete($product->image);
                    }
                    
                    $image = $request->file('image');
                    
                    // Ensure products directory exists
                    $productsDir = storage_path('app/public/products');
                    if (!file_exists($productsDir)) {
                        mkdir($productsDir, 0755, true);
                    }
                    
                    // Generate unique filename
                    $imageName = $product->product_id . '_' . time() . '.' . $image->getClientOriginalExtension();
                    
                    // Store image in public disk (storage/app/public/products/)
                    $imagePath = $image->storeAs('products', $imageName, 'public');
                    
                    // Update product with new image path
                    $updateData['image'] = $imagePath;
                    
                    \Log::info('Product image updated', [
                        'product_id' => $product->product_id,
                        'new_image_path' => $imagePath,
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Image upload failed during update: ' . $e->getMessage());
                    // Continue with update even if image fails
                }
            }

            // Update the product
            $product->update($updateData);

            return redirect()->route('seller.products')
                ->with('success', 'Product updated successfully!');

        } catch (\Exception $e) {
            \Log::error('Product Update Error: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['error' => 'Failed to update product: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy($id)
    {
        $user = Auth::guard('seller')->user();
        if (!$user || !($user instanceof Seller)) {
            return redirect()->route('home')
                ->withErrors(['error' => 'You must be logged in as a seller.']);
        }

        $product = Product::where('product_id', $id)
            ->where('seller_id', $user->seller_id)
            ->first();

        if (!$product) {
            return redirect()->route('seller.listings')
                ->withErrors(['error' => 'Product not found or you do not have permission to delete it.']);
        }

        try {
            // Delete image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();

            return redirect()->route('seller.listings')
                ->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            \Log::error('Product Deletion Error: ' . $e->getMessage());
            return redirect()->route('seller.listings')
                ->withErrors(['error' => 'Failed to delete product: ' . $e->getMessage()]);
        }
    }

    /**
     * Display all products for public viewing
     */
    public function publicIndex(Request $request)
    {
        $query = Product::where('quantity', '>', 0);

        // Apply search filter if provided
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Apply brand filter if provided
        if ($request->has('brand') && $request->brand) {
            $query->where('brand', $request->brand);
        }

        // Apply sorting
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->paginate(12);

        return view('products', compact('products'));
    }

    /**
     * Display products by brand
     */
    public function byBrand($brand)
    {
        // Map brand names
        $brandMap = [
            'chanel' => 'Chanel',
            'hermes' => 'Hermes',
            'ysl' => 'YSL',
            'coach' => 'Coach',
        ];

        $dbBrand = $brandMap[strtolower($brand)] ?? ucfirst($brand);
        
        $products = Product::where('brand', $dbBrand)
            ->where('quantity', '>', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $currentBrand = $dbBrand;
        $viewName = 'brands.' . strtolower($brand);
        
        // Check if brand-specific view exists, otherwise use generic products view
        if (view()->exists($viewName)) {
            return view($viewName, compact('products', 'currentBrand'));
        } else {
            return view('products', compact('products', 'currentBrand'));
        }
    }

    /**
     * Display the specified product detail page
     */
    public function show($id)
    {
        $product = Product::where('product_id', $id)->first();

        if (!$product) {
            abort(404, 'Product not found');
        }

        return view('product-detail', compact('product'));
    }

    /**
     * Get best selling products based on order_items quantity
     * Uses existing MySQL tables - no new tables needed
     */
    public function getBestSellers($limit = 4)
    {
        $bestSellers = Product::select('products.*')
            ->join('order_items', 'products.product_id', '=', 'order_items.product_id')
            ->selectRaw('SUM(order_items.quantity) as total_sold')
            ->groupBy('products.product_id', 'products.seller_id', 'products.brand', 'products.name', 'products.description', 'products.quantity', 'products.price', 'products.image', 'products.created_at')
            ->orderBy('total_sold', 'desc')
            ->where('products.quantity', '>', 0)
            ->limit($limit)
            ->get();

        return $bestSellers;
    }

    /**
     * Get new products (most recently created)
     * Uses existing MySQL tables - no new tables needed
     */
    public function getNewProducts($limit = 4)
    {
        return Product::where('quantity', '>', 0)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
