@extends('seller.dashboard')

@section('seller-content')
<div class="space-y-6">
  <div>
    <h1 class="text-2xl font-bold">Seller Profile</h1>
    <p class="text-gray-500">Update your account information and store details</p>
  </div>
  
  @if(session('success'))
  <div class="bg-green-50 border border-green-200 text-green-800 rounded-md p-4">
    {{ session('success') }}
  </div>
  @endif
  
  @if($errors->any())
  <div class="bg-red-50 border border-red-200 text-red-800 rounded-md p-4">
    <ul class="list-disc pl-5">
      @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
  
  <form action="{{ route('seller.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
    @csrf
    @method('PUT')
    
    <div class="bg-white shadow rounded-lg overflow-hidden">
      <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-900">Personal Information</h2>
      </div>
      <div class="p-6 space-y-6">
        <div class="flex items-center">
          <div class="flex-shrink-0 h-24 w-24 rounded-full overflow-hidden bg-gray-100 border">
            @if($seller->avatar)
            <img src="{{ asset('storage/' . $seller->avatar) }}" alt="{{ $seller->fname }}" class="h-full w-full object-cover">
            @else
            <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
              <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            @endif
          </div>
          <div class="ml-6">
            <label for="avatar" class="block text-sm font-medium text-gray-700">Profile Photo</label>
            <input type="file" name="avatar" id="avatar" class="mt-1 block">
            <p class="mt-1 text-sm text-gray-500">JPG, PNG or GIF. Max 2MB.</p>
          </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="fname" class="block text-sm font-medium text-gray-700">First Name</label>
            <input type="text" name="fname" id="fname" value="{{ old('fname', $seller->fname) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-black focus:border-black">
          </div>
          
          <div>
            <label for="lname" class="block text-sm font-medium text-gray-700">Last Name</label>
            <input type="text" name="lname" id="lname" value="{{ old('lname', $seller->lname) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-black focus:border-black">
          </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
            <input type="email" name="email" id="email" value="{{ old('email', $seller->email) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-black focus:border-black">
          </div>
          
          <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone', $seller->phone) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-black focus:border-black">
          </div>
        </div>
      </div>
    </div>
    
    <div class="bg-white shadow rounded-lg overflow-hidden">
      <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-900">Store Information</h2>
      </div>
      <div class="p-6 space-y-6">
        <div>
          <label for="store_name" class="block text-sm font-medium text-gray-700">Store Name</label>
          <input type="text" name="store_name" id="store_name" value="{{ old('store_name', $seller->store_name) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-black focus:border-black">
        </div>
        
        <div>
          <label for="description" class="block text-sm font-medium text-gray-700">Store Description</label>
          <textarea name="description" id="description" rows="5" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-black focus:border-black">{{ old('description', $seller->description) }}</textarea>
        </div>
        
        <div>
          <p class="block text-sm font-medium text-gray-700">Store Status</p>
          <div class="mt-2 flex items-center">
            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
              @if($seller->status == 'approved') bg-green-100 text-green-800
              @else bg-red-100 text-red-800 @endif">
              {{ ucfirst($seller->status) }}
            </span>
          </div>
        </div>
      </div>
    </div>
    
    <div class="bg-white shadow rounded-lg overflow-hidden">
      <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-900">Change Password</h2>
      </div>
      <div class="p-6 space-y-6">
        <div>
          <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
          <input type="password" name="current_password" id="current_password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-black focus:border-black">
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
            <input type="password" name="password" id="password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-black focus:border-black">
          </div>
          
          <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-black focus:border-black">
          </div>
        </div>
        <p class="text-sm text-gray-500">Leave password fields empty if you don't want to change it.</p>
      </div>
    </div>
    
    <div class="flex justify-end">
      <button type="submit" class="px-6 py-3 bg-black text-white font-medium rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
        Save Changes
      </button>
    </div>
  </form>
</div>
@endsection