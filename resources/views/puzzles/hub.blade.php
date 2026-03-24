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
    
    .game-card {
        transition: all 0.3s ease;
    }
    .game-card:hover {
        transform: translateY(-5px);
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
                <span class="text-gray-700">Games & Puzzles</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 font-urbanist">African Games & Puzzles</h1>
            <p class="text-gray-600 mt-2">Test your knowledge of African countries, capitals, heritage, and culture.</p>
        </div>

        <!-- Game Type Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Quiz Card -->
            <a href="{{ route('quiz.index') }}" 
               class="group bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 game-card">
                <div class="p-8 text-center">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-question-circle text-4xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2 font-urbanist">Quizzes</h3>
                    <p class="text-indigo-100 mb-4">Test your knowledge about African history, culture, and heritage.</p>
                    <span class="inline-flex items-center text-white font-medium group-hover:translate-x-2 transition-transform">
                        Browse Quizzes
                        <i class="fas fa-arrow-right ml-2"></i>
                    </span>
                </div>
            </a>

            <!-- Word Search Card -->
            <a href="{{ route('wordsearch.index') }}" 
               class="group bg-gradient-to-r from-gray-100 to-gray-300 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 game-card">
                <div class="p-8 text-center">
                    <div class="w-20 h-20 bg-black/10 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-search text-4xl text-black"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-black mb-2 font-urbanist">Word Search</h3>
                    <p class="text-black mb-4">Find hidden words about African countries, leaders, and cultural terms.</p>
                    <span class="inline-flex items-center text-black font-medium group-hover:translate-x-2 transition-transform">
                        Play Word Search
                        <i class="fas fa-arrow-right ml-2"></i>
                    </span>
                </div>
            </a>
        </div>

        <!-- Featured Word Searches Section -->
        @if(isset($featuredWordsearches) && $featuredWordsearches->count() > 0)
        <div class="mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 font-urbanist">Featured Word Searches</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($featuredWordsearches as $wordsearch)
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-md transition-all">
                    @if($wordsearch->featured_image)
                    <div class="h-32 overflow-hidden">
                        <img src="{{ $wordsearch->featured_image }}" class="w-full h-full object-cover">
                    </div>
                    @endif
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs px-2 py-1 rounded-full 
                                @if($wordsearch->difficulty == 'beginner') bg-green-100 text-green-700
                                @elseif($wordsearch->difficulty == 'intermediate') bg-blue-100 text-blue-700
                                @else bg-orange-100 text-orange-700 @endif">
                                {{ ucfirst($wordsearch->difficulty) }}
                            </span>
                            <span class="text-xs text-gray-500">{{ $wordsearch->words ? count($wordsearch->words) : 0 }} words</span>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-1 font-urbanist">{{ $wordsearch->title }}</h3>
                        <p class="text-xs text-gray-600 mb-3">{{ Str::limit($wordsearch->description, 70) }}</p>
                        <a href="{{ route('wordsearch.show', $wordsearch->slug) }}" class="text-indigo-600 text-sm font-medium hover:text-indigo-800">
                            Play Now →
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Popular Puzzles Section -->
        @if(isset($popularPuzzles) && $popularPuzzles->count() > 0)
        <div class="mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 font-urbanist">Popular Puzzles</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($popularPuzzles as $puzzle)
                <div class="bg-white rounded-lg border border-gray-200 p-4 hover:shadow-md transition-all">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs px-2 py-1 rounded-full 
                            @if($puzzle->difficulty == 'beginner') bg-green-100 text-green-700
                            @elseif($puzzle->difficulty == 'intermediate') bg-blue-100 text-blue-700
                            @elseif($puzzle->difficulty == 'advanced') bg-orange-100 text-orange-700
                            @else bg-red-100 text-red-700 @endif">
                            {{ ucfirst($puzzle->difficulty) }}
                        </span>
                        <div class="flex items-center text-xs text-yellow-500">
                            <i class="fas fa-star mr-1"></i>
                            <span>{{ number_format($puzzle->average_rating ?? 4.5, 1) }}</span>
                        </div>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1 font-urbanist">{{ $puzzle->title }}</h3>
                    <p class="text-xs text-gray-600 mb-3">{{ Str::limit($puzzle->short_description, 70) }}</p>
                    <a href="{{ route('puzzles.show', $puzzle->slug) }}" class="text-indigo-600 text-sm font-medium hover:text-indigo-800">
                        Play Now →
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Word Search Categories -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 font-urbanist">Word Search Categories</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <!-- All Word Searches Card -->
                <a href="{{ route('wordsearch.index') }}" class="bg-white rounded-lg border border-gray-200 p-4 hover:shadow-md transition-all hover:-translate-y-1 group">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-indigo-200 transition-colors">
                            <i class="fas fa-globe-africa text-indigo-600 text-xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-1 font-urbanist text-sm">All Puzzles</h3>
                        <p class="text-xs text-gray-500">Browse all word searches</p>
                        <div class="mt-2 text-indigo-600 text-xs font-medium group-hover:underline">
                            Explore →
                        </div>
                    </div>
                </a>

                <!-- Countries Card -->
                <a href="{{ route('wordsearch.index', ['category' => 'countries']) }}" class="bg-white rounded-lg border border-gray-200 p-4 hover:shadow-md transition-all hover:-translate-y-1 group">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-green-200 transition-colors">
                            <i class="fas fa-map text-green-600 text-xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-1 font-urbanist text-sm">Countries</h3>
                        <p class="text-xs text-gray-500">Find African nations</p>
                        <div class="mt-2 text-indigo-600 text-xs font-medium group-hover:underline">
                            Play →
                        </div>
                    </div>
                </a>

                <!-- Capitals Card -->
                <a href="{{ route('wordsearch.index', ['category' => 'capitals']) }}" class="bg-white rounded-lg border border-gray-200 p-4 hover:shadow-md transition-all hover:-translate-y-1 group">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-blue-200 transition-colors">
                            <i class="fas fa-city text-blue-600 text-xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-1 font-urbanist text-sm">Capitals</h3>
                        <p class="text-xs text-gray-500">Find capital cities</p>
                        <div class="mt-2 text-indigo-600 text-xs font-medium group-hover:underline">
                            Play →
                        </div>
                    </div>
                </a>

                <!-- Animals Card -->
                <a href="{{ route('wordsearch.index', ['category' => 'animals']) }}" class="bg-white rounded-lg border border-gray-200 p-4 hover:shadow-md transition-all hover:-translate-y-1 group">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-amber-200 transition-colors">
                            <i class="fas fa-paw text-amber-600 text-xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-1 font-urbanist text-sm">Animals</h3>
                        <p class="text-xs text-gray-500">African wildlife</p>
                        <div class="mt-2 text-indigo-600 text-xs font-medium group-hover:underline">
                            Play →
                        </div>
                    </div>
                </a>

                <!-- Landmarks Card -->
                <a href="{{ route('wordsearch.index', ['category' => 'landmarks']) }}" class="bg-white rounded-lg border border-gray-200 p-4 hover:shadow-md transition-all hover:-translate-y-1 group">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-purple-200 transition-colors">
                            <i class="fas fa-landmark text-purple-600 text-xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-1 font-urbanist text-sm">Landmarks</h3>
                        <p class="text-xs text-gray-500">Famous places</p>
                        <div class="mt-2 text-indigo-600 text-xs font-medium group-hover:underline">
                            Play →
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- View All Button -->
        <div class="text-center">
            <a href="{{ route('puzzles.index') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-medium font-urbanist">
                <i class="fas fa-th-large mr-2"></i>
                Browse All Games
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush
@endsection