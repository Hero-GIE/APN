<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use App\Models\Member;
use App\Models\MemberPayment;
use App\Models\Donation;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class MemberController extends Controller
{
    /**
     * Member Dashboard
     */
    public function dashboard()
    {
        $donor = Auth::guard('donor')->user();
        $member = Member::where('donor_id', $donor->id)->first();
        
        if (!$member) {
            return redirect()->route('donor.membership')
                ->with('error', 'You are not a member yet. Please purchase a membership.');
        }

        $payments = MemberPayment::where('donor_id', $donor->id)
            ->with('donation')
            ->orderBy('payment_date', 'desc')
            ->take(5)
            ->get();

        $donations = Donation::where('donor_id', $donor->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $stats = [
            'total_payments' => MemberPayment::where('donor_id', $donor->id)->count(),
            'total_spent' => MemberPayment::where('donor_id', $donor->id)->sum('amount'),
            'days_left' => $member->daysLeft(),
            'renewals' => $member->renewal_count,
        ];

        // Prepare status configuration
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

        return view('member.dashboard', compact('donor', 'member', 'payments', 'donations', 'stats', 'statusConfig'));
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
            ->with('donation')
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

        $memberPayments = MemberPayment::where('donor_id', $donor->id)
            ->with('donation')
            ->get()
            ->map(function($payment) {
                return [
                    'id' => $payment->id,
                    'date' => $payment->payment_date,
                    'transaction_id' => $payment->donation->transaction_id ?? 'N/A',
                    'description' => ucfirst($payment->membership_type) . ' Membership',
                    'amount' => $payment->amount,
                    'type' => 'membership',
                    'status' => 'success',
                    'payment_method' => $payment->donation->payment_method ?? 'Card',
                ];
            });

        $donations = Donation::where('donor_id', $donor->id)
            ->where('payment_status', 'success')
            ->get()
            ->map(function($donation) {
                return [
                    'id' => $donation->id,
                    'date' => $donation->created_at,
                    'transaction_id' => $donation->transaction_id,
                    'description' => 'Donation',
                    'amount' => $donation->amount,
                    'type' => 'donation',
                    'status' => $donation->payment_status,
                    'payment_method' => $donation->payment_method ?? 'Card',
                ];
            });

        $transactions = $memberPayments->concat($donations)
            ->sortByDesc('date')
            ->values();

        $page = request()->get('page', 1);
        $perPage = 15;
        $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $transactions->forPage($page, $perPage),
            $transactions->count(),
            $perPage,
            $page,
            ['path' => request()->url()]
        );

        return view('member.transactions', compact('donor', 'member', 'transactions', 'paginated', 'memberPayments', 'donations'));
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
        $payment = MemberPayment::with('donation')
            ->where('id', $paymentId)
            ->where('donor_id', $donor->id)
            ->firstOrFail();

        $receipt = view('member.receipt', compact('payment', 'donor'))->render();

        return response($receipt)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', 'attachment; filename="receipt-' . $payment->donation->transaction_id . '.html"');
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