@extends('admin.dashboard')

@section('admin-content')
<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold">Order #{{ $order->order_number ?? $order->id }}</h1>
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-gray-200 rounded-lg text-gray-700 hover:bg-gray-300 transition">
            Back to Orders
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <!-- Order Information -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-lg font-medium mb-4 pb-2 border-b">Order Information</h2>
        <div class="space-y-3">
            <div class="flex justify-between">
                <span class="text-gray-600">Order Number:</span>
                <span class="font-medium">{{ $order->order_number ?? $order->id }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Date:</span>
                <span>{{ $order->created_at->format('M d, Y h:i A') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Total Amount:</span>
                <span class="font-medium">${{ number_format($order->total_amount ?? $order->total ?? 0, 2) }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Shipping Cost:</span>
                <span>${{ number_format($order->shipping_cost ?? 0, 2) }}</span>
            </div>
            <div class="pt-2 border-t">
                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="mt-3">
                    @csrf
                    @method('PATCH')
                    <label for="status" class="block text-sm font-medium text-gray-600 mb-1">Order Status</label>
                    <div class="flex">
                        <select name="status" id="status" class="w-full rounded-l-md border-r-0 border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="px-4 py-2 bg-black text-white rounded-r-md hover:bg-gray-800">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Customer Information -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-lg font-medium mb-4 pb-2 border-b">Customer Information</h2>
        <div class="space-y-3">
            <div>
                <span class="text-gray-600 block">Name:</span>
                <span class="font-medium">{{ $order->customer->first_name ?? $order->customer->fname ?? '' }} {{ $order->customer->last_name ?? $order->customer->lname ?? '' }}</span>
            </div>
            <div>
                <span class="text-gray-600 block">Email:</span>
                <span class="font-medium">{{ $order->customer->email ?? 'N/A' }}</span>
            </div>
            <div>
                <span class="text-gray-600 block">Phone:</span>
                <span>{{ $order->customer->phone ?? $order->phone ?? 'N/A' }}</span>
            </div>
        </div>
    </div>
    
    <!-- Payment Information -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-lg font-medium mb-4 pb-2 border-b">Payment Information</h2>
        <div class="space-y-3">
            <div class="flex justify-between">
                <span class="text-gray-600">Payment Method:</span>
                <span>{{ ucfirst($order->payment_method ?? 'Credit Card') }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Payment Status:</span>
                @if($order->payment_status == 'pending')
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                        Pending
                    </span>
                @elseif($order->payment_status == 'paid')
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                        Paid
                    </span>
                @elseif($order->payment_status == 'failed')
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                        Failed
                    </span>
                @elseif($order->payment_status == 'refunded')
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                        Refunded
                    </span>
                @else
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                        {{ ucfirst($order->payment_status ?? 'N/A') }}
                    </span>
                @endif
            </div>
            <div class="pt-2 border-t">
                <form action="{{ route('admin.orders.update-payment-status', $order->id) }}" method="POST" class="mt-3">
                    @csrf
                    @method('PATCH')
                    <label for="payment_status" class="block text-sm font-medium text-gray-600 mb-1">Update Payment Status</label>
                    <div class="flex">
                        <select name="payment_status" id="payment_status" class="w-full rounded-l-md border-r-0 border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                        <button type="submit" class="px-4 py-2 bg-black text-white rounded-r-md hover:bg-gray-800">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Shipping Address -->
<div class="bg-white rounded-lg shadow-sm p-6 mb-6">
    <h2 class="text-lg font-medium mb-4 pb-2 border-b">Shipping Address</h2>
    <div class="text-gray-700">
        <p class="font-medium">{{ $order->billing_first_name ?? $order->billing_name ?? '' }} {{ $order->billing_last_name ?? '' }}</p>
        <p>{{ $order->billing_address ?? $order->address ?? '' }}</p>
        <p>{{ $order->billing_city ?? $order->city ?? '' }}, {{ $order->billing_postal_code ?? $order->postal_code ?? '' }}</p>
        <p>{{ $order->billing_country ?? $order->country ?? '' }}</p>
        <p class="mt-1">Phone: {{ $order->billing_phone ?? $order->phone ?? '' }}</p>
    </div>
</div>

<!-- Order Items -->
<div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
    <div class="p-6 border-b">
        <h2 class="text-lg font-medium">Order Items</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Product
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Unit Price
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Quantity
                    </th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Total
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($order->items ?? $order->orderItems as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="h-12 w-12 rounded-md overflow-hidden border border-gray-200">
                                @if($item->product && $item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" 
                                         class="h-full w-full object-cover" alt="{{ $item->product->name }}">
                                @elseif($item->product && $item->product->image_path)
                                    <img src="{{ asset('storage/' . $item->product->image_path) }}" 
                                         class="h-full w-full object-cover" alt="{{ $item->product->name }}">
                                @else
                                    <div class="h-full w-full bg-gray-200 flex items-center justify-center">
                                        <span class="text-xs text-gray-500">No Image</span>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $item->product->name ?? 'Product Unavailable' }}</div>
                                <div class="text-sm text-gray-500">{{ $item->product->brand_name ?? $item->product->brand ?? '' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">${{ number_format($item->price ?? $item->unit_price ?? 0, 2) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $item->quantity }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                        ${{ number_format(($item->price ?? $item->unit_price ?? 0) * $item->quantity, 2) }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                        No order items found
                    </td>
                </tr>
                @endforelse
            </tbody>
            <tfoot class="bg-gray-50">
                <tr>
                    <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-500">Subtotal</td>
                    <td class="px-6 py-3 text-right text-sm font-medium text-gray-900">
                        ${{ number_format(($order->total_amount ?? $order->total ?? 0) - ($order->shipping_cost ?? 0), 2) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-500">Shipping</td>
                    <td class="px-6 py-3 text-right text-sm font-medium text-gray-900">
                        ${{ number_format($order->shipping_cost ?? 0, 2) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-900">Total</td>
                    <td class="px-6 py-3 text-right text-sm font-bold text-gray-900">
                        ${{ number_format($order->total_amount ?? $order->total ?? 0, 2) }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<!-- Order Notes -->
<div class="bg-white rounded-lg shadow-sm p-6 mb-6">
    <h2 class="text-lg font-medium mb-4 pb-2 border-b">Order Notes</h2>
    <div class="text-gray-700">
        @if($order->notes)
            <p>{{ $order->notes }}</p>
        @else
            <p class="text-gray-500 italic">No notes available for this order.</p>
        @endif
    </div>
</div>
@endsection