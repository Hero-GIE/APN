@extends('layouts.guest')

@section('content')

<style>

    @keyframes orbFloat {
        0% { transform: translate(0, 0) scale(1); }
        100% { transform: translate(40px, 20px) scale(1.1); }
    }

    @keyframes cardReveal {
        from { opacity: 0; transform: translateY(30px) scale(0.98); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    @keyframes iconPop {
        from { opacity: 0; transform: scale(0.5); }
        to { opacity: 1; transform: scale(1); }
    }

    @keyframes particleFloat {
        from { transform: translateY(100vh) rotate(0deg); }
        to { transform: translateY(-100px) rotate(360deg); }
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
</style>

<div class="fixed inset-0 z-0 overflow-hidden bg-gradient-to-br from-slate-100 via-slate-50 to-slate-100">
    <!-- Floating orbs -->
    <div class="orb-1 absolute w-[600px] h-[600px] -top-200 -right-200 rounded-full"
         style="background: radial-gradient(circle, rgba(79,70,229,0.15) 0%, transparent 70%); filter: blur(60px); opacity: 0.4; animation: orbFloat 25s infinite alternate;"></div>
    <div class="orb-2 absolute w-[500px] h-[500px] -bottom-200 -left-100 rounded-full"
         style="background: radial-gradient(circle, rgba(55,48,163,0.12) 0%, transparent 70%); filter: blur(60px); opacity: 0.4; animation: orbFloat 30s infinite alternate reverse;"></div>
    <div class="orb-3 absolute w-[400px] h-[400px] top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 rounded-full"
         style="background: radial-gradient(circle, rgba(139,92,246,0.1) 0%, transparent 70%); filter: blur(80px); opacity: 0.4; animation: orbFloat 35s infinite alternate;"></div>
</div>

<div class="relative z-10 w-full max-w-[520px] mx-auto px-4 min-h-screen flex items-center">
    <div class="bg-white/90 backdrop-blur-xl rounded-lg p-10 shadow-[0_25px_50px_-12px_rgba(0,0,0,0.25)] border border-white/60 w-full"
         style="animation: cardReveal 0.7s cubic-bezier(0.22, 1, 0.36, 1) both;">
        
        <!-- Brand -->
        <div class="flex items-center justify-center gap-3 mb-8">
            <div class="w-10 h-10 bg-gradient-to-br from-[#3730a3] to-[#4f46e5] rounded-[6px] flex items-center justify-center text-white text-xl shadow-[0_10px_15px_-3px_rgba(79,70,229,0.3)]">
                <i class="fas fa-crown"></i>
            </div>
            <span class="font-['Lora'] text-2xl font-extrabold bg-gradient-to-r from-[#1a1f36] to-[#3730a3] bg-clip-text text-transparent tracking-tight">
                APN Membership
            </span>
        </div>

        <!-- Success Icon -->
        <div class="w-20 h-20 bg-gradient-to-br from-[#3730a3] to-[#4f46e5] rounded-full flex items-center justify-center mx-auto mb-6 shadow-[0_20px_30px_-10px_rgba(79,70,229,0.4)]"
             style="animation: iconPop 0.6s cubic-bezier(0.22, 1, 0.36, 1) both;">
            <i class="fas fa-check text-white text-4xl"></i>
        </div>

        <!-- Header -->
        <h1 class="font-['Syne'] text-4xl font-bold text-[#1a1f36] mb-2 text-center leading-tight">Welcome to APN!</h1>
        <p class="text-[#64748b] text-sm mb-8 text-center font-['Lora']">Your membership has been created successfully.</p>

        @if(isset($membership) && $membership)
        <!-- Receipt Card -->
        <div class="bg-slate-50 border-2 border-slate-200 rounded-lg p-5 mb-6 hover:border-[#4f46e5] hover:shadow-[0_4px_12px_rgba(79,70,229,0.1)] transition-all duration-300">
            <div class="flex justify-between items-center py-3 border-b-2 border-slate-200 text-sm">
                <span class="text-[#64748b] font-['Lora']">Membership Type</span>
                <span class="text-[#4f46e5] font-['Syne'] font-semibold text-xl">{{ ucfirst($membership->membership_type) }}</span>
            </div>
            <div class="flex justify-between items-center py-3 border-b-2 border-slate-200 text-sm">
                <span class="text-[#64748b] font-['Lora']">Amount</span>
                <span class="text-[#1a1f36] font-['Syne'] font-semibold">${{ number_format($membership->amount, 2) }}</span>
            </div>
            <div class="flex justify-between items-center py-3 border-b-2 border-slate-200 text-sm">
                <span class="text-[#64748b] font-['Lora']">Valid Until</span>
                <span class="text-[#1a1f36] font-['Syne'] font-semibold">{{ \Carbon\Carbon::parse($membership->end_date)->format('d M Y') }}</span>
            </div>
            <div class="flex justify-between items-center py-3 text-sm">
                <span class="text-[#64748b] font-['Lora']">Status</span>
                <span class="bg-green-100 text-green-800 text-xs font-bold px-4 py-1 rounded-full flex items-center gap-1">
                    <i class="fas fa-check-circle text-xs"></i>
                    Active
                </span>
            </div>
        </div>

        <!-- Info Box -->
        <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-5 mb-6 flex items-start gap-3 text-sm text-blue-900">
            <i class="fas fa-star text-[#4f46e5] text-lg mt-0.5"></i>
            <div class="flex-1">
                <strong class="text-blue-900 block mb-1">Member Benefits Activated</strong>
                <p class="m-0 leading-relaxed text-blue-800">You now have access to exclusive member benefits. Check your email for membership details and login credentials.</p>
            </div>
        </div>
        @endif

        <!-- Actions -->
        <a href="{{ route('member.dashboard') }}" class="btn-primary w-full py-4 bg-gradient-to-r from-[#3730a3] to-[#4f46e5] text-white rounded-lg font-['Syne'] text-base font-bold uppercase tracking-wide shadow-[0_10px_15px_-3px_rgba(79,70,229,0.3)] flex items-center justify-center gap-3 relative overflow-hidden transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_20px_25px_-5px_rgba(79,70,229,0.4)] mb-3">
            <span>Go to Member Dashboard</span>
            <i class="fas fa-arrow-right transition-transform duration-300 group-hover:translate-x-1"></i>
        </a>
        
        <a href="{{ route('donor.login') }}" class="w-full py-4 bg-slate-50 text-[#4f46e5] border-2 border-slate-200 rounded-lg font-['Syne'] text-sm font-semibold flex items-center justify-center gap-3 transition-all duration-300 hover:bg-blue-50 hover:border-[#4f46e5] hover:-translate-y-0.5">
            <i class="fas fa-user"></i>
            <span>Login to Account</span>
        </a>

        <!-- Security Note -->
        <div class="flex items-center justify-center gap-2 mt-8 text-xs text-slate-400">
            <i class="fas fa-circle text-[#4f46e5] text-[0.6rem] animate-pulse"></i>
            <span>Membership activated</span>
            <i class="fas fa-circle text-[#4f46e5] text-[0.6rem] animate-pulse"></i>
            <span>Welcome to APN</span>
        </div>

        <!-- Footer -->
        <p class="mt-6 text-xs text-slate-400 text-center">© {{ date('Y') }} Africa Prosperity Network</p>
    </div>
</div>

<script>
// Create floating particles
function createParticles() {
    const scene = document.querySelector('.fixed.inset-0');
    for (let i = 0; i < 20; i++) {
        const particle = document.createElement('div');
        particle.className = 'absolute rounded-full bg-[rgba(79,70,229,0.1)] pointer-events-none';
        particle.style.width = Math.random() * 4 + 2 + 'px';
        particle.style.height = particle.style.width;
        particle.style.left = Math.random() * 100 + '%';
        particle.style.animation = `particleFloat ${Math.random() * 10 + 15}s linear infinite`;
        particle.style.animationDelay = Math.random() * 10 + 's';
        scene.appendChild(particle);
    }
}
createParticles();
</script>
@endsection