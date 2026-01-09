<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Luxe Vault - Admin Login</title>
  @vite(['resources/js/app.js'])
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    html, body {
      font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
    }
  </style>
</head>
<body class="bg-gray-100">
  <div class="min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
      <div class="text-center mb-8">
        <img src="{{ asset('images/logo- black.png') }}" alt="Luxe Vault Logo" class="h-12 mx-auto mb-6">
        <h1 class="text-2xl font-bold">Admin Login</h1>
        <p class="text-gray-600 mt-2">Enter your credentials to access the admin panel</p>
      </div>
      
      @if($errors->any())
        <div class="bg-red-50 text-red-700 p-3 rounded-lg mb-6">
          {{ $errors->first() }}
        </div>
      @endif
      
      <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-6">
        @csrf
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
          <input type="email" id="email" name="email" value="admin@luxevault.com" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black">
        </div>
        
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
          <input type="password" id="password" name="password" value="admin123" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black">
          <p class="text-sm text-gray-500 mt-1">Demo credentials: admin@luxevault.com / admin123</p>
        </div>
        
        <div>
          <button type="submit" class="w-full bg-black text-white py-2 px-4 rounded-lg font-medium hover:bg-gray-800">
            Sign In
          </button>
        </div>
      </form>
      
      <div class="mt-6 text-center">
        <a href="{{ route('home') }}" class="text-sm text-gray-600 hover:underline">Return to Website</a>
      </div>
    </div>
  </div>
</body>
</html>