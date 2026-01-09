@extends('customer.layout')

@section('dashboard-content')
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0">Profile Information</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('customer.profile.update') }}" method="POST">
            @csrf
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name', $customer->first_name) }}" required>
                    @error('first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name', $customer->last_name) }}" required>
                    @error('last_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $customer->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $customer->phone) }}">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $customer->address) }}">
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="city" class="form-label">City</label>
                    <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city', $customer->city) }}">
                    @error('city')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="postal_code" class="form-label">Postal Code</label>
                    <input type="text" class="form-control @error('postal_code') is-invalid @enderror" id="postal_code" name="postal_code" value="{{ old('postal_code', $customer->postal_code) }}">
                    @error('postal_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="country" class="form-label">Country</label>
                <input type="text" class="form-control @error('country') is-invalid @enderror" id="country" name="country" value="{{ old('country', $customer->country) }}">
                @error('country')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <hr class="my-4">
            
            <h6>Change Password</h6>
            <p class="text-muted small">Leave blank if you don't want to change your password</p>
            
            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>
            
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </div>
        </form>
    </div>
</div>
@endsection