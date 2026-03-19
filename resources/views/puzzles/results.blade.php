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
    
    .section-title {
        font-family: 'Urbanist', sans-serif;
        font-size: 1.2rem;
        font-weight: 600;
    }
    
    .stat-label {
        font-size: 0.8rem;
        letter-spacing: 0.02em;
    }
    
    .stat-value {
        font-size: 1.65rem;
        font-family: 'Urbanist', sans-serif;
        font-weight: 600;
    }
    
    .score-circle {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: bold;
        margin: 0 auto;
    }
    .grade-A { background: #10b981; color: white; }
    .grade-B { background: #3b82f6; color: white; }
    .grade-C { background: #f59e0b; color: white; }
    .grade-D { background: #f97316; color: white; }
    .grade-F { background: #ef4444; color: white; }
    
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
        .score-circle {
            width: 120px;
            height: 120px;
            font-size: 2rem;
        }
    }
    
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin {
        animation: spin 1s linear infinite;
    }
</style>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header with breadcrumb -->
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
                <a href="{{ route('puzzles.hub') }}" class="hover:text-indigo-600">Puzzles</a>
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <a href="{{ route('puzzles.show', $puzzle->slug) }}" class="hover:text-indigo-600">{{ $puzzle->title }}</a>
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700">Results</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Quiz Results</h1>
            <p class="text-gray-600 mt-2">See how you performed on {{ $puzzle->title }}</p>
        </div>

        <!-- Main Content Card -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <!-- Header -->
            <div class="px-8 py-12 text-center text-black">
                <h1 class="text-3xl font-bold mb-2">Quiz Complete!</h1>
                <p class="text-gray-900">{{ $puzzle->title }}</p>
            </div>

            <!-- Content -->
            <div class="p-6 space-y-6">
                <!-- Score Section -->
                <div class="text-center mb-8">
                    <div class="score-circle grade-{{ $attempt->grade['grade'] }} mb-4">
                        {{ $attempt->score }}/{{ $attempt->max_score }}
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">
                        You scored {{ $attempt->percentage }}%
                    </h2>
                    <p class="text-gray-600">
                        Grade: <span class="font-bold text-{{ $attempt->grade['color'] }}-600">{{ $attempt->grade['grade'] }}</span> • 
                        Time: {{ $attempt->time_formatted }} • 
                        Correct: {{ $attempt->correct_answers_count }}/{{ count($attempt->feedback) }}
                    </p>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <div class="bg-green-50 rounded-lg p-4 text-center">
                        <p class="text-sm text-green-600 mb-1 stat-label">Correct Answers</p>
                        <p class="text-2xl font-bold text-green-700">{{ $attempt->correct_answers_count }}</p>
                    </div>
                    <div class="bg-red-50 rounded-lg p-4 text-center">
                        <p class="text-sm text-red-600 mb-1 stat-label">Incorrect Answers</p>
                        <p class="text-2xl font-bold text-red-700">{{ $attempt->incorrect_answers_count }}</p>
                    </div>
                    <div class="bg-indigo-50 rounded-lg p-4 text-center">
                        <p class="text-sm text-indigo-600 mb-1 stat-label">Accuracy</p>
                        <p class="text-2xl font-bold text-indigo-700">{{ $attempt->percentage }}%</p>
                    </div>
                </div>

                <!-- Achievements Earned -->
                @if($achievementsEarned->count() > 0)
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 section-title">Achievements Unlocked!</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($achievementsEarned as $achievement)
                        <div class="flex items-center p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                            <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                                <i class="{{ $achievement->icon }} text-yellow-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">{{ $achievement->name }}</h4>
                                <p class="text-xs text-gray-600">{{ $achievement->description }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Question Review -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 section-title">Question Review</h3>
                    <div class="space-y-4">
                        @foreach($attempt->feedback as $index => $feedback)
                            @if(isset($feedback['is_bonus'])) @continue @endif
                            <div class="border rounded-lg overflow-hidden">
                                <div class="p-4 {{ $feedback['is_correct'] ? 'bg-green-50' : 'bg-red-50' }}">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 mr-3">
                                            @if($feedback['is_correct'])
                                                <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                            @else
                                                <svg class="h-5 w-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-medium text-gray-900 mb-2">
                                                Question {{ $index + 1 }}: {{ $feedback['question'] }}
                                            </p>
                                            <div class="grid grid-cols-2 gap-4 text-sm mb-2">
                                                <div>
                                                    <p class="text-gray-500">Your answer:</p>
                                                    <p class="{{ $feedback['is_correct'] ? 'text-green-600' : 'text-red-600' }}">
                                                        {{ $feedback['user_answer'] ?: 'No answer' }}
                                                    </p>
                                                </div>
                                                @if(!$feedback['is_correct'])
                                                <div>
                                                    <p class="text-gray-500">Correct answer:</p>
                                                    <p class="text-green-600">{{ $feedback['correct_answer'] }}</p>
                                                </div>
                                                @endif
                                            </div>
                                            @if($feedback['explanation'])
                                            <p class="text-sm text-gray-600 mt-2 p-3 bg-white rounded">
                                                <span class="font-medium">Explanation:</span> {{ $feedback['explanation'] }}
                                            </p>
                                            @endif
                                            @if($feedback['fun_fact'])
                                            <p class="text-sm text-indigo-600 mt-2">
                                                <i class="fas fa-lightbulb mr-1"></i> {{ $feedback['fun_fact'] }}
                                            </p>
                                            @endif
                                        </div>
                                        <div class="ml-4 text-right">
                                            <span class="text-sm font-medium {{ $feedback['is_correct'] ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $feedback['points_earned'] }}/{{ $feedback['max_points'] }} pts
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-center space-x-3">
                <a href="{{ route('puzzles.show', $puzzle->slug) }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    ← Back to Puzzle
                </a>
                
                @if($puzzle->can_play)
                <a href="{{ route('puzzles.start', $puzzle->slug) }}" 
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Try Again
                </a>
                @endif
                
                <a href="{{ route('puzzles.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    More Puzzles
                </a>
            </div>

            <!-- Share Results -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <p class="text-sm text-gray-500 mb-3 text-center">Share your result:</p>
                <div class="flex justify-center space-x-3">
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($shareData['title']) }}&url={{ urlencode($shareData['url']) }}&hashtags={{ $shareData['hashtags'] }}" 
                       target="_blank"
                       class="w-10 h-10 bg-blue-400 text-white rounded-full flex items-center justify-center hover:bg-blue-500 transition-colors">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareData['url']) }}" 
                       target="_blank"
                       class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($shareData['url']) }}&title={{ urlencode($shareData['title']) }}" 
                       target="_blank"
                       class="w-10 h-10 bg-blue-700 text-white rounded-full flex items-center justify-center hover:bg-blue-800 transition-colors">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection