@extends('customer.layout')

@section('dashboard-content')
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0">Dashboard</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card bg-light">
                    <div class="card-body text-center py-4">
                        <h6 class="text-muted mb-2">Recent Orders</h6>
                        <h2 class="mb-0">{{ $recentOrders->count() }}</h2>
                        <a href="{{ route('customer.orders') }}" class="btn btn-sm btn-outline-primary mt-3">View All Orders</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($recentOrders->count() > 0)
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Recent Orders</h5>
        <a href="{{ route('customer.orders') }}" class="btn btn-sm btn-outline-primary">View All</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                        <td>
                            @if($order->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($order->status == 'processing')
                                <span class="badge bg-info">Processing</span>
                            @elseif($order->status == 'shipped')
                                <span class="badge bg-primary">Shipped</span>
                            @elseif($order->status == 'delivered')
                                <span class="badge bg-success">Delivered</span>
                            @elseif($order->status == 'cancelled')
                                <span class="badge bg-danger">Cancelled</span>
                            @endif
                        </td>
                        <td>${{ number_format($order->total_amount, 2) }}</td>
                        <td>
                            <a href="{{ route('customer.orders.detail', $order->order_id) }}" class="btn btn-sm btn-outline-secondary">
                                View
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@else
<div class="alert alert-info">
    <p class="mb-0">You haven't placed any orders yet. <a href="{{ route('products') }}">Start shopping now</a>.</p>
</div>
@endif
@endsection