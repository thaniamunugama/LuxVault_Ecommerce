<div>
    {{-- Filters Section --}}
    <div class="mb-8 p-6">
        <div class="flex flex-col md:flex-row gap-4 items-end">
            {{-- Search --}}
            <div class="flex-1 min-w-[200px]">
                <label for="search" class="block text-xs font-medium text-gray-700 mb-1">Search</label>
                <input 
                    type="text" 
                    id="search"
                    wire:model.live.debounce.300ms="search" 
                    placeholder="Search products..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-2xl focus:ring-black focus:border-black"
                >
            </div>

            {{-- Brand Filter --}}
            @if(!$hideBrandFilter)
            <div class="min-w-[150px]">
                <label for="brand" class="block text-xs font-medium text-gray-700 mb-1">Brand</label>
                <select 
                    id="brand"
                    wire:model.live="brand" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-black focus:border-black"
                >
                    <option value="">All Brands</option>
                    @foreach($brands as $brandOption)
                        <option value="{{ $brandOption }}">{{ $brandOption }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            {{-- Price Range --}}
            <div class="min-w-[120px]">
                <label for="minPrice" class="block text-xs font-medium text-gray-700 mb-1">Min Price</label>
                <input 
                    type="number" 
                    id="minPrice"
                    wire:model.live.debounce.500ms="minPrice" 
                    placeholder="Min" 
                    min="0"
                    step="0.01"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-black focus:border-black"
                >
            </div>

            <div class="min-w-[120px]">
                <label for="maxPrice" class="block text-xs font-medium text-gray-700 mb-1">Max Price</label>
                <input 
                    type="number" 
                    id="maxPrice"
                    wire:model.live.debounce.500ms="maxPrice" 
                    placeholder="Max" 
                    min="0"
                    step="0.01"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-black focus:border-black"
                >
            </div>

            {{-- Sort --}}
            <div class="min-w-[150px]">
                <label for="sort" class="block text-xs font-medium text-gray-700 mb-1">Sort By</label>
                <select 
                    id="sort"
                    wire:model.live="sort" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-black focus:border-black"
                >
                    <option value="newest">Newest First</option>
                    <option value="price_low">Price: Low to High</option>
                    <option value="price_high">Price: High to Low</option>
                    <option value="name_asc">Name: A to Z</option>
                    <option value="name_desc">Name: Z to A</option>
                </select>
            </div>

            {{-- Clear Filters --}}
            @if($search || (!$hideBrandFilter && $brand) || $minPrice || $maxPrice || $sort !== 'newest')
                <button 
                    wire:click="clearFilters" 
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition"
                >
                    Clear
                </button>
            @endif
        </div>

        {{-- Active Filters Display --}}
        @if($search || (!$hideBrandFilter && $brand) || $minPrice || $maxPrice)
            <div class="mt-4 flex flex-wrap gap-2">
                <span class="text-sm text-gray-600">Active filters:</span>
                @if($search)
                    <span class="px-3 py-1 bg-black text-white text-sm rounded-full">
                        Search: "{{ $search }}"
                    </span>
                @endif
                @if(!$hideBrandFilter && $brand)
                    <span class="px-3 py-1 bg-black text-white text-sm rounded-full">
                        Brand: {{ $brand }}
                    </span>
                @endif
                @if($minPrice)
                    <span class="px-3 py-1 bg-black text-white text-sm rounded-full">
                        Min: ${{ number_format($minPrice, 2) }}
                    </span>
                @endif
                @if($maxPrice)
                    <span class="px-3 py-1 bg-black text-white text-sm rounded-full">
                        Max: ${{ number_format($maxPrice, 2) }}
                    </span>
                @endif
            </div>
        @endif
    </div>

    {{-- Products Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-8">
        @forelse($products as $product)
        <div class="space-y-3 text-center group flex flex-col">
            <a href="{{ route('product.detail', $product->product_id) }}" class="block flex-1 flex flex-col">
                <div class="bg-gray-100 rounded-xl overflow-hidden aspect-square relative">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                             onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full bg-gray-200 flex items-center justify-center\'><span class=\'text-gray-500 text-sm\'>No Image</span></div>'">
                    @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-500 text-sm">No Image</span>
                        </div>
                    @endif
                </div>
                <div class="mt-3 flex-1 flex flex-col">
                    <p class="text-sm text-gray-500">{{ $product->brand }}</p>
                    <p class="text-base font-medium min-h-[2.5rem] flex items-center justify-center">{{ Str::limit($product->name, 30) }}</p>
                    <p class="text-base font-semibold mt-1">${{ number_format($product->price, 2) }}</p>
                </div>
            </a>
            @if($product->quantity > 0)
                <form method="POST" action="{{ route('cart.add') }}" class="inline-block w-full">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="w-full mt-2 px-4 py-2 bg-black text-white text-sm rounded-md hover:bg-gray-800 transition duration-300" onclick="addToCartAjax(event, {{ $product->product_id }})">
                        Add to Cart
                    </button>
                </form>
            @else
                <button class="w-full mt-2 px-4 py-2 bg-gray-400 text-white text-sm rounded-md cursor-not-allowed" disabled>
                    Sold Out
                </button>
            @endif
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <p class="text-gray-500 text-lg">No products found matching your criteria.</p>
            <button wire:click="clearFilters" class="mt-4 px-4 py-2 bg-black text-white rounded hover:bg-gray-800">
                Clear Filters
            </button>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $products->links() }}
    </div>
</div>
