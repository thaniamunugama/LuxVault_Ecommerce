@extends('seller.dashboard')

@section('seller-content')
<div class="space-y-8">
  <div>
    <h1 class="text-2xl font-bold mb-4">Analytics & Insights</h1>
    <p class="text-gray-600">Track your performance and sales data.</p>
  </div>

  <!-- Summary Cards -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <div class="bg-white rounded-xl p-6 shadow">
      <p class="text-gray-500 mb-1 text-sm">Total Products</p>
      <h3 class="text-3xl font-bold">{{ $seller->products->count() }}</h3>
      <div class="text-xs mt-2">
        <span class="text-gray-500">{{ $seller->products->where('status', 'active')->count() }} active</span>
      </div>
    </div>
    
    <div class="bg-white rounded-xl p-6 shadow">
      <p class="text-gray-500 mb-1 text-sm">Total Orders</p>
      <h3 class="text-3xl font-bold">{{ array_sum($statusData) }}</h3>
      <div class="text-xs mt-2">
        <span class="text-green-500">{{ $statusData['delivered'] }} delivered</span> •
        <span class="text-yellow-500">{{ $statusData['processing'] + $statusData['shipped'] }} in progress</span>
      </div>
    </div>
    
    <div class="bg-white rounded-xl p-6 shadow">
      <p class="text-gray-500 mb-1 text-sm">Monthly Revenue</p>
      <h3 class="text-3xl font-bold">£{{ number_format($monthlyData[now()->month], 2) }}</h3>
      <div class="text-xs mt-2">
        <span class="text-gray-500">{{ now()->format('F Y') }}</span>
      </div>
    </div>
    
    <div class="bg-white rounded-xl p-6 shadow">
      <p class="text-gray-500 mb-1 text-sm">Avg. Order Value</p>
      @php
        $totalRevenue = array_sum($monthlyData);
        $totalOrders = array_sum($statusData);
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
      @endphp
      <h3 class="text-3xl font-bold">£{{ number_format($avgOrderValue, 2) }}</h3>
      <div class="text-xs mt-2">
        <span class="text-gray-500">Lifetime average</span>
      </div>
    </div>
  </div>
  
  <!-- Charts -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Monthly Revenue Chart -->
    <div class="bg-white rounded-xl p-6 shadow">
      <h3 class="text-lg font-medium mb-6">Monthly Revenue ({{ now()->year }})</h3>
      <div class="h-64 flex items-end space-x-2">
        @php
          $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
          $maxRevenue = max($monthlyData) > 0 ? max($monthlyData) : 1;
        @endphp
        
        @foreach($monthlyData as $month => $revenue)
          <div class="flex flex-col items-center flex-1">
            @php $heightPercentage = ($revenue / $maxRevenue) * 100; @endphp
            <div class="w-full bg-gray-100 rounded-t-sm" style="height: {{ $heightPercentage }}%">
              <div class="w-full bg-black h-full rounded-t-sm"></div>
            </div>
            <div class="text-xs mt-2 text-gray-500">{{ $months[$month - 1] }}</div>
          </div>
        @endforeach
      </div>
    </div>
    
    <!-- Order Status Chart -->
    <div class="bg-white rounded-xl p-6 shadow">
      <h3 class="text-lg font-medium mb-6">Orders by Status</h3>
      <div class="flex items-center justify-center h-64">
        <div class="w-full max-w-md">
          @php
            $totalStatuses = array_sum($statusData);
            $colors = [
              'pending' => 'bg-blue-200',
              'processing' => 'bg-yellow-200',
              'shipped' => 'bg-purple-200',
              'delivered' => 'bg-green-200',
              'cancelled' => 'bg-red-200'
            ];
          @endphp
          
          @foreach($statusData as $status => $count)
            @if($totalStatuses > 0)
              @php $percentage = ($count / $totalStatuses) * 100; @endphp
              <div class="mb-4">
                <div class="flex items-center justify-between mb-1">
                  <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full mr-2 {{ $colors[$status] }}"></div>
                    <span class="text-sm capitalize">{{ $status }}</span>
                  </div>
                  <span class="text-sm text-gray-500">{{ $count }} ({{ number_format($percentage, 1) }}%)</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                  <div class="{{ $colors[$status] }} h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                </div>
              </div>
            @endif
          @endforeach
        </div>
      </div>
    </div>
  </div>
  
  <!-- Top Products Table -->
  <div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
      <h3 class="text-lg font-medium">Top Performing Products</h3>
    </div>
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Product
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Units Sold
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Revenue
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Average Price
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @forelse($topProducts as $product)
          <tr>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex items-center">
                @if($product->product && $product->product->image)
                <div class="flex-shrink-0 h-10 w-10">
                  <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $product->product->image) }}" alt="{{ $product->product->name ?? 'Product' }}">
                </div>
                @else
                <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                  <span class="text-xs text-gray-500">No</span>
                </div>
                @endif
                <div class="ml-4">
                  <div class="text-sm font-medium text-gray-900">
                    {{ $product->product->name ?? 'Unknown Product' }}
                  </div>
                  <div class="text-sm text-gray-500">
                    {{ $product->product->brand_name ?? 'Unknown Brand' }}
                  </div>
                </div>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              {{ $product->units_sold }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              £{{ number_format($product->revenue, 2) }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              £{{ number_format($product->units_sold > 0 ? $product->revenue / $product->units_sold : 0, 2) }}
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
              No product sales data available yet.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  
  <!-- Daily Revenue Chart (Last 30 days) -->
  <div class="bg-white rounded-xl p-6 shadow">
    <h3 class="text-lg font-medium mb-6">Daily Revenue (Last 30 Days)</h3>
    <div class="h-64">
      @if($dailyRevenue->count() > 0)
        <div class="flex items-end space-x-1 h-full">
          @php
            $maxDailyRevenue = $dailyRevenue->max('revenue');
            $maxDailyRevenue = $maxDailyRevenue > 0 ? $maxDailyRevenue : 1;
            
            // Get all dates in the last 30 days
            $dates = collect();
            for ($i = 0; $i < 30; $i++) {
                $date = Carbon\Carbon::now()->subDays($i)->format('Y-m-d');
                $dates->put($date, 0);
            }
            
            // Fill in the actual revenue
            foreach ($dailyRevenue as $day) {
                $dates[$day->date] = $day->revenue;
            }
            
            // Sort by date
            $dates = $dates->sortKeys();
          @endphp
          
          @foreach($dates as $date => $revenue)
            <div class="flex flex-col items-center flex-1">
              @php 
                $heightPercentage = ($revenue / $maxDailyRevenue) * 100;
                $formattedDate = Carbon\Carbon::parse($date)->format('d');
              @endphp
              <div class="w-full bg-gray-100 rounded-t-sm relative group" style="height: {{ $heightPercentage }}%">
                <div class="w-full bg-black h-full rounded-t-sm"></div>
                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 bg-black text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 whitespace-nowrap">
                  £{{ number_format($revenue, 2) }} on {{ Carbon\Carbon::parse($date)->format('M d') }}
                </div>
              </div>
              @if($loop->iteration % 5 == 0)
              <div class="text-xs mt-2 text-gray-500">{{ $formattedDate }}</div>
              @else
              <div class="text-xs mt-2 text-gray-500">·</div>
              @endif
            </div>
          @endforeach
        </div>
      @else
        <div class="flex items-center justify-center h-full text-gray-500">
          No daily revenue data available yet.
        </div>
      @endif
    </div>
  </div>
  
  <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
    <p class="text-gray-600 mb-3">Need help understanding your analytics?</p>
    <a href="#" class="text-black font-medium hover:underline">View Analytics Guide</a>
  </div>
</div>
@endsection