@extends('layouts.guest')

@section('content')
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
    --ink    : #1a1f36;
    --indigo : #3730a3;
    --indigo2: #4f46e5;
    --mist   : #f8fafc;
    --border : #e2e8f0;
    --sub    : #64748b;
    --white  : #ffffff;
    --error  : #dc2626;
    --radius : 8px; 
    --trans  : .25s cubic-bezier(0.4, 0, 0.2, 1);
}

body {
    font-family: 'Lora', sans-serif;
    background: #f1f5f9;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    position: relative;
    margin: 0;
}

/* Lora for headings */
h1, h2, h3, h4, .font-serif {
    font-family: 'Lora', serif;
}

/* Animated Background */
.bg-scene {
    position: fixed; inset: 0; z-index: 0; overflow: hidden;
    background: linear-gradient(145deg, #f1f5f9 0%, #eef2f6 60%, #e9eef5 100%);
}

.bg-scene .orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(60px);
    opacity: 0.4;
    animation: orbFloat 20s infinite alternate;
}

.orb-1 {
    width: 600px; height: 600px;
    background: radial-gradient(circle, rgba(79,70,229,0.15) 0%, transparent 70%);
    top: -200px; right: -200px;
    animation-duration: 25s;
}

.orb-2 {
    width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(55,48,163,0.12) 0%, transparent 70%);
    bottom: -200px; left: -100px;
    animation-duration: 30s;
    animation-direction: reverse;
}

.orb-3 {
    width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(139,92,246,0.1) 0%, transparent 70%);
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    animation-duration: 35s;
    filter: blur(80px);
}

@keyframes orbFloat {
    0% { transform: translate(0, 0) scale(1); }
    100% { transform: translate(40px, 20px) scale(1.1); }
}

/* Floating particles */
.particle {
    position: absolute;
    background: rgba(79,70,229,0.1);
    border-radius: 50%;
    pointer-events: none;
    animation: particleFloat 15s infinite linear;
}

@keyframes particleFloat {
    from { transform: translateY(100vh) rotate(0deg); }
    to { transform: translateY(-100px) rotate(360deg); }
}

/* Main Card */
.card {
    position: relative; z-index: 10;
    width: 100%;
    max-width: 560px;
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-radius: var(--radius); 
    padding: 2rem;
    box-shadow: 
        0 25px 50px -12px rgba(0,0,0,0.25),
        0 0 0 1px rgba(255,255,255,0.6) inset;
    animation: cardReveal 0.7s cubic-bezier(0.22, 1, 0.36, 1) both;
    margin: 1rem;
}

@keyframes cardReveal {
    from { opacity: 0; transform: translateY(30px) scale(0.98); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

/* Brand */
.brand {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    justify-content: center;
    flex-wrap: wrap;
}

.brand-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #3730a3, #4f46e5);
    border-radius: calc(var(--radius) - 2px); 
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    box-shadow: 0 10px 15px -3px rgba(79,70,229,0.3);
    flex-shrink: 0;
}

.brand-text {
    font-family: 'Lora', serif;
    font-size: 1.25rem;
    font-weight: 800;
    background: linear-gradient(135deg, #1a1f36, #3730a3);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    letter-spacing: -0.02em;
}

/* Success Icon */
.success-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #3730a3, #4f46e5);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.25rem;
    box-shadow: 0 20px 30px -10px rgba(79,70,229,0.4);
    animation: iconPop 0.6s cubic-bezier(0.22, 1, 0.36, 1) both;
}

@keyframes iconPop {
    from { opacity: 0; transform: scale(0.5); }
    to { opacity: 1; transform: scale(1); }
}

.success-icon i {
    color: white;
    font-size: 2rem;
}

/* Card Title */
.card-title {
    font-family: 'Syne', sans-serif;
    font-size: 1.75rem;
    font-weight: 700;
    color: #1a1f36;
    margin-bottom: 0.5rem;
    line-height: 1.2;
    text-align: center;
}

.card-sub {
    color: #64748b;
    font-size: 0.9rem;
    margin-bottom: 1.5rem;
    text-align: center;
    font-family: 'Lora', serif;
    line-height: 1.5;
}

/* Receipt Card */
.receipt-card {
    background: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: var(--radius);
    padding: 1rem 1.25rem;
    margin-bottom: 1.25rem;
    transition: all 0.3s ease;
}

.receipt-card:hover {
    border-color: #4f46e5;
    box-shadow: 0 4px 12px rgba(79,70,229,0.1);
}

.receipt-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 2px solid #e2e8f0;
    font-size: 0.9rem;
    gap: 1rem;
    flex-wrap: wrap;
}

.receipt-row:last-child {
    border-bottom: none;
}

.receipt-label {
    color: #64748b;
    font-family: 'Lora', serif;
    flex-shrink: 0;
}

.receipt-value {
    color: #1a1f36;
    font-weight: 600;
    font-family: 'Syne', sans-serif;
    text-align: right;
    word-break: break-word;
    flex: 1;
}

.amount-value {
    font-size: 1.2rem;
    color: #4f46e5;
}

/* Reference container with ellipsis and copy button */
.reference-container {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex: 1;
    justify-content: flex-end;
}

.reference-value {
    font-family: monospace;
    background: #f1f5f9;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.85rem;
    max-width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    flex: 1;
    text-align: left;
}

.copy-btn {
    background: transparent;
    border: none;
    color: #4f46e5;
    cursor: pointer;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    transition: all 0.2s ease;
    font-size: 0.8rem;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    flex-shrink: 0;
}

.copy-btn:hover {
    background: #e0e7ff;
    transform: scale(1.05);
}

.copy-btn:active {
    transform: scale(0.95);
}

.copy-success {
    color: #10b981;
}

.status-badge {
    background: #e8f5e9;
    color: #2e7d32;
    font-size: 0.7rem;
    font-weight: 700;
    padding: 0.25rem 1rem;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    white-space: nowrap;
}

.status-badge i {
    font-size: 0.65rem;
}

/* Info Box */
.info-box {
    background: #e8f0fe;
    border: 2px solid #c7d9f0;
    border-radius: var(--radius);
    padding: 1rem;
    margin-bottom: 1.25rem;
    font-size: 0.85rem;
    color: #1e3a6f;
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.info-box i {
    color: #4f46e5;
    font-size: 1rem;
    margin-top: 2px;
    flex-shrink: 0;
}

.info-content {
    flex: 1;
}

.info-content strong {
    color: #1e3a6f;
    display: block;
    margin-bottom: 0.25rem;
    font-size: 0.9rem;
}

.info-content p {
    margin: 0;
    line-height: 1.5;
    font-size: 0.85rem;
}

/* Buttons */
.btn-primary {
    display: flex;
    width: 100%;
    padding: 0.875rem 1rem;
    background: linear-gradient(135deg, #3730a3, #4f46e5);
    color: white;
    border: none;
    border-radius: var(--radius);
    font-family: 'Syne', sans-serif;
    font-size: 0.9rem;
    font-weight: 700;
    text-decoration: none;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 10px 15px -3px rgba(79,70,229,0.3);
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    position: relative;
    overflow: hidden;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    margin-bottom: 0.75rem;
}

.btn-primary::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.7s ease;
}

.btn-primary:hover::before {
    left: 100%;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 20px 25px -5px rgba(79,70,229,0.4);
}

.btn-primary i {
    transition: transform 0.3s ease;
}

.btn-primary:hover i {
    transform: translateX(5px);
}

/* Security Note */
.security-note {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 1.5rem;
    font-size: 0.65rem;
    color: #94a3b8;
    animation: fadeIn 0.5s 0.5s both;
    flex-wrap: wrap;
    text-align: center;
}

.security-note i {
    color: #4f46e5;
    font-size: 0.5rem;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Footer */
.footer-note {
    margin-top: 1.25rem;
    font-size: 0.65rem;
    color: #94a3b8;
    text-align: center;
}

/* Toast notification */
.copy-toast {
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    background: #1f2937;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-size: 0.85rem;
    z-index: 1000;
    animation: slideUp 0.3s ease, fadeOut 2s ease 1.7s forwards;
    pointer-events: none;
    white-space: nowrap;
    font-family: 'Syne', sans-serif;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateX(-50%) translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
}

/* Responsive Design */
@media screen and (max-width: 640px) {
    body {
        padding: 0.5rem;
    }
    
    .card {
        padding: 1.5rem;
        margin: 0.5rem;
    }
    
    .card-title {
        font-size: 1.5rem;
    }
    
    .brand-text {
        font-size: 1rem;
    }
    
    .receipt-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
        padding: 0.625rem 0;
    }
    
    .receipt-value {
        text-align: left;
        width: 100%;
    }
    
    .reference-container {
        width: 100%;
        justify-content: flex-start;
    }
    
    .reference-value {
        max-width: calc(100% - 60px);
    }
}

@media screen and (max-width: 480px) {
    .card {
        padding: 1.25rem;
    }
    
    .reference-value {
        font-size: 0.7rem;
    }
    
    .copy-btn {
        font-size: 0.7rem;
        padding: 0.2rem 0.4rem;
    }
}
</style>

<div class="bg-scene">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
</div>

<div class="card">
    <!-- Brand -->
    <div class="brand">
        <div class="brand-icon">
            <i class="fas fa-hand-holding-heart"></i>
        </div>
        <span class="brand-text">APN Donation</span>
    </div>

    <div class="success-icon">
        <i class="fas fa-check"></i>
    </div>

    <!-- Header -->
    <h1 class="card-title">Thank You!</h1>
    <p class="card-sub">Your donation has been received successfully.</p>

    @if(isset($donation) && $donation)
    <div class="receipt-card">
        <div class="receipt-row">
            <span class="receipt-label">Amount</span>
            <span class="receipt-value amount-value">{{ $donation->currency }} {{ number_format($donation->amount, 2) }}</span>
        </div>
        <div class="receipt-row">
            <span class="receipt-label">Reference</span>
            <div class="reference-container">
                <span class="reference-value" id="transactionRef">{{ $donation->transaction_id }}</span>
                <button class="copy-btn" onclick="copyToClipboard('{{ $donation->transaction_id }}')">
                    <i class="fas fa-copy"></i>
                    <span class="copy-text">Copy</span>
                </button>
            </div>
        </div>
        <div class="receipt-row">
            <span class="receipt-label">Date</span>
            <span class="receipt-value">{{ $donation->created_at->format('d M Y, g:i A') }}</span>
        </div>
        <div class="receipt-row">
            <span class="receipt-label">Status</span>
            <span class="status-badge">
                <i class="fas fa-check-circle"></i>
                Successful
            </span>
        </div>
    </div>
    @else
    <div class="receipt-card">
        <div class="receipt-row">
            <span class="receipt-label">Reference</span>
            <div class="reference-container">
                <span class="reference-value" id="transactionRef">{{ $reference }}</span>
                <button class="copy-btn" onclick="copyToClipboard('{{ $reference }}')">
                    <i class="fas fa-copy"></i>
                    <span class="copy-text">Copy</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    <div class="info-box">
        <i class="fas fa-envelope-open-text"></i>
        <div class="info-content">
            <strong>Check your email</strong>
            <p>We've sent your donation receipt to your email address.</p>
        </div>
    </div>

    <!-- Actions -->
    @if(Auth::guard('donor')->check())
        @php
            $member = Auth::guard('donor')->user() ? \App\Models\Member::where('donor_id', Auth::guard('donor')->id())->first() : null;
        @endphp
        
        @if($member && $member->status == 'active')
            <a href="{{ route('member.dashboard') }}" class="btn-primary">
                <span>Go to Member Dashboard</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        @else
            <a href="{{ route('donor.dashboard') }}" class="btn-primary">
                <span>Go to Donor Dashboard</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        @endif
    @else
        <a href="{{ route('donor.login') }}" class="btn-primary">
            <span>Login to Dashboard</span>
            <i class="fas fa-arrow-right"></i>
        </a>
    @endif

    <!-- Security Note -->
    <div class="security-note">
        <i class="fas fa-circle"></i>
        <span>256‑bit encrypted transaction</span>
        <i class="fas fa-circle"></i>
        <span>Secure receipt</span>
    </div>

    <!-- Footer -->
    <p class="footer-note">© {{ date('Y') }} Africa Prosperity Network</p>
</div>

<script>
function createParticles() {
    const scene = document.querySelector('.bg-scene');
    if (!scene) return;
    
    const particleCount = Math.min(20, Math.floor(window.innerWidth / 50));
    for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        particle.style.width = Math.random() * 4 + 2 + 'px';
        particle.style.height = particle.style.width;
        particle.style.left = Math.random() * 100 + '%';
        particle.style.animationDelay = Math.random() * 10 + 's';
        particle.style.animationDuration = Math.random() * 10 + 15 + 's';
        scene.appendChild(particle);
    }
}

// Copy to clipboard function
function copyToClipboard(text) {
    // Modern approach
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(text).then(() => {
            showCopySuccess();
        }).catch(err => {
            console.error('Failed to copy: ', err);
            fallbackCopy(text);
        });
    } else {
        fallbackCopy(text);
    }
}

// Fallback copy method
function fallbackCopy(text) {
    const textarea = document.createElement('textarea');
    textarea.value = text;
    textarea.style.position = 'fixed';
    textarea.style.opacity = '0';
    document.body.appendChild(textarea);
    textarea.select();
    
    try {
        const successful = document.execCommand('copy');
        if (successful) {
            showCopySuccess();
        } else {
            showCopyError();
        }
    } catch (err) {
        console.error('Fallback: Oops, unable to copy', err);
        showCopyError();
    }
    
    document.body.removeChild(textarea);
}

// Show success notification
function showCopySuccess() {
    // Update button text temporarily
    const copyBtn = document.querySelector('.copy-btn');
    if (copyBtn) {
        const copyText = copyBtn.querySelector('.copy-text');
        const originalText = copyText.textContent;
        
        copyText.textContent = 'Copied!';
        copyBtn.classList.add('copy-success');
        
        // Reset button text after 2 seconds
        setTimeout(() => {
            copyText.textContent = originalText;
            copyBtn.classList.remove('copy-success');
        }, 2000);
    }
    
    // Create toast notification
    const toast = document.createElement('div');
    toast.className = 'copy-toast';
    toast.innerHTML = '<i class="fas fa-check-circle" style="margin-right: 8px;"></i> Reference copied to clipboard!';
    document.body.appendChild(toast);
    
    // Remove toast after 2 seconds
    setTimeout(() => {
        toast.remove();
    }, 2000);
}

// Show error notification
function showCopyError() {
    const toast = document.createElement('div');
    toast.className = 'copy-toast';
    toast.style.background = '#dc2626';
    toast.innerHTML = '<i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i> Failed to copy. Please try again.';
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 2000);
}

createParticles();

// Handle resize for particles
let resizeTimeout;
window.addEventListener('resize', function() {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(function() {
        const scene = document.querySelector('.bg-scene');
        if (scene) {
            const particles = scene.querySelectorAll('.particle');
            particles.forEach(p => p.remove());
            createParticles();
        }
    }, 250);
});
</script>
@endsection