<div class="bg-white rounded-lg shadow-sm p-6 sticky top-6">
    <h2 class="text-lg font-semibold mb-6">Order Summary</h2>

    <div class="space-y-4 mb-6">
        <div class="flex justify-between">
            <p class="text-gray-600">Subtotal ({{ $itemCount }} {{ $itemCount == 1 ? 'item' : 'items' }})</p>
            <p class="font-medium">${{ number_format($subtotal, 2) }}</p>
        </div>
        <div class="flex justify-between">
            <p class="text-gray-600">Shipping</p>
            <p class="font-medium">Free</p>
        </div>
        <div class="border-t pt-4 flex justify-between">
            <p class="font-semibold">Total</p>
            <p class="font-semibold">${{ number_format($total, 2) }}</p>
        </div>
    </div>

    @if($itemCount > 0)
    <a href="{{ route('checkout') }}" class="block w-full bg-black text-white text-center py-3 rounded-lg font-semibold hover:bg-gray-800 transition">
        PROCEED TO CHECKOUT
    </a>
    @else
    <button disabled class="w-full bg-gray-300 text-gray-500 py-3 rounded-lg font-semibold cursor-not-allowed">
        PROCEED TO CHECKOUT
    </button>
    @endif

    <div class="mt-6">
        <div class="flex items-center justify-center space-x-4 text-gray-500">
            <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M4 4C2.89543 4 2 4.89543 2 6V18C2 19.1046 2.89543 20 4 20H20C21.1046 20 22 19.1046 22 18V6C22 4.89543 21.1046 4 20 4H4Z"/></svg>
            <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M2.5 3H21.5L12 18L2.5 3Z"/></svg>
            <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M21 4H3C1.89 4 1 4.89 1 6V18C1 19.11 1.89 20 3 20H21C22.11 20 23 19.11 23 18V6C23 4.89 22.11 4 21 4Z"/></svg>
            <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M5 3H19C20.1046 3 21 3.89543 21 5V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V5C3 3.89543 3.89543 3 5 3Z"/></svg>
        </div>
        <p class="text-xs text-center mt-4 text-gray-500">
            Secure Payment Processing • All transactions are encrypted
        </p>
    </div>
</div>
