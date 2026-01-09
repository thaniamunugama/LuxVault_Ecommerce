@extends('customer.layout')

@section('dashboard-content')
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0">My Wishlist</h5>
    </div>
    <div class="card-body p-0">
        @if($wishlistItems->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 100px;">Image</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th style="width: 180px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wishlistItems as $item)
                        <tr>
                            <td>
                                @if($item->product && $item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="img-thumbnail" style="max-width: 80px;">
                                @else
                                    <div class="w-20 h-20 bg-gray-200 flex items-center justify-center">
                                        <span class="text-xs text-gray-500">No Image</span>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('product.detail', $item->product->id) }}" class="text-decoration-none">
                                    <h6 class="mb-0">{{ $item->product->name }}</h6>
                                    <small class="text-muted">{{ $item->product->brand }}</small>
                                </a>
                            </td>
                            <td>${{ number_format($item->product->price, 2) }}</td>
                            <td>
                                @if($item->product->quantity > 0)
                                    <span class="badge bg-success">In Stock</span>
                                @else
                                    <span class="badge bg-danger">Out of Stock</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <form action="{{ route('wishlist.move-to-cart') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                        <button type="submit" class="btn btn-sm btn-primary me-2" {{ $item->product->quantity > 0 ? '' : 'disabled' }}>
                                            <i class="bi bi-cart-plus me-1"></i> Add to Cart
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('wishlist.remove') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash me-1"></i> Remove
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <img src="{{ asset('images/empty-wishlist.svg') }}" alt="Empty Wishlist" class="img-fluid mb-3" style="max-width: 200px;">
                <h5>Your Wishlist is Empty</h5>
                <p class="text-muted">Save items you like by clicking the heart icon on products.</p>
                <a href="{{ route('products') }}" class="btn btn-primary">Start Shopping</a>
            </div>
        @endif
    </div>
</div>
@endsection