<?php

namespace App\Http\Controllers;

use App\Models\Puzzle;
use App\Models\PuzzleCategory;
use App\Models\PuzzleAttempt;
use App\Models\PuzzleLeaderboard;
use App\Models\PuzzleAchievement;
use App\Models\PuzzleComment;
use App\Models\PuzzleRating;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PuzzleController extends Controller
{
    protected $puzzleTypes = [
        'country_puzzle' => 'Country Identification',
        'flag_match' => 'Flag Matching',
        'capital_quiz' => 'Capital Cities',
        'heritage_quiz' => 'Heritage & Culture',
        'timeline' => 'Historical Timeline',
        'map_puzzle' => 'Map Puzzle',
    ];

    protected $difficultyLevels = [
        'beginner' => 'Beginner',
        'intermediate' => 'Intermediate',
        'advanced' => 'Advanced',
        'expert' => 'Expert',
    ];

    /**
     * Display puzzle hub with categories and featured puzzles
     */
    public function hub()
    {
        $donor = Auth::guard('donor')->user();
        $member = null;
        
        if ($donor) {
            $member = Member::where('donor_id', $donor->id)->first();
        }
        
        $categories = PuzzleCategory::withCount(['puzzles' => function($query) {
            $query->where('is_active', true);
        }])->active()->get();
        
        $featuredPuzzles = Puzzle::with('category')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();
        
        $recentlyPlayed = collect();
        if ($donor) {
            $recentlyPlayed = PuzzleAttempt::with('puzzle.category')
                ->where('donor_id', $donor->id)
                ->where('completed', true)
                ->orderBy('created_at', 'desc')
                ->limit(4)
                ->get()
                ->map(function($attempt) {
                    return $attempt->puzzle;
                });
        }
        
        $popularPuzzles = Puzzle::with('category')
            ->where('is_active', true)
            ->orderBy('play_count', 'desc')
            ->limit(6)
            ->get();
        
        $newPuzzles = Puzzle::with('category')
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();
        
        $featuredQuizzes = Puzzle::where('type', 'quiz')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        
        $userStats = null;
        if ($donor) {
            $userStats = [
                'total_attempts' => PuzzleAttempt::where('donor_id', $donor->id)->count(),
                'completed' => PuzzleAttempt::where('donor_id', $donor->id)->where('completed', true)->count(),
                'total_score' => PuzzleAttempt::where('donor_id', $donor->id)->sum('score'),
                'average_score' => round(PuzzleAttempt::where('donor_id', $donor->id)->avg('score') ?? 0, 2),
                'achievements' => DB::table('donor_achievements')->where('donor_id', $donor->id)->count(),
                'rank' => $this->getUserRank($donor->id),
            ];
        }
        
        $globalLeaderboard = PuzzleLeaderboard::with('donor')
            ->select('donor_id', DB::raw('SUM(best_score) as total_score'), DB::raw('COUNT(*) as puzzles_mastered'))
            ->groupBy('donor_id')
            ->orderBy('total_score', 'desc')
            ->limit(10)
            ->get();
        
        return view('puzzles.hub', compact(
            'categories',
            'featuredPuzzles',
            'recentlyPlayed',
            'popularPuzzles',
            'newPuzzles',
            'donor',
            'member',
            'userStats',
            'globalLeaderboard',
            'featuredQuizzes'
        ));
    }

 /**
 * Display puzzle listing with filters
 */
public function index(Request $request)
{
    $donor = Auth::guard('donor')->user();
    $member = $donor ? Member::where('donor_id', $donor->id)->first() : null;
    
    // Get regular puzzles
    $regularPuzzles = Puzzle::with('category')
        ->where('is_active', true)
        ->get()
        ->map(function($puzzle) {
            $puzzle->puzzle_type = 'regular';
            $puzzle->questions_count = $puzzle->questions->count();
            return $puzzle;
        });
    
    // Get word search puzzles
    $wordSearchPuzzles = \App\Models\WordSearchPuzzle::where('is_active', true)
        ->get()
        ->map(function($puzzle) {
            $puzzle->puzzle_type = 'wordsearch';
            $puzzle->questions_count = count($puzzle->words);
            $puzzle->short_description = $puzzle->description;
            $puzzle->category = null;
            return $puzzle;
        });
    
    // Combine both collections
    $allPuzzles = $regularPuzzles->concat($wordSearchPuzzles);
    
    // Apply filters
    if ($request->filled('category')) {
        $allPuzzles = $allPuzzles->filter(function($puzzle) use ($request) {
            return $puzzle->category && $puzzle->category->id == $request->category;
        });
    }
    
    if ($request->filled('type')) {
        $allPuzzles = $allPuzzles->filter(function($puzzle) use ($request) {
            if ($request->type == 'wordsearch' && $puzzle->puzzle_type == 'wordsearch') {
                return true;
            }
            if ($request->type != 'wordsearch' && $puzzle->puzzle_type == 'regular' && $puzzle->type == $request->type) {
                return true;
            }
            return false;
        });
    }
    
    if ($request->filled('difficulty')) {
        $allPuzzles = $allPuzzles->filter(function($puzzle) use ($request) {
            return $puzzle->difficulty == $request->difficulty;
        });
    }
    
    if ($request->filled('search')) {
        $searchTerm = strtolower($request->search);
        $allPuzzles = $allPuzzles->filter(function($puzzle) use ($searchTerm) {
            return str_contains(strtolower($puzzle->title), $searchTerm) ||
                   str_contains(strtolower($puzzle->short_description ?? ''), $searchTerm);
        });
    }
    
    if ($request->filled('membership') && $request->membership === 'member') {
        $allPuzzles = $allPuzzles->filter(function($puzzle) {
            return $puzzle->requires_membership ?? false;
        });
    } elseif ($request->filled('membership') && $request->membership === 'free') {
        $allPuzzles = $allPuzzles->filter(function($puzzle) {
            return !($puzzle->requires_membership ?? false);
        });
    }
    
    // Apply sorting
    $sort = $request->get('sort', 'featured');
    $allPuzzles = match($sort) {
        'newest' => $allPuzzles->sortByDesc('created_at'),
        'popular' => $allPuzzles->sortByDesc('play_count'),
        'rating' => $allPuzzles->sortByDesc('average_rating'),
        'difficulty_asc' => $allPuzzles->sortBy(function($puzzle) {
            return array_search($puzzle->difficulty, ['beginner', 'intermediate', 'advanced', 'expert']);
        }),
        'difficulty_desc' => $allPuzzles->sortByDesc(function($puzzle) {
            return array_search($puzzle->difficulty, ['beginner', 'intermediate', 'advanced', 'expert']);
        }),
        default => $allPuzzles->sortByDesc('is_featured')->sortByDesc('created_at'),
    };
    
    // Paginate the combined results
    $page = $request->get('page', 1);
    $perPage = 12;
    $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
        $allPuzzles->forPage($page, $perPage),
        $allPuzzles->count(),
        $perPage,
        $page,
        ['path' => $request->url(), 'query' => $request->query()]
    );
    
    $categories = PuzzleCategory::active()->get();
    $types = array_merge($this->puzzleTypes, ['wordsearch' => 'Word Search']);
    $difficulties = $this->difficultyLevels;
    
    return view('puzzles.index', compact('paginated', 'categories', 'types', 'difficulties', 'donor', 'member'));
}

    /**
     * Display global leaderboard
     */
    public function globalLeaderboard()
    {
        $donor = Auth::guard('donor')->user();
        
        $leaderboard = PuzzleLeaderboard::with('donor')
            ->select('donor_id', DB::raw('SUM(best_score) as total_score'), DB::raw('COUNT(*) as puzzles_mastered'))
            ->groupBy('donor_id')
            ->orderBy('total_score', 'desc')
            ->paginate(20);
        
        $userRank = null;
        if ($donor) {
            $allRanks = PuzzleLeaderboard::with('donor')
                ->select('donor_id', DB::raw('SUM(best_score) as total_score'))
                ->groupBy('donor_id')
                ->orderBy('total_score', 'desc')
                ->get();
            
            $userRank = $allRanks->search(function($item) use ($donor) {
                return $item->donor_id == $donor->id;
            });
            $userRank = $userRank !== false ? $userRank + 1 : null;
        }
        
        $topCategories = PuzzleCategory::withCount('puzzles')
            ->with(['puzzles' => function($query) {
                $query->with(['leaderboards' => function($q) {
                    $q->orderBy('best_score', 'desc')->take(1);
                }]);
            }])
            ->take(5)
            ->get();
        
        return view('puzzles.leaderboard', compact('leaderboard', 'donor', 'userRank', 'topCategories'));
    }

    /**
     * Display single puzzle
     */
    public function show($slug)
    {
        $donor = Auth::guard('donor')->user();
        $member = $donor ? Member::where('donor_id', $donor->id)->first() : null;
        
        $puzzle = Puzzle::with(['category', 'questions' => function($query) {
            $query->where('is_active', true)->orderBy('order');
        }])->where('slug', $slug)->firstOrFail();
        
        if ($puzzle->requires_membership && !$member) {
            return redirect()->route('puzzles.index')->with('error', 'This puzzle is for members only.');
        }
        
        $userAttempts = collect();
        $userBestScore = 0;
        $userBestTime = null;
        $userRank = null;
        
        if ($donor) {
            $userAttempts = PuzzleAttempt::where('donor_id', $donor->id)
                ->where('puzzle_id', $puzzle->id)
                ->orderBy('created_at', 'desc')
                ->get();
            
            $userBestScore = $userAttempts->where('completed', true)->max('score') ?? 0;
            $bestTimeAttempt = $userAttempts->where('completed', true)->sortBy('time_taken')->first();
            $userBestTime = $bestTimeAttempt?->time_taken;
            
            $leaderboardEntry = PuzzleLeaderboard::where('puzzle_id', $puzzle->id)
                ->where('donor_id', $donor->id)
                ->first();
            $userRank = $leaderboardEntry?->rank;
        }
        
        $leaderboard = PuzzleLeaderboard::with('donor')
            ->where('puzzle_id', $puzzle->id)
            ->whereNotNull('rank')
            ->orderBy('rank')
            ->limit(10)
            ->get();
        
        $comments = PuzzleComment::with('donor')
            ->where('puzzle_id', $puzzle->id)
            ->where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        $relatedPuzzles = $puzzle->getRelatedPuzzles(3);
        
        $userRating = null;
        if ($donor) {
            $userRating = PuzzleRating::where('puzzle_id', $puzzle->id)
                ->where('donor_id', $donor->id)
                ->first();
        }
        
        if (!session()->has("puzzle_viewed_{$puzzle->id}")) {
            $puzzle->increment('play_count');
            session()->put("puzzle_viewed_{$puzzle->id}", true);
        }
        
        return view('puzzles.show', compact('puzzle', 'donor', 'member', 'userAttempts', 'userBestScore', 'userBestTime', 'userRank', 'leaderboard', 'comments', 'relatedPuzzles', 'userRating'));
    }

    /**
     * Start a puzzle attempt (handles puzzle types)
     */
    public function start($slug)
    {
        $donor = Auth::guard('donor')->user();
        
        if (!$donor) {
            return redirect()->route('donor.login')->with('error', 'Please log in to play puzzles.');
        }
        
        $puzzle = Puzzle::where('slug', $slug)->where('is_active', true)->firstOrFail();
        
        // Redirect to specific game type routes
        if ($puzzle->type === 'quiz') {
            return redirect()->route('quiz.show', $puzzle->slug);
        }
        
        return $this->startGenericPuzzle($puzzle, $donor);
    }

    /**
     * Start a quiz attempt
     */
    public function quizStart($slug)
    {
        $donor = Auth::guard('donor')->user();
        
        if (!$donor) {
            return redirect()->route('donor.login')->with('error', 'Please log in to play quizzes.');
        }
        
        $quiz = Puzzle::where('slug', $slug)->where('type', 'quiz')->where('is_active', true)->firstOrFail();
        return $this->startGenericPuzzle($quiz, $donor);
    }

    /**
     * Generic method to start any puzzle attempt
     */
    protected function startGenericPuzzle($puzzle, $donor)
    {
        $member = Member::where('donor_id', $donor->id)->first();
        
        if ($puzzle->requires_membership && !$member) {
            return redirect()->route('puzzles.show', $puzzle->slug)->with('error', 'This puzzle is for members only.');
        }
        
        $attemptCount = PuzzleAttempt::where('donor_id', $donor->id)->where('puzzle_id', $puzzle->id)->count();
        
        if ($attemptCount >= $puzzle->attempts_allowed && $puzzle->attempts_allowed > 0) {
            return redirect()->route('puzzles.show', $puzzle->slug)->with('error', 'Maximum attempts reached.');
        }
        
        $inProgress = PuzzleAttempt::where('donor_id', $donor->id)
            ->where('puzzle_id', $puzzle->id)
            ->where('status', 'in_progress')
            ->first();
        
        if ($inProgress) {
            return redirect()->route('puzzles.play', ['attempt' => $inProgress->id]);
        }
        
        $attempt = PuzzleAttempt::create([
            'donor_id' => $donor->id,
            'member_id' => $member?->id,
            'puzzle_id' => $puzzle->id,
            'session_id' => Str::random(40),
            'max_score' => $puzzle->questions->sum('points'),
            'attempt_number' => $attemptCount + 1,
            'status' => 'in_progress',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'started_at' => now(),
        ]);
        
        return redirect()->route('puzzles.play', ['attempt' => $attempt->id]);
    }

    /**
     * Play puzzle (unified method)
     */
    public function play($attemptId)
    {
        $donor = Auth::guard('donor')->user();
        
        if (!$donor) {
            return redirect()->route('donor.login');
        }
        
        $attempt = PuzzleAttempt::with('puzzle')
            ->where('id', $attemptId)
            ->where('donor_id', $donor->id)
            ->where('status', 'in_progress')
            ->firstOrFail();
        
        $puzzle = $attempt->puzzle;
        $questions = $puzzle->questions()->where('is_active', true)->orderBy('order')->get();
        
        if ($puzzle->is_timed && $puzzle->time_limit) {
            $timeElapsed = now()->diffInSeconds($attempt->started_at);
            if ($timeElapsed > $puzzle->time_limit) {
                $attempt->update([
                    'status' => 'timed_out',
                    'completed' => false,
                    'completed_at' => now(),
                ]);
                
                $route = $puzzle->type === 'quiz' ? 'quiz.results' : 'puzzles.results';
                return redirect()->route($route, ['attempt' => $attempt->id])->with('error', 'Time expired!');
            }
        }
        
        return view('puzzles.play', compact('puzzle', 'attempt', 'questions'));
    }

    /**
     * Quiz play (redirects to unified play method)
     */
    public function quizPlay($attemptId)
    {
        return $this->play($attemptId);
    }

    /**
     * Submit answers (AJAX endpoint)
     */
    public function submit(Request $request, $attemptId)
    {
        $donor = Auth::guard('donor')->user();
        
        if (!$donor) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $attempt = PuzzleAttempt::with('puzzle')
            ->where('id', $attemptId)
            ->where('donor_id', $donor->id)
            ->where('status', 'in_progress')
            ->firstOrFail();
        
        $puzzle = $attempt->puzzle;
        
        $validator = Validator::make($request->all(), [
            'answers' => 'required|array',
            'answers.*' => 'required',
            'time_taken' => 'nullable|integer',
            'question_times' => 'nullable|array',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $result = $this->processAnswers($puzzle, $request->answers);
        
        $timeTaken = $request->time_taken ?? now()->diffInSeconds($attempt->started_at);
        $timedOut = $puzzle->is_timed && $puzzle->time_limit && $timeTaken > $puzzle->time_limit;
        
        $attempt->update([
            'score' => $result['score'],
            'answers' => $request->answers,
            'feedback' => $result['feedback'],
            'question_times' => $request->question_times,
            'time_taken' => $timeTaken,
            'completed' => !$timedOut,
            'status' => $timedOut ? 'timed_out' : 'completed',
            'completed_at' => now(),
        ]);
        
        $puzzle->increment('play_count');
        $this->updateLeaderboard($puzzle, $donor, $attempt);
        $this->checkAchievements($donor, $puzzle, $attempt);
        
        Log::info('Puzzle completed', [
            'donor_id' => $donor->id,
            'puzzle_id' => $puzzle->id,
            'attempt_id' => $attempt->id,
            'score' => $attempt->score,
            'percentage' => $attempt->percentage,
        ]);
        
        $route = $puzzle->type === 'quiz' ? 'quiz.results' : 'puzzles.results';
        
        return response()->json([
            'success' => true,
            'attempt' => [
                'id' => $attempt->id,
                'score' => $attempt->score,
                'max_score' => $attempt->max_score,
                'percentage' => $attempt->percentage,
                'grade' => $attempt->grade,
                'time_formatted' => $attempt->time_formatted,
                'correct_count' => $attempt->correct_answers_count,
                'incorrect_count' => $attempt->incorrect_answers_count,
            ],
            'feedback' => $result['feedback'],
            'redirect' => route($route, ['attempt' => $attempt->id]),
        ]);
    }

    /**
     * Process answers based on puzzle type
     */
    protected function processAnswers($puzzle, $answers)
    {
        $questions = $puzzle->questions()->where('is_active', true)->orderBy('order')->get();
        $score = 0;
        $feedback = [];
        
        foreach ($questions as $index => $question) {
            $userAnswer = $answers[$index] ?? '';
            $normalizedUserAnswer = $this->normalizeAnswer($userAnswer);
            $normalizedCorrectAnswer = $this->normalizeAnswer($question->correct_answer);
            
            $isCorrect = $normalizedUserAnswer === $normalizedCorrectAnswer;
            
            if (!$isCorrect && is_array($question->correct_answer)) {
                $isCorrect = in_array($normalizedUserAnswer, array_map([$this, 'normalizeAnswer'], $question->correct_answer));
            }
            
            if ($isCorrect) {
                $score += $question->points;
            }
            
            $feedback[] = [
                'question_id' => $question->id,
                'question' => $question->question,
                'user_answer' => $userAnswer,
                'correct_answer' => $question->correct_answer,
                'is_correct' => $isCorrect,
                'explanation' => $question->explanation,
                'educational_note' => $question->educational_note,
                'fun_fact' => $question->fun_fact,
                'points_earned' => $isCorrect ? $question->points : 0,
                'max_points' => $question->points,
            ];
        }
        
        $bonus = 0;
        $maxScore = $questions->sum('points');
        if ($score == $maxScore) {
            $bonus = $puzzle->bonus_points ?? 0;
            $score += $bonus;
            $feedback[] = ['is_bonus' => true, 'message' => 'Perfect Score!', 'bonus_points' => $bonus];
        }
        
        return ['score' => $score, 'feedback' => $feedback, 'bonus' => $bonus];
    }

    /**
     * Normalize answer for comparison
     */
    protected function normalizeAnswer($answer)
    {
        if (is_array($answer)) {
            return array_map([$this, 'normalizeAnswer'], $answer);
        }
        
        if (is_null($answer)) {
            return '';
        }
        
        $answer = (string) $answer;
        $normalized = trim(strtolower(preg_replace('/\s+/', ' ', $answer)));
        $normalized = preg_replace('/[^\w\s]/', '', $normalized);
        
        return $normalized;
    }

    /**
     * Update leaderboard
     */
    protected function updateLeaderboard($puzzle, $donor, $attempt)
    {
        if (!$attempt->completed) return;
        
        $leaderboard = PuzzleLeaderboard::firstOrNew([
            'puzzle_id' => $puzzle->id,
            'donor_id' => $donor->id,
        ]);
        
        $leaderboard->member_id = Member::where('donor_id', $donor->id)->first()?->id;
        $leaderboard->total_attempts = ($leaderboard->total_attempts ?? 0) + 1;
        
        if ($attempt->score > ($leaderboard->best_score ?? 0)) {
            $leaderboard->best_score = $attempt->score;
        }
        
        if ($attempt->time_taken && (!$leaderboard->best_time || $attempt->time_taken < $leaderboard->best_time)) {
            $leaderboard->best_time = $attempt->time_taken;
        }
        
        $leaderboard->save();
        PuzzleLeaderboard::updateRankings($puzzle->id);
    }

    /**
     * Check and award achievements
     */
    protected function checkAchievements($donor, $puzzle, $attempt)
    {
        $achievements = PuzzleAchievement::where('is_active', true)->get();
        
        foreach ($achievements as $achievement) {
            $alreadyEarned = DB::table('donor_achievements')
                ->where('donor_id', $donor->id)
                ->where('achievement_id', $achievement->id)
                ->exists();
            
            if ($alreadyEarned) continue;
            
            if ($achievement->checkEligibility($donor->id, $puzzle->id)) {
                DB::table('donor_achievements')->insert([
                    'donor_id' => $donor->id,
                    'achievement_id' => $achievement->id,
                    'puzzle_id' => $puzzle->id,
                    'metadata' => json_encode(['attempt_id' => $attempt->id, 'score' => $attempt->score, 'time_taken' => $attempt->time_taken]),
                    'earned_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                Log::info('Achievement earned', ['donor_id' => $donor->id, 'achievement_id' => $achievement->id, 'achievement_name' => $achievement->name]);
            }
        }
    }

    /**
     * Show results
     */
    public function results($attemptId)
    {
        $donor = Auth::guard('donor')->user();
        
        $attempt = PuzzleAttempt::with(['puzzle', 'puzzle.category'])
            ->where('id', $attemptId)
            ->where('donor_id', $donor?->id)
            ->firstOrFail();
        
        $puzzle = $attempt->puzzle;
        
        $leaderboardEntry = PuzzleLeaderboard::where('puzzle_id', $puzzle->id)
            ->where('donor_id', $donor?->id)
            ->first();
        
        $achievementsEarned = [];
        if ($donor) {
            $achievementsEarned = DB::table('donor_achievements')
                ->join('puzzle_achievements', 'donor_achievements.achievement_id', '=', 'puzzle_achievements.id')
                ->where('donor_achievements.donor_id', $donor->id)
                ->where('donor_achievements.puzzle_id', $puzzle->id)
                ->where('donor_achievements.metadata', 'like', '%' . $attempt->id . '%')
                ->select('puzzle_achievements.*')
                ->get();
        }
        
        $shareData = [
            'url' => route('puzzles.show', $puzzle->slug),
            'title' => "I scored {$attempt->score}/{$attempt->max_score} on {$puzzle->title}!",
            'description' => "Can you beat my score? Play this African puzzle on Africa Prosperity Network.",
            'hashtags' => 'AfricaProsperityNetwork,AfricanPuzzles,AfricanHeritage',
        ];
        
        return view('puzzles.results', compact('attempt', 'puzzle', 'leaderboardEntry', 'achievementsEarned', 'shareData'));
    }

    /**
     * Submit rating
     */
    public function rate(Request $request, $slug)
    {
        $donor = Auth::guard('donor')->user();
        
        if (!$donor) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $puzzle = Puzzle::where('slug', $slug)->firstOrFail();
        
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:500',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $rating = PuzzleRating::updateOrCreate(
            ['puzzle_id' => $puzzle->id, 'donor_id' => $donor->id],
            ['rating' => $request->rating, 'review' => $request->review, 'feedback' => ['difficulty' => $request->difficulty_rating, 'enjoyment' => $request->enjoyment_rating]]
        );
        
        $puzzle->updateRating($request->rating);
        
        return response()->json(['success' => true, 'rating' => $rating, 'new_average' => $puzzle->average_rating]);
    }

    /**
     * Submit comment
     */
    public function comment(Request $request, $slug)
    {
        $donor = Auth::guard('donor')->user();
        
        if (!$donor) {
            return redirect()->route('donor.login')->with('error', 'Please log in to comment.');
        }
        
        $puzzle = Puzzle::where('slug', $slug)->firstOrFail();
        
        $validator = Validator::make($request->all(), [
            'comment' => 'required|string|min:3|max:1000',
            'parent_id' => 'nullable|exists:puzzle_comments,id',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        PuzzleComment::create([
            'puzzle_id' => $puzzle->id,
            'donor_id' => $donor->id,
            'parent_id' => $request->parent_id,
            'comment' => $request->comment,
            'metadata' => ['ip' => request()->ip(), 'user_agent' => request()->userAgent()],
        ]);
        
        return redirect()->back()->with('success', 'Comment posted successfully.');
    }

    /**
     * Get user rank
     */
    protected function getUserRank($donorId)
    {
        $rank = DB::table('puzzle_leaderboards')
            ->select('donor_id', DB::raw('SUM(best_score) as total_score'))
            ->groupBy('donor_id')
            ->orderBy('total_score', 'desc')
            ->get()
            ->search(function($item) use ($donorId) {
                return $item->donor_id == $donorId;
            });
        
        return $rank !== false ? $rank + 1 : null;
    }

    /**
     * Get user statistics
     */
    public function getUserStats()
    {
        $donor = Auth::guard('donor')->user();
        
        if (!$donor) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        return response()->json([
            'total_attempts' => PuzzleAttempt::where('donor_id', $donor->id)->count(),
            'completed' => PuzzleAttempt::where('donor_id', $donor->id)->where('completed', true)->count(),
            'total_score' => PuzzleAttempt::where('donor_id', $donor->id)->sum('score'),
            'average_score' => round(PuzzleAttempt::where('donor_id', $donor->id)->avg('score') ?? 0, 2),
            'best_puzzle' => $this->getBestPuzzle($donor->id),
            'recent_activity' => $this->getRecentActivity($donor->id),
            'achievements' => $this->getUserAchievements($donor->id),
            'streak' => $this->calculateStreak($donor->id),
        ]);
    }

    protected function getBestPuzzle($donorId)
    {
        $best = PuzzleAttempt::with('puzzle')
            ->where('donor_id', $donorId)
            ->where('completed', true)
            ->orderBy('score', 'desc')
            ->first();
        
        if (!$best) return null;
        
        return ['title' => $best->puzzle->title, 'score' => $best->score, 'max_score' => $best->max_score, 'percentage' => $best->percentage];
    }

    protected function getRecentActivity($donorId)
    {
        return PuzzleAttempt::with('puzzle')
            ->where('donor_id', $donorId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(fn($attempt) => [
                'puzzle_title' => $attempt->puzzle->title,
                'score' => $attempt->score,
                'max_score' => $attempt->max_score,
                'percentage' => $attempt->percentage,
                'date' => $attempt->created_at->diffForHumans(),
            ]);
    }

    protected function getUserAchievements($donorId)
    {
        return DB::table('donor_achievements')
            ->join('puzzle_achievements', 'donor_achievements.achievement_id', '=', 'puzzle_achievements.id')
            ->where('donor_achievements.donor_id', $donorId)
            ->orderBy('donor_achievements.earned_at', 'desc')
            ->select('puzzle_achievements.*', 'donor_achievements.earned_at')
            ->get();
    }

    protected function calculateStreak($donorId)
    {
        $attempts = PuzzleAttempt::where('donor_id', $donorId)
            ->where('completed', true)
            ->orderBy('created_at', 'desc')
            ->get();
            
        if ($attempts->isEmpty()) return 0;
        
        $streak = 1;
        $currentDate = $attempts->first()->created_at->startOfDay();
        
        foreach ($attempts->slice(1) as $attempt) {
            $attemptDate = $attempt->created_at->startOfDay();
            $diffInDays = $currentDate->diffInDays($attemptDate);
            
            if ($diffInDays == 1) {
                $streak++;
                $currentDate = $attemptDate;
            } elseif ($diffInDays > 1) {
                break;
            }
        }
        
        return $streak;
    }

    /**
     * Get achievement list
     */
    public function achievements()
    {
        $donor = Auth::guard('donor')->user();
        $achievements = PuzzleAchievement::where('is_active', true)->get();
        
        if ($donor) {
            $earnedIds = DB::table('donor_achievements')->where('donor_id', $donor->id)->pluck('achievement_id')->toArray();
            
            foreach ($achievements as $achievement) {
                $achievement->earned = in_array($achievement->id, $earnedIds);
                if ($achievement->earned) {
                    $achievement->earned_at = DB::table('donor_achievements')
                        ->where('donor_id', $donor->id)
                        ->where('achievement_id', $achievement->id)
                        ->value('earned_at');
                }
            }
        }
        
        return view('puzzles.achievements', compact('achievements', 'donor'));
    }

/**
 * Display all quizzes
 */
/**
 * Display all quizzes
 */
public function quizIndex()
{
    $donor = Auth::guard('donor')->user();
    $quizzes = Puzzle::whereIn('type', ['quiz', 'flag_match'])
        ->where('is_active', true)
        ->orderBy('created_at', 'desc')
        ->paginate(12);
    
    $userStats = null;
    if ($donor) {
        $userStats = [
            'total_attempts' => PuzzleAttempt::where('donor_id', $donor->id)
                ->whereHas('puzzle', fn($q) => $q->whereIn('type', ['quiz', 'flag_match']))
                ->count(),
            'completed' => PuzzleAttempt::where('donor_id', $donor->id)
                ->whereHas('puzzle', fn($q) => $q->whereIn('type', ['quiz', 'flag_match']))
                ->where('completed', true)
                ->count(),
            'total_score' => PuzzleAttempt::where('donor_id', $donor->id)
                ->whereHas('puzzle', fn($q) => $q->whereIn('type', ['quiz', 'flag_match']))
                ->sum('score'),
            'average_score' => round(PuzzleAttempt::where('donor_id', $donor->id)
                ->whereHas('puzzle', fn($q) => $q->whereIn('type', ['quiz', 'flag_match']))
                ->avg('score') ?? 0, 2),
        ];
    }
    
    return view('puzzles.quiz-index', compact('quizzes', 'donor', 'userStats'));
}
    /**
     * Display quiz details
     */
    public function quizShow($slug)
    {
        $donor = Auth::guard('donor')->user();
        $member = $donor ? Member::where('donor_id', $donor->id)->first() : null;
        
        $puzzle = Puzzle::with(['category', 'questions' => function($query) {
            $query->where('is_active', true)->orderBy('order');
        }])->where('slug', $slug)
            ->where('type', 'quiz')
            ->where('is_active', true)
            ->firstOrFail();
        
        // Get user's attempts
        $userAttempts = collect();
        $userBestScore = 0;
        $userBestTime = null;
        $userRank = null;
        
        if ($donor) {
            $userAttempts = PuzzleAttempt::where('donor_id', $donor->id)
                ->where('puzzle_id', $puzzle->id)
                ->orderBy('created_at', 'desc')
                ->get();
            
            $userBestScore = $userAttempts->where('completed', true)->max('score') ?? 0;
            
            $bestTimeAttempt = $userAttempts->where('completed', true)->sortBy('time_taken')->first();
            $userBestTime = $bestTimeAttempt?->time_taken;
            
            $leaderboardEntry = PuzzleLeaderboard::where('puzzle_id', $puzzle->id)
                ->where('donor_id', $donor->id)
                ->first();
            $userRank = $leaderboardEntry?->rank;
        }
        
        // Get leaderboard
        $leaderboard = PuzzleLeaderboard::with('donor')
            ->where('puzzle_id', $puzzle->id)
            ->whereNotNull('rank')
            ->orderBy('rank')
            ->limit(10)
            ->get();
        
        // Get comments
        $comments = PuzzleComment::with('donor')
            ->where('puzzle_id', $puzzle->id)
            ->where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Get related puzzles
        $relatedPuzzles = $puzzle->getRelatedPuzzles(3);
        
        // Check if user has rated
        $userRating = null;
        if ($donor) {
            $userRating = PuzzleRating::where('puzzle_id', $puzzle->id)
                ->where('donor_id', $donor->id)
                ->first();
        }
        
        // Increment view count
        if (!session()->has("puzzle_viewed_{$puzzle->id}")) {
            $puzzle->increment('play_count');
            session()->put("puzzle_viewed_{$puzzle->id}", true);
        }
        
        return view('puzzles.show', compact(
            'puzzle',
            'donor',
            'member',
            'userAttempts',
            'userBestScore',
            'userBestTime',
            'userRank',
            'leaderboard',
            'comments',
            'relatedPuzzles',
            'userRating'
        ));
    }
}