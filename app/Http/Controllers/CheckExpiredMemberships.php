<?php

namespace App\Console\Commands;

use App\Models\Member;
use App\Mail\MembershipExpired;
use App\Mail\MembershipExpirationReminder;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckExpiredMemberships extends Command
{
    protected $signature = 'membership:check-expired';
    protected $description = 'Check and update expired memberships and send reminders';

    public function handle()
    {
        // Update expired memberships (status: active but end_date passed)
        $expiredMembers = Member::where('status', 'active')
            ->where('end_date', '<', Carbon::now())
            ->get();

        foreach ($expiredMembers as $member) {
            $member->update(['status' => 'expired']);
            
            // Send expiration notice email
            try {
                Mail::to($member->donor->email)->send(new MembershipExpired($member));
                $this->info("Expired membership and sent email for donor: {$member->donor_id}");
            } catch (\Exception $e) {
                $this->error("Failed to send email for donor {$member->donor_id}: {$e->getMessage()}");
            }
        }

        // Send reminder for members expiring in 7 days
        $expiringSoon = Member::where('status', 'active')
            ->where('end_date', '>', Carbon::now())
            ->where('end_date', '<', Carbon::now()->addDays(7))
            ->get();

        foreach ($expiringSoon as $member) {
            $daysLeft = Carbon::now()->diffInDays($member->end_date);
            
            // Only send if reminder hasn't been sent in the last 3 days
            $lastReminder = $member->last_reminder_sent_at;
            if (!$lastReminder || Carbon::parse($lastReminder)->diffInDays(now()) >= 3) {
                try {
                    Mail::to($member->donor->email)->send(new MembershipExpirationReminder($member, $daysLeft));
                    
                    $member->update(['last_reminder_sent_at' => now()]);
                    $this->info("Sent reminder to donor: {$member->donor_id} ({$daysLeft} days left)");
                } catch (\Exception $e) {
                    $this->error("Failed to send reminder to donor {$member->donor_id}: {$e->getMessage()}");
                }
            }
        }

        $this->info("Processed {$expiredMembers->count()} expired memberships");
        $this->info("Sent {$expiringSoon->count()} expiration reminders");
        
        return Command::SUCCESS;
    }
}