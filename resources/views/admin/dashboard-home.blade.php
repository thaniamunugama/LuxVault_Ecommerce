@extends('admin.dashboard')

@section('admin-content')
<div class="space-y-8">
  <div>
    <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>
    <p class="text-gray-600">Welcome to Luxe Vault admin panel. Manage your products, brands, users, and more.</p>
  </div>
  
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
      <div class="flex justify-between items-start">
        <div>
          <p class="text-gray-500 mb-1">Total Products</p>
          <h3 class="text-3xl font-bold">154</h3>
        </div>
        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-medium">+12% ↑</span>
      </div>
    </div>
    
    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
      <div class="flex justify-between items-start">
        <div>
          <p class="text-gray-500 mb-1">Total Orders</p>
          <h3 class="text-3xl font-bold">87</h3>
        </div>
        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-medium">+5% ↑</span>
      </div>
    </div>
    
    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
      <div class="flex justify-between items-start">
        <div>
          <p class="text-gray-500 mb-1">Total Users</p>
          <h3 class="text-3xl font-bold">243</h3>
        </div>
        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-medium">+8% ↑</span>
      </div>
    </div>
  </div>
  
  <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <div class="border border-gray-200 rounded-xl overflow-hidden">
      <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
        <h3 class="font-semibold">Recent Orders</h3>
      </div>
      <div class="divide-y">
        <div class="px-6 py-4 flex justify-between items-center">
          <div>
            <p class="font-medium">#ORD-5632</p>
            <p class="text-sm text-gray-500">Jane Cooper • 2 items</p>
          </div>
          <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">Pending</span>
        </div>
        <div class="px-6 py-4 flex justify-between items-center">
          <div>
            <p class="font-medium">#ORD-5631</p>
            <p class="text-sm text-gray-500">Robert Fox • 1 item</p>
          </div>
          <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Shipped</span>
        </div>
        <div class="px-6 py-4 flex justify-between items-center">
          <div>
            <p class="font-medium">#ORD-5630</p>
            <p class="text-sm text-gray-500">Wade Warren • 3 items</p>
          </div>
          <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">Completed</span>
        </div>
      </div>
      <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
        <a href="{{ route('admin.orders') }}" class="text-sm font-medium text-black hover:underline">View all orders</a>
      </div>
    </div>
    
    <div class="border border-gray-200 rounded-xl overflow-hidden">
      <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
        <h3 class="font-semibold">Top Sellers</h3>
      </div>
      <div class="divide-y">
        <div class="px-6 py-4 flex justify-between items-center">
          <div class="flex items-center">
            <img src="{{ asset('images/pfp-b.png') }}" alt="Seller" class="h-10 w-10 rounded-full mr-3">
            <div>
              <p class="font-medium">Olivia Rhye</p>
              <p class="text-sm text-gray-500">32 products</p>
            </div>
          </div>
          <span class="font-semibold">$24,500</span>
        </div>
        <div class="px-6 py-4 flex justify-between items-center">
          <div class="flex items-center">
            <img src="{{ asset('images/pfp-b.png') }}" alt="Seller" class="h-10 w-10 rounded-full mr-3">
            <div>
              <p class="font-medium">Phoenix Baker</p>
              <p class="text-sm text-gray-500">24 products</p>
            </div>
          </div>
          <span class="font-semibold">$19,200</span>
        </div>
        <div class="px-6 py-4 flex justify-between items-center">
          <div class="flex items-center">
            <img src="{{ asset('images/pfp-b.png') }}" alt="Seller" class="h-10 w-10 rounded-full mr-3">
            <div>
              <p class="font-medium">Lana Steiner</p>
              <p class="text-sm text-gray-500">18 products</p>
            </div>
          </div>
          <span class="font-semibold">$12,750</span>
        </div>
      </div>
      <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
        <a href="{{ route('admin.users') }}" class="text-sm font-medium text-black hover:underline">View all sellers</a>
      </div>
    </div>
  </div>
</div>
@endsection