@extends('seller.dashboard')

@section('seller-content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start px-4">
  
  <form action="{{ route('seller.products.update', $product->product_id) }}" method="POST" enctype="multipart/form-data" id="productForm" class="contents">
    @csrf
    @method('PUT')
    
    {{-- Image upload (square) --}}
    <div class="order-1 lg:order-1">
      <label class="w-full bg-gray-200 rounded-2xl border border-gray-300 cursor-pointer flex items-center justify-center hover:bg-gray-100 overflow-hidden aspect-square relative" for="productImage">
        <input type="file" accept="image/*" class="hidden" name="image" id="productImage" />
        {{-- Check for all possible image paths --}}
        @if($product->image)
          <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover" id="currentImage" alt="{{ $product->name }}">
        @elseif($product->image_path)
          <img src="{{ asset('storage/' . $product->image_path) }}" class="w-full h-full object-cover" id="currentImage" alt="{{ $product->name }}">
        @elseif($product->images && $product->images->where('is_primary', true)->first())
          <img src="{{ asset('storage/' . $product->images->where('is_primary', true)->first()->path) }}" class="w-full h-full object-cover" id="currentImage" alt="{{ $product->name }}">
        @else
          <img src="{{ asset('images/addimg.png') }}" alt="Add" class="h-16 w-16 opacity-70" id="placeholderImage">
        @endif
        <img id="previewImage" class="w-full h-full object-cover hidden absolute inset-0" alt="Preview">
      </label>
      @error('image')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
      @enderror
      <p class="text-sm text-gray-500 mt-2 text-center">Click to change image</p>
    </div>

    {{-- Form fields on the right --}}
    <div class="space-y-8 order-2 lg:order-2">
      
      {{-- Product Name --}}
      <div>
        <input type="text" name="name" placeholder="ENTER PRODUCT NAME" value="{{ old('name', $product->name) }}" 
               class="w-full bg-gray-200 rounded-xl px-6 py-5 text-lg font-semibold placeholder-gray-700 focus:outline-none focus:ring-2 focus:ring-black" required>
        @error('name')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>
      
      {{-- Brand Selection - Horizontal layout --}}
      <div>
        <p class="text-lg font-semibold text-gray-700 mb-4">SELECT BRAND</p>
        <div class="flex flex-wrap gap-4">
          <label class="flex items-center">
            <input type="radio" name="brand_name" value="Chanel" class="mr-2 text-black focus:ring-black" {{ old('brand_name', $product->brand) == 'Chanel' ? 'checked' : '' }} required>
            <span class="text-base font-medium">Chanel</span>
          </label>
          <label class="flex items-center">
            <input type="radio" name="brand_name" value="Hermes" class="mr-2 text-black focus:ring-black" {{ old('brand_name', $product->brand) == 'Hermes' ? 'checked' : '' }}>
            <span class="text-base font-medium">Hermès</span>
          </label>
          <label class="flex items-center">
            <input type="radio" name="brand_name" value="YSL" class="mr-2 text-black focus:ring-black" {{ old('brand_name', $product->brand) == 'YSL' ? 'checked' : '' }}>
            <span class="text-base font-medium">YSL</span>
          </label>
          <label class="flex items-center">
            <input type="radio" name="brand_name" value="Coach" class="mr-2 text-black focus:ring-black" {{ old('brand_name', $product->brand) == 'Coach' ? 'checked' : '' }}>
            <span class="text-base font-medium">Coach</span>
          </label>
        </div>
        @error('brand_name')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>
      
      {{-- Product Description --}}
      <div>
        <textarea rows="6" name="description" placeholder="ENTER PRODUCT DESCRIPTION" 
                  class="w-full bg-gray-200 rounded-xl px-6 py-5 text-lg font-semibold placeholder-gray-700 focus:outline-none focus:ring-2 focus:ring-black" required>{{ old('description', $product->description) }}</textarea>
        @error('description')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>
      
      {{-- Price --}}
      <div class="relative">
        <div class="absolute left-0 top-0 bottom-0 flex items-center pl-6">
          <span class="text-2xl font-semibold text-gray-700">$</span>
        </div>
        <input type="number" step="0.01" name="price" placeholder="ENTER PRICE" value="{{ old('price', $product->price) }}" 
               class="w-full bg-gray-200 rounded-xl pl-12 pr-6 py-5 text-lg font-semibold placeholder-gray-700 focus:outline-none focus:ring-2 focus:ring-black" required>
        @error('price')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Quantity --}}
      <div>
        <input type="number" min="0" name="quantity" placeholder="ENTER QUANTITY" value="{{ old('quantity', $product->quantity) }}" 
               class="w-full bg-gray-200 rounded-xl px-6 py-5 text-lg font-semibold placeholder-gray-700 focus:outline-none focus:ring-2 focus:ring-black" required>
        @error('quantity')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Action Buttons --}}
      <div class="flex flex-col sm:flex-row gap-4 mt-8">
        <a href="{{ route('seller.listings') }}" class="flex-1 py-3 bg-gray-600 text-white rounded text-center font-bold transition hover:bg-gray-700 hover:shadow-md">CANCEL</a>
        <button type="submit" class="flex-1 py-3 bg-black text-white rounded font-bold transition hover:bg-gray-800 hover:shadow-md">UPDATE LISTING</button>
      </div>
    </div>
  </form>
</div>

<script>
  // Image preview functionality
  document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('productImage');
    const previewImage = document.getElementById('previewImage');
    const currentImage = document.getElementById('currentImage');
    const placeholderImage = document.getElementById('placeholderImage');
    
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
          if (placeholderImage) {
            placeholderImage.classList.add('hidden');
          }
        };
        reader.readAsDataURL(file);
      }
    });
  });
</script>
@endsection