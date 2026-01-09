@extends('seller.dashboard')

@section('seller-content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start px-4">
  
  <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm" class="contents">
    @csrf
    
    {{-- Image upload (square) --}}
    <div class="order-1 lg:order-1">
      <label class="w-full bg-gray-200 rounded-2xl border border-gray-300 cursor-pointer flex items-center justify-center hover:bg-gray-100 overflow-hidden aspect-square relative" for="productImage">
        <input type="file" accept="image/*" class="hidden" name="image" id="productImage" required />
        <img src="{{ asset('images/addimg.png') }}" alt="Add" class="h-16 w-16 opacity-70" id="placeholderImage">
        <img id="previewImage" class="w-full h-full object-cover hidden" alt="Preview">
      </label>
      @error('image')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    {{-- Form fields on the right --}}
    <div class="space-y-8 order-2 lg:order-2">
      
      {{-- Product Name --}}
      <div>
        <input type="text" name="name" placeholder="ENTER PRODUCT NAME" value="{{ old('name') }}" 
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
            <input type="radio" name="brand_name" value="Chanel" class="mr-2 text-black focus:ring-black" {{ old('brand_name') == 'Chanel' ? 'checked' : '' }} required>
            <span class="text-base font-medium">Chanel</span>
          </label>
          <label class="flex items-center">
            <input type="radio" name="brand_name" value="Hermes" class="mr-2 text-black focus:ring-black" {{ old('brand_name') == 'Hermes' ? 'checked' : '' }}>
            <span class="text-base font-medium">Hermès</span>
          </label>
          <label class="flex items-center">
            <input type="radio" name="brand_name" value="YSL" class="mr-2 text-black focus:ring-black" {{ old('brand_name') == 'YSL' ? 'checked' : '' }}>
            <span class="text-base font-medium">YSL</span>
          </label>
          <label class="flex items-center">
            <input type="radio" name="brand_name" value="Coach" class="mr-2 text-black focus:ring-black" {{ old('brand_name') == 'Coach' ? 'checked' : '' }}>
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
                  class="w-full bg-gray-200 rounded-xl px-6 py-5 text-lg font-semibold placeholder-gray-700 focus:outline-none focus:ring-2 focus:ring-black" required>{{ old('description') }}</textarea>
        @error('description')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>
      
      {{-- Price --}}
      <div class="relative">
        <div class="absolute left-0 top-0 bottom-0 flex items-center pl-6">
          <span class="text-2xl font-semibold text-gray-700">$</span>
        </div>
        <input type="number" step="0.01" name="price" placeholder="ENTER PRICE" value="{{ old('price') }}" 
               class="w-full bg-gray-200 rounded-xl pl-12 pr-6 py-5 text-lg font-semibold placeholder-gray-700 focus:outline-none focus:ring-2 focus:ring-black" required>
        @error('price')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Quantity --}}
      <div>
        <input type="number" min="1" name="quantity" placeholder="ENTER QUANTITY" value="{{ old('quantity', 1) }}" 
               class="w-full bg-gray-200 rounded-xl px-6 py-5 text-lg font-semibold placeholder-gray-700 focus:outline-none focus:ring-2 focus:ring-black" required>
        @error('quantity')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Action Buttons --}}
      {{-- Status Message --}}
      @if(session('success'))
      <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
        {{ session('success') }}
      </div>
      @endif

      @if(session('error'))
      <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
        {{ session('error') }}
      </div>
      @endif

      @if($errors->any())
      <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
        <ul class="list-disc list-inside">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <div class="flex flex-col sm:flex-row gap-4 mt-8">
        <a href="{{ route('seller.listings') }}" class="flex-1 py-3 bg-gray-600 text-white rounded text-center font-bold transition hover:bg-gray-700 hover:shadow-md">DISCARD LISTING</a>
        <button type="submit" class="flex-1 py-3 bg-black text-white rounded font-bold transition hover:bg-gray-800 hover:shadow-md">ADD LISTING</button>
      </div>
    </div>
  </form>
</div>

{{-- Success Modal --}}
<div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden" style="display: none;">
  <div class="flex items-center justify-center min-h-screen px-4">
    <div class="bg-white rounded-lg p-8 max-w-md w-full">
      <div class="text-center">
      <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
      </div>
      <h3 class="text-lg font-medium text-gray-900 mb-2">Product Added Successfully!</h3>
      <p class="text-sm text-gray-500 mb-4">Your product has been added to your listings.</p>
      <div class="flex gap-3">
        <button onclick="closeModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
          Add Another
        </button>
        <a href="{{ route('seller.listings') }}" class="flex-1 bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded text-center">
          View Listings
        </a>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const imageInput = document.getElementById('productImage');
  const previewImage = document.getElementById('previewImage');
  const placeholderImage = document.getElementById('placeholderImage');
  
  imageInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        previewImage.src = e.target.result;
        previewImage.classList.remove('hidden');
        placeholderImage.classList.add('hidden');
      };
      reader.readAsDataURL(file);
    }
  });
});

// Show success modal if there's a success message
@if(session('success'))
  document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('successModal');
    modal.classList.remove('hidden');
    modal.style.display = 'flex';
    // Reset form on success
    document.getElementById('productForm').reset();
    document.getElementById('previewImage').classList.add('hidden');
    document.getElementById('placeholderImage').classList.remove('hidden');
  });
@endif

function closeModal() {
  const modal = document.getElementById('successModal');
  modal.classList.add('hidden');
  modal.style.display = 'none';
}
</script>

@endsection
