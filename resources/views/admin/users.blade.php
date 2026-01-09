@extends('admin.dashboard')

@section('admin-content')
<div class="space-y-6">
  <div class="flex justify-between items-center">
    <h1 class="text-2xl font-bold">Users Management</h1>
    <button class="bg-black text-white px-4 py-2 rounded font-medium hover:bg-gray-800">Add New User</button>
  </div>
  
  <div class="bg-gray-50 rounded-lg p-4 flex items-center space-x-4">
    <div class="flex-1">
      <input type="text" placeholder="Search users..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black">
    </div>
    <div class="flex space-x-2">
      <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black">
        <option value="">All Roles</option>
        <option value="customer">Customer</option>
        <option value="seller">Seller</option>
        <option value="admin">Admin</option>
      </select>
      <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black">
        <option value="">Status: All</option>
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
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
          <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">User</th>
          <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Email</th>
          <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Role</th>
          <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Status</th>
          <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Joined Date</th>
          <th class="px-6 py-4 text-right text-sm font-medium text-gray-500">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        <tr>
          <td class="px-6 py-4">
            <div class="flex items-center">
              <img src="{{ asset('images/pfp-b.png') }}" alt="User" class="h-10 w-10 rounded-full mr-3">
              <div>
                <div class="font-medium">Phoenix Baker</div>
              </div>
            </div>
          </td>
          <td class="px-6 py-4">phoenix@example.com</td>
          <td class="px-6 py-4">
            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">Seller</span>
          </td>
          <td class="px-6 py-4">
            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Active</span>
          </td>
          <td class="px-6 py-4">Sept 15, 2025</td>
          <td class="px-6 py-4 text-right">
            <div class="flex justify-end space-x-2">
              <button class="text-blue-600 hover:text-blue-900">Edit</button>
              <button class="text-red-600 hover:text-red-900">Deactivate</button>
            </div>
          </td>
        </tr>
        
        <tr>
          <td class="px-6 py-4">
            <div class="flex items-center">
              <img src="{{ asset('images/pfp-b.png') }}" alt="User" class="h-10 w-10 rounded-full mr-3">
              <div>
                <div class="font-medium">Olivia Rhye</div>
              </div>
            </div>
          </td>
          <td class="px-6 py-4">olivia@example.com</td>
          <td class="px-6 py-4">
            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">Seller</span>
          </td>
          <td class="px-6 py-4">
            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Active</span>
          </td>
          <td class="px-6 py-4">Sept 12, 2025</td>
          <td class="px-6 py-4 text-right">
            <div class="flex justify-end space-x-2">
              <button class="text-blue-600 hover:text-blue-900">Edit</button>
              <button class="text-red-600 hover:text-red-900">Deactivate</button>
            </div>
          </td>
        </tr>
        
        <tr>
          <td class="px-6 py-4">
            <div class="flex items-center">
              <img src="{{ asset('images/pfp-b.png') }}" alt="User" class="h-10 w-10 rounded-full mr-3">
              <div>
                <div class="font-medium">Jane Cooper</div>
              </div>
            </div>
          </td>
          <td class="px-6 py-4">jane@example.com</td>
          <td class="px-6 py-4">
            <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-medium">Customer</span>
          </td>
          <td class="px-6 py-4">
            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Active</span>
          </td>
          <td class="px-6 py-4">Sept 20, 2025</td>
          <td class="px-6 py-4 text-right">
            <div class="flex justify-end space-x-2">
              <button class="text-blue-600 hover:text-blue-900">Edit</button>
              <button class="text-red-600 hover:text-red-900">Deactivate</button>
            </div>
          </td>
        </tr>
        
        <tr>
          <td class="px-6 py-4">
            <div class="flex items-center">
              <img src="{{ asset('images/pfp-b.png') }}" alt="User" class="h-10 w-10 rounded-full mr-3">
              <div>
                <div class="font-medium">Admin User</div>
              </div>
            </div>
          </td>
          <td class="px-6 py-4">admin@luxevault.com</td>
          <td class="px-6 py-4">
            <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">Admin</span>
          </td>
          <td class="px-6 py-4">
            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Active</span>
          </td>
          <td class="px-6 py-4">Sept 1, 2025</td>
          <td class="px-6 py-4 text-right">
            <div class="flex justify-end space-x-2">
              <button class="text-blue-600 hover:text-blue-900">Edit</button>
              <button class="text-gray-400 cursor-not-allowed">Deactivate</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  
  <div class="flex justify-between items-center pt-4">
    <div class="text-sm text-gray-500">Showing 1-4 of 243 users</div>
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