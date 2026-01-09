@extends('layouts.app')

@section('title', 'Direct Seller Registration')

@section('content')
<div class="max-w-md mx-auto my-12 p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6 text-center">Direct Seller Registration</h1>
    
    <div id="response-message" class="hidden mb-4 p-3 rounded"></div>
    
    <form id="direct-seller-form" class="space-y-4">
        @csrf
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
            <input type="email" name="email" id="email" value="seller{{ time() }}@example.com" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-black focus:border-black" required>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="fname" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                <input type="text" name="fname" id="fname" value="Test" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-black focus:border-black" required>
            </div>
            <div>
                <label for="lname" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                <input type="text" name="lname" id="lname" value="User" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-black focus:border-black" required>
            </div>
        </div>
        
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
            <input type="text" name="phone" id="phone" value="1234567890" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-black focus:border-black">
        </div>
        
        <div>
            <label for="store_name" class="block text-sm font-medium text-gray-700 mb-1">Store Name</label>
            <input type="text" name="store_name" id="store_name" value="Test Store" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-black focus:border-black" required>
        </div>
        
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Store Description</label>
            <textarea name="description" id="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-black focus:border-black">Test store description</textarea>
        </div>
        
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" name="password" id="password" value="password123" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-black focus:border-black" required>
        </div>
        
        <div>
            <button type="submit" id="submit-btn" class="w-full bg-black text-white py-2 px-4 rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
                Register Directly
            </button>
        </div>
    </form>
    
    <div class="mt-6">
        <div id="debug-info" class="text-xs bg-gray-100 p-3 rounded"></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('direct-seller-form');
    const submitBtn = document.getElementById('submit-btn');
    const responseMessage = document.getElementById('response-message');
    const debugInfo = document.getElementById('debug-info');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Disable submit button and show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Processing...';
        
        // Get form data
        const formData = new FormData(form);
        
        // Get CSRF token
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Debug info
        debugInfo.innerHTML = 'Submitting form...';
        
        // Send AJAX request
        fetch('{{ route("direct.seller.register") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Show response message
            responseMessage.classList.remove('hidden', 'bg-red-100', 'text-red-700', 'bg-green-100', 'text-green-700');
            
            if (data.success) {
                responseMessage.classList.add('bg-green-100', 'text-green-700');
                responseMessage.innerHTML = `
                    <p><strong>Registration successful!</strong></p>
                    <p>Seller ID: ${data.seller_id}</p>
                    <p>Login Status: ${data.login_status}</p>
                    <p class="mt-3">
                        <a href="${data.dashboard_url}" class="bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded">
                            Go to Dashboard
                        </a>
                    </p>
                `;
                
                // Redirect after 2 seconds
                setTimeout(() => {
                    window.location.href = data.dashboard_url;
                }, 2000);
            } else {
                responseMessage.classList.add('bg-red-100', 'text-red-700');
                responseMessage.innerHTML = `<p><strong>Error:</strong> ${data.message}</p>`;
            }
            
            // Debug info
            debugInfo.innerHTML = `Response: ${JSON.stringify(data)}`;
            
            // Re-enable submit button
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Register Directly';
        })
        .catch(error => {
            // Show error message
            responseMessage.classList.remove('hidden');
            responseMessage.classList.add('bg-red-100', 'text-red-700');
            responseMessage.innerHTML = `<p><strong>Error:</strong> ${error.message}</p>`;
            
            // Debug info
            debugInfo.innerHTML = `Error: ${error}`;
            
            // Re-enable submit button
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Register Directly';
        });
    });
});
</script>
@endsection