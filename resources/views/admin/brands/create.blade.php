@extends('admin.dashboard')

@section('admin-content')
<h1 class="text-2xl font-bold mb-6">Add Brand</h1>
<div class="bg-white rounded-xl shadow-sm p-6 max-w-xl">
  <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf
    <div>
      <label class="block text-sm font-medium text-gray-700">Name</label>
      <input type="text" name="name" class="mt-1 w-full border rounded px-3 py-2" required />
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700">Image</label>
      <input type="file" name="image" accept="image/*" class="mt-1 w-full border rounded px-3 py-2" />
    </div>
    <div class="pt-2">
      <button type="submit" class="px-4 py-2 bg-black text-white rounded">Create</button>
      <a href="{{ route('admin.brands.index') }}" class="ml-2 px-4 py-2 border rounded">Cancel</a>
    </div>
  </form>
 </div>
@endsection
