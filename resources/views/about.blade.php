@extends('layouts.app')

@section('content')
  {{-- HERO BANNER --}}
  <section class="relative">
    <img src="{{ asset('images/aboutus-banner.png') }}" class="w-full h-[400px] md:h-[500px] object-cover" alt="About Us Banner">
    <div class="absolute inset-0 bg-black/40"></div>
    <div class="absolute inset-0 flex items-center">
      <div class="mx-auto max-w-4xl px-6 text-center text-white">
        <h1 class="text-3xl md:text-5xl font-semibold mb-4">About Luxe Vault</h1>
        <p class="text-base md:text-lg leading-relaxed max-w-2xl mx-auto">
          Where timeless luxury meets authentic craftsmanship
        </p>
      </div>
    </div>
  </section>

  {{-- OUR STORY --}}
  <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 md:py-24">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
      <div>
        <h2 class="text-2xl md:text-3xl font-semibold mb-6 tracking-wide">Our Story</h2>
        <div class="space-y-4 text-gray-700 leading-relaxed">
          <p>
            Founded with a passion for authentic luxury, Luxe Vault emerged as a trusted destination for discerning collectors and fashion enthusiasts. We understand that a luxury handbag is more than an accessory—it's an investment, a statement, and a piece of art.
          </p>
          <p>
            Our journey began with a simple mission: to make authentic designer handbags accessible while ensuring every piece meets the highest standards of quality and authenticity. Each item in our collection is carefully curated and authenticated by our team of certified experts.
          </p>
          <p>
            Today, we're proud to offer an extensive collection from the world's most prestigious brands, including Chanel, Hermès, YSL, and Coach. Every handbag tells a story, and we're here to help you find yours.
          </p>
        </div>
      </div>
      <div class="relative">
        <img src="{{ asset('images/aboutus-1.png') }}" class="w-full rounded-2xl object-cover shadow-lg" alt="Our Story">
      </div>
    </div>
  </section>

  {{-- OUR VALUES --}}
  <section class="bg-gray-50 py-16 md:py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12">
        <h2 class="text-2xl md:text-3xl font-semibold mb-4 tracking-wide">Our Values</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">
          The principles that guide everything we do
        </p>
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        {{-- Authenticity --}}
        <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-lg transition duration-300">
          <div class="w-16 h-16 bg-black rounded-xl flex items-center justify-center mb-6">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-semibold mb-3">Authenticity Guaranteed</h3>
          <p class="text-gray-600 leading-relaxed">
            Every item undergoes rigorous authentication by our certified experts. We stand behind the authenticity of every piece in our collection.
          </p>
        </div>

        {{-- Curation --}}
        <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-lg transition duration-300">
          <div class="w-16 h-16 bg-black rounded-xl flex items-center justify-center mb-6">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-semibold mb-3">Curated Selection</h3>
          <p class="text-gray-600 leading-relaxed">
            We hand-pick each product to ensure our collection features only the most desirable and timeless luxury pieces from renowned designers.
          </p>
        </div>

        {{-- Service --}}
        <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-lg transition duration-300">
          <div class="w-16 h-16 bg-black rounded-xl flex items-center justify-center mb-6">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-semibold mb-3">Exceptional Service</h3>
          <p class="text-gray-600 leading-relaxed">
            Our dedicated team provides personalized assistance, expert guidance, and unwavering support throughout your luxury shopping journey.
          </p>
        </div>
      </div>
    </div>
  </section>

  {{-- WHY CHOOSE US --}}
  <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 md:py-24">
    <div class="text-center mb-12">
      <h2 class="text-2xl md:text-3xl font-semibold mb-4 tracking-wide">Why Choose Luxe Vault</h2>
      <p class="text-gray-600 max-w-2xl mx-auto">
        Experience the difference of shopping with a trusted luxury partner
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="text-center p-6">
        <div class="w-20 h-20 bg-black rounded-full flex items-center justify-center mx-auto mb-4">
          <span class="text-white text-2xl font-bold">100%</span>
        </div>
        <h3 class="font-semibold mb-2">Authentic</h3>
        <p class="text-sm text-gray-600">Every item verified by experts</p>
      </div>

      <div class="text-center p-6">
        <div class="w-20 h-20 bg-black rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
        </div>
        <h3 class="font-semibold mb-2">Insured</h3>
        <p class="text-sm text-gray-600">Full protection on every purchase</p>
      </div>

      <div class="text-center p-6">
        <div class="w-20 h-20 bg-black rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
          </svg>
        </div>
        <h3 class="font-semibold mb-2">Ready to Ship</h3>
        <p class="text-sm text-gray-600">Fast and secure delivery</p>
      </div>

      <div class="text-center p-6">
        <div class="w-20 h-20 bg-black rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <h3 class="font-semibold mb-2">Expert Support</h3>
        <p class="text-sm text-gray-600">Personalized guidance always</p>
      </div>
    </div>
  </section>

  {{-- MISSION & VISION --}}
  <section class="bg-black text-white py-16 md:py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <div>
          <h2 class="text-2xl md:text-3xl font-semibold mb-6 tracking-wide">Our Mission</h2>
          <p class="text-gray-300 leading-relaxed mb-4">
            To democratize access to authentic luxury handbags while maintaining the highest standards of quality, authenticity, and customer service. We believe everyone deserves to own a piece of timeless luxury.
          </p>
          <p class="text-gray-300 leading-relaxed">
            Through our rigorous authentication process and curated selection, we ensure that every customer receives not just a handbag, but a piece of art that will be cherished for generations.
          </p>
        </div>
        <div>
          <h2 class="text-2xl md:text-3xl font-semibold mb-6 tracking-wide">Our Vision</h2>
          <p class="text-gray-300 leading-relaxed mb-4">
            To become the world's most trusted destination for authentic luxury handbags, recognized for our unwavering commitment to authenticity, exceptional curation, and unparalleled customer experience.
          </p>
          <p class="text-gray-300 leading-relaxed">
            We envision a future where luxury is accessible, transparent, and sustainable—where every purchase is an investment in quality and craftsmanship.
          </p>
        </div>
      </div>
    </div>
  </section>

  {{-- IMAGE GALLERY SECTION --}}
  <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 md:py-24">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
        <img src="{{ asset('images/abtus_img3.png') }}" class="w-full h-[300px] md:h-[400px] object-cover rounded-2xl shadow-lg" alt="Luxe Vault Collection">
      </div>
      <div>
        <img src="{{ asset('images/aboutus2.jpg') }}" class="w-full h-[300px] md:h-[400px] object-cover rounded-2xl shadow-lg" alt="Luxe Vault Experience">
      </div>
    </div>
  </section>

  {{-- CTA SECTION --}}
  <section class="bg-gray-50 py-16 md:py-24">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center">
      <h2 class="text-2xl md:text-3xl font-semibold mb-4 tracking-wide">Ready to Discover Your Perfect Handbag?</h2>
      <p class="text-gray-600 mb-8 max-w-2xl mx-auto">
        Explore our curated collection of authentic luxury handbags and find the piece that speaks to you.
      </p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ route('products') }}" class="px-8 py-3 bg-black text-white rounded-2xl font-medium hover:bg-gray-900 transition duration-300 inline-block">
          View Collection
        </a>
        <a href="{{ route('home') }}#brands" class="px-8 py-3 border-2 border-black text-black rounded-2xl font-medium hover:bg-black hover:text-white transition duration-300 inline-block">
          Shop by Brand
        </a>
      </div>
    </div>
  </section>
@endsection
