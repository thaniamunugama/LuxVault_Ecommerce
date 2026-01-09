# Livewire Implementation Documentation

## Overview
This project uses Laravel Livewire for dynamic, real-time user interactions without writing custom JavaScript. Livewire is used for functional requirements beyond Jetstream's default components.

## Livewire Components Implemented

### 1. ProductFilter Component
**Location:** `app/Livewire/ProductFilter.php`  
**View:** `resources/views/livewire/product-filter.blade.php`  
**Usage:** `@livewire('product-filter')` in `resources/views/products.blade.php`

**Functionality:**
- **Real-time Product Filtering** - Filters products as you type (debounced)
- **Dynamic Brand Filtering** - Instant brand filtering without page refresh
- **Price Range Filtering** - Filter by minimum and maximum price
- **Live Sorting** - Sort by newest, price (low/high), name (A-Z/Z-A)
- **Active Filters Display** - Shows currently applied filters
- **Clear Filters** - One-click filter reset
- **Pagination** - Livewire pagination that works with filters

**Features:**
- Uses `wire:model.live` for real-time updates
- Debounced search (300ms) to reduce server requests
- Query string persistence (filters persist in URL)
- Auto-reset pagination when filters change

**Database:**
- Uses existing `products` table
- No new tables added
- Queries filtered by `quantity > 0` (only in-stock items)

---

### 2. CartItem Component
**Location:** `app/Livewire/CartItem.php`  
**View:** `resources/views/livewire/cart-item.blade.php`  
**Usage:** `@livewire('cart-item', ['cartItem' => $item])` in `resources/views/cart.blade.php`

**Functionality:**
- **Real-time Quantity Updates** - Update cart quantity without page refresh
- **Increment/Decrement Buttons** - Live +/- buttons for quantity
- **Direct Input Updates** - Type quantity directly (debounced 500ms)
- **Stock Validation** - Prevents ordering more than available stock
- **Remove Item** - Remove items from cart with confirmation
- **Auto-refresh Totals** - Cart totals update automatically

**Features:**
- Uses `wire:click` for button actions
- Uses `wire:model.live.debounce` for input updates
- Emits `cartUpdated` event to refresh parent component
- Validates against product stock quantity
- Shows success/error flash messages

**Database:**
- Uses existing `cart` table
- Updates `quantity` column in existing table
- No new tables added

---

## Integration Points

### Products Page (`/products`)
- Replaced static filtering with Livewire `ProductFilter` component
- Provides real-time search, filtering, and sorting
- No page refresh required for any filter changes

### Cart Page (`/cart`)
- Each cart item is a Livewire `CartItem` component
- Real-time quantity updates without form submission
- Instant removal of items
- Auto-refreshes cart totals

---

## Technical Details

### Livewire Features Used:
1. **`wire:model.live`** - Two-way data binding with live updates
2. **`wire:click`** - Button click handlers
3. **`wire:confirm`** - Confirmation dialogs
4. **`wire:key`** - Component keying for proper re-rendering
5. **`$this->dispatch()`** - Event broadcasting
6. **`WithPagination`** - Pagination trait
7. **Query String Binding** - URL state persistence

### Database Operations:
- All operations use existing tables
- No new migrations required
- Updates existing `cart` table `quantity` column
- Queries existing `products` table

### Security:
- Authentication checks in all Livewire methods
- CSRF protection via Livewire's built-in security
- Input validation and sanitization
- Stock quantity validation

---

## Benefits

1. **Better User Experience** - No page refreshes for filtering/cart updates
2. **Reduced Server Load** - Debounced requests reduce unnecessary queries
3. **Real-time Updates** - Instant feedback on user actions
4. **Maintainable Code** - Server-side logic, no custom JavaScript needed
5. **Assignment Requirement** - Demonstrates functional use of Livewire beyond Jetstream

---

## Testing

To test the Livewire components:

1. **Product Filter:**
   - Visit `/products`
   - Type in search box - products filter instantly
   - Select brand - products filter without refresh
   - Change price range - products update live
   - Change sort order - products reorder instantly

2. **Cart Updates:**
   - Add items to cart
   - Visit `/cart`
   - Click +/- buttons - quantity updates without page refresh
   - Type quantity directly - updates after 500ms
   - Click remove - item removed with confirmation
   - Cart totals refresh automatically

---

## Files Modified/Created

### Created:
- `app/Livewire/ProductFilter.php`
- `app/Livewire/CartItem.php`
- `resources/views/livewire/product-filter.blade.php`
- `resources/views/livewire/cart-item.blade.php`

### Modified:
- `resources/views/products.blade.php` - Now uses Livewire component
- `resources/views/cart.blade.php` - Now uses Livewire components
- `routes/web.php` - Updated products route to use Livewire view

### No Database Changes:
- ✅ No new tables added
- ✅ Only updates existing `cart` table `quantity` column
- ✅ Uses existing `products` table for filtering

