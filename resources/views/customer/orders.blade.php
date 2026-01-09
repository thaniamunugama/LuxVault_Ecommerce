@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-sm rounded-lg overflow-hidden mb-6">
        <div class="border-b border-gray-200 px-6 py-4">
            <h2 class="text-xl font-bold">My Order History</h2>
        </div>
        <div class="p-0">
        @if($orders->count() > 0 || $deliveredOrders->count() > 0)
            @if($orders->count() > 0)
            <div class="px-6 py-4 bg-gray-50 border-b">
                <h3 class="text-lg font-semibold text-gray-700">Active Orders</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    #{{ $order->order_id }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($order->order_date)->format('h:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">${{ number_format($order->total_price, 2) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('order.show', $order->order_id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 px-3 py-1 rounded-md">
                                    View Details
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
            
            @if($deliveredOrders->count() > 0)
            <div class="px-6 py-4 bg-gray-50 border-b border-t mt-6">
                <h3 class="text-lg font-semibold text-gray-700">Delivered Orders</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($deliveredOrders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    #{{ $order->order_id }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($order->order_date)->format('h:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Delivered
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">${{ number_format($order->total_price, 2) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('order.show', $order->order_id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 px-3 py-1 rounded-md">
                                    View Details
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No orders found</h3>
                <p class="mt-1 text-sm text-gray-500">You haven't placed any orders yet.</p>
                <div class="mt-6">
                    <a href="{{ route('products') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-black hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
                        Start Shopping
                    </a>
                </div>
            </div>
        @endif
        </div>
    </div>
</div>
@endsection