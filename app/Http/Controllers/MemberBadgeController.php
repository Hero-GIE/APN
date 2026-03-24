<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class MemberBadgeController extends Controller
{
    /**
     * Show badge management page
     */
   public function index()
{
    $donor = Auth::guard('donor')->user();
    $member = Member::where('donor_id', $donor->id)->first();
    
    if (!$member) {
        return redirect()->route('donor.membership')
            ->with('error', 'You need to be a member to access badges.');
    }
    
    if (!$member->badge_token) {
        do {
            $token = Str::random(32);
        } while (Member::where('badge_token', $token)->exists());
        
        $member->badge_token = $token;
        $member->save();
        
        Log::info('Badge token generated for member', [
            'member_id' => $member->id,
            'donor_id' => $donor->id
        ]);
    }
    
    // Generate embed codes
    $badgeUrl = route('member.badge.image', ['token' => $member->badge_token]);
    $verifyUrl = route('member.badge.verify', ['token' => $member->badge_token]);
    
    $embedCodes = [
        'html' => '<a href="' . $verifyUrl . '" target="_blank"><img src="' . $badgeUrl . '" alt="APN Member" style="border:0;"></a>',
        'markdown' => '[![APN Member](' . $badgeUrl . ')](' . $verifyUrl . ')',
        'bbcode' => '[url=' . $verifyUrl . '][img]' . $badgeUrl . '[/img][/url]',
        'iframe' => '<iframe src="' . route('member.badge.widget', ['token' => $member->badge_token]) . '" width="200" height="200" frameborder="0" scrolling="no"></iframe>',
    ];
    
    return view('member.badges', compact('donor', 'member', 'embedCodes', 'badgeUrl', 'verifyUrl'));
}
    
    /**
     * Serve the badge image
     */
    public function image($token)
    {
        $member = Member::where('badge_token', $token)->first();
        
        if (!$member) {
            return $this->getBadgeResponse('not-found');
        }
        if ($member->status === 'active') {
            $badgeType = 'active';
        } elseif ($member->status === 'expired') {
            $badgeType = 'expired';
        } elseif ($member->status === 'cancelled') {
            $badgeType = 'cancelled';
        } else {
            $badgeType = 'pending';
        }
        $this->logBadgeView($member, request()->header('Referer'));
        
        return $this->getBadgeResponse($badgeType);
    }
    
    /**
     * Serve the badge as a widget (iframe)
     */
    public function widget($token)
    {
        $member = Member::where('badge_token', $token)->first();
        
        if (!$member) {
            return view('member.badge-widget', ['member' => null, 'error' => 'Member not found']);
        }
        
        $this->logBadgeView($member, request()->header('Referer'), 'widget');
        
        return view('member.badge-widget', compact('member'));
    }
    
    /**
     * Verify a member badge
     */
    public function verify($token)
    {
        $member = Member::where('badge_token', $token)->first();
        
        if (!$member) {
            return view('member.badge-verify', ['member' => null, 'valid' => false]);
        }
        
        $donor = $member->donor;
        
        $this->logBadgeView($member, request()->header('Referer'), 'verification');
        
        return view('member.badge-verify', [
            'member' => $member,
            'donor' => $donor,
            'valid' => $member->status === 'active'
        ]);
    }
    
    /**
     * Regenerate badge token (if compromised)
     */
    public function regenerateToken(Request $request)
    {
        $donor = Auth::guard('donor')->user();
        $member = Member::where('donor_id', $donor->id)->first();
        
        if (!$member) {
            return redirect()->back()->with('error', 'Member not found.');
        }
        
        $member->badge_token = Str::random(32);
        $member->save();
        
        return redirect()->route('member.badges')
            ->with('success', 'Badge token regenerated successfully. Update your embed codes with the new URL.');
    }
    
    /**
     * Get badge image response
     */
    private function getBadgeResponse($type)
    {
        $imagePath = public_path("images/badges/badge-{$type}.png");
        
        if (!file_exists($imagePath)) {
            $imagePath = public_path("images/badges/badge-active.png");
        }
        
        $image = file_get_contents($imagePath);
        
        return Response::make($image, 200, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'inline',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
    
    /**
     * Log badge view for analytics
     */
    private function logBadgeView($member, $referer = null, $type = 'image')
    {
   
        \Illuminate\Support\Facades\Log::info('Badge viewed', [
            'member_id' => $member->id,
            'member_name' => $member->donor->firstname . ' ' . $member->donor->lastname,
            'type' => $type,
            'referer' => $referer,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now()->toDateTimeString()
        ]);
    }
    
    /**
     * Download badge image
     */
    public function download(Request $request)
    {
        $donor = Auth::guard('donor')->user();
        $member = Member::where('donor_id', $donor->id)->first();
        
        if (!$member || $member->status !== 'active') {
            return redirect()->back()->with('error', 'Only active members can download badges.');
        }
        
        $format = $request->get('format', 'png');
        
        if ($format === 'svg') {
            $imagePath = public_path('images/badges/badge-active.svg');
            $contentType = 'image/svg+xml';
            $extension = 'svg';
        } else {
            $imagePath = public_path('images/badges/badge-active.png');
            $contentType = 'image/png';
            $extension = 'png';
        }
        
        if (!file_exists($imagePath)) {
            return redirect()->back()->with('error', 'Badge image not found.');
        }
        
        $fileName = "apn-member-badge-{$donor->firstname}-{$donor->lastname}.{$extension}";
        
        return Response::download($imagePath, $fileName, [
            'Content-Type' => $contentType
        ]);
    }
}