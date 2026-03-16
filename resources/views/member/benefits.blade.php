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
    
    /* Text size adjustments */
    .text-xs {
        font-size: 0.8rem !important;
    }
    .text-sm {
        font-size: 0.95rem !important;
    }
    .text-base {
        font-size: 1rem !important;
    }
    .text-lg {
        font-size: 1.125rem !important;
    }
    .text-xl {
        font-size: 1.3rem !important;
    }
    .text-2xl {
        font-size: 1.65rem !important;
    }
    .text-3xl {
        font-size: 2rem !important;
    }
    
    .breadcrumb-link {
        font-family: 'Open Sans', sans-serif;
        font-size: 0.95rem;
    }
    
    .badge-text {
        font-size: 0.75rem;
        letter-spacing: 0.02em;
    }
    
    .benefit-title {
        font-family: 'Urbanist', sans-serif;
        font-size: 1.15rem;
        font-weight: 600;
    }
    
    .benefit-description {
        font-size: 0.95rem;
        line-height: 1.6;
    }
    
    .plan-name {
        font-family: 'Urbanist', sans-serif;
        font-size: 1.75rem;
        font-weight: 700;
    }
    
    /* Responsive adjustments */
    @media (max-width: 640px) {
        body {
            font-size: 15px;
        }
        .text-xs {
            font-size: 0.75rem !important;
        }
        .text-sm {
            font-size: 0.875rem !important;
        }
        h1 {
            font-size: 1.75rem !important;
        }
        .plan-name {
            font-size: 1.5rem !important;
        }
    }
</style>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center text-sm text-gray-500 mb-2 breadcrumb-link">
                <a href="{{ route('member.dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700">Member Benefits</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Member Benefits</h1>
            <p class="text-gray-600 mt-2">Everything included in your {{ $member->plan_name }}</p>
        </div>

        <!-- Membership Tier Card - Matching Stats Cards Style -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-indigo-100 rounded-full">
                        <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center space-x-2 mb-1">
                            <span class="px-2 py-0.5 bg-indigo-100 text-indigo-700 rounded-full text-xs font-semibold tracking-wide badge-text">
                                CURRENT PLAN
                            </span>
                            @if($member->status == 'active')
                                <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold flex items-center badge-text">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1 animate-pulse"></span>
                                    ACTIVE
                                </span>
                            @endif
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 plan-name">{{ $member->plan_name }}</h2>
                        <p class="text-gray-600">${{ $member->price }}/{{ $member->membership_type }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Valid Until</p>
                    <p class="text-xl font-bold text-gray-900">{{ $member->end_date->format('M d, Y') }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $member->daysLeft() }} days remaining</p>
                </div>
            </div>
        </div>

        <!-- Benefits Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Full APN Access -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="bg-indigo-100 rounded-lg p-3 mr-4">
                        <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 benefit-title">Full APN Access</h3>
                </div>
                <p class="text-gray-600 benefit-description">Complete access to all APN programmes, events, and initiatives across the continent.</p>
            </div>

            <!-- Event Discounts -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="bg-green-100 rounded-lg p-3 mr-4">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 benefit-title">Event Discounts</h3>
                </div>
                <p class="text-gray-600 benefit-description">10% discount on all APN events, conferences, and merchandise. Priority registration included.</p>
            </div>

            <!-- Member Directory -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="bg-purple-100 rounded-lg p-3 mr-4">
                        <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 benefit-title">Member Directory</h3>
                </div>
                <p class="text-gray-600 benefit-description">Exclusive access to the APN member directory for networking and collaboration opportunities.</p>
            </div>

            <!-- APN Magazine -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="bg-yellow-100 rounded-lg p-3 mr-4">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 benefit-title">APN Magazine</h3>
                </div>
                <p class="text-gray-600 benefit-description">Digital access to the APN Magazine with exclusive content, interviews, and insights.</p>
            </div>

            <!-- Borderless Campaigns -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="bg-blue-100 rounded-lg p-3 mr-4">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 benefit-title">Borderless Campaigns</h3>
                </div>
                <p class="text-gray-600 benefit-description">Participate in borderless campaigns and initiatives driving Africa's economic integration.</p>
            </div>

            <!-- Awards Eligibility -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="bg-red-100 rounded-lg p-3 mr-4">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 benefit-title">Awards & Recognition</h3>
                </div>
                <p class="text-gray-600 benefit-description">Eligibility for APN awards and recognition programmes celebrating contributions to Africa's prosperity.</p>
            </div>
        </div>

        <!-- Annual Plan Bonus -->
        @if($member->membership_type == 'annual')
        <div class="mt-8 bg-gradient-to-r from-amber-500 to-yellow-500 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center">
                <div class="bg-white/20 rounded-lg p-3 mr-4">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-1">Annual Member Bonus</h3>
                    <p class="text-yellow-100">You're saving with 2 months free on your annual membership!</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection