@extends('seller.layouts.app')

@section('title', 'Add New Product')

@section('content')
<div class="space-y-6">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Add New Product</h1>
            <p class="text-gray-600 mt-2">Create a new product listing for your store</p>
        </div>

        <!-- Form -->
        <div class="bg-white shadow rounded-lg">
            <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data" class="p-6">
                @csrf
                
                <!-- Product Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Product Name</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea id="description" 
                              name="description" 
                              rows="4" 
                              required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price and Quantity -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price ($)</label>
                        <input type="number" 
                               id="price" 
                               name="price" 
                               value="{{ old('price') }}"
                               step="0.01"
                               min="0"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('price') border-red-500 @enderror">
                        @error('price')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                        <input type="number" 
                               id="quantity" 
                               name="quantity" 
                               value="{{ old('quantity') }}"
                               min="0"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('quantity') border-red-500 @enderror">
                        @error('quantity')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Brand and Category -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="brand_name" class="block text-sm font-medium text-gray-700 mb-2">Brand Name</label>
                        <input type="text" 
                               id="brand_name" 
                               name="brand_name" 
                               value="{{ old('brand_name') }}"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('brand_name') border-red-500 @enderror">
                        @error('brand_name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <select id="category" 
                                name="category" 
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('category') border-red-500 @enderror">
                            <option value="">Select a category</option>
                            <option value="Electronics" {{ old('category') === 'Electronics' ? 'selected' : '' }}>Electronics</option>
                            <option value="Clothing" {{ old('category') === 'Clothing' ? 'selected' : '' }}>Clothing</option>
                            <option value="Accessories" {{ old('category') === 'Accessories' ? 'selected' : '' }}>Accessories</option>
                            <option value="Home & Garden" {{ old('category') === 'Home & Garden' ? 'selected' : '' }}>Home & Garden</option>
                            <option value="Sports" {{ old('category') === 'Sports' ? 'selected' : '' }}>Sports</option>
                            <option value="Books" {{ old('category') === 'Books' ? 'selected' : '' }}>Books</option>
                            <option value="Beauty" {{ old('category') === 'Beauty' ? 'selected' : '' }}>Beauty</option>
                            <option value="Toys" {{ old('category') === 'Toys' ? 'selected' : '' }}>Toys</option>
                            <option value="Other" {{ old('category') === 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('category')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Product Image -->
                <div class="mb-6">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Product Image</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Upload a file</span>
                                    <input id="image" name="image" type="file" accept="image/*" class="sr-only">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                        </div>
                    </div>
                    @error('image')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('seller.products') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Create Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Image preview functionality
document.getElementById('image').addEventListener('change', function(e) {
    if (e.target.files && e.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // You can add preview functionality here if needed
        };
        reader.readAsDataURL(e.target.files[0]);
    }
});
</script>
@endsection