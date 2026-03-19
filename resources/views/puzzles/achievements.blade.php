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
    
    .achievement-card {
        transition: all 0.3s ease;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        background: white;
        height: 100%;
        position: relative;
    }
    .achievement-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
    }
    .achievement-card.earned {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        border-color: #f59e0b;
    }
    .achievement-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 2rem;
    }
    .rarity-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    .progress-bar {
        height: 8px;
        background: #e2e8f0;
        border-radius: 4px;
        overflow: hidden;
        margin-top: 0.5rem;
    }
    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #3b82f6, #8b5cf6);
        transition: width 0.3s ease;
    }
    
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
    }
</style>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <div class="mb-6">
            <div class="flex items-center text-sm text-gray-500 mb-2 breadcrumb-link">
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
                <span class="text-gray-700">Achievements</span>
            </div>
        </div>

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Achievements</h1>
            <p class="text-gray-600 mt-2">Earn achievements by completing puzzles and demonstrating your knowledge of African heritage.</p>
        </div>

        <!-- Stats Summary -->
        @if($donor)
        @php
            $totalAchievements = $achievements->count();
            $earnedCount = $achievements->where('earned', true)->count();
            $progressPercentage = $totalAchievements > 0 ? round(($earnedCount / $totalAchievements) * 100) : 0;
        @endphp
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">Your Achievement Progress</h2>
                    <p class="text-gray-600">You've earned {{ $earnedCount }} of {{ $totalAchievements }} achievements</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <div class="flex items-center">
                        <span class="text-3xl font-bold text-indigo-600 mr-4">{{ $progressPercentage }}%</span>
                        <div class="w-48">
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: {{ $progressPercentage }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Filter Tabs -->
        <div class="mb-6 border-b border-gray-200">
            <div class="flex space-x-6">
                <button onclick="filterAchievements('all')" class="filter-btn active pb-3 px-1 text-sm font-medium text-indigo-600 border-b-2 border-indigo-600" data-filter="all">
                    All Achievements
                </button>
                <button onclick="filterAchievements('earned')" class="filter-btn pb-3 px-1 text-sm font-medium text-gray-500 hover:text-gray-700" data-filter="earned">
                    Earned
                </button>
                <button onclick="filterAchievements('locked')" class="filter-btn pb-3 px-1 text-sm font-medium text-gray-500 hover:text-gray-700" data-filter="locked">
                    Locked
                </button>
            </div>
        </div>

        <!-- Achievements Grid -->
        @if($achievements->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($achievements as $achievement)
            <div class="achievement-card {{ isset($achievement->earned) && $achievement->earned ? 'earned' : '' }}" 
                 data-earned="{{ isset($achievement->earned) && $achievement->earned ? 'true' : 'false' }}">
                
                <!-- Rarity Badge -->
                <span class="rarity-badge {{ $achievement->rarity_color ?? 'bg-gray-100 text-gray-800' }}">
                    {{ ucfirst($achievement->rarity) }}
                </span>

                <div class="p-6">
                    <!-- Icon -->
                    <div class="achievement-icon 
                        @if($achievement->rarity == 'common') bg-gray-100 text-gray-600
                        @elseif($achievement->rarity == 'rare') bg-blue-100 text-blue-600
                        @elseif($achievement->rarity == 'epic') bg-purple-100 text-purple-600
                        @elseif($achievement->rarity == 'legendary') bg-yellow-100 text-yellow-600
                        @else bg-indigo-100 text-indigo-600 @endif">
                        {!! $achievement->icon_html !!}
                    </div>

                    <!-- Title & Description -->
                    <h3 class="text-lg font-bold text-gray-900 text-center mb-2">{{ $achievement->name }}</h3>
                    <p class="text-sm text-gray-600 text-center mb-4">{{ $achievement->description }}</p>

                    <!-- Points -->
                    <div class="text-center mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                            <i class="fas fa-star mr-1"></i> {{ $achievement->points }} points
                        </span>
                    </div>

                    <!-- Earned Status -->
                    @if(isset($achievement->earned) && $achievement->earned)
                    <div class="text-center">
                        <span class="inline-flex items-center text-green-600 text-sm">
                            <i class="fas fa-check-circle mr-1"></i> Earned
                            @if($achievement->earned_at)
                                <span class="text-xs text-gray-500 ml-2">{{ \Carbon\Carbon::parse($achievement->earned_at)->format('M d, Y') }}</span>
                            @endif
                        </span>
                    </div>

                    @if(isset($achievement->progress))
                    <div class="mt-4">
                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                            <span>Progress</span>
                            <span>{{ $achievement->progress['current'] }}/{{ $achievement->progress['total'] }}</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $achievement->progress['percentage'] }}%"></div>
                        </div>
                    </div>
                    @endif
                    @else
                    <div class="text-center">
                        <span class="inline-flex items-center text-gray-400 text-sm">
                            <i class="fas fa-lock mr-1"></i> Locked
                        </span>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">No achievements available</h3>
            <p class="mt-2 text-gray-500">Check back later for new achievements to unlock.</p>
        </div>
        @endif

        <!-- Achievement Categories Info -->
        <div class="mt-8 bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">About Achievements</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="flex items-start space-x-3">
                    <div class="bg-gray-100 rounded-full p-2">
                        <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Common</p>
                        <p class="text-xs text-gray-500">Easy to earn, found by most players</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="bg-blue-100 rounded-full p-2">
                        <span class="w-2 h-2 bg-blue-400 rounded-full"></span>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Rare</p>
                        <p class="text-xs text-gray-500">Requires some dedication</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="bg-purple-100 rounded-full p-2">
                        <span class="w-2 h-2 bg-purple-400 rounded-full"></span>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Epic</p>
                        <p class="text-xs text-gray-500">Challenging to achieve</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="bg-yellow-100 rounded-full p-2">
                        <span class="w-2 h-2 bg-yellow-400 rounded-full"></span>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Legendary</p>
                        <p class="text-xs text-gray-500">The ultimate test of skill</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Security Footer Note -->
<div class="flex items-center justify-center gap-3 mt-8 text-xs text-gray-400">
    <i class="fas fa-circle text-yellow-500" style="font-size:0.35rem;"></i>
    <span>256-bit encrypted</span>
    <i class="fas fa-circle text-yellow-500" style="font-size:0.35rem;"></i>
    <span>Powered by Paystack</span>
    <i class="fas fa-circle text-yellow-500" style="font-size:0.35rem;"></i>
    <span>Secure transactions</span>
</div>

<script>
function filterAchievements(filter) {
    // Update active tab styling
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('text-indigo-600', 'border-indigo-600', 'active');
        btn.classList.add('text-gray-500');
        btn.style.borderBottomWidth = '0';
    });
    
    const activeBtn = document.querySelector(`.filter-btn[data-filter="${filter}"]`);
    activeBtn.classList.add('text-indigo-600', 'border-indigo-600', 'active');
    activeBtn.classList.remove('text-gray-500');
    activeBtn.style.borderBottomWidth = '2px';
    
    // Filter achievements
    const achievements = document.querySelectorAll('.achievement-card');
    
    achievements.forEach(card => {
        const earned = card.dataset.earned === 'true';
        
        if (filter === 'all') {
            card.style.display = 'block';
        } else if (filter === 'earned' && earned) {
            card.style.display = 'block';
        } else if (filter === 'locked' && !earned) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>
@endsection