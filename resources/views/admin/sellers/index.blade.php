@extends('admin.dashboard')

@section('admin-content')
<div class="space-y-8">
  <div class="flex justify-between items-center">
    <div>
      <h1 class="text-2xl font-bold">Sellers Management</h1>
      <p class="text-gray-600">Manage all registered sellers</p>
    </div>
    <div class="text-sm text-gray-500">
      Total: {{ $sellers->total() }} sellers
    </div>
  </div>

  <!-- Search and Filter -->
  <div class="bg-white rounded-lg shadow-sm p-6">
    <form method="GET" action="{{ route('admin.sellers') }}" class="flex items-center space-x-4">
      <div class="flex-1">
        <input type="text" name="search" value="{{ request('search') }}" 
               placeholder="Search by name or email..." 
               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
      </div>
      <select name="status" class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        <option value="">All Status</option>
        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
      </select>
      <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
        Search
      </button>
      @if(request('search') || request('status'))
        <a href="{{ route('admin.sellers') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800">
          Clear
        </a>
      @endif
    </form>
  </div>

  <!-- Sellers Table -->
  <div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seller</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Products</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Orders</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @forelse($sellers as $seller)
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm font-medium text-gray-900">
                {{ $seller->fname }} {{ $seller->lname }}
              </div>
              <div class="text-sm text-gray-500">
                ID: {{ $seller->seller_id }}
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
              {{ $seller->email }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                @if($seller->status == 'approved') bg-green-100 text-green-800
                @elseif($seller->status == 'pending') bg-yellow-100 text-yellow-800
                @else bg-red-100 text-red-800 @endif">
                {{ ucfirst($seller->status) }}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                {{ $seller->products->count() ?? 0 }} products
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
              @php
                $orderCount = \App\Models\OrderItem::whereHas('product', function($q) use ($seller) {
                  $q->where('seller_id', $seller->seller_id);
                })->distinct('order_id')->count();
              @endphp
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                {{ $orderCount }} orders
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
              @php
                $revenue = \App\Models\OrderItem::whereHas('product', function($q) use ($seller) {
                  $q->where('seller_id', $seller->seller_id);
                })->sum(\DB::raw('price * quantity'));
              @endphp
              ${{ number_format($revenue, 2) }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
              <form method="POST" action="{{ route('admin.sellers.destroy', $seller->seller_id) }}" 
                    onsubmit="return confirm('Are you sure you want to remove this seller? This will also remove all their products and affect related orders.')"
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
            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
              No sellers found.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Pagination -->
  <div class="flex justify-center">
    {{ $sellers->appends(request()->query())->links() }}
  </div>
</div>
@endsection