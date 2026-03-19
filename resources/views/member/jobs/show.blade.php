@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <a href="{{ route('member.dashboard') }}" 
           class="inline-flex items-center text-gray-600 hover:text-indigo-600 mb-6" 
           id="backButton"
           style="font-family: 'Open Sans', sans-serif;">
            <span id="backButtonText">Back to Dashboard</span>
        </a>

        <!-- Job Details -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-8">
                <div class="flex flex-wrap items-start justify-between gap-4 mb-4">
                    <div>
                        <div class="flex flex-wrap items-center gap-2 mb-3">
                            <span class="px-3 py-1 {{ $job->category_color_class }} rounded-full text-xs font-semibold" style="font-family: 'Urbanist', sans-serif;">
                                {{ $job->category }}
                            </span>
                            @if($job->badge_type)
                            <span class="px-3 py-1 {{ $job->badge_color_class }} rounded-full text-xs font-semibold" style="font-family: 'Urbanist', sans-serif;">
                                {{ $job->badge_type }}
                            </span>
                            @endif
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900" style="font-family: 'Urbanist', sans-serif;">{{ $job->title }}</h1>
                        <p class="text-lg text-gray-600 mt-2" style="font-family: 'Open Sans', sans-serif;">{{ $job->company }} • {{ $job->location }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500" style="font-family: 'Open Sans', sans-serif;">{{ $job->formatted_posted_date }}</p>
                        @if($job->application_deadline)
                        <p class="text-sm text-red-600 mt-1" style="font-family: 'Open Sans', sans-serif;">Deadline: {{ $job->application_deadline->format('M d, Y') }}</p>
                        @endif
                    </div>
                </div>

                <!-- Key Details Grid -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-gray-50 rounded-lg p-4 mb-6">
                    <div>
                        <p class="text-xs text-gray-500" style="font-family: 'Open Sans', sans-serif;">Job Type</p>
                        <p class="font-medium" style="font-family: 'Urbanist', sans-serif;">{{ $job->job_type }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500" style="font-family: 'Open Sans', sans-serif;">Experience</p>
                        <p class="font-medium" style="font-family: 'Urbanist', sans-serif;">{{ $job->experience_level }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500" style="font-family: 'Open Sans', sans-serif;">Salary</p>
                        <p class="font-medium" style="font-family: 'Urbanist', sans-serif;">{{ $job->salary_range }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500" style="font-family: 'Open Sans', sans-serif;">Location</p>
                        <p class="font-medium" style="font-family: 'Urbanist', sans-serif;">{{ $job->city }}, {{ $job->country }}</p>
                    </div>
                </div>

                <!-- Job Description -->
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4" style="font-family: 'Urbanist', sans-serif;">Job Description</h2>
                    <div class="prose max-w-none" style="font-family: 'Open Sans', sans-serif;">
                        {!! nl2br(e($job->description)) !!}
                    </div>
                </div>

                @if($job->requirements)
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4" style="font-family: 'Urbanist', sans-serif;">Requirements</h2>
                    <div class="prose max-w-none" style="font-family: 'Open Sans', sans-serif;">
                        {!! nl2br(e($job->requirements)) !!}
                    </div>
                </div>
                @endif

                @if($job->benefits)
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4" style="font-family: 'Urbanist', sans-serif;">Benefits</h2>
                    <div class="prose max-w-none" style="font-family: 'Open Sans', sans-serif;">
                        {!! nl2br(e($job->benefits)) !!}
                    </div>
                </div>
                @endif

                <!-- Apply Button -->
                <div class="border-t border-gray-200 pt-6 mt-6">
                    <a href="{{ $job->application_url ?: '#' }}" class="inline-block px-8 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium" style="font-family: 'Urbanist', sans-serif;">
                        Apply for this position
                    </a>
                    <p class="text-sm text-gray-500 mt-2" style="font-family: 'Open Sans', sans-serif;">Applications are reviewed on a rolling basis</p>
                </div>
            </div>
        </div>

        <!-- Similar Jobs -->
        @if($similarJobs->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6" style="font-family: 'Urbanist', sans-serif;">Similar Jobs</h2>
            <div class="space-y-4">
                @foreach($similarJobs as $similar)
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900" style="font-family: 'Urbanist', sans-serif;">
                                <a href="{{ route('member.jobs.show', $similar->slug) }}" class="hover:text-indigo-600">
                                    {{ $similar->title }}
                                </a>
                            </h3>
                            <p class="text-sm text-gray-600" style="font-family: 'Open Sans', sans-serif;">{{ $similar->company }} • {{ $similar->location }}</p>
                            <div class="flex flex-wrap gap-2 mt-2">
                                <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded-full" style="font-family: 'Open Sans', sans-serif;">{{ $similar->job_type }}</span>
                                <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded-full" style="font-family: 'Open Sans', sans-serif;">{{ $similar->experience_level }}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500" style="font-family: 'Open Sans', sans-serif;">{{ $similar->formatted_posted_date }}</p>
                            <a href="{{ route('member.jobs.show', $similar->slug) }}" class="text-sm text-indigo-600 hover:text-indigo-900 mt-2 inline-block" style="font-family: 'Urbanist', sans-serif;">
                                View Details →
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const backButton = document.getElementById('backButton');
        const backText = document.getElementById('backButtonText');
        
        if (window.location.hash === '#from-dashboard-jobs') {
            backButton.href = '{{ route("member.dashboard") }}#jobs';
            backText.textContent = '← Back to Dashboard (Jobs)';
        } else {
            backButton.href = '{{ route("member.jobs.index") }}';
            backText.textContent = '← Back to Jobs';
        }
    });
</script>
@endpush
@endsection