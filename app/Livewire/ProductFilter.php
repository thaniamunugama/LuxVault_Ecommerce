<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductFilter extends Component
{
    use WithPagination;

    public $search = '';
    public $brand = '';
    public $sort = 'newest';
    public $minPrice = '';
    public $maxPrice = '';
    public $hideBrandFilter = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'brand' => ['except' => ''],
        'sort' => ['except' => 'newest'],
        'minPrice' => ['except' => ''],
        'maxPrice' => ['except' => ''],
    ];

    public function mount($defaultBrand = null, $hideBrandFilter = false)
    {
        $this->hideBrandFilter = $hideBrandFilter;
        if ($defaultBrand && empty($this->brand)) {
            $this->brand = $defaultBrand;
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingBrand()
    {
        $this->resetPage();
    }

    public function updatingSort()
    {
        $this->resetPage();
    }

    public function updatingMinPrice()
    {
        $this->resetPage();
    }

    public function updatingMaxPrice()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        if (!$this->hideBrandFilter) {
            $this->brand = '';
        }
        $this->sort = 'newest';
        $this->minPrice = '';
        $this->maxPrice = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = Product::where('quantity', '>', 0);

        // Apply search filter
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Apply brand filter
        if (!empty($this->brand)) {
            $query->where('brand', $this->brand);
        }

        // Apply price filters
        if (!empty($this->minPrice)) {
            $query->where('price', '>=', $this->minPrice);
        }

        if (!empty($this->maxPrice)) {
            $query->where('price', '<=', $this->maxPrice);
        }

        // Apply sorting
        switch ($this->sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->paginate(12);

        $brands = ['Hermès', 'Chanel', 'Coach', 'YSL'];

        return view('livewire.product-filter', [
            'products' => $products,
            'brands' => $brands,
        ]);
    }
}
