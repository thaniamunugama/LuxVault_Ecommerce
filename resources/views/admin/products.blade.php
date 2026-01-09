@extends('admin.dashboard')

@section('admin-content')
<div class="space-y-6">
  <div class="flex justify-between items-center">
    <h1 class="text-2xl font-bold">Products Management</h1>
    <button class="bg-black text-white px-4 py-2 rounded font-medium hover:bg-gray-800">Add New Product</button>
  </div>
  
  <div class="bg-gray-50 rounded-lg p-4 flex items-center space-x-4">
    <div class="flex-1">
      <input type="text" placeholder="Search products..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black">
    </div>
    <div class="flex space-x-2">
      <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black">
        <option value="">All Brands</option>
        <option value="1">Hermès</option>
        <option value="2">Chanel</option>
        <option value="3">YSL</option>
        <option value="4">Coach</option>
      </select>
      <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black">
        <option value="">Status: All</option>
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
        <option value="out_of_stock">Out of Stock</option>
      </select>
      <button class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300">
        Filter
      </button>
    </div>
  </div>

  <div class="overflow-x-auto">
    <table class="min-w-full bg-white rounded-xl overflow-hidden">
      <thead class="bg-gray-50 border-b">
        <tr>
          <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Product</th>
          <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Brand</th>
          <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Price</th>
          <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Stock</th>
          <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Status</th>
          <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Seller</th>
          <th class="px-6 py-4 text-right text-sm font-medium text-gray-500">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        <tr>
          <td class="px-6 py-4">
            <div class="flex items-center">
              <img src="{{ asset('images/birkin_1.png') }}" alt="Product" class="h-12 w-16 object-cover rounded mr-3">
              <div>
                <div class="font-medium">Hermès Birkin 25</div>
                <div class="text-sm text-gray-500">SKU: PRD-0001</div>
              </div>
            </div>
          </td>
          <td class="px-6 py-4">Hermès</td>
          <td class="px-6 py-4 font-medium">$12,500</td>
          <td class="px-6 py-4">2</td>
          <td class="px-6 py-4">
            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Active</span>
          </td>
          <td class="px-6 py-4">Phoenix Baker</td>
          <td class="px-6 py-4 text-right">
            <div class="flex justify-end space-x-2">
              <button class="text-blue-600 hover:text-blue-900">Edit</button>
              <button class="text-red-600 hover:text-red-900">Delete</button>
            </div>
          </td>
        </tr>
        
        <tr>
          <td class="px-6 py-4">
            <div class="flex items-center">
              <img src="{{ asset('images/chanel_1.png') }}" alt="Product" class="h-12 w-16 object-cover rounded mr-3">
              <div>
                <div class="font-medium">Chanel Classic Flap</div>
                <div class="text-sm text-gray-500">SKU: PRD-0002</div>
              </div>
            </div>
          </td>
          <td class="px-6 py-4">Chanel</td>
          <td class="px-6 py-4 font-medium">$8,200</td>
          <td class="px-6 py-4">5</td>
          <td class="px-6 py-4">
            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Active</span>
          </td>
          <td class="px-6 py-4">Olivia Rhye</td>
          <td class="px-6 py-4 text-right">
            <div class="flex justify-end space-x-2">
              <button class="text-blue-600 hover:text-blue-900">Edit</button>
              <button class="text-red-600 hover:text-red-900">Delete</button>
            </div>
          </td>
        </tr>
        
        <tr>
          <td class="px-6 py-4">
            <div class="flex items-center">
              <img src="{{ asset('images/coach_1.png') }}" alt="Product" class="h-12 w-16 object-cover rounded mr-3">
              <div>
                <div class="font-medium">Coach Tabby Bag</div>
                <div class="text-sm text-gray-500">SKU: PRD-0005</div>
              </div>
            </div>
          </td>
          <td class="px-6 py-4">Coach</td>
          <td class="px-6 py-4 font-medium">$450</td>
          <td class="px-6 py-4">0</td>
          <td class="px-6 py-4">
            <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">Out of Stock</span>
          </td>
          <td class="px-6 py-4">Lana Steiner</td>
          <td class="px-6 py-4 text-right">
            <div class="flex justify-end space-x-2">
              <button class="text-blue-600 hover:text-blue-900">Edit</button>
              <button class="text-red-600 hover:text-red-900">Delete</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  
  <div class="flex justify-between items-center pt-4">
    <div class="text-sm text-gray-500">Showing 1-3 of 154 products</div>
    <div class="flex space-x-1">
      <button class="px-3 py-1 border border-gray-300 rounded-md disabled:opacity-50">Previous</button>
      <button class="px-3 py-1 bg-black text-white border border-black rounded-md">1</button>
      <button class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-100">2</button>
      <button class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-100">3</button>
      <button class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-100">Next</button>
    </div>
  </div>
</div>
@endsection