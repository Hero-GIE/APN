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
    .puzzle-card {
        transition: all 0.3s ease;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        overflow: hidden;
        background: white;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .puzzle-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
    }
    .puzzle-card:hover .image-overlay {
        transform: scale(1.05);
    }
    .difficulty-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .image-container {
        position: relative;
        overflow: hidden;
        height: 200px;
        flex-shrink: 0;
    }
    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(
            to bottom,
            rgba(0, 0, 0, 0.1) 0%,
            rgba(0, 0, 0, 0.3) 50%,
            rgba(0, 0, 0, 0.6) 100%
        );
        transition: transform 0.3s ease;
        z-index: 1;
    }
    .card-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .puzzle-card:hover .card-image {
        transform: scale(1.1);
    }
    .card-content {
        padding: 1.25rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .card-footer {
        margin-top: auto;
        padding-top: 0.75rem;
        border-top: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
</style>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
                <a href="{{ route('puzzles.hub') }}" class="hover:text-indigo-600">Games & Puzzles</a>
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700">Word Search</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 font-urbanist">Word Search Puzzles</h1>
            <p class="text-gray-600 mt-2">Find hidden words about African countries, culture, and heritage.</p>
        </div>

        <!-- Puzzles Grid -->
        @if($puzzles->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($puzzles as $puzzle)
            <div class="puzzle-card">
                @if($puzzle->featured_image)
                <div class="image-container">
                    <img src="{{ $puzzle->featured_image }}" class="card-image" alt="{{ $puzzle->title }}">
                    <div class="image-overlay"></div>
                </div>
                @endif
                <div class="card-content">
                    <div class="flex items-center justify-between mb-3">
                        <span class="difficulty-badge 
                            @if($puzzle->difficulty == 'beginner') bg-green-100 text-green-800
                            @elseif($puzzle->difficulty == 'intermediate') bg-blue-100 text-blue-800
                            @elseif($puzzle->difficulty == 'advanced') bg-orange-100 text-orange-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($puzzle->difficulty) }}
                        </span>
                        <div class="flex items-center text-xs text-gray-500">
                            <i class="fas fa-search mr-1"></i> {{ count($puzzle->words) }} words
                        </div>
                    </div>
                    
                    <h3 class="text-lg font-bold text-gray-900 mb-2 font-urbanist">{{ $puzzle->title }}</h3>
                    <p class="text-sm text-gray-600 mb-4 flex-1">{{ Str::limit($puzzle->description, 100) }}</p>
                    
                    <div class="card-footer">
                        <div class="flex items-center text-xs text-gray-500">
                            <i class="fas fa-play mr-1"></i> {{ $puzzle->play_count }} plays
                        </div>
                        <a href="{{ route('wordsearch.show', $puzzle->slug) }}" 
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors">
                            Play Now
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $puzzles->links() }}
        </div>
        @else
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900 font-urbanist">No word search puzzles available</h3>
            <p class="mt-2 text-gray-500">Check back soon for new puzzles.</p>
        </div>
        @endif

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