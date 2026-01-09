<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CartItem extends Component
{
    public $cartItem;
    public $quantity;
    public $product;

    public function mount($cartItem)
    {
        $this->cartItem = $cartItem;
        $this->quantity = $cartItem->quantity;
        $this->product = $cartItem->product;
    }

    public function increment()
    {
        if (!Auth::check()) {
            session()->flash('error', 'Please log in to update cart.');
            return;
        }

        $user = Auth::user();
        $maxQuantity = $this->product->quantity;

        if ($this->quantity < $maxQuantity) {
            $this->quantity++;
            $this->updateCart();
        } else {
            session()->flash('error', "Only {$maxQuantity} items available in stock.");
        }
    }

    public function decrement()
    {
        if (!Auth::check()) {
            session()->flash('error', 'Please log in to update cart.');
            return;
        }

        if ($this->quantity > 1) {
            $this->quantity--;
            $this->updateCart();
        }
    }

    public function updatedQuantity($value)
    {
        // This is called automatically when quantity property changes via wire:model.live
        if (Auth::check()) {
            $newQuantity = (int)$value;
            $maxQuantity = $this->product->quantity;

            if ($newQuantity < 1) {
                $newQuantity = 1;
                $this->quantity = 1;
            } elseif ($newQuantity > $maxQuantity) {
                $newQuantity = $maxQuantity;
                $this->quantity = $maxQuantity;
                session()->flash('error', "Only {$maxQuantity} items available in stock.");
            }

            $this->updateCart();
        }
    }

    public function updateQuantity($newQuantity)
    {
        if (!Auth::check()) {
            session()->flash('error', 'Please log in to update cart.');
            return;
        }

        $newQuantity = (int)$newQuantity;
        $maxQuantity = $this->product->quantity;

        if ($newQuantity < 1) {
            $newQuantity = 1;
        } elseif ($newQuantity > $maxQuantity) {
            $newQuantity = $maxQuantity;
            session()->flash('error', "Only {$maxQuantity} items available in stock.");
        }

        $this->quantity = $newQuantity;
        $this->updateCart();
    }

    protected function updateCart()
    {
        $user = Auth::user();
        
        $cartItem = Cart::where('customer_id', $user->customer_id)
            ->where('product_id', $this->product->product_id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity = $this->quantity;
            $cartItem->save();
            
            session()->flash('success', 'Cart updated successfully!');
            
            // Refresh the cart item
            $this->cartItem = $cartItem->fresh(['product']);
            
            // Emit event to refresh cart summary totals (Livewire component)
            $this->dispatch('cartUpdated');
        }
    }

    public function remove()
    {
        if (!Auth::check()) {
            session()->flash('error', 'Please log in to remove items.');
            return;
        }

        $user = Auth::user();
        
        Cart::where('customer_id', $user->customer_id)
            ->where('product_id', $this->product->product_id)
            ->delete();

        session()->flash('success', 'Item removed from cart.');
        
        // Emit event to refresh cart summary totals
        $this->dispatch('cartUpdated');
        
        // Redirect to refresh the page and update cart items list
        return redirect()->route('cart');
    }

    public function render()
    {
        return view('livewire.cart-item');
    }
}
