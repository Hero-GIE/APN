@extends('layouts.guest')

@section('content')
<style>
    body {
        font-family: 'Open Sans', sans-serif;
        font-size: 16px;
        line-height: 1.6;
        background-color: #f9fafb;
    }
    h1, h2, h3, h4, h5, h6, .font-urbanist, button, .btn {
        font-family: 'Urbanist', sans-serif;
    }
    .job-detail-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    .job-detail-card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    
    /* Circular Badge Styles */
    .circular-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        font-size: 0.75rem;
        font-weight: 700;
        text-align: center;
        line-height: 1.2;
        padding: 0.5rem;
        word-break: break-word;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: transform 0.2s ease;
    }
    
    .circular-badge:hover {
        transform: scale(1.05);
    }
    
    .badge-green { 
        background: linear-gradient(135deg, #d1fae5, #a7f3d0); 
        color: #065f46;
        box-shadow: 0 2px 8px rgba(6, 95, 70, 0.2);
    }
    .badge-orange { 
        background: linear-gradient(135deg, #fed7aa, #fed7aa); 
        color: #9a3412;
        box-shadow: 0 2px 8px rgba(154, 52, 18, 0.2);
    }
    .badge-blue { 
        background: linear-gradient(135deg, #dbeafe, #bfdbfe); 
        color: #1e40af;
        box-shadow: 0 2px 8px rgba(30, 64, 175, 0.2);
    }
    .badge-purple { 
        background: linear-gradient(135deg, #ede9fe, #ddd6fe); 
        color: #5b21b6;
        box-shadow: 0 2px 8px rgba(91, 33, 182, 0.2);
    }
    
    /* Responsive badge sizes */
    @media (max-width: 768px) {
        .circular-badge {
            width: 70px;
            height: 70px;
            font-size: 0.7rem;
        }
    }
    
    @media (max-width: 640px) {
        .circular-badge {
            width: 60px;
            height: 60px;
            font-size: 0.65rem;
        }
    }
    
    @media (max-width: 480px) {
        .circular-badge {
            width: 55px;
            height: 55px;
            font-size: 0.6rem;
        }
    }
    
    /* Breadcrumb styles matching other pages */
    .breadcrumb-link {
        font-family: 'Open Sans', sans-serif;
        font-size: 0.95rem;
    }
    
    /* Key details grid responsiveness */
    .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }
    
    /* Similar jobs grid */
    .similar-jobs-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1rem;
    }
    
    /* Responsive adjustments */
    @media (max-width: 640px) {
        .details-grid {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }
        
        .similar-jobs-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb - Updated to match other pages -->
        <div class="mb-6">
            <div class="flex items-center text-sm text-gray-500 mb-2 breadcrumb-link flex-wrap">
                @php
                    $donor = Auth::guard('donor')->user();
                @endphp
                @if($donor && \App\Models\Member::where('donor_id', $donor->id)->exists())
                    <a href="{{ route('member.dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                @else
                    <a href="{{ route('donor.dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                @endif
                <svg class="w-4 h-4 mx-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <a href="{{ route('member.jobs.index') }}" class="hover:text-indigo-600">Job Opportunities</a>
                <svg class="w-4 h-4 mx-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700 truncate">{{ $job->title }}</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 font-urbanist">{{ $job->title }}</h1>
            <p class="text-gray-600 mt-2 text-sm sm:text-base">View job details and apply for this opportunity</p>
        </div>

        <!-- Main Job Card -->
        <div class="job-detail-card p-4 sm:p-6 md:p-8 mb-6">
            
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
                <div class="flex-1">
                    <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 font-urbanist">{{ $job->title }}</h2>
                    <p class="text-gray-600 mt-1 sm:mt-2 text-base sm:text-lg">{{ $job->company }}</p>
                </div>
                @if($job->badge_type)
                <div class="flex justify-center sm:justify-end">
                    <span class="circular-badge 
                        @if($job->badge_color == 'green') badge-green
                        @elseif($job->badge_color == 'orange') badge-orange
                        @elseif($job->badge_color == 'blue') badge-blue
                        @else badge-green
                        @endif">
                        {{ $job->badge_type }}
                    </span>
                </div>
                @endif
            </div>

            <!-- Key Details Grid -->
            <div class="details-grid mb-8">
                <div class="bg-gray-50 rounded-lg p-3 sm:p-4">
                    <p class="text-xs text-gray-500 mb-1">Location</p>
                    <p class="font-semibold text-gray-900 text-sm sm:text-base">{{ $job->location }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3 sm:p-4">
                    <p class="text-xs text-gray-500 mb-1">Job Type</p>
                    <p class="font-semibold text-gray-900 text-sm sm:text-base">{{ $job->job_type }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3 sm:p-4">
                    <p class="text-xs text-gray-500 mb-1">Experience Level</p>
                    <p class="font-semibold text-gray-900 text-sm sm:text-base">{{ $job->experience_level }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3 sm:p-4">
                    <p class="text-xs text-gray-500 mb-1">Salary Range</p>
                    <p class="font-semibold text-gray-900 text-sm sm:text-base">{{ $job->salary_range }}</p>
                </div>
            </div>

            <!-- Job Summary/Description -->
            <div class="mb-8">
                <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-3 sm:mb-4 font-urbanist">Job Description</h3>
                <div class="prose max-w-none text-gray-700 leading-relaxed text-sm sm:text-base">
                    {!! nl2br(e($job->description)) !!}
                </div>
            </div>

            <!-- Requirements Section -->
            <div class="mb-8">
                <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-3 sm:mb-4 font-urbanist">Requirements</h3>
                <div class="bg-gray-50 rounded-lg p-4 sm:p-6">
                    <p class="text-gray-700 text-sm sm:text-base">{{ $job->requirements }}</p>
                </div>
            </div>

            <!-- Benefits Section -->
            @if($job->benefits)
            <div class="mb-8">
                <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-3 sm:mb-4 font-urbanist">Benefits</h3>
                <div class="bg-gray-50 rounded-lg p-4 sm:p-6">
                    <p class="text-gray-700 text-sm sm:text-base">{{ $job->benefits }}</p>
                </div>
            </div>
            @endif

            <!-- Application Deadline -->
            <div class="bg-amber-50 border-2 border-amber-200 rounded-xl p-4 mb-8">
                <div class="flex items-center gap-3">
                    <div class="bg-amber-100 rounded-full p-2 flex-shrink-0">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-amber-800 text-sm sm:text-base">Application Deadline</p>
                        <p class="text-xs sm:text-sm text-amber-700">{{ $job->application_deadline->format('F j, Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- APPLY SECTION-->
            @php
                $hasApplied = $job->hasApplied(Auth::guard('donor')->id());
            @endphp

            @if($hasApplied)
                <div class="bg-green-50 border-2 border-green-200 rounded-xl p-4 sm:p-6 mb-6">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                        <div class="bg-green-100 rounded-full p-3 w-fit">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-green-800 text-base sm:text-lg">You've Already Applied!</p>
                            <p class="text-green-700 mt-1 text-sm sm:text-base">Your application for this position has been received.</p>
                            <a href="{{ route('member.jobs.applications') }}" class="inline-block mt-2 sm:mt-3 text-green-700 hover:text-green-900 font-medium underline text-sm sm:text-base">
                                Track your application in My Applications →
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('member.jobs.apply', $job->slug) }}" 
                   class="block w-full py-3 sm:py-4 md:py-5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl text-center font-urbanist font-bold text-sm sm:text-base md:text-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Apply for This Position
                </a>
            @endif

            <!-- Additional Info -->
            <p class="text-xs text-gray-400 text-center mt-4">
                Posted {{ $job->posted_date->diffForHumans() }} • Reference: {{ substr($job->slug, 0, 8) }}
            </p>
        </div>

        <!-- Similar Jobs Section -->
        @if(isset($similarJobs) && $similarJobs->count() > 0)
        <div class="mt-8">
            <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-4 font-urbanist">Similar Opportunities</h3>
            <div class="similar-jobs-grid">
                @foreach($similarJobs as $similar)
                <a href="{{ route('member.jobs.show', $similar->slug) }}" 
                   class="block bg-white rounded-lg p-4 border border-gray-200 hover:border-indigo-300 hover:shadow-md transition-all">
                    <h4 class="font-bold text-gray-900 font-urbanist text-sm sm:text-base">{{ $similar->title }}</h4>
                    <p class="text-xs sm:text-sm text-gray-600 mt-1">{{ $similar->company }} • {{ $similar->location }}</p>
                    <div class="flex items-center justify-between mt-3">
                        <span class="text-xs text-gray-500">{{ $similar->job_type }}</span>
                        <span class="text-xs text-indigo-600">View Details →</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Security Footer Note -->
        <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-3 mt-8 text-xs text-gray-400">
            <i class="fas fa-circle text-yellow-500" style="font-size:0.35rem;"></i>
            <span>256-bit encrypted</span>
            <i class="fas fa-circle text-yellow-500" style="font-size:0.35rem;"></i>
            <span>Powered by Paystack</span>
            <i class="fas fa-circle text-yellow-500" style="font-size:0.35rem;"></i>
            <span>Secure transactions</span>
        </div>
    </div>
</div>
@endsection