<?php

namespace App\Console\Commands;

use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckExpiringMemberships extends Command
{
    protected $signature = 'membership:check-expiring';
    protected $description = 'Check for memberships expiring soon and send reminders';

    public function handle()
    {
        $expiringSoon = Member::where('status', 'active')
            ->where('end_date', '<=', Carbon::now()->addDays(7))
            ->where('end_date', '>', Carbon::now())
            ->get();

        foreach ($expiringSoon as $member) {
            // Send reminder email
            if (function_exists('sendEmail')) {
                sendEmail(
                    'emails.member-expiring',
                    ['member' => $member],
                    $member->donor->email,
                    'Your APN Membership is Expiring Soon'
                );
            }
            
            $member->update(['renewal_reminder_sent_at' => Carbon::now()]);
            
            $this->info("Reminder sent to {$member->donor->email}");
        }

        // Expire past memberships
        $expired = Member::where('status', 'active')
            ->where('end_date', '<', Carbon::now())
            ->update(['status' => 'expired']);

        $this->info("{$expiringSoon->count()} expiring reminders sent. {$expired} memberships expired.");

        return 0;
    }
}