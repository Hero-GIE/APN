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
    
    .rank-1 { background: linear-gradient(135deg, #fbbf24, #f59e0b); }
    .rank-2 { background: linear-gradient(135deg, #94a3b8, #64748b); }
    .rank-3 { background: linear-gradient(135deg, #f97316, #ea580c); }
    
    .leaderboard-card {
        transition: all 0.3s ease;
    }
    .leaderboard-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
    }
</style>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <div class="mb-6">
            <div class="flex items-center text-sm text-gray-500 mb-2">
                @if($donor && \App\Models\Member::where('donor_id', $donor->id)->exists())
                    <a href="{{ route('member.dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                @else
                    <a href="{{ route('donor.dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                @endif
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <a href="{{ route('puzzles.hub') }}" class="hover:text-indigo-600">Puzzles</a>
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700">Global Leaderboard</span>
            </div>
        </div>

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Global Leaderboard</h1>
            <p class="text-gray-600 mt-2">Top players ranked by total puzzle scores</p>
        </div>

        <!-- User's Rank (if logged in) -->
        @if($donor && $userRank)
        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg p-6 mb-8 border border-indigo-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-indigo-600 mb-1">Your Current Rank</p>
                    <p class="text-3xl font-bold text-indigo-900">#{{ $userRank }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600 mb-1">Total Score</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($leaderboard->where('donor_id', $donor->id)->first()?->total_score ?? 0) }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Leaderboard Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-800">Top Players</h2>
                    <span class="text-xs text-gray-500">Updated daily</span>
                </div>
            </div>
            
            <div class="divide-y divide-gray-200">
                @foreach($leaderboard as $index => $entry)
                <div class="leaderboard-card p-4 {{ $donor && $entry->donor_id == $donor->id ? 'bg-indigo-50' : 'hover:bg-gray-50' }}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center flex-1">
                            <!-- Rank Badge -->
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mr-4
                                @if($index == 0) rank-1 text-white
                                @elseif($index == 1) rank-2 text-white
                                @elseif($index == 2) rank-3 text-white
                                @else bg-gray-100 text-gray-700 @endif">
                                <span class="text-xl font-bold">#{{ $loop->iteration }}</span>
                            </div>
                            
                            <!-- Player Info -->
                            <div class="flex-1">
                                <div class="flex items-center">
                                    <p class="font-semibold text-gray-900">
                                        {{ $entry->donor->firstname ?? 'Anonymous' }} {{ substr($entry->donor->lastname ?? '', 0, 1) }}.
                                    </p>
                                    @if($entry->donor && $entry->donor->member)
                                    <span class="ml-2 px-2 py-0.5 bg-purple-100 text-purple-700 text-xs rounded-full">
                                        Member
                                    </span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-500">
                                    <i class="fas fa-trophy mr-1 text-yellow-500"></i>
                                    {{ $entry->puzzles_mastered }} puzzles mastered
                                </p>
                            </div>
                        </div>
                        
                        <!-- Score -->
                        <div class="text-right">
                            <p class="text-2xl font-bold text-indigo-600">{{ number_format($entry->total_score) }}</p>
                            <p class="text-xs text-gray-500">total points</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $leaderboard->links() }}
            </div>
        </div>

        <!-- Category Champions -->
        @if(isset($topCategories) && $topCategories->count() > 0)
        <div class="mt-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Category Champions</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($topCategories as $category)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center mb-4">
                        @if($category->icon)
                        <i class="{{ $category->icon }} text-2xl mr-3" style="color: {{ $category->color }}"></i>
                        @endif
                        <h3 class="font-semibold text-gray-900">{{ $category->name }}</h3>
                    </div>
                    
                    @php
                        $topPlayer = $category->puzzles->flatMap->leaderboards->sortByDesc('best_score')->first();
                    @endphp
                    
                    @if($topPlayer && $topPlayer->donor)
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-900">{{ $topPlayer->donor->firstname ?? 'Anonymous' }}</p>
                            <p class="text-xs text-gray-500">{{ $topPlayer->best_score }} points</p>
                        </div>
                        <span class="text-yellow-500">👑</span>
                    </div>
                    @else
                    <p class="text-sm text-gray-500">No champion yet</p>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Back to Puzzles -->
        <div class="text-center mt-8">
            <a href="{{ route('puzzles.hub') }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                ← Back to Puzzles
            </a>
        </div>
    </div>
</div>
@endsection