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


class AuthController extends Controller
{
    /**
     * Show donor login form
     */
    public function showLoginForm()
    {
        if (Auth::guard('donor')->check()) {
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
        
        if (!$donor) {
            Log::error('Login failed: Donor not found', ['email' => $credentials['email']]);
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->withInput($request->only('email'));
        }
        
        $passwordCheck = Hash::check($credentials['password'], $donor->password);
        
        Log::info('Login attempt details', [
            'email' => $credentials['email'],
            'donor_id' => $donor->id,
            'donor_found' => true,
            'password_check_result' => $passwordCheck,
            'password_in_db_length' => strlen($donor->password),
            'input_password_length' => strlen($credentials['password'])
        ]);

        if (Auth::guard('donor')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            Log::info('Login successful', ['email' => $credentials['email']]);
            
            // Send email notification
            $donor = Auth::guard('donor')->user();
            sendEmail(
                'emails.admin_message',
                [
                    'title'    => 'New Login Detected',
                    'message'  => 'A new login was recorded on your APN Membership account.',
                    'user_info'=> $donor->firstname . ' ' . $donor->lastname . ' (' . $donor->email . ')',
                    'time'     => now()->format('d M Y, h:i A'),
                ],
                $donor->email,
                'APN Membership — New Login Detected'
            );

            // Check if donor has active membership and redirect accordingly
            $member = Member::where('donor_id', $donor->id)
                            ->where('status', 'active')
                            ->first();
            
            if ($member) {
                return redirect()->intended(route('member.dashboard'));
            }
            
            return redirect()->intended(route('donor.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    /**
     * Handle donor registration
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:donors',
            'phone'     => 'nullable|string|max:20',
            'country'   => 'nullable|string|max:100',
            'address'   => 'nullable|string|max:255',
            'city'      => 'nullable|string|max:100',
            'region'    => 'nullable|string|max:100',
            'postcode'  => 'nullable|string|max:20',
            'password'  => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Create the donor
        $donor = Donor::create([
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
            'password'      => Hash::make($request->password),
        ]);

        // Welcome email → donor
        sendEmail(
            'emails.admin_message',
            [
                'title'      => 'Welcome to Africa Prosperity Network!',
                'message'    => 'Your donor account has been created successfully. We are glad to have you as part of our community.',
                'user_info'  => $donor->firstname . ' ' . $donor->lastname,
                'time'       => now()->format('d M Y, h:i A'),
                'action_url' => route('donor.dashboard'),
            ],
            $donor->email,
            'Welcome to APN Membership'
        );

        // Notify admin of new registration
        messageAdmin([
            'title'    => 'New Donor Registration',
            'message'  => 'A new donor has just registered on the APN Membership portal.',
            'user_info'=> $donor->firstname . ' ' . $donor->lastname . ' — ' . $donor->email . ' (' . ($donor->country ?? 'N/A') . ')',
            'time'     => now()->format('d M Y, h:i A'),
            'action_url'=> route('donor.dashboard'),
        ]);

        Auth::guard('donor')->login($donor);
        $member = Member::where('donor_id', $donor->id)
                        ->where('status', 'active')
                        ->first();
        
        if ($member) {
            return redirect()->route('member.dashboard')->with('success', 'Welcome! Your account has been created successfully.');
        }
        
        return redirect()->route('donor.dashboard')->with('success', 'Welcome! Your account has been created successfully.');
    }

    /**
     * Handle donor logout
     */
    public function logout(Request $request)
    {
        $donor = Auth::guard('donor')->user();

        Auth::guard('donor')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($donor) {
            sendEmail(
                'emails.admin_message',
                [
                    'title'   => 'You have been logged out',
                    'message' => 'You have successfully logged out of your APN Membership account. If this was not you, please contact support immediately.',
                    'time'    => now()->format('d M Y, h:i A'),
                ],
                $donor->email,
                'APN Membership — Logout Notification'
            );
        }

        return redirect()->route('donor.login')->with('success', 'You have been logged out successfully.');
    }

    /**
     * Show donor dashboard
     */
   /**
 * Show donor dashboard
 */
public function dashboard()
{
    $donor = Auth::guard('donor')->user();
    
    // Check if donor has a membership
    $member = Member::where('donor_id', $donor->id)->first();
    
    // Get donation stats
    $donations = Donation::where('donor_id', $donor->id)
        ->where('payment_status', 'success')
        ->get();
    
    $recentDonations = Donation::where('donor_id', $donor->id)
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();
    
    $stats = [
        'total_donations' => $donations->count(),
        'total_amount' => $donations->sum('amount'),
        'member_since' => $member ? $member->start_date->format('M Y') : null,
        'is_member' => $member ? true : false,
    ];
    
    // Member status for display
    $memberStatus = null;
    $memberStatusColor = null;
    $memberStatusPulse = false;
    
    if ($member) {
        $memberStatus = strtoupper($member->status);
        $memberStatusColor = match($member->status) {
            'active' => 'green',
            'expired' => 'red',
            'cancelled' => 'orange',
            'pending' => 'yellow',
            default => 'gray'
        };
        $memberStatusPulse = in_array($member->status, ['active', 'pending']);
    }
    
    return view('donor.dashboard', compact(
        'donor', 
        'member', 
        'recentDonations', 
        'stats',
        'memberStatus',
        'memberStatusColor',
        'memberStatusPulse'
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

        // Notify donor of profile update
        sendEmail(
            'emails.admin_message',
            [
                'title'   => 'Profile Updated Successfully',
                'message' => 'Your APN Membership profile information has been updated.',
                'time'    => now()->format('d M Y, h:i A'),
            ],
            $donor->email,
            'APN Membership — Profile Updated'
        );

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

        sendEmail(
            'emails.admin_message',
            [
                'title'   => 'Password Changed Successfully',
                'message' => 'Your APN Membership account password has been changed. If you did not make this change, please contact support immediately.',
                'time'    => now()->format('d M Y, h:i A'),
            ],
            $donor->email,
            'APN Membership — Password Changed'
        );

        return back()->with('success', 'Password changed successfully.');
    }
}