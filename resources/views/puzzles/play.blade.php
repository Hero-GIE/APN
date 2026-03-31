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
    
    .breadcrumb-link {
        font-family: 'Open Sans', sans-serif;
        font-size: 0.95rem;
    }
    
    .game-container {
        max-width: 800px;
        margin: 2rem auto;
        background: white;
        border-radius: 16px;
        box-shadow: 0 20px 40px -15px rgba(0,0,0,0.15), inset 0 0 0 1px rgba(0,0,0,0.02);
        overflow: hidden;
    }
    .question-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
    }
    .option-item {
        transition: all 0.2s ease;
        cursor: pointer;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 0.75rem;
    }
    .option-item:hover {
        border-color: #667eea;
        background: #f5f3ff;
        transform: translateX(5px);
    }
    .option-item.selected {
        border-color: #667eea;
        background: #e0e7ff;
    }
    .progress-bar {
        height: 8px;
        background: rgba(255,255,255,0.3);
        border-radius: 4px;
        overflow: hidden;
    }
    .progress-fill {
        height: 100%;
        background: white;
        transition: width 0.3s ease;
    }
    
    /* Level indicator */
    .level-badge {
        display: inline-block;
        background: rgba(255,255,255,0.2);
        padding: 0.25rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }
    
    .level-progress {
        background: rgba(255,255,255,0.15);
        border-radius: 10px;
        overflow: hidden;
    }
    
    .level-progress-fill {
        background: #10b981;
        height: 100%;
        transition: width 0.3s ease;
    }
    
    /* Level complete animation */
    @keyframes levelComplete {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .level-complete {
        animation: levelComplete 0.5s ease;
    }
    
    /* Next button */
    .next-btn {
        transition: all 0.2s ease;
    }
    .next-btn:hover:not(:disabled) {
        transform: translateY(-2px);
    }
    .next-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    /* Flag container styles */
    .flag-container {
        margin-bottom: 2rem;
        text-align: center;
        min-height: 180px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .flag-image {
        width: 180px;
        height: auto;
        max-height: 120px;
        object-fit: contain;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        background: white;
        padding: 0.5rem;
        transition: transform 0.2s ease;
    }
    
    .flag-image:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    /* Question image styles */
    .question-image {
        max-width: 100%;
        max-height: 200px;
        object-fit: contain;
        margin: 0 auto;
        border-radius: 8px;
    }
    
    /* Error fallback for images */
    .flag-error {
        background: #f3f4f6;
        border: 2px dashed #d1d5db;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        color: #6b7280;
        font-size: 0.875rem;
        width: 100%;
        max-width: 250px;
        margin: 0 auto;
    }
    
    @media (max-width: 640px) {
        body { font-size: 15px; }
        .text-xs { font-size: 0.75rem !important; }
        .text-sm { font-size: 0.875rem !important; }
        h1 { font-size: 1.75rem !important; }
        .game-container { margin: 1rem; }
        .question-header { padding: 1.5rem; }
        .flag-image {
            width: 140px;
            max-height: 90px;
            padding: 0.35rem;
        }
        .flag-container {
            min-height: 140px;
        }
    }
</style>

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <div class="mb-6">
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
                <span class="text-gray-700">Play</span>
            </div>
        </div>

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 font-urbanist">{{ $puzzle->title }}</h1>
            <p class="text-gray-600 mt-2">Answer 5 questions correctly to advance to the next level!</p>
        </div>

        <!-- Game Container -->
        <div class="game-container">
            <div class="question-header">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="text-2xl font-bold">{{ $puzzle->title }}</h2>
                        <div class="mt-2 flex items-center gap-3">
                            <span class="level-badge">Level <span id="current-level">1</span> of <span id="total-levels">{{ ceil($questions->count() / 5) }}</span></span>
                            <div class="level-progress w-32 h-2">
                                <div id="level-progress-fill" class="level-progress-fill" style="width: 0%"></div>
                            </div>
                            <span id="level-questions-complete" class="text-sm">0/5</span>
                        </div>
                    </div>
                    @if($puzzle->is_timed && $puzzle->time_limit)
                    <div id="timer" class="text-xl font-mono bg-white/20 px-4 py-2 rounded-lg">
                        {{ floor($puzzle->time_limit / 60) }}:{{ str_pad($puzzle->time_limit % 60, 2, '0', STR_PAD_LEFT) }}
                    </div>
                    @endif
                </div>
                
                <div class="flex justify-between text-sm mb-2">
                    <span>Question <span id="current-q">1</span> of <span id="total-q">{{ $questions->count() }}</span></span>
                    <span id="score-display">Score: <span id="current-score">0</span></span>
                </div>
                
                <div class="progress-bar">
                    <div id="progress" class="progress-fill" style="width: 0%"></div>
                </div>
            </div>

            <div class="p-8">
                <div id="question-container">
                    <!-- Question loaded here -->
                </div>
                
                <div class="flex justify-end mt-8">
                    <button id="next-question" class="next-btn px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                        Next <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
                
                <!-- Level Complete Modal -->
                <div id="level-complete-modal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
                    <div class="bg-white rounded-2xl p-8 max-w-md text-center">
                        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-trophy text-4xl text-green-600"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Level Complete!</h3>
                        <p class="text-gray-600 mb-4">Great job! You've completed <span id="completed-level-num">1</span> of <span id="total-levels-modal">{{ ceil($questions->count() / 5) }}</span> levels.</p>
                        <p class="text-sm text-gray-500 mb-6">Get ready for the next level!</p>
                        <button onclick="continueToNextLevel()" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                            Continue to Level <span id="next-level-num">2</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-center gap-3 mt-8 text-xs text-gray-400">
            <i class="fas fa-circle text-yellow-500" style="font-size:0.35rem;"></i>
            <span>Let's have fun</span>
            <i class="fas fa-circle text-yellow-500" style="font-size:0.35rem;"></i>
            <span>Know your continent</span>
            <i class="fas fa-circle text-yellow-500" style="font-size:0.35rem;"></i>
            <span>Finish hard</span>
        </div>
    </div>
</div>

@php
    // Prepare questions data in PHP
    $questionsData = [];
    foreach($questions as $q) {
        $questionsData[] = [
            'id' => $q->id,
            'question' => $q->question,
            'options' => $q->options_array,
            'correct_answer' => $q->correct_answer,
            'points' => $q->points,
            'image' => $q->image,
            'explanation' => $q->explanation,
            'fun_fact' => $q->fun_fact,
        ];
    }
@endphp

<script>
// Game configuration
const puzzleConfig = {
    id: {{ $puzzle->id }},
    attemptId: {{ $attempt->id }},
    type: '{{ $puzzle->type }}',
    title: '{{ $puzzle->title }}',
    questions: {!! json_encode($questionsData) !!},
    timeLimit: {{ $puzzle->time_limit ?? 0 }},
    hintsAllowed: {{ $puzzle->hints_allowed ?? 0 }},
    hintsUsed: {{ $attempt->hints_used ?? 0 }},
    questionsPerLevel: 5
};

// Initialize arrays
let answers = new Array(puzzleConfig.questions.length).fill(null);
let answersCorrect = new Array(puzzleConfig.questions.length).fill(false);
let questionTimes = new Array(puzzleConfig.questions.length).fill(0);
let totalScore = 0;
let timerInterval = null;
let timeRemaining = puzzleConfig.timeLimit;
let currentQuestion = 0;
let currentLevel = 0;
let totalLevels = Math.ceil(puzzleConfig.questions.length / puzzleConfig.questionsPerLevel);
let levelAnswers = 0;
let questionStartTime = Date.now();
let hasAnswered = false;

// Initialize game
document.addEventListener('DOMContentLoaded', function() {
    loadQuestion();
    updateProgress();
    updateScoreDisplay();
    setupNextButton();
    
    if (puzzleConfig.timeLimit > 0) {
        startTimer();
    }
});

function loadQuestion() {
    const question = puzzleConfig.questions[currentQuestion];
    const container = document.getElementById('question-container');
    
    // Reset hasAnswered flag
    hasAnswered = false;
    
    // Enable next button but disable it until answer is selected
    const nextBtn = document.getElementById('next-question');
    nextBtn.disabled = true;
    
    // Render based on puzzle type
    if (puzzleConfig.type === 'flag_match') {
        container.innerHTML = renderFlagMatchQuestion(question);
    } else {
        container.innerHTML = renderMultipleChoiceQuestion(question);
    }
    
    // Restore previously selected answer
    if (answers[currentQuestion] !== null && answers[currentQuestion] !== undefined && answers[currentQuestion] !== '') {
        const selectedDiv = document.querySelector(`.option-item[data-value="${answers[currentQuestion].replace(/'/g, "\\'").replace(/"/g, '&quot;')}"]`);
        if (selectedDiv) {
            selectedDiv.classList.add('selected');
            hasAnswered = true;
            nextBtn.disabled = false;
        }
    }
    
    // Update question counter
    document.getElementById('current-q').textContent = currentQuestion + 1;
    
    // Update level display
    updateLevelDisplay();
}

function renderMultipleChoiceQuestion(question) {
    let optionsHtml = '';
    for (let i = 0; i < question.options.length; i++) {
        const option = question.options[i];
        const letter = String.fromCharCode(65 + i);
        const escapedOption = option.replace(/'/g, "\\'").replace(/"/g, '&quot;');
        optionsHtml += `
            <div class="option-item" data-value="${escapedOption}" onclick="selectOption('${escapedOption}')">
                <div class="flex items-center">
                    <span class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 mr-3 font-semibold">
                        ${letter}
                    </span>
                    <span class="text-gray-800">${escapeHtml(option)}</span>
                </div>
            </div>
        `;
    }
    
    return `
        <div class="question-body">
            ${question.image ? `<div class="flag-container"><img src="${question.image}" class="question-image" onerror="this.style.display='none'"></div>` : ''}
            <h2 class="text-xl font-bold text-gray-900 mb-6">${escapeHtml(question.question)}</h2>
            <div class="options-list">
                ${optionsHtml}
            </div>
        </div>
    `;
}

function renderFlagMatchQuestion(question) {
    let optionsHtml = '';
    for (let i = 0; i < question.options.length; i++) {
        const option = question.options[i];
        const letter = String.fromCharCode(65 + i);
        const escapedOption = option.replace(/'/g, "\\'").replace(/"/g, '&quot;');
        optionsHtml += `
            <div class="option-item" data-value="${escapedOption}" onclick="selectOption('${escapedOption}')">
                <div class="flex items-center">
                    <span class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 mr-3 font-semibold">
                        ${letter}
                    </span>
                    <span class="text-gray-800">${escapeHtml(option)}</span>
                </div>
            </div>
        `;
    }
    
    // Use flagpedia.net URL format
    const flagUrl = question.question;
    
    return `
        <div class="question-body">
            <div class="flag-container">
                <img src="${flagUrl}" 
                     alt="Flag" 
                     class="flag-image" 
                     loading="lazy"
                     onerror="handleFlagError(this, '${getCountryCodeFromUrl(flagUrl)}')">
            </div>
            <h2 class="text-xl font-bold text-gray-900 mb-6 text-center">Which country does this flag belong to?</h2>
            <div class="options-list">
                ${optionsHtml}
            </div>
        </div>
    `;
}

// Helper function to handle flag loading errors
function handleFlagError(img, countryCode) {
    img.onerror = null;
    
    // Try alternative flagpedia URL format
    const currentUrl = img.src;
    if (currentUrl.includes('flagpedia.net')) {
        // Try different size or format
        const altUrl = currentUrl.replace('/w320/', '/w160/');
        img.src = altUrl;
        img.onerror = function() {
            this.onerror = null;
            // Show error message if still fails
            this.style.display = 'none';
            const errorDiv = document.createElement('div');
            errorDiv.className = 'flag-error';
            errorDiv.innerHTML = `<i class="fas fa-flag text-gray-400 text-4xl mb-2 block"></i>Flag image not available<br><small class="text-xs">Country code: ${countryCode}</small>`;
            this.parentNode.appendChild(errorDiv);
        };
    } else {
        // Show error message
        this.style.display = 'none';
        const errorDiv = document.createElement('div');
        errorDiv.className = 'flag-error';
        errorDiv.innerHTML = `<i class="fas fa-flag text-gray-400 text-4xl mb-2 block"></i>Flag image not available<br><small class="text-xs">Country code: ${countryCode}</small>`;
        this.parentNode.appendChild(errorDiv);
    }
}

// Helper function to extract country code from URL
function getCountryCodeFromUrl(url) {
    const match = url.match(/\/([a-z]{2})\.png$/);
    return match ? match[1].toUpperCase() : 'Unknown';
}

// Helper function to escape HTML
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function selectOption(value) {
    // Store the answer
    answers[currentQuestion] = value;
    
    // Check if answer is correct
    const question = puzzleConfig.questions[currentQuestion];
    const userAnswer = value.toString().trim().toLowerCase();
    const correctAnswer = question.correct_answer.toString().trim().toLowerCase();
    const isCorrect = userAnswer === correctAnswer;
    
    answersCorrect[currentQuestion] = isCorrect;
    
    if (isCorrect) {
        totalScore += question.points;
    }
    
    // Update UI - remove selected class from all options and add to selected
    document.querySelectorAll('.option-item').forEach(el => {
        el.classList.remove('selected');
        if (el.getAttribute('data-value') === value) {
            el.classList.add('selected');
        }
    });
    
    // Update score display
    updateScoreDisplay();
    updateProgress();
    
    // Enable next button
    const nextBtn = document.getElementById('next-question');
    nextBtn.disabled = false;
    hasAnswered = true;
}

function nextQuestion() {
    if (!hasAnswered) {
        alert('Please select an answer before continuing.');
        return;
    }
    
    // Save time for current question
    const timeSpent = Math.floor((Date.now() - questionStartTime) / 1000);
    questionTimes[currentQuestion] = timeSpent;
    
    // Update level answers count
    if (answers[currentQuestion] !== null && answersCorrect[currentQuestion]) {
        levelAnswers++;
        updateLevelProgress();
    }
    
    // Check if this was the last question in the level
    const levelStart = currentLevel * puzzleConfig.questionsPerLevel;
    const levelEnd = Math.min(levelStart + puzzleConfig.questionsPerLevel, puzzleConfig.questions.length);
    const levelQuestionIndex = currentQuestion - levelStart;
    
    // Check if level is complete (answered all questions in this level correctly)
    if (levelQuestionIndex + 1 === puzzleConfig.questionsPerLevel || currentQuestion + 1 === levelEnd) {
        // Check if the player answered all questions in this level correctly
        const levelQuestions = [];
        for (let i = levelStart; i < levelEnd; i++) {
            levelQuestions.push(answersCorrect[i]);
        }
        const allCorrect = levelQuestions.every(correct => correct === true);
        
        if (allCorrect) {
            // Show level complete modal
            showLevelCompleteModal();
            return;
        }
    }
    
    // Move to next question
    if (currentQuestion < puzzleConfig.questions.length - 1) {
        currentQuestion++;
        questionStartTime = Date.now();
        loadQuestion();
        
        // Check if we moved to next level
        const newLevel = Math.floor(currentQuestion / puzzleConfig.questionsPerLevel);
        if (newLevel !== currentLevel) {
            currentLevel = newLevel;
            levelAnswers = 0;
            updateLevelProgress();
        }
    } else {
        // All questions completed, submit quiz
        submitQuiz();
    }
}

function updateLevelDisplay() {
    const newLevel = Math.floor(currentQuestion / puzzleConfig.questionsPerLevel);
    currentLevel = newLevel;
    document.getElementById('current-level').textContent = currentLevel + 1;
    document.getElementById('total-levels').textContent = totalLevels;
    
    // Reset level answers for this level
    const levelStart = currentLevel * puzzleConfig.questionsPerLevel;
    const levelEnd = Math.min(levelStart + puzzleConfig.questionsPerLevel, puzzleConfig.questions.length);
    levelAnswers = 0;
    
    // Count correct answers in current level
    for (let i = levelStart; i < levelEnd; i++) {
        if (answersCorrect[i] === true) {
            levelAnswers++;
        }
    }
    
    updateLevelProgress();
}

function updateLevelProgress() {
    const levelStart = currentLevel * puzzleConfig.questionsPerLevel;
    const levelEnd = Math.min(levelStart + puzzleConfig.questionsPerLevel, puzzleConfig.questions.length);
    const totalInLevel = levelEnd - levelStart;
    const percentage = (levelAnswers / totalInLevel) * 100;
    
    document.getElementById('level-progress-fill').style.width = percentage + '%';
    document.getElementById('level-questions-complete').textContent = `${levelAnswers}/${totalInLevel}`;
}

function showLevelCompleteModal() {
    const modal = document.getElementById('level-complete-modal');
    const completedLevel = currentLevel + 1;
    document.getElementById('completed-level-num').textContent = completedLevel;
    document.getElementById('next-level-num').textContent = completedLevel + 1;
    document.getElementById('total-levels-modal').textContent = totalLevels;
    
    modal.classList.remove('hidden');
}

function continueToNextLevel() {
    // Hide modal
    const modal = document.getElementById('level-complete-modal');
    modal.classList.add('hidden');
    
    // Move to next level
    const nextLevelStart = (currentLevel + 1) * puzzleConfig.questionsPerLevel;
    
    if (nextLevelStart < puzzleConfig.questions.length) {
        currentQuestion = nextLevelStart;
        currentLevel++;
        levelAnswers = 0;
        questionStartTime = Date.now();
        loadQuestion();
        updateLevelProgress();
    } else {
        // If no next level, submit quiz
        submitQuiz();
    }
}

function updateProgress() {
    const answeredCount = answers.filter(a => a !== null && a !== undefined && a !== '').length;
    const progress = (answeredCount / puzzleConfig.questions.length) * 100;
    document.getElementById('progress').style.width = progress + '%';
}

function updateScoreDisplay() {
    document.getElementById('current-score').textContent = totalScore;
}

function setupNextButton() {
    const nextBtn = document.getElementById('next-question');
    nextBtn.addEventListener('click', nextQuestion);
}

function startTimer() {
    timerInterval = setInterval(() => {
        timeRemaining--;
        
        const minutes = Math.floor(timeRemaining / 60);
        const seconds = timeRemaining % 60;
        document.getElementById('timer').textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
        
        if (timeRemaining <= 60) {
            document.getElementById('timer').classList.add('text-red-300');
        }
        
        if (timeRemaining <= 0) {
            clearInterval(timerInterval);
            submitQuiz();
        }
    }, 1000);
}

function submitQuiz() {
    // Save last question time
    const timeSpent = Math.floor((Date.now() - questionStartTime) / 1000);
    questionTimes[currentQuestion] = timeSpent;
    
    // Calculate total time
    const totalTime = puzzleConfig.timeLimit ? 
        (puzzleConfig.timeLimit - timeRemaining) : 
        Math.floor((Date.now() - window.performance.timing.navigationStart) / 1000);
    
    // Prepare answers array - replace null with empty string
    const finalAnswers = answers.map(answer => answer !== null ? answer : '');
    
    console.log('Submitting answers:', finalAnswers);
    
    showLoading();
    
    // Submit answers
    fetch(`/puzzles/submit/${puzzleConfig.attemptId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            answers: finalAnswers,
            time_taken: totalTime,
            question_times: questionTimes
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = data.redirect;
        } else {
            hideLoading();
            alert('Error submitting answers: ' + (data.message || 'Please try again.'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        hideLoading();
        alert('Network error. Please check your connection.');
    });
}

function showLoading() {
    const nextBtn = document.getElementById('next-question');
    if (nextBtn) {
        nextBtn.disabled = true;
        nextBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
    }
}

function hideLoading() {
    const nextBtn = document.getElementById('next-question');
    if (nextBtn) {
        nextBtn.disabled = false;
        nextBtn.innerHTML = 'Next <i class="fas fa-arrow-right ml-2"></i>';
    }
}
</script>
@endsection