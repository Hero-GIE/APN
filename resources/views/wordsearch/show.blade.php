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
    .breadcrumb-link {
        font-family: 'Open Sans', sans-serif;
        font-size: 0.95rem;
    }
    .difficulty-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .attempt-card {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 1rem;
        transition: all 0.2s ease;
    }
    .attempt-card:hover {
        background: #f8fafc;
    }
</style>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <div class="mb-8">
            <div class="flex items-center text-sm text-gray-500 mb-2 breadcrumb-link">
                @php
                    $donor = Auth::guard('donor')->user();
                @endphp
                @if($donor && \App\Models\Member::where('donor_id', $donor->id)->exists())
                    <a href="{{ route('member.dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                @else
                    <a href="{{ route('donor.dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                @endif
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <a href="{{ route('wordsearch.index') }}" class="hover:text-indigo-600">Word Search</a>
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700">{{ $puzzle->title }}</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 font-urbanist">{{ $puzzle->title }}</h1>
            <p class="text-gray-600 mt-2">{{ $puzzle->description }}</p>
        </div>

        <!-- Puzzle Details Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            @if($puzzle->featured_image)
           <div class="h-64 md:h-80 overflow-hidden rounded-lg">
    <img src="{{ $puzzle->featured_image }}" class="w-full h-full object-cover">
</div>
            @endif
            
            <div class="p-6">
                <!-- Stats Grid -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500">Words to Find</p>
                        <p class="text-xl font-bold text-gray-900">{{ count($puzzle->words) }}</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500">Grid Size</p>
                        <p class="text-xl font-bold text-gray-900">{{ $puzzle->grid_size }}x{{ $puzzle->grid_size }}</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500">Difficulty</p>
                        <p class="text-xl font-bold capitalize 
                            @if($puzzle->difficulty == 'beginner') text-green-600
                            @elseif($puzzle->difficulty == 'intermediate') text-blue-600
                            @else text-orange-600 @endif">
                            {{ $puzzle->difficulty }}
                        </p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500">Points</p>
                        <p class="text-xl font-bold text-indigo-600">{{ $puzzle->points }}</p>
                    </div>
                </div>

                <!-- Words to Find -->
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-800 mb-3 font-urbanist">Words to Find</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($puzzle->words as $word)
                        <span class="px-3 py-1 bg-gray-100 rounded-full text-sm text-gray-700">{{ $word }}</span>
                        @endforeach
                    </div>
                </div>

                <!-- User Best Score -->
                @if($userBestScore > 0)
                <div class="mb-6 p-4 bg-indigo-50 rounded-lg border border-indigo-100">
                    <p class="text-sm text-indigo-600">Your Best Score</p>
                    <p class="text-2xl font-bold text-indigo-700">{{ $userBestScore }}/{{ count($puzzle->words) }}</p>
                </div>
                @endif

                <!-- Previous Attempts -->
                @if($userAttempts->count() > 0)
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-800 mb-3 font-urbanist">Your Previous Attempts</h3>
                    <div class="space-y-2">
                        @foreach($userAttempts->take(3) as $attempt)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="text-sm text-gray-600">Attempt #{{ $loop->iteration }}</p>
                                <p class="text-xs text-gray-500">{{ $attempt->created_at->format('M d, Y') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-indigo-600">{{ $attempt->score }}/{{ count($puzzle->words) }}</p>
                                @if($attempt->time_taken)
                                <p class="text-xs text-gray-500">{{ $attempt->time_formatted }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3">
                    @if($donor)
                        <form action="{{ route('wordsearch.start', $puzzle->slug) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition-colors font-urbanist">
                                <i class="fas fa-play mr-2"></i> Start Puzzle
                            </button>
                        </form>
                    @else
                        <a href="{{ route('donor.login') }}" class="flex-1 py-3 bg-indigo-600 text-white rounded-lg text-center font-semibold hover:bg-indigo-700 transition-colors font-urbanist">
                            <i class="fas fa-sign-in-alt mr-2"></i> Login to Play
                        </a>
                    @endif
                    
                    <a href="{{ route('wordsearch.index') }}" class="flex-1 py-3 bg-gray-200 text-gray-700 rounded-lg text-center font-semibold hover:bg-gray-300 transition-colors font-urbanist">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Puzzles
                    </a>
                </div>
            </div>
        </div>

        <!-- Security Footer Note -->
        <div class="flex items-center justify-center gap-3 mt-8 text-xs text-gray-400">
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