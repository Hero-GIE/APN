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
    
    .difficulty-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
    }
    
    .stat-box {
        background: #f8fafc;
        border-radius: 12px;
        padding: 1rem;
        text-align: center;
        border: 1px solid #e2e8f0;
    }
    
    .attempt-card {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 1rem;
        transition: all 0.2s ease;
    }
    .attempt-card:hover {
        background: #f8fafc;
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
                <span class="text-gray-700">{{ $puzzle->title }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Puzzle Header -->
                <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                    @if($puzzle->featured_image)
                    <img src="{{ $puzzle->featured_image }}" class="w-full h-64 object-cover">
                    @else
                    <div class="w-full h-32 bg-gradient-to-r from-indigo-500 to-purple-600"></div>
                    @endif
                    
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3 flex-wrap gap-2">
                                <span class="difficulty-badge 
                                    @if($puzzle->difficulty == 'beginner') bg-green-100 text-green-800
                                    @elseif($puzzle->difficulty == 'intermediate') bg-blue-100 text-blue-800
                                    @elseif($puzzle->difficulty == 'advanced') bg-orange-100 text-orange-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($puzzle->difficulty) }}
                                </span>
                                @if($puzzle->is_featured)
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">
                                    Featured
                                </span>
                                @endif
                                @if($puzzle->requires_membership)
                                <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-semibold">
                                    Members Only
                                </span>
                                @endif
                                <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">
                                    <i class="far fa-clock mr-1"></i> {{ $puzzle->questions->count() }} questions
                                </span>
                            </div>
                            <span class="text-sm text-gray-500">
                                <i class="far fa-calendar mr-1"></i> {{ $puzzle->created_at->format('M d, Y') }}
                            </span>
                        </div>

                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $puzzle->title }}</h1>
                        
                        @if($puzzle->short_description)
                        <p class="text-lg text-gray-700 mb-4">{{ $puzzle->short_description }}</p>
                        @endif

                        @if($puzzle->description)
                        <div class="prose max-w-none mb-6 text-gray-600">
                            {!! nl2br(e($puzzle->description)) !!}
                        </div>
                        @endif
<!-- Action Buttons -->
<div class="flex space-x-4">
    @if($donor)
        @if($puzzle->type == 'quiz')
            <form action="{{ route('quiz.start', $puzzle->slug) }}" method="POST" class="flex-1">
                @csrf
                <button type="submit" class="w-full py-3 bg-green-600 text-white rounded-lg text-center font-semibold hover:bg-green-700 transition-colors">
                    <i class="fas fa-play mr-2"></i>Start Quiz
                </button>
            </form>
        @elseif($puzzle->type == 'wordsearch')
            <form action="{{ route('wordsearch.start', $puzzle->slug) }}" method="POST" class="flex-1">
                @csrf
                <button type="submit" class="w-full py-3 bg-green-600 text-white rounded-lg text-center font-semibold hover:bg-green-700 transition-colors">
                    <i class="fas fa-play mr-2"></i>Start Word Search
                </button>
            </form>
        @elseif($puzzle->can_play)
            <a href="{{ route('puzzles.start', $puzzle->slug) }}" 
               class="flex-1 py-3 bg-green-600 text-white rounded-lg text-center font-semibold hover:bg-green-700 transition-colors">
                <i class="fas fa-play mr-2"></i>Start Puzzle
            </a>
        @else
            <button disabled class="flex-1 py-3 bg-gray-400 text-white rounded-lg font-semibold cursor-not-allowed">
                No Attempts Left
            </button>
        @endif
    @else
        <a href="{{ route('donor.login') }}" 
           class="flex-1 py-3 bg-indigo-600 text-white rounded-lg text-center font-semibold hover:bg-indigo-700">
            <i class="fas fa-sign-in-alt mr-2"></i>Login to Play
        </a>
    @endif
</div>

                        @if($donor && $puzzle->attempts_allowed > 0)
                        <p class="text-sm text-gray-500 mt-3">
                            <i class="fas fa-info-circle mr-1"></i>
                            You have {{ $puzzle->remaining_attempts }} out of {{ $puzzle->attempts_allowed }} attempts remaining.
                        </p>
                        @endif
                    </div>
                </div>

                <!-- Statistics -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="stat-box">
                        <p class="text-sm text-gray-500">Questions</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $puzzle->questions->count() }}</p>
                    </div>
                    <div class="stat-box">
                        <p class="text-sm text-gray-500">Total Plays</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $puzzle->play_count }}</p>
                    </div>
                    <div class="stat-box">
                        <p class="text-sm text-gray-500">Avg. Score</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($puzzle->average_score, 1) }}%</p>
                    </div>
                    <div class="stat-box">
                        <p class="text-sm text-gray-500">Rating</p>
                        <p class="text-2xl font-bold text-yellow-500">{{ number_format($puzzle->average_rating, 1) }} ⭐</p>
                    </div>
                </div>

                <!-- Your Previous Attempts -->
                @if($userAttempts && $userAttempts->count() > 0)
                <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-800">Your Previous Attempts</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            @foreach($userAttempts as $attempt)
                            <div class="attempt-card flex flex-col sm:flex-row sm:items-center justify-between">
                                <div class="mb-2 sm:mb-0">
                                    <p class="font-medium text-gray-900">
                                        Attempt #{{ $attempt->attempt_number }}
                                        @if($attempt->completed)
                                            <span class="ml-2 text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">Completed</span>
                                        @else
                                            <span class="ml-2 text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">{{ ucfirst($attempt->status) }}</span>
                                        @endif
                                    </p>
                                    <p class="text-sm text-gray-500">{{ $attempt->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div class="text-right">
                                        <p class="text-lg font-bold text-indigo-600">{{ $attempt->score }}/{{ $attempt->max_score }}</p>
                                        <p class="text-sm text-gray-500">{{ $attempt->percentage }}%</p>
                                    </div>
                                    @if($attempt->completed)
                                    <a href="{{ route('puzzles.results', $attempt->id) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium whitespace-nowrap">
                                        View Results →
                                    </a>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Comments Section -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-800">Comments ({{ $comments->total() ?? 0 }})</h2>
                    </div>
                    <div class="p-6">
                        @if($donor)
                        <form action="{{ route('puzzles.comment', $puzzle->slug) }}" method="POST" class="mb-6">
                            @csrf
                            <textarea name="comment" rows="3" 
                                      class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                      placeholder="Share your thoughts about this puzzle..." required></textarea>
                            <div class="flex justify-end mt-3">
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                                    Post Comment
                                </button>
                            </div>
                        </form>
                        @else
                        <p class="text-center text-gray-500 mb-6">
                            <a href="{{ route('donor.login') }}" class="text-indigo-600 hover:underline">Login</a> to leave a comment.
                        </p>
                        @endif

                        @if(isset($comments) && $comments->count() > 0)
                            @foreach($comments as $comment)
                            <div class="border-b border-gray-100 last:border-0 py-4">
                                <div class="flex items-start">
                                    <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center mr-3 flex-shrink-0">
                                        <span class="text-indigo-600 font-semibold">
                                            {{ strtoupper(substr($comment->donor->firstname ?? 'A', 0, 1)) }}
                                        </span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-1">
                                            <p class="font-medium text-gray-900">
                                                {{ $comment->donor->firstname ?? 'Anonymous' }} {{ substr($comment->donor->lastname ?? '', 0, 1) }}.
                                            </p>
                                            <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                                        </div>
                                        <p class="text-gray-700">{{ $comment->comment }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                            @if($comments->hasPages())
                            <div class="mt-4">
                                {{ $comments->links() }}
                            </div>
                            @endif
                        @else
                        <p class="text-center text-gray-500 py-4">No comments yet. Be the first to comment!</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Quick Info Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Quick Info</h3>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Type:</span>
                            <span class="font-medium text-gray-900">{{ $puzzle->type_label ?? ucfirst(str_replace('_', ' ', $puzzle->type)) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Difficulty:</span>
                            <span class="font-medium 
                                @if($puzzle->difficulty == 'beginner') text-green-600
                                @elseif($puzzle->difficulty == 'intermediate') text-blue-600
                                @elseif($puzzle->difficulty == 'advanced') text-orange-600
                                @else text-red-600 @endif">
                                {{ ucfirst($puzzle->difficulty) }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Questions:</span>
                            <span class="font-medium text-gray-900">{{ $puzzle->questions->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Total Points:</span>
                            <span class="font-medium text-gray-900">{{ $puzzle->questions->sum('points') }}</span>
                        </div>
                        @if($puzzle->time_limit)
                        <div class="flex justify-between">
                            <span class="text-gray-500">Time Limit:</span>
                            <span class="font-medium text-gray-900">{{ floor($puzzle->time_limit / 60) }}:{{ str_pad($puzzle->time_limit % 60, 2, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-gray-500">Attempts Allowed:</span>
                            <span class="font-medium text-gray-900">{{ $puzzle->attempts_allowed }}</span>
                        </div>
                        @if($puzzle->category)
                        <div class="flex justify-between">
                            <span class="text-gray-500">Category:</span>
                            <span class="font-medium text-indigo-600">{{ $puzzle->category->name }}</span>
                        </div>
                        @endif
                    </div>

                    @if($donor && $userBestScore > 0)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <p class="text-sm text-gray-500 mb-1">Your Best Score</p>
                        <p class="text-2xl font-bold text-indigo-600">{{ $userBestScore }}/{{ $puzzle->questions->sum('points') }}</p>
                        @if($userRank)
                        <p class="text-sm text-gray-500 mt-1">Rank: #{{ $userRank }}</p>
                        @endif
                    </div>
                    @endif
                </div>

                <!-- Leaderboard -->
                @if(isset($leaderboard) && $leaderboard->count() > 0)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="font-semibold text-gray-800">Top Players</h3>
                    </div>
                    <div class="p-4">
                        @foreach($leaderboard as $entry)
                        <div class="flex items-center justify-between py-2 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                            <div class="flex items-center">
                                <span class="w-6 text-sm font-bold 
                                    @if($entry->rank == 1) text-yellow-500
                                    @elseif($entry->rank == 2) text-gray-400
                                    @elseif($entry->rank == 3) text-orange-600
                                    @else text-gray-500 @endif">
                                    #{{ $entry->rank }}
                                </span>
                                <span class="ml-2 text-sm text-gray-900">{{ $entry->donor->firstname ?? 'Anonymous' }}</span>
                            </div>
                            <span class="text-sm font-semibold text-indigo-600">{{ $entry->best_score }} pts</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Related Puzzles -->
                @if(isset($relatedPuzzles) && $relatedPuzzles->count() > 0)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="font-semibold text-gray-800">Related Puzzles</h3>
                    </div>
                    <div class="p-4">
                        @foreach($relatedPuzzles as $related)
                        <a href="{{ route('puzzles.show', $related->slug) }}" class="block py-2 hover:bg-gray-50 rounded px-2 -mx-2">
                            <p class="font-medium text-gray-900">{{ $related->title }}</p>
                            <p class="text-xs text-gray-500">{{ $related->questions->count() }} questions • {{ $related->play_count }} plays</p>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Rating Card -->
                @if($donor && !isset($userRating))
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-semibold text-gray-800 mb-3">Rate this Puzzle</h3>
                    <div class="flex items-center space-x-1 mb-3" id="ratingStars">
                        @for($i = 1; $i <= 5; $i++)
                        <button onclick="setRating({{ $i }})" class="text-2xl text-gray-300 hover:text-yellow-400 focus:outline-none rating-star" data-rating="{{ $i }}">
                            ★
                        </button>
                        @endfor
                    </div>
                    <textarea id="ratingReview" rows="2" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm mb-3" placeholder="Write a review (optional)"></textarea>
                    <button onclick="submitRating()" class="w-full py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm font-medium">
                        Submit Rating
                    </button>
                </div>
                @endif
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
let currentRating = 0;

function setRating(rating) {
    currentRating = rating;
    document.querySelectorAll('.rating-star').forEach((star, index) => {
        if (index < rating) {
            star.classList.remove('text-gray-300');
            star.classList.add('text-yellow-400');
        } else {
            star.classList.remove('text-yellow-400');
            star.classList.add('text-gray-300');
        }
    });
}


function submitRating() {
    if (currentRating === 0) {
        alert('Please select a rating');
        return;
    }
    
    const review = document.getElementById('ratingReview').value;
    
    fetch('{{ route("puzzles.rate", $puzzle->slug) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            rating: currentRating,
            review: review
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Thank you for rating!');
            location.reload();
        } else {
            alert('Error submitting rating');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error submitting rating');
    });
}
</script>
@endsection