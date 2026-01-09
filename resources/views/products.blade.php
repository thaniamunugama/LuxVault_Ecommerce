@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
  {{-- Brand Quick Links --}}
  <div class="flex flex-wrap gap-2 mb-6 justify-center">
    <a href="{{ route('products') }}" class="px-4 py-2 bg-black text-white rounded-2xl hover:bg-gray-800 hover:scale-105 transition-all duration-300">All</a>
    <a href="{{ route('brands.hermes') }}" class="px-4 py-2 bg-black text-white rounded-2xl hover:bg-gray-800 hover:scale-105 transition-all duration-300">Hermès</a>
    <a href="{{ route('brands.chanel') }}" class="px-4 py-2 bg-black text-white rounded-2xl hover:bg-gray-800 hover:scale-105 transition-all duration-300">Chanel</a>
    <a href="{{ route('brands.ysl') }}" class="px-4 py-2 bg-black text-white rounded-2xl hover:bg-gray-800 hover:scale-105 transition-all duration-300">YSL</a>
    <a href="{{ route('brands.coach') }}" class="px-4 py-2 bg-black text-white rounded-2xl hover:bg-gray-800 hover:scale-105 transition-all duration-300">Coach</a>
  </div>

  {{-- Livewire Product Filter Component --}}
  @livewire('product-filter')
</div>

<script>
function addToCartAjax(event, productId) {
  event.preventDefault();
  
  fetch('{{ route("cart.add") }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json'
    },
    body: JSON.stringify({
      product_id: productId,
      quantity: 1
    })
  })
  .then(response => {
    if (response.status === 401) {
      return response.json().then(data => {
        if (typeof openLoginModal === 'function') {
          openLoginModal('customer');
        } else {
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
    if (data && data.success) {
      alert('Item added to cart!');
    } else {
      if (data && data.login_required) {
        if (typeof openLoginModal === 'function') {
          openLoginModal('customer');
          alert(data.message || 'Please log in to add items to cart.');
        } else {
          window.location.href = '{{ route("home") }}?open_modal=login&active_tab=customer';
        }
      } else {
        alert(data.message || 'Error adding item to cart.');
      }
    }
  })
  .catch(error => {
    console.error('AJAX failed, submitting form normally:', error);
    event.target.closest('form').submit();
  });
}
</script>
@endsection
