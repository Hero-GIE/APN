@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb Navigation -->
        <div class="mb-6">
            <nav class="flex items-center text-sm" style="font-family: 'Open Sans', sans-serif;">
                <a href="{{ route('member.dashboard') }}#calendar" class="text-gray-500 hover:text-indigo-600 transition-colors">Dashboard</a>
                <svg class="w-4 h-4 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-gray-900 font-medium">Events</span>
            </nav>
        </div>

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900" style="font-family: 'Urbanist', sans-serif;">Events Calendar</h1>
            <p class="text-gray-600 mt-2" style="font-family: 'Open Sans', sans-serif;">Discover upcoming events, conferences, and webinars</p>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <form method="GET" action="{{ route('member.events.index') }}" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-2" style="font-family: 'Urbanist', sans-serif;">Category</label>
                    <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" style="font-family: 'Open Sans', sans-serif;">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-2" style="font-family: 'Urbanist', sans-serif;">Event Type</label>
                    <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" style="font-family: 'Open Sans', sans-serif;">
                        <option value="">All Types</option>
                        @foreach($types as $type)
                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700" style="font-family: 'Urbanist', sans-serif;">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>

        <!-- Events List -->
        <div class="space-y-4">
            @forelse($events as $event)
            <div class="bg-white rounded-lg shadow p-6 hover:shadow-md transition-shadow">
                <div class="flex flex-wrap items-start gap-4">
                    <div class="bg-indigo-50 rounded-lg p-4 text-center min-w-[100px]">
                        <span class="block text-3xl font-bold text-indigo-600" style="font-family: 'Urbanist', sans-serif;">{{ $event->start_date->format('d') }}</span>
                        <span class="text-sm text-gray-600" style="font-family: 'Open Sans', sans-serif;">{{ $event->start_date->format('M Y') }}</span>
                    </div>
                    <div class="flex-1">
                        <div class="flex flex-wrap items-start justify-between gap-2">
                            <h3 class="text-xl font-bold text-gray-900" style="font-family: 'Urbanist', sans-serif;">{{ $event->title }}</h3>
                            @if($event->badge_type)
                            <span class="px-3 py-1 {{ $event->badge_color_class }} rounded-full text-xs font-semibold" style="font-family: 'Urbanist', sans-serif;">
                                {{ $event->badge_type }}
                            </span>
                            @endif
                        </div>
                        <p class="text-gray-600 mt-2" style="font-family: 'Open Sans', sans-serif;">{{ $event->description }}</p>
                        <div class="flex flex-wrap items-center gap-4 mt-4">
                            <span class="text-sm text-gray-500" style="font-family: 'Open Sans', sans-serif;">
                                <i class="far fa-clock mr-1"></i> {{ $event->start_date->format('g:i A') }} - {{ $event->end_date->format('g:i A T') }}
                            </span>
                            <span class="text-sm text-gray-500" style="font-family: 'Open Sans', sans-serif;">
                                <i class="fas fa-map-marker-alt mr-1"></i> {{ $event->location }}
                            </span>
                            @if($event->is_free_for_members)
                            <span class="text-sm text-green-600" style="font-family: 'Open Sans', sans-serif;">
                                <i class="fas fa-tag mr-1"></i> Free for Members
                            </span>
                            @endif
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('member.events.show', ['slug' => $event->slug, 'from' => 'dashboard']) }}" class="text-indigo-600 hover:text-indigo-900 font-medium" style="font-family: 'Urbanist', sans-serif;">
                                View Details →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-12">
                <p class="text-gray-500" style="font-family: 'Open Sans', sans-serif;">No events found matching your criteria.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $events->withQueryString()->links() }}
        </div>

        <!-- Mobile Bottom Navigation -->
        <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 md:hidden">
            <a href="{{ route('member.dashboard') }}#calendar" class="block w-full text-center px-4 py-2 bg-indigo-600 text-white rounded-lg" style="font-family: 'Urbanist', sans-serif;">
                ← Back to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection