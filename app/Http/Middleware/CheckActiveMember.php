<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;

class CheckActiveMember
{
    public function handle(Request $request, Closure $next)
    {
        $donor = Auth::guard('donor')->user();
        
        if (!$donor) {
            return redirect()->route('donor.login');
        }

        $member = Member::where('donor_id', $donor->id)
                        ->where('status', 'active')
                        ->first();

        if (!$member) {
            return redirect()->route('donor.dashboard')
                ->with('error', 'This area is for active members only. Please purchase a membership to access member benefits.');
        }

        return $next($request);
    }
}