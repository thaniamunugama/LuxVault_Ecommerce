<div>
  <h2 class="text-2xl font-bold mb-4">Order #{{ $order->order_id }}</h2>
  
  <!-- Order Items -->
  <div class="mb-6">
    <h3 class="text-lg font-semibold mb-3">Order Items</h3>
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Image</th>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Brand</th>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Product Name</th>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Price</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach($sellerItems as $item)
            <tr>
              <td class="px-4 py-2">
                <div class="w-16 h-16">
                  @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->product->name ?? 'Product' }}" class="w-full h-full object-cover rounded">
                  @elseif($item->product && $item->product->image)
                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name ?? 'Product' }}" class="w-full h-full object-cover rounded">
                  @else
                    <div class="w-full h-full bg-gray-200 flex items-center justify-center rounded">
                      <span class="text-xs text-gray-500">No Image</span>
                    </div>
                  @endif
                </div>
              </td>
              <td class="px-4 py-2 text-sm text-gray-900">{{ $item->product->brand ?? 'N/A' }}</td>
              <td class="px-4 py-2 text-sm font-medium text-gray-900">{{ $item->product->name ?? 'Product Unavailable' }}</td>
              <td class="px-4 py-2 text-sm text-gray-500">{{ $item->quantity }}</td>
              <td class="px-4 py-2 text-sm text-gray-900 text-right">${{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
          @endforeach
        </tbody>
        <tfoot class="bg-gray-50">
          <tr>
            <td colspan="4" class="px-4 py-3 text-right text-sm font-medium text-gray-900">Total Profit</td>
            <td class="px-4 py-3 text-right text-sm font-bold text-gray-900">${{ number_format($totalProfit, 2) }}</td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>

  <!-- Delivery Details -->
  <div class="mb-6">
    <h3 class="text-lg font-semibold mb-3">Delivery Details</h3>
    <div class="bg-gray-50 p-4 rounded-lg">
      <div class="grid grid-cols-2 gap-4">
        <div>
          <p class="text-sm text-gray-600">Name</p>
          <p class="text-sm font-medium text-gray-900">{{ $order->shipping_first_name ?? 'N/A' }} {{ $order->shipping_last_name ?? '' }}</p>
        </div>
        <div>
          <p class="text-sm text-gray-600">Phone</p>
          <p class="text-sm font-medium text-gray-900">{{ $order->shipping_phone ?? 'N/A' }}</p>
        </div>
        <div class="col-span-2">
          <p class="text-sm text-gray-600">Address</p>
          <p class="text-sm font-medium text-gray-900">{{ $order->shipping_address ?? 'N/A' }}</p>
        </div>
        <div>
          <p class="text-sm text-gray-600">City</p>
          <p class="text-sm font-medium text-gray-900">{{ $order->shipping_city ?? 'N/A' }}</p>
        </div>
        <div>
          <p class="text-sm text-gray-600">State/Province</p>
          <p class="text-sm font-medium text-gray-900">{{ $order->shipping_state ?? 'N/A' }}</p>
        </div>
        <div>
          <p class="text-sm text-gray-600">Postal Code</p>
          <p class="text-sm font-medium text-gray-900">{{ $order->shipping_postal_code ?? 'N/A' }}</p>
        </div>
        <div>
          <p class="text-sm text-gray-600">Country</p>
          <p class="text-sm font-medium text-gray-900">{{ $order->shipping_country ?? 'N/A' }}</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Order Status Buttons -->
  <div class="border-t pt-4">
    <h3 class="text-lg font-semibold mb-3">Update Order Status</h3>
    <div class="flex gap-3">
      <button onclick="updateOrderStatus({{ $order->order_id }}, 'received')" 
              class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 {{ $order->status == 'received' || $order->status == 'processing' || $order->status == 'delivered' ? 'opacity-50 cursor-not-allowed' : '' }}"
              {{ $order->status == 'received' || $order->status == 'processing' || $order->status == 'delivered' ? 'disabled' : '' }}>
        Order Received
      </button>
      <button onclick="updateOrderStatus({{ $order->order_id }}, 'processing')" 
              class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 {{ $order->status == 'processing' || $order->status == 'delivered' ? 'opacity-50 cursor-not-allowed' : '' }} {{ $order->status == 'pending' ? 'opacity-50 cursor-not-allowed' : '' }}"
              {{ $order->status == 'processing' || $order->status == 'delivered' || $order->status == 'pending' ? 'disabled' : '' }}>
        Order Processing
      </button>
      <button onclick="updateOrderStatus({{ $order->order_id }}, 'delivered')" 
              class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 {{ $order->status == 'delivered' ? 'opacity-50 cursor-not-allowed' : '' }} {{ $order->status != 'processing' ? 'opacity-50 cursor-not-allowed' : '' }}"
              {{ $order->status == 'delivered' || $order->status != 'processing' ? 'disabled' : '' }}>
        Order Delivered
      </button>
    </div>
  </div>
</div>

