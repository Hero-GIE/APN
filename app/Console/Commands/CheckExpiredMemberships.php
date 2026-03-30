<?php

namespace App\Console\Commands;

use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckExpiredMemberships extends Command
{
    protected $signature = 'membership:check-expired';
    protected $description = 'Check and update expired memberships and send reminders';

    public function handle()
    {
        // Update expired memberships
      $expiredMembers = Member::where('status', 'active')
       ->where('end_date', '<=', Carbon::now()->endOfDay())
       ->with('donor')
       ->get();

        foreach ($expiredMembers as $member) {
            $member->update(['status' => 'expired']);

            // Send expiration notice using your existing sendEmail helper
            try {
                sendEmail(
                    'emails.membership-expiration-reminder',
                    [
                        'donor'  => $member->donor,
                        'member' => $member,
                    ],
                    $member->donor->email,
                    'Your APN Membership Has Expired'
                );
                $this->info("Expired membership and sent email for donor: {$member->donor_id}");
            } catch (\Exception $e) {
                $this->error("Failed to send email for donor {$member->donor_id}: {$e->getMessage()}");
            }
        }

        // Send reminders for members expiring within 7 days
        $expiringSoon = Member::where('status', 'active')
            ->where('end_date', '>', Carbon::now())
            ->where('end_date', '<', Carbon::now()->addDays(7))
            ->with('donor')
            ->get();

        foreach ($expiringSoon as $member) {
            $daysLeft = Carbon::now()->diffInDays($member->end_date);

            $lastReminder = $member->last_reminder_sent_at;
            if (!$lastReminder || Carbon::parse($lastReminder)->diffInDays(now()) >= 3) {
                try {
                    sendEmail(
                        'emails.membership-expired',
                        [
                            'donor'    => $member->donor,
                            'member'   => $member,
                            'daysLeft' => $daysLeft,
                        ],
                        $member->donor->email,
                        "Your APN Membership Expires in {$daysLeft} Days"
                    );

                    $member->update(['last_reminder_sent_at' => now()]);
                    $this->info("Sent reminder to donor: {$member->donor_id} ({$daysLeft} days left)");
                } catch (\Exception $e) {
                    $this->error("Failed to send reminder to donor {$member->donor_id}: {$e->getMessage()}");
                }
            }
        }

        $this->info("Processed {$expiredMembers->count()} expired memberships");
        $this->info("Processed {$expiringSoon->count()} expiration reminders");

        return Command::SUCCESS;
    }
}