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
    .badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .badge-green { background: #d1fae5; color: #065f46; }
    .badge-orange { background: #fed7aa; color: #9a3412; }
    .badge-blue { background: #dbeafe; color: #1e40af; }
    .badge-purple { background: #ede9fe; color: #5b21b6; }
</style>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <div class="mb-6">
            <div class="flex items-center text-sm text-gray-500 mb-2">
                <a href="{{ route('member.dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <a href="{{ route('member.jobs.index') }}" class="hover:text-indigo-600">Jobs</a>
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700">{{ $job->title }}</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Job Details</h1>
        </div>

        <!-- Main Job Card -->
        <div class="job-detail-card p-6 md:p-8 mb-6">
            
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $job->title }}</h2>
                    <p class="text-gray-600 mt-2 text-lg">{{ $job->company }}</p>
                </div>
                @if($job->badge_type)
                <span class="badge 
                    @if($job->badge_color == 'green') badge-green
                    @elseif($job->badge_color == 'orange') badge-orange
                    @elseif($job->badge_color == 'blue') badge-blue
                    @else badge-green
                    @endif px-3 py-1.5 text-sm">
                    {{ $job->badge_type }}
                </span>
                @endif
            </div>

            <!-- Key Details Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-xs text-gray-500 mb-1">Location</p>
                    <p class="font-semibold text-gray-900">{{ $job->location }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-xs text-gray-500 mb-1">Job Type</p>
                    <p class="font-semibold text-gray-900">{{ $job->job_type }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-xs text-gray-500 mb-1">Experience Level</p>
                    <p class="font-semibold text-gray-900">{{ $job->experience_level }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-xs text-gray-500 mb-1">Salary Range</p>
                    <p class="font-semibold text-gray-900">{{ $job->salary_range }}</p>
                </div>
            </div>

            <!-- Job Summary/Description -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Job Description</h3>
                <div class="prose max-w-none text-gray-700 leading-relaxed">
                    {!! nl2br(e($job->description)) !!}
                </div>
            </div>

            <!-- Requirements Section -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Requirements</h3>
                <div class="bg-gray-50 rounded-lg p-6">
                    <p class="text-gray-700">{{ $job->requirements }}</p>
                </div>
            </div>

            <!-- Benefits Section -->
            @if($job->benefits)
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Benefits</h3>
                <div class="bg-gray-50 rounded-lg p-6">
                    <p class="text-gray-700">{{ $job->benefits }}</p>
                </div>
            </div>
            @endif

            <!-- Application Deadline -->
            <div class="bg-amber-50 border-2 border-amber-200 rounded-xl p-4 mb-8">
                <div class="flex items-center gap-3">
                    <div class="bg-amber-100 rounded-full p-2">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-amber-800">Application Deadline</p>
                        <p class="text-sm text-amber-700">{{ $job->application_deadline->format('F j, Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- APPLY SECTION-->
            @php
                $hasApplied = $job->hasApplied(Auth::guard('donor')->id());
            @endphp

            @if($hasApplied)
                <div class="bg-green-50 border-2 border-green-200 rounded-xl p-6 mb-6">
                    <div class="flex items-center gap-4">
                        <div class="bg-green-100 rounded-full p-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-green-800 text-lg">You've Already Applied!</p>
                            <p class="text-green-700 mt-1">Your application for this position has been received.</p>
                            <a href="{{ route('member.jobs.applications') }}" class="inline-block mt-3 text-green-700 hover:text-green-900 font-medium underline">
                                Track your application in My Applications →
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('member.jobs.apply', $job->slug) }}" 
                   class="block w-full py-5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl text-center font-urbanist font-bold text-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
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
            <h3 class="text-xl font-bold text-gray-900 mb-4">Similar Opportunities</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($similarJobs as $similar)
                <a href="{{ route('member.jobs.show', $similar->slug) }}" 
                   class="block bg-white rounded-lg p-4 border border-gray-200 hover:border-indigo-300 hover:shadow-md transition-all">
                    <h4 class="font-bold text-gray-900">{{ $similar->title }}</h4>
                    <p class="text-sm text-gray-600 mt-1">{{ $similar->company }} • {{ $similar->location }}</p>
                    <div class="flex items-center justify-between mt-3">
                        <span class="text-xs text-gray-500">{{ $similar->job_type }}</span>
                        <span class="text-xs text-indigo-600">View Details →</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>
@endsection