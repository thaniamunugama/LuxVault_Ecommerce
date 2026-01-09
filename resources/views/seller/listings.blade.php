@extends('seller.dashboard')

@section('seller-content')
<div class="mb-8">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">My Products</h2>
    <a href="{{ route('seller.listings.add') }}" class="bg-black text-white px-6 py-2 rounded font-bold hover:bg-gray-800 transition">
      Add New Product
    </a>
  </div>
  
  @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
      {{ session('success') }}
    </div>
  @endif

  @if($products->count() > 0)
    <div class="overflow-x-auto rounded-lg shadow">
      <table class="min-w-full bg-white">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Image</th>
            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Product</th>
            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Brand</th>
            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Price</th>
            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($products as $product)
          <tr class="border-b hover:bg-gray-50">
            <td class="px-4 py-2">
              @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name ?? $product->product_name }}" class="w-16 h-16 object-cover rounded" onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-16 h-16 bg-gray-200 rounded flex items-center justify-center\'><span class=\'text-gray-400 text-xs\'>No Image</span></div>';">
              @else
                <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                  <span class="text-gray-400 text-xs">No Image</span>
                </div>
              @endif
            </td>
            <td class="px-4 py-2">
              <div class="font-bold">{{ $product->name ?? $product->product_name }}</div>
              @if($product->description)
                <div class="text-sm text-gray-500">{{ Str::limit($product->description, 50) }}</div>
              @endif
            </td>
            <td class="px-4 py-2">
              <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs font-medium">
                {{ $product->brand_name ?? $product->brand }}
              </span>
            </td>
            <td class="px-4 py-2 text-green-600 font-semibold">${{ number_format($product->price, 2) }}</td>
            <td class="px-4 py-2">
              <div class="flex space-x-2">
                <a href="{{ route('seller.products.edit', $product->product_id) }}" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs">Edit</a>
                
                <form action="{{ route('seller.products.destroy', $product->product_id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs">Delete</button>
                </form>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @else
    <div class="text-center py-12">
      <div class="max-w-sm mx-auto">
        <img src="{{ asset('images/addimg.png') }}" alt="No products" class="w-24 h-24 mx-auto mb-4 opacity-50">
        <h3 class="text-lg font-medium text-gray-900 mb-2">No products yet</h3>
        <p class="text-gray-500 mb-6">Start by adding your first luxury item to your store.</p>
        <a href="{{ route('seller.listings.add') }}" class="bg-black text-white px-6 py-3 rounded font-bold hover:bg-gray-800 transition">
          Add Your First Product
        </a>
      </div>
    </div>
  @endif
</div>
@endsection
