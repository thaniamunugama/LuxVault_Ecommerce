@extends('seller.layouts.app')

@section('title', 'Product Listings')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">My Products</h1>
        </div>
        <a href="{{ route('seller.listings.add') }}" class="inline-flex items-center px-6 py-3 bg-black text-white font-bold rounded-md hover:bg-gray-800">
            Add New Product
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- All Products Section -->
    <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
        <h2 class="text-xl font-semibold mb-6">All Products</h2>

        @if($products->count() > 0)
            <div class="overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Image</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Brand</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Product Name</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Quantity</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Price</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($products as $product)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="w-20 h-20">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded">
                                        @else
                                            <div class="w-full h-full bg-gray-200 flex items-center justify-center rounded">
                                                <span class="text-xs text-gray-500">No image</span>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-sm rounded-lg bg-gray-100 text-gray-800">
                                        {{ $product->brand }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $product->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $product->quantity }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-green-600">${{ number_format($product->price, 2) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex gap-2">
                                        <a href="{{ route('seller.products.edit', $product->product_id) }}" 
                                           class="inline-flex justify-center px-4 py-2 bg-blue-600 text-white text-sm rounded-md font-medium hover:bg-blue-700">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('seller.products.destroy', $product->product_id) }}" 
                                              onsubmit="return confirm('Are you sure you want to delete this product?')" 
                                              class="inline-flex">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="px-4 py-2 bg-red-600 text-white text-sm rounded-md font-medium hover:bg-red-700">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-white text-center py-8">
                <div class="py-12 text-center">
                    <div class="max-w-sm mx-auto">
                        <img src="{{ asset('images/addimg.png') }}" alt="No products" class="w-24 h-24 mx-auto mb-4 opacity-50">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No products yet</h3>
                        <p class="text-gray-500 mb-6">Start by adding your first luxury item to your store.</p>
                        <a href="{{ route('seller.listings.add') }}" class="inline-flex items-center px-6 py-3 bg-black text-white font-bold rounded hover:bg-gray-800">
                            Add Your First Product
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection