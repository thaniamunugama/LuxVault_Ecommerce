@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
  <!-- Breadcrumbs -->
  <div class="text-sm text-gray-500 mb-8">
    <a href="{{ route('home') }}" class="hover:underline">Home</a> / 
    <a href="{{ route('products') }}" class="hover:underline">Products</a> / 
    <span>{{ $product->name ?? $product->product_name }}</span>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
    <!-- Product Images - Left Side -->
    <div class="space-y-4">
      <div class="bg-gray-100 rounded-lg overflow-hidden aspect-square">
        @if($product->image)
          <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name ?? $product->product_name }}" class="w-full h-full object-cover" id="mainImage" onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full bg-gray-200 flex items-center justify-center\'><span class=\'text-gray-500\'>No Image</span></div>';">
        @else
          <div class="w-full h-full bg-gray-200 flex items-center justify-center">
            <span class="text-gray-500">No Image</span>
          </div>
        @endif
      </div>
    </div>

    <!-- Product Details - Right Side -->
    <div class="flex flex-col">
      <div class="mb-6">
        <span class="text-xl font-light text-gray-500">{{ $product->brand_name ?? $product->brand }}</span>
        <h1 class="text-3xl font-bold mt-2 mb-4">{{ $product->name ?? $product->product_name }}</h1>
        <div class="text-2xl font-semibold mb-6">${{ number_format($product->price, 2) }}</div>
      </div>

      <div class="border-t border-gray-200 py-6 flex-grow">
        <h2 class="font-medium text-lg mb-3">Description</h2>
        <p class="text-gray-600 mb-4 leading-relaxed">
          @if($product->description)
            {{ $product->description }}
          @else
            <span class="text-gray-400 italic">No description available for this product.</span>
          @endif
        </p>
      </div>

      <!-- Quantity and Add to Cart - Bottom Right -->
      <div class="border-t border-gray-200 py-6 mt-auto">
        <div class="mb-6">
          @if($product->quantity > 0)
            <p class="text-sm mb-2">
              <span class="text-green-600 font-medium">In Stock:</span> 
              <span class="font-bold">{{ $product->quantity }}</span> available
            </p>
          @else
            <p class="text-sm mb-2 text-red-600 font-medium">Out of Stock</p>
          @endif
        </div>
        
        <div class="flex flex-col space-y-4">
          <div class="flex space-x-4">
            @if($product->quantity > 0)
              <form method="POST" action="{{ route('cart.add') }}" class="flex space-x-4 w-full" id="cartForm">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                <input type="number" name="quantity" min="1" max="{{ $product->quantity }}" value="1" id="quantity" 
                       class="px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black w-24 text-center font-medium" 
                       placeholder="Qty">
                <button type="submit" class="flex-1 bg-black text-white py-3 px-8 rounded-lg font-bold hover:bg-gray-800 transition text-lg" id="addToCartBtn">
                  ADD TO CART
                </button>
              </form>
            @else
              <input type="number" value="0" disabled 
                     class="px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 text-gray-500 w-24 text-center" 
                     placeholder="0">
              <button class="flex-1 bg-gray-400 text-white py-3 px-8 rounded-lg font-bold cursor-not-allowed text-lg" disabled>
                SOLD OUT
              </button>
            @endif
          </div>
          
          @if($product->quantity > 0)
            <p class="text-sm text-gray-600">{{ $product->quantity }} item(s) available</p>
            <p id="notAvailableMessage" class="text-red-600 font-medium hidden">Quantity exceeds available stock</p>
          @else
            <p class="text-sm text-red-600">This item is currently out of stock</p>
          @endif
        </div>
      </div>
    </div>

      <script>
        document.addEventListener('DOMContentLoaded', function() {
          const quantityInput = document.getElementById('quantity');
          const notAvailableMessage = document.getElementById('notAvailableMessage');
          const addToCartBtn = document.getElementById('addToCartBtn');
          const maxQuantity = {{ $product->quantity ?? 0 }};
          
          if (quantityInput && notAvailableMessage) {
            quantityInput.addEventListener('input', function() {
              const requestedQty = parseInt(this.value);
              
              if (requestedQty > maxQuantity) {
                notAvailableMessage.classList.remove('hidden');
                if (addToCartBtn) {
                  addToCartBtn.disabled = true;
                  addToCartBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
                  addToCartBtn.classList.remove('bg-black', 'hover:bg-gray-800');
                }
              } else {
                notAvailableMessage.classList.add('hidden');
                if (addToCartBtn) {
                  addToCartBtn.disabled = false;
                  addToCartBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
                  addToCartBtn.classList.add('bg-black', 'hover:bg-gray-800');
                }
              }
            });
          }
          
          const cartForm = document.getElementById('cartForm');
          
          if (cartForm && addToCartBtn) {
            cartForm.addEventListener('submit', function(e) {
              e.preventDefault(); // Prevent default form submission
              
              const quantity = parseInt(quantityInput.value);
              console.log('Adding to cart:', {
                product_id: {{ $product->product_id }},
                quantity: quantity,
                url: '{{ route("cart.add") }}',
                csrf: '{{ csrf_token() }}'
              });
              
              if (quantity > 0 && quantity <= maxQuantity) {
                // Try AJAX first
                fetch('{{ route("cart.add") }}', {
                  method: 'POST',
                  headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                  },
                  body: JSON.stringify({
                    product_id: {{ $product->product_id }},
                    quantity: quantity
                  })
                })
                .then(response => {
                  console.log('Response status:', response.status);
                  
                  // Handle authentication errors
                  if (response.status === 401) {
                    return response.json().then(data => {
                      // Show login modal
                      if (typeof openLoginModal === 'function') {
                        openLoginModal('customer');
                      } else {
                        // Fallback: trigger modal via event or redirect
                        window.location.href = '{{ route("home") }}?open_modal=login&active_tab=customer';
                      }
                      throw new Error(data.message || 'Please log in to add items to cart.');
                    });
                  }
                  
                  if (!response.ok) {
                    return response.json().then(data => {
                      throw new Error(data.message || 'Network response was not ok');
                    });
                  }
                  return response.json();
                })
                .then(data => {
                  console.log('Response data:', data);
                  if (data && data.success) {
                    alert('Item added to cart!');
                    // Optional: Redirect to cart
                    // window.location.href = '{{ route("cart") }}';
                  } else {
                    alert(data.message || 'Error adding item to cart.');
                  }
                })
                .catch(error => {
                  console.error('AJAX error:', error);
                  // If it's not a login error, try form submission
                  if (!error.message || !error.message.includes('log in')) {
                    // Submit the form normally as fallback, but prevent default was already called
                    // So we need to manually submit
                    const formData = new FormData(cartForm);
                    fetch(cartForm.action, {
                      method: 'POST',
                      body: formData,
                      headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                      }
                    }).catch(() => {
                      // If that also fails, just show an error
                      alert('Failed to add item to cart. Please try again.');
                    });
                  }
                });
              } else {
                alert('Please enter a valid quantity');
              }
            });
          }
        });
      </script>
    </div>
  </div>

  <!-- Related Products -->
  <div class="mt-16">
    <h2 class="text-2xl font-bold mb-6">You May Also Like</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
      <div class="group">
        <a href="#" class="block">
          <div class="bg-gray-100 rounded-lg overflow-hidden aspect-square">
            <img src="{{ asset('images/chanel_1.png') }}" alt="Chanel Classic Flap" class="w-full h-full object-cover">
          </div>
          <div class="mt-3">
            <h3 class="font-semibold text-lg">Classic Flap Bag</h3>
            <p class="text-gray-600">Chanel</p>
            <p class="font-semibold mt-1">$8,200</p>
          </div>
        </a>
        <button class="w-full mt-3 py-2 bg-black text-white font-semibold rounded hover:bg-gray-800 hover:scale-105 transition-all duration-200">Add to Cart</button>
      </div>

      <div class="group">
        <a href="#" class="block">
          <div class="bg-gray-100 rounded-lg overflow-hidden aspect-square">
            <img src="{{ asset('images/ysl.png') }}" alt="YSL Bag" class="w-full h-full object-cover">
          </div>
          <div class="mt-3">
            <h3 class="font-semibold text-lg">Envelope Chain Wallet</h3>
            <p class="text-gray-600">YSL</p>
            <p class="font-semibold mt-1">$1,750</p>
          </div>
        </a>
        <button class="w-full mt-3 py-2 bg-black text-white font-semibold rounded hover:bg-gray-800 hover:scale-105 transition-all duration-200">Add to Cart</button>
      </div>

      <div class="group">
        <a href="#" class="block">
          <div class="bg-gray-100 rounded-lg overflow-hidden aspect-square">
            <img src="{{ asset('images/coach_1.png') }}" alt="Coach Tabby" class="w-full h-full object-cover">
          </div>
          <div class="mt-3">
            <h3 class="font-semibold text-lg">Tabby Shoulder Bag</h3>
            <p class="text-gray-600">Coach</p>
            <p class="font-semibold mt-1">$450</p>
          </div>
        </a>
        <button class="w-full mt-3 py-2 bg-black text-white font-semibold rounded hover:bg-gray-800 hover:scale-105 transition-all duration-200">Add to Cart</button>
      </div>

    </div>
  </div>
</div>
@endsection