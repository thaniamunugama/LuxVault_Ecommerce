@extends('admin.dashboard')

@section('admin-content')
<div class="space-y-8">
  <div>
    <h1 class="text-2xl font-bold mb-4">Site Settings</h1>
    <p class="text-gray-600">Manage your site configuration, logos, banners, and featured products.</p>
  </div>
  
  <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
      <h3 class="font-semibold">General Settings</h3>
    </div>
    <div class="p-6">
      <form class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Site Name</label>
            <input type="text" value="Luxe Vault" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black">
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Contact Email</label>
            <input type="email" value="info@luxevault.com" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black">
          </div>
        </div>
        
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Site Description</label>
          <textarea rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black">Luxe Vault offers a curated collection of luxury handbags from top designer brands including Hermès, Chanel, YSL, and Coach.</textarea>
        </div>
      </form>
    </div>
  </div>
  
  <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
      <h3 class="font-semibold">Logo & Images</h3>
    </div>
    <div class="p-6">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Site Logo (Dark)</label>
          <div class="border border-gray-200 rounded-lg p-4 flex items-center justify-center bg-gray-50 h-40">
            <img src="{{ asset('images/logo- black.png') }}" alt="Luxe Vault Logo" class="h-16 w-auto">
          </div>
          <div class="mt-4">
            <button class="bg-black text-white px-3 py-2 rounded text-sm font-medium hover:bg-gray-800">Update Logo</button>
          </div>
        </div>
        
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Site Logo (Light)</label>
          <div class="border border-gray-200 rounded-lg p-4 flex items-center justify-center bg-gray-800 h-40">
            <img src="{{ asset('images/logo-white.png') }}" alt="Luxe Vault Logo" class="h-16 w-auto">
          </div>
          <div class="mt-4">
            <button class="bg-black text-white px-3 py-2 rounded text-sm font-medium hover:bg-gray-800">Update Logo</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
      <h3 class="font-semibold">Homepage Banners</h3>
    </div>
    <div class="p-6 space-y-6">
      <div class="border border-gray-200 rounded-lg p-4 flex flex-col md:flex-row gap-6">
        <div class="md:w-1/3">
          <img src="{{ asset('images/bg-1.jpg') }}" alt="Banner" class="w-full h-40 object-cover rounded">
        </div>
        <div class="md:w-2/3 space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Banner Title</label>
            <input type="text" value="Luxury Within Reach" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Banner Description</label>
            <textarea rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black">Discover our curated collection of authentic designer handbags.</textarea>
          </div>
          <div class="flex space-x-2">
            <button class="bg-black text-white px-3 py-2 rounded text-sm font-medium hover:bg-gray-800">Update Banner</button>
            <button class="bg-red-600 text-white px-3 py-2 rounded text-sm font-medium hover:bg-red-700">Remove</button>
          </div>
        </div>
      </div>
      
      <button class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded font-medium flex items-center justify-center w-full">
        <span class="mr-2">+</span> Add New Banner
      </button>
    </div>
  </div>
  
  <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
      <h3 class="font-semibold">Featured Products</h3>
    </div>
    <div class="p-6">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="border border-gray-200 rounded-lg p-3">
          <img src="{{ asset('images/birkin_1.png') }}" alt="Product" class="w-full h-32 object-cover rounded mb-2">
          <div class="font-medium">Hermès Birkin 25</div>
          <div class="flex justify-between items-center mt-2">
            <span class="text-sm text-gray-500">Featured #1</span>
            <button class="text-red-600 hover:text-red-900 text-sm">Remove</button>
          </div>
        </div>
        
        <div class="border border-gray-200 rounded-lg p-3">
          <img src="{{ asset('images/chanel_1.png') }}" alt="Product" class="w-full h-32 object-cover rounded mb-2">
          <div class="font-medium">Chanel Classic Flap</div>
          <div class="flex justify-between items-center mt-2">
            <span class="text-sm text-gray-500">Featured #2</span>
            <button class="text-red-600 hover:text-red-900 text-sm">Remove</button>
          </div>
        </div>
        
        <div class="border border-gray-200 rounded-lg p-3">
          <img src="{{ asset('images/coach_1.png') }}" alt="Product" class="w-full h-32 object-cover rounded mb-2">
          <div class="font-medium">Coach Tabby Bag</div>
          <div class="flex justify-between items-center mt-2">
            <span class="text-sm text-gray-500">Featured #3</span>
            <button class="text-red-600 hover:text-red-900 text-sm">Remove</button>
          </div>
        </div>
      </div>
      
      <div class="mt-6">
        <button class="bg-black text-white px-4 py-2 rounded font-medium hover:bg-gray-800">Manage Featured Products</button>
      </div>
    </div>
  </div>
  
  <div class="flex justify-end">
    <button type="submit" class="bg-black text-white px-6 py-3 rounded font-medium hover:bg-gray-800">Save All Changes</button>
  </div>
</div>
@endsection