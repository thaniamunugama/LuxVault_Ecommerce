@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
  <h1 class="text-3xl font-bold mb-8">Order Details</h1>

  <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
    <div class="border-b border-gray-200 pb-4 mb-6">
      <div class="flex justify-between items-center">
        <div>
          <h2 class="text-xl font-bold">Order #{{ $order->order_id }}</h2>
          <p class="text-sm text-gray-500 mt-1">Placed on {{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y h:i A') }}</p>
        </div>
        <button onclick="window.history.back()" class="text-blue-600 hover:underline flex items-center">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
          Back
        </button>
      </div>
    </div>

    <!-- Order Items -->
    <div class="mb-6">
      <h3 class="text-lg font-semibold mb-4">Order Items</h3>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Brand</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Name</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Price (Total)</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach($order->orderItems as $item)
            <tr>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="w-16 h-16 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                  @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->product->name ?? 'Product' }}" class="w-full h-full object-cover">
                  @elseif($item->product && $item->product->image)
                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name ?? 'Product' }}" class="w-full h-full object-cover">
                  @else
                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                      <span class="text-gray-400 text-xs">No Image</span>
                    </div>
                  @endif
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ $item->product->brand ?? 'N/A' }}
              </td>
              <td class="px-6 py-4 text-sm font-medium text-gray-900">
                {{ $item->product->name ?? 'Product Unavailable' }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ $item->quantity }}
              </td>
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
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                ${{ number_format($item->price * $item->quantity, 2) }}
              </td>
            </tr>
            @endforeach
          </tbody>
          <tfoot class="bg-gray-50">
            <tr>
              <td colspan="6" class="px-6 py-3 text-right text-sm font-medium text-gray-900">Total</td>
              <td class="px-6 py-3 text-right text-sm font-bold text-gray-900">
                ${{ number_format($order->total_price, 2) }}
              </td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>

    <!-- Actions -->
    <div class="border-t border-gray-200 pt-6 flex justify-between items-center">
      <a href="{{ route('home') }}" class="text-blue-600 hover:underline">Continue Shopping</a>
      <div class="flex space-x-3">
        <a href="{{ route('order.download', $order->order_id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
          <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          Download PDF
        </a>
      </div>
    </div>
  </div>
</div>
@endsection

