@extends('seller.dashboard')

@section('seller-content')
<div class="mb-8">
  <h2 class="text-2xl font-bold mb-4">Total Revenue</h2>
  <div class="bg-white rounded-lg shadow p-8 flex flex-col items-center justify-center">
    <img src="{{ asset('images/revenue.png') }}" alt="Revenue" class="h-24 w-auto mb-6">
    <div class="text-4xl font-bold text-green-600 mb-2">£15,200</div>
    <div class="text-lg text-gray-600">Total revenue from all completed orders</div>
  </div>
</div>
@endsection
