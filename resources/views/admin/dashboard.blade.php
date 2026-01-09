<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Luxe Vault - Admin Dashboard</title>
  @vite(['resources/js/app.js'])
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    html, body {
      font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
    }
  </style>
</head>
<body class="bg-gray-100 text-gray-900">

@php
  $nav = [
    ['name' => 'Products', 'route' => 'admin.products.index'],
    ['name' => 'Users', 'route' => 'admin.users.index'],
  ];
  $current = request()->route()->getName();
@endphp

<div class="flex min-h-screen">
  <!-- Sidebar -->
  <div class="w-64 bg-white shadow-lg">
    <div class="p-6">
      <img src="{{ asset('images/logo- black.png') }}" alt="Luxe Vault Logo" class="h-16 w-auto mb-8">
      
      <nav class="space-y-1">
        @foreach ($nav as $item)
          <a href="{{ route($item['route']) }}"
             class="flex items-center px-4 py-3 text-base font-medium rounded-lg {{ $current === $item['route'] ? 'bg-black text-white' : 'text-gray-700 hover:bg-gray-100' }}">
            {{ $item['name'] }}
          </a>
        @endforeach
      </nav>
    </div>
    
    <div class="mt-auto p-6 border-t">
      <div class="flex items-center">
        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-700 font-semibold text-sm">
          A
        </div>
        <div class="ml-3">
          <a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-sm text-gray-500 hover:text-gray-700">Sign Out</a>
          <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="hidden">
            @csrf
          </form>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Main Content -->
  <div class="flex-1 p-8">
    <div class="max-w-7xl mx-auto">
      <!-- Flash Messages -->
      @if(session('success'))
      <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg relative flex items-center justify-between" role="alert">
          <div class="flex items-center">
              <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span>{{ session('success') }}</span>
          </div>
          <button type="button" class="text-green-700 hover:text-green-900" onclick="this.parentElement.style.display='none'">
              <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
          </button>
      </div>
      @endif

      @if(session('error'))
      <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg relative flex items-center justify-between" role="alert">
          <div class="flex items-center">
              <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span>{{ session('error') }}</span>
          </div>
          <button type="button" class="text-red-700 hover:text-red-900" onclick="this.parentElement.style.display='none'">
              <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
          </button>
      </div>
      @endif

      <div class="bg-white rounded-xl shadow-lg p-8">
        @hasSection('admin-content')
          @yield('admin-content')
        @else
        @if(isset($totalProducts) && isset($totalOrders) && isset($totalCustomers) && isset($totalRevenue))
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-indigo-100 text-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Products</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $totalProducts }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Orders</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $totalOrders }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Customers</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $totalCustomers }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                        <p class="text-2xl font-semibold text-gray-900">${{ number_format($totalRevenue, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Orders -->
            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Recent Orders</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-3 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                                <th class="px-3 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                <th class="px-3 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-3 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-3 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($latestOrders as $order)
                            <tr>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                        #{{ $order->order_number ?? $order->id }}
                                    </a>
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    {{ $order->customer->first_name ?? 'N/A' }} {{ $order->customer->last_name ?? '' }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    {{ $order->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    ${{ number_format($order->total_amount ?? $order->total ?? 0, 2) }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    @if($order->status == 'pending')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    @elseif($order->status == 'processing')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Processing
                                        </span>
                                    @elseif($order->status == 'shipped')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                            Shipped
                                        </span>
                                    @elseif($order->status == 'delivered')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Delivered
                                        </span>
                                    @elseif($order->status == 'cancelled')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Cancelled
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            {{ ucfirst($order->status ?? 'N/A') }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-3 py-4 text-center text-gray-500">
                                    No orders found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.orders.index') }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">View all orders →</a>
                </div>
            </div>
            
            <!-- Recent Products -->
            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Recent Products</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-3 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                <th class="px-3 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seller</th>
                                <th class="px-3 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th class="px-3 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($recentProducts as $product)
                            <tr>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                        {{ $product->name ?? 'N/A' }}
                                    </a>
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    {{ $product->seller->name ?? 'N/A' }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    ${{ number_format($product->price ?? 0, 2) }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    @if(($product->quantity ?? 0) > 10)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ $product->quantity ?? 0 }} in stock
                                        </span>
                                    @elseif(($product->quantity ?? 0) > 0)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            {{ $product->quantity ?? 0 }} low stock
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Out of stock
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-3 py-4 text-center text-gray-500">
                                    No products found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.products.index') }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">View all products →</a>
                </div>
            </div>
        </div>
        @else
        <div class="p-6 text-center">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Welcome to Admin Dashboard</h2>
            <p class="text-gray-600">Use the navigation menu on the left to manage your store.</p>
        </div>
        @endif
        @endif
      </div>
    </div>
  </div>
</div>

</body>
</html>