@extends('layouts.app')


@section('content')
<section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-10 pb-6">
  <div class="text-center mb-8">
    <h1 class="text-2xl md:text-3xl font-bold tracking-wide uppercase">YSL HANDBAGS</h1>
  </div>

  {{-- Livewire Product Filter Component --}}
  @livewire('product-filter', ['defaultBrand' => 'YSL', 'hideBrandFilter' => true])
</section>
@endsection