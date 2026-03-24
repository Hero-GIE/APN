@extends('layouts.guest')

@section('content')
<style>
    body {
        font-family: 'Open Sans', sans-serif;
        background-color: #f9fafb;
    }
    h1, h2, h3, h4, h5, h6, .font-urbanist {
        font-family: 'Urbanist', sans-serif;
    }
    .breadcrumb-link {
        font-family: 'Open Sans', sans-serif;
        font-size: 0.95rem;
    }
    
    /* Responsive Grid Styles */
    .word-grid {
        display: grid;
        gap: 2px;
        background: #e2e8f0;
        padding: 2px;
        border-radius: 8px;
        overflow: auto;
        user-select: none;
        -webkit-tap-highlight-color: transparent;
    }
    
    .word-cell {
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        aspect-ratio: 1 / 1;
        -webkit-tap-highlight-color: transparent;
    }
    
    /* Responsive font sizes */
    @media (min-width: 1024px) {
        .word-cell {
            font-size: 1.25rem;
        }
    }
    
    @media (max-width: 1024px) and (min-width: 768px) {
        .word-cell {
            font-size: 1rem;
        }
    }
    
    @media (max-width: 768px) {
        .word-cell {
            font-size: 0.875rem;
        }
        .word-grid {
            gap: 1px;
            padding: 1px;
        }
    }
    
    @media (max-width: 480px) {
        .word-cell {
            font-size: 0.75rem;
        }
    }
    
    .word-cell:hover {
        background: #e0e7ff;
        transform: scale(1.05);
    }
    
    .word-cell.selected {
        background: #4f46e5;
        color: white;
    }
    
    .word-cell.found {
        background: #10b981;
        color: white;
        cursor: default;
        text-decoration: line-through;
        opacity: 0.8;
    }
    
    .word-list-item {
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    .word-list-item:hover {
        background: #f1f5f9;
    }
    
    .word-list-item.found {
        background: #d1fae5;
        color: #065f46;
        text-decoration: line-through;
    }
    
    .word-list-item.selected-word {
        background: #e0e7ff;
        border-left: 3px solid #4f46e5;
    }
    
    .timer-badge {
        font-family: monospace;
        font-size: 1.5rem;
        font-weight: bold;
    }
    
    /* Mobile-specific styles */
    @media (max-width: 768px) {
        .timer-badge {
            font-size: 1.25rem;
        }
        
        .word-list-item {
            padding: 0.375rem 0.5rem;
            font-size: 0.875rem;
        }
        
        .submit-btn {
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
        }
    }
    
    /* Touch optimization */
    @media (hover: none) and (pointer: coarse) {
        .word-cell {
            cursor: default;
        }
        
        .word-list-item {
            cursor: default;
        }
    }
    
    .animate-fade-in {
        animation: fadeIn 0.3s ease-in;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Scrollbar styling */
    .word-grid::-webkit-scrollbar {
        width: 4px;
        height: 4px;
    }
    
    .word-grid::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    .word-grid::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    
    .word-grid::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>

<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

<div class="min-h-screen bg-gray-50 py-4 sm:py-8">
    <div class="max-w-6xl mx-auto px-2 sm:px-4 lg:px-8">
        <!-- Breadcrumb -->
        <div class="mb-4 sm:mb-6">
            <div class="flex items-center text-xs sm:text-sm text-gray-500 mb-2 breadcrumb-link">
                <a href="{{ route('member.dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                <svg class="w-3 h-3 sm:w-4 sm:h-4 mx-1 sm:mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700">{{ $puzzle->title }}</span>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-4 sm:p-6">
                <!-- Header -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 sm:mb-6 gap-3">
                    <div class="w-full sm:w-auto">
                        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 font-urbanist">{{ $puzzle->title }}</h1>
                        <p class="text-gray-600 text-xs sm:text-sm mt-1">Find all the hidden words</p>
                    </div>
                    <div class="flex justify-between sm:justify-end items-center w-full sm:w-auto gap-4">
                        @if($puzzle->time_limit)
                        <div class="flex items-center gap-2">
                            <i class="fas fa-hourglass-half text-gray-400 text-sm sm:text-base"></i>
                            <span id="timer" class="timer-badge text-indigo-600">{{ floor($puzzle->time_limit / 60) }}:{{ str_pad($puzzle->time_limit % 60, 2, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        @endif
                        <div class="text-xs sm:text-sm text-gray-500">
                            Words Found: <span id="found-count" class="font-semibold">0</span> / <span id="total-words" class="font-semibold">{{ count($puzzle->words) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Game Grid - Responsive Layout -->
                <div class="flex flex-col lg:flex-row gap-4 sm:gap-6 lg:gap-8">
                    <!-- Left: Word Search Grid -->
                    <div class="w-full lg:w-2/3 overflow-x-auto">
                        <div class="min-w-[300px]">
                            <div id="word-grid" class="word-grid" style="grid-template-columns: repeat({{ $puzzle->grid_size }}, minmax(30px, 1fr));">
                                @php
                                    $grid = is_string($puzzle->grid) ? json_decode($puzzle->grid, true) : $puzzle->grid;
                                @endphp
                                @foreach($grid as $rowIndex => $row)
                                    @foreach($row as $colIndex => $letter)
                                        <div class="word-cell" data-row="{{ $rowIndex }}" data-col="{{ $colIndex }}" data-letter="{{ $letter }}">
                                            {{ $letter }}
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Right: Word List -->
                    <div class="w-full lg:w-1/3">
                        <div class="bg-gray-50 rounded-lg p-3 sm:p-4">
                            <h3 class="font-semibold text-gray-800 mb-2 sm:mb-3 font-urbanist text-sm sm:text-base">Words to Find</h3>
                            <div id="word-list" class="space-y-1 max-h-64 sm:max-h-96 overflow-y-auto">
                                @foreach($puzzle->words as $word)
                                <div class="word-list-item" data-word="{{ strtoupper($word) }}">
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-700 text-sm sm:text-base">{{ strtoupper($word) }}</span>
                                        <i class="fas fa-search text-gray-400 text-xs sm:text-sm"></i>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Instructions -->
                        <div class="mt-3 sm:mt-4 bg-blue-50 rounded-lg p-3 sm:p-4">
                            <p class="text-xs sm:text-sm text-blue-800 flex items-start gap-2">
                                <i class="fas fa-info-circle mt-0.5 text-sm"></i>
                                <span>Click and drag to select letters, or tap on a word to find it. Found words will be marked green.</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-6 text-center">
                    <button onclick="submitCurrentSelection()" id="submitBtn" class="submit-btn w-full sm:w-auto px-4 sm:px-6 py-2.5 sm:py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-medium text-sm sm:text-base">
                        <i class="fas fa-check mr-2"></i> Submit Selected Word
                    </button>
                </div>
            </div>
        </div>

        <!-- Security Footer Note -->
        <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-3 mt-6 sm:mt-8 text-xs text-gray-400">
            <i class="fas fa-circle text-yellow-500" style="font-size:0.35rem;"></i>
            <span>256-bit encrypted</span>
            <i class="fas fa-circle text-yellow-500" style="font-size:0.35rem;"></i>
            <span>Powered by Paystack</span>
            <i class="fas fa-circle text-yellow-500" style="font-size:0.35rem;"></i>
            <span>Secure transactions</span>
        </div>
    </div>
</div>

<script>
let puzzleConfig = {
    id: {{ $puzzle->id }},
    attemptId: {{ $attempt->id }},
    gridSize: {{ $puzzle->grid_size }},
    words: @json($puzzle->words),
    foundWords: @json($attempt->found_words ?? []),
    timeLimit: {{ $puzzle->time_limit ?? 0 }}
};

let selectedCells = [];
let isDragging = false;
let timerInterval = null;
let timeRemaining = puzzleConfig.timeLimit;
let dragDirection = null;
let startCell = null;
let touchTimeout = null;

// Initialize game
document.addEventListener('DOMContentLoaded', function() {
    initializeGrid();
    initializeWordList();
    markFoundWords();
    updateFoundCount();
    
    if (puzzleConfig.timeLimit > 0) {
        startTimer();
    }
});

function initializeGrid() {
    const cells = document.querySelectorAll('.word-cell');
    
    cells.forEach(cell => {
        cell.addEventListener('mousedown', startSelection);
        cell.addEventListener('mouseenter', continueSelection);
        cell.addEventListener('mouseup', endSelection);
        
        // Touch events for mobile
        cell.addEventListener('touchstart', startTouchSelection, { passive: false });
        cell.addEventListener('touchmove', continueTouchSelection, { passive: false });
        cell.addEventListener('touchend', endTouchSelection);
        
        // Prevent default drag behavior
        cell.addEventListener('dragstart', (e) => e.preventDefault());
    });
    
    document.addEventListener('mouseup', endSelection);
    document.addEventListener('mouseleave', () => {
        if (isDragging) endSelection();
    });
}

function startSelection(e) {
    e.preventDefault();
    isDragging = true;
    dragDirection = null;
    startCell = null;
    
    const cell = e.target.closest('.word-cell');
    if (cell && !cell.classList.contains('found')) {
        startCell = cell;
        clearSelection();
        selectCell(cell);
    }
}

function continueSelection(e) {
    if (!isDragging) return;
    e.preventDefault();
    
    const cell = e.target.closest('.word-cell');
    if (!cell || cell.classList.contains('found')) return;
    
    if (selectedCells.length === 0) {
        selectCell(cell);
        return;
    }
    
    const lastCell = selectedCells[selectedCells.length - 1];
    const lastRow = parseInt(lastCell.dataset.row);
    const lastCol = parseInt(lastCell.dataset.col);
    const currentRow = parseInt(cell.dataset.row);
    const currentCol = parseInt(cell.dataset.col);
    
    const rowDiff = currentRow - lastRow;
    const colDiff = currentCol - lastCol;
    
    // Determine direction if not set
    if (dragDirection === null && selectedCells.length === 1) {
        if (Math.abs(rowDiff) > 0 || Math.abs(colDiff) > 0) {
            // Determine the direction based on the movement
            if (Math.abs(rowDiff) > Math.abs(colDiff)) {
                // Vertical movement
                dragDirection = { row: Math.sign(rowDiff), col: 0 };
            } else if (Math.abs(colDiff) > Math.abs(rowDiff)) {
                // Horizontal movement
                dragDirection = { row: 0, col: Math.sign(colDiff) };
            } else {
                // Diagonal movement
                dragDirection = { row: Math.sign(rowDiff), col: Math.sign(colDiff) };
            }
            
            // Add the current cell after setting direction
            if (!selectedCells.includes(cell)) {
                selectCell(cell);
            }
        }
        return;
    }
    
    // If direction is set, handle selection
    if (dragDirection !== null) {
        const expectedRow = lastRow + dragDirection.row;
        const expectedCol = lastCol + dragDirection.col;
        
        // Check if this is the next cell in the drag direction
        if (currentRow === expectedRow && currentCol === expectedCol) {
            if (!selectedCells.includes(cell)) {
                selectCell(cell);
            }
        } 
        // Check if we're going backwards (to deselect)
        else if (selectedCells.length >= 2) {
            const secondLastCell = selectedCells[selectedCells.length - 2];
            const secondLastRow = parseInt(secondLastCell.dataset.row);
            const secondLastCol = parseInt(secondLastCell.dataset.col);
            
            if (currentRow === secondLastRow && currentCol === secondLastCol) {
                // Remove the last cell
                const removedCell = selectedCells.pop();
                if (removedCell) {
                    removedCell.classList.remove('selected');
                }
            }
        }
    }
}

function endSelection() {
    if (!isDragging) return;
    isDragging = false;
    
    if (selectedCells.length > 0) {
        submitCurrentSelection();
    } else {
        dragDirection = null;
        startCell = null;
    }
}

function startTouchSelection(e) {
    e.preventDefault();
    isDragging = true;
    dragDirection = null;
    startCell = null;
    
    const cell = e.target.closest('.word-cell');
    if (cell && !cell.classList.contains('found')) {
        startCell = cell;
        clearSelection();
        selectCell(cell);
    }
}

function continueTouchSelection(e) {
    e.preventDefault();
    if (!isDragging) return;
    
    const touch = e.touches[0];
    const element = document.elementFromPoint(touch.clientX, touch.clientY);
    const cell = element?.closest('.word-cell');
    
    if (!cell || cell.classList.contains('found')) return;
    
    if (selectedCells.length === 0) {
        selectCell(cell);
        return;
    }
    
    const lastCell = selectedCells[selectedCells.length - 1];
    const lastRow = parseInt(lastCell.dataset.row);
    const lastCol = parseInt(lastCell.dataset.col);
    const currentRow = parseInt(cell.dataset.row);
    const currentCol = parseInt(cell.dataset.col);
    
    const rowDiff = currentRow - lastRow;
    const colDiff = currentCol - lastCol;
    
    if (dragDirection === null && selectedCells.length === 1) {
        if (Math.abs(rowDiff) > 0 || Math.abs(colDiff) > 0) {
            if (Math.abs(rowDiff) > Math.abs(colDiff)) {
                dragDirection = { row: Math.sign(rowDiff), col: 0 };
            } else if (Math.abs(colDiff) > Math.abs(rowDiff)) {
                dragDirection = { row: 0, col: Math.sign(colDiff) };
            } else {
                dragDirection = { row: Math.sign(rowDiff), col: Math.sign(colDiff) };
            }
            
            if (!selectedCells.includes(cell)) {
                selectCell(cell);
            }
        }
        return;
    }
    
    if (dragDirection !== null) {
        const expectedRow = lastRow + dragDirection.row;
        const expectedCol = lastCol + dragDirection.col;
        
        if (currentRow === expectedRow && currentCol === expectedCol) {
            if (!selectedCells.includes(cell)) {
                selectCell(cell);
            }
        }
        else if (selectedCells.length >= 2) {
            const secondLastCell = selectedCells[selectedCells.length - 2];
            const secondLastRow = parseInt(secondLastCell.dataset.row);
            const secondLastCol = parseInt(secondLastCell.dataset.col);
            
            if (currentRow === secondLastRow && currentCol === secondLastCol) {
                const removedCell = selectedCells.pop();
                if (removedCell) {
                    removedCell.classList.remove('selected');
                }
            }
        }
    }
}

function endTouchSelection(e) {
    e.preventDefault();
    if (!isDragging) return;
    isDragging = false;
    
    if (selectedCells.length > 0) {
        setTimeout(() => submitCurrentSelection(), 100);
    }
    dragDirection = null;
    startCell = null;
}

function selectCell(cell) {
    if (!cell || selectedCells.includes(cell)) return;
    selectedCells.push(cell);
    cell.classList.add('selected');
}

function clearSelection() {
    selectedCells.forEach(cell => {
        if (cell) cell.classList.remove('selected');
    });
    selectedCells = [];
    dragDirection = null;
}

function getSelectedWord() {
    let word = '';
    for (let i = 0; i < selectedCells.length; i++) {
        if (selectedCells[i]) {
            word += selectedCells[i].dataset.letter;
        }
    }
    return word;
}

function submitCurrentSelection() {
    if (selectedCells.length === 0) return;
    
    const word = getSelectedWord();
    const positions = selectedCells.map(cell => ({
        row: parseInt(cell.dataset.row),
        col: parseInt(cell.dataset.col)
    }));
    
    if (puzzleConfig.foundWords.includes(word)) {
        clearSelection();
        showMessage('Word already found!', 'warning');
        return;
    }
    
    submitWord(word, positions);
}

function submitWord(word, positions) {
    const submitBtn = document.getElementById('submitBtn');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Checking...';
    
    fetch(`/wordsearch/submit/${puzzleConfig.attemptId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            word: word,
            positions: positions
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.word_found) {
            positions.forEach(pos => {
                const cell = document.querySelector(`.word-cell[data-row="${pos.row}"][data-col="${pos.col}"]`);
                if (cell) {
                    cell.classList.add('found');
                    cell.classList.remove('selected');
                }
            });
            
            const wordElement = document.querySelector(`.word-list-item[data-word="${word}"]`);
            if (wordElement) {
                wordElement.classList.add('found');
            }
            
            puzzleConfig.foundWords.push(word);
            updateFoundCount();
            
            showMessage(`Found "${word}"! +1 point`, 'success');
            
            if (data.completed) {
                showMessage('Congratulations! You found all words!', 'success');
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 2000);
            }
            
            clearSelection();
        } else {
            clearSelection();
            showMessage(data.message || 'Word not found!', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        clearSelection();
        showMessage('Error submitting word. Please try again.', 'error');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
}

function markFoundWords() {
    puzzleConfig.foundWords.forEach(word => {
        const wordElement = document.querySelector(`.word-list-item[data-word="${word}"]`);
        if (wordElement) {
            wordElement.classList.add('found');
        }
    });
}

function updateFoundCount() {
    document.getElementById('found-count').textContent = puzzleConfig.foundWords.length;
}

function initializeWordList() {
    const words = document.querySelectorAll('.word-list-item');
    words.forEach(wordEl => {
        wordEl.addEventListener('click', () => {
            const word = wordEl.dataset.word;
            if (!wordEl.classList.contains('found')) {
                highlightWordInGrid(word);
            }
        });
    });
}

function highlightWordInGrid(word) {
    clearSelection();
    showMessage(`Searching for "${word}"...`, 'info');
}

function showMessage(message, type) {
    const existingMessages = document.querySelectorAll('.game-message');
    existingMessages.forEach(msg => msg.remove());
    
    const messageDiv = document.createElement('div');
    messageDiv.className = `game-message fixed bottom-4 right-4 px-3 sm:px-4 py-2 rounded-lg text-white text-sm sm:text-base ${
        type === 'success' ? 'bg-green-500' : 
        type === 'error' ? 'bg-red-500' : 
        type === 'warning' ? 'bg-yellow-500' : 'bg-blue-500'
    } z-50 animate-fade-in`;
    messageDiv.style.zIndex = '9999';
    messageDiv.innerHTML = message;
    document.body.appendChild(messageDiv);
    
    setTimeout(() => {
        messageDiv.remove();
    }, 3000);
}

function startTimer() {
    timerInterval = setInterval(() => {
        timeRemaining--;
        
        const minutes = Math.floor(timeRemaining / 60);
        const seconds = timeRemaining % 60;
        const timerElement = document.getElementById('timer');
        if (timerElement) {
            timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
        }
        
        if (timeRemaining <= 60) {
            const timerElement = document.getElementById('timer');
            if (timerElement) timerElement.classList.add('text-red-600');
        }
        
        if (timeRemaining <= 0) {
            clearInterval(timerInterval);
            autoSubmit();
        }
    }, 1000);
}

function autoSubmit() {
    showMessage('Time\'s up! Submitting your results...', 'warning');
    fetch(`/wordsearch/submit/${puzzleConfig.attemptId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            auto_submit: true
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.redirect) {
            window.location.href = data.redirect;
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
</script>
@endsection