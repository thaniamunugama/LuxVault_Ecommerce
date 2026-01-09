@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">My Account</h5>
                    <div class="d-flex align-items-center mb-4">
                        <div class="flex-shrink-0">
                            <div class="avatar-placeholder bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                @php $customer = Auth::user(); @endphp
                                @if($customer)
                                    {{ strtoupper(substr($customer->fname, 0, 1)) }}{{ strtoupper(substr($customer->lname, 0, 1)) }}
                                @endif
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            @if($customer)
                                <p class="m-0">{{ $customer->fname }} {{ $customer->lname }}</p>
                                <small class="text-muted">{{ $customer->email }}</small>
                            @endif
                        </div>
                    </div>
                    
                    <div class="list-group list-group-flush">
                        <a href="{{ route('customer.orders') }}" class="list-group-item list-group-item-action {{ request()->routeIs('customer.orders*') ? 'active' : '' }}">
                            <i class="bi bi-box-seam me-2"></i> My Orders
                        </a>
                        <a href="{{ route('wishlist') }}" class="list-group-item list-group-item-action {{ request()->routeIs('wishlist') ? 'active' : '' }}">
                            <i class="bi bi-heart me-2"></i> My Wishlist
                        </a>
                        <form action="{{ route('customer.logout') }}" method="POST" class="mt-3">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-lg-9">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @yield('dashboard-content')
        </div>
    </div>
</div>
@endsection