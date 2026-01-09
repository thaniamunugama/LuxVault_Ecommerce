@extends('layouts.app')

@section('content')
  {{-- HERO --}}
  <section class="relative">
    {{-- if you keep the space in filename, encode it as %20 --}}
    <img src="{{ asset('images/home-banner%201.png') }}" class="w-full h-[480px] md:h-[620px] object-cover" alt="Luxe Vault Hero">
    <div class="absolute inset-0 bg-black/30"></div>
    <div class="absolute inset-0 flex items-center">
      <div class="mx-auto max-w-4xl px-6 text-center text-white">
        <h1 class="text-3xl md:text-5xl font-bold tracking-tight" style="font-family: 'Playfair Display', serif; font-weight: 700;">Timeless Luxury, Curated for You</h1>
        <p class="mt-4 leading-relaxed font-bold" style="font-family: 'Cormorant Garamond', serif; font-size: 1.2rem;">
          Discover iconic designer handbags authenticated, insured, and ready to ship.</p>
        <a href="{{ route('products') }}" class="inline-block mt-16 px-8 py-3 bg-white text-black font-semibold rounded-md hover:bg-gray-100 hover:scale-105 transition-all duration-300" style="font-family: 'Abhaya Libre', serif;">VIEW SELECTION</a>
      </div>
    </div>
  </section>


    {{-- BRAND LOGOS ROW --}}
    <section id="brands" class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
    @php
        $brands = [
        ['name' => 'Chanel', 'logo' => 'chanel.png', 'slug' => 'chanel'],
        ['name' => 'Birkin (Hermès)', 'logo' => 'hermes.png', 'slug' => 'birkin'],
        ['name' => 'YSL', 'logo' => 'ysl.png', 'slug' => 'ysl'],
        ['name' => 'Coach', 'logo' => 'coach.png', 'slug' => 'coach'],
        ];
    @endphp

    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-10 justify-items-center max-w-6xl mx-auto">
    @foreach($brands as $b)
        <div class="space-y-4 text-center group w-full max-w-[380px]">
        {{-- Logo Box (Black circle with hover animation) --}}
        <div class="w-full aspect-square rounded-full bg-black flex items-center justify-center border group-hover:shadow-lg transition duration-300">
            <img
            src="{{ asset('images/'.$b['logo']) }}"
            alt="{{ $b['name'] }} logo"
            class="max-h-28 md:max-h-32 group-hover:scale-110 transition-transform duration-300 object-contain"
            >
        </div>

        {{-- Brand Button (black bg, white text, smooth hover) --}}
        <a href="{{ url('/brands/'.$b['slug']) }}"
            class="w-full text-sm md:text-base tracking-wide py-3 px-5 rounded-2xl inline-block
                    bg-black text-white transition-all duration-300 ease-in-out hover:scale-105 hover:bg-gray-900">
            {{ $b['name'] }}
        </a>
        </div>
    @endforeach
    </div>
    </section>


  {{-- BEST SELLERS --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
    <h2 class="text-xl font-semibold tracking-wide mb-6">BEST SELLERS</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        @forelse($bestSellers as $product)
        <div class="space-y-3 text-center group">
            <a href="{{ route('product.detail', $product->product_id) }}" class="block">
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
                <div class="mt-3">
                    <p class="text-sm text-gray-500">{{ $product->brand }}</p>
                    <p class="text-base font-medium">{{ Str::limit($product->name, 30) }}</p>
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
        <div class="col-span-full text-center py-8">
            <p class="text-gray-500">No best sellers yet. Check back soon!</p>
        </div>
        @endforelse
    </div>
    </section>

    {{-- NEW ARRIVALS --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
    <h2 class="text-xl font-semibold tracking-wide mb-6">NEW ARRIVALS</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        @forelse($newProducts as $product)
        <div class="space-y-3 text-center group">
            <a href="{{ route('product.detail', $product->product_id) }}" class="block">
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
                <div class="mt-3">
                    <p class="text-sm text-gray-500">{{ $product->brand }}</p>
                    <p class="text-base font-medium">{{ Str::limit($product->name, 30) }}</p>
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
        <div class="col-span-full text-center py-8">
            <p class="text-gray-500">No new products yet. Check back soon!</p>
        </div>
        @endforelse
    </div>
    </section>



  {{-- BIG BANNER --}}
  <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-16">
    <img src="{{ asset('images/home-banner%202.png') }}" class="w-full rounded-2xl object-cover" alt="Collection Banner">
  </section>
@endsection
