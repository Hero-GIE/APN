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
    
    .stat-card p {
        font-size: 0.8rem;
    }
    
    .stat-card .font-semibold {
        font-size: 1rem;
    }
    
    .info-label {
        font-size: 0.8rem;
        letter-spacing: 0.02em;
    }
    
    .info-value {
        font-size: 1rem;
    }
    
    .section-title {
        font-family: 'Urbanist', sans-serif;
        font-size: 1.2rem;
        font-weight: 600;
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
        <!-- Header with breadcrumb (matching edit page) -->
        <div class="mb-8">
            <div class="flex items-center text-sm text-gray-500 mb-2 breadcrumb-link">
                <a href="{{ route('member.dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700">My Profile</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
            <p class="text-gray-600 mt-2">View and manage your personal information.</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative">
                {{ session('success') }}
            </div>
        @endif

        <!-- Profile Content - Matching edit page style -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <!-- Profile Header - Simple like edit page (no gradient) -->
            <div class="px-6 py-6 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center shadow-sm">
                        <span class="text-indigo-600 font-bold text-2xl">
                            {{ strtoupper(substr($donor->firstname, 0, 1)) }}{{ strtoupper(substr($donor->lastname, 0, 1)) }}
                        </span>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-semibold text-gray-800">{{ $donor->firstname }} {{ $donor->lastname }}</h2>
                        <p class="text-gray-500 text-sm">{{ $donor->email }}</p>
                        <p class="text-gray-400 text-xs mt-1">Member since {{ $donor->created_at->format('F Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Stats Cards Row (Matching edit page) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-6 bg-gray-50 border-b border-gray-200">
                <div class="bg-white rounded-lg shadow-sm p-4 hover:shadow-md transition-shadow stat-card">
                    <div class="flex items-center">
                        <div class="p-2 bg-indigo-100 rounded-full">
                            <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-xs text-gray-500">Full Name</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $donor->firstname }} {{ $donor->lastname }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-4 hover:shadow-md transition-shadow stat-card">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 rounded-full">
                            <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-xs text-gray-500">Email</p>
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $donor->email }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-4 hover:shadow-md transition-shadow stat-card">
                    <div class="flex items-center">
                        <div class="p-2 bg-purple-100 rounded-full">
                            <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-xs text-gray-500">Phone</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $donor->phone ?? 'Not provided' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Information Sections -->
            <div class="p-6">
                <!-- Header with Edit Button (matching edit page) -->
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 section-title">Personal Information</h3>
                    <a href="{{ route('member.profile.edit') }}" 
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                        Edit Profile
                    </a>
                </div>

                <!-- Personal Information Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                        <p class="text-xs text-gray-500 mb-1 info-label">First Name</p>
                        <p class="text-base font-medium text-gray-900 info-value">{{ $donor->firstname }}</p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                        <p class="text-xs text-gray-500 mb-1 info-label">Last Name</p>
                        <p class="text-base font-medium text-gray-900 info-value">{{ $donor->lastname }}</p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-100 md:col-span-2">
                        <p class="text-xs text-gray-500 mb-1 info-label">Email Address</p>
                        <p class="text-base font-medium text-gray-900 info-value">{{ $donor->email }}</p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                        <p class="text-xs text-gray-500 mb-1 info-label">Phone Number</p>
                        <p class="text-base font-medium text-gray-900 info-value">{{ $donor->phone ?? 'Not provided' }}</p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                        <p class="text-xs text-gray-500 mb-1 info-label">Country</p>
                        <p class="text-base font-medium text-gray-900 info-value">{{ $donor->country ?? 'Not provided' }}</p>
                    </div>
                </div>

                <!-- Address Information -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 section-title">Address Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-100 md:col-span-2">
                            <p class="text-xs text-gray-500 mb-1 info-label">Street Address</p>
                            <p class="text-base font-medium text-gray-900 info-value">{{ $donor->address ?? 'Not provided' }}</p>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                            <p class="text-xs text-gray-500 mb-1 info-label">City</p>
                            <p class="text-base font-medium text-gray-900 info-value">{{ $donor->city ?? 'Not provided' }}</p>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                            <p class="text-xs text-gray-500 mb-1 info-label">Region/State</p>
                            <p class="text-base font-medium text-gray-900 info-value">{{ $donor->region ?? 'Not provided' }}</p>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                            <p class="text-xs text-gray-500 mb-1 info-label">Postal Code</p>
                            <p class="text-base font-medium text-gray-900 info-value">{{ $donor->postcode ?? 'Not provided' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Communication Preferences -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 section-title">Communication Preferences</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-100 flex items-center">
                            <div class="w-2 h-2 {{ $donor->email_updates ? 'bg-green-500' : 'bg-gray-300' }} rounded-full mr-3"></div>
                            <span class="text-sm text-gray-700">
                                Email Updates: 
                                <span class="font-medium {{ $donor->email_updates ? 'text-green-600' : 'text-gray-500' }}">
                                    {{ $donor->email_updates ? 'Subscribed' : 'Unsubscribed' }}
                                </span>
                            </span>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-100 flex items-center">
                            <div class="w-2 h-2 {{ $donor->text_updates ? 'bg-green-500' : 'bg-gray-300' }} rounded-full mr-3"></div>
                            <span class="text-sm text-gray-700">
                                SMS Updates: 
                                <span class="font-medium {{ $donor->text_updates ? 'text-green-600' : 'text-gray-500' }}">
                                    {{ $donor->text_updates ? 'Subscribed' : 'Unsubscribed' }}
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Account Security -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 section-title">Account Security</h3>
                    
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-100 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="p-2 bg-yellow-100 rounded-full mr-3">
                                <svg class="h-5 w-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Password</p>
                                <p class="text-xs text-gray-500 mt-1">Last changed: {{ $donor->updated_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <a href="{{ route('member.password.change') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Change Password
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <p class="text-xs text-gray-500">
                        <span class="font-medium">Member since:</span> {{ $donor->created_at->format('F j, Y') }}
                    </p>
                    <div class="flex space-x-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            ● Active
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection