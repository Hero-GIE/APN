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
    
    /* Flag Match Specific Styles */
    .flag-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1rem;
        margin: 1rem 0;
    }
    .flag-item {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .flag-item:hover {
        border-color: #667eea;
        transform: scale(1.05);
    }
    .flag-item.selected {
        border-color: #667eea;
        background: #e0e7ff;
    }
    .flag-image {
        width: 100%;
        height: 100px;
        object-fit: contain;
        margin-bottom: 0.5rem;
    }
    
    /* Timeline Specific Styles */
    .timeline-item {
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 0.75rem;
        cursor: move;
        user-select: none;
    }
    .timeline-item.dragging {
        opacity: 0.5;
        transform: scale(1.02);
    }
    
    /* Button styling */
    .btn-primary {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        border: none;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px -1px rgba(59,130,246,0.2);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-family: 'Urbanist', sans-serif;
    }
    .btn-primary:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(59,130,246,0.3);
    }
    
    .btn-secondary {
        background: #f1f5f9;
        color: #475569;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        border: none;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: 'Urbanist', sans-serif;
    }
    .btn-secondary:hover:not(:disabled) {
        background: #e2e8f0;
        transform: translateY(-2px);
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
        .game-container {
            margin: 1rem;
        }
        .question-header {
            padding: 1.5rem;
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
                <a href="{{ route('puzzles.hub') }}" class="hover:text-indigo-600">Puzzles</a>
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <a href="{{ route('puzzles.show', $puzzle->slug) }}" class="hover:text-indigo-600">{{ $puzzle->title }}</a>
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700">Play</span>
            </div>
        </div>

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">{{ $puzzle->title }}</h1>
            <p class="text-gray-600 mt-2">Test your knowledge and earn points</p>
        </div>

        <!-- Game Container -->
        <div class="game-container">
            <div class="question-header">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold">{{ $puzzle->title }}</h2>
                    @if($puzzle->is_timed && $puzzle->time_limit)
                    <div id="timer" class="text-xl font-mono bg-white/20 px-4 py-2 rounded-lg">
                        {{ floor($puzzle->time_limit / 60) }}:{{ str_pad($puzzle->time_limit % 60, 2, '0', STR_PAD_LEFT) }}
                    </div>
                    @endif
                </div>
                
                <div class="flex justify-between text-sm mb-2">
                    <span id="question-counter">Question <span id="current-q">1</span> of <span id="total-q">{{ $questions->count() }}</span></span>
                    <span id="score-display">Score: <span id="current-score">0</span></span>
                </div>
                
                <div class="progress-bar">
                    <div id="progress" class="progress-fill" style="width: 0%"></div>
                </div>
            </div>

            <div class="p-8">
                <div id="question-container">
                    <!-- Questions loaded here by JavaScript -->
                </div>
            </div>
        </div>

        <div class="flex items-center justify-center gap-3 mt-8 text-xs text-gray-400">
            <i class="fas fa-circle text-yellow-500" style="font-size:0.35rem;"></i>
            <span>256-bit encrypted</span>
            <i class="fas fa-circle text-yellow-500" style="font-size:0.35rem;"></i>
            <span>Powered by Paystack</span>
            <i class="fas fa-circle text-yellow-500" style="font-size:0.35rem;"></i>
            <span>Secure transactions</span>
        </div>
    </div>
</div>

@php
    // Prepare questions data in PHP first
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
// Game configuration from server 
const puzzleConfig = {
    id: {{ $puzzle->id }},
    attemptId: {{ $attempt->id }},
    type: '{{ $puzzle->type }}',
    title: '{{ $puzzle->title }}',
    questions: {!! json_encode($questionsData) !!},
    timeLimit: {{ $puzzle->time_limit ?? 0 }},
    hintsAllowed: {{ $puzzle->hints_allowed ?? 0 }},
    hintsUsed: {{ $attempt->hints_used ?? 0 }}
};

let currentQuestion = 0;
let answers = [];
let questionTimes = [];
let questionStartTime = Date.now();
let totalScore = 0;
let timerInterval = null;
let timeRemaining = puzzleConfig.timeLimit;

// Initialize game based on puzzle type
document.addEventListener('DOMContentLoaded', function() {
    loadQuestion(currentQuestion);
    
    if (puzzleConfig.timeLimit > 0) {
        startTimer();
    }
});

function loadQuestion(index) {
    const question = puzzleConfig.questions[index];
    const container = document.getElementById('question-container');
    
    // Choose template based on puzzle type
    switch(puzzleConfig.type) {
        case 'flag_match':
            container.innerHTML = renderFlagQuestion(question, index);
            break;
        case 'timeline':
            container.innerHTML = renderTimelineQuestion(question, index);
            break;
        case 'map_puzzle':
            container.innerHTML = renderMapQuestion(question, index);
            break;
        default: 
            container.innerHTML = renderMultipleChoiceQuestion(question, index);
    }
    
    if (answers[index]) {
        const selected = document.querySelector(`input[value="${answers[index]}"]`);
        if (selected) {
            selected.checked = true;
            selected.closest('.option-item')?.classList.add('selected');
        }
    }
    
    updateProgress();
}

function renderMultipleChoiceQuestion(question, index) {
    let optionsHtml = '';
    for (let i = 0; i < question.options.length; i++) {
        const option = question.options[i];
        const letter = String.fromCharCode(65 + i);
        optionsHtml += `
            <div class="option-item" onclick="selectOption(${index}, '${option.replace(/'/g, "\\'")}')">
                <div class="flex items-center">
                    <span class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 mr-3 font-semibold">
                        ${letter}
                    </span>
                    <span class="text-gray-800">${option}</span>
                </div>
            </div>
        `;
    }
    
    return `
        <div class="question-body">
            ${question.image ? `<img src="${question.image}" class="mb-6 rounded-lg max-h-64 mx-auto">` : ''}
            <h2 class="text-xl font-bold text-gray-900 mb-6">${question.question}</h2>
            
            <div class="options-list">
                ${optionsHtml}
            </div>
            
            ${renderNavigationButtons(index)}
        </div>
    `;
}

function renderFlagQuestion(question, index) {
    let optionsHtml = '';
    for (let i = 0; i < question.options.length; i++) {
        const option = question.options[i];
        optionsHtml += `
            <div class="flag-item" onclick="selectOption(${index}, '${option.replace(/'/g, "\\'")}')">
                ${option.includes('flag') ? 
                    `<img src="${option}" class="flag-image" alt="Flag">` : 
                    `<div class="flag-image flex items-center justify-center bg-gray-100 rounded">${option}</div>`
                }
                <p class="text-sm font-medium">${option.split('/').pop()?.replace('.png', '') || option}</p>
            </div>
        `;
    }
    
    return `
        <div class="question-body">
            <h2 class="text-xl font-bold text-gray-900 mb-6">${question.question}</h2>
            
            <div class="flag-grid">
                ${optionsHtml}
            </div>
            
            ${renderNavigationButtons(index)}
        </div>
    `;
}

function renderTimelineQuestion(question, index) {
    let itemsHtml = '';
    for (let i = 0; i < question.options.length; i++) {
        const item = question.options[i];
        itemsHtml += `
            <div class="timeline-item" draggable="true" data-index="${i}" ondragstart="dragStart(event)" ondragover="dragOver(event)" ondrop="drop(event)">
                <div class="flex items-center">
                    <span class="w-8 h-8 flex items-center justify-center bg-gray-200 rounded-full mr-3">${i + 1}</span>
                    <span>${item}</span>
                </div>
            </div>
        `;
    }
    
    return `
        <div class="question-body">
            <h2 class="text-xl font-bold text-gray-900 mb-4">${question.question}</h2>
            <p class="text-sm text-gray-500 mb-6">Drag and drop the items in correct chronological order</p>
            
            <div id="timeline-container" class="space-y-2">
                ${itemsHtml}
            </div>
            
            ${renderNavigationButtons(index)}
        </div>
    `;
}

function renderMapQuestion(question, index) {
    return `
        <div class="question-body">
            <h2 class="text-xl font-bold text-gray-900 mb-4">${question.question}</h2>
            <p class="text-sm text-gray-500 mb-4">Click on the map to select your answer</p>
            
            <div class="relative">
                <img src="/images/africa-map.png" class="w-full rounded-lg" usemap="#africa-map">
                <map name="africa-map">
                    <!-- Map areas would be defined here -->
                </map>
            </div>
            
            ${renderNavigationButtons(index)}
        </div>
    `;
}

function renderNavigationButtons(index) {
    const isLast = index === puzzleConfig.questions.length - 1;
    const prevClass = index === 0 ? 'invisible' : '';
    
    return `
        <div class="flex justify-between mt-8">
            <button onclick="previousQuestion()" 
                    class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium text-sm ${prevClass}">
                ← Previous
            </button>
            
            ${!isLast ? 
                `<button onclick="nextQuestion()" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium text-sm">
                    Next →
                </button>` : 
                `<button onclick="submitQuiz()" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium text-sm">
                    Submit Answers
                </button>`
            }
        </div>
    `;
}

function selectOption(index, value) {
    answers[index] = value;
    
    document.querySelectorAll('.option-item, .flag-item').forEach(el => {
        el.classList.remove('selected');
    });
    
    event.currentTarget.classList.add('selected');
    
    updateTotalScore();
}

function nextQuestion() {
    // Save time for current question
    const timeSpent = Math.floor((Date.now() - questionStartTime) / 1000);
    questionTimes[currentQuestion] = timeSpent;
    
    if (currentQuestion < puzzleConfig.questions.length - 1) {
        currentQuestion++;
        questionStartTime = Date.now();
        loadQuestion(currentQuestion);
        document.getElementById('current-q').textContent = currentQuestion + 1;
    }
}

function previousQuestion() {
    if (currentQuestion > 0) {
        currentQuestion--;
        questionStartTime = Date.now();
        loadQuestion(currentQuestion);
        document.getElementById('current-q').textContent = currentQuestion + 1;
    }
}

function updateProgress() {
    const progress = ((currentQuestion + 1) / puzzleConfig.questions.length) * 100;
    document.getElementById('progress').style.width = progress + '%';
}

function updateTotalScore() {
    let score = 0;
    for (let i = 0; i < answers.length; i++) {
        if (answers[i]) {
            const question = puzzleConfig.questions[i];
            if (answers[i] === question.correct_answer) {
                score += question.points;
            }
        }
    }
    totalScore = score;
    document.getElementById('current-score').textContent = totalScore;
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
    
    showLoading();
    
    // Submit answers
    fetch(`/puzzles/submit/${puzzleConfig.attemptId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            answers: answers,
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
            alert('Error submitting answers. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        hideLoading();
        alert('Network error. Please check your connection.');
    });
}

function showLoading() {
    const btn = document.querySelector('button[onclick="submitQuiz()"]');
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Submitting...';
    }
}

function hideLoading() {
    const btn = document.querySelector('button[onclick="submitQuiz()"]');
    if (btn) {
        btn.disabled = false;
        btn.innerHTML = 'Submit Answers';
    }
}

// Timeline drag and drop functions
function dragStart(e) {
    e.dataTransfer.setData('text/plain', e.target.dataset.index);
    e.target.classList.add('dragging');
}

function dragOver(e) {
    e.preventDefault();
}

function drop(e) {
    e.preventDefault();
    const fromIndex = e.dataTransfer.getData('text/plain');
    const toIndex = e.target.closest('.timeline-item')?.dataset.index;
    
    if (fromIndex && toIndex && fromIndex !== toIndex) {
        const container = document.getElementById('timeline-container');
        
        document.querySelectorAll('.timeline-item').forEach(el => {
            el.classList.remove('dragging');
        });
    }
}
</script>
@endsection