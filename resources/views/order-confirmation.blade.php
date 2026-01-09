@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12 max-w-4xl">
  <div class="bg-white rounded-lg shadow-sm p-8">
    <!-- Order Confirmation Header -->
    <div class="text-center mb-8">
      <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
      </div>
      <h1 class="text-3xl font-bold mb-2">Order Confirmed!</h1>
      <p class="text-gray-600">Thank you for your purchase. Your order has been received and is being processed.</p>
    </div>

    @if(isset($order))
    <!-- Order Info -->
    <div class="border rounded-lg mb-8">
      <div class="p-6 border-b">
        <h2 class="text-lg font-semibold mb-4">Order Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <p class="text-sm text-gray-600 mb-1">Order Number</p>
            <p class="font-medium">{{ $order->order_number ?? 'LV-' . date('Ymd') . '-' . $order->id }}</p>
          </div>
          <div>
            <p class="text-sm text-gray-600 mb-1">Order Date</p>
            <p class="font-medium">{{ $order->created_at->format('F d, Y') }}</p>
          </div>
          <div>
            <p class="text-sm text-gray-600 mb-1">Total Amount</p>
            <p class="font-medium">${{ number_format($order->total, 2) }}</p>
          </div>
          <div>
            <p class="text-sm text-gray-600 mb-1">Status</p>
            <p class="font-medium text-green-600">{{ ucfirst($order->status) }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Order Items -->
    <div class="border rounded-lg mb-8">
      <div class="border-b px-6 py-4">
        <h2 class="text-lg font-semibold">Order Items ({{ $order->orderItems ? $order->orderItems->count() : ($order->items ? $order->items->count() : 0) }})</h2>
      </div>

      <div class="divide-y">
        @if(($order->orderItems && $order->orderItems->count() > 0) || ($order->items && $order->items->count() > 0))
          @php 
            $items = $order->orderItems && $order->orderItems->count() > 0 ? $order->orderItems : $order->items;
          @endphp
          @foreach($items as $item)
          <div class="p-6 flex items-center">
            <div class="w-16 h-16 flex-shrink-0 overflow-hidden rounded-md">
              @if($item->product && $item->product->image)
                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
              @elseif($item->product && $item->product->image_path)
                <img src="{{ asset('storage/' . $item->product->image_path) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
              @else
                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                  <span class="text-gray-400 text-xs">No Image</span>
                </div>
              @endif
            </div>
          <div class="ml-6 flex-1">
            <h3 class="text-base font-medium">{{ $item->product->name ?? 'Product Unavailable' }}</h3>
            <p class="mt-1 text-sm text-gray-500">{{ $item->product->brand_name ?? $item->product->brand ?? 'Luxury Brand' }}</p>
          </div>
          <div class="ml-6">
            <p class="text-sm text-gray-600">Qty: {{ $item->quantity }}</p>
          </div>
          <div class="ml-6">
            <p class="text-base font-medium">${{ number_format($item->price ?? $item->unit_price ?? 0, 2) }}</p>
          </div>
        </div>
        @endforeach
        @else
          <div class="p-6 text-center text-gray-500">
            <p>No order items found.</p>
          </div>
        @endif
      </div>

      <!-- Order Summary -->
      <div class="border-t px-6 py-4">
        <div class="space-y-2 flex flex-col items-end">
          <div class="flex justify-between w-64">
            <p class="text-gray-600">Subtotal</p>
            <p class="text-gray-900">${{ number_format(($order->total_amount ?? $order->total_price ?? $order->total ?? 0) - ($order->shipping_cost ?? 0), 2) }}</p>
          </div>
          <div class="flex justify-between w-64">
            <p class="text-gray-600">Shipping</p>
            <p class="text-gray-900">${{ number_format($order->shipping_cost ?? 0, 2) }}</p>
          </div>
          <div class="flex justify-between w-64 border-t pt-2">
            <p class="font-semibold">Total:</p>
            <p class="font-semibold">${{ number_format($order->total_amount ?? $order->total_price ?? $order->total ?? 0, 2) }}</p>
          </div>
        </div>
      </div>
    </div>
    @endif

    <!-- Next Steps -->
    <div class="bg-gray-50 rounded-lg p-6 mb-8">
      <h2 class="text-lg font-semibold mb-4">What's Next?</h2>
      <ul class="space-y-3">
        <li class="flex">
          <svg class="flex-shrink-0 w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
          </svg>
          <span>Your order has been confirmed and is being processed.</span>
        </li>
        <li class="flex">
          <svg class="flex-shrink-0 w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
          </svg>
          <span>The seller has been notified and will begin processing your order.</span>
        </li>
        <li class="flex">
          <svg class="flex-shrink-0 w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
          </svg>
          <span>Your items will be shipped within 1-2 business days.</span>
        </li>
      </ul>
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-center gap-4">
      <a href="{{ route('products') }}" class="bg-black text-white px-8 py-3 rounded-lg font-semibold hover:bg-gray-800 transition">
        Continue Shopping
      </a>
      <a href="{{ route('home') }}" class="border border-gray-300 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-50 transition">
        Back to Home
      </a>
    </div>
  </div>
</div>

<script>
// Check if we've already shown the notification
if (!sessionStorage.getItem('orderConfirmationShown')) {
  // Show success notification using a more elegant approach than alert()
  setTimeout(function() {
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-md transition-all duration-500 transform translate-x-0 z-50';
    notification.innerHTML = `
      <div class="flex items-center">
        <div class="py-1">
          <svg class="w-6 h-6 mr-4 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <div>
          <p class="font-bold">Order Placed Successfully!</p>
          <p class="text-sm">Thank you for your purchase.</p>
        </div>
        <button onclick="this.parentElement.parentElement.remove()" class="ml-6">
          <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    `;
    
    document.body.appendChild(notification);
    
    // Remove after 5 seconds
    setTimeout(() => {
      notification.classList.add('translate-x-full', 'opacity-0');
      setTimeout(() => {
        notification.remove();
      }, 500);
    }, 5000);
    
    // Mark as shown in this session
    sessionStorage.setItem('orderConfirmationShown', 'true');
  }, 500);
}
</script>
@endsection