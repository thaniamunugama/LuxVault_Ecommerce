@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
  <h1 class="text-3xl font-bold mb-8">Shopping Cart</h1>

  <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <!-- Cart Items (8 columns on large screens) -->
    <div class="lg:col-span-8">
      <div class="bg-white rounded-lg shadow-sm mb-6">
        <!-- Cart Header -->
        <div class="border-b px-6 py-4">
          <h2 class="text-lg font-semibold">Your Cart ({{ count($cartItems) }} {{ Str::plural('item', count($cartItems)) }})</h2>
        </div>

        @if(count($cartItems) > 0)
        <!-- Cart Items (Livewire Components) -->
        <div class="divide-y">
          @foreach($cartItems as $item)
            @livewire('cart-item', ['cartItem' => $item], key('cart-item-'.$item->cart_id))
          @endforeach
        </div>

        <!-- Continue Shopping & Clear Cart -->
        <div class="border-t px-6 py-4 flex justify-between items-center">
          <a href="{{ route('products') }}" class="text-blue-600 hover:underline flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Continue Shopping
          </a>
          <form action="{{ route('cart.clear') }}" method="POST">
            @csrf
            <button type="submit" class="text-gray-500 text-sm hover:underline">Clear Cart</button>
          </form>
        </div>
        @else
        <div class="p-8 text-center">
          <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
          </svg>
          <p class="mt-4 text-lg text-gray-500">Your cart is empty</p>
          <a href="{{ route('products') }}" class="mt-4 inline-block px-6 py-2 bg-black text-white rounded-md hover:bg-gray-800 transition">
            Continue Shopping
          </a>
        </div>
        @endif
      </div>
    </div>

    <!-- Order Summary (Livewire Component - Updates in Real-time) -->
    <div class="lg:col-span-4">
      @livewire('cart-summary')
    </div>
  </div>
</div>

@endsection