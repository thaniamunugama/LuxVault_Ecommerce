@extends('seller.layouts.app')

@section('title', 'Seller Orders')

@section('content')
      <img src="{{ asset('images/logo- black.png') }}" alt="Luxe Vault Logo" class="h-12 w-auto mb-8">
      
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
        @php $seller = Auth::guard('seller')->user(); @endphp
        @if($seller && $seller->avatar)
          <img src="{{ asset('storage/' . $seller->avatar) }}" alt="Profile" class="h-10 w-10 rounded-full border object-cover">
        @else
          <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-semibold">
            {{ $seller ? strtoupper(substr($seller->fname, 0, 1) . substr($seller->lname, 0, 1)) : 'SE' }}
          </div>
        @endif
        <div class="ml-3">
          <p class="text-sm font-medium text-gray-700">{{ $seller ? $seller->fname . ' ' . $seller->lname : 'Seller' }}</p>
          <a href="{{ route('seller.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-xs text-gray-500 hover:text-gray-700">Sign Out</a>
          <form id="logout-form" action="{{ route('seller.logout') }}" method="POST" class="hidden">
            @csrf
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="flex-1 p-8">
    <div class="space-y-6">
      <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">My Orders</h1>
      </div>
      
      @if(session('success'))
      <div class="bg-green-50 border border-green-200 text-green-800 rounded-md p-4">
        {{ session('success') }}
      </div>
      @endif
      
      @if(session('error'))
      <div class="bg-red-50 border border-red-200 text-red-800 rounded-md p-4">
        {{ session('error') }}
      </div>
      @endif
      
      <div class="bg-gray-50 rounded-lg p-4 flex items-center space-x-4">
        <div class="flex-1">
          <input type="text" placeholder="Search by order ID or customer name..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black">
        </div>
        <div class="flex space-x-2">
          <input type="date" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black" placeholder="Date">
          <button class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300">
            Filter
          </button>
        </div>
      </div>
  
  <div class="overflow-x-auto">
    <table class="min-w-full bg-white rounded-xl overflow-hidden">
      <thead class="bg-gray-50 border-b">
        <tr>
          <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Order ID</th>
          <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Items</th>
          <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Date</th>
          <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Status</th>
          <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Amount</th>
          <th class="px-6 py-4 text-right text-sm font-medium text-gray-500">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        @forelse($orders as $orderId => $orderData)
        <tr>
          <td class="px-6 py-4 font-medium">#{{ $orderData['order']->order_number ?? $orderId }}</td>
          <td class="px-6 py-4">
            @if($orderData['items']->isNotEmpty())
            <div class="flex items-center">
              @if($orderData['items']->first()->product && $orderData['items']->first()->product->image)
              <img src="{{ asset('storage/' . $orderData['items']->first()->product->image) }}" 
                   alt="{{ $orderData['items']->first()->product->name }}" 
                   class="h-12 w-16 object-cover rounded mr-3">
              @else
              <div class="h-12 w-16 bg-gray-200 rounded mr-3 flex items-center justify-center">
                <span class="text-xs text-gray-500">No Image</span>
              </div>
              @endif
              <div>
                <span>{{ $orderData['items']->first()->product->name ?? 'Unknown Product' }}</span>
                @if($orderData['items']->count() > 1)
                <div class="text-xs text-gray-500">+{{ $orderData['items']->count() - 1 }} more items</div>
                @endif
              </div>
            </div>
            @else
            <span class="text-gray-500">No items</span>
            @endif
          </td>
          <td class="px-6 py-4">{{ $orderData['order']->created_at->format('Y-m-d') }}</td>
          <td class="px-6 py-4">
            <span class="px-3 py-1 rounded-full text-xs font-medium 
              @if($orderData['order']->status == 'completed') bg-green-100 text-green-800
              @elseif($orderData['order']->status == 'processing') bg-yellow-100 text-yellow-800
              @elseif($orderData['order']->status == 'cancelled') bg-red-100 text-red-800
              @else bg-blue-100 text-blue-800 @endif">
              {{ ucfirst($orderData['order']->status) }}
            </span>
          </td>
          <td class="px-6 py-4 font-medium">£{{ number_format($orderData['total'], 2) }}</td>
          <td class="px-6 py-4 text-right">
            <a href="{{ route('seller.orders.show', $orderId) }}" class="text-blue-600 hover:text-blue-900">View</a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="px-6 py-4 text-center text-gray-500">No orders found.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  
  @if(!$orders->isEmpty())
  <div class="flex justify-between items-center pt-4">
    <div class="text-sm text-gray-500">Showing {{ $orders->count() }} orders</div>
  </div>
  @endif
</div>
@endsection
