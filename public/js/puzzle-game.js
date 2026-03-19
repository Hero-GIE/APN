class PuzzleGame {
    constructor(config) {
        this.attemptId = config.attemptId;
        this.questions = config.questions;
        this.timeLimit = config.timeLimit;
        this.hintsAllowed = config.hintsAllowed;
        this.hintsUsed = config.hintsUsed || 0;
        
        this.currentQuestion = 0;
        this.answers = [];
        this.questionTimes = [];
        this.startTime = Date.now();
        this.questionStartTime = Date.now();
        this.timer = null;
        this.hintUsedForQuestion = {};
        
        this.init();
    }
    
    init() {
        this.renderQuestion();
        this.setupEventListeners();
        
        if (this.timeLimit) {
            this.startTimer();
        }
    }
    
    renderQuestion() {
        const question = this.questions[this.currentQuestion];
        const container = document.getElementById('question-container');
        
        let html = `
            <div class="question-header mb-6">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">
                        Question ${this.currentQuestion + 1} of ${this.questions.length}
                    </span>
                    ${this.timeLimit ? `
                        <span id="timer" class="text-lg font-bold text-indigo-600">
                            ${this.formatTime(this.getRemainingTime())}
                        </span>
                    ` : ''}
                </div>
                <div class="w-full bg-gray-200 h-2 rounded-full mt-2">
                    <div class="bg-indigo-600 h-2 rounded-full" style="width: ${((this.currentQuestion + 1) / this.questions.length) * 100}%"></div>
                </div>
            </div>
            
            <div class="question-body mb-8">
                ${question.image ? `<img src="${question.image}" class="mb-4 rounded-lg max-h-64 mx-auto">` : ''}
                <h3 class="text-xl font-bold text-gray-900 mb-4">${question.question}</h3>
                
                <div class="space-y-3">
                    ${question.options.map((option, index) => `
                        <label class="option-item flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-indigo-300 transition-all">
                            <input type="radio" name="answer" value="${option}" class="hidden">
                            <span class="w-6 h-6 flex items-center justify-center rounded-full border-2 border-gray-300 mr-3">
                                ${String.fromCharCode(65 + index)}
                            </span>
                            <span class="text-gray-700">${option}</span>
                        </label>
                    `).join('')}
                </div>
            </div>
            
            <div class="question-footer flex justify-between items-center">
                <div>
                    ${this.hintsAllowed > 0 && !this.hintUsedForQuestion[this.currentQuestion] ? `
                        <button onclick="game.useHint()" class="text-sm text-indigo-600 hover:text-indigo-800">
                            <i class="fas fa-lightbulb mr-1"></i>
                            Use Hint (${this.hintsAllowed - this.hintsUsed} left)
                        </button>
                    ` : ''}
                </div>
                <div class="flex space-x-3">
                    ${this.currentQuestion < this.questions.length - 1 ? `
                        <button onclick="game.nextQuestion()" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                            Next
                        </button>
                    ` : `
                        <button onclick="game.submit()" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            Submit Answers
                        </button>
                    `}
                </div>
            </div>
        `;
        
        container.innerHTML = html;
        
        // Add click handlers for options
        document.querySelectorAll('.option-item').forEach(item => {
            item.addEventListener('click', function() {
                this.querySelector('input').checked = true;
                document.querySelectorAll('.option-item').forEach(opt => {
                    opt.classList.remove('border-indigo-600', 'bg-indigo-50');
                });
                this.classList.add('border-indigo-600', 'bg-indigo-50');
            });
        });
        
        // Preserve answer if already selected
        const currentAnswer = this.answers[this.currentQuestion];
        if (currentAnswer) {
            const radio = document.querySelector(`input[value="${currentAnswer}"]`);
            if (radio) {
                radio.checked = true;
                radio.closest('.option-item').classList.add('border-indigo-600', 'bg-indigo-50');
            }
        }
        
        this.questionStartTime = Date.now();
    }
    
    nextQuestion() {
        // Save current answer
        const selected = document.querySelector('input[name="answer"]:checked');
        if (!selected) {
            alert('Please select an answer');
            return;
        }
        
        this.answers[this.currentQuestion] = selected.value;
        this.questionTimes[this.currentQuestion] = Math.floor((Date.now() - this.questionStartTime) / 1000);
        
        this.currentQuestion++;
        this.renderQuestion();
    }
    
    useHint() {
        if (this.hintsUsed >= this.hintsAllowed) return;
        
        const question = this.questions[this.currentQuestion];
        const hint = question.hint;
        
        if (hint) {
            alert(`Hint: ${hint}`);
            this.hintsUsed++;
            this.hintUsedForQuestion[this.currentQuestion] = true;
        }
        
        // Update hint button
        const hintBtn = document.querySelector('.hint-btn');
        if (hintBtn) {
            hintBtn.textContent = `Use Hint (${this.hintsAllowed - this.hintsUsed} left)`;
            if (this.hintsUsed >= this.hintsAllowed) {
                hintBtn.style.display = 'none';
            }
        }
    }
    
    submit() {
        // Save last answer
        const selected = document.querySelector('input[name="answer"]:checked');
        if (!selected) {
            alert('Please select an answer');
            return;
        }
        
        this.answers[this.currentQuestion] = selected.value;
        this.questionTimes[this.currentQuestion] = Math.floor((Date.now() - this.questionStartTime) / 1000);
        
        // Calculate total time
        const totalTime = Math.floor((Date.now() - this.startTime) / 1000);
        
        // Show loading
        this.showLoading();
        
        // Submit answers
        fetch(`/puzzles/submit/${this.attemptId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                answers: this.answers,
                time_taken: totalTime,
                question_times: this.questionTimes
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                this.hideLoading();
                alert('Error submitting answers. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            this.hideLoading();
            alert('Network error. Please check your connection.');
        });
    }
    
    startTimer() {
        this.timer = setInterval(() => {
            const remaining = this.getRemainingTime();
            const timerEl = document.getElementById('timer');
            
            if (timerEl) {
                timerEl.textContent = this.formatTime(remaining);
                
                if (remaining <= 60) {
                    timerEl.classList.add('text-red-600');
                }
                
                if (remaining <= 0) {
                    clearInterval(this.timer);
                    this.timeout();
                }
            }
        }, 1000);
    }
    
    getRemainingTime() {
        const elapsed = Math.floor((Date.now() - this.startTime) / 1000);
        return Math.max(0, this.timeLimit - elapsed);
    }
    
    formatTime(seconds) {
        const mins = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return `${mins}:${secs.toString().padStart(2, '0')}`;
    }
    
    timeout() {
        alert('Time is up! Submitting your answers...');
        this.submit();
    }
    
    showLoading() {
        const btn = document.querySelector('button[onclick="game.submit()"]');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Submitting...';
        }
    }
    
    hideLoading() {
        const btn = document.querySelector('button[onclick="game.submit()"]');
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = 'Submit Answers';
        }
    }
}

// Initialize game
document.addEventListener('DOMContentLoaded', function() {
    if (typeof puzzleConfig !== 'undefined') {
        window.game = new PuzzleGame(puzzleConfig);
    }
});