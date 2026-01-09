<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - Luxe Vault Admin</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-900 text-white min-h-screen">
            <div class="p-4 text-center">
                <img src="{{ asset('images/logo-white.png') }}" alt="Luxe Vault Logo" class="h-16 w-auto mx-auto mb-2">
                <p class="text-gray-400 text-sm">Admin Dashboard</p>
            </div>
            
            <div class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
                
                <div class="mt-4">
                    <p class="px-4 text-xs text-gray-500 uppercase font-bold">User Management</p>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.users*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        All Users
                    </a>
                    <a href="{{ route('admin.customers') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.customers') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Customers
                    </a>
                    <a href="{{ route('admin.sellers') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.sellers') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Sellers
                    </a>
                </div>
                
                <div class="mt-4">
                    <p class="px-4 text-xs text-gray-500 uppercase font-bold">Product Management</p>
                    <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.products*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        Products
                    </a>
                    <!-- Brands link removed - brands are managed as enum in products table -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Brands
                    </a>
                </div>
                
                <div class="mt-4">
                    <p class="px-4 text-xs text-gray-500 uppercase font-bold">Orders</p>
                    <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.orders*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Orders
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Main content -->
        <div class="flex-1 flex flex-col">
            <!-- Top bar -->
            <div class="bg-white shadow-sm h-16 flex items-center justify-between px-6">
                <div>
                    <h2 class="text-lg font-semibold">@yield('page-title', 'Dashboard')</h2>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button type="button" class="flex items-center text-gray-700 focus:outline-none" onclick="document.getElementById('user-dropdown').classList.toggle('hidden')">
                            <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <span class="ml-2">Admin</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        
                        <div id="user-dropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden z-50">
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Content -->
            <div class="flex-1 p-6 overflow-auto">
                @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>