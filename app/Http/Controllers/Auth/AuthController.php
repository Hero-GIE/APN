<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use App\Models\Donation;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;
use App\Models\FilteredImage;


class AuthController extends Controller
{
    /**
     * Show donor login form
     */
public function showLoginForm()
{
    if (Auth::guard('donor')->check()) {
        $donor = Auth::guard('donor')->user();
        
        // Check for ANY membership (not just active)
        $member = Member::where('donor_id', $donor->id)->latest()->first();
        
        if ($member) {
            return redirect()->route('member.dashboard');
        }
        return redirect()->route('donor.dashboard');
    }

    return view('auth.donor-login');
}

    /**
     * Show donor profile
     */
  public function showProfile()
{
    $donor = Auth::guard('donor')->user();
    $member = Member::where('donor_id', $donor->id)->first();
    
    return view('donor.profile', compact('donor', 'member'));
}

 /**
 * Handle donor login
 */
public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email'    => 'required|email',
        'password' => 'required|string',
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    $credentials = $request->only('email', 'password');
    
    $donor = Donor::where('email', $credentials['email'])->first();
    
    // Check if email exists
    if (!$donor) {
        Log::error('Login failed: Donor not found', ['email' => $credentials['email']]);
        return back()->withErrors([
            'email' => 'We could not find an account with this email address.',
        ])->withInput($request->only('email'));
    }
    
    // Check if password is correct
    if (!Hash::check($credentials['password'], $donor->password)) {
        Log::error('Login failed: Incorrect password', ['email' => $credentials['email']]);
        return back()->withErrors([
            'password' => 'The password you entered is incorrect.',
        ])->withInput($request->only('email'));
    }

    // Attempt login with Auth guard
    if (Auth::guard('donor')->attempt($credentials, $request->filled('remember'))) {
        $request->session()->regenerate();
     
        $donor = Auth::guard('donor')->user();
     
       $member = Member::where('donor_id', $donor->id)->latest()->first();

        $message = 'Welcome back, ' . $donor->firstname . '! You have successfully logged in.';
        
      if ($member) {
        return redirect()->intended(route('member.dashboard'))->with('login_success', $message);
       }
        
       return redirect()->intended(route('donor.dashboard'))->with('login_success', $message);
    }
    // Fallback error 
    return back()->withErrors([
        'email' => 'Unable to login. Please try again.',
    ])->withInput($request->only('email'));
}



public function logout(Request $request)
{
    $donor = Auth::guard('donor')->user();
 
    Log::info('User logged out', [
        'donor_id' => $donor ? $donor->id : null,
        'email'    => $donor ? $donor->email : null,
    ]);
 
    Auth::guard('donor')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    $request->session()->flush();
 
    $sessionCookieName = \Illuminate\Support\Str::slug(
        (string) env('APP_NAME', 'laravel')
    ) . '-session';
 
    $response = redirect()->route('donor.login')
        ->with('success', 'You have been logged out successfully.');
 
    foreach ([$sessionCookieName, 'XSRF-TOKEN'] as $name) {
        $response->headers->setCookie(
            \Symfony\Component\HttpFoundation\Cookie::create($name)
                ->withValue('')
                ->withExpires(now()->subYear()->getTimestamp())
                ->withPath('/')
                ->withDomain(null)
                ->withSecure((bool) env('SESSION_SECURE_COOKIE', false))
                ->withHttpOnly(true)
                ->withSameSite('lax')
        );
    }
 
    return $response;
}
 

   /**
 * Show donor dashboard
 */
public function dashboard()
{
    $donor = Auth::guard('donor')->user();
    
    $member = Member::where('donor_id', $donor->id)->first();
    
    $donations = Donation::where('donor_id', $donor->id)
        ->where('payment_status', 'success')
        ->get();
    
    $recentDonations = Donation::where('donor_id', $donor->id)
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();
    
    $stats = [
        'total_donations' => $donations->count(),
        'total_amount'    => $donations->sum('amount'),
        'member_since'    => $member ? $member->start_date->format('M Y') : null,
        'is_member'       => $member ? true : false,
    ];
    
    $memberStatus      = null;
    $memberStatusColor = null;
    $memberStatusPulse = false;
    
    if ($member) {
        $memberStatus      = strtoupper($member->status);
        $memberStatusColor = match($member->status) {
            'active'    => 'green',
            'expired'   => 'red',
            'cancelled' => 'orange',
            'pending'   => 'yellow',
            default     => 'gray'
        };
        $memberStatusPulse = in_array($member->status, ['active', 'pending']);
    }

    // Add this ↓
    $latestFilteredImage = FilteredImage::where('user_id', $donor->id)
        ->latest()
        ->first();
    
    return view('donor.dashboard', compact(
        'donor', 
        'member', 
        'recentDonations', 
        'stats',
        'memberStatus',
        'memberStatusColor',
        'memberStatusPulse',
        'latestFilteredImage'  // Add this ↓
    ));
}


 public function transactions()
{
    $donor = Auth::guard('donor')->user();
    $member = Member::where('donor_id', $donor->id)->first();
    
    $transactions = Donation::where('donor_id', $donor->id)
        ->orderBy('created_at', 'desc')
        ->paginate(7);
    
    return view('donor.transactions', compact('donor', 'member', 'transactions'));
}

    /**
     * Show edit profile form
     */
 public function editProfile()
{
    $donor = Auth::guard('donor')->user();
    $member = Member::where('donor_id', $donor->id)->first();
    
    return view('donor.profile-edit', compact('donor', 'member'));
}

    /**
     * Update donor profile
     */
    public function updateProfile(Request $request)
    {
        $donor = Auth::guard('donor')->user();

        $validator = Validator::make($request->all(), [
            'firstname'     => 'required|string|max:255',
            'lastname'      => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:donors,email,' . $donor->id,
            'phone'         => 'nullable|string|max:20',
            'country'       => 'nullable|string|max:100',
            'address'       => 'nullable|string|max:255',
            'city'          => 'nullable|string|max:100',
            'region'        => 'nullable|string|max:100',
            'postcode'      => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $donor->update([
            'firstname'     => $request->firstname,
            'lastname'      => $request->lastname,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'country'       => $request->country,
            'address'       => $request->address,
            'city'          => $request->city,
            'region'        => $request->region,
            'postcode'      => $request->postcode,
            'email_updates' => $request->has('email_updates'),
            'text_updates'  => $request->has('text_updates'),
        ]);

        Log::info('Profile updated successfully', [
            'donor_id' => $donor->id,
            'email' => $donor->email
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Show change password form
     */
public function showChangePasswordForm()
{
    $donor = Auth::guard('donor')->user();
    $member = Member::where('donor_id', $donor->id)->first();
    
    return view('donor.change-password', compact('donor', 'member'));
}

    /**
     * Handle password change
     */
    public function changePassword(Request $request)
    {
        $donor = Auth::guard('donor')->user();

        $validator = Validator::make($request->all(), [
            'current_password'      => 'required|string',
            'password'              => 'required|string|min:8|confirmed|different:current_password',
            'password_confirmation' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if (! Hash::check($request->current_password, $donor->password)) {
            return back()->withErrors([
                'current_password' => 'The current password you entered is incorrect.',
            ]);
        }

        $donor->update([
            'password' => Hash::make($request->password),
        ]);

        Log::info('Password changed successfully', [
            'donor_id' => $donor->id,
            'email' => $donor->email
        ]);

        return back()->with('success', 'Password changed successfully.');
    }
}