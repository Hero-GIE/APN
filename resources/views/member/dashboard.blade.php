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
    
    @keyframes pageReveal {
        from { opacity: 0; transform: scale(1.02); }
        to { opacity: 1; transform: scale(1); }
    }
    @keyframes patternMove {
        from { background-position: 0 0; }
        to { background-position: 200px 200px; }
    }
    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    .animate-page-reveal { animation: pageReveal 0.9s cubic-bezier(0.22,1,0.36,1) both; }
    .animate-pattern { animation: patternMove 60s linear infinite; }
    .animate-gradient { animation: gradientShift 5s ease infinite; background-size: 200% 200%; }

    .apn-scrollbar::-webkit-scrollbar { width: 6px; }
    .apn-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
    .apn-scrollbar::-webkit-scrollbar-thumb { background: #3b82f6; border-radius: 3px; }

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

    .membership-card {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .membership-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 28px -10px rgba(59,130,246,0.2);
    }
    .popular-badge {
        position: absolute;
        top: 12px; right: -30px;
        background: linear-gradient(135deg, #D4AF37, #B8860B);
        color: white;
        padding: 8px 40px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        transform: rotate(45deg);
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        z-index: 10;
    }
    .feature-list { list-style: none; padding: 0; margin: 0 0 1.5rem 0; }
    .feature-list li {
        display: flex; align-items: center; gap: 0.75rem;
        padding: 0.5rem 0;
        font-size: 0.95rem;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
    }
    .feature-list li:last-child { border-bottom: none; }
    .feature-list li i { color: #10b981; font-size: 0.9rem; width: 18px; text-align: center; }
    .price-tag { font-family: 'Urbanist', sans-serif; font-size: 2.2rem; font-weight: 800; color: #1e1b4b; line-height: 1.2; }
    .price-period { font-size: 0.95rem; color: #64748b; font-weight: 400; }

    /* Donation Modal Styles */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(4px);
        z-index: 50;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    .modal-container {
        background: white;
        border-radius: 24px;
        max-width: 500px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        transform: translateY(20px);
        transition: all 0.3s ease;
    }
    .active .modal-container {
        transform: translateY(0);
    }
    .donation-option {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem;
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: center;
        font-weight: 600;
        font-size: 1rem;
    }
    .donation-option:hover {
        border-color: #3b82f6;
        background: #f0f9ff;
    }
    .donation-option.selected {
        border-color: #3b82f6;
        background: #eff6ff;
    }

    .field-apn {
        width: 100%;
        padding: 0.8rem 0.8rem 0.8rem 2.8rem;
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 0.95rem;
        color: #1e293b;
        transition: all 0.2s ease;
        outline: none;
        font-family: 'Open Sans', sans-serif;
    }
    .field-apn:focus {
        border-color: #3b82f6;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
    }
    .field-wrap { position: relative; }
    .field-wrap i {
        position: absolute; left: 0.9rem; top: 50%; transform: translateY(-50%);
        color: #94a3b8; font-size: 0.9rem; pointer-events: none;
    }

    /* Table styles */
    table td, table th {
        font-size: 0.95rem;
    }
    
    th.text-xs.font-medium {
        font-size: 0.8rem !important;
        letter-spacing: 0.03em;
    }
    
    /* Status badges */
    .px-2.py-1.inline-flex.text-xs {
        font-size: 0.8rem !important;
        padding: 0.3rem 0.8rem !important;
    }
    
    /* Dropdown menu items */
    .dropdown-menu a, .dropdown-menu button,
    .absolute.w-48 a, .absolute.w-48 button {
        font-size: 0.95rem;
    }
    
    /* Banner text */
    .text-pink-800 .text-sm {
        font-size: 0.95rem;
    }
    
    /* Member Since, Renewal Date values */
    .text-base.font-semibold {
        font-size: 1.1rem;
    }
    
    /* Days Left value */
    .text-base.font-semibold small {
        font-size: 0.8rem;
    }
    
    /* Quick actions text */
    .space-y-3 .font-medium {
        font-size: 0.95rem;
    }
    
    /* Footer/security note */
    .text-\[0\.7rem\] {
        font-size: 0.8rem !important;
    }
    
    /* Benefit items */
    .benefit-text {
        font-size: 0.95rem;
    }
    .benefit-text small {
        font-size: 0.8rem;
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
    }
</style>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ $donor->firstname }}!</h1>
                <p class="text-gray-600 mt-2">Here's your membership overview and benefits.</p>
            </div>
            
            <div class="flex items-center space-x-3">

                <!-- User Dropdown Menu -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center">
                            <span class="text-indigo-600 font-semibold text-lg">
                                {{ strtoupper(substr($donor->firstname, 0, 1)) }}{{ strtoupper(substr($donor->lastname, 0, 1)) }}
                            </span>
                        </div>
                        <span class="text-gray-700 font-medium">{{ $donor->firstname }} {{ $donor->lastname }}</span>
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                        <a href="{{ route('member.profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Profile</a>
                        <a href="{{ route('member.benefits') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Member Benefits</a>
                        <a href="{{ route('member.payments') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Payment History</a>
                        <a href="{{ route('donor.dashboard') }}" class="block px-4 py-2 text-sm text-indigo-600 hover:bg-gray-100 font-medium">
                            Switch to Donor Dashboard
                        </a>
                        <a href="{{ route('member.support') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Help & Support</a>
                        <div class="border-t border-gray-100"></div>
                        <button @click="open = false; $dispatch('open-logout-modal')" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                            Logout
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Donation Banner -->
        <div class="mb-6 bg-gradient-to-r from-pink-50 to-rose-50 border border-pink-200 rounded-lg p-4 flex items-center justify-between">
            <div class="flex items-center">
                <div class="bg-pink-100 rounded-full p-2 mr-3">
                    <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-pink-800">
                        <span class="font-medium">Want to make an additional donation?</span> 
                        Your support helps us expand our impact across Africa.
                    </p>
                </div>
            </div>
            <button onclick="openDonationModal()" class="text-sm font-medium text-pink-600 hover:text-pink-800 hover:underline flex items-center">
                Donate Now
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>

        <div class="bg-white rounded-lg shadow p-8 mb-8">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <div class="flex items-center space-x-2 mb-4">
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-semibold tracking-wide">
                            {{ $member->plan_name }}
                        </span>
           
                        <span class="px-3 py-1 bg-{{ $statusConfig['color'] }}-100 text-{{ $statusConfig['color'] }}-700 rounded-full text-xs font-semibold flex items-center">
                            <span class="w-2 h-2 bg-{{ $statusConfig['color'] }}-500 rounded-full mr-1 {{ $statusConfig['pulse'] ? 'animate-pulse' : '' }}"></span>
                            {{ $statusConfig['text'] }}
                        </span>
                    </div>
                    
                    <h2 class="text-2xl font-bold text-gray-900 mb-1">
                        @if($member->status == 'active')
                            Member Benefits Active
                        @elseif($member->status == 'expired')
                            Membership Expired
                        @elseif($member->status == 'cancelled')
                            Membership Cancelled
                        @elseif($member->status == 'pending')
                            Membership Pending
                        @endif
                    </h2>
                    
                    <p class="text-gray-600 text-sm mb-6">
                        @if($member->status == 'active')
                            Your membership gives you access to exclusive APN benefits
                        @elseif($member->status == 'expired')
                            Your membership has expired. Renew to continue enjoying benefits.
                        @elseif($member->status == 'cancelled')
                            Your membership has been cancelled. You can rejoin anytime.
                        @elseif($member->status == 'pending')
                            Your membership is being processed. This may take 24-48 hours.
                        @endif
                    </p>
                    
                    <div class="grid grid-cols-4 gap-6">
                        <div>
                            <p class="text-gray-500 text-xs">Member Since</p>
                            <p class="text-base font-semibold text-gray-900">{{ $member->start_date->format('M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs">Renewal Date</p>
                            <p class="text-base font-semibold text-gray-900">
                                @if($member->end_date)
                                    {{ $member->end_date->format('M d, Y') }}
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs">Days Left</p>
                            <p class="text-base font-semibold text-gray-900">
                                @if($member->status == 'active')
                                    {{ $member->daysLeft() }} days
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs">Auto-Renew</p>
                            <p class="text-base font-semibold text-gray-900">{{ $member->renewal_count > 0 ? 'Yes' : 'No' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="ml-6 flex-shrink-0">
                    <div class="flex items-center">
                        <div class="p-3 bg-indigo-100 rounded-full">
                            <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-gray-500 text-xs">Membership</p>
                            <p class="text-xl font-bold text-gray-900">${{ $member->price }}</p>
                            <p class="text-xs text-gray-500">per {{ $member->membership_type }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-indigo-100 rounded-full">
                        <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Member ID</p>
                        <p class="text-lg font-semibold text-gray-900">#{{ $member->id }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Total Payments</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $payments->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-full">
                        <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Total Spent</p>
                        <p class="text-lg font-semibold text-gray-900">${{ number_format($payments->sum('amount'), 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Renewals</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $member->renewal_count }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Member Benefits Card -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-800">Your Member Benefits</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-start space-x-3">
                            <div class="bg-green-100 rounded-lg p-2">
                                <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Event Discounts</p>
                                <p class="text-sm text-gray-500">10% off all APN events</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <div class="bg-green-100 rounded-lg p-2">
                                <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Priority Registration</p>
                                <p class="text-sm text-gray-500">Early access to events</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <div class="bg-green-100 rounded-lg p-2">
                                <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Member Directory</p>
                                <p class="text-sm text-gray-500">Exclusive networking</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <div class="bg-green-100 rounded-lg p-2">
                                <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">APN Magazine</p>
                                <p class="text-sm text-gray-500">Digital access included</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <div class="bg-green-100 rounded-lg p-2">
                                <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Borderless Campaigns</p>
                                <p class="text-sm text-gray-500">Participate in initiatives</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <div class="bg-green-100 rounded-lg p-2">
                                <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Awards Eligibility</p>
                                <p class="text-sm text-gray-500">Recognition opportunities</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                <div class="space-y-3">
              
<a href="{{ route('member.about') }}" class="flex items-center justify-between p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
    <div class="flex items-center">
        <div class="bg-purple-100 rounded-lg p-2 mr-3">
            <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <span class="font-medium text-gray-700">About Us</span>
    </div>
    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
    </svg>
</a>
                    <a href="{{ route('member.benefits') }}" class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex items-center">
                            <div class="bg-indigo-100 rounded-lg p-2 mr-3">
                                <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                </svg>
                            </div>
                            <span class="font-medium text-gray-700">View All Benefits</span>
                        </div>
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>

                    <a href="{{ route('member.payments') }}" class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex items-center">
                            <div class="bg-green-100 rounded-lg p-2 mr-3">
                                <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                            </div>
                            <span class="font-medium text-gray-700">Payment History</span>
                        </div>
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>

                    <a href="{{ route('member.profile.edit') }}" class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex items-center">
                            <div class="bg-purple-100 rounded-lg p-2 mr-3">
                                <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <span class="font-medium text-gray-700">Update Profile</span>
                        </div>
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>

                    @if($member->status == 'active')
                    <form action="{{ route('member.cancel') }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel your membership? This action cannot be undone.')">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-between p-3 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                            <div class="flex items-center">
                                <div class="bg-red-100 rounded-lg p-2 mr-3">
                                    <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </div>
                                <span class="font-medium text-red-700">Cancel Membership</span>
                            </div>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Payments Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800">Recent Membership Payments</h2>
                <a href="{{ route('member.payments') }}" class="text-sm text-indigo-600 hover:text-indigo-900">View All →</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Period</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Receipt</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($payments as $payment)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $payment->payment_date->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                {{ substr($payment->donation->transaction_id, 0, 8) }}...
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                ${{ number_format($payment->amount, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $payment->period_start->format('M d') }} - {{ $payment->period_end->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Paid
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <button onclick="downloadReceipt('{{ $payment->donation->transaction_id }}', {{ $payment->amount }}, '{{ $payment->payment_date }}', 'card')" 
                                        class="text-indigo-600 hover:text-indigo-900 font-medium">
                                    Download
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">
                                No payment records found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Donation History -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800">Your Donation History</h2>
                <a href="{{ route('member.transactions') }}" class="text-sm text-indigo-600 hover:text-indigo-900">View All Donations →</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Receipt</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($donations as $donation)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $donation->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                {{ substr($donation->transaction_id, 0, 8) }}...
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                ${{ number_format($donation->amount, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ ucfirst($donation->payment_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <button onclick="downloadReceipt('{{ $donation->transaction_id }}', {{ $donation->amount }}, '{{ $donation->created_at }}', '{{ $donation->payment_method ?? 'Card' }}')" 
                                        class="text-indigo-600 hover:text-indigo-900 font-medium">
                                    Download
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">
                                No donations found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- DONATION MODAL --}}
<div id="donationModal" class="modal-overlay">
    <div class="modal-container p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-urbanist text-xl font-bold text-gray-900">Make a Donation now</h3>
            <button onclick="closeDonationModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <div id="modalErrorContainer"></div>

        {{-- Quick amount options --}}
        <div class="grid grid-cols-3 gap-3 mb-6">
            <button onclick="setDonationAmount(10)" class="donation-option">$10</button>
            <button onclick="setDonationAmount(25)" class="donation-option">$25</button>
            <button onclick="setDonationAmount(50)" class="donation-option">$50</button>
            <button onclick="setDonationAmount(100)" class="donation-option">$100</button>
            <button onclick="setDonationAmount(250)" class="donation-option">$250</button>
            <button onclick="setDonationAmount(500)" class="donation-option">$500</button>
        </div>

        {{-- Custom amount --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Or enter custom amount</label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-semibold">$</span>
                <input type="number" id="donationAmount" min="1" step="1" 
                       class="w-full pl-8 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:outline-none"
                       placeholder="Enter amount">
            </div>
        </div>

        <div class="bg-blue-50 p-4 rounded-xl mb-6">
            <p class="text-sm text-blue-800 flex items-start gap-2">
                <i class="fas fa-info-circle mt-0.5"></i>
                <span>Your donation helps us continue our mission of building Africa's prosperity through economic integration and development programs.</span>
            </p>
        </div>

        <div class="flex gap-3">
            <button onclick="processDonation()" 
                    class="flex-1 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-urbanist font-bold hover:from-blue-700 hover:to-indigo-700 transition-all duration-300">
                Complete Donation
            </button>
            <button onclick="closeDonationModal()" 
                    class="flex-1 py-3 bg-gray-100 text-gray-700 rounded-xl font-urbanist font-bold hover:bg-gray-200 transition-all duration-300">
                Cancel
            </button>
        </div>
    </div>
</div>

<!-- Logout Modal -->
<div x-data="{ showLogoutModal: false, isLoggingOut: false }" 
     @open-logout-modal.window="showLogoutModal = true"
     x-cloak>
    <div x-show="showLogoutModal" 
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">
        
        <div class="flex items-center justify-center min-h-screen px-4">
            <div x-show="showLogoutModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-black/40 backdrop-blur-sm"
                 @click="showLogoutModal = false">
            </div>
            <div x-show="showLogoutModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="relative bg-white rounded-2xl max-w-md w-full mx-auto shadow-2xl transform transition-all border border-gray-100">
                <div class="p-8 pt-10">
                    <div class="flex justify-center mb-4">
                        <div class="bg-gradient-to-br from-red-50 to-orange-50 rounded-2xl p-4">
                            <svg class="h-12 w-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </div>
                    </div>
                
                    <h3 class="text-xl font-bold text-center text-gray-900 mb-2">
                        Ready to logout?
                    </h3>
                    
                    <p class="text-gray-500 text-center mb-6 text-sm">
                        We'll miss you!<br>
                        Come back soon to see what's new.
                    </p>
                    
                    <div class="flex gap-3">
                        <button @click="showLogoutModal = false" 
                                :disabled="isLoggingOut"
                                class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all font-medium text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                            Cancel
                        </button>
                        
                        <form method="POST" action="{{ route('donor.logout') }}" 
                              @submit="isLoggingOut = true"
                              class="flex-1">
                            @csrf
                            <button type="submit" 
                                    :disabled="isLoggingOut"
                                    class="w-full px-4 py-2.5 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-all font-medium text-sm shadow-md disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                                <template x-if="!isLoggingOut">
                                    <span>Logout</span>
                                </template>
                                <template x-if="isLoggingOut">
                                    <span class="flex items-center gap-2">
                                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Logging out...
                                    </span>
                                </template>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
    
    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(4px);
        z-index: 50;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    .modal-container {
        background: white;
        border-radius: 24px;
        max-width: 500px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        transform: translateY(20px);
        transition: all 0.3s ease;
    }
    .active .modal-container {
        transform: translateY(0);
    }
    .donation-option {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem;
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: center;
        font-weight: 600;
    }
    .donation-option:hover {
        border-color: #3b82f6;
        background: #f0f9ff;
    }
    .donation-option.selected {
        border-color: #3b82f6;
        background: #eff6ff;
    }
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin {
        animation: spin 1s linear infinite;
    }
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    let selectedDonationAmount = 0;

    // Donation modal functions
    function openDonationModal() {
        document.getElementById('donationModal').classList.add('active');
        document.body.style.overflow = 'hidden';
        clearModalError();
    }

    function closeDonationModal() {
        document.getElementById('donationModal').classList.remove('active');
        document.body.style.overflow = '';
        document.querySelectorAll('.donation-option').forEach(opt => opt.classList.remove('selected'));
        document.getElementById('donationAmount').value = '';
        selectedDonationAmount = 0;
        clearModalError();
    }

    function clearModalError() {
        const container = document.getElementById('modalErrorContainer');
        if (container) container.innerHTML = '';
    }

    function showModalError(message) {
        const errorHtml = `
            <div class="bg-red-50 border-2 border-red-200 rounded-xl p-4 mb-4 flex items-center gap-3 text-red-600 text-sm">
                <i class="fas fa-exclamation-circle"></i>
                <span>${message}</span>
                <button onclick="this.parentElement.remove()" class="ml-auto hover:opacity-70">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        document.getElementById('modalErrorContainer').innerHTML = errorHtml;
    }

    function setDonationAmount(amount) {
        document.querySelectorAll('.donation-option').forEach(opt => opt.classList.remove('selected'));
        event.target.classList.add('selected');
        document.getElementById('donationAmount').value = amount;
        selectedDonationAmount = amount;
        clearModalError();
    }

    async function processDonation() {
        clearModalError();
        
        const amount = document.getElementById('donationAmount').value;
        if (!amount || amount < 1) {
            showModalError('Please enter a valid donation amount');
            return;
        }

        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';

        try {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            
            if (!token) {
                throw new Error('Security token not found. Please refresh the page.');
            }

            const response = await fetch('{{ route("donation.initialize") }}', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    amount: amount,
                    membership_type: 'donation'
                })
            });
            
            const contentType = response.headers.get('content-type');
            
            if (!response.ok) {
                if (contentType && contentType.includes('application/json')) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || `Server error: ${response.status}`);
                } else {
                    const errorText = await response.text();
                    console.error('HTML error response:', errorText.substring(0, 200));
                    
                    if (errorText.includes('login') || response.url.includes('login')) {
                        throw new Error('Your session has expired. Please refresh the page and login again.');
                    }
                    
                    throw new Error(`Server error (${response.status}). Please try again.`);
                }
            }
            
            if (!contentType || !contentType.includes('application/json')) {
                const text = await response.text();
                console.error('Non-JSON response:', text.substring(0, 200));
                throw new Error('Invalid response from server. Please try again.');
            }
            
            const data = await response.json();
            
            if (data.status === true && data.data?.authorization_url) {
                window.location.href = data.data.authorization_url;
            } else {
                throw new Error(data.message || 'Failed to process donation');
            }
            
        } catch (error) {
            console.error('Donation error:', error);
            btn.disabled = false;
            btn.innerHTML = originalText;
            showModalError(error.message || 'Failed to process donation. Please try again.');
        }
    }

    // Close modal when clicking outside
    document.getElementById('donationModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeDonationModal();
        }
    });

    // Download receipt function
    function downloadReceipt(transactionId, amount, date, paymentMethod) {
        const button = event.target;
        const originalText = button.textContent;
        button.innerHTML = '<svg class="animate-spin h-4 w-4 mr-2 inline" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Generating...';
        button.disabled = true;

        setTimeout(() => {
            const receiptDate = new Date(date);
            const formattedDate = receiptDate.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });

            const receiptHTML = `
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Payment Receipt</title>
                    <style>
                        body { font-family: 'Inter', sans-serif; max-width: 600px; margin: 0 auto; padding: 30px; background: #f9fafb; }
                        .receipt-container { background: white; border-radius: 12px; padding: 30px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
                        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #e5e7eb; padding-bottom: 20px; }
                        .logo { font-size: 24px; font-weight: bold; color: #4f46e5; }
                        .receipt-title { font-size: 20px; margin-top: 10px; color: #1f2937; }
                        .details { margin: 20px 0; }
                        .row { display: flex; justify-content: space-between; margin-bottom: 12px; padding: 8px 0; border-bottom: 1px dashed #e5e7eb; }
                        .label { font-weight: 600; color: #4b5563; }
                        .value { color: #1f2937; }
                        .amount { font-size: 24px; font-weight: bold; color: #059669; text-align: center; margin: 20px 0; }
                        .footer { margin-top: 30px; text-align: center; color: #6b7280; font-size: 14px; border-top: 2px solid #e5e7eb; padding-top: 20px; }
                        .thank-you { font-size: 18px; color: #4f46e5; margin-bottom: 10px; }
                    </style>
                </head>
                <body>
                    <div class="receipt-container">
                        <div class="header">
                            <div class="logo">Africa Prosperity Network</div>
                            <div class="receipt-title">Payment Receipt</div>
                        </div>
                        
                        <div class="amount">$${parseFloat(amount).toFixed(2)}</div>
                        
                        <div class="details">
                            <div class="row"><span class="label">Transaction ID:</span><span class="value">${transactionId}</span></div>
                            <div class="row"><span class="label">Date:</span><span class="value">${formattedDate}</span></div>
                            <div class="row"><span class="label">Donor Name:</span><span class="value">{{ $donor->firstname }} {{ $donor->lastname }}</span></div>
                            <div class="row"><span class="label">Donor Email:</span><span class="value">{{ $donor->email }}</span></div>
                            <div class="row"><span class="label">Payment Method:</span><span class="value">${paymentMethod.charAt(0).toUpperCase() + paymentMethod.slice(1)}</span></div>
                            <div class="row"><span class="label">Status:</span><span class="value" style="color: #059669;">Success</span></div>
                        </div>
                        
                        <div class="footer">
                            <div class="thank-you">Thank you for your support!</div>
                            <p>This is a computer-generated receipt. No signature required.</p>
                        </div>
                    </div>
                </body>
                </html>
            `;

            const blob = new Blob([receiptHTML], { type: 'text/html' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `receipt-${transactionId}.html`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);

            button.innerHTML = originalText;
            button.disabled = false;
        }, 1000);
    }
</script>
@endpush
@endsection