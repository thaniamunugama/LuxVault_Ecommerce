@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
  <h1 class="text-3xl font-bold mb-8">Checkout</h1>

  @if ($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-6">
      <ul class="list-disc pl-5">
        @foreach ($errors->all() as $error)
          <li class="text-sm">{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-6">
      <p class="text-sm">{{ session('error') }}</p>
    </div>
  @endif

  <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <!-- Form (8 columns on large screens) -->
    <div class="lg:col-span-8">
      <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
        @csrf

        <!-- Shipping Address -->
        <div class="bg-white rounded-lg shadow-sm mb-6 p-6">
          <h2 class="text-lg font-semibold mb-4">Shipping Address</h2>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label for="firstName" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
              <input type="text" id="firstName" name="firstName" value="{{ old('firstName') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('firstName') border-red-500 @enderror" required>
              @error('firstName')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
            
            <div>
              <label for="lastName" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
              <input type="text" id="lastName" name="lastName" value="{{ old('lastName') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('lastName') border-red-500 @enderror" required>
              @error('lastName')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
            
            <div class="md:col-span-2">
              <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Street Address</label>
              <input type="text" id="address" name="address" value="{{ old('address') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('address') border-red-500 @enderror" required>
              @error('address')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
            
            <div>
              <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
              <input type="text" id="city" name="city" value="{{ old('city') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('city') border-red-500 @enderror" required>
              @error('city')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
            
            <div>
              <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State/Province</label>
              <input type="text" id="state" name="state" value="{{ old('state') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('state') border-red-500 @enderror" required>
              @error('state')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
            
            <div>
              <label for="postalCode" class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
              <input type="text" id="postalCode" name="postalCode" value="{{ old('postalCode') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('postalCode') border-red-500 @enderror" required>
              @error('postalCode')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
            
            <div>
              <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
              <select id="country" name="country" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('country') border-red-500 @enderror" required>
                <option value="">Select Country</option>
                <option value="US" {{ old('country') == 'US' ? 'selected' : '' }}>United States</option>
                <option value="CA" {{ old('country') == 'CA' ? 'selected' : '' }}>Canada</option>
                <option value="UK" {{ old('country') == 'UK' ? 'selected' : '' }}>United Kingdom</option>
                <option value="AU" {{ old('country') == 'AU' ? 'selected' : '' }}>Australia</option>
              </select>
              @error('country')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
            
            <div class="md:col-span-2">
              <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
              <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror" required>
              @error('phone')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
          </div>
        </div>
        
        <!-- Payment Information -->
        <div class="bg-white rounded-lg shadow-sm mb-6 p-6">
          <h2 class="text-lg font-semibold mb-4">Payment Information</h2>
          
          <div class="space-y-6">
            <div>
              <label for="cardName" class="block text-sm font-medium text-gray-700 mb-1">Name on Card</label>
              <input type="text" id="cardName" name="cardName" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            
            <div>
              <label for="cardNumber" class="block text-sm font-medium text-gray-700 mb-1">Card Number</label>
              <div class="relative">
                <input type="text" id="cardNumber" name="cardNumber" placeholder="**** **** **** ****" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                <div class="absolute top-1/2 right-3 transform -translate-y-1/2 flex space-x-2">
                  <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M4 4C2.89543 4 2 4.89543 2 6V18C2 19.1046 2.89543 20 4 20H20C21.1046 20 22 19.1046 22 18V6C22 4.89543 21.1046 4 20 4H4Z"/></svg>
                  <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M2.5 3H21.5L12 18L2.5 3Z"/></svg>
                </div>
              </div>
            </div>
            
            <div class="grid grid-cols-2 gap-6">
              <div>
                <label for="expiryDate" class="block text-sm font-medium text-gray-700 mb-1">Expiry Date (MM/YY)</label>
                <input type="text" id="expiryDate" name="expiryDate" placeholder="MM/YY" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
              </div>
              
              <div>
                <label for="cvv" class="block text-sm font-medium text-gray-700 mb-1">CVV</label>
                <input type="text" id="cvv" name="cvv" placeholder="***" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Back to Cart -->
        <div class="mb-6">
          <a href="{{ route('cart') }}" class="text-blue-600 hover:underline flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Return to Cart
          </a>
        </div>
      </form>
    </div>

    <!-- Order Summary (4 columns on large screens) -->
    <div class="lg:col-span-4">
      <div class="bg-white rounded-lg shadow-sm p-6 sticky top-6">
        <h2 class="text-lg font-semibold mb-6">Order Summary</h2>
        
        <div class="space-y-4 mb-6">
          <!-- Order Items Summary -->
          <div class="space-y-3 mb-4">
            @foreach($cartItems as $item)
            <div class="flex justify-between items-center">
              <div class="flex items-center">
                <div class="w-12 h-12 flex-shrink-0 overflow-hidden rounded-md">
                  @if($item->product->image)
                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                  @elseif($item->product->image_path)
                    <img src="{{ asset('storage/' . $item->product->image_path) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                  @else
                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                      <span class="text-xs text-gray-500">No Image</span>
                    </div>
                  @endif
                </div>
                <div class="ml-3">
                  <p class="text-sm font-medium">{{ $item->product->name }}</p>
                  <p class="text-xs text-gray-500">Qty: {{ $item->quantity }}</p>
                </div>
              </div>
              <p class="text-sm font-medium">${{ number_format($item->product->price * $item->quantity, 2) }}</p>
            </div>
            @endforeach
          </div>
          
          <div class="border-t pt-4"></div>
          
          <!-- Price Calculations -->
          <div class="flex justify-between">
            @php
              $totalItems = $cartItems->sum('quantity');
            @endphp
            <p class="text-gray-600">Subtotal ({{ $totalItems }} {{ Str::plural('item', $totalItems) }})</p>
            <p class="font-medium">${{ number_format($subtotal, 2) }}</p>
          </div>
          <div class="flex justify-between">
            <p class="text-gray-600">Shipping</p>
            <p class="font-medium">Free</p>
          </div>
          <div class="border-t pt-4 flex justify-between">
            <p class="font-semibold">Total</p>
            <p class="font-semibold">${{ number_format($total, 2) }}</p>
          </div>
        </div>

        <button type="button" onclick="confirmOrder()" class="w-full bg-black text-white py-3 rounded-lg font-semibold hover:bg-gray-800 transition">
          PLACE ORDER
        </button>

        <div class="mt-6">
          <div class="flex items-center justify-center space-x-4 text-gray-500">
            <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M4 4C2.89543 4 2 4.89543 2 6V18C2 19.1046 2.89543 20 4 20H20C21.1046 20 22 19.1046 22 18V6C22 4.89543 21.1046 4 20 4H4Z"/></svg>
            <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M2.5 3H21.5L12 18L2.5 3Z"/></svg>
            <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M21 4H3C1.89 4 1 4.89 1 6V18C1 19.11 1.89 20 3 20H21C22.11 20 23 19.11 23 18V6C23 4.89 22.11 4 21 4Z"/></svg>
            <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M5 3H19C20.1046 3 21 3.89543 21 5V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V5C3 3.89543 3.89543 3 5 3Z"/></svg>
          </div>
          <p class="text-xs text-center mt-4 text-gray-500">
            Secure Payment Processing • All transactions are encrypted
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function confirmOrder() {
  if (confirm('Are you sure you want to place this order?')) {
    // Show loading state
    const btn = event.target;
    const form = document.getElementById('checkoutForm');
    
    // Validate form first
    if (!form.checkValidity()) {
      form.reportValidity();
      return;
    }
    
    btn.disabled = true;
    btn.textContent = 'Processing...';
    
    // Submit the form
    form.submit();
  }
}
</script>
@endsection