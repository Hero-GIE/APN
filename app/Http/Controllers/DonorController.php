<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Models\Donor;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DonorController extends Controller
{

  /**
  * Show support page
  */
  public function support()
  {
    $donor = Auth::guard('donor')->user();
    $member = Member::where('donor_id', $donor->id)->first();
    
    $tickets = SupportTicket::where('donor_id', $donor->id)
        ->orderBy('created_at', 'desc')
        ->paginate(5);
        
    return view('donor.support', compact('donor', 'member', 'tickets'));
   }

    /**
     * Submit support ticket
     */
    public function submitTicket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'category' => 'required|string|in:technical,billing,account,donation,other',
            'message' => 'required|string|min:10',
            'priority' => 'required|string|in:low,medium,high',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $donor = Auth::guard('donor')->user();
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('support-attachments', 'public');
        }

        $ticket = SupportTicket::create([
            'donor_id' => $donor->id,
            'ticket_number' => 'TICKET-' . strtoupper(uniqid()),
            'subject' => $request->subject,
            'category' => $request->category,
            'message' => $request->message,
            'priority' => $request->priority,
            'attachment' => $attachmentPath,
            'status' => 'open',
            'created_at' => now(),
        ]);

        messageAdmin([
        'title' => '🆘 New Support Ticket',
        'message' => "New support ticket from {$donor->firstname} {$donor->lastname}",
        'user_info' => "Ticket #: {$ticket->ticket_number}<br>Subject: {$request->subject}<br>Priority: {$request->priority}<br>Category: {$request->category}",
        'time' => now()->format('d M Y, h:i A'),
        'type' => 'support_ticket',
        'details' => [
            'ticket_number' => $ticket->ticket_number,
            'subject' => $request->subject,
            'priority' => $request->priority,
            'category' => $request->category,
            'message_preview' => substr($request->message, 0, 200) . (strlen($request->message) > 200 ? '...' : ''),
            'donor_name' => $donor->firstname . ' ' . $donor->lastname,
            'donor_email' => $donor->email
        ],
        'action_url' => route('admin.support-tickets.show', $ticket->id),
        'subject' => "New Support Ticket: {$ticket->ticket_number}"
    ]);

        return back()->with('success', 'Your support ticket has been submitted successfully. We\'ll get back to you soon.');
    }


  /**
  * Show membership page within donor dashboard
  */
public function membership()
{
    $donor = Auth::guard('donor')->user();
    $member = Member::where('donor_id', $donor->id)->first();
    
    if ($member && $member->status == 'active') {
        return redirect()->route('member.dashboard')
            ->with('info', 'You are already an active member!');
    }
    
    return view('donor.membership', compact('donor', 'member'));
}
}