{{-- FOOTER --}}
<footer class="mt-16 bg-black text-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10 items-start">
            <div><img src="{{ asset('images/logo-white.png') }}" class="h-16 md:h-20" alt="Luxe Vault"></div>

            <div>
                <h3 class="font-semibold mb-3">Navigate</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:underline text-white">Home</a></li>
                    <li><a href="{{ route('about') }}" class="hover:underline text-white">About Us</a></li>
                    <li><a href="{{ route('products') }}" class="hover:underline text-white">All Products</a></li>
                </ul>
            </div>

            <div>
                <h3 class="font-semibold mb-3">Our Products</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('brands.chanel') }}" class="hover:underline text-white">Chanel</a></li>
                    <li><a href="{{ route('brands.hermes') }}" class="hover:underline text-white">Hermès</a></li>
                    <li><a href="{{ route('brands.ysl') }}" class="hover:underline text-white">YSL</a></li>
                    <li><a href="{{ route('brands.coach') }}" class="hover:underline text-white">Coach</a></li>
                </ul>
            </div>

            <div class="flex gap-4 md:justify-end">
                <img src="{{ asset('images/twitter.png') }}" class="h-8 w-8" alt="X">
                <img src="{{ asset('images/instagram.png') }}" class="h-8 w-8" alt="Instagram">
                <img src="{{ asset('images/facebook.png') }}" class="h-8 w-8" alt="Facebook">
                <img src="{{ asset('images/tik-tok.png') }}" class="h-8 w-8" alt="TikTok">
            </div>
        </div>
    </div>
</footer>

