@extends('admin.dashboard')

@section('admin-content')
<div class="space-y-8">
  <div class="flex justify-between items-center">
    <div>
      <h1 class="text-2xl font-bold">Customers Management</h1>
      <p class="text-gray-600">Manage all registered customers</p>
    </div>
    <div class="text-sm text-gray-500">
      Total: {{ $customers->total() }} customers
    </div>
  </div>

  <!-- Search -->
  <div class="bg-white rounded-lg shadow-sm p-6">
    <form method="GET" action="{{ route('admin.customers') }}" class="flex items-center space-x-4">
      <div class="flex-1">
        <input type="text" name="search" value="{{ request('search') }}" 
               placeholder="Search by name or email..." 
               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
      </div>
      <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
        Search
      </button>
      @if(request('search'))
        <a href="{{ route('admin.customers') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800">
          Clear
        </a>
      @endif
    </form>
  </div>

  <!-- Customers Table -->
  <div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Orders</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cart Items</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @forelse($customers as $customer)
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm font-medium text-gray-900">
                {{ $customer->fname }} {{ $customer->lname }}
              </div>
              <div class="text-sm text-gray-500">
                ID: {{ $customer->customer_id }}
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
              {{ $customer->email }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
              {{ $customer->phone ?? 'N/A' }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                {{ $customer->orders->count() ?? 0 }} orders
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                {{ $customer->persistentCartItems->count() ?? 0 }} items
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
              <form method="POST" action="{{ route('admin.customers.destroy', $customer->customer_id) }}" 
                    onsubmit="return confirm('Are you sure you want to remove this customer? This action cannot be undone.')"
                    class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-900">
                  Remove
                </button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
              No customers found.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Pagination -->
  <div class="flex justify-center">
    {{ $customers->appends(request()->query())->links() }}
  </div>
</div>
@endsection