@extends('seller.dashboard')

@section('seller-content')
<div class="space-y-8">
  <!-- Account Status Banner -->
  @if(Auth::user() && Auth::user()->status === 'active')
    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
      <div class="flex">
        <div class="flex-shrink-0">
          <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
          </svg>
        </div>
        <div class="ml-3">
          <h3 class="text-sm font-medium text-green-800">Account Approved</h3>
          <div class="mt-2 text-sm text-green-700">
            <p>Your seller account has been approved! You can now create listings that will be visible to customers.</p>
          </div>
        </div>
      </div>
    </div>
  @endif

  <div>
    <h1 class="text-2xl font-bold mb-4">Seller Dashboard</h1>
    <p class="text-gray-600">Welcome to your Luxe Vault seller dashboard. Manage your listings, track orders, and view your revenue.</p>
  </div>
  
  <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
      <div class="flex justify-between items-start">
        <div>
          <p class="text-gray-500 mb-1">Active Listings</p>
          <h3 class="text-3xl font-bold">{{ $activeListings }}</h3>
        </div>
        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-medium">{{ $totalListings }} total</span>
      </div>
    </div>
    
    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
      <div class="flex justify-between items-start">
        <div>
          <p class="text-gray-500 mb-1">Total Orders</p>
          <h3 class="text-3xl font-bold">{{ $totalOrders }}</h3>
        </div>
        @if($pendingOrders > 0)
        <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded text-xs font-medium">{{ $pendingOrders }} pending</span>
        @endif
      </div>
    </div>
    
    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
      <div class="flex justify-between items-start">
        <div>
          <p class="text-gray-500 mb-1">Total Revenue</p>
          <h3 class="text-3xl font-bold">${{ number_format($totalRevenue, 2) }}</h3>
        </div>
      </div>
    </div>
    
    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
      <div class="flex justify-between items-start">
        <div>
          <p class="text-gray-500 mb-1">Monthly Revenue</p>
          <h3 class="text-3xl font-bold">${{ number_format($monthlyRevenue, 2) }}</h3>
        </div>
        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-medium">{{ now()->format('M Y') }}</span>
      </div>
    </div>

    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
      <div class="flex justify-between items-start">
        <div>
          <p class="text-gray-500 mb-1">Avg Order Value</p>
          <h3 class="text-3xl font-bold">${{ $totalOrders > 0 ? number_format($totalRevenue / $totalOrders, 2) : '0.00' }}</h3>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Sales Chart and Best Selling Products -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Daily Sales Chart -->
    <div class="border border-gray-200 rounded-xl overflow-hidden">
      <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
        <h3 class="font-semibold">Sales Last 7 Days</h3>
      </div>
      <div class="p-6">
        <div class="space-y-4">
          @foreach($dailySales as $day)
          <div class="flex justify-between items-center">
            <span class="text-sm text-gray-600">{{ $day['date'] }}</span>
            <div class="flex items-center">
              <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                <div class="bg-black h-2 rounded-full" style="width: {{ $totalRevenue > 0 ? ($day['sales'] / $totalRevenue * 100) : 0 }}%"></div>
              </div>
              <span class="text-sm font-medium">${{ number_format($day['sales'], 2) }}</span>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>

    <!-- Best Selling Products -->
    <div class="border border-gray-200 rounded-xl overflow-hidden">
      <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
        <h3 class="font-semibold">Best Selling Products</h3>
      </div>
      @if($bestSellingProducts->count() > 0)
      <div class="divide-y">
        @foreach($bestSellingProducts as $item)
        <div class="px-6 py-4 flex justify-between items-center">
          <div class="flex items-center">
            @if($item['product']->image)
              <img src="{{ asset('images/' . $item['product']->image) }}" alt="{{ $item['product']->name }}" class="w-10 h-10 rounded object-cover mr-3">
            @else
              <div class="w-10 h-10 bg-gray-200 rounded mr-3"></div>
            @endif
            <div>
              <p class="font-medium text-sm">{{ Str::limit($item['product']->name, 30) }}</p>
              <p class="text-xs text-gray-500">{{ $item['quantity_sold'] }} sold • ${{ number_format($item['revenue'], 2) }}</p>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      @else
      <div class="px-6 py-4 text-center">
        <p class="text-gray-500">No sales yet</p>
      </div>
      @endif
    </div>
  </div>
  
  <div class="grid grid-cols-1 md:grid-cols-1 gap-8">
    <div class="border border-gray-200 rounded-xl overflow-hidden">
      <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
        <h3 class="font-semibold">Recent Orders</h3>
      </div>
      
      @if($recentOrders->count() > 0)
      <div class="divide-y">
        @foreach($recentOrders as $order)
        <div class="px-6 py-4 flex justify-between items-center">
          <div>
            <p class="font-medium">#{{ $order->order_number ?? $order->order_id }}</p>
            <p class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</p>
          </div>
          <span class="px-3 py-1 rounded-full text-xs font-medium
            @if($order->status == 'completed') bg-green-100 text-green-800 
            @elseif($order->status == 'processing') bg-yellow-100 text-yellow-800
            @elseif($order->status == 'cancelled') bg-red-100 text-red-800
            @else bg-blue-100 text-blue-800 @endif">
            {{ ucfirst($order->status) }}
          </span>
        </div>
        @endforeach
      </div>
      @else
      <div class="px-6 py-4 text-center">
        <p class="text-gray-500">No orders yet</p>
      </div>
      @endif
      
      <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
        <a href="{{ route('seller.orders') }}" class="text-sm font-medium text-black hover:underline">View all orders</a>
      </div>
    </div>
  </div>
  
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="relative rounded-lg border border-gray-200 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
      <div class="flex-shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
      </div>
      <div class="flex-1 min-w-0">
        <a href="{{ route('seller.listings.create') }}" class="focus:outline-none">
          <p class="text-sm font-medium text-gray-900">Add New Product</p>
          <p class="text-sm text-gray-500">Create a new product listing</p>
        </a>
      </div>
    </div>
    
    <div class="relative rounded-lg border border-gray-200 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
      <div class="flex-shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
        </svg>
      </div>
      <div class="flex-1 min-w-0">
        <a href="{{ route('seller.listings') }}" class="focus:outline-none">
          <p class="text-sm font-medium text-gray-900">Manage Products</p>
          <p class="text-sm text-gray-500">View and edit your product listings</p>
        </a>
      </div>
    </div>
  </div>
</div>
@endsection