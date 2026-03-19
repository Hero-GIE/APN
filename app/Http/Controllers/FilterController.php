<?php

namespace App\Http\Controllers;

use App\Models\FilteredImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class FilterController extends Controller
{
    /**
     * Apply filter to uploaded image
     */

    public function applyFilter(Request $request)
    {
        // Log the request for debugging
        Log::info('Filter apply method called', [
            'has_file' => $request->hasFile('user_photo'),
            'filter_type' => $request->input('filter_type'),
            'all_inputs' => $request->all()
        ]);

        $request->validate([
            'user_photo' => 'required|image|mimes:jpeg,png,jpg|max:5120', 
            'filter_type' => 'required|in:ceremony,petition'
        ]);

        try {
            $user = Auth::guard('donor')->user();
            
            // Path to your customized filter image
            $filterPath = public_path('images/filtered-image.jpeg');
            
            if (!file_exists($filterPath)) {
                Log::error('Filter template not found at: ' . $filterPath);
                return response()->json([
                    'success' => false,
                    'message' => 'Filter template not found. Please contact support.'
                ], 404);
            }

            // Upload and process user photo
            $userPhoto = $request->file('user_photo');
            $fileName = Str::random(20) . '.png';
            $filteredFileName = 'filtered_' . $fileName;
            
            // Create upload directories if they don't exist
            $originalPath = storage_path('app/public/filters/original');
            $filteredPath = storage_path('app/public/filters/filtered');
            
            if (!file_exists($originalPath)) {
                mkdir($originalPath, 0755, true);
            }
            if (!file_exists($filteredPath)) {
                mkdir($filteredPath, 0755, true);
            }

            // Save original image
            $userPhoto->storeAs('public/filters/original', $fileName);
            
            // Read images using Intervention v3
            $filter = Image::read($filterPath);
            $userImage = Image::read($userPhoto);
            
            // Get filter dimensions
            $filterWidth = $filter->width();
            $filterHeight = $filter->height();
            
            Log::info('Filter dimensions', ['width' => $filterWidth, 'height' => $filterHeight]);
            
            // Resize user image (60% of filter width)
            $photoWidth = intval($filterWidth * 0.6);
            $userImage->resize($photoWidth, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            Log::info('User image dimensions after resize', [
                'width' => $userImage->width(), 
                'height' => $userImage->height()
            ]);
            
            // Calculate position to center the user photo
            $x = intval(($filterWidth - $userImage->width()) / 2);
            $y = intval($filterHeight * 0.25); // Position at 25% from top
            
            Log::info('Position', ['x' => $x, 'y' => $y]);
            
            // FIXED: Create a new image with filter dimensions - v3 syntax
            // Method 1: Create a transparent canvas correctly
            $canvas = Image::create($filterWidth, $filterHeight);
            
            // Fill with transparent background (v3 syntax)
            $canvas->fill('rgba(255, 255, 255, 0)'); // Transparent
            
            // Place user image on canvas
            $canvas->place($userImage, 'top-left', $x, $y);
            
            // Place filter on top (with transparency)
            // Create a copy of the filter to work with
            $filterCopy = Image::read($filterPath);
            
            // Composite the images - filter on top of canvas
            $filterCopy->place($canvas, 'top-left', 0, 0);
            
            // Save the result
            $filterCopy->save(storage_path("app/public/filters/filtered/{$filteredFileName}"));
            
            // Save to database
            $filteredImage = FilteredImage::create([
                'user_id' => $user ? $user->id : null,
                'original_image' => "filters/original/{$fileName}",
                'filtered_image' => "filters/filtered/{$filteredFileName}",
                'filter_type' => $request->filter_type
            ]);
            
            Log::info('Filter applied successfully', [
                'image_id' => $filteredImage->id,
                'filtered_image' => $filteredFileName
            ]);
            
            return response()->json([
                'success' => true,
                'image_url' => asset("storage/filters/filtered/{$filteredFileName}"),
                'image_id' => $filteredImage->id,
                'message' => 'Filter applied successfully!'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Filter application error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error processing image: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Get user's filtered images
     */
    public function getUserImages(Request $request)
    {
        try {
            $user = Auth::guard('donor')->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }
            
            $images = FilteredImage::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($image) {
                    return [
                        'id' => $image->id,
                        'filtered_image_url' => asset("storage/{$image->filtered_image}"),
                        'original_image_url' => asset("storage/{$image->original_image}"),
                        'filter_type' => $image->filter_type,
                        'created_at' => $image->created_at->format('Y-m-d H:i:s'),
                        'created_at_formatted' => $image->created_at->diffForHumans()
                    ];
                });
            
            return response()->json([
                'success' => true,
                'images' => $images
            ]);
            
        } catch (\Exception $e) {
            Log::error('Get user images error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving images: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download filtered image
     */
    public function downloadImage($id)
    {
        try {
            $user = Auth::guard('donor')->user();
            
            $image = FilteredImage::findOrFail($id);
            
            // Check if user owns this image or is admin
            if ($user && ($image->user_id == $user->id || $user->is_admin)) {
                $path = storage_path("app/public/{$image->filtered_image}");
                
                if (!file_exists($path)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Image file not found'
                    ], 404);
                }
                
                return response()->download($path, 'filtered-image.png', [
                    'Content-Type' => 'image/png'
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
            
        } catch (\Exception $e) {
            Log::error('Download image error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error downloading image: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete filtered image
     */
    public function deleteImage($id)
    {
        try {
            $user = Auth::guard('donor')->user();
            
            $image = FilteredImage::findOrFail($id);
            
            // Check if user owns this image or is admin
            if ($user && ($image->user_id == $user->id || $user->is_admin)) {
                // Delete files from storage
                Storage::disk('public')->delete($image->original_image);
                Storage::disk('public')->delete($image->filtered_image);
                
                // Delete database record
                $image->delete();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Image deleted successfully'
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
            
        } catch (\Exception $e) {
            Log::error('Delete image error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error deleting image: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get single filtered image
     */
    public function getImage($id)
    {
        try {
            $user = Auth::guard('donor')->user();
            
            $image = FilteredImage::findOrFail($id);
            
            // Check if user owns this image or is admin
            if ($user && ($image->user_id == $user->id || $user->is_admin)) {
                return response()->json([
                    'success' => true,
                    'image' => [
                        'id' => $image->id,
                        'filtered_image_url' => asset("storage/{$image->filtered_image}"),
                        'original_image_url' => asset("storage/{$image->original_image}"),
                        'filter_type' => $image->filter_type,
                        'created_at' => $image->created_at->format('Y-m-d H:i:s')
                    ]
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
            
        } catch (\Exception $e) {
            Log::error('Get image error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving image: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get filter template preview
     */
    public function getTemplatePreview()
    {
        try {
            $filterPath = public_path('images/filtered-image.jpeg');
            
            if (!file_exists($filterPath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Filter template not found'
                ], 404);
            }
            
            return response()->file($filterPath);
            
        } catch (\Exception $e) {
            Log::error('Get template error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving template: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Share filtered image on social media (generate share links)
     */
    public function shareImage(Request $request, $id)
    {
        try {
            $user = Auth::guard('donor')->user();
            
            $image = FilteredImage::findOrFail($id);
            
            // Check if user owns this image
            if ($user && $image->user_id != $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }
            
            $imageUrl = asset("storage/{$image->filtered_image}");
            $encodedUrl = urlencode($imageUrl);
            
            $shareText = $image->filter_type == 'ceremony' 
                ? 'I attended the APN Ceremony! Join me in supporting Africa Prosperity Network.' 
                : 'I signed the MABN Petition! Support Africa Prosperity Network.';
            
            $encodedText = urlencode($shareText);
            
            $shareLinks = [
                'twitter' => "https://twitter.com/intent/tweet?text={$encodedText}&url={$encodedUrl}",
                'linkedin' => "https://www.linkedin.com/sharing/share-offsite/?url={$encodedUrl}",
                'facebook' => "https://www.facebook.com/sharer/sharer.php?u={$encodedUrl}",
                'whatsapp' => "https://api.whatsapp.com/send?text={$encodedText}%20{$encodedUrl}",
                'telegram' => "https://t.me/share/url?url={$encodedUrl}&text={$encodedText}"
            ];
            
            return response()->json([
                'success' => true,
                'share_links' => $shareLinks,
                'image_url' => $imageUrl
            ]);
            
        } catch (\Exception $e) {
            Log::error('Share image error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error generating share links: ' . $e->getMessage()
            ], 500);
        }
    }
}