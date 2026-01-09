@extends('customer.layout')

@section('dashboard-content')
<div class="bg-white shadow-sm rounded-lg overflow-hidden mb-6">
    <div class="border-b border-gray-200 px-6 py-4 flex justify-between items-center">
        <h2 class="text-xl font-bold">Write a Review</h2>
        <a href="{{ route('customer.orders.detail', $order->order_id) }}" class="inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
            <svg class="mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Order
        </a>
    </div>
    
    <div class="px-6 py-4">
        <p class="text-gray-600 mb-6">Your feedback helps other shoppers make better purchase decisions and helps us improve our products.</p>
        
        @if ($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Please correct the following errors:</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        <div class="mb-6">
            <h3 class="text-lg font-medium mb-4">Select a product to review</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($order->items as $item)
                <div class="border rounded-lg p-4 cursor-pointer hover:border-indigo-500 transition-colors" 
                     onclick="selectProduct('{{ $item->product->product_id }}', '{{ $item->product->name }}')">
                    <div class="flex items-center">
                        <div class="w-16 h-16 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                            @if($item->product && $item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            @elseif($item->product && $item->product->image_path)
                                <img src="{{ asset('storage/' . $item->product->image_path) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400 text-xs">No Image</span>
                                </div>
                            @endif
                        </div>
                        <div class="ml-4 flex-1">
                            <h4 class="text-sm font-medium text-gray-900">{{ $item->product->name }}</h4>
                            <p class="mt-1 text-sm text-gray-500">{{ $item->product->brand_name ?? $item->product->brand ?? 'Luxury Brand' }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <form id="reviewForm" action="{{ route('customer.review.store') }}" method="POST" class="hidden">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->order_id }}">
            <input type="hidden" id="product_id" name="product_id" value="">
            
            <div class="mb-6">
                <h3 id="selectedProductName" class="text-lg font-medium mb-2"></h3>
                <p class="text-sm text-gray-600">You purchased this item on {{ $order->created_at->format('M d, Y') }}</p>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Your Rating</label>
                <div class="flex items-center space-x-1">
                    @for ($i = 1; $i <= 5; $i++)
                    <button type="button" data-rating="{{ $i }}" class="rating-star text-gray-300 hover:text-yellow-400">
                        <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M12 17.27l-5.27 3.18 1.38-5.83-4.24-3.67 5.88-.51 2.25-5.36 2.25 5.36 5.88.51-4.24 3.67 1.38 5.83z"/>
                        </svg>
                    </button>
                    @endfor
                </div>
                <input type="hidden" id="rating" name="rating" required>
            </div>
            
            <div class="mb-6">
                <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Your Review</label>
                <textarea id="comment" name="comment" rows="4" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Share your experience with this product..."></textarea>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Submit Review
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function selectProduct(productId, productName) {
    document.getElementById('product_id').value = productId;
    document.getElementById('selectedProductName').textContent = 'Writing review for: ' + productName;
    document.getElementById('reviewForm').classList.remove('hidden');
    // Scroll to the form
    document.getElementById('reviewForm').scrollIntoView({ behavior: 'smooth' });
}

// Handle star rating
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.rating-star');
    const ratingInput = document.getElementById('rating');
    
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-rating');
            ratingInput.value = rating;
            
            // Update star colors
            stars.forEach(s => {
                const starRating = s.getAttribute('data-rating');
                if (starRating <= rating) {
                    s.classList.remove('text-gray-300');
                    s.classList.add('text-yellow-400');
                } else {
                    s.classList.remove('text-yellow-400');
                    s.classList.add('text-gray-300');
                }
            });
        });
    });
});
</script>
@endsection