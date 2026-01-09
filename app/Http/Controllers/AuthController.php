<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Seller;
use App\Models\TerminatedEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Register a new customer
     */
    public function registerCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required|string|max:100',
            'lname' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:customers,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            if ($validator->fails()) {
                return redirect()->route('home')
                    ->withErrors($validator)
                    ->withInput()
                    ->with('open_modal', 'register')
                    ->with('active_tab', 'customer');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            if (str_contains($e->getMessage(), '2002') || str_contains($e->getMessage(), 'refused')) {
                return redirect()->route('home')
                    ->withErrors(['error' => 'Database connection failed. Please ensure MySQL is running in XAMPP Control Panel.'])
                    ->withInput()
                    ->with('open_modal', 'register')
                    ->with('active_tab', 'customer');
            }
            throw $e;
        }

        try {
            // Check if email is terminated
            $terminated = TerminatedEmail::find($request->email);
            if ($terminated) {
                return redirect()->route('home')
                    ->withErrors(['email' => 'Your account has been terminated.'])
                    ->withInput()
                    ->with('open_modal', 'register')
                    ->with('active_tab', 'customer');
            }

            // Create customer directly
            $customer = Customer::create([
                'fname' => $request->fname,
                'lname' => $request->lname,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);

            // Login customer using Laravel Auth
            Auth::login($customer);

            // Store customer_id in session for backward compatibility
            session(['customer_id' => $customer->customer_id]);
            session(['user_role' => 'customer']);

            // Redirect to home page after registration
            return redirect()->route('home')->with('success', 'Registration successful! Welcome to Luxe Vault.');

        } catch (\Illuminate\Database\QueryException $e) {
            if (str_contains($e->getMessage(), '2002') || str_contains($e->getMessage(), 'refused')) {
                return redirect()->route('home')
                    ->withErrors(['error' => 'Database connection failed. Please ensure MySQL is running in XAMPP Control Panel.'])
                    ->withInput()
                    ->with('open_modal', 'register')
                    ->with('active_tab', 'customer');
            }
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Customer Registration Error: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
            return redirect()->route('home')
                ->withErrors(['error' => 'Registration failed: ' . $e->getMessage()])
                ->withInput()
                ->with('open_modal', 'register')
                ->with('active_tab', 'customer');
        }
    }

    /**
     * Register a new seller
     */
    public function registerSeller(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required|string|max:100',
            'lname' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:sellers,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            if ($validator->fails()) {
                return redirect()->route('home')
                    ->withErrors($validator)
                    ->withInput()
                    ->with('open_modal', 'register')
                    ->with('active_tab', 'seller');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            if (str_contains($e->getMessage(), '2002') || str_contains($e->getMessage(), 'refused')) {
                return redirect()->route('home')
                    ->withErrors(['error' => 'Database connection failed. Please ensure MySQL is running in XAMPP Control Panel.'])
                    ->withInput()
                    ->with('open_modal', 'register')
                    ->with('active_tab', 'seller');
            }
            throw $e;
        }

        try {
            // Check if email is terminated
            $terminated = TerminatedEmail::find($request->email);
            if ($terminated) {
                return redirect()->route('home')
                    ->withErrors(['email' => 'Your account has been terminated.'])
                    ->withInput()
                    ->with('open_modal', 'register')
                    ->with('active_tab', 'seller');
            }

            // Create seller directly (not admin)
            $seller = Seller::create([
                'fname' => $request->fname,
                'lname' => $request->lname,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'is_admin' => false,
            ]);

            // Login seller using Laravel Auth with seller guard
            Auth::guard('seller')->login($seller);

            // Store seller_id in session for backward compatibility
            session(['seller_id' => $seller->seller_id]);
            session(['user_role' => 'seller']);

            return redirect()->route('seller.dashboard')->with('success', 'Registration successful! Welcome to Luxe Vault Seller Portal.');

        } catch (\Illuminate\Database\QueryException $e) {
            if (str_contains($e->getMessage(), '2002') || str_contains($e->getMessage(), 'refused')) {
                return redirect()->route('home')
                    ->withErrors(['error' => 'Database connection failed. Please ensure MySQL is running in XAMPP Control Panel.'])
                    ->withInput()
                    ->with('open_modal', 'register')
                    ->with('active_tab', 'seller');
            }
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Seller Registration Error: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
            return redirect()->route('home')
                ->withErrors(['error' => 'Registration failed: ' . $e->getMessage()])
                ->withInput()
                ->with('open_modal', 'register')
                ->with('active_tab', 'seller');
        }
    }

    /**
     * Login customer
     */
    public function loginCustomer(Request $request)
    {
        // Store intended URL from request or session BEFORE validation
        // Priority: request input > stored session > previous URL (if valid) > home
        $requestedIntended = $request->input('intended_url');
        $storedIntended = session()->get('url.intended');
        $previousUrl = url()->previous();
        
        // Determine intended URL
        if ($requestedIntended && !str_contains($requestedIntended, '/customer/login') && !str_contains($requestedIntended, '/login') && !str_contains($requestedIntended, '/customer/register')) {
            $intendedUrl = $requestedIntended;
            session()->put('url.intended', $intendedUrl);
        } elseif ($storedIntended && !str_contains($storedIntended, '/home') && !str_contains($storedIntended, '/login') && !str_contains($storedIntended, '/register')) {
            $intendedUrl = $storedIntended;
        } elseif ($previousUrl && !str_contains($previousUrl, '/customer/login') && !str_contains($previousUrl, '/login') && !str_contains($previousUrl, '/customer/register') && !str_contains($previousUrl, '/home') && $previousUrl !== url()->current()) {
            $intendedUrl = $previousUrl;
            session()->put('url.intended', $intendedUrl);
        } else {
            $intendedUrl = route('home');
            if (!$storedIntended) {
                session()->put('url.intended', $intendedUrl);
            }
        }

        // Check if this is an AJAX request
        $isAjax = $request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest';
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Handle AJAX requests
        if ($isAjax) {
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            try {
                // Check if email is terminated FIRST
                $terminated = TerminatedEmail::find($request->email);
                if ($terminated) {
                    return response()->json([
                        'success' => false,
                        'errors' => ['email' => ['Your account has been terminated.']]
                    ], 422);
                }

                // Check if email exists in sellers table (wrong user type)
                $seller = Seller::where('email', $request->email)->first();
                if ($seller) {
                    return response()->json([
                        'success' => false,
                        'errors' => ['email' => ['Invalid credentials.']]
                    ], 422);
                }

                // Find customer
                $customer = Customer::where('email', $request->email)->first();

                if (!$customer) {
                    return response()->json([
                        'success' => false,
                        'errors' => ['email' => ['Wrong username or email.']]
                    ], 422);
                }

                // Verify password
                if (!Hash::check($request->password, $customer->password)) {
                    return response()->json([
                        'success' => false,
                        'errors' => ['password' => ['Wrong password.']]
                    ], 422);
                }

                // Login customer using Laravel Auth
                Auth::login($customer, false);

                // Store customer_id in session for backward compatibility
                session(['customer_id' => $customer->customer_id]);
                session(['user_role' => 'customer']);

                // Don't redirect to POST routes
                $finalUrl = $intendedUrl;
                if (str_contains($intendedUrl, '/cart/add')) {
                    $finalUrl = route('products');
                }
                
                return response()->json([
                    'success' => true,
                    'redirect' => $finalUrl,
                    'intended_url' => $finalUrl,
                    'message' => 'Welcome back!'
                ]);

            } catch (\Illuminate\Database\QueryException $e) {
                if (str_contains($e->getMessage(), '2002') || str_contains($e->getMessage(), 'refused')) {
                    return response()->json([
                        'success' => false,
                        'errors' => ['error' => ['Database connection failed. Please ensure MySQL is running in XAMPP Control Panel.']]
                    ], 500);
                }
                throw $e;
            } catch (\Exception $e) {
                \Log::error('Customer Login Error: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'errors' => ['error' => ['Login failed. Please try again.']]
                ], 500);
            }
        }

        // Handle regular form submissions (fallback)
        if ($validator->fails()) {
            // Redirect to intended URL (or previous if intended is home) with modal open
            $redirectTo = ($intendedUrl && $intendedUrl !== route('home')) ? $intendedUrl : url()->previous();
            if ($redirectTo === route('customer.login') || str_contains($redirectTo, '/login')) {
                $redirectTo = route('home');
            }
            return redirect()->to($redirectTo)
                ->withErrors($validator)
                ->withInput()
                ->with('open_modal', 'login')
                ->with('active_tab', 'customer');
        }

        try {
            // Check if email is terminated FIRST
            $terminated = TerminatedEmail::find($request->email);
            if ($terminated) {
                $redirectTo = ($intendedUrl && $intendedUrl !== route('home')) ? $intendedUrl : url()->previous();
                if ($redirectTo === route('customer.login') || str_contains($redirectTo, '/login')) {
                    $redirectTo = route('home');
                }
                return redirect()->to($redirectTo)
                    ->withErrors(['email' => 'Your account has been terminated.'])
                    ->withInput()
                    ->with('open_modal', 'login')
                    ->with('active_tab', 'customer');
            }

            // Check if email exists in sellers table (wrong user type)
            $seller = Seller::where('email', $request->email)->first();
            if ($seller) {
                $redirectTo = ($intendedUrl && $intendedUrl !== route('home')) ? $intendedUrl : url()->previous();
                if ($redirectTo === route('customer.login') || str_contains($redirectTo, '/login')) {
                    $redirectTo = route('home');
                }
                return redirect()->to($redirectTo)
                    ->withErrors(['email' => 'Invalid credentials.'])
                    ->withInput()
                    ->with('open_modal', 'login')
                    ->with('active_tab', 'customer');
            }

            // Find customer
            $customer = Customer::where('email', $request->email)->first();

            if (!$customer) {
                $redirectTo = ($intendedUrl && $intendedUrl !== route('home')) ? $intendedUrl : url()->previous();
                if ($redirectTo === route('customer.login') || str_contains($redirectTo, '/login')) {
                    $redirectTo = route('home');
                }
                return redirect()->to($redirectTo)
                    ->withErrors(['email' => 'Wrong username or email.'])
                    ->withInput()
                    ->with('open_modal', 'login')
                    ->with('active_tab', 'customer');
            }

            // Verify password
            if (!Hash::check($request->password, $customer->password)) {
                $redirectTo = ($intendedUrl && $intendedUrl !== route('home')) ? $intendedUrl : url()->previous();
                if ($redirectTo === route('customer.login') || str_contains($redirectTo, '/login')) {
                    $redirectTo = route('home');
                }
                return redirect()->to($redirectTo)
                    ->withErrors(['password' => 'Wrong password.'])
                    ->withInput()
                    ->with('open_modal', 'login')
                    ->with('active_tab', 'customer');
            }

            // Login customer using Laravel Auth
            Auth::login($customer, $request->has('remember'));

            // Store customer_id in session for backward compatibility
            session(['customer_id' => $customer->customer_id]);
            session(['user_role' => 'customer']);

            // Don't redirect to POST routes
            if (str_contains($intendedUrl, '/cart/add')) {
                $intendedUrl = route('products');
            }
            
            return redirect()->to($intendedUrl)->with('success', 'Welcome back!');

        } catch (\Illuminate\Database\QueryException $e) {
            if (str_contains($e->getMessage(), '2002') || str_contains($e->getMessage(), 'refused')) {
                $redirectTo = ($intendedUrl && $intendedUrl !== route('home')) ? $intendedUrl : url()->previous();
                if ($redirectTo === route('customer.login') || str_contains($redirectTo, '/login')) {
                    $redirectTo = route('home');
                }
                return redirect()->to($redirectTo)
                    ->withErrors(['error' => 'Database connection failed. Please ensure MySQL is running in XAMPP Control Panel.'])
                    ->withInput()
                    ->with('open_modal', 'login')
                    ->with('active_tab', 'customer');
            }
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Customer Login Error: ' . $e->getMessage());
            $redirectTo = ($intendedUrl && $intendedUrl !== route('home')) ? $intendedUrl : url()->previous();
            if ($redirectTo === route('customer.login') || str_contains($redirectTo, '/login')) {
                $redirectTo = route('home');
            }
            return redirect()->to($redirectTo)
                ->withErrors(['error' => 'Login failed. Please try again.'])
                ->withInput()
                ->with('open_modal', 'login')
                ->with('active_tab', 'customer');
        }
    }

    /**
     * Login seller/admin
     */
    public function loginSeller(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Check if request came from admin login page
        $isAdminLogin = $request->route()->getName() === 'admin.login.submit';
        $redirectRoute = $isAdminLogin ? 'admin.login' : 'home';

        // Store intended URL from request or session BEFORE validation
        $intendedUrl = $request->input('intended_url') ?: session()->get('url.intended') ?: url()->previous();
        // Don't store auth routes as intended
        if (!$isAdminLogin) {
            if ($intendedUrl && !str_contains($intendedUrl, '/seller/login') && !str_contains($intendedUrl, '/login') && !str_contains($intendedUrl, '/seller/register')) {
                session()->put('url.intended', $intendedUrl);
            } else {
                $intendedUrl = route('seller.orders');
                session()->put('url.intended', $intendedUrl);
            }
        } else {
            $intendedUrl = route('admin.dashboard');
            session()->put('url.intended', $intendedUrl);
        }

        // Check if this is an AJAX request
        $isAjaxSeller = $request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest';
        
        // Handle AJAX requests
        if ($isAjaxSeller) {
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            try {
                // Check if email is terminated FIRST
                $terminated = TerminatedEmail::find($request->email);
                if ($terminated) {
                    return response()->json([
                        'success' => false,
                        'errors' => ['email' => ['Your account has been terminated.']]
                    ], 422);
                }

                // Check if email exists in customers table (wrong user type)
                $customer = Customer::where('email', $request->email)->first();
                if ($customer) {
                    return response()->json([
                        'success' => false,
                        'errors' => ['email' => ['Invalid credentials.']]
                    ], 422);
                }

                // Find seller (includes admin)
                $seller = Seller::where('email', $request->email)->first();

                if (!$seller) {
                    return response()->json([
                        'success' => false,
                        'errors' => ['email' => ['Wrong username or email.']]
                    ], 422);
                }

                // Verify password
                if (!Hash::check($request->password, $seller->password)) {
                    return response()->json([
                        'success' => false,
                        'errors' => ['password' => ['Wrong password.']]
                    ], 422);
                }

                // Login seller using Laravel Auth with seller guard
                Auth::guard('seller')->login($seller, false);

                // Store seller_id or admin_id in session for backward compatibility
                if ($seller->is_admin) {
                    session(['admin_id' => $seller->seller_id]);
                    session(['user_role' => 'admin']);
                    $redirectUrl = route('admin.dashboard');
                } else {
                    session(['seller_id' => $seller->seller_id]);
                    session(['user_role' => 'seller']);
                    $redirectUrl = route('seller.orders');
                }

                return response()->json([
                    'success' => true,
                    'redirect' => $redirectUrl,
                    'message' => $seller->is_admin ? 'Welcome back, Admin!' : 'Welcome back!'
                ]);

            } catch (\Illuminate\Database\QueryException $e) {
                if (str_contains($e->getMessage(), '2002') || str_contains($e->getMessage(), 'refused')) {
                    return response()->json([
                        'success' => false,
                        'errors' => ['error' => ['Database connection failed. Please ensure MySQL is running in XAMPP Control Panel.']]
                    ], 500);
                }
                throw $e;
            } catch (\Exception $e) {
                \Log::error('Seller Login Error: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'errors' => ['error' => ['Login failed. Please try again.']]
                ], 500);
            }
        }

        // Handle regular form submissions (fallback)
        if ($validator->fails()) {
            $redirect = redirect()->route($redirectRoute)->withErrors($validator)->withInput();
            if (!$isAdminLogin) {
                $redirect->with('open_modal', 'login')->with('active_tab', 'seller');
            }
            return $redirect;
        }

        try {
            // Check if email is terminated FIRST
            $terminated = TerminatedEmail::find($request->email);
            if ($terminated) {
                $redirect = redirect()->route($redirectRoute)
                    ->withErrors(['email' => 'Your account has been terminated.'])
                    ->withInput();
                if (!$isAdminLogin) {
                    $redirect->with('open_modal', 'login')->with('active_tab', 'seller');
                }
                return $redirect;
            }

            // Check if email exists in customers table (wrong user type)
            $customer = Customer::where('email', $request->email)->first();
            if ($customer) {
                $redirect = redirect()->route($redirectRoute)
                    ->withErrors(['email' => 'Invalid credentials.'])
                    ->withInput();
                if (!$isAdminLogin) {
                    $redirect->with('open_modal', 'login')->with('active_tab', 'seller');
                }
                return $redirect;
            }

            // Find seller (includes admin)
            $seller = Seller::where('email', $request->email)->first();

            if (!$seller) {
                $redirect = redirect()->route($redirectRoute)
                    ->withErrors(['email' => 'Wrong username or email.'])
                    ->withInput();
                if (!$isAdminLogin) {
                    $redirect->with('open_modal', 'login')->with('active_tab', 'seller');
                }
                return $redirect;
            }

            // Verify password
            if (!Hash::check($request->password, $seller->password)) {
                $redirect = redirect()->route($redirectRoute)
                    ->withErrors(['password' => 'Wrong password.'])
                    ->withInput();
                if (!$isAdminLogin) {
                    $redirect->with('open_modal', 'login')->with('active_tab', 'seller');
                }
                return $redirect;
            }

            // Login seller using Laravel Auth with seller guard
            Auth::guard('seller')->login($seller, $request->has('remember'));

            // Store seller_id or admin_id in session for backward compatibility
            if ($seller->is_admin) {
                session(['admin_id' => $seller->seller_id]);
                session(['user_role' => 'admin']);
                return redirect()->route('admin.dashboard')->with('success', 'Welcome back, Admin!');
            } else {
                session(['seller_id' => $seller->seller_id]);
                session(['user_role' => 'seller']);
                return redirect()->route('seller.orders')->with('success', 'Welcome back!');
            }

        } catch (\Illuminate\Database\QueryException $e) {
            if (str_contains($e->getMessage(), '2002') || str_contains($e->getMessage(), 'refused')) {
                $redirect = redirect()->route($redirectRoute)
                    ->withErrors(['error' => 'Database connection failed. Please ensure MySQL is running in XAMPP Control Panel.'])
                    ->withInput();
                if (!$isAdminLogin) {
                    $redirect->with('open_modal', 'login')->with('active_tab', 'seller');
                }
                return $redirect;
            }
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Seller Login Error: ' . $e->getMessage());
            $redirect = redirect()->route($redirectRoute)
                ->withErrors(['error' => 'Login failed. Please try again.'])
                ->withInput();
            if (!$isAdminLogin) {
                $redirect->with('open_modal', 'login')->with('active_tab', 'seller');
            }
            return $redirect;
        }
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        // Logout from seller guard if authenticated
        if (Auth::guard('seller')->check()) {
            Auth::guard('seller')->logout();
        }
        
        // Logout from default guard if authenticated
        if (Auth::check()) {
            Auth::logout();
        }
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'You have been logged out successfully.');
    }
}
