@extends('admin.dashboard')

@section('admin-content')
<div class="space-y-6">
  <div class="flex justify-between items-center">
    <h1 class="text-2xl font-bold">Orders Management</h1>
  </div>
  
  <div class="bg-gray-50 rounded-lg p-4 flex items-center space-x-4">
    <div class="flex-1">
      <input type="text" placeholder="Search order ID or customer..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black">
    </div>
    <div class="flex space-x-2">
      <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black">
        <option value="">All Statuses</option>
        <option value="pending">Pending</option>
        <option value="confirmed">Confirmed</option>
        <option value="shipped">Shipped</option>
        <option value="delivered">Delivered</option>
        <option value="cancelled">Cancelled</option>
      </select>
      <input type="date" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black" placeholder="Start Date">
      <button class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300">
        Filter
      </button>
    </div>
  </div>

  <div class="overflow-x-auto">
    <table class="min-w-full bg-white rounded-xl overflow-hidden">
      <thead class="bg-gray-50 border-b">
        <tr>
          <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Order ID</th>
          <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Customer</th>
          <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Date</th>
          <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Total</th>
          <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Items</th>
          <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Status</th>
          <th class="px-6 py-4 text-right text-sm font-medium text-gray-500">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        <tr>
          <td class="px-6 py-4 font-medium">#ORD-5632</td>
          <td class="px-6 py-4">Jane Cooper</td>
          <td class="px-6 py-4">Sept 30, 2025</td>
          <td class="px-6 py-4 font-medium">$24,950</td>
          <td class="px-6 py-4">2 items</td>
          <td class="px-6 py-4">
            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">Pending</span>
          </td>
          <td class="px-6 py-4 text-right">
            <div class="flex justify-end space-x-2">
              <button class="text-blue-600 hover:text-blue-900">View</button>
              <select class="text-sm border-none bg-transparent focus:outline-none focus:ring-0 text-gray-600">
                <option value="" disabled selected>Change Status</option>
                <option value="confirmed">Confirm</option>
                <option value="shipped">Ship</option>
                <option value="delivered">Deliver</option>
                <option value="cancelled">Cancel</option>
              </select>
            </div>
          </td>
        </tr>
        
        <tr>
          <td class="px-6 py-4 font-medium">#ORD-5631</td>
          <td class="px-6 py-4">Robert Fox</td>
          <td class="px-6 py-4">Sept 29, 2025</td>
          <td class="px-6 py-4 font-medium">$8,200</td>
          <td class="px-6 py-4">1 item</td>
          <td class="px-6 py-4">
            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Shipped</span>
          </td>
          <td class="px-6 py-4 text-right">
            <div class="flex justify-end space-x-2">
              <button class="text-blue-600 hover:text-blue-900">View</button>
              <select class="text-sm border-none bg-transparent focus:outline-none focus:ring-0 text-gray-600">
                <option value="" disabled selected>Change Status</option>
                <option value="delivered">Deliver</option>
                <option value="cancelled">Cancel</option>
              </select>
            </div>
          </td>
        </tr>
        
        <tr>
          <td class="px-6 py-4 font-medium">#ORD-5630</td>
          <td class="px-6 py-4">Wade Warren</td>
          <td class="px-6 py-4">Sept 28, 2025</td>
          <td class="px-6 py-4 font-medium">$1,350</td>
          <td class="px-6 py-4">3 items</td>
          <td class="px-6 py-4">
            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">Completed</span>
          </td>
          <td class="px-6 py-4 text-right">
            <div class="flex justify-end space-x-2">
              <button class="text-blue-600 hover:text-blue-900">View</button>
              <button class="text-gray-400 cursor-not-allowed">Completed</button>
            </div>
          </td>
        </tr>
        
        <tr>
          <td class="px-6 py-4 font-medium">#ORD-5629</td>
          <td class="px-6 py-4">Brooklyn Simmons</td>
          <td class="px-6 py-4">Sept 27, 2025</td>
          <td class="px-6 py-4 font-medium">$3,200</td>
          <td class="px-6 py-4">1 item</td>
          <td class="px-6 py-4">
            <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">Cancelled</span>
          </td>
          <td class="px-6 py-4 text-right">
            <div class="flex justify-end space-x-2">
              <button class="text-blue-600 hover:text-blue-900">View</button>
              <button class="text-gray-400 cursor-not-allowed">Cancelled</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  
  <div class="flex justify-between items-center pt-4">
    <div class="text-sm text-gray-500">Showing 1-4 of 87 orders</div>
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