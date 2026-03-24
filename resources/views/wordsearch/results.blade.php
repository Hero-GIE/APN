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
                <span class="text-gray-700">Results</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 font-urbanist">Word Search Results</h1>
            <p class="text-gray-600 mt-2">See how you performed on {{ $puzzle->title }}</p>
        </div>

        <!-- Main Content Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-8">
                <!-- Score Section -->
                <div class="text-center mb-8">
                    @php
                        $percentage = ($attempt->score / $totalWords) * 100;
                        $grade = $percentage >= 90 ? 'A' : ($percentage >= 70 ? 'B' : ($percentage >= 50 ? 'C' : ($percentage >= 30 ? 'D' : 'F')));
                    @endphp
                    <div class="score-circle grade-{{ $grade }} mb-4">
                        {{ $attempt->score }}/{{ $totalWords }}
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">
                        You found {{ $attempt->score }} out of {{ $totalWords }} words
                    </h2>
                    <p class="text-gray-600">
                        Grade: <span class="font-bold text-{{ $grade == 'A' ? 'green' : ($grade == 'B' ? 'blue' : ($grade == 'C' ? 'orange' : ($grade == 'D' ? 'yellow' : 'red'))) }}-600">{{ $grade }}</span> • 
                        Time: {{ $attempt->time_formatted }}
                    </p>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <div class="bg-green-50 rounded-lg p-4 text-center">
                        <p class="text-sm text-green-600 mb-1">Words Found</p>
                        <p class="text-2xl font-bold text-green-700">{{ $attempt->score }}</p>
                    </div>
                    <div class="bg-red-50 rounded-lg p-4 text-center">
                        <p class="text-sm text-red-600 mb-1">Words Missed</p>
                        <p class="text-2xl font-bold text-red-700">{{ $totalWords - $attempt->score }}</p>
                    </div>
                    <div class="bg-indigo-50 rounded-lg p-4 text-center">
                        <p class="text-sm text-indigo-600 mb-1">Accuracy</p>
                        <p class="text-2xl font-bold text-indigo-700">{{ round($scorePercentage, 1) }}%</p>
                    </div>
                </div>

                <!-- Words Found List -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 font-urbanist">Words Found</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($attempt->found_words as $word)
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">
                            {{ $word }}
                        </span>
                        @endforeach
                    </div>
                </div>

                <!-- Words Missed List -->
                @if($totalWords - $attempt->score > 0)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 font-urbanist">Words to Practice</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($puzzle->words as $word)
                            @if(!in_array($word, $attempt->found_words))
                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm">
                                {{ $word }}
                            </span>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-center space-x-3">
                <a href="{{ route('wordsearch.show', $puzzle->slug) }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition-colors">
                    ← Back to Puzzle
                </a>
                
                <a href="{{ route('wordsearch.start', $puzzle->slug) }}" 
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition-colors">
                    Try Again
                </a>
                
                <a href="{{ route('wordsearch.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition-colors">
                    More Puzzles
                </a>
            </div>

            <!-- Share Results -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <p class="text-sm text-gray-500 mb-3 text-center">Share your result:</p>
                <div class="flex justify-center space-x-3">
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode("I found {$attempt->score} out of {$totalWords} words in the {$puzzle->title}!") }}&url={{ urlencode(route('wordsearch.show', $puzzle->slug)) }}" 
                       target="_blank"
                       class="w-10 h-10 bg-blue-400 text-white rounded-full flex items-center justify-center hover:bg-blue-500 transition-colors">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('wordsearch.show', $puzzle->slug)) }}" 
                       target="_blank"
                       class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('wordsearch.show', $puzzle->slug)) }}&title={{ urlencode("I found {$attempt->score} out of {$totalWords} words in the {$puzzle->title}!") }}" 
                       target="_blank"
                       class="w-10 h-10 bg-blue-700 text-white rounded-full flex items-center justify-center hover:bg-blue-800 transition-colors">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Security Footer Note -->
        <div class="flex items-center justify-center gap-3 mt-8 text-xs text-gray-400">
            <i class="fas fa-circle text-yellow-500" style="font-size:0.35rem;"></i>
            <span>Let's begin</span>
            <i class="fas fa-circle text-yellow-500" style="font-size:0.35rem;"></i>
            <span>One love, One Africa</span>
            <i class="fas fa-circle text-yellow-500" style="font-size:0.35rem;"></i>
            <span>Finish with excitement</span>
        </div>
    </div>
</div>
@endsection