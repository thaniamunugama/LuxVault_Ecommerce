@extends('admin.dashboard')

@section('admin-content')
<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold">Brands</h1>
    <a href="{{ route('admin.brands.create') }}" class="px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800">Add Brand</a>
  </div>

  <div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
          <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @foreach($brands as $brand)
        <tr>
          <td class="px-6 py-4">{{ $brand->brand_id }}</td>
          <td class="px-6 py-4">{{ $brand->name }}</td>
          <td class="px-6 py-4">
            @if($brand->image)
              <img src="{{ asset('storage/' . $brand->image) }}" alt="{{ $brand->name }}" class="h-10 w-10 object-contain" />
            @else
              <span class="text-gray-400 text-sm">No image</span>
            @endif
          </td>
          <td class="px-6 py-4 text-right text-sm">
            <a href="{{ route('admin.brands.edit', $brand) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
            <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" class="inline" onsubmit="return confirm('Delete this brand?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="p-4">{{ $brands->links() }}</div>
  </div>
@endsection
