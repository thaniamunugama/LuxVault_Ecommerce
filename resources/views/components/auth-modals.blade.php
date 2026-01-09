{{-- LOGIN MODAL --}}
<div id="loginModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    {{-- Backdrop with blur --}}
    <div id="loginModalBackdrop" class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>
    
    {{-- Modal Content --}}
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full p-6 transform transition-all">
            {{-- Close Button --}}
            <button id="closeLoginModal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            {{-- Logo --}}
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/logo- black.png') }}" alt="Luxe Vault" class="h-16">
            </div>

            <h2 class="text-2xl font-bold text-center text-gray-900 mb-2">Sign in</h2>
            <p class="text-center text-sm text-gray-600 mb-6">Sign in to your account</p>

            {{-- Tab Navigation --}}
            <div class="flex border-b border-gray-200 mb-6">
                <button id="loginTabCustomer" onclick="switchLoginTab('customer')" class="flex-1 py-2 px-4 text-sm font-medium text-center border-b-2 border-black text-black">
                    Customer
                </button>
                <button id="loginTabSeller" onclick="switchLoginTab('seller')" class="flex-1 py-2 px-4 text-sm font-medium text-center border-b-2 border-transparent text-gray-500 hover:text-gray-700">
                    Seller
                </button>
            </div>

            {{-- Error Messages (Dynamic) --}}
            <div id="loginErrorMessage" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4 hidden">
                <ul id="loginErrorList" class="list-disc pl-5">
                </ul>
            </div>

            {{-- Error Messages (Server-side on page load) --}}
            @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Success Message --}}
            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-4">
                <p class="text-sm">{{ session('success') }}</p>
            </div>
            @endif

            {{-- Customer Login Form --}}
            <form method="POST" action="{{ route('customer.login.submit') }}" id="customerLoginForm" class="space-y-4">
                @csrf
                <input type="hidden" name="user_type" value="customer">
                <div>
                    <label for="login_email_customer" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="login_email_customer" name="email" type="email" autocomplete="username" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-black focus:border-black text-sm" 
                           value="{{ old('email') }}">
                </div>

                <div>
                    <label for="login_password_customer" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input id="login_password_customer" name="password" type="password" autocomplete="current-password" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-black focus:border-black text-sm">
                </div>

                <button type="submit" class="w-full py-2 px-4 bg-black text-white rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black text-sm font-medium">
                    Sign in as Customer
                </button>
            </form>

            {{-- Seller Login Form --}}
            <form method="POST" action="{{ route('seller.login.submit') }}" id="sellerLoginForm" class="space-y-4 hidden">
                @csrf
                <input type="hidden" name="user_type" value="seller">
                <div>
                    <label for="login_email_seller" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="login_email_seller" name="email" type="email" autocomplete="username" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-black focus:border-black text-sm" 
                           value="{{ old('email') }}">
                </div>

                <div>
                    <label for="login_password_seller" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input id="login_password_seller" name="password" type="password" autocomplete="current-password" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-black focus:border-black text-sm">
                </div>

                <button type="submit" class="w-full py-2 px-4 bg-black text-white rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black text-sm font-medium">
                    Sign in as Seller
                </button>
            </form>

            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600">
                    Don't have an account? 
                    <button onclick="closeLoginModal(); openRegisterModal(); switchRegisterTab(getActiveLoginTab());" class="text-black font-medium hover:underline">Register</button>
                </p>
            </div>
        </div>
    </div>
</div>

{{-- REGISTER MODAL --}}
<div id="registerModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    {{-- Backdrop with blur --}}
    <div id="registerModalBackdrop" class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>
    
    {{-- Modal Content --}}
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full p-6 transform transition-all max-h-[90vh] overflow-y-auto">
            {{-- Close Button --}}
            <button id="closeRegisterModal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            {{-- Logo --}}
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/logo- black.png') }}" alt="Luxe Vault" class="h-16">
            </div>

            <h2 class="text-2xl font-bold text-center text-gray-900 mb-2">Create account</h2>
            <p class="text-center text-sm text-gray-600 mb-6">Sign up for a new account</p>

            {{-- Tab Navigation --}}
            <div class="flex border-b border-gray-200 mb-6">
                <button id="registerTabCustomer" onclick="switchRegisterTab('customer')" class="flex-1 py-2 px-4 text-sm font-medium text-center border-b-2 border-black text-black">
                    Customer
                </button>
                <button id="registerTabSeller" onclick="switchRegisterTab('seller')" class="flex-1 py-2 px-4 text-sm font-medium text-center border-b-2 border-transparent text-gray-500 hover:text-gray-700">
                    Seller
                </button>
            </div>

            {{-- Error Messages --}}
            @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Success Message --}}
            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-4">
                <p class="text-sm">{{ session('success') }}</p>
            </div>
            @endif

            {{-- Customer Register Form --}}
            <form method="POST" action="{{ route('customer.register.submit') }}" id="customerRegisterForm" class="space-y-4">
                @csrf
                <input type="hidden" name="user_type" value="customer">
                <div>
                    <label for="register_fname_customer" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                    <input id="register_fname_customer" name="fname" type="text" autocomplete="given-name" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-black focus:border-black text-sm" 
                           value="{{ old('fname') }}">
                </div>

                <div>
                    <label for="register_lname_customer" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                    <input id="register_lname_customer" name="lname" type="text" autocomplete="family-name" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-black focus:border-black text-sm" 
                           value="{{ old('lname') }}">
                </div>

                <div>
                    <label for="register_email_customer" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="register_email_customer" name="email" type="email" autocomplete="username" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-black focus:border-black text-sm" 
                           value="{{ old('email') }}">
                </div>

                <div>
                    <label for="register_phone_customer" class="block text-sm font-medium text-gray-700 mb-1">Phone (Optional)</label>
                    <input id="register_phone_customer" name="phone" type="tel" autocomplete="tel" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-black focus:border-black text-sm" 
                           value="{{ old('phone') }}">
                </div>

                <div>
                    <label for="register_password_customer" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input id="register_password_customer" name="password" type="password" autocomplete="new-password" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-black focus:border-black text-sm">
                </div>

                <div>
                    <label for="register_password_confirmation_customer" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input id="register_password_confirmation_customer" name="password_confirmation" type="password" autocomplete="new-password" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-black focus:border-black text-sm">
                </div>

                <button type="submit" class="w-full py-2 px-4 bg-black text-white rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black text-sm font-medium">
                    Register as Customer
                </button>
            </form>

            {{-- Seller Register Form --}}
            <form method="POST" action="{{ route('seller.register.submit') }}" id="sellerRegisterForm" class="space-y-4 hidden">
                @csrf
                <input type="hidden" name="user_type" value="seller">
                <div>
                    <label for="register_fname_seller" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                    <input id="register_fname_seller" name="fname" type="text" autocomplete="given-name" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-black focus:border-black text-sm" 
                           value="{{ old('fname') }}">
                </div>

                <div>
                    <label for="register_lname_seller" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                    <input id="register_lname_seller" name="lname" type="text" autocomplete="family-name" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-black focus:border-black text-sm" 
                           value="{{ old('lname') }}">
                </div>

                <div>
                    <label for="register_email_seller" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="register_email_seller" name="email" type="email" autocomplete="username" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-black focus:border-black text-sm" 
                           value="{{ old('email') }}">
                </div>

                <div>
                    <label for="register_phone_seller" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input id="register_phone_seller" name="phone" type="tel" autocomplete="tel" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-black focus:border-black text-sm" 
                           value="{{ old('phone') }}">
                </div>

                <div>
                    <label for="register_password_seller" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input id="register_password_seller" name="password" type="password" autocomplete="new-password" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-black focus:border-black text-sm">
                </div>

                <div>
                    <label for="register_password_confirmation_seller" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input id="register_password_confirmation_seller" name="password_confirmation" type="password" autocomplete="new-password" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-black focus:border-black text-sm">
                </div>

                <button type="submit" class="w-full py-2 px-4 bg-black text-white rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black text-sm font-medium">
                    Register as Seller
                </button>
            </form>

            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600">
                    Already have an account? 
                    <button onclick="closeRegisterModal(); openLoginModal(); switchLoginTab(getActiveRegisterTab());" class="text-black font-medium hover:underline">Sign in</button>
                </p>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript for Modal Control --}}
<script>
    // Prevent body scroll when modal is open
    function preventBodyScroll() {
        document.body.style.overflow = 'hidden';
    }
    
    function allowBodyScroll() {
        document.body.style.overflow = '';
    }

    // Tab switching functions
    let activeLoginTab = 'customer';
    let activeRegisterTab = 'customer';

    function switchLoginTab(tab) {
        activeLoginTab = tab;
        const customerForm = document.getElementById('customerLoginForm');
        const sellerForm = document.getElementById('sellerLoginForm');
        const customerTab = document.getElementById('loginTabCustomer');
        const sellerTab = document.getElementById('loginTabSeller');

        if (tab === 'customer') {
            customerForm.classList.remove('hidden');
            sellerForm.classList.add('hidden');
            customerTab.classList.add('border-black', 'text-black');
            customerTab.classList.remove('border-transparent', 'text-gray-500');
            sellerTab.classList.remove('border-black', 'text-black');
            sellerTab.classList.add('border-transparent', 'text-gray-500');
        } else {
            customerForm.classList.add('hidden');
            sellerForm.classList.remove('hidden');
            sellerTab.classList.add('border-black', 'text-black');
            sellerTab.classList.remove('border-transparent', 'text-gray-500');
            customerTab.classList.remove('border-black', 'text-black');
            customerTab.classList.add('border-transparent', 'text-gray-500');
        }
    }

    function switchRegisterTab(tab) {
        activeRegisterTab = tab;
        const customerForm = document.getElementById('customerRegisterForm');
        const sellerForm = document.getElementById('sellerRegisterForm');
        const customerTab = document.getElementById('registerTabCustomer');
        const sellerTab = document.getElementById('registerTabSeller');

        if (tab === 'customer') {
            customerForm.classList.remove('hidden');
            sellerForm.classList.add('hidden');
            customerTab.classList.add('border-black', 'text-black');
            customerTab.classList.remove('border-transparent', 'text-gray-500');
            sellerTab.classList.remove('border-black', 'text-black');
            sellerTab.classList.add('border-transparent', 'text-gray-500');
        } else {
            customerForm.classList.add('hidden');
            sellerForm.classList.remove('hidden');
            sellerTab.classList.add('border-black', 'text-black');
            sellerTab.classList.remove('border-transparent', 'text-gray-500');
            customerTab.classList.remove('border-black', 'text-black');
            customerTab.classList.add('border-transparent', 'text-gray-500');
        }
    }

    function getActiveLoginTab() {
        return activeLoginTab;
    }

    function getActiveRegisterTab() {
        return activeRegisterTab;
    }

    // Login Modal Functions
    function openLoginModal() {
        const modal = document.getElementById('loginModal');
        const backdrop = document.getElementById('loginModalBackdrop');
        if (modal) {
            modal.classList.remove('hidden');
            preventBodyScroll();
            // Small delay for animation
            setTimeout(() => {
                backdrop.style.opacity = '1';
            }, 10);
        }
    }

    function closeLoginModal() {
        const modal = document.getElementById('loginModal');
        const backdrop = document.getElementById('loginModalBackdrop');
        if (modal) {
            backdrop.style.opacity = '0';
            setTimeout(() => {
                modal.classList.add('hidden');
                allowBodyScroll();
            }, 200);
        }
    }

    // Register Modal Functions
    function openRegisterModal() {
        const modal = document.getElementById('registerModal');
        const backdrop = document.getElementById('registerModalBackdrop');
        if (modal) {
            modal.classList.remove('hidden');
            preventBodyScroll();
            setTimeout(() => {
                backdrop.style.opacity = '1';
            }, 10);
        }
    }

    function closeRegisterModal() {
        const modal = document.getElementById('registerModal');
        const backdrop = document.getElementById('registerModalBackdrop');
        if (modal) {
            backdrop.style.opacity = '0';
            setTimeout(() => {
                modal.classList.add('hidden');
                allowBodyScroll();
            }, 200);
        }
    }

    // Close modals when clicking backdrop
    document.getElementById('loginModalBackdrop')?.addEventListener('click', closeLoginModal);
    document.getElementById('registerModalBackdrop')?.addEventListener('click', closeRegisterModal);

    // Close modals with close buttons
    document.getElementById('closeLoginModal')?.addEventListener('click', closeLoginModal);
    document.getElementById('closeRegisterModal')?.addEventListener('click', closeRegisterModal);

    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLoginModal();
            closeRegisterModal();
        }
    });

    // Open modals from session (set by controller after form submission errors)
    @if(session('open_modal') === 'login')
        document.addEventListener('DOMContentLoaded', function() {
            openLoginModal();
            @if(session('active_tab') === 'seller')
                switchLoginTab('seller');
            @else
                switchLoginTab('customer');
            @endif
        });
    @endif

    @if(session('open_modal') === 'register')
        document.addEventListener('DOMContentLoaded', function() {
            openRegisterModal();
            @if(session('active_tab') === 'seller')
                switchRegisterTab('seller');
            @else
                switchRegisterTab('customer');
            @endif
        });
    @endif

    // Also check URL parameter for opening modals
    @if(request()->has('open_modal'))
        @if(request()->get('open_modal') === 'login')
            document.addEventListener('DOMContentLoaded', function() {
                openLoginModal();
                @if(request()->get('active_tab') === 'seller')
                    switchLoginTab('seller');
                @else
                    switchLoginTab('customer');
                @endif
            });
        @elseif(request()->get('open_modal') === 'register')
            document.addEventListener('DOMContentLoaded', function() {
                openRegisterModal();
                @if(request()->get('active_tab') === 'seller')
                    switchRegisterTab('seller');
                @else
                    switchRegisterTab('customer');
                @endif
            });
            @endif
    @endif

    // Store intended URL before login attempts - preserve current page
    const intendedUrl = window.location.href;
    
    // AJAX Login Form Submission - Customer
    document.getElementById('customerLoginForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const errorDiv = document.getElementById('loginErrorMessage');
        const errorList = document.getElementById('loginErrorList');
        const originalBtnText = submitBtn.textContent;
        
        // Store intended URL
        formData.append('intended_url', intendedUrl);
        
        // Clear previous errors
        errorDiv.classList.add('hidden');
        errorList.innerHTML = '';
        submitBtn.disabled = true;
        submitBtn.textContent = 'Signing in...';
        
        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => {
            // Check if response is JSON
            const contentType = response.headers.get("content-type");
            if (contentType && contentType.includes("application/json")) {
                return response.json();
            }
            // If not JSON (redirect response), follow redirect
            window.location.href = response.url;
            return null;
        })
        .then(data => {
            if (!data) return; // Redirect happened
            
            if (data.success) {
                // Success - redirect to intended URL or data.redirect
                window.location.href = data.redirect || data.intended_url || intendedUrl || '{{ route("home") }}';
            } else {
                // Show errors in modal
                if (data.errors) {
                    errorList.innerHTML = '';
                    Object.keys(data.errors).forEach(field => {
                        data.errors[field].forEach(error => {
                            const li = document.createElement('li');
                            li.className = 'text-sm';
                            li.textContent = error;
                            errorList.appendChild(li);
                        });
                    });
                    errorDiv.classList.remove('hidden');
                } else if (data.message) {
                    errorList.innerHTML = '<li class="text-sm">' + data.message + '</li>';
                    errorDiv.classList.remove('hidden');
                }
                submitBtn.disabled = false;
                submitBtn.textContent = originalBtnText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            errorList.innerHTML = '<li class="text-sm">An error occurred. Please try again.</li>';
            errorDiv.classList.remove('hidden');
            submitBtn.disabled = false;
            submitBtn.textContent = originalBtnText;
        });
    });

    // AJAX Login Form Submission - Seller
    document.getElementById('sellerLoginForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const errorDiv = document.getElementById('loginErrorMessage');
        const errorList = document.getElementById('loginErrorList');
        const originalBtnText = submitBtn.textContent;
        
        // Store intended URL
        formData.append('intended_url', intendedUrl);
        
        // Clear previous errors
        errorDiv.classList.add('hidden');
        errorList.innerHTML = '';
        submitBtn.disabled = true;
        submitBtn.textContent = 'Signing in...';
        
        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => {
            // Check if response is JSON
            const contentType = response.headers.get("content-type");
            if (contentType && contentType.includes("application/json")) {
                return response.json();
            }
            // If not JSON (redirect response), follow redirect
            window.location.href = response.url;
            return null;
        })
        .then(data => {
            if (!data) return; // Redirect happened
            
            if (data.success) {
                // Success - redirect to intended URL or data.redirect
                window.location.href = data.redirect || data.intended_url || intendedUrl || '{{ route("home") }}';
            } else {
                // Show errors in modal
                if (data.errors) {
                    errorList.innerHTML = '';
                    Object.keys(data.errors).forEach(field => {
                        data.errors[field].forEach(error => {
                            const li = document.createElement('li');
                            li.className = 'text-sm';
                            li.textContent = error;
                            errorList.appendChild(li);
                        });
                    });
                    errorDiv.classList.remove('hidden');
                } else if (data.message) {
                    errorList.innerHTML = '<li class="text-sm">' + data.message + '</li>';
                    errorDiv.classList.remove('hidden');
                }
                submitBtn.disabled = false;
                submitBtn.textContent = originalBtnText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            errorList.innerHTML = '<li class="text-sm">An error occurred. Please try again.</li>';
            errorDiv.classList.remove('hidden');
            submitBtn.disabled = false;
            submitBtn.textContent = originalBtnText;
        });
    });
</script>
