@extends('layouts.guest')

@section('content')
<style>
    body {
        font-family: 'Open Sans', sans-serif;
        font-size: 16px;
        line-height: 1.6;
    }
    h1, h2, h3, h4, h5, h6 {
        font-family: 'Urbanist', sans-serif;
    }
    .puzzle-card {
        transition: all 0.3s ease;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        background: white;
        height: 100%;
    }
    .puzzle-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
    }
    .filter-active {
        background: #3b82f6;
        color: white;
        border-color: #3b82f6;
    }
</style>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center text-sm text-gray-500 mb-2">
                <a href="{{ route('puzzles.hub') }}" class="hover:text-indigo-600">Puzzles</a>
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700">All Puzzles</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">All Puzzles</h1>
            <p class="text-gray-600 mt-2">Browse and filter our collection of African puzzles and games.</p>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <form method="GET" action="{{ route('puzzles.index') }}" id="filterForm">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Category Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <select name="category" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Type Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                        <select name="type" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">All Types</option>
                            @foreach($types as $key => $type)
                                <option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Difficulty Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Difficulty</label>
                        <select name="difficulty" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">All Difficulties</option>
                            @foreach($difficulties as $key => $difficulty)
                                <option value="{{ $key }}" {{ request('difficulty') == $key ? 'selected' : '' }}>
                                    {{ $difficulty }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Membership Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Access</label>
                        <select name="membership" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">All</option>
                            <option value="free" {{ request('membership') == 'free' ? 'selected' : '' }}>Free</option>
                            <option value="member" {{ request('membership') == 'member' ? 'selected' : '' }}>Members Only</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-between items-center mt-4">
                    <!-- Search -->
                    <div class="flex-1 max-w-md">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search puzzles..." 
                               class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <!-- Sort and Actions -->
                    <div class="flex space-x-3">
                        <select name="sort" class="rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Featured</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                            <option value="difficulty_asc" {{ request('sort') == 'difficulty_asc' ? 'selected' : '' }}>Difficulty (Low to High)</option>
                            <option value="difficulty_desc" {{ request('sort') == 'difficulty_desc' ? 'selected' : '' }}>Difficulty (High to Low)</option>
                        </select>

                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                            Apply Filters
                        </button>
                        
                        <a href="{{ route('puzzles.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Results Count -->
        <div class="mb-4">
            <p class="text-sm text-gray-600">Showing {{ $puzzles->firstItem() ?? 0 }} - {{ $puzzles->lastItem() ?? 0 }} of {{ $puzzles->total() }} puzzles</p>
        </div>

        <!-- Puzzles Grid -->
        @if($puzzles->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($puzzles as $puzzle)
            <div class="puzzle-card">
                @if($puzzle->featured_image)
                <img src="{{ $puzzle->featured_image }}" class="w-full h-48 object-cover">
                @endif
                <div class="p-6">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <span class="difficulty-badge 
                                @if($puzzle->difficulty == 'beginner') bg-green-100 text-green-800
                                @elseif($puzzle->difficulty == 'intermediate') bg-blue-100 text-blue-800
                                @elseif($puzzle->difficulty == 'advanced') bg-orange-100 text-orange-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($puzzle->difficulty) }}
                            </span>
                            @if($puzzle->is_featured)
                            <span class="ml-2 text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">Featured</span>
                            @endif
                        </div>
                        @if($puzzle->requires_membership)
                        <span class="text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded-full">Member Only</span>
                        @endif
                    </div>

                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $puzzle->title }}</h3>
                    
                    @if($puzzle->category)
                    <p class="text-xs text-indigo-600 mb-2">{{ $puzzle->category->name }}</p>
                    @endif
                    
                    <p class="text-sm text-gray-600 mb-4">{{ Str::limit($puzzle->short_description, 100) }}</p>

                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                        <span><i class="far fa-question-circle mr-1"></i> {{ $puzzle->questions_count ?? 0 }} questions</span>
                        <span><i class="fas fa-star mr-1 text-yellow-400"></i> {{ number_format($puzzle->average_rating, 1) }} ({{ $puzzle->total_ratings }})</span>
                        <span><i class="fas fa-play mr-1"></i> {{ $puzzle->play_count }}</span>
                    </div>

                    <div class="flex space-x-3">
                        <a href="{{ route('puzzles.show', $puzzle->slug) }}" 
                           class="flex-1 text-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm font-medium">
                            View Details
                        </a>
                        @if($puzzle->can_play)
                        <a href="{{ route('puzzles.start', $puzzle->slug) }}" 
                           class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-medium">
                            Play
                        </a>
                        @endif
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
            <h3 class="mt-4 text-lg font-medium text-gray-900">No puzzles found</h3>
            <p class="mt-2 text-gray-500">Try adjusting your filters or check back later for new puzzles.</p>
        </div>
        @endif
    </div>
</div>

<script>
document.getElementById('filterForm').addEventListener('change', function() {
    this.submit();
});
</script>
@endsection