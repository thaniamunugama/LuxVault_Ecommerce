<div wire:key="cart-item-{{ $cartItem->cart_id }}" class="border-b last:border-b-0">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center py-4 px-6 hover:bg-gray-50">
        {{-- Product Image & Info (Mobile: Stacked, Desktop: Col 3) --}}
        <div class="md:col-span-3 flex items-center space-x-4">
            <div class="w-20 h-20 flex-shrink-0 overflow-hidden rounded-md">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                        <span class="text-xs text-gray-500">No Image</span>
                    </div>
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="text-base font-medium text-gray-900">{{ $product->name }}</h3>
                <p class="mt-1 text-sm text-gray-500">{{ $product->brand }}</p>
            </div>
        </div>

        {{-- Product Description (Desktop: Col 2) --}}
        <div class="md:col-span-2 hidden md:block">
            @if($product->description)
                <p class="text-sm text-gray-600">{{ Str::limit($product->description, 50) }}</p>
            @else
                <p class="text-sm text-gray-400">No description</p>
            @endif
        </div>

        {{-- Price (Desktop: Col 2, Right Aligned) --}}
        <div class="md:col-span-2 text-left md:text-right">
            <p class="text-base font-medium text-gray-900">${{ number_format($product->price, 2) }}</p>
            <p class="text-sm text-gray-500 font-semibold">${{ number_format($product->price * $quantity, 2) }} total</p>
        </div>

        {{-- Quantity Controls (Livewire) (Desktop: Col 3) --}}
        <div class="md:col-span-3">
            <div class="flex items-center border border-gray-300 rounded max-w-xs">
                <button 
                    wire:click="decrement" 
                    class="px-3 py-1 text-gray-600 hover:bg-gray-100 transition disabled:opacity-50 disabled:cursor-not-allowed"
                    @if($quantity <= 1) disabled @endif
                >
                    -
                </button>
                <input 
                    type="number" 
                    wire:model.live.debounce.500ms="quantity"
                    wire:change="updateQuantity($event.target.value)"
                    min="1" 
                    max="{{ $product->quantity }}" 
                    class="w-16 text-center border-l border-r border-gray-300 py-1 focus:outline-none focus:ring-2 focus:ring-black"
                >
                <button 
                    wire:click="increment" 
                    class="px-3 py-1 text-gray-600 hover:bg-gray-100 transition disabled:opacity-50 disabled:cursor-not-allowed"
                    @if($quantity >= $product->quantity) disabled @endif
                >
                    +
                </button>
            </div>
            @if($quantity > $product->quantity)
                <p class="text-xs text-red-600 mt-1">Max: {{ $product->quantity }}</p>
            @endif
        </div>

        {{-- Remove Button (Livewire) (Desktop: Col 2, Right Aligned) --}}
        <div class="md:col-span-2 text-left md:text-right">
            <button 
                wire:click="remove"
                wire:confirm="Are you sure you want to remove this item from your cart?"
                class="text-red-600 hover:text-red-800 transition inline-flex items-center"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                <span class="ml-2 md:hidden">Remove</span>
            </button>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <div class="px-4 pb-2">
            <p class="text-sm text-green-600">{{ session('success') }}</p>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="px-4 pb-2">
            <p class="text-sm text-red-600">{{ session('error') }}</p>
        </div>
    @endif
</div>
