<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\FilteredImage;

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
        
        // Ensure all badge images exist
        $this->ensureBadgeImagesExist();
        
        // Get the latest filtered image for the profile picture
        $latestFilteredImage = FilteredImage::where('user_id', $donor->id)
            ->latest()
            ->first();
        
        // Generate embed codes
        $badgeUrl = route('member.badge.image', ['token' => $member->badge_token]);
        $verifyUrl = route('member.badge.verify', ['token' => $member->badge_token]);
        
        $embedCodes = [
            'html' => '<a href="' . $verifyUrl . '" target="_blank"><img src="' . $badgeUrl . '" alt="APN Member" style="border:0; width:150px;"></a>',
            'markdown' => '[![APN Member](' . $badgeUrl . ')](' . $verifyUrl . ')',
            'bbcode' => '[url=' . $verifyUrl . '][img]' . $badgeUrl . '[/img][/url]',
            'iframe' => '<iframe src="' . route('member.badge.widget', ['token' => $member->badge_token]) . '" width="200" height="200" frameborder="0" scrolling="no"></iframe>',
        ];
        
        return view('member.badges', compact('donor', 'member', 'embedCodes', 'badgeUrl', 'verifyUrl', 'latestFilteredImage'));
    }
    
    /**
     * Serve the badge image with profile picture (optimized sizing)
     */
    public function image($token)
    {
        $member = Member::where('badge_token', $token)->first();
        
        if (!$member) {
            return $this->getBadgeResponse('not-found');
        }
        
        $this->ensureBadgeImagesExist();
        
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
        
        return $this->getBadgeWithProfileImage($member, $badgeType);
    }
    
/**
 * Get badge with properly sized profile image overlay
 */
private function getBadgeWithProfileImage($member, $badgeType)
{
    $badgePath = public_path('images/badges/badge-' . $badgeType . '.png');
    
    if (!file_exists($badgePath)) {
        $this->createBadgeImage($badgeType);
        $badgePath = public_path('images/badges/badge-' . $badgeType . '.png');
    }
    
    // Create image from badge
    $badgeImg = imagecreatefrompng($badgePath);
    $badgeWidth = imagesx($badgeImg);
    $badgeHeight = imagesy($badgeImg);
    
    // Get profile image
    $profileImagePath = $this->getProfileImagePath($member->donor);
    
    // If profile image exists, use it as the full badge background
    if ($profileImagePath && file_exists($profileImagePath)) {
        // Get image info to determine type
        $imageInfo = getimagesize($profileImagePath);
        $imageType = $imageInfo[2];
        
        // Load profile image based on type
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $profileImg = imagecreatefromjpeg($profileImagePath);
                break;
            case IMAGETYPE_PNG:
                $profileImg = imagecreatefrompng($profileImagePath);
                break;
            case IMAGETYPE_WEBP:
                $profileImg = imagecreatefromwebp($profileImagePath);
                break;
            default:
                $profileImg = null;
        }
        
        if ($profileImg) {
            // Create final image with transparency
            $finalImg = imagecreatetruecolor($badgeWidth, $badgeHeight);
            imagealphablending($finalImg, false);
            imagesavealpha($finalImg, true);
            $transparent = imagecolorallocatealpha($finalImg, 0, 0, 0, 127);
            imagefill($finalImg, 0, 0, $transparent);
            
            // Resize profile image to fit the badge dimensions
            $originalWidth = imagesx($profileImg);
            $originalHeight = imagesy($profileImg);
            
            // Calculate scaling to cover the entire badge
            $scale = max($badgeWidth / $originalWidth, $badgeHeight / $originalHeight);
            $newWidth = $originalWidth * $scale;
            $newHeight = $originalHeight * $scale;
            
            // Create resized profile image
            $resizedProfile = imagecreatetruecolor($badgeWidth, $badgeHeight);
            imagealphablending($resizedProfile, false);
            imagesavealpha($resizedProfile, true);
            $transparentResized = imagecolorallocatealpha($resizedProfile, 0, 0, 0, 127);
            imagefill($resizedProfile, 0, 0, $transparentResized);
            
            // Calculate position to center the image (for cover effect)
            $srcX = ($newWidth - $badgeWidth) / 2;
            $srcY = ($newHeight - $badgeHeight) / 2;
            
            // Resize and crop to center for cover effect
            imagecopyresampled($resizedProfile, $profileImg, 
                0, 0, 
                $srcX, $srcY, 
                $badgeWidth, $badgeHeight, 
                $originalWidth, $originalHeight);
            
            // Copy the profile image as the base
            imagecopy($finalImg, $resizedProfile, 0, 0, 0, 0, $badgeWidth, $badgeHeight);
            
            // Overlay the badge design on top with transparency
            imagealphablending($finalImg, true);
            imagecopy($finalImg, $badgeImg, 0, 0, 0, 0, $badgeWidth, $badgeHeight);
            
            imagedestroy($profileImg);
            imagedestroy($resizedProfile);
            
            // Output image
            ob_start();
            imagepng($finalImg);
            $imageData = ob_get_clean();
            
            imagedestroy($badgeImg);
            imagedestroy($finalImg);
            
            return Response::make($imageData, 200, [
                'Content-Type' => 'image/png',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
            ]);
        }
    }
    
    // If no profile image, just return the badge
    $finalImg = imagecreatetruecolor($badgeWidth, $badgeHeight);
    imagealphablending($finalImg, false);
    imagesavealpha($finalImg, true);
    $transparent = imagecolorallocatealpha($finalImg, 0, 0, 0, 127);
    imagefill($finalImg, 0, 0, $transparent);
    imagecopy($finalImg, $badgeImg, 0, 0, 0, 0, $badgeWidth, $badgeHeight);
    
    ob_start();
    imagepng($finalImg);
    $imageData = ob_get_clean();
    
    imagedestroy($badgeImg);
    imagedestroy($finalImg);
    
    return Response::make($imageData, 200, [
        'Content-Type' => 'image/png',
        'Cache-Control' => 'no-cache, no-store, must-revalidate',
    ]);
}
    
    /**
     * Get profile image path from FilteredImage model
     */
    private function getProfileImagePath($donor)
    {
        // Get the latest filtered image for this donor
        $filteredImage = FilteredImage::where('user_id', $donor->id)
            ->latest()
            ->first();
        
        if ($filteredImage && $filteredImage->filtered_image) {
            // Check in storage/app/public directory
            $path = storage_path('app/public/' . $filteredImage->filtered_image);
            if (file_exists($path)) {
                return $path;
            }
            
            // Also check in public/storage directory (if symlinked)
            $publicPath = public_path('storage/' . $filteredImage->filtered_image);
            if (file_exists($publicPath)) {
                return $publicPath;
            }
        }
        
        return null;
    }
    
 /**
 * Download badge with profile image
 */
public function download(Request $request)
{
    $donor = Auth::guard('donor')->user();
    $member = Member::where('donor_id', $donor->id)->first();
    
    if (!$member) {
        return redirect()->back()->with('error', 'Member not found.');
    }
    
    if ($member->status !== 'active') {
        return redirect()->back()->with('error', 'Only active members can download badges.');
    }
    
    $badgeType = 'active';
    $badgePath = public_path('images/badges/badge-' . $badgeType . '.png');
    
    if (!file_exists($badgePath)) {
        $this->createBadgeImage($badgeType);
    }
    
    // Create image from badge
    $badgeImg = imagecreatefrompng($badgePath);
    $badgeWidth = imagesx($badgeImg);
    $badgeHeight = imagesy($badgeImg);
    
    // Get profile image
    $profileImagePath = $this->getProfileImagePath($donor);
    
    // If profile image exists, use it as the full badge background
    if ($profileImagePath && file_exists($profileImagePath)) {
        // Get image info to determine type
        $imageInfo = getimagesize($profileImagePath);
        $imageType = $imageInfo[2];
        
        // Load profile image based on type
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $profileImg = imagecreatefromjpeg($profileImagePath);
                break;
            case IMAGETYPE_PNG:
                $profileImg = imagecreatefrompng($profileImagePath);
                break;
            case IMAGETYPE_WEBP:
                $profileImg = imagecreatefromwebp($profileImagePath);
                break;
            default:
                $profileImg = null;
        }
        
        if ($profileImg) {
            // Create final image with transparency
            $finalImg = imagecreatetruecolor($badgeWidth, $badgeHeight);
            imagealphablending($finalImg, false);
            imagesavealpha($finalImg, true);
            $transparent = imagecolorallocatealpha($finalImg, 0, 0, 0, 127);
            imagefill($finalImg, 0, 0, $transparent);
            
            // Resize profile image to fit the badge dimensions
            $originalWidth = imagesx($profileImg);
            $originalHeight = imagesy($profileImg);
            
            // Calculate scaling to cover the entire badge
            $scale = max($badgeWidth / $originalWidth, $badgeHeight / $originalHeight);
            $newWidth = $originalWidth * $scale;
            $newHeight = $originalHeight * $scale;
            
            // Create resized profile image
            $resizedProfile = imagecreatetruecolor($badgeWidth, $badgeHeight);
            imagealphablending($resizedProfile, false);
            imagesavealpha($resizedProfile, true);
            $transparentResized = imagecolorallocatealpha($resizedProfile, 0, 0, 0, 127);
            imagefill($resizedProfile, 0, 0, $transparentResized);
            
            // Calculate position to center the image (for cover effect)
            $srcX = ($newWidth - $badgeWidth) / 2;
            $srcY = ($newHeight - $badgeHeight) / 2;
            
            // Resize and crop to center for cover effect
            imagecopyresampled($resizedProfile, $profileImg, 
                0, 0, 
                $srcX, $srcY, 
                $badgeWidth, $badgeHeight, 
                $originalWidth, $originalHeight);
            
            // Copy the profile image as the base
            imagecopy($finalImg, $resizedProfile, 0, 0, 0, 0, $badgeWidth, $badgeHeight);
            
            // Overlay the badge design on top with transparency
            imagealphablending($finalImg, true);
            imagecopy($finalImg, $badgeImg, 0, 0, 0, 0, $badgeWidth, $badgeHeight);
            
            imagedestroy($profileImg);
            imagedestroy($resizedProfile);
            
            // Output for download
            ob_start();
            imagepng($finalImg);
            $imageData = ob_get_clean();
            
            imagedestroy($badgeImg);
            imagedestroy($finalImg);
            
            $fileName = "apn-member-badge-" . strtolower($donor->firstname . '-' . $donor->lastname) . ".png";
            
            return Response::make($imageData, 200, [
                'Content-Type' => 'image/png',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]);
        }
    }
    
    // If no profile image, just return the badge
    $finalImg = imagecreatetruecolor($badgeWidth, $badgeHeight);
    imagealphablending($finalImg, false);
    imagesavealpha($finalImg, true);
    $transparent = imagecolorallocatealpha($finalImg, 0, 0, 0, 127);
    imagefill($finalImg, 0, 0, $transparent);
    imagecopy($finalImg, $badgeImg, 0, 0, 0, 0, $badgeWidth, $badgeHeight);
    
    ob_start();
    imagepng($finalImg);
    $imageData = ob_get_clean();
    
    imagedestroy($badgeImg);
    imagedestroy($finalImg);
    
    $fileName = "apn-member-badge-" . strtolower($donor->firstname . '-' . $donor->lastname) . ".png";
    
    return Response::make($imageData, 200, [
        'Content-Type' => 'image/png',
        'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
    ]);
}
    
    /**
     * Verify a member badge - QR code redirects here
     */
    public function verify($token)
    {
        $member = Member::where('badge_token', $token)->first();
        
        if (!$member) {
            return view('member.badge-verify', ['member' => null, 'valid' => false]);
        }
        
        $donor = $member->donor;
        $profileImagePath = $this->getProfileImagePath($donor);
        $profileImageUrl = null;
        
        if ($profileImagePath) {
            $profileImageUrl = asset('storage/' . str_replace(storage_path('app/public/'), '', $profileImagePath));
        }
        
        $this->logBadgeView($member, request()->header('Referer'), 'verification');
        
        return view('member.badge-verify', [
            'member' => $member,
            'donor' => $donor,
            'valid' => $member->status === 'active',
            'profileImageUrl' => $profileImageUrl,
            'verifyUrl' => route('member.badge.verify', ['token' => $member->badge_token]),
        ]);
    }
    
    /**
     * Ensure all badge images exist
     */
    private function ensureBadgeImagesExist()
    {
        $badgeTypes = ['active', 'expired', 'cancelled', 'pending', 'not-found', 'placeholder'];
        $directory = public_path('images/badges');
        
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        
        foreach ($badgeTypes as $type) {
            $filepath = $directory . '/badge-' . $type . '.png';
            if (!file_exists($filepath)) {
                $this->createBadgeImage($type);
            }
        }
    }
    
   private function createBadgeImage($type)
{
    $width = 300;
    $height = 300;
    
    $img = imagecreatetruecolor($width, $height);
    imageantialias($img, true);
    
    if ($type === 'active') {
        // Enable alpha blending for transparency
        imagealphablending($img, false);
        imagesavealpha($img, true);
        
        // Create transparent background
        $transparent = imagecolorallocatealpha($img, 0, 0, 0, 127);
        imagefill($img, 0, 0, $transparent);
        
        $accentColor = imagecolorallocatealpha($img, 79, 70, 229, 50); // Semi-transparent
        $textColor = imagecolorallocatealpha($img, 255, 255, 255, 200); // Mostly white
        $lightGray = imagecolorallocatealpha($img, 255, 255, 255, 150); // Semi-transparent white
        
        // Draw decorative border with accent color
        imagerectangle($img, 5, 5, $width - 5, $height - 5, $accentColor);
        imagerectangle($img, 10, 10, $width - 10, $height - 10, $accentColor);
        
        // Corner decorations (semi-transparent)
        $circleRadius = 15;
        imagefilledellipse($img, 20, 20, $circleRadius, $circleRadius, $accentColor);
        imagefilledellipse($img, $width - 20, 20, $circleRadius, $circleRadius, $accentColor);
        imagefilledellipse($img, 20, $height - 20, $circleRadius, $circleRadius, $accentColor);
        imagefilledellipse($img, $width - 20, $height - 20, $circleRadius, $circleRadius, $accentColor);
        
        // APN Logo with semi-transparent background
        $apnText = "APN";
        $fontSize = 5;
        $apnWidth = imagefontwidth($fontSize) * strlen($apnText);
        $apnX = ($width - $apnWidth) / 2;
        $apnY = 30;
        
        // Add background for APN text
        $textBgColor = imagecolorallocatealpha($img, 0, 0, 0, 80);
        imagefilledrectangle($img, $apnX - 10, $apnY - 5, $apnX + $apnWidth + 10, $apnY + 15, $textBgColor);
        imagestring($img, $fontSize, $apnX, $apnY, $apnText, $textColor);
        
        // Main text with semi-transparent background
        $mainText = "ACTIVE MEMBER";
        $textWidth = imagefontwidth($fontSize) * strlen($mainText);
        $textX = ($width - $textWidth) / 2;
        $textY = $height - 90;
        
        // Add background for main text
        imagefilledrectangle($img, $textX - 10, $textY - 5, $textX + $textWidth + 10, $textY + 15, $textBgColor);
        imagestring($img, $fontSize, $textX, $textY, $mainText, $textColor);
        
        // Member text with semi-transparent background
        $memberText = "MEMBER";
        $memberWidth = imagefontwidth($fontSize) * strlen($memberText);
        $memberX = ($width - $memberWidth) / 2;
        $memberY = $height - 60;
        
        // Add background for member text
        imagefilledrectangle($img, $memberX - 10, $memberY - 5, $memberX + $memberWidth + 10, $memberY + 15, $textBgColor);
        imagestring($img, $fontSize, $memberX, $memberY, $memberText, $textColor);
        
        // Bottom text with semi-transparent background
        $bottomText = "Africa Prosperity Network";
        $bottomWidth = imagefontwidth(3) * strlen($bottomText);
        $bottomX = ($width - $bottomWidth) / 2;
        $bottomY = $height - 25;
        
        // Add background for bottom text
        imagefilledrectangle($img, $bottomX - 5, $bottomY - 3, $bottomX + $bottomWidth + 5, $bottomY + 10, $textBgColor);
        imagestring($img, 3, $bottomX, $bottomY, $bottomText, $lightGray);
        
    } else {
        // For other badge types, keep the original colored backgrounds
        $colorSchemes = [
            'expired' => [
                'bg' => [239, 68, 68],
                'accent' => [255, 215, 0],
                'text' => [255, 255, 255],
                'badge_text' => 'EXPIRED'
            ],
            'cancelled' => [
                'bg' => [245, 158, 11],
                'accent' => [255, 215, 0],
                'text' => [255, 255, 255],
                'badge_text' => 'CANCELLED'
            ],
            'pending' => [
                'bg' => [59, 130, 246],
                'accent' => [255, 215, 0],
                'text' => [255, 255, 255],
                'badge_text' => 'PENDING'
            ],
            'not-found' => [
                'bg' => [107, 114, 128],
                'accent' => [255, 215, 0],
                'text' => [255, 255, 255],
                'badge_text' => 'NOT FOUND'
            ],
            'placeholder' => [
                'bg' => [156, 163, 175],
                'accent' => [255, 215, 0],
                'text' => [33, 33, 33],
                'badge_text' => 'APN'
            ],
        ];
        
        $scheme = $colorSchemes[$type];
        
        $bgColor = imagecolorallocate($img, $scheme['bg'][0], $scheme['bg'][1], $scheme['bg'][2]);
        $accentColor = imagecolorallocate($img, $scheme['accent'][0], $scheme['accent'][1], $scheme['accent'][2]);
        $textColor = imagecolorallocate($img, $scheme['text'][0], $scheme['text'][1], $scheme['text'][2]);
        
        imagefill($img, 0, 0, $bgColor);
        
        // Gradient effect
        for ($i = 0; $i < $height; $i++) {
            $darken = 20 * ($i / $height);
            $color = imagecolorallocate($img, 
                max(0, $scheme['bg'][0] - $darken),
                max(0, $scheme['bg'][1] - $darken),
                max(0, $scheme['bg'][2] - $darken)
            );
            imageline($img, 0, $i, $width, $i, $color);
        }
        
        // Borders
        imagerectangle($img, 5, 5, $width - 5, $height - 5, $accentColor);
        imagerectangle($img, 10, 10, $width - 10, $height - 10, $accentColor);
        
        // Corner decorations
        $circleRadius = 15;
        $circleColor = $accentColor;
        imagefilledellipse($img, 20, 20, $circleRadius, $circleRadius, $circleColor);
        imagefilledellipse($img, $width - 20, 20, $circleRadius, $circleRadius, $circleColor);
        imagefilledellipse($img, 20, $height - 20, $circleRadius, $circleRadius, $circleColor);
        imagefilledellipse($img, $width - 20, $height - 20, $circleRadius, $circleRadius, $circleColor);
        
        // APN Logo
        $apnText = "APN";
        $fontSize = 5;
        $apnWidth = imagefontwidth($fontSize) * strlen($apnText);
        $apnX = ($width - $apnWidth) / 2;
        $apnY = 30;
        imagestring($img, $fontSize, $apnX, $apnY, $apnText, $accentColor);
        
        // Main text
        $mainText = $scheme['badge_text'];
        $textWidth = imagefontwidth($fontSize) * strlen($mainText);
        $textX = ($width - $textWidth) / 2;
        $textY = $height - 90;
        imagestring($img, $fontSize, $textX, $textY, $mainText, $textColor);
        
        // Member text
        $memberText = "MEMBER";
        $memberWidth = imagefontwidth($fontSize) * strlen($memberText);
        $memberX = ($width - $memberWidth) / 2;
        $memberY = $height - 60;
        imagestring($img, $fontSize, $memberX, $memberY, $memberText, $textColor);
        
        // Bottom text
        $bottomText = "Africa Prosperity Network";
        $bottomWidth = imagefontwidth(3) * strlen($bottomText);
        $bottomX = ($width - $bottomWidth) / 2;
        $bottomY = $height - 25;
        $smallFont = imagecolorallocate($img, 255, 255, 255);
        imagestring($img, 3, $bottomX, $bottomY, $bottomText, $smallFont);
    }
    
    $directory = public_path('images/badges');
    $filepath = $directory . '/badge-' . $type . '.png';
    imagepng($img, $filepath);
    imagedestroy($img);
    
    return $filepath;
}
    
    /**
     * Get badge response without profile
     */
    private function getBadgeResponse($type)
    {
        $directory = public_path('images/badges');
        $filepath = $directory . '/badge-' . $type . '.png';
        
        if (!file_exists($filepath)) {
            $this->createBadgeImage($type);
        }
        
        $image = file_get_contents($filepath);
        
        return Response::make($image, 200, [
            'Content-Type' => 'image/png',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
    
    /**
     * Log badge view
     */
    private function logBadgeView($member, $referer = null, $type = 'image')
    {
        Log::info('Badge viewed', [
            'member_id' => $member->id,
            'type' => $type,
            'referer' => $referer,
        ]);
    }
    
    /**
     * Regenerate token
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
        
        return redirect()->route('member.badges')->with('success', 'Badge token regenerated successfully.');
    }
    
    /**
     * Widget
     */
    public function widget($token)
    {
        $member = Member::where('badge_token', $token)->first();
        return view('member.badge-widget', compact('member'));
    }
    
    /**
     * Track
     */
    public function track(Request $request, $token)
    {
        return response()->json(['success' => true]);
    }
    
    /**
     * Email signature
     */
    public function emailSignature()
    {
        $donor = Auth::guard('donor')->user();
        $member = Member::where('donor_id', $donor->id)->first();
        
        $badgeUrl = route('member.badge.image', ['token' => $member->badge_token]);
        $verifyUrl = route('member.badge.verify', ['token' => $member->badge_token]);
        $signatureHtml = $this->generateEmailSignatureHtml($donor, $badgeUrl, $verifyUrl);
        
        return view('member.email-signature', compact('signatureHtml'));
    }
    
    private function generateEmailSignatureHtml($donor, $badgeUrl, $verifyUrl)
    {
        return '<div style="font-family: Arial, sans-serif; max-width: 500px; padding: 15px; border-top: 2px solid #4f46e5;">
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td style="vertical-align: top; padding-right: 15px;">
                        <a href="' . $verifyUrl . '" target="_blank">
                            <img src="' . $badgeUrl . '" alt="APN Member" style="width: 80px; border: 0;">
                        </a>
                    </td>
                    <td style="vertical-align: top;">
                        <div style="font-weight: bold; color: #1f2937;">' . e($donor->firstname . ' ' . $donor->lastname) . '</div>
                        <div style="color: #6b7280; font-size: 12px;">Africa Prosperity Network Member</div>
                        <div style="color: #4f46e5; font-size: 11px; margin-top: 5px;">
                            <a href="' . $verifyUrl . '" style="color: #4f46e5; text-decoration: none;">Verify membership →</a>
                        </div>
                    </td>
                </tr>
            </table>
        </div>';
    }
    
    /**
     * Regenerate all badges 
     */
    public function regenerateAllBadges()
    {
        $badgeTypes = ['active', 'expired', 'cancelled', 'pending', 'not-found', 'placeholder'];
        $directory = public_path('images/badges');
        
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        
        foreach ($badgeTypes as $type) {
            $this->createBadgeImage($type);
            Log::info('Regenerated badge: ' . $type);
        }
        
        return response()->json(['message' => 'All badges regenerated successfully']);
    }
}