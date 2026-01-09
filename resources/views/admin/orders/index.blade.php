@extends('admin.dashboard')

@section('admin-content')
<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold">Order Management</h1>
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-200 rounded-lg text-gray-700 hover:bg-gray-300 transition">
            Back to Dashboard
        </a>
    </div>
</div>

<!-- Search and Filter Section -->
<div class="mb-6 bg-white rounded-xl shadow-sm p-4">
    <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-[200px]">
            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <input type="text" name="search" id="search" value="{{ request('search') }}" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                   placeholder="Search by order number or customer name">
        </div>
        
        <div class="min-w-[150px]">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        
        <div class="min-w-[150px]">
            <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-1">Payment Status</label>
            <select name="payment_status" id="payment_status" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">All Payment Statuses</option>
                <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
            </select>
        </div>
        
        <div class="min-w-[150px]">
            <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
            <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        
        <div class="min-w-[150px]">
            <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
            <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        
        <div class="self-end">
            <button type="submit" class="px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800 transition">
                Filter
            </button>
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 border border-gray-300 rounded-md ml-2 hover:bg-gray-50 transition">
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Order List -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Order Number
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Customer
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Date
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Amount
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Payment Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($orders as $order)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">#{{ $order->order_number ?? $order->id }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">
                            {{ $order->customer->first_name ?? $order->customer->fname ?? '' }} {{ $order->customer->last_name ?? $order->customer->lname ?? '' }}
                        </div>
                        <div class="text-xs text-gray-500">{{ $order->customer->email ?? 'N/A' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $order->created_at->format('M d, Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $order->created_at->format('h:i A') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">${{ number_format($order->total_amount ?? $order->total ?? 0, 2) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($order->status == 'pending')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                        @elseif($order->status == 'processing')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                Processing
                            </span>
                        @elseif($order->status == 'shipped')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                Shipped
                            </span>
                        @elseif($order->status == 'delivered')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Delivered
                            </span>
                        @elseif($order->status == 'cancelled')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Cancelled
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                {{ ucfirst($order->status ?? 'N/A') }}
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($order->payment_status == 'pending')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                        @elseif($order->payment_status == 'paid')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Paid
                            </span>
                        @elseif($order->payment_status == 'failed')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Failed
                            </span>
                        @elseif($order->payment_status == 'refunded')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                Refunded
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                {{ ucfirst($order->payment_status ?? 'N/A') }}
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-indigo-600 hover:text-indigo-900">
                            View Details
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        No orders found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4">
        {{ $orders->withQueryString()->links() }}
    </div>
</div>
@endsection