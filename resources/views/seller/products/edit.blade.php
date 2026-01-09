@extends('seller.layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold">Edit Product</h1>
        <p class="text-gray-600 mt-1">Update your product details</p>
    </div>

    <!-- Edit Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" action="{{ route('seller.products.update', $product->product_id) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-2 md:col-span-1">
                    <!-- Product Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-black">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Product Brand -->
                    <div class="mb-4">
                        <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                        <input type="text" id="brand" value="{{ $product->brand }}" readonly
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100">
                    </div>
                    
                    <!-- Price -->
                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price ($)</label>
                        <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" min="0" step="0.01" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-black">
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Quantity -->
                    <div class="mb-4">
                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                        <input type="number" id="quantity" name="quantity" value="{{ old('quantity', $product->quantity) }}" min="0" step="1" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-black">
                        @error('quantity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="col-span-2 md:col-span-1">
                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Product Description</label>
                        <textarea id="description" name="description" rows="10" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-black">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Product Image -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-3">Product Image</label>
                        <div class="mb-3">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                                     class="w-full h-64 object-cover rounded-md border border-gray-200" id="currentImage">
                            @else
                                <div class="w-full h-64 flex items-center justify-center bg-gray-100 rounded-md border border-gray-200" id="noImagePlaceholder">
                                    <span class="text-gray-400">No image available</span>
                                </div>
                            @endif
                            <img id="previewImage" class="w-full h-64 object-cover rounded-md border border-gray-200 hidden" alt="Preview">
                        </div>
                        <label for="image" class="block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md cursor-pointer hover:bg-gray-200 text-center text-sm font-medium text-gray-700">
                            <input type="file" accept="image/*" name="image" id="image" class="hidden">
                            <span id="fileLabel">Change Image</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF up to 5MB</p>
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex justify-end space-x-3 border-t border-gray-200 pt-4">
                <a href="{{ route('seller.products') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Discard Edits
                </a>
                <button type="submit" class="px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-black">
                    Edit Listing
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image');
    const previewImage = document.getElementById('previewImage');
    const currentImage = document.getElementById('currentImage');
    const noImagePlaceholder = document.getElementById('noImagePlaceholder');
    const fileLabel = document.getElementById('fileLabel');
    
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.classList.remove('hidden');
                    if (currentImage) {
                        currentImage.classList.add('hidden');
                    }
                    if (noImagePlaceholder) {
                        noImagePlaceholder.classList.add('hidden');
                    }
                };
                reader.readAsDataURL(file);
                fileLabel.textContent = file.name || 'Change Image';
            }
        });
    }
});
</script>
@endsection