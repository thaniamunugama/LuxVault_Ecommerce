@extends('admin.dashboard')

@section('admin-content')
<div class="space-y-6">
  <div class="flex justify-between items-center">
    <h1 class="text-2xl font-bold">Brands Management</h1>
    <button class="bg-black text-white px-4 py-2 rounded font-medium hover:bg-gray-800">Add New Brand</button>
  </div>
  
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
      <div class="h-40 bg-gray-200 relative">
        <img src="{{ asset('images/hermes-b.png') }}" alt="Hermès" class="w-full h-full object-contain p-4">
        <div class="absolute top-3 right-3 flex space-x-2">
          <button class="bg-white p-2 rounded-full shadow hover:bg-gray-100">
            <img src="{{ asset('images/edit.png') }}" alt="Edit" class="w-5 h-5">
          </button>
          <button class="bg-white p-2 rounded-full shadow hover:bg-gray-100">
            <img src="{{ asset('images/delete.png') }}" alt="Delete" class="w-5 h-5">
          </button>
        </div>
      </div>
      <div class="p-5">
        <h3 class="text-xl font-bold mb-2">Hermès</h3>
        <p class="text-gray-500 text-sm mb-4">Founded in 1837, Hermès is a luxury brand specializing in leather goods, lifestyle accessories, home furnishings, perfumes, jewelry, and ready-to-wear clothing.</p>
        <div class="flex justify-between items-center">
          <span class="text-sm font-medium text-gray-500">24 products</span>
          <a href="#" class="text-sm font-medium text-black hover:underline">View Products</a>
        </div>
      </div>
    </div>
    
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
      <div class="h-40 bg-gray-200 relative">
        <img src="{{ asset('images/chanel-b.png') }}" alt="Chanel" class="w-full h-full object-contain p-4">
        <div class="absolute top-3 right-3 flex space-x-2">
          <button class="bg-white p-2 rounded-full shadow hover:bg-gray-100">
            <img src="{{ asset('images/edit.png') }}" alt="Edit" class="w-5 h-5">
          </button>
          <button class="bg-white p-2 rounded-full shadow hover:bg-gray-100">
            <img src="{{ asset('images/delete.png') }}" alt="Delete" class="w-5 h-5">
          </button>
        </div>
      </div>
      <div class="p-5">
        <h3 class="text-xl font-bold mb-2">Chanel</h3>
        <p class="text-gray-500 text-sm mb-4">Founded by Coco Chanel in 1910, Chanel is known for its timeless designs, little black dresses, No. 5 perfume, and iconic Chanel suit.</p>
        <div class="flex justify-between items-center">
          <span class="text-sm font-medium text-gray-500">32 products</span>
          <a href="#" class="text-sm font-medium text-black hover:underline">View Products</a>
        </div>
      </div>
    </div>
    
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
      <div class="h-40 bg-gray-200 relative">
        <img src="{{ asset('images/coach-b.png') }}" alt="Coach" class="w-full h-full object-contain p-4">
        <div class="absolute top-3 right-3 flex space-x-2">
          <button class="bg-white p-2 rounded-full shadow hover:bg-gray-100">
            <img src="{{ asset('images/edit.png') }}" alt="Edit" class="w-5 h-5">
          </button>
          <button class="bg-white p-2 rounded-full shadow hover:bg-gray-100">
            <img src="{{ asset('images/delete.png') }}" alt="Delete" class="w-5 h-5">
          </button>
        </div>
      </div>
      <div class="p-5">
        <h3 class="text-xl font-bold mb-2">Coach</h3>
        <p class="text-gray-500 text-sm mb-4">Founded in 1941, Coach is an American luxury fashion company known for accessories and gifts for women and men, including bags, small leather goods, footwear, and more.</p>
        <div class="flex justify-between items-center">
          <span class="text-sm font-medium text-gray-500">18 products</span>
          <a href="#" class="text-sm font-medium text-black hover:underline">View Products</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection