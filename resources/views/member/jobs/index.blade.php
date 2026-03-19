@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <nav class="flex items-center text-sm" style="font-family: 'Open Sans', sans-serif;">
                <a href="{{ route('member.dashboard') }}#jobs" class="text-gray-500 hover:text-indigo-600 transition-colors">Dashboard</a>
                <svg class="w-4 h-4 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-gray-900 font-medium">Job Opportunities</span>
            </nav>
        </div>

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900" style="font-family: 'Urbanist', sans-serif;">Job Opportunities</h1>
            <p class="text-gray-600 mt-2" style="font-family: 'Open Sans', sans-serif;">Find your next career opportunity across Africa</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <form method="GET" action="{{ route('member.jobs.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" style="font-family: 'Urbanist', sans-serif;">Category</label>
                    <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" style="font-family: 'Open Sans', sans-serif;">
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
                    <select name="job_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" style="font-family: 'Open Sans', sans-serif;">
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
                    <select name="experience_level" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" style="font-family: 'Open Sans', sans-serif;">
                        <option value="">All Levels</option>
                        <option value="Entry Level" {{ request('experience_level') == 'Entry Level' ? 'selected' : '' }}>Entry Level</option>
                        <option value="Mid Level" {{ request('experience_level') == 'Mid Level' ? 'selected' : '' }}>Mid Level</option>
                        <option value="Senior Level" {{ request('experience_level') == 'Senior Level' ? 'selected' : '' }}>Senior Level</option>
                        <option value="Executive Level" {{ request('experience_level') == 'Executive Level' ? 'selected' : '' }}>Executive Level</option>
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="w-full px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700" style="font-family: 'Urbanist', sans-serif;">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>

        <!-- Jobs List -->
        <div class="space-y-4">
            @forelse($jobs as $job)
            <div class="bg-white rounded-lg shadow p-6 hover:shadow-md transition-shadow">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex flex-wrap items-center gap-2 mb-2">
                            <h3 class="text-xl font-bold text-gray-900" style="font-family: 'Urbanist', sans-serif;">{{ $job->title }}</h3>
                            @if($job->badge_type)
                            <span class="px-2 py-1 {{ $job->badge_color_class }} rounded-full text-xs font-semibold" style="font-family: 'Urbanist', sans-serif;">
                                {{ $job->badge_type }}
                            </span>
                            @endif
                        </div>
                        <p class="text-gray-600" style="font-family: 'Open Sans', sans-serif;">{{ $job->company }} • {{ $job->location }}</p>
                        <p class="text-gray-500 text-sm mt-2" style="font-family: 'Open Sans', sans-serif;">{{ $job->summary }}</p>
                        <div class="flex flex-wrap items-center gap-4 mt-4">
                            <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded-full" style="font-family: 'Open Sans', sans-serif;">{{ $job->job_type }}</span>
                            <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded-full" style="font-family: 'Open Sans', sans-serif;">{{ $job->experience_level }}</span>
                            <span class="text-xs text-gray-500" style="font-family: 'Open Sans', sans-serif;">{{ $job->salary_range }}</span>
                            <span class="text-xs text-gray-500" style="font-family: 'Open Sans', sans-serif;">{{ $job->formatted_posted_date }}</span>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-2">
                        <a href="{{ route('member.jobs.show', ['slug' => $job->slug, 'from' => 'dashboard']) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium" style="font-family: 'Urbanist', sans-serif;">
                            View Details →
                        </a>
                        <a href="{{ $job->application_url ?: '#' }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm hover:bg-indigo-700" style="font-family: 'Urbanist', sans-serif;">
                            Apply Now
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-12">
                <p class="text-gray-500" style="font-family: 'Open Sans', sans-serif;">No job opportunities found matching your criteria.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $jobs->withQueryString()->links() }}
        </div>

        <!-- Mobile Bottom Navigation -->
        <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 md:hidden">
            <a href="{{ route('member.dashboard') }}#jobs" class="block w-full text-center px-4 py-2 bg-indigo-600 text-white rounded-lg" style="font-family: 'Urbanist', sans-serif;">
                ← Back to Dashboard
            </a>
        </div>

        <!-- Career Resources -->
        <div class="mt-8 p-6 bg-blue-50 rounded-lg">
            <h3 class="text-lg font-bold text-gray-900 mb-2" style="font-family: 'Urbanist', sans-serif;">Career Resources</h3>
            <p class="text-sm text-gray-600 mb-4" style="font-family: 'Open Sans', sans-serif;">Access exclusive career development resources for members</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="#" class="text-sm text-indigo-600 hover:text-indigo-900 flex items-center" style="font-family: 'Open Sans', sans-serif;">
                    <i class="fas fa-file-pdf mr-2"></i> Resume Template
                </a>
                <a href="#" class="text-sm text-indigo-600 hover:text-indigo-900 flex items-center" style="font-family: 'Open Sans', sans-serif;">
                    <i class="fas fa-video mr-2"></i> Interview Tips
                </a>
                <a href="#" class="text-sm text-indigo-600 hover:text-indigo-900 flex items-center" style="font-family: 'Open Sans', sans-serif;">
                    <i class="fas fa-users mr-2"></i> Mentorship Program
                </a>
            </div>
        </div>
    </div>
</div>
@endsection