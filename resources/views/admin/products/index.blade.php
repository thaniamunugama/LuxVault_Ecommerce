@extends('admin.dashboard')

@section('admin-content')
@if(session('success'))
<div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4">
    <div class="flex">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
        </div>
        <div class="ml-3">
            <p class="text-sm text-green-700">{{ session('success') }}</p>
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4">
    <div class="flex">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>
        </div>
        <div class="ml-3">
            <p class="text-sm text-red-700">{{ session('error') }}</p>
        </div>
    </div>
</div>
@endif

<div class="mb-8">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">All Products</h2>
  </div>
  
  @if($products->count() > 0)
    <div class="overflow-x-auto rounded-lg shadow">
      <table class="min-w-full bg-white">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Image</th>
            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Product Name</th>
            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Brand</th>
            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Quantity</th>
            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Price</th>
            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($products as $product)
          <tr class="border-b hover:bg-gray-50">
            <td class="px-4 py-2">
              @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded" onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-16 h-16 bg-gray-200 rounded flex items-center justify-center\'><span class=\'text-gray-400 text-xs\'>No Image</span></div>';">
              @else
                <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                  <span class="text-gray-400 text-xs">No Image</span>
                </div>
              @endif
            </td>
            <td class="px-4 py-2">
              <div class="font-bold">{{ $product->name }}</div>
            </td>
            <td class="px-4 py-2">
              <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs font-medium">
                {{ $product->brand }}
              </span>
            </td>
            <td class="px-4 py-2">
              <span class="font-semibold">{{ $product->quantity }}</span>
            </td>
            <td class="px-4 py-2 text-green-600 font-semibold">${{ number_format($product->price, 2) }}</td>
            <td class="px-4 py-2">
              <form action="{{ route('admin.products.delete', $product->product_id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this product? This will remove it from the website and from the seller\'s product listings. This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs">Delete</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @else
    <div class="text-center py-12">
      <div class="max-w-sm mx-auto">
        <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
        <p class="text-gray-500">There are no products in the system.</p>
      </div>
    </div>
  @endif
</div>
@endsection
