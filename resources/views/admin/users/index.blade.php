@extends('admin.dashboard')

@section('admin-content')
<div class="space-y-8">
  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-bold">Users Management</h1>
      <p class="text-gray-600">Manage customers and sellers</p>
    </div>
  </div>

  @if(session('success'))
  <div class="bg-green-50 border-l-4 border-green-500 p-4">
    <div class="flex">
      <div class="flex-shrink-0">
        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
      </div>
      <div class="ml-3">
        <p class="text-sm text-green-700">{{ session('success') }}</p>
      </div>
    </div>
  </div>
  @endif

  @if(session('error'))
  <div class="bg-red-50 border-l-4 border-red-500 p-4">
    <div class="flex">
      <div class="flex-shrink-0">
        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
        </svg>
      </div>
      <div class="ml-3">
        <p class="text-sm text-red-700">{{ session('error') }}</p>
      </div>
    </div>
  </div>
  @endif

  <!-- Customers Section -->
  <div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
      <h2 class="text-xl font-semibold">Customers</h2>
      <p class="text-sm text-gray-600 mt-1">Total: {{ $customers->count() }}</p>
    </div>
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @forelse($customers as $customer)
          <tr>
            <td class="px-6 py-4 text-sm">{{ $customer->customer_id }}</td>
            <td class="px-6 py-4 text-sm font-medium">{{ $customer->fname }} {{ $customer->lname }}</td>
            <td class="px-6 py-4 text-sm">{{ $customer->email }}</td>
            <td class="px-6 py-4 text-sm">{{ $customer->phone ?? '—' }}</td>
            <td class="px-6 py-4 text-sm text-right">
              <form method="POST" action="{{ route('admin.customers.remove', $customer->customer_id) }}" onsubmit="return confirm('Are you sure you want to remove this customer? This will terminate their account and they will not be able to login or register again. This action cannot be undone.');" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Remove</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="px-6 py-10 text-center text-gray-500">No customers found.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Sellers Section -->
  <div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
      <h2 class="text-xl font-semibold">Sellers</h2>
      <p class="text-sm text-gray-600 mt-1">Total: {{ $sellers->count() }}</p>
    </div>
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Products</th>
            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @forelse($sellers as $seller)
          <tr>
            <td class="px-6 py-4 text-sm">{{ $seller->seller_id }}</td>
            <td class="px-6 py-4 text-sm font-medium">{{ $seller->fname }} {{ $seller->lname }}</td>
            <td class="px-6 py-4 text-sm">{{ $seller->email }}</td>
            <td class="px-6 py-4 text-sm">{{ $seller->phone ?? '—' }}</td>
            <td class="px-6 py-4 text-sm">
              {{ \App\Models\Product::where('seller_id', $seller->seller_id)->count() }}
            </td>
            <td class="px-6 py-4 text-sm text-right">
              <form method="POST" action="{{ route('admin.sellers.remove', $seller->seller_id) }}" onsubmit="return confirm('Are you sure you want to remove this seller? This will delete all their products and terminate their account. They will not be able to login or register again. This action cannot be undone.');" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Remove</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="px-6 py-10 text-center text-gray-500">No sellers found.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Terminated Emails Section -->
  @if($terminatedEmails->count() > 0)
  <div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
      <h2 class="text-xl font-semibold">Terminated Accounts</h2>
      <p class="text-sm text-gray-600 mt-1">Total: {{ $terminatedEmails->count() }}</p>
    </div>
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reason</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Terminated At</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach($terminatedEmails as $terminated)
          <tr>
            <td class="px-6 py-4 text-sm font-medium text-red-600">{{ $terminated->email }}</td>
            <td class="px-6 py-4 text-sm">{{ $terminated->reason }}</td>
            <td class="px-6 py-4 text-sm">{{ \Carbon\Carbon::parse($terminated->terminated_at)->format('M d, Y h:i A') }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  @endif
</div>
@endsection
