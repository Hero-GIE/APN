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
    
    .puzzle-card {
        transition: all 0.3s ease;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        background: white;
        height: 100%;
    }
    .puzzle-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
    }
    .difficulty-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9000px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .stat-card {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        border: 1px solid #e2e8f0;
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
        <!-- Breadcrumb -->
        <div class="mb-6">
            <div class="flex items-center text-sm text-gray-500 mb-2 breadcrumb-link">
                @if($donor)
                    <a href="{{ route('member.dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                @else
                    <a href="{{ route('donor.dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                @endif
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700">Puzzles</span>
            </div>
        </div>

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">African Puzzles & Games</h1>
            <p class="text-gray-600 mt-2">Test your knowledge of African countries, capitals, heritage, and culture.</p>
        </div>

        <!-- User Stats -->
     <!-- User Stats - Dashboard Style -->
@if($donor && $userStats)
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
    <!-- Total Attempts -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 hover:shadow-md transition-all duration-300">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-full">
                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Total Attempts</p>
                <p class="text-2xl font-bold text-gray-900">{{ $userStats['total_attempts'] }}</p>
            </div>
        </div>
    </div>

    <!-- Completed -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 hover:shadow-md transition-all duration-300">
        <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-full">
                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Completed</p>
                <p class="text-2xl font-bold text-green-600">{{ $userStats['completed'] }}</p>
            </div>
        </div>
    </div>

    <!-- Total Score -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 hover:shadow-md transition-all duration-300">
        <div class="flex items-center">
            <div class="p-3 bg-indigo-100 rounded-full">
                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Total Score</p>
                <p class="text-2xl font-bold text-indigo-600">{{ number_format($userStats['total_score']) }}</p>
            </div>
        </div>
    </div>

    <!-- Achievements -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 hover:shadow-md transition-all duration-300">
        <div class="flex items-center">
            <div class="p-3 bg-purple-100 rounded-full">
                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Achievements</p>
                <p class="text-2xl font-bold text-purple-600">{{ $userStats['achievements'] }}</p>
            </div>
        </div>
    </div>

    <!-- Global Rank -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 hover:shadow-md transition-all duration-300">
        <div class="flex items-center">
            <div class="p-3 bg-yellow-100 rounded-full">
                <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Global Rank</p>
                <p class="text-2xl font-bold text-yellow-600">#{{ $userStats['rank'] ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
</div>
@endif

        <!-- Categories -->
        @if($categories->count() > 0)
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Categories</h2>
            <div class="grid grid-cols-5 md:grid-cols-6 lg:grid-cols-4 gap-4">
                @foreach($categories as $category)
                <a href="{{ route('puzzles.index', ['category' => $category->id]) }}" 
                   class="bg-white rounded-lg p-4 text-center border border-gray-200 hover:border-indigo-300 transition-all">
                    @if($category->icon)
                        <i class="{{ $category->icon }} text-2xl" style="color: {{ $category->color }}"></i>
                    @endif
                    <h3 class="font-medium text-gray-900 mt-2">{{ $category->name }}</h3>
                    <p class="text-xs text-gray-500">{{ $category->puzzles_count }} puzzles</p>
                </a>
                @endforeach
            </div>
        </div>
        @endif

     <!-- Replace the Featured Puzzles section -->
@if($featuredPuzzles->count() > 0)
<div class="mb-8">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-800">Featured Puzzles</h2>
        <a href="{{ route('puzzles.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">View All →</a>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($featuredPuzzles as $puzzle)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-all duration-300 hover:-translate-y-1">
            @if($puzzle->featured_image)
            <div class="h-48 overflow-hidden">
                <img src="{{ $puzzle->featured_image }}" class="w-full h-full object-cover">
            </div>
            @endif
            <div class="p-6">
                <div class="flex items-center justify-between mb-3">
                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                        @if($puzzle->difficulty == 'beginner') bg-green-100 text-green-700
                        @elseif($puzzle->difficulty == 'intermediate') bg-blue-100 text-blue-700
                        @elseif($puzzle->difficulty == 'advanced') bg-orange-100 text-orange-700
                        @else bg-red-100 text-red-700 @endif">
                        {{ ucfirst($puzzle->difficulty) }}
                    </span>
                    @if($puzzle->requires_membership)
                    <span class="px-2 py-1 bg-purple-100 text-purple-700 text-xs rounded-full">Member Only</span>
                    @else
                    <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">Free</span>
                    @endif
                </div>
                
                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $puzzle->title }}</h3>
                <p class="text-sm text-gray-600 mb-4">{{ Str::limit($puzzle->short_description, 100) }}</p>
                
                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <div class="flex items-center space-x-4">
                        <span class="text-xs text-gray-500 flex items-center">
                            <i class="far fa-clock mr-1"></i> {{ $puzzle->questions_count ?? 0 }} questions
                        </span>
                        <span class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-play mr-1"></i> {{ $puzzle->play_count ?? 0 }} plays
                        </span>
                    </div>
                    <a href="{{ route('puzzles.show', $puzzle->slug) }}" 
                       class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-900">
                        Play Now
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Replace the Popular Puzzles section -->
@if($popularPuzzles->count() > 0)
<div class="mb-8">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-800">Popular Puzzles</h2>
        <a href="{{ route('puzzles.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">View All →</a>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($popularPuzzles as $puzzle)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between mb-3">
                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                    @if($puzzle->difficulty == 'beginner') bg-green-100 text-green-700
                    @elseif($puzzle->difficulty == 'intermediate') bg-blue-100 text-blue-700
                    @elseif($puzzle->difficulty == 'advanced') bg-orange-100 text-orange-700
                    @else bg-red-100 text-red-700 @endif">
                    {{ ucfirst($puzzle->difficulty) }}
                </span>
                <div class="flex items-center text-sm text-gray-500">
                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                    <span>{{ $puzzle->rating ?? '4.5' }}</span>
                    <span class="mx-1">•</span>
                    <i class="fas fa-users mr-1"></i>
                    <span>{{ $puzzle->play_count ?? 0 }}</span>
                </div>
            </div>
            
            <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $puzzle->title }}</h3>
            <p class="text-sm text-gray-600 mb-4">{{ Str::limit($puzzle->short_description, 80) }}</p>
            
            <div class="flex items-center justify-between">
                <span class="text-xs text-gray-500 flex items-center">
                    <i class="far fa-clock mr-1"></i> {{ $puzzle->avg_completion_time ?? '10-15' }} mins
                </span>
                <a href="{{ route('puzzles.show', $puzzle->slug) }}" 
                   class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-900">
                    Play Now
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Replace the Recently Played section -->
@if(isset($recentlyPlayed) && $recentlyPlayed->count() > 0)
<div class="mb-8">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Recently Played</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($recentlyPlayed as $puzzle)
        <a href="{{ route('puzzles.show', $puzzle->slug) }}" 
           class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-300 hover:-translate-y-1 group">
            <div class="flex items-start justify-between">
                <div>
                    <h4 class="font-medium text-gray-900 group-hover:text-indigo-600">{{ $puzzle->title }}</h4>
                    <p class="text-xs text-gray-500 mt-1">{{ $puzzle->category->name ?? 'Uncategorized' }}</p>
                </div>
                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">
                    {{ $puzzle->last_played_at ? \Carbon\Carbon::parse($puzzle->last_played_at)->diffForHumans() : 'Recently' }}
                </span>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endif

<!-- Update the Global Leaderboard section -->
@if(isset($globalLeaderboard) && $globalLeaderboard->count() > 0)
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">Global Leaderboard</h2>
            <span class="text-xs text-gray-500">Updated daily</span>
        </div>
    </div>
    <div class="p-6">
        @foreach($globalLeaderboard as $index => $entry)
        <div class="flex items-center justify-between py-3 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-full 
                    @if($index == 0) bg-yellow-100
                    @elseif($index == 1) bg-gray-100
                    @elseif($index == 2) bg-orange-100
                    @else bg-gray-50 @endif
                    flex items-center justify-center mr-3">
                    <span class="text-sm font-bold 
                        @if($index == 0) text-yellow-600
                        @elseif($index == 1) text-gray-600
                        @elseif($index == 2) text-orange-600
                        @else text-gray-500 @endif">
                        #{{ $index + 1 }}
                    </span>
                </div>
                <div>
                    <p class="font-medium text-gray-900">{{ $entry->donor->firstname ?? 'Anonymous' }} {{ substr($entry->donor->lastname ?? '', 0, 1) }}.</p>
                    <p class="text-xs text-gray-500">
                        <span class="flex items-center">
                            <i class="fas fa-trophy mr-1 text-yellow-500"></i> 
                            {{ $entry->puzzles_mastered }} puzzles mastered
                        </span>
                    </p>
                </div>
            </div>
            <div class="text-right">
                <span class="font-bold text-indigo-600">{{ number_format($entry->total_score) }} pts</span>
                <p class="text-xs text-gray-500">total score</p>
            </div>
        </div>
        @endforeach
    </div>
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 text-center">
      <a href="{{ route('puzzles.leaderboard') }}" class="text-sm text-indigo-600 hover:text-indigo-900 font-medium">
    View Full Leaderboard
    <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
    </svg>
    </a>
    </div>
</div>
@endif 
    </div>
</div>
@endsection