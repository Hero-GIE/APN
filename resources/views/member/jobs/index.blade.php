@extends('layouts.guest')

@section('content')
<style>
    body {
        font-family: 'Open Sans', sans-serif;
        background-color: #f9fafb;
    }
    h1, h2, h3, h4, h5, h6, .font-urbanist, button, .btn {
        font-family: 'Urbanist', sans-serif;
    }
    .job-card {
        transition: all 0.3s ease;
    }
    .job-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }
    .badge-applied {
        background: #d1fae5;
        color: #065f46;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .badge-deadline {
        background: #fffbeb;
        color: #92400e;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }
    .filter-select {
        width: 100%;
        padding: 0.5rem 1rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        font-size: 0.95rem;
        transition: all 0.2s ease;
    }
    .filter-select:focus {
        outline: none;
        border-color: #4f46e5;
        ring: 2px solid #4f46e5;
    }
</style>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb Navigation -->
        <div class="mb-6">
            <nav class="flex items-center text-sm" style="font-family: 'Open Sans', sans-serif;">
                <a href="{{ route('member.dashboard') }}#jobs" class="text-gray-500 hover:text-indigo-600 transition-colors">Dashboard</a>
                <svg class="w-4 h-4 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-gray-900 font-medium">Job Opportunities</span>
            </nav>
        </div>

        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900" style="font-family: 'Urbanist', sans-serif;">Job Opportunities</h1>
            <p class="text-gray-600 mt-2" style="font-family: 'Open Sans', sans-serif;">Find your next career opportunity across Africa</p>
        </div>

        <!-- Filters Section -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <form method="GET" action="{{ route('member.jobs.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" style="font-family: 'Urbanist', sans-serif;">Category</label>
                    <select name="category" class="filter-select" style="font-family: 'Open Sans', sans-serif;">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" style="font-family: 'Urbanist', sans-serif;">Job Type</label>
                    <select name="job_type" class="filter-select" style="font-family: 'Open Sans', sans-serif;">
                        <option value="">All Types</option>
                        @foreach($jobTypes as $type)
                        <option value="{{ $type }}" {{ request('job_type') == $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" style="font-family: 'Urbanist', sans-serif;">Experience Level</label>
                    <select name="experience_level" class="filter-select" style="font-family: 'Open Sans', sans-serif;">
                        <option value="">All Levels</option>
                        <option value="Entry Level" {{ request('experience_level') == 'Entry Level' ? 'selected' : '' }}>Entry Level</option>
                        <option value="Mid Level" {{ request('experience_level') == 'Mid Level' ? 'selected' : '' }}>Mid Level</option>
                        <option value="Senior Level" {{ request('experience_level') == 'Senior Level' ? 'selected' : '' }}>Senior Level</option>
                        <option value="Executive Level" {{ request('experience_level') == 'Executive Level' ? 'selected' : '' }}>Executive Level</option>
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="w-full px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-md" style="font-family: 'Urbanist', sans-serif;">
                        Apply Filters
                    </button>
                </div>
            </form>

            <!-- Active Filters Display -->
            @if(request()->anyFilled(['category', 'job_type', 'experience_level']))
            <div class="mt-4 pt-4 border-t border-gray-200">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="text-sm text-gray-500" style="font-family: 'Open Sans', sans-serif;">Active filters:</span>
                    @if(request('category'))
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-medium">
                        Category: {{ request('category') }}
                    </span>
                    @endif
                    @if(request('job_type'))
                    <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-medium">
                        Type: {{ request('job_type') }}
                    </span>
                    @endif
                    @if(request('experience_level'))
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">
                        Level: {{ request('experience_level') }}
                    </span>
                    @endif
                    <a href="{{ route('member.jobs.index') }}" class="text-sm text-red-600 hover:text-red-800 ml-2" style="font-family: 'Urbanist', sans-serif;">
                        Clear All
                    </a>
                </div>
            </div>
            @endif
        </div>

        <!-- Jobs List -->
        <div class="space-y-4">
            @forelse($jobs as $job)
            @php
                $hasApplied = $job->hasApplied(Auth::guard('donor')->id());
                $deadlineApproaching = $job->application_deadline && $job->application_deadline->diffInDays(now()) < 7;
            @endphp
            <div class="job-card bg-white rounded-lg shadow p-6 hover:shadow-md transition-all">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <!-- Left Column - Job Details -->
                    <div class="flex-1 min-w-[200px]">
                        <div class="flex flex-wrap items-center gap-2 mb-2">
                            <h3 class="text-xl font-bold text-gray-900" style="font-family: 'Urbanist', sans-serif;">{{ $job->title }}</h3>
                            @if($job->badge_type)
                            <span class="px-2 py-1 {{ $job->badge_color_class }} rounded-full text-xs font-semibold" style="font-family: 'Urbanist', sans-serif;">
                                {{ $job->badge_type }}
                            </span>
                            @endif
                            @if($hasApplied)
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold" style="font-family: 'Urbanist', sans-serif;">
                                <i class="fas fa-check-circle mr-1"></i> Applied
                            </span>
                            @endif
                        </div>
                        
                        <p class="text-gray-600" style="font-family: 'Open Sans', sans-serif;">
                            <i class="fas fa-building mr-1 text-gray-400"></i> {{ $job->company }} 
                            <span class="mx-2">•</span>
                            <i class="fas fa-map-marker-alt mr-1 text-gray-400"></i> {{ $job->location }}
                        </p>
                        
                        <p class="text-gray-500 text-sm mt-3 leading-relaxed" style="font-family: 'Open Sans', sans-serif;">
                            {{ $job->summary }}
                        </p>
                        
                        <!-- Job Meta Information -->
                        <div class="flex flex-wrap items-center gap-3 mt-4">
                            <span class="inline-flex items-center text-xs bg-gray-100 text-gray-700 px-3 py-1 rounded-full" style="font-family: 'Open Sans', sans-serif;">
                                <i class="far fa-clock mr-1"></i> {{ $job->job_type }}
                            </span>
                            <span class="inline-flex items-center text-xs bg-gray-100 text-gray-700 px-3 py-1 rounded-full" style="font-family: 'Open Sans', sans-serif;">
                                <i class="far fa-chart-bar mr-1"></i> {{ $job->experience_level }}
                            </span>
                            <span class="inline-flex items-center text-xs text-gray-500" style="font-family: 'Open Sans', sans-serif;">
                                <i class="far fa-money-bill-alt mr-1"></i> {{ $job->salary_range }}
                            </span>
                            <span class="inline-flex items-center text-xs text-gray-500" style="font-family: 'Open Sans', sans-serif;">
                                <i class="far fa-calendar-alt mr-1"></i> {{ $job->formatted_posted_date }}
                            </span>
                        </div>

                        <!-- Deadline Warning -->
                        @if($deadlineApproaching && !$hasApplied)
                        <div class="mt-3">
                            <span class="badge-deadline">
                                <i class="fas fa-exclamation-triangle"></i>
                                Deadline: {{ $job->application_deadline->format('M d, Y') }}
                            </span>
                        </div>
                        @endif
                    </div>

                    <!-- Right Column - Actions -->
                    <div class="flex flex-col items-end gap-3 min-w-[140px]">
                        <a href="{{ route('member.jobs.show', ['slug' => $job->slug]) }}" 
                           class="text-indigo-600 hover:text-indigo-900 text-sm font-medium flex items-center gap-1" 
                           style="font-family: 'Urbanist', sans-serif;">
                            View Details
                            <i class="fas fa-arrow-right text-xs"></i>
                        </a>

                        <!-- Application Button / Status -->
                        @if($hasApplied)
                            <span class="badge-applied w-full justify-center">
                                <i class="fas fa-check-circle"></i>
                                Application Submitted
                            </span>
                            <span class="text-xs text-gray-400 text-center w-full">
                                Applied {{ $job->applications->first()->created_at->diffForHumans() ?? 'recently' }}
                            </span>
                        @else
                            <a href="{{ route('member.jobs.apply', $job->slug) }}?from=jobs-index" 
                               class="w-full px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg text-sm hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-md flex items-center justify-center gap-2 font-medium"
                               style="font-family: 'Urbanist', sans-serif;">
                                <i class="fas fa-paper-plane"></i>
                                Apply Now
                            </a>
                            
                            @if($job->application_deadline)
                            <span class="text-xs text-gray-400 text-center w-full">
                                Deadline: {{ $job->application_deadline->format('M d, Y') }}
                            </span>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-16 bg-white rounded-lg shadow">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2" style="font-family: 'Urbanist', sans-serif;">No Jobs Found</h3>
                <p class="text-gray-500 mb-6" style="font-family: 'Open Sans', sans-serif;">No job opportunities match your current filters.</p>
                <a href="{{ route('member.jobs.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-md font-medium" style="font-family: 'Urbanist', sans-serif;">
                    <i class="fas fa-times-circle mr-2"></i>
                    Clear All Filters
                </a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($jobs->hasPages())
        <div class="mt-8">
            {{ $jobs->withQueryString()->links() }}
        </div>
        @endif

        <!-- Career Resources Section -->
        <div class="mt-8 p-8 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border border-blue-200">
            <div class="flex items-center gap-4 mb-6">
                <div class="bg-white rounded-full p-3 shadow-sm">
                    <i class="fas fa-briefcase text-indigo-600 text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900" style="font-family: 'Urbanist', sans-serif;">Career Resources</h3>
                    <p class="text-sm text-gray-600" style="font-family: 'Open Sans', sans-serif;">Exclusive resources for APN members</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="#" class="flex items-center gap-3 p-4 bg-white rounded-lg hover:shadow-md transition-all group">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-file-pdf text-red-500"></i>
                    </div>
                    <div>
                        <span class="block text-sm font-medium text-gray-900" style="font-family: 'Urbanist', sans-serif;">Resume Template</span>
                        <span class="text-xs text-gray-500">Professional CV templates</span>
                    </div>
                </a>
                
                <a href="#" class="flex items-center gap-3 p-4 bg-white rounded-lg hover:shadow-md transition-all group">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-video text-blue-500"></i>
                    </div>
                    <div>
                        <span class="block text-sm font-medium text-gray-900" style="font-family: 'Urbanist', sans-serif;">Interview Tips</span>
                        <span class="text-xs text-gray-500">Ace your next interview</span>
                    </div>
                </a>
                
                <a href="#" class="flex items-center gap-3 p-4 bg-white rounded-lg hover:shadow-md transition-all group">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-users text-green-500"></i>
                    </div>
                    <div>
                        <span class="block text-sm font-medium text-gray-900" style="font-family: 'Urbanist', sans-serif;">Mentorship Program</span>
                        <span class="text-xs text-gray-500">Connect with industry leaders</span>
                    </div>
                </a>
            </div>
        </div>

        <!-- Mobile Bottom Navigation -->
        <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 md:hidden">
            <a href="{{ route('member.dashboard') }}#jobs" class="block w-full text-center px-4 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg font-medium" style="font-family: 'Urbanist', sans-serif;">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection