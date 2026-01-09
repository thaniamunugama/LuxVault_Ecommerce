@extends('seller.layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="space-y-6">
  <!-- Header -->
  <div class="flex justify-between items-center">
    <h1 class="text-2xl font-bold">My Orders</h1>
  </div>

  @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
      {{ session('success') }}
    </div>
  @endif

  <!-- Orders List -->
  <div class="bg-white shadow rounded-lg">
    @if($orders->count() > 0)
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order Date</th>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order Details</th>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach($orders as $order)
              @php
                $seller = Auth::guard('seller')->user();
                $sellerItems = $order->orderItems->where('seller_id', $seller->seller_id);
                $sellerTotal = $sellerItems->sum(function($item) {
                  return $item->price * $item->quantity;
                });
              @endphp
              <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 whitespace-nowrap">
                  <div class="text-xs font-medium text-gray-900">#{{ $order->order_id }}</div>
                </td>
                <td class="px-4 py-3">
                  <div class="text-xs text-gray-900">{{ $order->customer->fname ?? 'N/A' }} {{ $order->customer->lname ?? '' }}</div>
                  <div class="text-xs text-gray-500">{{ $order->customer->email ?? 'N/A' }}</div>
                  @if($order->customer->phone)
                    <div class="text-xs text-gray-500">{{ $order->customer->phone }}</div>
                  @endif
                </td>
                <td class="px-4 py-3">
                  <div class="space-y-1">
                    @foreach($sellerItems as $item)
                      <div class="text-xs text-gray-900 line-clamp-3" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                        {{ $item->product->name ?? 'N/A' }}
                      </div>
                    @endforeach
                  </div>
                </td>
                <td class="px-4 py-3">
                  <div class="space-y-1">
                    @foreach($sellerItems as $item)
                      <div class="text-xs text-gray-500">{{ $item->quantity }}</div>
                    @endforeach
                  </div>
                </td>
                <td class="px-4 py-3">
                  <div class="space-y-1">
                    @foreach($sellerItems as $item)
                      <div class="text-xs text-gray-500">${{ number_format($item->price * $item->quantity, 2) }}</div>
                    @endforeach
                    <div class="text-xs font-bold text-gray-900 mt-2 pt-2 border-t">Total: ${{ number_format($sellerTotal, 2) }}</div>
                  </div>
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-xs text-gray-900">
                  {{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y') }}
                </td>
                <td class="px-4 py-3">
                  <button onclick="openOrderDetails({{ $order->order_id }})" class="text-indigo-600 hover:text-indigo-900 underline text-xs leading-tight" style="line-height: 1.2;">
                    Order<br>Details
                  </button>
                </td>
                <td class="px-4 py-3 whitespace-nowrap">
                  <span class="px-2 inline-flex text-xs leading-4 font-semibold rounded-full 
                    @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                    @elseif($order->status == 'received') bg-blue-100 text-blue-800
                    @elseif($order->status == 'processing') bg-purple-100 text-purple-800
                    @elseif($order->status == 'delivered') bg-green-100 text-green-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    {{ ucfirst($order->status ?? 'pending') }}
                  </span>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @else
      <div class="px-6 py-8 text-center">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No orders found</h3>
        <p class="mt-1 text-sm text-gray-500">When customers place orders for your products, they'll appear here.</p>
      </div>
    @endif
  </div>
</div>

<!-- Order Details Modal -->
<div id="orderDetailsModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
  <div id="orderDetailsBackdrop" class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>
  <div class="flex min-h-full items-center justify-center p-4">
    <div class="relative bg-white rounded-lg shadow-xl max-w-4xl w-full p-6 transform transition-all max-h-[90vh] overflow-y-auto">
      <button id="closeOrderDetailsModal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
      </button>
      
      <div id="orderDetailsContent">
        <!-- Content will be loaded here -->
      </div>
    </div>
  </div>
</div>

<script>
function openOrderDetails(orderId) {
  const modal = document.getElementById('orderDetailsModal');
  const backdrop = document.getElementById('orderDetailsBackdrop');
  const content = document.getElementById('orderDetailsContent');
  
  // Show loading
  content.innerHTML = '<div class="text-center py-8">Loading...</div>';
  
  modal.classList.remove('hidden');
  document.body.style.overflow = 'hidden';
  
  // Fetch order details
  fetch(`/seller/orders/${orderId}/details`)
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        content.innerHTML = data.html;
      } else {
        content.innerHTML = '<div class="text-center py-8 text-red-600">Error loading order details</div>';
      }
    })
    .catch(error => {
      console.error('Error:', error);
      content.innerHTML = '<div class="text-center py-8 text-red-600">Error loading order details</div>';
    });
}

function closeOrderDetailsModal() {
  const modal = document.getElementById('orderDetailsModal');
  const backdrop = document.getElementById('orderDetailsBackdrop');
  
  backdrop.style.opacity = '0';
  setTimeout(() => {
    modal.classList.add('hidden');
    document.body.style.overflow = '';
  }, 200);
}

function updateOrderStatus(orderId, status) {
  const statusLabels = {
    'received': 'Order Received',
    'processing': 'Order Processing',
    'delivered': 'Order Delivered'
  };
  
  if (!confirm(`Are you sure you want to update order status to "${statusLabels[status]}"?`)) {
    return;
  }
  
  // Show loading state
  const btn = event.target;
  const originalText = btn.textContent;
  btn.disabled = true;
  btn.textContent = 'Updating...';
  
  // Get CSRF token
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                    document.querySelector('input[name="_token"]')?.value;
  
  fetch(`/seller/orders/${orderId}/status`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrfToken,
      'Accept': 'application/json'
    },
    body: JSON.stringify({ status: status })
  })
  .then(response => {
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    return response.json();
  })
  .then(data => {
    if (data.success) {
      // Close modal and reload page to show updated status
      closeOrderDetailsModal();
      setTimeout(() => {
        window.location.reload();
      }, 300);
    } else {
      btn.disabled = false;
      btn.textContent = originalText;
      alert('Error updating order status: ' + (data.message || 'Unknown error'));
    }
  })
  .catch(error => {
    console.error('Error:', error);
    btn.disabled = false;
    btn.textContent = originalText;
    alert('Error updating order status: ' + error.message);
  });
}

// Event listeners
document.getElementById('closeOrderDetailsModal')?.addEventListener('click', closeOrderDetailsModal);
document.getElementById('orderDetailsBackdrop')?.addEventListener('click', closeOrderDetailsModal);

document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') {
    closeOrderDetailsModal();
  }
});
</script>
@endsection
