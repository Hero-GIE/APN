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
    padding: 1.5rem;
    position: relative;
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
    width: 520px; max-width: 100%;
    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-radius: var(--radius); 
    padding: 2.5rem;
    box-shadow: 
        0 25px 50px -12px rgba(0,0,0,0.25),
        0 0 0 1px rgba(255,255,255,0.6) inset;
    animation: cardReveal 0.7s cubic-bezier(0.22, 1, 0.36, 1) both;
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
    margin-bottom: 2rem;
    justify-content: center;
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
}

.brand-text {
    font-family: 'Lora', serif;
    font-size: 1.5rem;
    font-weight: 800;
    background: linear-gradient(135deg, #1a1f36, #3730a3);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    letter-spacing: -0.02em;
}

/* Success Icon */
.success-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #3730a3, #4f46e5);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    box-shadow: 0 20px 30px -10px rgba(79,70,229,0.4);
    animation: iconPop 0.6s cubic-bezier(0.22, 1, 0.36, 1) both;
}

@keyframes iconPop {
    from { opacity: 0; transform: scale(0.5); }
    to { opacity: 1; transform: scale(1); }
}

.success-icon i {
    color: white;
    font-size: 2.5rem;
}

/* Card Title */
.card-title {
    font-family: 'Syne', sans-serif;
    font-size: 2rem;
    font-weight: 700;
    color: #1a1f36;
    margin-bottom: 0.5rem;
    line-height: 1.2;
    text-align: center;
}

.card-sub {
    color: #64748b;
    font-size: 0.95rem;
    margin-bottom: 2rem;
    text-align: center;
    font-family: 'Lora', serif;
}

/* Receipt Card */
.receipt-card {
    background: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: var(--radius);
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.5rem;
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
    font-size: 0.95rem;
}

.receipt-row:last-child {
    border-bottom: none;
}

.receipt-label {
    color: #64748b;
    font-family: 'Lora', serif;
}

.receipt-value {
    color: #1a1f36;
    font-weight: 600;
    font-family: 'Syne', sans-serif;
}

.amount-value {
    font-size: 1.3rem;
    color: #4f46e5;
}

.reference-value {
    font-family: monospace;
    background: #f1f5f9;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.85rem;
}

.status-badge {
    background: #e8f5e9;
    color: #2e7d32;
    font-size: 0.75rem;
    font-weight: 700;
    padding: 0.25rem 1rem;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}

.status-badge i {
    font-size: 0.7rem;
}

/* Info Box */
.info-box {
    background: #e8f0fe;
    border: 2px solid #c7d9f0;
    border-radius: var(--radius);
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
    font-size: 0.9rem;
    color: #1e3a6f;
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.info-box i {
    color: #4f46e5;
    font-size: 1.1rem;
    margin-top: 2px;
}

.info-content {
    flex: 1;
}

.info-content strong {
    color: #1e3a6f;
    display: block;
    margin-bottom: 0.25rem;
}

.info-content p {
    margin: 0;
    line-height: 1.5;
}

/* Buttons */
.btn-primary {
    display: block;
    width: 100%;
    padding: 1rem;
    background: linear-gradient(135deg, #3730a3, #4f46e5);
    color: white;
    border: none;
    border-radius: var(--radius);
    font-family: 'Syne', sans-serif;
    font-size: 1rem;
    font-weight: 700;
    text-decoration: none;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 10px 15px -3px rgba(79,70,229,0.3);
    display: flex;
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

.btn-secondary {
    display: block;
    width: 100%;
    padding: 1rem;
    background: #f8fafc;
    color: #4f46e5;
    border: 2px solid #e2e8f0;
    border-radius: var(--radius);
    font-family: 'Syne', sans-serif;
    font-size: 0.95rem;
    font-weight: 600;
    text-decoration: none;
    text-align: center;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
}

.btn-secondary:hover {
    background: #e8f0fe;
    border-color: #4f46e5;
    transform: translateY(-2px);
}

/* Security Note */
.security-note {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 2rem;
    font-size: 0.7rem;
    color: #94a3b8;
    animation: fadeIn 0.5s 0.5s both;
}

.security-note i {
    color: #4f46e5;
    font-size: 0.6rem;
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
    margin-top: 1.5rem;
    font-size: 0.7rem;
    color: #94a3b8;
    text-align: center;
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
            <span class="receipt-value reference-value">{{ $donation->transaction_id }}</span>
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
    <div class="receipt-card" style="text-align: center;">
        <p style="color: #64748b; margin: 0;">Reference: <strong style="color: #1a1f36;">{{ $reference }}</strong></p>
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
    for (let i = 0; i < 20; i++) {
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
createParticles();
</script>
@endsection