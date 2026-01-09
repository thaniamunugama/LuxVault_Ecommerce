@extends('seller.dashboard')

@section('seller-content')
<div class="space-y-6">
  <div class="flex justify-between items-center">
    <div>
      <h1 class="text-2xl font-bold">Order #{{ $order->order_number ?? $order->id }}</h1>
      <p class="text-gray-500">Placed on {{ $order->created_at->format('M d, Y') }}</p>
    </div>
    <a href="{{ route('seller.orders') }}" class="bg-gray-100 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-200">
      Back to Orders
    </a>
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
  
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Order Status -->
    <div class="col-span-2 bg-white shadow overflow-hidden rounded-md">
      <div class="bg-gray-50 px-4 py-4 border-b border-gray-200">
        <h2 class="text-lg font-medium">Order Status</h2>
      </div>
      <div class="p-6">
        <div class="flex items-center space-x-4">
          <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
            @if($order->status == 'completed') bg-green-100 text-green-800
            @elseif($order->status == 'processing') bg-yellow-100 text-yellow-800
            @elseif($order->status == 'cancelled') bg-red-100 text-red-800
            @else bg-blue-100 text-blue-800 @endif">
            {{ ucfirst($order->status) }}
          </span>
          
          <form action="{{ route('seller.orders.update-status', $order->id) }}" method="POST" class="flex-grow">
            @csrf
            @method('PATCH')
            <div class="flex space-x-2">
              <select name="status" class="flex-grow px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black">
                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
              </select>
              <button type="submit" class="bg-black text-white px-4 py-2 rounded-md hover:bg-gray-800">Update Status</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    
    <!-- Order Summary -->
    <div class="bg-white shadow overflow-hidden rounded-md">
      <div class="bg-gray-50 px-4 py-4 border-b border-gray-200">
        <h2 class="text-lg font-medium">Order Summary</h2>
      </div>
      <div class="p-6 space-y-4">
        <div class="flex justify-between">
          <span class="text-gray-600">Subtotal</span>
          <span class="font-medium">£{{ number_format($orderTotal, 2) }}</span>
        </div>
        <div class="flex justify-between">
          <span class="text-gray-600">Shipping</span>
          <span class="font-medium">£{{ number_format($order->shipping_fee ?? 0, 2) }}</span>
        </div>
        <div class="flex justify-between">
          <span class="text-gray-600">Tax</span>
          <span class="font-medium">£{{ number_format($order->tax ?? 0, 2) }}</span>
        </div>
        <hr>
        <div class="flex justify-between font-bold">
          <span>Total</span>
          <span>£{{ number_format($orderTotal + ($order->shipping_fee ?? 0) + ($order->tax ?? 0), 2) }}</span>
        </div>
        <div class="pt-4">
          <span class="text-sm font-medium text-gray-500">Payment Method</span>
          <div class="mt-1 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
            </svg>
            <span>{{ $order->payment_method ?? 'Credit Card' }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Order Items -->
  <div class="bg-white shadow overflow-hidden rounded-md">
    <div class="bg-gray-50 px-4 py-4 border-b border-gray-200">
      <h2 class="text-lg font-medium">Items in this Order</h2>
    </div>
    <div class="divide-y divide-gray-200">
      @foreach($orderItems as $item)
      <div class="px-6 py-4 flex">
        <div class="flex-shrink-0 w-20 h-20">
          @if($item->product && $item->product->image)
          <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded">
          @elseif($item->product && $item->product->image_path)
          <img src="{{ asset('storage/' . $item->product->image_path) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded">
          @else
          <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-500 rounded">No Image</div>
          @endif
        </div>
        <div class="ml-6 flex-1 flex flex-col">
          <div>
            <div class="flex justify-between">
              <h3 class="text-lg font-medium">{{ $item->product->name ?? 'Unknown Product' }}</h3>
              <p class="ml-4 text-lg font-medium">£{{ number_format($item->price, 2) }}</p>
            </div>
            <p class="mt-1 text-sm text-gray-500">{{ $item->product->brand_name ?? 'Unknown Brand' }}</p>
          </div>
          <div class="mt-2 flex-1 flex items-end justify-between">
            <p class="text-sm font-medium text-gray-700">Qty: {{ $item->quantity }}</p>
            <p class="text-sm font-medium text-gray-700">Total: £{{ number_format($item->price * $item->quantity, 2) }}</p>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  
  <!-- Customer Information -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white shadow overflow-hidden rounded-md">
      <div class="bg-gray-50 px-4 py-4 border-b border-gray-200">
        <h2 class="text-lg font-medium">Shipping Address</h2>
      </div>
      <div class="p-6">
        <address class="not-italic">
          <p class="font-medium">{{ $order->shipping_name ?? 'Customer Name' }}</p>
          <p>{{ $order->shipping_address ?? '123 Main St' }}</p>
          <p>{{ ($order->shipping_city ?? 'City') . ', ' . ($order->shipping_postcode ?? 'Postcode') }}</p>
          <p>{{ $order->shipping_country ?? 'Country' }}</p>
          <p class="mt-2">{{ $order->contact_email ?? 'email@example.com' }}</p>
          <p>{{ $order->contact_phone ?? '+44 123 456 7890' }}</p>
        </address>
      </div>
    </div>
    
    <div class="bg-white shadow overflow-hidden rounded-md">
      <div class="bg-gray-50 px-4 py-4 border-b border-gray-200">
        <h2 class="text-lg font-medium">Order Notes</h2>
      </div>
      <div class="p-6">
        @if($order->notes)
        <p>{{ $order->notes }}</p>
        @else
        <p class="text-gray-500 italic">No notes for this order.</p>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection