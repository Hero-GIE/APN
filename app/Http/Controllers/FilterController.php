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
    public function applyFilter(Request $request)
    {
        Log::info('Filter apply method called', [
            'has_file'    => $request->hasFile('user_photo'),
            'filter_type' => $request->input('filter_type'),
        ]);

        $request->validate([
            'user_photo'  => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'filter_type' => 'required|in:ceremony,petition',
        ]);

        try {
            $user       = Auth::guard('donor')->user();
            $filterPath = public_path('images/filtered-image.png');

            if (!file_exists($filterPath)) {
                Log::error('Filter template not found at: ' . $filterPath);
                return response()->json([
                    'success' => false,
                    'message' => 'Filter template not found. Please contact support.',
                ], 404);
            }

            $fileName         = Str::random(20) . '.png';
            $filteredFileName = 'filtered_' . $fileName;
            $originalPath     = storage_path('app/public/filters/original');
            $filteredPath     = storage_path('app/public/filters/filtered');

            if (!file_exists($originalPath)) mkdir($originalPath, 0755, true);
            if (!file_exists($filteredPath)) mkdir($filteredPath, 0755, true);

            $request->file('user_photo')->storeAs('public/filters/original', $fileName);

            $filter       = Image::read($filterPath);
            $filterWidth  = $filter->width();
            $filterHeight = $filter->height();

            Log::info('Filter dimensions', ['w' => $filterWidth, 'h' => $filterHeight]);

            $userImage = Image::read($request->file('user_photo'));
            $origW     = $userImage->width();
            $origH     = $userImage->height();

            $scaleW = $filterWidth  / $origW;
            $scaleH = $filterHeight / $origH;
            $scale  = max($scaleW, $scaleH);

            $scaledW = (int) round($origW * $scale);
            $scaledH = (int) round($origH * $scale);

            $userImage->resize($scaledW, $scaledH);

            $cropX = (int) round(($scaledW - $filterWidth)  / 2);
            $cropY = (int) round(($scaledH - $filterHeight) / 2);
            $userImage->crop($filterWidth, $filterHeight, $cropX, $cropY);

            $userImage->place($filter, 'top-left', 0, 0);

            $savePath = storage_path("app/public/filters/filtered/{$filteredFileName}");
            $userImage->toPng()->save($savePath);

            Log::info('Saved filtered image', ['path' => $savePath]);

            $filteredImage = FilteredImage::create([
                'user_id'        => $user ? $user->id : null,
                'original_image' => "filters/original/{$fileName}",
                'filtered_image' => "filters/filtered/{$filteredFileName}",
                'filter_type'    => $request->filter_type,
            ]);

            $imageUrl   = url("storage/filters/filtered/{$filteredFileName}");
            $shareText  = $request->filter_type === 'ceremony'
                ? 'I attended the APN Ceremony! Join me in supporting Africa Prosperity Network.'
                : 'I signed the MABN Petition! Support Africa Prosperity Network.';

            $encodedText = urlencode($shareText);
            $encodedUrl  = urlencode($imageUrl);

            return response()->json([
                'success'   => true,
                'image_url' => $imageUrl,
                'image_id'  => $filteredImage->id,
                'message'   => 'Filter applied successfully!',
                'share_links' => [
                    'twitter'   => "https://twitter.com/intent/tweet?text={$encodedText}&url={$encodedUrl}",
                    'linkedin'  => "https://www.linkedin.com/sharing/share-offsite/?url={$encodedUrl}",
                    'facebook'  => "https://www.facebook.com/sharer/sharer.php?u={$encodedUrl}",
                    'whatsapp'  => "https://api.whatsapp.com/send?text={$encodedText}%20{$encodedUrl}",
                    'telegram'  => "https://t.me/share/url?url={$encodedUrl}&text={$encodedText}",
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Filter application error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error processing image: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getUserImages(Request $request)
    {
        try {
            $user = Auth::guard('donor')->user();

            if (!$user) {
                return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
            }

            $images = FilteredImage::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(fn($image) => [
                    'id'                   => $image->id,
                    'filtered_image_url'   => url("storage/{$image->filtered_image}"),
                    'original_image_url'   => url("storage/{$image->original_image}"),
                    'filter_type'          => $image->filter_type,
                    'created_at'           => $image->created_at->format('Y-m-d H:i:s'),
                    'created_at_formatted' => $image->created_at->diffForHumans(),
                ]);

            return response()->json(['success' => true, 'images' => $images]);

        } catch (\Exception $e) {
            Log::error('Get user images error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error retrieving images: ' . $e->getMessage()], 500);
        }
    }

    public function downloadImage($id)
    {
        try {
            $user  = Auth::guard('donor')->user();
            $image = FilteredImage::findOrFail($id);

            if ($user && ($image->user_id == $user->id || $user->is_admin)) {
                $path = storage_path("app/public/{$image->filtered_image}");

                if (!file_exists($path)) {
                    return response()->json(['success' => false, 'message' => 'Image file not found'], 404);
                }

                return response()->download($path, 'filtered-image.png', ['Content-Type' => 'image/png']);
            }

            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);

        } catch (\Exception $e) {
            Log::error('Download image error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error downloading image: ' . $e->getMessage()], 500);
        }
    }

    public function deleteImage($id)
    {
        try {
            $user  = Auth::guard('donor')->user();
            $image = FilteredImage::findOrFail($id);

            if ($user && ($image->user_id == $user->id || $user->is_admin)) {
                Storage::disk('public')->delete($image->original_image);
                Storage::disk('public')->delete($image->filtered_image);
                $image->delete();

                return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
            }

            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);

        } catch (\Exception $e) {
            Log::error('Delete image error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error deleting image: ' . $e->getMessage()], 500);
        }
    }

    public function getImage($id)
    {
        try {
            $user  = Auth::guard('donor')->user();
            $image = FilteredImage::findOrFail($id);

            if ($user && ($image->user_id == $user->id || $user->is_admin)) {
                return response()->json([
                    'success' => true,
                    'image'   => [
                        'id'                 => $image->id,
                        'filtered_image_url' => url("storage/{$image->filtered_image}"),
                        'original_image_url' => url("storage/{$image->original_image}"),
                        'filter_type'        => $image->filter_type,
                        'created_at'         => $image->created_at->format('Y-m-d H:i:s'),
                    ],
                ]);
            }

            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);

        } catch (\Exception $e) {
            Log::error('Get image error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error retrieving image: ' . $e->getMessage()], 500);
        }
    }

    public function getTemplatePreview()
    {
        try {
            $filterPath = public_path('images/filtered-image.png');

            if (!file_exists($filterPath)) {
                return response()->json(['success' => false, 'message' => 'Filter template not found'], 404);
            }

            return response()->file($filterPath);

        } catch (\Exception $e) {
            Log::error('Get template error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error retrieving template: ' . $e->getMessage()], 500);
        }
    }

    public function shareImage(Request $request, $id)
    {
        try {
            $user  = Auth::guard('donor')->user();
            $image = FilteredImage::findOrFail($id);

            if ($user && $image->user_id != $user->id) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            $imageUrl    = url("storage/{$image->filtered_image}");
            $encodedUrl  = urlencode($imageUrl);
            $shareText   = $image->filter_type == 'ceremony'
                ? 'I attended the APN Ceremony! Join me in supporting Africa Prosperity Network.'
                : 'I signed the MABN Petition! Support Africa Prosperity Network.';
            $encodedText = urlencode($shareText);

            return response()->json([
                'success'     => true,
                'share_links' => [
                    'twitter'  => "https://twitter.com/intent/tweet?text={$encodedText}&url={$encodedUrl}",
                    'linkedin' => "https://www.linkedin.com/sharing/share-offsite/?url={$encodedUrl}",
                    'facebook' => "https://www.facebook.com/sharer/sharer.php?u={$encodedUrl}",
                    'whatsapp' => "https://api.whatsapp.com/send?text={$encodedText}%20{$encodedUrl}",
                    'telegram' => "https://t.me/share/url?url={$encodedUrl}&text={$encodedText}",
                ],
                'image_url' => $imageUrl,
            ]);

        } catch (\Exception $e) {
            Log::error('Share image error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error generating share links: ' . $e->getMessage()], 500);
        }
    }
}