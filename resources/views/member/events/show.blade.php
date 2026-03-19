@extends('layouts.guest')

@section('content')
<style>
    /* Additional styles for overlay */
    .event-image-container {
        position: relative;
        width: 100%;
        height: 400px;
        overflow: hidden;
    }
    
    .event-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .event-image:hover {
        transform: scale(1.02);
    }
    
    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, 
            rgba(0,0,0,0.2) 0%,
            rgba(0,0,0,0.5) 50%,
            rgba(0,0,0,0.9) 100%);
        pointer-events: none;
    }
    
    .overlay-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 2.5rem;
        color: white;
        z-index: 10;
    }
    
    .overlay-badge {
        display: inline-block;
        padding: 0.4rem 1.2rem;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(10px);
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 1rem;
        border: 1px solid rgba(255,255,255,0.3);
        font-family: 'Urbanist', sans-serif;
    }
    
    .overlay-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        line-height: 1.2;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        font-family: 'Urbanist', sans-serif;
    }
    
    .overlay-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        font-size: 1rem;
        font-family: 'Open Sans', sans-serif;
        opacity: 0.9;
    }
    
    .overlay-meta i {
        margin-right: 0.5rem;
    }
    
    @media (max-width: 768px) {
        .event-image-container {
            height: 350px;
        }
        
        .overlay-content {
            padding: 1.5rem;
        }
        
        .overlay-title {
            font-size: 1.8rem;
        }
        
        .overlay-meta {
            flex-direction: column;
            gap: 0.5rem;
        }
    }
    
    @media (max-width: 640px) {
        .event-image-container {
            height: 300px;
        }
        
        .overlay-title {
            font-size: 1.5rem;
        }
    }
</style>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <a href="{{ route('member.dashboard') }}" 
           class="inline-flex items-center text-gray-600 hover:text-indigo-600 mb-6" 
           id="backButton"
           style="font-family: 'Open Sans', sans-serif;">
            <span id="backButtonText">Back to Dashboard</span>
        </a>

        <!-- Event Details with Enhanced Image -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            @if($event->featured_image)
            <div class="event-image-container">
                <img src="{{ $event->featured_image }}" alt="{{ $event->title }}" class="event-image">
                <div class="image-overlay"></div>
                <div class="overlay-content">
                    <div class="flex flex-wrap items-center gap-2 mb-3">
                        <span class="overlay-badge">
                            <i class="fas fa-tag mr-2"></i>
                            {{ $event->category }}
                        </span>
                        @if($event->badge_type)
                        <span class="overlay-badge" style="background: rgba(79, 70, 229, 0.3);">
                            {{ $event->badge_type }}
                        </span>
                        @endif
                    </div>
                    <h1 class="overlay-title">{{ $event->title }}</h1>
                    <div class="overlay-meta">
                        <span><i class="far fa-calendar-alt"></i> {{ $event->formatted_start_date_time }}</span>
                        <span><i class="fas fa-map-marker-alt"></i> {{ $event->location }}</span>
                        @if($event->organizer)
                        <span><i class="far fa-user"></i> {{ $event->organizer }}</span>
                        @endif
                    </div>
                </div>
            </div>
            @else
            <div class="h-48 bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center">
                <h1 class="text-3xl font-bold text-white px-8 text-center" style="font-family: 'Urbanist', sans-serif;">{{ $event->title }}</h1>
            </div>
            @endif
            
            <div class="p-8">
                <!-- Categories moved to overlay, so removed from here -->
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="flex items-start space-x-3">
                        <div class="bg-indigo-50 rounded-lg p-3">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div style="font-family: 'Open Sans', sans-serif;">
                            <p class="text-sm text-gray-500">Date & Time</p>
                            <p class="font-medium">{{ $event->formatted_start_date_time }}</p>
                            <p class="text-sm text-gray-500">to {{ $event->formatted_end_date_time }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-3">
                        <div class="bg-indigo-50 rounded-lg p-3">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div style="font-family: 'Open Sans', sans-serif;">
                            <p class="text-sm text-gray-500">Location</p>
                            <p class="font-medium">{{ $event->location }}</p>
                            @if($event->venue && $event->city)
                            <p class="text-sm text-gray-500">{{ $event->venue }}, {{ $event->city }}, {{ $event->country }}</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-3">
                        <div class="bg-indigo-50 rounded-lg p-3">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div style="font-family: 'Open Sans', sans-serif;">
                            <p class="text-sm text-gray-500">Organizer</p>
                            <p class="font-medium">{{ $event->organizer }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-3">
                        <div class="bg-indigo-50 rounded-lg p-3">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div style="font-family: 'Open Sans', sans-serif;">
                            <p class="text-sm text-gray-500">Capacity</p>
                            <p class="font-medium">{{ $event->capacity ?? 'Unlimited' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="border-t border-b border-gray-200 py-6 my-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4" style="font-family: 'Urbanist', sans-serif;">About This Event</h2>
                    <p class="text-gray-700" style="font-family: 'Open Sans', sans-serif;">{{ $event->description }}</p>
                </div>
                
                <div class="flex flex-wrap gap-4">
                    @if($event->price > 0)
                    <div class="bg-gray-50 rounded-lg px-6 py-3">
                        <p class="text-sm text-gray-500" style="font-family: 'Open Sans', sans-serif;">Price</p>
                        <p class="text-2xl font-bold text-gray-900" style="font-family: 'Urbanist', sans-serif;">${{ number_format($event->price, 2) }}</p>
                        @if($event->is_free_for_members)
                        <p class="text-xs text-green-600" style="font-family: 'Open Sans', sans-serif;">Free for members</p>
                        @endif
                    </div>
                    @else
                    <div class="bg-green-50 rounded-lg px-6 py-3">
                        <p class="text-sm text-gray-500" style="font-family: 'Open Sans', sans-serif;">Price</p>
                        <p class="text-2xl font-bold text-green-600" style="font-family: 'Urbanist', sans-serif;">Free</p>
                    </div>
                    @endif
                    
                    <div class="flex-1 flex justify-end items-center">
                        <a href="{{ $event->registration_url ?: '#' }}" class="px-8 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium" style="font-family: 'Urbanist', sans-serif;">
                            Register for Event
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Events -->
        @if($upcomingEvents->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6" style="font-family: 'Urbanist', sans-serif;">More Upcoming Events</h2>
            <div class="space-y-4">
                @foreach($upcomingEvents as $upcoming)
                <div class="bg-white rounded-lg shadow p-6 flex items-start space-x-4 hover:shadow-md transition-shadow">
                    <div class="bg-indigo-50 rounded-lg p-3 text-center min-w-[80px]">
                        <span class="block text-2xl font-bold text-indigo-600" style="font-family: 'Urbanist', sans-serif;">{{ $upcoming->start_date->format('d') }}</span>
                        <span class="text-xs text-gray-600" style="font-family: 'Open Sans', sans-serif;">{{ $upcoming->start_date->format('M') }}</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-900" style="font-family: 'Urbanist', sans-serif;">
                            <a href="{{ route('member.events.show', $upcoming->slug) }}" class="hover:text-indigo-600">
                                {{ $upcoming->title }}
                            </a>
                        </h3>
                        <p class="text-sm text-gray-600" style="font-family: 'Open Sans', sans-serif;">{{ $upcoming->location }}</p>
                    </div>
                    <a href="{{ route('member.events.show', $upcoming->slug) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium" style="font-family: 'Urbanist', sans-serif;">
                        View Details →
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const backButton = document.getElementById('backButton');
        const backText = document.getElementById('backButtonText');
        
        if (window.location.hash === '#from-dashboard-calendar') {
            backButton.href = '{{ route("member.dashboard") }}#calendar';
            backText.textContent = '← Back to Dashboard (Events)';
        } else {
            backButton.href = '{{ route("member.events.index") }}';
            backText.textContent = '← Back to Events';
        }
    });
</script>
@endpush
@endsection