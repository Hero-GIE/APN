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
    
    /* Membership card styles */
    .membership-card {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .membership-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 30px -12px rgba(79, 70, 229, 0.25);
    }
    
    .popular-badge {
        position: absolute;
        top: 12px;
        right: -30px;
        background: linear-gradient(135deg, #D4AF37, #B8860B);
        color: white;
        padding: 8px 40px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        transform: rotate(45deg);
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        z-index: 10;
    }
    
    .feature-list {
        list-style: none;
        padding: 0;
        margin: 0 0 1.5rem 0;
    }
    
    .feature-list li {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.5rem 0;
        font-size: 0.9rem;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .feature-list li:last-child {
        border-bottom: none;
    }
    
    .feature-list li i {
        color: #4f46e5;
        font-size: 0.9rem;
        width: 20px;
        text-align: center;
    }
    
    .feature-list li i.fa-check-circle {
        color: #10b981;
    }
    
    .price-tag {
        font-family: 'Syne', sans-serif;
        font-size: 2.2rem;
        font-weight: 800;
        color: #1e1b4b;
        line-height: 1.2;
    }
    
    .price-period {
        font-size: 0.9rem;
        color: #64748b;
        font-weight: 400;
    }
</style>

<div class="fixed inset-0 bg-white font-['Inter']">
    <div class="grid grid-cols-1 lg:grid-cols-2 w-screen h-screen animate-page-reveal">
        
        <!-- Left Panel -->
        <div class="relative overflow-hidden h-screen w-full flex flex-col justify-end bg-cover bg-center"
             style="background-image: url('https://membership.africaprosperitynetwork.com/wp-content/uploads/2026/03/Group-598.jpg')">
    
            <div class="absolute inset-0 bg-gradient-to-br from-[#0f172a]/60 via-[#1e1b4b]/45 to-[#2d1b4b]/30 z-[1]"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_70%_30%,rgba(212,175,55,0.1),transparent_70%)] z-[2] pointer-events-none"></div>
            <div class="absolute inset-0 opacity-8 z-[3] pointer-events-none animate-pattern"
                 style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\" opacity=\"0.1\"><path d=\"M20,20 L30,10 L40,20 L50,10 L60,20 L70,10 L80,20 L70,30 L80,40 L70,50 L80,60 L70,70 L80,80 L70,90 L60,80 L50,90 L40,80 L30,90 L20,80 L30,70 L20,60 L30,50 L20,40 L30,30 Z\" fill=\"%23D4AF37\"/><circle cx=\"50\" cy=\"50\" r=\"5\" fill=\"%234f46e5\"/></svg>');background-size: 100px 100px;background-repeat: repeat;"></div>
            
            <div class="relative z-[4] px-8 md:px-16 py-16 text-white bg-gradient-to-t from-black/40 via-transparent to-transparent max-w-[600px]">
                <div class="flex items-center gap-2 mb-4 font-['Syne'] text-sm font-semibold tracking-[4px] uppercase text-[#D4AF37]">
                    <span class="w-[50px] h-[2px] bg-gradient-to-r from-[#D4AF37] to-transparent"></span>
                    AFRICA PROSPERITY NETWORK
                </div>
                
                <!-- Main Heading -->
                <h1 class="font-['Syne'] text-4xl md:text-5xl lg:text-6xl font-extrabold leading-[1.1] mb-6 drop-shadow-lg">
                    Join the<br>
                    <span class="text-[#D4AF37] relative inline-block">
                        Movement
                        <span class="absolute bottom-1 left-0 w-full h-2 bg-[#D4AF37]/30 -z-[1]"></span>
                    </span><br>
                    for Prosperity
                </h1>
                
                <p class="text-base leading-relaxed text-white/98 mb-8 max-w-[90%] font-light">
                    Choose the membership that fits your commitment to advancing Africa's economic integration and shared prosperity.
                </p>
            </div>
        </div>
        
        <!-- Right Panel -->
        <div class="relative bg-white h-screen w-full overflow-y-auto custom-scrollbar flex items-start justify-center p-8">

            <div class="absolute top-0 left-0 w-full h-full shadow-[-10px_0_30px_-10px_rgba(0,0,0,0.15)] pointer-events-none z-[1]"></div>
            
            <div class="absolute top-8 right-8 z-20 flex justify-end w-[calc(100%-4rem)]">
                <a href="{{ route('donor.login') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-transparent border-2 border-[#4f46e5] rounded-xl text-[#4f46e5] font-['Syne'] text-sm font-semibold transition-all duration-300 hover:bg-[#4f46e5]/5 hover:-translate-y-1 hover:shadow-lg hover:shadow-[#4f46e5]/20">
                    <span>Login</span>
                    <i class="fas fa-chevron-right transition-transform duration-300 group-hover:translate-x-1"></i>
                </a>
            </div>
            
            <!-- Form Container -->
            <div class="max-w-[900px] w-full bg-white rounded-xl p-10 shadow-[0_20px_40px_-15px_rgba(0,0,0,0.2),inset_0_0_0_1px_rgba(0,0,0,0.02)] relative z-20 mt-20">
                
                <div class="text-center mb-8">
                    <h2 class="font-['Syne'] text-3xl md:text-4xl font-bold bg-gradient-to-r from-[#1e1b4b] to-[#2d1b4b] bg-clip-text text-transparent mb-1">
                        Membership Options
                    </h2>
                    <p class="text-sm text-[#64748b] flex items-center justify-center gap-2">
                        Choose the Membership That Fits You
                    </p>
                </div>
                <div id="errorAlert" class="bg-red-50 border-2 border-red-200 rounded-xl p-4 mb-6 flex items-center gap-3 text-red-600 text-sm hidden">
                    <i class="fas fa-exclamation-circle"></i>
                    <span id="errorMsg">Something went wrong.</span>
                </div>
                
                <!-- Membership Options Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    
                    <!-- Monthly Membership -->
                    <div class="membership-card bg-white border-2 border-[#e2e8f0] rounded-2xl p-8 flex flex-col h-full relative">
                        <div class="mb-6">
                            <h3 class="font-['Syne'] text-2xl font-bold text-[#1e1b4b] mb-1">Monthly</h3>
                            <div class="flex items-baseline gap-1">
                                <span class="price-tag">$35</span>
                                <span class="price-period">/month</span>
                            </div>
                            <p class="text-sm text-[#64748b] mt-2">Flexible month-to-month access to all APN benefits.</p>
                        </div>
                        
                        <ul class="feature-list flex-grow">
                            <li><i class="fas fa-check-circle"></i> Full APN membership access</li>
                            <li><i class="fas fa-check-circle"></i> 10% discount on events & merch</li>
                            <li><i class="fas fa-check-circle"></i> Monthly newsletters</li>
                            <li><i class="fas fa-check-circle"></i> Borderless campaign enrollment</li>
                            <li><i class="fas fa-check-circle"></i> APN Magazine digital access</li>
                        </ul>
                        
                        <button type="button" class="w-full mt-6 py-4 bg-gradient-to-r from-[#1e1b4b] to-[#4f46e5] text-white border-none rounded-xl font-['Syne'] text-base font-bold cursor-pointer transition-all duration-300 shadow-md hover:-translate-y-1 hover:shadow-xl flex items-center justify-center gap-2 select-monthly">
                            <span>Get Started</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                    
                    <!-- Annual Membership -->
                    <div class="membership-card bg-gradient-to-br from-[#f8fafc] to-white border-2 border-[#4f46e5] rounded-2xl p-8 flex flex-col h-full relative overflow-hidden">
                        <div class="popular-badge">POPULAR</div>
                        <div class="mb-6">
                            <h3 class="font-['Syne'] text-2xl font-bold text-[#1e1b4b] mb-1">Annual</h3>
                            <div class="flex items-baseline gap-1">
                                <span class="price-tag">$350</span>
                                <span class="price-period">/year</span>
                            </div>
                            <p class="text-sm text-[#64748b] mt-2">Best value, save with an annual commitment.</p>
                        </div>
                        
                        <ul class="feature-list flex-grow">
                            <li><i class="fas fa-check-circle"></i> Everything in Monthly</li>
                            <li><i class="fas fa-check-circle"></i> Priority event registration</li>
                            <li><i class="fas fa-check-circle"></i> Exclusive member directory listing</li>
                            <li><i class="fas fa-check-circle"></i> Awards & recognition eligibility</li>
                            <li><i class="fas fa-check-circle"></i> APD conference discounts</li>
                            <li><i class="fas fa-check-circle text-[#D4AF37]"></i> <span class="font-semibold">2 months free</span></li>
                        </ul>
                        
                        <button type="button" class="w-full mt-6 py-4 bg-gradient-to-r from-[#D4AF37] to-[#B8860B] text-white border-none rounded-xl font-['Syne'] text-base font-bold cursor-pointer transition-all duration-300 shadow-md hover:-translate-y-1 hover:shadow-xl flex items-center justify-center gap-2 select-annual">
                            <span>Get Started</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
                
                <input type="hidden" id="membershipAmount" value="">
                <input type="hidden" id="membershipType" value="">
                
                <!-- Divider -->
                <div class="flex items-center gap-3 my-7">
                    <div class="flex-1 h-px bg-gradient-to-r from-transparent via-[#e2e8f0] to-transparent"></div>
                    <span class="text-xs text-[#D4AF37] uppercase tracking-wider font-semibold">Your Details</span>
                    <div class="flex-1 h-px bg-gradient-to-r from-transparent via-[#e2e8f0] to-transparent"></div>
                </div>
                
                <div class="grid grid-cols-2 gap-3">
                    <!-- First Name -->
                    <div class="mb-5">
                        <label class="flex items-center gap-1 text-sm font-semibold text-[#334155] mb-2">
                            <i class="fas fa-user text-[#4f46e5] text-sm"></i> First Name <span class="text-red-500 ml-0.5">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-[#94a3b8] text-sm transition-colors duration-200 peer-focus:text-[#4f46e5]"></i>
                            <input type="text" id="firstname" 
                                   class="w-full py-3 pl-11 pr-4 bg-[#f8fafc] border-2 border-[#e2e8f0] rounded-xl text-sm text-[#1e293b] transition-all duration-200 focus:outline-none focus:border-[#4f46e5] focus:bg-white focus:shadow-[0_0_0_3px_rgba(79,70,229,0.1),0_4px_10px_rgba(0,0,0,0.05)]"
                                   placeholder="John" required>
                        </div>
                    </div>
                    
                    <!-- Last Name -->
                    <div class="mb-5">
                        <label class="flex items-center gap-1 text-sm font-semibold text-[#334155] mb-2">
                            <i class="fas fa-user text-[#4f46e5] text-sm"></i> Last Name <span class="text-red-500 ml-0.5">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-[#94a3b8] text-sm transition-colors duration-200 peer-focus:text-[#4f46e5]"></i>
                            <input type="text" id="lastname" 
                                   class="w-full py-3 pl-11 pr-4 bg-[#f8fafc] border-2 border-[#e2e8f0] rounded-xl text-sm text-[#1e293b] transition-all duration-200 focus:outline-none focus:border-[#4f46e5] focus:bg-white focus:shadow-[0_0_0_3px_rgba(79,70,229,0.1),0_4px_10px_rgba(0,0,0,0.05)]"
                                   placeholder="Doe" required>
                        </div>
                    </div>
                </div>
                
                <!-- Email -->
                <div class="mb-5">
                    <label class="flex items-center gap-1 text-sm font-semibold text-[#334155] mb-2">
                        <i class="far fa-envelope text-[#4f46e5] text-sm"></i> Email Address <span class="text-red-500 ml-0.5">*</span>
                    </label>
                    <div class="relative">
                        <i class="far fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-[#94a3b8] text-sm transition-colors duration-200 peer-focus:text-[#4f46e5]"></i>
                        <input type="email" id="donorEmail" 
                               class="w-full py-3 pl-11 pr-4 bg-[#f8fafc] border-2 border-[#e2e8f0] rounded-xl text-sm text-[#1e293b] transition-all duration-200 focus:outline-none focus:border-[#4f46e5] focus:bg-white focus:shadow-[0_0_0_3px_rgba(79,70,229,0.1),0_4px_10px_rgba(0,0,0,0.05)]"
                               placeholder="you@example.com" required>
                    </div>
                </div>
                
                <!-- Phone & Country Grid -->
                <div class="grid grid-cols-2 gap-3">
                    <div class="mb-5">
                        <label class="flex items-center gap-1 text-sm font-semibold text-[#334155] mb-2">
                            <i class="fas fa-phone text-[#4f46e5] text-sm"></i> Phone
                        </label>
                        <div class="relative">
                            <i class="fas fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-[#94a3b8] text-sm transition-colors duration-200 peer-focus:text-[#4f46e5]"></i>
                            <input type="text" id="phone" 
                                   class="w-full py-3 pl-11 pr-4 bg-[#f8fafc] border-2 border-[#e2e8f0] rounded-xl text-sm text-[#1e293b] transition-all duration-200 focus:outline-none focus:border-[#4f46e5] focus:bg-white focus:shadow-[0_0_0_3px_rgba(79,70,229,0.1),0_4px_10px_rgba(0,0,0,0.05)]"
                                   placeholder="+233 XX XXX XXXX">
                        </div>
                    </div>
                    
                    <div class="mb-5">
                        <label class="flex items-center gap-1 text-sm font-semibold text-[#334155] mb-2">
                            <i class="fas fa-globe text-[#4f46e5] text-sm"></i> Country
                        </label>
                        <div class="relative">
                            <i class="fas fa-globe absolute left-4 top-1/2 -translate-y-1/2 text-[#94a3b8] text-sm transition-colors duration-200 peer-focus:text-[#4f46e5]"></i>
                            <input type="text" id="country" 
                                   class="w-full py-3 pl-11 pr-4 bg-[#f8fafc] border-2 border-[#e2e8f0] rounded-xl text-sm text-[#1e293b] transition-all duration-200 focus:outline-none focus:border-[#4f46e5] focus:bg-white focus:shadow-[0_0_0_3px_rgba(79,70,229,0.1),0_4px_10px_rgba(0,0,0,0.05)]"
                                   placeholder="Ghana">
                        </div>
                    </div>
                </div>
                
                <!-- City & Region Grid -->
                <div class="grid grid-cols-2 gap-3">
                    <div class="mb-5">
                        <label class="flex items-center gap-1 text-sm font-semibold text-[#334155] mb-2">
                            <i class="fas fa-city text-[#4f46e5] text-sm"></i> City
                        </label>
                        <div class="relative">
                            <i class="fas fa-city absolute left-4 top-1/2 -translate-y-1/2 text-[#94a3b8] text-sm transition-colors duration-200 peer-focus:text-[#4f46e5]"></i>
                            <input type="text" id="city" 
                                   class="w-full py-3 pl-11 pr-4 bg-[#f8fafc] border-2 border-[#e2e8f0] rounded-xl text-sm text-[#1e293b] transition-all duration-200 focus:outline-none focus:border-[#4f46e5] focus:bg-white focus:shadow-[0_0_0_3px_rgba(79,70,229,0.1),0_4px_10px_rgba(0,0,0,0.05)]"
                                   placeholder="Accra">
                        </div>
                    </div>
                    
                    <div class="mb-5">
                        <label class="flex items-center gap-1 text-sm font-semibold text-[#334155] mb-2">
                            <i class="fas fa-map text-[#4f46e5] text-sm"></i> Region
                        </label>
                        <div class="relative">
                            <i class="fas fa-map absolute left-4 top-1/2 -translate-y-1/2 text-[#94a3b8] text-sm transition-colors duration-200 peer-focus:text-[#4f46e5]"></i>
                            <input type="text" id="region" 
                                   class="w-full py-3 pl-11 pr-4 bg-[#f8fafc] border-2 border-[#e2e8f0] rounded-xl text-sm text-[#1e293b] transition-all duration-200 focus:outline-none focus:border-[#4f46e5] focus:bg-white focus:shadow-[0_0_0_3px_rgba(79,70,229,0.1),0_4px_10px_rgba(0,0,0,0.05)]"
                                   placeholder="Greater Accra">
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 my-7">
                    <div class="flex-1 h-px bg-gradient-to-r from-transparent via-[#e2e8f0] to-transparent"></div>
                    <span class="text-xs text-[#D4AF37] uppercase tracking-wider font-semibold">Preferences</span>
                    <div class="flex-1 h-px bg-gradient-to-r from-transparent via-[#e2e8f0] to-transparent"></div>
                </div>
                
                <label class="flex items-start gap-3 text-sm text-[#475569] cursor-pointer mb-3 p-2 rounded-xl hover:bg-[#f8fafc] hover:translate-x-0.5 transition-all duration-200">
                    <input type="checkbox" id="emailUpdates" class="accent-[#4f46e5] mt-0.5 w-4 h-4 flex-shrink-0" checked>
                    Receive email updates about APN programmes and news
                </label>
                <label class="flex items-start gap-3 text-sm text-[#475569] cursor-pointer mb-5 p-2 rounded-xl hover:bg-[#f8fafc] hover:translate-x-0.5 transition-all duration-200">
                    <input type="checkbox" id="textUpdates" class="accent-[#4f46e5] mt-0.5 w-4 h-4 flex-shrink-0">
                    Receive SMS updates
                </label>
            
                <button type="button" id="joinBtn" onclick="processMembership()"
                        class="w-full py-4 bg-gradient-to-r from-[#1e1b4b] via-[#2d1b4b] to-[#4f46e5] animate-gradient text-white border-none rounded-xl font-['Syne'] text-lg font-bold tracking-wide uppercase cursor-pointer transition-all duration-300 shadow-[0_15px_25px_-8px_rgba(79,70,229,0.4)] hover:-translate-y-1 hover:shadow-[0_20px_30px_-8px_rgba(79,70,229,0.6)] flex items-center justify-center gap-3 mt-8">
                    <span id="joinBtnText">Become a Member</span>
                    <i class="fas fa-arrow-right transition-transform duration-200 group-hover:translate-x-2"></i>
                </button>
                
                <div class="flex items-center justify-center gap-3 mt-6 text-xs text-[#94a3b8] flex-wrap">
                    <i class="fas fa-circle text-[#D4AF37] text-[0.4rem]"></i>
                    <span>256-bit encrypted</span>
                    <i class="fas fa-circle text-[#D4AF37] text-[0.4rem]"></i>
                    <span>Powered by Paystack</span>
                    <i class="fas fa-circle text-[#D4AF37] text-[0.4rem]"></i>
                    <span>No card data stored</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const INITIATE_URL = '{{ route("donation.initialize") }}';
    let selectedMembership = null;
    let selectedAmount = 0;

    // Setup membership selection
    document.querySelector('.select-monthly').addEventListener('click', function() {
        selectedMembership = 'monthly';
        selectedAmount = 35;
        document.getElementById('membershipAmount').value = 35;
        document.getElementById('membershipType').value = 'monthly';
        
        document.querySelectorAll('.membership-card').forEach(c => c.style.borderColor = '#e2e8f0');
        this.closest('.membership-card').style.borderColor = '#4f46e5';
        this.closest('.membership-card').style.borderWidth = '2px';
    });

    document.querySelector('.select-annual').addEventListener('click', function() {
        selectedMembership = 'annual';
        selectedAmount = 350;
        document.getElementById('membershipAmount').value = 350;
        document.getElementById('membershipType').value = 'annual';
        
        // Visual feedback
        document.querySelectorAll('.membership-card').forEach(c => c.style.borderColor = '#e2e8f0');
        this.closest('.membership-card').style.borderColor = '#4f46e5';
        this.closest('.membership-card').style.borderWidth = '2px';
    });

    function showError(msg) {
        const el = document.getElementById('errorAlert');
        document.getElementById('errorMsg').textContent = msg;
        el.classList.remove('hidden');
        el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function hideError() {
        document.getElementById('errorAlert').classList.add('hidden');
    }

    function validate() {
        if (!selectedMembership) {
            showError('Please select a membership plan.');
            return false;
        }

        const firstname = document.getElementById('firstname').value.trim();
        const lastname  = document.getElementById('lastname').value.trim();
        const email     = document.getElementById('donorEmail').value.trim();

        if (!firstname || !lastname) {
            showError('Please enter your first and last name.');
            return false;
        }
        if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            showError('Please enter a valid email address.');
            return false;
        }

        return true;
    }

    async function processMembership() {
        hideError();

        if (!validate()) return;

        const amount       = selectedAmount;
        const membershipType = selectedMembership;
        const email        = document.getElementById('donorEmail').value.trim();
        const firstname    = document.getElementById('firstname').value.trim();
        const lastname     = document.getElementById('lastname').value.trim();
        const phone        = document.getElementById('phone').value.trim();
        const country      = document.getElementById('country').value.trim();
        const city         = document.getElementById('city').value.trim();
        const region       = document.getElementById('region').value.trim();
        const emailUpdates = document.getElementById('emailUpdates').checked;
        const textUpdates  = document.getElementById('textUpdates').checked;

        const btn = document.getElementById('joinBtn');
        const btnText = document.getElementById('joinBtnText');
        btn.disabled = true;
        btnText.textContent = 'Processing...';

        try {
            const response = await fetch(INITIATE_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    amount: amount,
                    membership_type: membershipType,
                    email: email,
                    firstname: firstname,
                    lastname: lastname,
                    phone: phone,
                    country: country,
                    city: city,
                    region: region,
                    email_updates: emailUpdates,
                    text_updates: textUpdates
                })
            });

            const data = await response.json();

            if (data.status && data.status === true && data.data && data.data.authorization_url) {
                window.location.href = data.data.authorization_url;
            } else {
                throw new Error(data.message || 'Failed to process membership');
            }

        } catch (error) {
            console.error('Membership processing error:', error);
            btn.disabled = false;
            btnText.textContent = 'Become a Member';
            showError(error.message || 'Failed to process membership. Please try again.');
        }
    }
</script>
@endsection