@extends('layouts.guest')

@section('content')
<style>
    body {
        font-family: 'Open Sans', sans-serif;
        font-size: 16px;
        line-height: 1.6;
    }
    h1, h2, h3, h4, h5, h6, .heading-font, .font-urbanist, .btn, button, [class*="font-bold"] {
        font-family: 'Urbanist', sans-serif;
    }
    
    .verification-card {
        max-width: 500px;
        margin: 0 auto;
        background: white;
        border-radius: 16px;
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
        overflow: hidden;
    }
    
    .verification-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px 20px;
        text-align: center;
    }
    
    .verification-content {
        padding: 30px 20px;
    }
    
    .valid-badge {
        background: #10b981;
        color: white;
        padding: 8px 16px;
        border-radius: 9999px;
        display: inline-block;
        font-size: 14px;
        font-weight: 600;
    }
    
    .invalid-badge {
        background: #ef4444;
        color: white;
        padding: 8px 16px;
        border-radius: 9999px;
        display: inline-block;
        font-size: 14px;
        font-weight: 600;
    }
    
    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .detail-label {
        color: #64748b;
        font-size: 14px;
    }
    
    .detail-value {
        font-weight: 600;
        color: #1e293b;
    }
</style>

<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="verification-card">
            <div class="verification-header">
                <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                <h1 class="text-2xl font-bold">Membership Verification</h1>
            </div>
            
            <div class="verification-content">
                @if(!$valid || !$member)
                    <div class="text-center mb-6">
                        <span class="invalid-badge">✗ Invalid Membership</span>
                    </div>
                    
                    <div class="text-center text-gray-600 mb-6">
                        <p class="mb-2">This membership badge could not be verified.</p>
                        <p class="text-sm">The badge may be for a member who has expired, cancelled, or the link may be incorrect.</p>
                    </div>
                    
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-sm text-yellow-800">
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <span>
                                <strong>Note:</strong> If you are the badge owner and believe this is an error, 
                                please contact support@africaprosperitynetwork.com
                            </span>
                        </div>
                    </div>
                @else
                    <div class="text-center mb-6">
                        <span class="valid-badge">✓ Verified Member</span>
                    </div>
                    
                    <div class="text-center mb-8">
                        <img src="{{ route('member.badge.image', ['token' => $member->badge_token]) }}" 
                             alt="Member Badge" 
                             class="w-24 h-24 mx-auto mb-3">
                        <h2 class="text-xl font-bold text-gray-900">{{ $donor->firstname }} {{ $donor->lastname }}</h2>
                        <p class="text-gray-500">{{ $donor->email }}</p>
                    </div>
                    
                    <div class="space-y-2">
                        <div class="detail-row">
                            <span class="detail-label">Membership Type</span>
                            <span class="detail-value">{{ ucfirst($member->membership_type) }}</span>
                        </div>
                        
                        <div class="detail-row">
                            <span class="detail-label">Member Since</span>
                            <span class="detail-value">{{ $member->start_date->format('F j, Y') }}</span>
                        </div>
                        
                        <div class="detail-row">
                            <span class="detail-label">Valid Until</span>
                            <span class="detail-value">{{ $member->end_date->format('F j, Y') }}</span>
                        </div>
                        
                        <div class="detail-row">
                            <span class="detail-label">Status</span>
                            <span class="detail-value">
                                <span class="text-green-600 font-semibold">● Active</span>
                            </span>
                        </div>
                        
                        <div class="detail-row">
                            <span class="detail-label">Verification ID</span>
                            <span class="detail-value text-xs font-mono">{{ substr($member->badge_token, 0, 16) }}...</span>
                        </div>
                    </div>
                    
                    <div class="mt-8 text-center text-sm text-gray-500">
                        <p>This verification confirms that the above individual is a current member of Africa Prosperity Network.</p>
                    </div>
                @endif
                
                <div class="mt-8 text-center">
                    <a href="{{ url('/') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                        ← Return to APN Homepage
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection