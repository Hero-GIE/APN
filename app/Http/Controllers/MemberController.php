<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use App\Models\Member;
use App\Models\MemberPayment;
use App\Models\Donation;
use App\Models\SupportTicket;
use App\Models\News;
use App\Models\Event;
use App\Models\JobOpportunity;
use App\Models\Puzzle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\FilteredImage;

class MemberController extends Controller
{
    /**
     * Member Dashboard
     */
/**
 * Member Dashboard
 */
public function dashboard()
{
    $donor = Auth::guard('donor')->user();
    
    $member = Member::where('donor_id', $donor->id)
        ->orderBy('created_at', 'desc')
        ->first();

    if (!$member) {
        return redirect()->route('donor.membership')
            ->with('error', 'You are not a member yet. Please purchase a membership to access this page.');
    }
    
      if ($member->status === 'active' 
        && $member->end_date 
        && $member->end_date->lte(Carbon::now()->endOfDay())) {
        $member->update(['status' => 'expired']);
        $member->refresh();
    }
    // Check if there's an active membership for data queries
    $activeMember = Member::where('donor_id', $donor->id)
        ->where('status', 'active')
        ->orderBy('end_date', 'asc')
        ->first();
    
    // Get recent payments (last 5) - only if there are payments
    $payments = MemberPayment::where('donor_id', $donor->id)
        ->orderBy('payment_date', 'desc')
        ->take(5)
        ->get();
    
    // Get recent donations (last 5)
    $donations = Donation::where('donor_id', $donor->id)
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();
    
    // Get news for the news tab 
    $news = News::where('is_published', true)
        ->orderBy('published_date', 'desc')
        ->take(4)
        ->get();
    
    // Get upcoming events for the calendar tab
    $events = Event::where('is_published', true)
        ->where('start_date', '>=', now())
        ->orderBy('start_date', 'asc')
        ->take(4)
        ->get();
    
    // Get jobs for the jobs tab
    $jobs = JobOpportunity::where('is_published', true)
        ->orderBy('posted_date', 'desc')
        ->take(4)
        ->get();
    
    // ===== CAROUSEL DATA =====
    $featuredNews = News::where('is_published', true)
        ->where('is_featured', true)
        ->orderBy('published_date', 'desc')
        ->take(2)
        ->get();
    
    $featuredEvents = Event::where('is_published', true)
        ->where('is_featured', true)
        ->where('start_date', '>=', now())
        ->orderBy('start_date', 'asc')
        ->take(2)
        ->get();
    
    $featuredJobs = JobOpportunity::where('is_published', true)
        ->where('is_featured', true)
        ->orderBy('posted_date', 'desc')
        ->take(2)
        ->get();
    
    // ===== PUZZLE DATA FOR GAMES TAB =====
    $featuredQuizzes = Puzzle::where('type', 'quiz')
        ->where('is_active', true)
        ->where('is_featured', true)
        ->orderBy('created_at', 'desc')
        ->limit(3)
        ->get();
    
    $featuredWordsearches = Puzzle::where('type', 'wordsearch')
        ->where('is_active', true)
        ->where('is_featured', true)
        ->orderBy('created_at', 'desc')
        ->limit(3)
        ->get();
    
    $popularPuzzles = Puzzle::where('is_active', true)
        ->orderBy('play_count', 'desc')
        ->limit(6)
        ->get();
    
    // Calculate statistics for the dashboard 
    $stats = [
        'total_payments'  => MemberPayment::where('donor_id', $donor->id)->count(),
        'total_spent'     => MemberPayment::where('donor_id', $donor->id)->sum('amount'),
        'days_left'       => $activeMember ? $activeMember->daysLeft() : 0,
        'renewals'        => $activeMember ? $activeMember->renewal_count : 0,
        'total_donations' => Donation::where('donor_id', $donor->id)->count(),
        'total_donated'   => Donation::where('donor_id', $donor->id)->sum('amount'),
    ];
    
    // Status configuration for the membership badge
    $statusConfig = [
        'color' => match($member->status) {
            'active'    => 'green',
            'expired'   => 'red',
            'cancelled' => 'orange',
            'pending'   => 'yellow',
            default     => 'gray'
        },
        'text'  => strtoupper($member->status),
        'pulse' => in_array($member->status, ['active', 'pending'])
    ];
    
    // Latest filtered image for avatar
    $latestFilteredImage = FilteredImage::where('user_id', $donor->id)
        ->latest()
        ->first();

    // Return the view with all data
    return view('member.dashboard', compact(
        'donor',
        'member',
        'activeMember',  // Pass the active member separately
        'payments',
        'donations',
        'stats',
        'statusConfig',
        'news',
        'events',
        'jobs',
        'latestFilteredImage',
        'featuredQuizzes',
        'featuredWordsearches',
        'popularPuzzles',
        'featuredNews',
        'featuredEvents',
        'featuredJobs'
    ));
}

    /**
     * Member Benefits Page
     */
    public function benefits()
    {
        $donor = Auth::guard('donor')->user();
        $member = Member::where('donor_id', $donor->id)->first();

        if (!$member) {
            return redirect()->route('donor.membership')
                ->with('error', 'You are not a member yet.');
        }

        $statusConfig = [
            'color' => match($member->status) {
                'active' => 'green',
                'expired' => 'red',
                'cancelled' => 'orange',
                'pending' => 'yellow',
                default => 'gray'
            },
            'text' => strtoupper($member->status),
            'pulse' => in_array($member->status, ['active', 'pending'])
        ];

        return view('member.benefits', compact('donor', 'member', 'statusConfig'));
    }

    /**
     * Payment History
     */
    public function payments()
    {
        $donor = Auth::guard('donor')->user();
        $member = Member::where('donor_id', $donor->id)->first();

        if (!$member) {
            return redirect()->route('donor.membership')
                ->with('error', 'You are not a member yet.');
        }

        $payments = MemberPayment::where('donor_id', $donor->id)
            ->orderBy('payment_date', 'desc')
            ->paginate(10);

        return view('member.payments', compact('donor', 'member', 'payments'));
    }

    /**
     * All Transactions
     */
    public function transactions()
    {
        $donor = Auth::guard('donor')->user();
        $member = Member::where('donor_id', $donor->id)->first();

        // Get member payments
        $memberPayments = MemberPayment::where('donor_id', $donor->id)
            ->orderBy('payment_date', 'desc')
            ->get()
            ->map(function($payment) {
                return [
                    'id' => $payment->id,
                    'date' => $payment->payment_date,
                    'transaction_id' => $payment->transaction_id,
                    'description' => ucfirst($payment->membership_type) . ' Membership Payment',
                    'amount' => $payment->amount,
                    'type' => 'membership',
                    'status' => $payment->payment_status,
                    'payment_method' => $payment->payment_method ?? 'Card',
                ];
            });

        // Get donations
        $donations = Donation::where('donor_id', $donor->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($donation) {
                return [
                    'id' => $donation->id,
                    'date' => $donation->created_at,
                    'transaction_id' => $donation->transaction_id,
                    'description' => $donation->description ?? 'General Donation',
                    'amount' => $donation->amount,
                    'type' => 'donation',
                    'status' => $donation->payment_status,
                    'payment_method' => $donation->payment_method ?? 'Card',
                ];
            });

        // Combine and sort transactions
        $transactions = $memberPayments->concat($donations)
            ->sortByDesc('date')
            ->values();

        // Paginate the combined results
        $page = request()->get('page', 1);
        $perPage = 15;
        $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $transactions->forPage($page, $perPage),
            $transactions->count(),
            $perPage,
            $page,
            ['path' => request()->url()]
        );

        return view('member.transactions', compact(
            'donor', 
            'member', 
            'transactions', 
            'paginated',
            'memberPayments' 
        ));
    }

    /**
     * Show Profile
     */
    public function profile()
    {
        $donor = Auth::guard('donor')->user();
        $member = Member::where('donor_id', $donor->id)->first();

        return view('member.profile', compact('donor', 'member'));
    }

    /**
     * Edit Profile
     */
    public function editProfile()
    {
        $donor = Auth::guard('donor')->user();
        $member = Member::where('donor_id', $donor->id)->first();

        return view('member.profile-edit', compact('donor', 'member'));
    }

    /**
     * Update Profile
     */
    public function updateProfile(Request $request)
    {
        $donor = Auth::guard('donor')->user();

        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:donors,email,' . $donor->id,
            'phone' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'region' => 'nullable|string|max:100',
            'postcode' => 'nullable|string|max:20',
            'email_updates' => 'sometimes|boolean',
            'text_updates' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $donor->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
            'country' => $request->country,
            'address' => $request->address,
            'city' => $request->city,
            'region' => $request->region,
            'postcode' => $request->postcode,
            'email_updates' => $request->boolean('email_updates', true),
            'text_updates' => $request->boolean('text_updates', false),
        ]);

        return redirect()->route('member.profile.show')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Show Change Password Form
     */
    public function showChangePasswordForm()
    {
        $donor = Auth::guard('donor')->user();
        $member = Member::where('donor_id', $donor->id)->first();

        return view('member.change-password', compact('donor', 'member'));
    }

    /**
     * Change Password
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            Log::warning('Password change validation failed', [
                'errors' => $validator->errors()->toArray()
            ]);
            
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $donor = Auth::guard('donor')->user();
        
        if (!Hash::check($request->current_password, $donor->password)) {
            Log::warning('Current password incorrect', [
                'donor_id' => $donor->id,
                'provided_password_length' => strlen($request->current_password)
            ]);
            
            return redirect()->back()
                ->with('error', 'Current password is incorrect.');
        }

        // Hash the new password
        $newHashedPassword = Hash::make($request->new_password);
        
        Log::info('New password hashed', [
            'new_hash_length' => strlen($newHashedPassword)
        ]);

        // Update password
        try {
            $updateResult = $donor->update([
                'password' => $newHashedPassword
            ]);

            $updatedDonor = Donor::find($donor->id);
            $verifyCheck = Hash::check($request->new_password, $updatedDonor->password);
            
            Log::info('Password update verification', [
                'new_password_works' => $verifyCheck,
                'updated_at' => $updatedDonor->updated_at->toDateTimeString()
            ]);

            if (!$verifyCheck) {
                Log::error('Password update verification failed - new password does not work');
            }

        } catch (\Exception $e) {
            Log::error('Exception during password update', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->with('error', 'An error occurred while updating your password. Please try again.');
        }

        return redirect()->route('member.profile.show')
            ->with('success', 'Password changed successfully.');
    }

    /**
     * Support Page
     */
    public function support()
    {
        $donor = Auth::guard('donor')->user();
        $member = Member::where('donor_id', $donor->id)->first();
        
        $tickets = SupportTicket::where('donor_id', $donor->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('member.support', compact('donor', 'member', 'tickets'));
    }

    /**
     * Submit Support Ticket
     */
    public function submitTicket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'category' => 'required|string|in:technical,billing,account,membership,other',
            'message' => 'required|string|min:10',
            'priority' => 'required|string|in:low,medium,high',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $donor = Auth::guard('donor')->user();
        $member = Member::where('donor_id', $donor->id)->first();

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')
                ->store('support-attachments/' . $donor->id, 'public');
        }

        $ticket = SupportTicket::create([
            'donor_id' => $donor->id,
            'member_id' => $member->id ?? null,
            'ticket_number' => 'TICKET-' . strtoupper(uniqid()),
            'subject' => $request->subject,
            'category' => $request->category,
            'message' => $request->message,
            'priority' => $request->priority,
            'attachment' => $attachmentPath,
            'status' => 'open',
        ]);

        Log::info('Support ticket created', [
            'donor_id' => $donor->id,
            'ticket_id' => $ticket->id
        ]);

        return redirect()->route('member.support')
            ->with('success', 'Support ticket submitted successfully. We\'ll get back to you within 24 hours.');
    }

  /**
  * Membership Page
  */
  public function membership()
  {
    $donor = Auth::guard('donor')->user();
    $member = Member::where('donor_id', $donor->id)->first();

    return view('member.membership', compact('donor', 'member'));
  }

    /**
     * Cancel Membership
     */
    public function cancelMembership(Request $request)
    {
        $donor = Auth::guard('donor')->user();
        $member = Member::where('donor_id', $donor->id)
            ->where('status', 'active')
            ->first();

        if (!$member) {
            return redirect()->back()
                ->with('error', 'No active membership found.');
        }

        $member->update([
            'status' => 'cancelled',
        ]);

        Log::info('Membership cancelled', [
            'donor_id' => $donor->id,
            'member_id' => $member->id
        ]);

        return redirect()->route('member.dashboard')
            ->with('success', 'Your membership has been cancelled. You will continue to have access until the end of your billing period.');
    }

    /**
     * Renew Membership
     */
    public function renew()
    {
        $donor = Auth::guard('donor')->user();
        $member = Member::where('donor_id', $donor->id)->first();

        if (!$member) {
            return redirect()->route('donor.membership');
        }

        return redirect()->route('donate', ['type' => $member->membership_type, 'renew' => true]);
    }

    /**
     * Download Payment Receipt
     */
    public function downloadReceipt($paymentId)
    {
        $donor = Auth::guard('donor')->user();
        $payment = MemberPayment::where('id', $paymentId)
            ->where('donor_id', $donor->id)
            ->firstOrFail();

        $receipt = view('member.receipt', compact('payment', 'donor'))->render();

        return response($receipt)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', 'attachment; filename="receipt-' . $payment->transaction_id . '.html"');
    }

    /**
     * Show About APN page
     */
    public function about()
    {
        $donor = Auth::guard('donor')->user();
        $member = Member::where('donor_id', $donor->id)->first();
        
        return view('member.about', compact('donor', 'member'));
    }
}