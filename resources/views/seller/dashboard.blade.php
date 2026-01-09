
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Luxe Vault - Seller Dashboard</title>
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
    ['name' => 'Orders', 'route' => 'seller.orders'],
    ['name' => 'Product Listings', 'route' => 'seller.listings'],
    ['name' => 'Add New Product', 'route' => 'seller.listings.create'],
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
        @php $seller = Auth::guard('seller')->user(); @endphp
        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-700 font-semibold text-sm">
          {{ $seller ? strtoupper(substr($seller->fname ?? '', 0, 1) . substr($seller->lname ?? '', 0, 1)) : 'SE' }}
        </div>
        <div class="ml-3">
          <a href="{{ route('seller.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-sm text-gray-500 hover:text-gray-700">Sign Out</a>
          <form id="logout-form" action="{{ route('seller.logout') }}" method="POST" class="hidden">
            @csrf
          </form>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Main Content -->
  <div class="flex-1 p-8">
    <div class="max-w-7xl mx-auto">
      <div class="bg-white rounded-xl shadow-lg p-8">
        @yield('seller-content')
      </div>
    </div>
  </div>
</div>

</body>
</html>
