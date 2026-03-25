@extends('layouts.guest')

@section('content')
<style>
    * { font-family: 'Open Sans', sans-serif; }
    h1,h2,h3,h4,h5,h6,
    .font-syne,
    .price-tag { font-family: 'Urbanist', sans-serif !important; }

    @keyframes pageReveal { from { opacity: 0; transform: scale(1.02); } to { opacity: 1; transform: scale(1); } }
    @keyframes patternMove { from { background-position: 0 0; } to { background-position: 200px 200px; } }
    @keyframes gradientShift { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }
    @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-18px); } }
    @keyframes pulseSlow { 0%, 100% { opacity: 0.6; } 50% { opacity: 1; } }
    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

    .animate-page-reveal  { animation: pageReveal 0.9s cubic-bezier(0.22,1,0.36,1) both; }
    .animate-pattern      { animation: patternMove 60s linear infinite; }
    .animate-gradient     { animation: gradientShift 5s ease infinite; background-size: 200% 200%; }
    .animate-float        { animation: float 6s ease-in-out infinite; }
    .animate-pulse-slow   { animation: pulseSlow 3s ease-in-out infinite; }

    .apn-scrollbar::-webkit-scrollbar { width: 6px; }
    .apn-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
    .apn-scrollbar::-webkit-scrollbar-thumb { background: #4f46e5; border-radius: 3px; }

    .apn-layout { display: flex; width: 100%; min-height: 100vh; }
    .left-panel { background: #fff; overflow-y: auto; display: flex; align-items: flex-start; justify-content: center; }
    .right-panel { position: relative; overflow: hidden; background-size: cover; background-position: center; background-image: url('https://membership.africaprosperitynetwork.com/wp-content/uploads/2026/03/Group-600.jpg'); flex-shrink: 0; display: flex; flex-direction: column; justify-content: flex-end; }

    @media (min-width: 1024px) {
        .apn-layout { flex-direction: row; height: 100vh; overflow: hidden; }
        .left-panel { width: 50%; height: 100vh; }
        .right-panel { width: 50%; min-height: 100vh; }
    }
    @media (min-width: 640px) and (max-width: 1023px) {
        .apn-layout { flex-direction: column; }
        .left-panel { width: 100%; }
        .right-panel { width: 100%; min-height: 320px; }
    }
    @media (max-width: 639px) {
        .apn-layout { flex-direction: column; }
        .left-panel { width: 100%; }
        .right-panel { width: 100%; min-height: 240px; }
        .right-panel .panel-text { padding: 1.5rem 1.25rem; }
        .right-panel .panel-heading { font-size: 1.8rem !important; }
        .right-panel .panel-sub { display: none; }
        .back-link { display: none !important; }
        .register-btn-top { top: 1rem !important; right: 1rem !important; padding: 0.5rem 0.9rem !important; font-size: 0.75rem !important; }
        .login-card-wrap { padding: 1.5rem !important; margin-top: 1.5rem !important; }
    }

    .btn-login { position: relative; overflow: hidden; transition: all 0.3s ease; }
    .btn-login::before { content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent); transition: left 0.7s ease; }
    .btn-login:hover::before { left: 100%; }
    .btn-login:hover { transform: translateY(-2px); box-shadow: 0 18px 24px -6px rgba(79,70,229,0.4); }
    .btn-login.loading { opacity: 0.8; cursor: not-allowed; }
    .btn-login.loading i { animation: spin 1s linear infinite; }

    .field-apn { width: 100%; padding: 1rem 1rem 1rem 2.7rem; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 0.88rem; color: #1e293b; transition: all 0.3s ease; outline: none; font-family: 'Open Sans', sans-serif; }
    .field-apn:focus { border-color: #4f46e5; background: #fff; box-shadow: 0 0 0 4px rgba(79,70,229,0.1); transform: translateY(-2px); }
    .field-wrap { position: relative; }
    .field-wrap .fi { position: absolute; left: 0.9rem; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.85rem; pointer-events: none; }
    .field-wrap .fi-right { position: absolute; right: 0.9rem; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.85rem; cursor: pointer; transition: color 0.2s ease; }
    .field-wrap .fi-right:hover { color: #4f46e5; }

    /* Logo circle styles */
    .logo-circle {
        width: 100px;
        height: 100px;
        background-color: rgb(16, 16, 70);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem auto;
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.3);
        transition: transform 0.3s ease;
    }
    .logo-circle:hover {
        transform: scale(1.05);
    }
    .logo-circle img {
        max-width: 96px;
        max-height: 96px;
        filter: brightness(0) invert(1);
    }
</style>

<div class="apn-layout animate-page-reveal">

    <!-- Right Panel -->
    <div class="right-panel">

        <div class="absolute inset-0 bg-gradient-to-br from-[#0f172a]/60 via-[#1e1b4b]/50 to-[#2d1b4b]/35 z-[1]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_50%,rgba(212,175,55,0.15),transparent_60%)] z-[2] pointer-events-none"></div>
        <div class="absolute inset-0 opacity-10 z-[3] pointer-events-none animate-pattern"
             style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><path d=\"M20,20 L30,10 L40,20 L50,10 L60,20 L70,10 L80,20 L70,30 L80,40 L70,50 L80,60 L70,70 L80,80 L70,90 L60,80 L50,90 L40,80 L30,90 L20,80 L30,70 L20,60 L30,50 L20,40 L30,30 Z\" fill=\"%23D4AF37\" opacity=\"0.15\"/><circle cx=\"50\" cy=\"50\" r=\"5\" fill=\"%234f46e5\" opacity=\"0.15\"/></svg>'); background-size:100px 100px; background-repeat:repeat;"></div>
        <div class="absolute z-[3] w-56 h-56 rounded-full bg-[#D4AF37]/5 blur-3xl top-16 left-8 animate-float pointer-events-none"></div>
        <div class="absolute z-[3] w-44 h-44 rounded-full bg-[#4f46e5]/5 blur-3xl bottom-32 right-8 animate-float pointer-events-none" style="animation-delay:2s;"></div>

        <div class="relative z-[4] px-8 md:px-14 py-12 text-white bg-gradient-to-t from-black/60 via-black/25 to-transparent panel-text">
            <div class="flex items-center gap-3 mb-4 text-xs font-semibold tracking-[3px] uppercase" style="font-family:'Urbanist',sans-serif;">
                <span class="w-10 h-[2px] bg-gradient-to-r from-[#D4AF37] to-transparent"></span>
                <span class="text-[#D4AF37] animate-pulse-slow">WELCOME BACK</span>
                <span class="w-10 h-[2px] bg-gradient-to-l from-[#D4AF37] to-transparent"></span>
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold leading-[1.1] mb-4 drop-shadow-lg panel-heading" style="font-family:'Urbanist',sans-serif;">
                Reconnect with<br>
                <span class="text-[#D4AF37] relative inline-block">
                    Africa's Future
                    <span class="absolute bottom-2 left-0 w-full h-3 bg-[#D4AF37]/25 -z-[1] blur-sm"></span>
                </span>
            </h1>
            <p class="text-sm leading-relaxed text-white/90 max-w-[400px] font-light panel-sub">
                Access your membership dashboard, manage your contributions, and stay connected with the Africa Prosperity Network community.
            </p>
        </div>

    </div>

    <!-- Left Panel  -->
    <div class="left-panel apn-scrollbar p-6 md:p-8 relative">

        <div class="back-link absolute top-7 left-7 z-20">
            <a href="/" class="inline-flex items-center gap-2 text-md text-[#64748b] hover:text-[#4f46e5] transition-colors duration-300">
                <i class="fas fa-chevron-left text-md"></i>
                <span>Back to Home</span>
            </a>
        </div>

        <div class="max-w-[460px] w-full mx-auto bg-white rounded-2xl p-8 md:p-10 shadow-[0_20px_40px_-15px_rgba(0,0,0,0.18),inset_0_0_0_1px_rgba(0,0,0,0.02)] relative z-20 mt-20 md:mt-36 mb-10 login-card-wrap">

            <!-- Logo in black circle -->
            <div class="logo-circle animate-float">
                <img src="https://res.cloudinary.com/dvsacegwf/image/upload/v1773785052/APN-LOGOS-01-e1733932773480-scaled_l1coi5.png" alt="APN Logo">
            </div>

            <div class="text-center mb-8">
             
                <h2 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-[#1e1b4b] to-[#4f46e5] bg-clip-text text-transparent mb-1" style="font-family:'Urbanist',sans-serif;">
                    Login
                </h2>
                <p class="text-sm text-[#64748b] flex items-center justify-center gap-2">
                    <i class="fas fa-shield-alt text-[#D4AF37]" style="font-size:0.8rem;"></i>
                    Access to your account
                </p>
            </div>

            @if($errors->any())
            <div class="bg-red-50 border-2 border-red-200 rounded-xl p-4 mb-5 flex items-center gap-3 text-red-600 text-sm">
                <i class="fas fa-exclamation-circle text-base"></i>
                <span>{{ $errors->first() }}</span>
            </div>
            @endif

            @if(session('status'))
            <div class="bg-green-50 border-2 border-green-200 rounded-xl p-4 mb-5 flex items-center gap-3 text-green-600 text-sm">
                <i class="fas fa-check-circle text-base"></i>
                <span>{{ session('status') }}</span>
            </div>
            @endif

            <form method="POST" action="{{ route('donor.login') }}" id="loginForm">
                @csrf

                <div class="mb-5">
                    <label class="flex items-center gap-1.5 text-xs font-semibold text-[#334155] mb-2" style="font-family:'Urbanist',sans-serif;">
                        <i class="fas fa-envelope text-[#4f46e5]" style="font-size:0.75rem;"></i>
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <div class="field-wrap">
                        <i class="fi far fa-envelope"></i>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="field-apn" placeholder="your@email.com"
                               autocomplete="email" required autofocus>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="flex items-center gap-1.5 text-xs font-semibold text-[#334155] mb-2" style="font-family:'Urbanist',sans-serif;">
                        <i class="fas fa-lock text-[#4f46e5]" style="font-size:0.75rem;"></i>
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="field-wrap">
                        <i class="fi fas fa-lock"></i>
                        <input type="password" name="password" id="password"
                               class="field-apn" style="padding-right: 2.8rem;"
                               placeholder="Enter your password"
                               autocomplete="current-password" required>
                        <button type="button" class="fi-right" onclick="togglePassword()">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between mb-7">
                    <label class="flex items-center gap-2 text-sm text-[#475569] cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 accent-[#4f46e5]">
                        <span>Remember me</span>
                    </label>
                    @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm font-medium text-[#4f46e5] hover:text-[#3730a3] transition-colors duration-300 hover:underline flex items-center gap-1">
                        <span>Forgot password?</span>
                        <i class="fas fa-chevron-right text-xs"></i>
                    </a>
                    @endif
                </div>

                <button type="submit" class="btn-login w-full py-4 bg-gradient-to-r from-[#1e1b4b] via-[#2d1b4b] to-[#4f46e5] animate-gradient text-white rounded-xl text-base font-bold uppercase tracking-wide shadow-lg flex items-center justify-center gap-3" style="font-family:'Urbanist',sans-serif;">
                    <span>Sign In to Your Account</span>
                    <i class="fas fa-chevron-right transition-transform duration-300" id="submitIcon"></i>
                </button>

                <!-- Register prompt -->
                <div class="text-center mt-6 pt-4 border-t-2 border-[#e2e8f0]">
                    <p class="text-sm text-[#64748b]">
                        Don't have an account yet?
                        <a href="/" 
                           class="font-semibold text-[#4f46e5] hover:text-[#3730a3] transition-colors duration-300 hover:underline ml-1">
                            Register here
                            <i class="fas fa-chevron-right text-xs ml-1"></i>
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <div class="absolute bottom-5 left-0 right-0 text-center text-xs text-[#94a3b8] z-20">
            <p>© {{ date('Y') }} Africa Prosperity Network. All rights reserved.</p>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const pw = document.getElementById('password');
        const icon = document.getElementById('toggleIcon');
        if (pw.type === 'password') {
            pw.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            pw.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    document.getElementById('loginForm')?.addEventListener('submit', function(e) {
        const submitBtn = document.querySelector('.btn-login');
        const submitIcon = document.getElementById('submitIcon');
        const email    = document.querySelector('input[name="email"]').value.trim();
        const password = document.getElementById('password').value.trim();

        if (!email) { e.preventDefault(); showNotification('Please enter your email address', 'error'); return; }
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { e.preventDefault(); showNotification('Please enter a valid email address', 'error'); return; }
        if (!password) { e.preventDefault(); showNotification('Please enter your password', 'error'); return; }
        if (password.length < 8) { e.preventDefault(); showNotification('Password must be at least 8 characters', 'error'); return; }

        submitBtn.classList.add('loading');
        submitIcon.className = 'fas fa-spinner';
        submitBtn.disabled = true;
    });

    function showNotification(message, type) {
        document.querySelector('.custom-notification')?.remove();
        const n = document.createElement('div');
        n.className = `custom-notification fixed top-5 right-5 z-50 px-5 py-4 rounded-xl shadow-lg flex items-center gap-3 ${type === 'error' ? 'bg-red-50 border-2 border-red-200 text-red-700' : 'bg-green-50 border-2 border-green-200 text-green-700'}`;
        n.innerHTML = `<i class="fas fa-${type === 'error' ? 'exclamation-circle' : 'check-circle'} text-base"></i><span class="text-sm font-medium">${message}</span><button onclick="this.parentElement.remove()" class="ml-3 hover:opacity-70"><i class="fas fa-times"></i></button>`;
        document.body.appendChild(n);
        setTimeout(() => { if (n.parentElement) { n.style.transform = 'translateX(120%)'; n.style.transition = 'transform 0.4s ease'; setTimeout(() => n.remove(), 400); } }, 5000);
    }

    const emailParam = new URLSearchParams(window.location.search).get('email');
    if (emailParam) document.querySelector('input[name="email"]').value = emailParam;
</script>
@endsection