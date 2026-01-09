<?php

namespace App\Livewire;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CartSummary extends Component
{
    public $subtotal = 0;
    public $total = 0;
    public $itemCount = 0;

    protected $listeners = ['cartUpdated' => 'updateTotals'];

    public function mount()
    {
        $this->updateTotals();
    }

    public function updateTotals()
    {
        if (!Auth::check()) {
            $this->subtotal = 0;
            $this->total = 0;
            $this->itemCount = 0;
            return;
        }

        $user = Auth::user();
        
        $cartItems = Cart::where('customer_id', $user->customer_id)
            ->with('product')
            ->get();

        // Calculate total quantity (sum of all item quantities)
        $this->itemCount = $cartItems->sum('quantity');

        // Calculate subtotal (sum of price * quantity for each item)
        $this->subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Total is same as subtotal (no shipping)
        $this->total = $this->subtotal;
    }

    public function render()
    {
        return view('livewire.cart-summary');
    }
}
