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

    /* Breadcrumb styles */
    .breadcrumb-link {
        font-family: 'Open Sans', sans-serif;
        font-size: 0.95rem;
    }

    /* Featured Image Overlay Styles */
    .featured-image-container {
        position: relative;
        width: 100%;
        height: 450px;
        overflow: hidden;
    }
    
    .featured-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .featured-image:hover {
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
            rgba(0,0,0,0.4) 50%,
            rgba(0,0,0,0.8) 100%);
        pointer-events: none;
    }
    
    .image-overlay-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 2.5rem;
        color: white;
        transform: translateY(0);
        transition: transform 0.3s ease;
    }
    
    .image-overlay-content .category-badge {
        display: inline-block;
        padding: 0.4rem 1.2rem;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
        border: 1px solid rgba(255,255,255,0.3);
        font-family: 'Urbanist', sans-serif;
    }
    
    .image-overlay-content h1 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.75rem;
        line-height: 1.2;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        font-family: 'Urbanist', sans-serif;
    }
    
    .image-overlay-content .meta {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        font-size: 0.95rem;
        font-family: 'Open Sans', sans-serif;
        opacity: 0.9;
    }
    
    .image-overlay-content .meta i {
        margin-right: 0.5rem;
    }

    /* All News Sidebar Styles */
    .news-sidebar {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
        overflow: hidden;
        position: sticky;
        top: 1rem;
        max-height: calc(100vh - 2rem);
        display: flex;
        flex-direction: column;
    }
    
    .news-sidebar-header {
        padding: 1.25rem;
        border-bottom: 1px solid #e5e7eb;
        background: #f9fafb;
    }
    
    .news-sidebar-header h3 {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1f2937;
        font-family: 'Urbanist', sans-serif;
        margin-bottom: 0.25rem;
    }
    
    .news-sidebar-header p {
        font-size: 0.85rem;
        color: #6b7280;
        font-family: 'Open Sans', sans-serif;
    }
    
    .news-sidebar-content {
        flex: 1;
        overflow-y: auto;
        padding: 1rem;
        scrollbar-width: thin;
        scrollbar-color: #4f46e5 #e5e7eb;
        max-height: 600px;
    }
    
    .news-sidebar-content::-webkit-scrollbar {
        width: 6px;
    }
    
    .news-sidebar-content::-webkit-scrollbar-track {
        background: #e5e7eb;
        border-radius: 3px;
    }
    
    .news-sidebar-content::-webkit-scrollbar-thumb {
        background: #4f46e5;
        border-radius: 3px;
    }
    
    .news-sidebar-content::-webkit-scrollbar-thumb:hover {
        background: #4338ca;
    }
    
    .sidebar-news-item {
        display: flex;
        gap: 0.75rem;
        padding: 0.75rem;
        border-radius: 0.5rem;
        transition: all 0.2s ease;
        margin-bottom: 0.75rem;
        cursor: pointer;
        border: 1px solid transparent;
        text-decoration: none;
    }
    
    .sidebar-news-item:hover {
        background: #f3f4f6;
        border-color: #e5e7eb;
    }
    
    .sidebar-news-item.active {
        background: #eef2ff;
        border-color: #4f46e5;
    }
    
    .sidebar-news-item .item-image {
        width: 70px;
        height: 70px;
        border-radius: 0.5rem;
        overflow: hidden;
        flex-shrink: 0;
    }
    
    .sidebar-news-item .item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .sidebar-news-item .item-content {
        flex: 1;
    }
    
    .sidebar-news-item .item-category {
        font-size: 0.7rem;
        font-weight: 600;
        color: #4f46e5;
        font-family: 'Urbanist', sans-serif;
        margin-bottom: 0.25rem;
        display: block;
    }
    
    .sidebar-news-item .item-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: #1f2937;
        font-family: 'Urbanist', sans-serif;
        margin-bottom: 0.25rem;
        line-height: 1.3;
    }
    
    .sidebar-news-item .item-date {
        font-size: 0.7rem;
        color: #6b7280;
        font-family: 'Open Sans', sans-serif;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    /* Main content styles */
    .main-content {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
        overflow: hidden;
    }
    
    .news-content {
        padding: 2rem;
    }
    
    .prose {
        font-family: 'Open Sans', sans-serif;
        line-height: 1.8;
        color: #374151;
    }
    
    .prose p {
        margin-bottom: 1.25rem;
    }
    
    /* News Count Badge */
    .news-count {
        display: inline-block;
        background: #eef2ff;
        color: #4f46e5;
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-left: 0.5rem;
    }
    
    /* Responsive */
    @media (max-width: 1024px) {
        .featured-image-container {
            height: 400px;
        }
        
        .image-overlay-content h1 {
            font-size: 2rem;
        }
    }
    
    @media (max-width: 768px) {
        .featured-image-container {
            height: 350px;
        }
        
        .image-overlay-content {
            padding: 1.5rem;
        }
        
        .image-overlay-content h1 {
            font-size: 1.5rem;
        }
        
        .image-overlay-content .meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        
        .news-sidebar {
            position: static;
            max-height: none;
            margin-bottom: 1.5rem;
        }
        
        .news-sidebar-content {
            max-height: 400px;
        }
    }
    
    @media (max-width: 640px) {
        .featured-image-container {
            height: 300px;
        }
        
        .image-overlay-content h1 {
            font-size: 1.25rem;
        }
        
        .sidebar-news-item .item-image {
            width: 50px;
            height: 50px;
        }
    }
</style>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <div class="mb-6">
            <div class="flex items-center text-sm text-gray-500 mb-2 breadcrumb-link">
                <a href="{{ route('member.dashboard') }}#news" class="hover:text-indigo-600">Dashboard</a>
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <a href="{{ route('member.news.index') }}" class="hover:text-indigo-600">News</a>
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700">Article</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Left Sidebar - All News -->
            <div class="lg:col-span-1">
                <div class="news-sidebar">
                    <div class="news-sidebar-header">
                        <div class="flex items-center justify-between">
                            <h3>All News</h3>
                            <span class="news-count">{{ $allNews->count() + 1 }} articles</span>
                        </div>
                        <p>Browse our latest articles</p>
                    </div>
                    <div class="news-sidebar-content" id="newsSidebar">
                        <!-- Current Article (shown first) -->
                        <a href="{{ route('member.news.show', $news->slug) }}" 
                           class="sidebar-news-item active">
                            <div class="item-image">
                                @if($news->featured_image)
                                <img src="{{ $news->featured_image }}" alt="{{ $news->title }}">
                                @else
                                <img src="https://images.unsplash.com/photo-1585829365295-ab7cd400c4c7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Default news image">
                                @endif
                            </div>
                            <div class="item-content">
                                <span class="item-category">{{ $news->category }}</span>
                                <h4 class="item-title">{{ Str::limit($news->title, 50) }}</h4>
                                <span class="item-date">
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    {{ $news->published_date->format('M d, Y') }}
                                </span>
                            </div>
                        </a>

                        <!-- All Other News -->
                        @forelse($allNews as $newsItem)
                        <a href="{{ route('member.news.show', $newsItem->slug) }}" 
                           class="sidebar-news-item">
                            <div class="item-image">
                                @if($newsItem->featured_image)
                                <img src="{{ $newsItem->featured_image }}" alt="{{ $newsItem->title }}">
                                @else
                                <img src="https://images.unsplash.com/photo-1585829365295-ab7cd400c4c7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Default news image">
                                @endif
                            </div>
                            <div class="item-content">
                                <span class="item-category">{{ $newsItem->category }}</span>
                                <h4 class="item-title">{{ Str::limit($newsItem->title, 50) }}</h4>
                                <span class="item-date">
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    {{ $newsItem->published_date->format('M d, Y') }}
                                </span>
                            </div>
                        </a>
                        @empty
                        <p class="text-gray-500 text-sm text-center py-4">No other news available</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Main Content - Current Article -->
            <div class="lg:col-span-3">
                <div class="main-content">
                    <!-- Article with Enhanced Featured Image -->
                    @if($news->featured_image)
                    <div class="featured-image-container">
                        <img src="{{ $news->featured_image }}" alt="{{ $news->title }}" class="featured-image">
                        <div class="image-overlay"></div>
                        <div class="image-overlay-content">
                            <span class="category-badge">
                                <i class="fas fa-newspaper mr-2"></i>
                                {{ $news->category }}
                            </span>
                            <h1>{{ $news->title }}</h1>
                            <div class="meta">
                                @if($news->author)
                                <span><i class="far fa-user"></i> {{ $news->author }}</span>
                                @endif
                                <span><i class="far fa-calendar-alt"></i> {{ $news->published_date->format('F j, Y') }}</span>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="news-content">
                        <div class="prose max-w-none">
                            {!! nl2br(e($news->content)) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Smooth scroll to active item in sidebar
        const activeItem = document.querySelector('.sidebar-news-item.active');
        const sidebar = document.getElementById('newsSidebar');
        
        if (activeItem && sidebar) {
            const itemOffset = activeItem.offsetTop;
            const sidebarHeight = sidebar.clientHeight;
            const itemHeight = activeItem.clientHeight;
            
            sidebar.scrollTo({
                top: itemOffset - (sidebarHeight / 2) + (itemHeight / 2),
                behavior: 'smooth'
            });
        }
    });
</script>
@endpush
@endsection