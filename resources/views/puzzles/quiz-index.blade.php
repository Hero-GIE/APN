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
    
    .breadcrumb-link {
        font-family: 'Open Sans', sans-serif;
        font-size: 0.95rem;
    }
</style>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <div class="mb-6">
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
                <a href="{{ route('puzzles.hub') }}" class="hover:text-indigo-600">Games & Puzzles</a>
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700">Quizzes</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 font-urbanist">African Quizzes</h1>
            <p class="text-gray-600 mt-2">Test your knowledge about African history, culture, and heritage.</p>
        </div>

        <!-- Quizzes Grid -->
        @if($quizzes->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($quizzes as $quiz)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-all hover:-translate-y-1">
                @if($quiz->featured_image)
                <div class="h-40 overflow-hidden">
                    <img src="{{ $quiz->featured_image }}" class="w-full h-full object-cover">
                </div>
                @endif
                <div class="p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full 
                            @if($quiz->difficulty == 'beginner') bg-green-100 text-green-700
                            @elseif($quiz->difficulty == 'intermediate') bg-blue-100 text-blue-700
                            @elseif($quiz->difficulty == 'advanced') bg-orange-100 text-orange-700
                            @else bg-red-100 text-red-700 @endif">
                            {{ ucfirst($quiz->difficulty) }}
                        </span>
                        <div class="flex items-center text-xs text-gray-500">
                            <i class="fas fa-question-circle mr-1"></i> {{ $quiz->questions->count() }} questions
                        </div>
                    </div>
                    
                    <h3 class="text-lg font-bold text-gray-900 mb-2 font-urbanist">{{ $quiz->title }}</h3>
                    <p class="text-sm text-gray-600 mb-4">{{ Str::limit($quiz->short_description, 100) }}</p>
                    
                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                        <div class="flex items-center text-xs text-gray-500">
                            <i class="fas fa-play mr-1"></i> {{ $quiz->play_count }} plays
                        </div>
                        <a href="{{ route('quiz.show', $quiz->slug) }}" 
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors font-urbanist">
                            Take Quiz
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $quizzes->links() }}
        </div>
        @else
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900 font-urbanist">No quizzes available</h3>
            <p class="mt-2 text-gray-500">Check back soon for new quizzes.</p>
        </div>
        @endif
    </div>
</div>
@endsection