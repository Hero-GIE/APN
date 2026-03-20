@extends('layouts.guest')

@section('content')
<style>
    body {
        font-family: 'Open Sans', sans-serif;
        background-color: #f9fafb;
    }
    h1, h2, h3, h4, h5, h6, .font-urbanist {
        font-family: 'Urbanist', sans-serif;
    }
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .status-pending { background: #fef3c7; color: #92400e; }
    .status-reviewed { background: #dbeafe; color: #1e40af; }
    .status-shortlisted { background: #d1fae5; color: #065f46; }
    .status-rejected { background: #fee2e2; color: #991b1b; }
    .status-hired { background: #e0e7ff; color: #3730a3; }
</style>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center text-sm text-gray-500 mb-2">
                <a href="{{ route('member.dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700">My Applications</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">My Job Applications</h1>
            <p class="text-gray-600 mt-2">Track your job applications and their status.</p>
        </div>

        <!-- Applications List -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            @forelse($applications as $application)
            <div class="border-b border-gray-200 last:border-b-0 hover:bg-gray-50 transition-colors p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-lg font-bold text-gray-900">{{ $application->job->title }}</h3>
                            <span class="status-badge status-{{ $application->status }}">
                                {{ ucfirst($application->status) }}
                            </span>
                        </div>
                        <p class="text-gray-600 text-sm mb-2">{{ $application->job->company }} • {{ $application->job->location }}</p>
                        <div class="flex flex-wrap gap-4 text-xs text-gray-500">
                            <span><i class="far fa-calendar mr-1"></i> Applied: {{ $application->applied_at->format('M d, Y') }}</span>
                            <span><i class="far fa-clock mr-1"></i> {{ $application->job->job_type }}</span>
                            <span><i class="far fa-money-bill-alt mr-1"></i> {{ $application->job->salary_range }}</span>
                        </div>
                        @if($application->cover_letter)
                        <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                            <p class="text-xs text-gray-500 mb-1">Your Cover Letter:</p>
                            <p class="text-sm text-gray-700">{{ Str::limit($application->cover_letter, 200) }}</p>
                        </div>
                        @endif
                    </div>
                    <div class="flex flex-col gap-2 md:text-right">
                        <a href="{{ route('member.jobs.show', $application->job->slug) }}" 
                           class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm">
                            View Job
                        </a>
                        @if($application->resume_path)
                        <a href="{{ asset('storage/' . $application->resume_path) }}" 
                           target="_blank"
                           class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm">
                            <i class="fas fa-download mr-2"></i> Resume
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-12">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No applications yet</h3>
                <p class="text-gray-500 mb-6">Start exploring job opportunities and submit your first application.</p>
                <a href="{{ route('member.jobs.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    Browse Jobs
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($applications->hasPages())
        <div class="mt-6">
            {{ $applications->links() }}
        </div>
        @endif
    </div>
</div>
@endsection