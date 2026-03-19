<?php
// app/Http/Controllers/MagazineController.php

namespace App\Http\Controllers;

use App\Models\Magazine;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MagazineController extends Controller
{
    /**
     * Get all publications for members
     */
    public function getMemberPublications()
    {
        $donor = Auth::guard('donor')->user();
        
        if (!$donor) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $member = Member::where('donor_id', $donor->id)
            ->where('status', 'active')
            ->first();
        
        if (!$member) {
            return response()->json(['error' => 'Membership required'], 403);
        }
        
        $publications = Magazine::where('is_active', true)
            ->get()
            ->groupBy('type');
        
        return response()->json([
            'success' => true,
            'publications' => $publications
        ]);
    }

    /**
     * Download a file
     */
 public function download($id)
{
    $donor = Auth::guard('donor')->user();
    
    if (!$donor) {
        return redirect()->route('donor.login')
            ->with('error', 'Please log in to download.');
    }
    
    $member = Member::where('donor_id', $donor->id)
        ->where('status', 'active')
        ->first();
    
    if (!$member) {
        return redirect()->back()
            ->with('error', 'This content is for active members only.');
    }
    
    $publication = Magazine::where('id', $id)
        ->where('is_active', true)
        ->firstOrFail();
    
    $fullPath = storage_path('app/public/' . $publication->file_path);
    
    if (!file_exists($fullPath)) {
        return redirect()->back()->with('error', 'File not found.');
    }
    
    // Set headers for PDF download
    $headers = [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'attachment; filename="' . basename($publication->file_path) . '"',
        'Content-Length' => filesize($fullPath),
        'Content-Transfer-Encoding' => 'binary',
        'Accept-Ranges' => 'bytes',
        'Cache-Control' => 'private, no-transform, no-store, must-revalidate',
        'Pragma' => 'no-cache',
    ];
    
    return response()->stream(function() use ($fullPath) {
        $stream = fopen($fullPath, 'rb');
        fpassthru($stream);
        if (is_resource($stream)) {
            fclose($stream);
        }
    }, 200, $headers);
}
}