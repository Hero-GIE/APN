<?php

namespace App\Http\Controllers;

use App\Models\WordSearchPuzzle;
use App\Models\WordSearchAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class WordSearchController extends Controller
{
    /**
     * Display all word search puzzles
     */
    public function index()
    {
        $donor = Auth::guard('donor')->user();
        $puzzles = WordSearchPuzzle::active()
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('wordsearch.index', compact('puzzles', 'donor'));
    }

    /**
     * Display a single word search puzzle
     */
    public function show($slug)
    {
        $donor = Auth::guard('donor')->user();
        $puzzle = WordSearchPuzzle::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $userAttempts = collect();
        $userBestScore = 0;

        if ($donor) {
            $userAttempts = WordSearchAttempt::where('donor_id', $donor->id)
                ->where('word_search_puzzle_id', $puzzle->id)
                ->orderBy('created_at', 'desc')
                ->get();

            $userBestScore = $userAttempts->where('completed', true)->max('score') ?? 0;
        }

        return view('wordsearch.show', compact('puzzle', 'donor', 'userAttempts', 'userBestScore'));
    }

    /**
     * Start a word search puzzle attempt
     */
    public function start($slug)
    {
        $donor = Auth::guard('donor')->user();

        if (!$donor) {
            return redirect()->route('donor.login')
                ->with('error', 'Please log in to play word search puzzles.');
        }

        $puzzle = WordSearchPuzzle::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $attemptCount = WordSearchAttempt::where('donor_id', $donor->id)
            ->where('word_search_puzzle_id', $puzzle->id)
            ->count();

        if ($attemptCount >= $puzzle->attempts_allowed && $puzzle->attempts_allowed > 0) {
            return redirect()->route('wordsearch.show', $puzzle->slug)
                ->with('error', 'You have reached the maximum number of attempts for this puzzle.');
        }

        // Check for in-progress attempt
        $inProgress = WordSearchAttempt::where('donor_id', $donor->id)
            ->where('word_search_puzzle_id', $puzzle->id)
            ->where('status', 'in_progress')
            ->first();

        if ($inProgress) {
            return redirect()->route('wordsearch.play', ['attempt' => $inProgress->id]);
        }

        // Create new attempt
        $attempt = WordSearchAttempt::create([
            'donor_id' => $donor->id,
            'word_search_puzzle_id' => $puzzle->id,
            'found_words' => [],
            'score' => 0,
            'status' => 'in_progress',
            'started_at' => now(),
        ]);

        return redirect()->route('wordsearch.play', ['attempt' => $attempt->id]);
    }

    /**
     * Play the word search game
     */
    public function play($attemptId)
    {
        $donor = Auth::guard('donor')->user();

        if (!$donor) {
            return redirect()->route('donor.login');
        }

        $attempt = WordSearchAttempt::with('puzzle')
            ->where('id', $attemptId)
            ->where('donor_id', $donor->id)
            ->where('status', 'in_progress')
            ->firstOrFail();

        $puzzle = $attempt->puzzle;

        // Check time limit
        if ($puzzle->time_limit) {
            $timeElapsed = now()->diffInSeconds($attempt->started_at);
            if ($timeElapsed > $puzzle->time_limit) {
                $attempt->update([
                    'status' => 'timed_out',
                    'completed' => false,
                    'completed_at' => now(),
                ]);

                return redirect()->route('wordsearch.results', ['attempt' => $attempt->id])
                    ->with('error', 'Time expired!');
            }
        }

        return view('wordsearch.play', compact('puzzle', 'attempt'));
    }

    /**
     * Submit a word found in the word search
     */
    public function submitWord(Request $request, $attemptId)
    {
        $donor = Auth::guard('donor')->user();

        if (!$donor) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $attempt = WordSearchAttempt::with('puzzle')
            ->where('id', $attemptId)
            ->where('donor_id', $donor->id)
            ->where('status', 'in_progress')
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'word' => 'required|string',
            'positions' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $puzzle = $attempt->puzzle;
        $foundWords = $attempt->found_words ?? [];
        $word = strtoupper($request->word);
        $positions = $request->positions;

        $validWords = $puzzle->words;
        if (!in_array($word, $validWords)) {
            return response()->json(['success' => false, 'message' => 'Word not found in this puzzle!']);
        }

        if (in_array($word, $foundWords)) {
            return response()->json(['success' => false, 'message' => 'Word already found!']);
        }

        $wordPositions = $puzzle->word_positions[$word] ?? null;
        if ($wordPositions) {
            $isValid = $this->validateWordPosition($positions, $wordPositions);
            if (!$isValid) {
                return response()->json(['success' => false, 'message' => 'Invalid word placement!']);
            }
        }

        // Add to found words
        $foundWords[] = $word;
        $newScore = count($foundWords);
        $points = ($newScore / count($validWords)) * $puzzle->points;

        $attempt->update([
            'found_words' => $foundWords,
            'score' => $newScore,
        ]);

        // Check if all words found
        $isComplete = count($foundWords) === count($validWords);

        if ($isComplete) {
            $attempt->update([
                'completed' => true,
                'status' => 'completed',
                'completed_at' => now(),
                'time_taken' => now()->diffInSeconds($attempt->started_at),
            ]);

            return response()->json([
                'success' => true,
                'word_found' => true,
                'completed' => true,
                'score' => $newScore,
                'total_words' => count($validWords),
                'points_earned' => round($points),
                'redirect' => route('wordsearch.results', ['attempt' => $attempt->id]),
            ]);
        }

        return response()->json([
            'success' => true,
            'word_found' => true,
            'completed' => false,
            'score' => $newScore,
            'total_words' => count($validWords),
            'found_words' => $foundWords,
        ]);
    }

    /**
     * Validate word position (simplified validation)
     */
    protected function validateWordPosition($submittedPositions, $actualPositions)
    {
      
        return true;
    }

    /**
     * Show results page
     */
    public function results($attemptId)
    {
        $donor = Auth::guard('donor')->user();

        $attempt = WordSearchAttempt::with('puzzle')
            ->where('id', $attemptId)
            ->where('donor_id', $donor->id)
            ->firstOrFail();

        $puzzle = $attempt->puzzle;
        $totalWords = count($puzzle->words);
        $scorePercentage = ($attempt->score / $totalWords) * 100;

        return view('wordsearch.results', compact('attempt', 'puzzle', 'totalWords', 'scorePercentage'));
    }
}