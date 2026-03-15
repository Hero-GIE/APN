@extends('layouts.guest')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;500;600;700&family=Syne:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    @keyframes pageReveal {
        from { opacity: 0; transform: scale(1.02); }
        to { opacity: 1; transform: scale(1); }
    }
    
    @keyframes patternMove {
        from { background-position: 0 0; }
        to { background-position: 200px 200px; }
    }
    
    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 0.6; }
        50% { opacity: 1; }
    }
    
    .animate-page-reveal {
        animation: pageReveal 0.9s cubic-bezier(0.22,1,0.36,1) both;
    }
    
    .animate-pattern {
        animation: patternMove 60s linear infinite;
    }
    
    .animate-gradient {
        animation: gradientShift 5s ease infinite;
        background-size: 200% 200%;
    }
    
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
    
    .animate-pulse-slow {
        animation: pulse 3s ease-in-out infinite;
    }
    
    /* Custom scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #4f46e5;
        border-radius: 3px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #3730a3;
    }
    
    /* Login card styles */
    .login-card {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .login-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 30px -12px rgba(79, 70, 229, 0.25);
    }
    
    .input-focus-effect {
        transition: all 0.3s ease;
    }
    
    .input-focus-effect:focus {
        transform: translateY(-2px);
    }
    
    .btn-login {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .btn-login::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.7s ease;
    }
    
    .btn-login:hover::before {
        left: 100%;
    }
    
    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 25px -5px rgba(79, 70, 229, 0.4);
    }
    
    /* Feature list styles */
    .feature-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.5rem 0;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    
    .feature-item:last-child {
        border-bottom: none;
    }
    
    .feature-item i {
        color: #D4AF37;
        font-size: 1rem;
        width: 24px;
    }
</style>

<div class="fixed inset-0 bg-white font-['Inter']">
    <!-- Main Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 w-screen h-screen animate-page-reveal">
        
      <!-- Left Panel-->
<div class="relative overflow-hidden h-screen w-full flex flex-col justify-end bg-cover bg-center"
     style="background-image: url('https://membership.africaprosperitynetwork.com/wp-content/uploads/2026/03/Group-600.jpg')">
    <div class="absolute inset-0 bg-gradient-to-br from-[#0f172a]/60 via-[#1e1b4b]/50 to-[#2d1b4b]/35 z-[1]"></div>
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_50%,rgba(212,175,55,0.15),transparent_60%)] z-[2] pointer-events-none"></div>
    
    <div class="absolute inset-0 opacity-10 z-[3] pointer-events-none animate-pattern"
         style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\" opacity=\"0.15\"><path d=\"M20,20 L30,10 L40,20 L50,10 L60,20 L70,10 L80,20 L70,30 L80,40 L70,50 L80,60 L70,70 L80,80 L70,90 L60,80 L50,90 L40,80 L30,90 L20,80 L30,70 L20,60 L30,50 L20,40 L30,30 Z\" fill=\"%23D4AF37\"/><circle cx=\"50\" cy=\"50\" r=\"5\" fill=\"%234f46e5\"/></svg>');
                 background-size: 100px 100px;
                 background-repeat: repeat;"></div>
    <div class="absolute z-[3] w-64 h-64 rounded-full bg-[#D4AF37]/5 blur-3xl top-20 left-10 animate-float"></div>
    <div class="absolute z-[3] w-48 h-48 rounded-full bg-[#4f46e5]/5 blur-3xl bottom-40 right-10 animate-float" style="animation-delay: 2s;"></div>
    <div class="relative z-[4] px-8 md:px-16 py-16 text-white bg-gradient-to-t from-black/60 via-black/30 to-transparent max-w-[600px]">
        <div class="flex items-center gap-3 mb-5 font-['Syne'] text-sm font-semibold tracking-[4px] uppercase">
            <span class="w-[50px] h-[2px] bg-gradient-to-r from-[#D4AF37] to-transparent"></span>
            <span class="text-[#D4AF37] animate-pulse-slow">WELCOME BACK</span>
            <span class="w-[50px] h-[2px] bg-gradient-to-l from-[#D4AF37] to-transparent"></span>
        </div>
        <h1 class="font-['Syne'] text-4xl md:text-5xl lg:text-6xl font-extrabold leading-[1.1] mb-6 drop-shadow-lg">
            Reconnect with<br>
            <span class="text-[#D4AF37] relative inline-block">
                Africa's Future
                <span class="absolute bottom-2 left-0 w-full h-3 bg-[#D4AF37]/30 -z-[1] blur-sm"></span>
            </span>
        </h1>
        <p class="text-base leading-relaxed text-white/95 mb-8 max-w-[90%] font-light">
            Access your membership dashboard, manage your contributions, and stay connected with the Africa Prosperity Network community.
        </p>

    </div>
</div>
        
        <!-- Right Panel -->
        <div class="relative bg-white h-screen w-full overflow-y-auto custom-scrollbar flex items-start justify-center p-8">
            <div class="absolute top-0 left-0 w-full h-full shadow-[-10px_0_30px_-10px_rgba(0,0,0,0.15)] pointer-events-none z-[1]"></div>
            
            <!-- Back to Home  -->
            <div class="absolute top-8 left-8 z-20">
                <a href="/" class="inline-flex items-center gap-2 text-sm text-[#64748b] hover:text-[#4f46e5] transition-colors duration-300">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Home</span>
                </a>
            </div>
            
            <!-- Don't have an account? Link -->
            <div class="absolute top-8 right-8 z-20">
                @if (Route::has('register'))
                    <a href="{{ route('donor.register') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-[#4f46e5] to-[#3730a3] text-white rounded-xl font-['Syne'] text-sm font-semibold transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-[#4f46e5]/30">
                        <span>Create Account</span>
                        <i class="fas fa-user-plus"></i>
                    </a>
                @endif
            </div>
            
            <!-- Form Container -->
            <div class="max-w-[480px] w-full bg-white rounded-xl p-10 shadow-[0_20px_40px_-15px_rgba(0,0,0,0.2),inset_0_0_0_1px_rgba(0,0,0,0.02)] relative z-20 login-card mt-40">
  
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-[#4f46e5]/10 to-[#D4AF37]/10 rounded-2xl mb-4 animate-float">
                        <i class="fas fa-lock text-2xl bg-gradient-to-r from-[#1e1b4b] to-[#4f46e5] bg-clip-text text-transparent"></i>
                    </div>
                    <h2 class="font-['Syne'] text-3xl md:text-4xl font-bold bg-gradient-to-r from-[#1e1b4b] to-[#4f46e5] bg-clip-text text-transparent mb-2">
                     Login
                    </h2>
                    <p class="text-sm text-[#64748b] flex items-center justify-center gap-2">
                        <i class="fas fa-shield-alt text-[#D4AF37]"></i>
                        Access to your account
                    </p>
                </div>
                @if($errors->any())
                    <div class="bg-red-50 border-2 border-red-200 rounded-xl p-4 mb-6 flex items-center gap-3 text-red-600 text-sm">
                        <i class="fas fa-exclamation-circle text-lg"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif
                @if (session('status'))
                    <div class="bg-green-50 border-2 border-green-200 rounded-xl p-4 mb-6 flex items-center gap-3 text-green-600 text-sm">
                        <i class="fas fa-check-circle text-lg"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('donor.login') }}" id="loginForm">
                    @csrf

                    <!-- Email field -->
                    <div class="mb-6">
                        <label class="flex items-center gap-2 text-sm font-semibold text-[#334155] mb-2">
                            <i class="fas fa-envelope text-[#4f46e5] text-sm"></i>
                            Email Address <span class="text-red-500 ml-0.5">*</span>
                        </label>
                        <div class="relative">
                            <i class="far fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-[#94a3b8] text-sm transition-colors duration-200"></i>
                            <input type="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   class="w-full py-4 pl-11 pr-4 bg-[#f8fafc] border-2 border-[#e2e8f0] rounded-xl text-sm text-[#1e293b] transition-all duration-300 input-focus-effect focus:outline-none focus:border-[#4f46e5] focus:bg-white focus:shadow-[0_0_0_4px_rgba(79,70,229,0.1)]"
                                   placeholder="your@email.com"
                                   autocomplete="email"
                                   required 
                                   autofocus>
                        </div>
                    </div>

                    <!-- Password field -->
                    <div class="mb-4">
                        <label class="flex items-center gap-2 text-sm font-semibold text-[#334155] mb-2">
                            <i class="fas fa-lock text-[#4f46e5] text-sm"></i>
                            Password <span class="text-red-500 ml-0.5">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-[#94a3b8] text-sm transition-colors duration-200"></i>
                            <input type="password" 
                                   name="password" 
                                   id="password"
                                   class="w-full py-4 pl-11 pr-12 bg-[#f8fafc] border-2 border-[#e2e8f0] rounded-xl text-sm text-[#1e293b] transition-all duration-300 input-focus-effect focus:outline-none focus:border-[#4f46e5] focus:bg-white focus:shadow-[0_0_0_4px_rgba(79,70,229,0.1)]"
                                   placeholder="Enter your password"
                                   autocomplete="current-password"
                                   required>
                            <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#94a3b8] hover:text-[#4f46e5] transition-colors duration-300" onclick="togglePassword()">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember me & Forgot password -->
                    <div class="flex items-center justify-between mb-8">
                        <label class="flex items-center gap-2 text-sm text-[#475569] cursor-pointer group">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-[#e2e8f0] text-[#4f46e5] focus:ring-[#4f46e5] focus:ring-offset-0">
                            <span class="group-hover:text-[#4f46e5] transition-colors duration-300">Remember me</span>
                        </label>
                        
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm font-medium text-[#4f46e5] hover:text-[#3730a3] transition-all duration-300 hover:underline flex items-center gap-1">
                                <span>Forgot password?</span>
                                <i class="fas fa-chevron-right text-xs"></i>
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-login w-full py-4 bg-gradient-to-r from-[#1e1b4b] via-[#2d1b4b] to-[#4f46e5] animate-gradient text-white rounded-xl font-['Syne'] text-base font-bold uppercase tracking-wide shadow-lg flex items-center justify-center gap-3 relative group">
                        <span>Sign In to Your Account</span>
                        <i class="fas fa-arrow-right transition-transform duration-300 group-hover:translate-x-2" id="submitIcon"></i>
                    </button>

                    <!-- Register Link (Mobile/Alternate) -->
                    @if (Route::has('register'))
                        <div class="text-center mt-8 pt-6 border-t-2 border-[#e2e8f0] lg:hidden">
                            <p class="text-sm text-[#64748b]">
                                Don't have an account?
                                <a href="{{ route('donor.register') }}" class="font-semibold text-[#4f46e5] hover:text-[#3730a3] hover:underline ml-1 transition-all duration-300">
                                    Create one
                                </a>
                            </p>
                        </div>
                    @endif

                    <!-- Security Note -->
                    <div class="flex items-center justify-center gap-3 mt-8 text-xs text-[#94a3b8] flex-wrap">
                        <i class="fas fa-circle text-[#D4AF37] text-[0.4rem] animate-pulse-slow"></i>
                        <span class="flex items-center gap-1">
                            <i class="fas fa-shield-alt text-[#4f46e5]"></i>
                            256-bit encrypted
                        </span>
                        <i class="fas fa-circle text-[#D4AF37] text-[0.4rem] animate-pulse-slow"></i>
                        <span class="flex items-center gap-1">
                            <i class="fas fa-lock text-[#4f46e5]"></i>
                            Secure login
                        </span>
                        <i class="fas fa-circle text-[#D4AF37] text-[0.4rem] animate-pulse-slow"></i>
                    </div>
                </form>
            </div>
            
            <!-- Footer Note -->
            <div class="absolute bottom-8 left-0 right-0 text-center text-xs text-[#94a3b8] z-20">
                <p>© {{ date('Y') }} Africa Prosperity Network. All rights reserved.</p>
            </div>
        </div>
    </div>
</div>

<style>
    /* Additional custom styles */
    .btn-login {
        position: relative;
        overflow: hidden;
    }
    
    .btn-login::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 70%);
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }
    
    .btn-login:hover::after {
        opacity: 1;
    }
    
    .input-focus-effect:focus {
        transform: translateY(-2px);
    }
    
    /* Loading state */
    .btn-login.loading {
        opacity: 0.8;
        cursor: not-allowed;
    }
    
    .btn-login.loading i {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>

<script>

    function togglePassword() {
        const password = document.getElementById('password');
        const icon = document.getElementById('toggleIcon');
        
        if (password.type === 'password') {
            password.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            password.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Form submission handling
    document.getElementById('loginForm')?.addEventListener('submit', function(e) {
        const submitBtn = document.querySelector('.btn-login');
        const submitIcon = document.getElementById('submitIcon');
        const email = document.querySelector('input[name="email"]').value.trim();
        const password = document.getElementById('password').value.trim();
        
        // Basic validation
        if (!email) {
            e.preventDefault();
            showNotification('Please enter your email address', 'error');
            return;
        }
        
        if (!isValidEmail(email)) {
            e.preventDefault();
            showNotification('Please enter a valid email address', 'error');
            return;
        }
        
        if (!password) {
            e.preventDefault();
            showNotification('Please enter your password', 'error');
            return;
        }
        
        if (password.length < 8) {
            e.preventDefault();
            showNotification('Password must be at least 8 characters', 'error');
            return;
        }
        
        submitBtn.classList.add('loading');
        submitIcon.className = 'fas fa-spinner';
        submitBtn.disabled = true;
    });

    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    function showNotification(message, type) {

        const existingNotification = document.querySelector('.custom-notification');
        if (existingNotification) {
            existingNotification.remove();
        }
        
        const notification = document.createElement('div');
        notification.className = `custom-notification fixed top-5 right-5 z-50 px-6 py-4 rounded-xl shadow-lg flex items-center gap-3 transform transition-all duration-500 translate-x-0 ${
            type === 'error' ? 'bg-red-50 border-2 border-red-200 text-red-700' : 'bg-green-50 border-2 border-green-200 text-green-700'
        }`;
        
        notification.innerHTML = `
            <i class="fas fa-${type === 'error' ? 'exclamation-circle' : 'check-circle'} text-lg"></i>
            <span class="text-sm font-medium">${message}</span>
            <button onclick="this.parentElement.remove()" class="ml-4 hover:opacity-70">
                <i class="fas fa-times"></i>
            </button>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            if (notification.parentElement) {
                notification.style.transform = 'translateX(120%)';
                setTimeout(() => notification.remove(), 500);
            }
        }, 5000);
    }

    function createParticles() {
        const leftPanel = document.querySelector('.grid-cols-2 > div:first-child');
        if (!leftPanel) return;
        
        for (let i = 0; i < 15; i++) {
            const particle = document.createElement('div');
            particle.className = 'absolute rounded-full bg-[rgba(212,175,55,0.1)] pointer-events-none';
            particle.style.width = Math.random() * 6 + 2 + 'px';
            particle.style.height = particle.style.width;
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = Math.random() * 100 + '%';
            particle.style.animation = `particleFloat ${Math.random() * 15 + 10}s linear infinite`;
            particle.style.animationDelay = Math.random() * 5 + 's';
            leftPanel.appendChild(particle);
        }
    }

    const style = document.createElement('style');
    style.textContent = `
        @keyframes particleFloat {
            from { transform: translateY(0) rotate(0deg); opacity: 0; }
            10% { opacity: 0.5; }
            90% { opacity: 0.5; }
            to { transform: translateY(-100px) rotate(360deg); opacity: 0; }
        }
    `;
    document.head.appendChild(style);

    window.addEventListener('load', createParticles);
    const urlParams = new URLSearchParams(window.location.search);
    const emailParam = urlParams.get('email');
    if (emailParam) {
        document.querySelector('input[name="email"]').value = emailParam;
    }
</script>
@endsection