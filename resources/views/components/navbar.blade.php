{{-- HEADER --}}
<header class="sticky top-0 z-40 bg-white/70 backdrop-blur-md shadow-sm">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 h-24 flex items-center justify-between">
        {{-- Menu Icon --}}
        <button id="btn-menu" class="p-2" aria-label="Open menu">
            <img src="{{ asset('images/menu1.png') }}" class="h-4 w-4" alt="menu">
        </button>

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="inline-flex">
            <img src="{{ asset('images/logo- black.png') }}" class="h-20" alt="Luxe Vault">
        </a>

        {{-- Right Side (Profile + Cart) --}}
        <div class="flex items-center gap-4 relative">
            {{-- Profile Dropdown --}}
            <div class="relative">
                <button id="pfpToggle" class="p-2 rounded-full focus:outline-none">
                    <img src="{{ asset('images/pfp-b.png') }}" class="h-7 w-7 rounded-full" alt="account">
                </button>
                <div id="pfpDropdown" class="absolute right-0 mt-2 w-48 bg-white border rounded shadow-lg hidden z-50" onclick="event.stopPropagation()">
                    @auth
                        <a href="{{ route('customer.orders') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">My Orders</a>
                        <div class="border-t border-gray-100"></div>
                        <form method="POST" action="{{ route('customer.logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">Sign Out</button>
                        </form>
                    @else
                        <button onclick="openLoginModal(); event.stopPropagation();" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">Sign In</button>
                        <button onclick="openRegisterModal(); event.stopPropagation();" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">Register</button>
                    @endif
                </div>
            </div>

            {{-- Cart Icon --}}
            <a class="p-2 relative" href="{{ route('cart') }}">
                <img src="{{ asset('images/cart1.png') }}" class="h-7 w-7" alt="cart">
                @auth
                    @php
                        $customerId = Auth::user()->customer_id ?? Auth::id();
                        $cartCount = \App\Models\Cart::where('customer_id', $customerId)->sum('quantity') ?? 0;
                    @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-1 -right-1 bg-black text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $cartCount }}</span>
                    @endif
                @endauth
            </a>
        </div>
    </div>
</header>

{{-- MOBILE SLIDE-IN MENU --}}
<div id="mobileMenu" class="fixed inset-0 z-50 hidden">
    <div id="menuOverlay" class="absolute inset-0 bg-black/50"></div>
    <aside id="menuPanel"
                 class="absolute left-0 top-0 h-full w-80 max-w-[85%] bg-white shadow-xl translate-x-[-100%] transition-transform duration-300">
        <div class="flex items-center justify-between px-4 h-16 border-b">
            <span class="font-semibold">Menu</span>
            <button id="btn-menu-close" class="p-2" aria-label="Close menu">
                <img src="{{ asset('images/close.png') }}" class="h-6 w-6" alt="close">
            </button>
        </div>
        <nav class="p-4 text-sm" onclick="event.stopPropagation()">
            <ul class="space-y-1">
                <li><a href="{{ route('home') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Home</a></li>

                {{-- Products Dropdown --}}
                <li>
                    <button id="btn-products"
                                    class="w-full flex items-center justify-between px-3 py-2 rounded hover:bg-gray-100"
                                    aria-expanded="false" aria-controls="submenu-products">
                        <span>Products</span>
                        <img src="{{ asset('images/right.png') }}" class="h-4 w-4 rotate-90 transition-transform" id="products-caret" alt="">
                    </button>
                    <ul id="submenu-products" class="mt-1 ml-3 hidden border-l pl-3 space-y-1">
                        <li><a href="{{ route('products') }}" class="block px-3 py-2 rounded hover:bg-gray-100">All Products</a></li>
                        <li><a href="{{ route('brands.chanel') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Chanel</a></li>
                        <li><a href="{{ route('brands.hermes') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Hermès</a></li>
                        <li><a href="{{ route('brands.ysl') }}" class="block px-3 py-2 rounded hover:bg-gray-100">YSL</a></li>
                        <li><a href="{{ route('brands.coach') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Coach</a></li>
                    </ul>
                </li>

                <li><a href="{{ route('about') }}" class="block px-3 py-2 rounded hover:bg-gray-100">About Us</a></li>
                <li><a href="{{ route('cart') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Cart</a></li>
            </ul>
        </nav>
    </aside>
</div>

{{-- JavaScript to handle dropdown --}}
<script>
    document.getElementById('pfpToggle')?.addEventListener('click', function (e) {
        e.stopPropagation(); // Prevent bubbling
        const dropdown = document.getElementById('pfpDropdown');
        dropdown.classList.toggle('hidden');
    });

    // Only close dropdown when clicking outside, never interfere with links
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('pfpDropdown');
        const toggle = document.getElementById('pfpToggle');
        
        // If clicking on a link, let it navigate immediately - don't interfere at all
        const link = e.target.closest('a');
        if (link && link.href && link.href !== '#') {
            // Close dropdown if clicking outside, but don't prevent navigation
            if (dropdown && toggle && !toggle.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
            // Don't prevent default - let link navigate immediately
            return;
        }
        
        // Close dropdown if clicking outside (but not on links)
        if (dropdown && toggle && !toggle.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    }, false); // Use bubble phase
</script>
