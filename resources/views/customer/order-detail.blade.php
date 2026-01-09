@extends('customer.layout')

@section('dashboard-content')
@php
    $items = $order->items ?? $order->orderItems ?? collect();
    $allDelivered = $items->count() > 0 && $items->every(function($item) {
        return $item->status === 'delivered';
    });
@endphp
<div class="bg-white shadow-sm rounded-lg overflow-hidden mb-6">
    <div class="border-b border-gray-200 px-6 py-4 flex justify-between items-center">
        <h2 class="text-xl font-bold">Order #{{ $order->order_number }}</h2>
        <a href="{{ route('customer.orders') }}" class="inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
            <svg class="mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Orders
        </a>
    </div>
    <div class="px-6 py-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-3">Order Information</h3>
                <dl class="grid grid-cols-3 gap-x-4 gap-y-2">
                    <dt class="text-sm font-medium text-gray-500">Order Number:</dt>
                    <dd class="text-sm text-gray-900 col-span-2">{{ $order->order_number }}</dd>
                    
                    <dt class="text-sm font-medium text-gray-500">Date Placed:</dt>
                    <dd class="text-sm text-gray-900 col-span-2">{{ $order->created_at->format('M d, Y h:i A') }}</dd>
                    
                    @if($allDelivered)
                    <dt class="text-sm font-medium text-gray-500">Status:</dt>
                    <dd class="text-sm text-gray-900 col-span-2">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Delivered
                        </span>
                    </dd>
                    @endif
                    <dt class="text-sm font-medium text-gray-500">Payment Method:</dt>
                    <dd class="text-sm text-gray-900 col-span-2">{{ ucfirst($order->payment_method ?? 'Credit Card') }}</dd>
                    
                    <dt class="text-sm font-medium text-gray-500">Payment Status:</dt>
                    <dd class="text-sm text-gray-900 col-span-2">
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
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Paid
                            </span>
                        @endif
                    </dd>
                </dl>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-3">Shipping Address</h3>
                <div class="text-sm text-gray-900">
                    <p class="font-medium">{{ $order->billing_first_name ?? '' }} {{ $order->billing_last_name ?? '' }}</p>
                    <p>{{ $order->billing_address ?? $order->address ?? '' }}</p>
                    <p>{{ $order->billing_city ?? $order->city ?? '' }}, {{ $order->billing_postal_code ?? $order->postal_code ?? '' }}</p>
                    <p>{{ $order->billing_country ?? $order->country ?? '' }}</p>
                    <p class="mt-1">Phone: {{ $order->billing_phone ?? $order->phone ?? '' }}</p>
                </div>
            </div>
        </div>
        
        <h3 class="text-lg font-medium text-gray-900 mb-4">Order Items</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 100px;">Image</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                        @if(!$allDelivered)
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        @endif
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($order->items ?? $order->orderItems as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="w-16 h-16 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                @if($item->product && $item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                @elseif($item->product && $item->product->image_path)
                                    <img src="{{ asset('storage/' . $item->product->image_path) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-400 text-xs">No Image</span>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $item->product->name ?? 'Product Unavailable' }}</div>
                            <div class="text-sm text-gray-500">{{ $item->product->brand_name ?? $item->product->brand ?? '' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            ${{ number_format($item->price ?? $item->unit_price, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $item->quantity }}
                        </td>
                        @if(!$allDelivered)
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($item->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($item->status == 'received') bg-blue-100 text-blue-800
                                @elseif($item->status == 'processing') bg-purple-100 text-purple-800
                                @elseif($item->status == 'delivered') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($item->status ?? 'Pending') }}
                            </span>
                        </td>
                        @endif
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                            ${{ number_format(($item->price ?? $item->unit_price) * $item->quantity, 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="{{ $allDelivered ? '4' : '5' }}" class="px-6 py-3 text-right text-sm font-medium text-gray-500">Subtotal</td>
                        <td class="px-6 py-3 text-right text-sm font-medium text-gray-900">
                            ${{ number_format(($order->total_amount ?? $order->total) - ($order->shipping_cost ?? 0), 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="{{ $allDelivered ? '4' : '5' }}" class="px-6 py-3 text-right text-sm font-medium text-gray-500">Shipping</td>
                        <td class="px-6 py-3 text-right text-sm font-medium text-gray-900">
                            ${{ number_format($order->shipping_cost ?? 0, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="{{ $allDelivered ? '4' : '5' }}" class="px-6 py-3 text-right text-sm font-medium text-gray-900">Total</td>
                        <td class="px-6 py-3 text-right text-sm font-bold text-gray-900">
                            ${{ number_format($order->total_amount ?? $order->total, 2) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        @if($allDelivered && ($order->status == 'shipped' || $order->status == 'delivered'))
        <div class="mt-6 bg-blue-50 border-l-4 border-blue-400 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Tracking Information</h3>
                    <p class="mt-2 text-sm text-blue-700">Your order has been shipped! Tracking number: <span class="font-semibold">DEMO12345678</span></p>
                </div>
            </div>
        </div>
        @endif
        
        <div class="mt-6 pt-6 border-t border-gray-200">
            <div class="flex justify-between items-center">
                <a href="{{ route('customer.orders') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to All Orders
                </a>
                
                <div class="flex space-x-3">
                    @if(!$allDelivered && ($order->status == 'pending' || $order->status == 'processing'))
                    <form action="{{ route('customer.orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?');">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Cancel Order
                        </button>
                    </form>
                    @endif
                    
                    @if($allDelivered)
                    <a href="{{ route('customer.review.create', ['order' => $order->id]) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Leave a Review
                    </a>
                    @endif
                    
                    <button type="button" onclick="window.print()" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Print Order
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection