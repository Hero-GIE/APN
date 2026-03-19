@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb Navigation -->
        <div class="mb-6">
            <nav class="flex items-center text-sm" style="font-family: 'Open Sans', sans-serif;">
                <a href="{{ route('member.dashboard') }}#news" class="text-gray-500 hover:text-indigo-600 transition-colors">Dashboard</a>
                <svg class="w-4 h-4 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-gray-900 font-medium">News</span>
            </nav>
        </div>

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900" style="font-family: 'Urbanist', sans-serif;">Latest News</h1>
            <p class="text-gray-600 mt-2" style="font-family: 'Open Sans', sans-serif;">Stay updated with the latest developments across Africa</p>
        </div>

        <!-- Featured News -->
        @if($featuredNews->count() > 0)
        <div class="mb-12">
            <h2 class="text-xl font-bold text-gray-800 mb-4" style="font-family: 'Urbanist', sans-serif;">Featured Stories</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($featuredNews as $featured)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                    @if($featured->featured_image)
                    <img src="{{ $featured->featured_image }}" alt="{{ $featured->title }}" class="w-full h-48 object-cover">
                    @endif
                    <div class="p-6">
                        <span class="text-xs 
                            @if($featured->category_color == 'indigo') text-indigo-600
                            @elseif($featured->category_color == 'green') text-green-600
                            @elseif($featured->category_color == 'blue') text-blue-600
                            @elseif($featured->category_color == 'purple') text-purple-600
                            @else text-indigo-600
                            @endif font-semibold uppercase tracking-wider" style="font-family: 'Urbanist', sans-serif;">
                            {{ $featured->category }}
                        </span>
                        <h3 class="text-lg font-bold text-gray-900 mt-2" style="font-family: 'Urbanist', sans-serif;">{{ $featured->title }}</h3>
                        <p class="text-gray-600 text-sm mt-2" style="font-family: 'Open Sans', sans-serif;">{{ Str::limit($featured->excerpt, 100) }}</p>
                        <div class="flex items-center justify-between mt-4">
                            <span class="text-xs text-gray-500" style="font-family: 'Open Sans', sans-serif;">{{ \Carbon\Carbon::parse($featured->published_date)->format('M d, Y') }}</span>
                            <a href="{{ route('member.news.show', ['slug' => $featured->slug, 'from' => 'dashboard']) }}" class="text-sm text-indigo-600 hover:text-indigo-900" style="font-family: 'Urbanist', sans-serif;">Read More →</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- All News -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($news as $newsItem)
            <div class="bg-white rounded-lg shadow p-6 hover:shadow-md transition-shadow">
                <span class="text-xs 
                    @if($newsItem->category_color == 'indigo') text-indigo-600
                    @elseif($newsItem->category_color == 'green') text-green-600
                    @elseif($newsItem->category_color == 'blue') text-blue-600
                    @elseif($newsItem->category_color == 'purple') text-purple-600
                    @else text-indigo-600
                    @endif font-semibold uppercase tracking-wider" style="font-family: 'Urbanist', sans-serif;">
                    {{ $newsItem->category }}
                </span>
                <h3 class="text-lg font-bold text-gray-900 mt-2" style="font-family: 'Urbanist', sans-serif;">{{ $newsItem->title }}</h3>
                <p class="text-gray-600 text-sm mt-2" style="font-family: 'Open Sans', sans-serif;">{{ $newsItem->excerpt }}</p>
                <div class="flex items-center justify-between mt-4">
                    <span class="text-xs text-gray-500" style="font-family: 'Open Sans', sans-serif;">{{ \Carbon\Carbon::parse($newsItem->published_date)->format('M d, Y') }}</span>
                    <a href="{{ route('member.news.show', ['slug' => $newsItem->slug, 'from' => 'dashboard']) }}" class="text-sm text-indigo-600 hover:text-indigo-900" style="font-family: 'Urbanist', sans-serif;">Read More →</a>
                </div>
            </div>
            @empty
            <div class="col-span-2 text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900" style="font-family: 'Urbanist', sans-serif;">No news articles</h3>
                <p class="mt-1 text-sm text-gray-500" style="font-family: 'Open Sans', sans-serif;">Check back later for updates.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($news->hasPages())
        <div class="mt-8">
            {{ $news->links() }}
        </div>
        @endif

        <!-- Mobile Bottom Navigation -->
        <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 md:hidden">
            <a href="{{ route('member.dashboard') }}#news" class="block w-full text-center px-4 py-2 bg-indigo-600 text-white rounded-lg" style="font-family: 'Urbanist', sans-serif;">
                ← Back to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection