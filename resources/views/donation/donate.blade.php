@extends('layouts.guest')

@section('content')

<style>
    * { font-family: 'Open Sans', sans-serif; }
    h1,h2,h3,h4,h5,h6,
    .font-syne,
    [class*="font-['Syne']"],
    [class*="font-['Urbanist']"],
    .price-tag,
    .popular-badge { font-family: 'Urbanist', sans-serif !important; }

    @keyframes pageReveal { from { opacity: 0; transform: scale(1.02); } to { opacity: 1; transform: scale(1); } }
    @keyframes patternMove { from { background-position: 0 0; } to { background-position: 200px 200px; } }
    @keyframes gradientShift { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }
    .animate-page-reveal { animation: pageReveal 0.9s cubic-bezier(0.22,1,0.36,1) both; }
    .animate-pattern { animation: patternMove 60s linear infinite; }
    .animate-gradient { animation: gradientShift 5s ease infinite; background-size: 200% 200%; }

    .apn-scrollbar::-webkit-scrollbar { width: 6px; }
    .apn-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
    .apn-scrollbar::-webkit-scrollbar-thumb { background: #3b82f6; border-radius: 3px; }

    .membership-card { transition: all 0.3s ease; position: relative; overflow: hidden; cursor: pointer; }
    .membership-card:hover { transform: translateY(-4px); box-shadow: 0 20px 28px -10px rgba(59,130,246,0.2); }
    .membership-card.selected { border-color: #3b82f6 !important; box-shadow: 0 0 0 3px rgba(59,130,246,0.18); transform: translateY(-2px); }

    .popular-badge {
        position: absolute; top: 12px; right: -30px;
        background: linear-gradient(135deg, #D4AF37, #B8860B);
        color: white; padding: 8px 40px; font-size: 0.7rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 1px; transform: rotate(45deg);
        box-shadow: 0 2px 10px rgba(0,0,0,0.1); z-index: 10;
    }
    .feature-list { list-style: none; padding: 0; margin: 0 0 1.5rem 0; }
    .feature-list li { display: flex; align-items: center; gap: 0.75rem; padding: 0.45rem 0; font-size: 0.88rem; color: #334155; border-bottom: 1px solid #f1f5f9; }
    .feature-list li:last-child { border-bottom: none; }
    .feature-list li i { color: #10b981; font-size: 0.85rem; width: 18px; text-align: center; }
    .price-tag { font-size: 2.1rem; font-weight: 800; color: #1e1b4b; line-height: 1.2; }
    .price-period { font-size: 0.88rem; color: #64748b; font-weight: 400; }

    .plan-checkbox-wrap {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        margin-top: 1.2rem;
        padding: 0.75rem 1rem;
        border-radius: 10px;
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        transition: all 0.2s ease;
        cursor: pointer;
        user-select: none;
    }
    .plan-checkbox-wrap.checked {
        background: #eff6ff;
        border-color: #3b82f6;
    }
    .plan-checkbox {
        width: 20px; height: 20px;
        border-radius: 6px;
        border: 2px solid #d1d5db;
        background: #fff;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        transition: all 0.2s ease;
        font-size: 0.75rem;
        color: transparent;
    }
    .plan-checkbox-wrap.checked .plan-checkbox {
        background: #3b82f6;
        border-color: #3b82f6;
        color: #fff;
    }
    .plan-checkbox-label {
        font-family: 'Urbanist', sans-serif;
        font-size: 0.88rem;
        font-weight: 700;
        color: #64748b;
        transition: color 0.2s ease;
    }
    .plan-checkbox-wrap.checked .plan-checkbox-label { color: #3b82f6; }

    /* Swapped panel styles */
    .left-panel { background: #fff; overflow-y: auto; display: flex; align-items: flex-start; justify-content: center; }
    .right-panel { position: relative; overflow: hidden; background-size: cover; background-position: center; background-image: url('https://membership.africaprosperitynetwork.com/wp-content/uploads/2026/03/Group-598.jpg'); flex-shrink: 0; }
    
    .apn-layout { display: flex; width: 100%; min-height: 100vh; }

    @media (min-width: 1024px) {
        .apn-layout { flex-direction: row; height: 100vh; overflow: hidden; }
        .left-panel { width: 50%; height: 100vh; }
        .right-panel { width: 50%; min-height: 100vh; display: flex; flex-direction: column; justify-content: flex-end; }
    }
    @media (min-width: 640px) and (max-width: 1023px) {
        .apn-layout { flex-direction: column; }
        .left-panel { width: 100%; }
        .right-panel { width: 100%; min-height: 340px; display: flex; flex-direction: column; justify-content: flex-end; }
    }
    @media (max-width: 639px) {
        .apn-layout { flex-direction: column; }
        .left-panel { width: 100%; }
        .right-panel { width: 100%; min-height: 260px; display: flex; flex-direction: column; justify-content: flex-end; }
        .right-panel .panel-text { padding: 1.5rem 1.25rem; }
        .right-panel .panel-heading { font-size: 1.8rem !important; }
        .right-panel .panel-sub { display: none; }
        .membership-grid { grid-template-columns: 1fr !important; }
        .form-two-col { grid-template-columns: 1fr !important; }
        .login-btn-top { display: none !important; }
        .login-mobile-note { display: block !important; }
    }

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

    .field-apn { width: 100%; padding: 0.75rem 0.75rem 0.75rem 2.6rem; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 0.88rem; color: #1e293b; transition: all 0.2s ease; outline: none; font-family: 'Open Sans', sans-serif; }
    .field-apn:focus { border-color: #3b82f6; background: #fff; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
    .field-wrap { position: relative; }
    .field-wrap > i.field-icon { position: absolute; left: 0.8rem; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.85rem; pointer-events: none; z-index: 2; }

    .country-picker { position: relative; }
    .country-trigger { width: 100%; padding: 0.75rem 2.5rem 0.75rem 2.6rem; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 0.88rem; color: #1e293b; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; transition: all 0.2s ease; text-align: left; outline: none; user-select: none; font-family: 'Open Sans', sans-serif; }
    .country-trigger:hover, .country-trigger.open { border-color: #3b82f6; background: #fff; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
    .country-trigger .flag { font-size: 1.1rem; flex-shrink: 0; }
    .country-trigger .ct-name { flex: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .country-trigger .ct-chevron { position: absolute; right: 0.8rem; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.75rem; transition: transform 0.2s ease; }
    .country-trigger.open .ct-chevron { transform: translateY(-50%) rotate(180deg); }
    .country-trigger .globe-icon { position: absolute; left: 0.8rem; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.85rem; pointer-events: none; }
    .country-dropdown { position: absolute; top: calc(100% + 4px); left: 0; right: 0; background: #fff; border: 2px solid #e2e8f0; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.12); z-index: 100; display: none; overflow: hidden; }
    .country-dropdown.open { display: block; }
    .country-search-wrap { padding: 0.6rem; border-bottom: 1px solid #f1f5f9; position: relative; }
    .country-search { width: 100%; padding: 0.5rem 0.8rem 0.5rem 2rem; border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: 0.83rem; outline: none; background: #f8fafc; font-family: 'Open Sans', sans-serif; }
    .country-search:focus { border-color: #3b82f6; background: #fff; }
    .country-search-wrap .search-icon { position: absolute; left: 1.2rem; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.75rem; pointer-events: none; }
    .country-list { max-height: 220px; overflow-y: auto; }
    .country-list::-webkit-scrollbar { width: 4px; }
    .country-list::-webkit-scrollbar-thumb { background: #3b82f6; border-radius: 4px; }
    .country-item { display: flex; align-items: center; gap: 0.6rem; padding: 0.55rem 0.9rem; font-size: 0.85rem; color: #334155; cursor: pointer; transition: background 0.15s ease; font-family: 'Open Sans', sans-serif; }
    .country-item:hover { background: #eff6ff; }
    .country-item.selected { background: #dbeafe; font-weight: 600; }
    .country-item .ci-flag { font-size: 1.05rem; flex-shrink: 0; }
    .country-item .ci-name { flex: 1; }
    .country-no-results { padding: 1rem; text-align: center; color: #94a3b8; font-size: 0.83rem; }

    .region-picker { position: relative; }
    .region-trigger { width: 100%; padding: 0.75rem 2.5rem 0.75rem 2.6rem; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 0.88rem; color: #1e293b; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; transition: all 0.2s ease; text-align: left; outline: none; user-select: none; font-family: 'Open Sans', sans-serif; }
    .region-trigger:hover, .region-trigger.open { border-color: #3b82f6; background: #fff; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
    .region-trigger .rt-name { flex: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .region-trigger .rt-chevron { position: absolute; right: 0.8rem; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.75rem; transition: transform 0.2s ease; }
    .region-trigger.open .rt-chevron { transform: translateY(-50%) rotate(180deg); }
    .region-trigger .rt-icon { position: absolute; left: 0.8rem; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.85rem; pointer-events: none; }
    .region-dropdown { position: absolute; top: calc(100% + 4px); left: 0; right: 0; background: #fff; border: 2px solid #e2e8f0; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.12); z-index: 100; display: none; overflow: hidden; }
    .region-dropdown.open { display: block; }
    .region-list { max-height: 220px; overflow-y: auto; }
    .region-list::-webkit-scrollbar { width: 4px; }
    .region-list::-webkit-scrollbar-thumb { background: #3b82f6; border-radius: 4px; }
    .region-item { display: flex; align-items: flex-start; gap: 0.5rem; padding: 0.6rem 0.9rem; font-size: 0.85rem; color: #334155; cursor: pointer; transition: background 0.15s ease; border-bottom: 1px solid #f8fafc; font-family: 'Open Sans', sans-serif; }
    .region-item:last-child { border-bottom: none; }
    .region-item:hover { background: #eff6ff; }
    .region-item.selected { background: #dbeafe; font-weight: 600; }
    .region-item .ri-name { font-weight: 700; color: #1e293b; font-family: 'Urbanist', sans-serif; }
    .region-item .ri-cap { font-size: 0.75rem; color: #64748b; margin-top: 1px; }
    .region-custom-wrap { border-top: 1px solid #e2e8f0; padding: 0.6rem; background: #fafbfc; }
    .region-custom-input { width: 100%; padding: 0.5rem 0.8rem; border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: 0.83rem; outline: none; background: #fff; color: #1e293b; font-family: 'Open Sans', sans-serif; }
    .region-custom-input:focus { border-color: #3b82f6; }
    .region-custom-label { font-size: 0.73rem; color: #94a3b8; margin-bottom: 0.35rem; display: block; }
</style>

<div class="apn-layout animate-page-reveal">

    <!-- Right Panel -->
    <div class="right-panel">
        <div class="absolute inset-0 bg-gradient-to-br from-[#0f172a]/60 via-[#1e1b4b]/45 to-[#2d1b4b]/30 z-[1]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_70%_30%,rgba(212,175,55,0.1),transparent_70%)] z-[2] pointer-events-none"></div>
        <div class="absolute inset-0 opacity-8 z-[3] pointer-events-none animate-pattern"
             style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\" opacity=\"0.1\"><path d=\"M20,20 L30,10 L40,20 L50,10 L60,20 L70,10 L80,20 L70,30 L80,40 L70,50 L80,60 L70,70 L80,80 L70,90 L60,80 L50,90 L40,80 L30,90 L20,80 L30,70 L20,60 L30,50 L20,40 L30,30 Z\" fill=\"%23D4AF37\"/><circle cx=\"50\" cy=\"50\" r=\"5\" fill=\"%233b82f6\"/></svg>')</div>
        <div class="relative z-[4] px-8 md:px-14 py-12 text-white bg-gradient-to-t from-black/50 via-transparent to-transparent panel-text">
            <div class="flex items-center gap-2 mb-3 text-xs font-semibold tracking-[3px] uppercase text-[#D4AF37]" style="font-family:'Urbanist',sans-serif;">
                <span class="w-10 h-[2px] bg-gradient-to-r from-[#D4AF37] to-transparent"></span>
                AFRICA PROSPERITY NETWORK
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold leading-[1.1] mb-4 drop-shadow-lg panel-heading" style="font-family:'Urbanist',sans-serif;">
                Join the<br>
                <span class="text-[#D4AF37] relative inline-block">
                    Movement
                    <span class="absolute bottom-1 left-0 w-full h-2 bg-[#D4AF37]/30 -z-[1]"></span>
                </span><br>
                for Prosperity
            </h1>
            <p class="text-sm leading-relaxed text-white/90 max-w-[420px] font-light panel-sub">
                Choose to become a member to support Africa's economic integration and shared prosperity.
            </p>
        </div>
    </div>




    <!-- Left Panel -->
    <div class="left-panel apn-scrollbar p-6 md:p-8 relative">
      <div class="login-btn-top absolute top-6 right-6 z-20">
    <a href="{{ route('donor.login') }}"
       class="inline-flex items-center gap-2 text-sm text-[#64748b] hover:text-[#3b82f6] transition-colors duration-300">
        <i class="fas fa-sign-in-alt text-xs"></i>
        <span>Login</span>
    </a>
</div>

        <div class="max-w-[860px] w-full mx-auto bg-white rounded-2xl p-6 md:p-10 shadow-[0_20px_40px_-15px_rgba(0,0,0,0.15),inset_0_0_0_1px_rgba(0,0,0,0.02)] mt-14 lg:mt-10">

            <!-- Logo in black circle above the form -->
            <div class="logo-circle animate-float">
                <img src="https://res.cloudinary.com/dvsacegwf/image/upload/v1773785052/APN-LOGOS-01-e1733932773480-scaled_l1coi5.png" alt="APN Logo">
            </div>

            <div class="text-center mb-7">
                <h2 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-[#1e1b4b] to-[#2d1b4b] bg-clip-text text-transparent mb-1" style="font-family:'Urbanist',sans-serif;">APN Membership Registration</h2>
                <p class="text-md text-[#64748b]">Select a membership plan to proceed with registration</p>
            </div>

            <div id="errorAlert" class="bg-red-50 border-2 border-red-200 rounded-xl p-4 mb-6 flex items-center gap-3 text-red-600 text-sm hidden">
                <i class="fas fa-exclamation-circle"></i>
                <span id="errorMsg">Something went wrong.</span>
            </div>

            <div class="grid gap-5 mb-7 membership-grid" style="grid-template-columns: repeat(2, 1fr);">
    <!-- Monthly Plan -->
    <div class="membership-card bg-white border-2 border-[#e2e8f0] rounded-2xl p-6 flex flex-col relative" onclick="selectPlan('monthly',10,this)">
        <div class="mb-5">
            <h3 class="text-xl font-bold text-[#1e1b4b] mb-1" style="font-family:'Urbanist',sans-serif;">Monthly</h3>
            <div class="flex items-baseline gap-1">
                <span class="price-tag">$10</span>
                <span class="price-period">/month</span>
            </div>
            <p class="text-xs text-[#64748b] mt-1.5">Flexible month-to-month access to all APN benefits.</p>
        </div>
        <ul class="feature-list flex-grow">
            <li><i class="fas fa-check-circle"></i> Full APN membership access</li>
            <li><i class="fas fa-check-circle"></i> 10% discount on events & merch</li>
            <li><i class="fas fa-check-circle"></i> Monthly newsletters</li>
            <li><i class="fas fa-check-circle"></i> Borderless campaign enrollment</li>
            <li><i class="fas fa-check-circle"></i> APN Magazine digital access</li>
        </ul>
        <div class="plan-checkbox-wrap" id="checkbox-monthly">
            <div class="plan-checkbox"><i class="fas fa-check"></i></div>
            <span class="plan-checkbox-label">Select Monthly Plan</span>
        </div>
    </div>

    <!-- Annual Plan -->
    <div class="membership-card bg-gradient-to-br from-[#f8fafc] to-white border-2 border-[#3b82f6] rounded-2xl p-6 flex flex-col relative overflow-hidden selected" onclick="selectPlan('annual',100,this)">
        <div class="popular-badge">POPULAR</div>
        <div class="mb-5">
            <h3 class="text-xl font-bold text-[#1e1b4b] mb-1" style="font-family:'Urbanist',sans-serif;">Annual</h3>
            <div class="flex items-baseline gap-1">
                <span class="price-tag">$100</span>
                <span class="price-period">/year</span>
            </div>
            <p class="text-xs text-[#64748b] mt-1.5">Best value — save with an annual commitment.</p>
        </div>
        <ul class="feature-list flex-grow">
            <li><i class="fas fa-check-circle"></i> Everything in Monthly</li>
            <li><i class="fas fa-check-circle"></i> Priority event registration</li>
            <li><i class="fas fa-check-circle"></i> Exclusive member directory listing</li>
            <li><i class="fas fa-check-circle"></i> Awards & recognition eligibility</li>
            <li><i class="fas fa-check-circle"></i> APD conference discounts</li>
            <li><i class="fas fa-check-circle" style="color:#D4AF37;"></i> <span class="font-semibold">Save $20 compared to monthly</span></li>
        </ul>
        <div class="plan-checkbox-wrap checked" id="checkbox-annual">
            <div class="plan-checkbox"><i class="fas fa-check"></i></div>
            <span class="plan-checkbox-label">Annual Plan Selected</span>
        </div>
    </div>
</div>

<input type="hidden" id="membershipAmount" value="100">
<input type="hidden" id="membershipType" value="annual">

            <input type="hidden" id="country" value="">

            <div class="flex items-center gap-3 my-6">
                <div class="flex-1 h-px bg-gradient-to-r from-transparent via-[#e2e8f0] to-transparent"></div>
                <span class="text-xs text-[#D4AF37] uppercase tracking-wider font-semibold" style="font-family:'Urbanist',sans-serif;">Membership Details</span>
                <div class="flex-1 h-px bg-gradient-to-r from-transparent via-[#e2e8f0] to-transparent"></div>
            </div>

            <div class="grid gap-3 mb-4 form-two-col" style="grid-template-columns: repeat(2, 1fr);">
                <div>
                    <label class="flex items-center gap-1 text-xs font-semibold text-[#334155] mb-1.5" style="font-family:'Urbanist',sans-serif;">
                        <i class="fas fa-user text-[#3b82f6]" style="font-size:0.75rem;"></i> First Name <span class="text-red-500">*</span>
                    </label>
                    <div class="field-wrap">
                        <i class="fas fa-user field-icon"></i>
                        <input type="text" id="firstname" class="field-apn" placeholder="John" required>
                    </div>
                </div>
                <div>
                    <label class="flex items-center gap-1 text-xs font-semibold text-[#334155] mb-1.5" style="font-family:'Urbanist',sans-serif;">
                        <i class="fas fa-user text-[#3b82f6]" style="font-size:0.75rem;"></i> Last Name <span class="text-red-500">*</span>
                    </label>
                    <div class="field-wrap">
                        <i class="fas fa-user field-icon"></i>
                        <input type="text" id="lastname" class="field-apn" placeholder="Doe" required>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <label class="flex items-center gap-1 text-xs font-semibold text-[#334155] mb-1.5" style="font-family:'Urbanist',sans-serif;">
                    <i class="far fa-envelope text-[#3b82f6]" style="font-size:0.75rem;"></i> Email Address <span class="text-red-500">*</span>
                </label>
                <div class="field-wrap">
                    <i class="far fa-envelope field-icon"></i>
                    <input type="email" id="donorEmail" class="field-apn" placeholder="you@example.com" required>
                </div>
            </div>

            <div class="grid gap-3 mb-4 form-two-col" style="grid-template-columns: repeat(2, 1fr);">
                <div>
                    <label class="flex items-center gap-1 text-xs font-semibold text-[#334155] mb-1.5" style="font-family:'Urbanist',sans-serif;">
                        <i class="fas fa-phone text-[#3b82f6]" style="font-size:0.75rem;"></i> Phone
                    </label>
                    <div class="field-wrap">
                        <i class="fas fa-phone field-icon"></i>
                        <input type="text" id="phone" class="field-apn" placeholder="+233 XX XXX XXXX">
                    </div>
                </div>
                <div>
                    <label class="flex items-center gap-1 text-xs font-semibold text-[#334155] mb-1.5" style="font-family:'Urbanist',sans-serif;">
                        <i class="fas fa-globe text-[#3b82f6]" style="font-size:0.75rem;"></i> Country
                    </label>
                    <div class="country-picker" id="countryPicker">
                        <button type="button" class="country-trigger" id="countryTrigger" onclick="toggleCountryDropdown()">
                            <i class="fas fa-globe globe-icon"></i>
                            <span class="flag" id="selectedFlag"></span>
                            <span class="ct-name" id="selectedCountryName">Select country</span>
                            <i class="fas fa-chevron-down ct-chevron"></i>
                        </button>
                        <div class="country-dropdown" id="countryDropdown">
                            <div class="country-search-wrap">
                                <i class="fas fa-search search-icon"></i>
                                <input type="text" class="country-search" id="countrySearch" placeholder="Search country..." oninput="filterCountries(this.value)">
                            </div>
                            <div class="country-list" id="countryList"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid gap-3 mb-4 form-two-col" style="grid-template-columns: repeat(2, 1fr);">
                <div>
                    <label class="flex items-center gap-1 text-xs font-semibold text-[#334155] mb-1.5" style="font-family:'Urbanist',sans-serif;">
                        <i class="fas fa-city text-[#3b82f6]" style="font-size:0.75rem;"></i> City
                    </label>
                    <div class="field-wrap">
                        <i class="fas fa-city field-icon"></i>
                        <input type="text" id="city" class="field-apn" placeholder="Accra">
                    </div>
                </div>
                <div>
                    <label class="flex items-center gap-1 text-xs font-semibold text-[#334155] mb-1.5" style="font-family:'Urbanist',sans-serif;">
                        <i class="fas fa-map text-[#3b82f6]" style="font-size:0.75rem;"></i> Region
                    </label>
                    <input type="hidden" id="region" value="">
                    <div class="region-picker" id="regionPicker">
                        <button type="button" class="region-trigger" id="regionTrigger" onclick="toggleRegionDropdown()">
                            <i class="fas fa-map rt-icon"></i>
                            <span class="rt-name" id="selectedRegionName">Select or type region</span>
                            <i class="fas fa-chevron-down rt-chevron"></i>
                        </button>
                        <div class="region-dropdown" id="regionDropdown">
                            <div class="region-list" id="regionList"></div>
                            <div class="region-custom-wrap">
                                <span class="region-custom-label">Not listed? Type your region:</span>
                                <input type="text" class="region-custom-input" id="regionCustomInput" placeholder="e.g. Ashanti, Northern..." oninput="onRegionCustomInput(this.value)">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" id="joinBtn" onclick="processMembership()"
                    class="w-full py-4 bg-gradient-to-r from-[#1e1b4b] via-[#2d1b4b] to-[#3b82f6] animate-gradient text-white border-none rounded-xl text-base font-bold tracking-wide uppercase cursor-pointer transition-all duration-300 shadow-[0_12px_22px_-6px_rgba(59,130,246,0.4)] hover:-translate-y-1 hover:shadow-[0_18px_28px_-6px_rgba(59,130,246,0.55)] flex items-center justify-center gap-3" style="font-family:'Urbanist',sans-serif;">
                <span id="joinBtnText">REGISTER</span>
                <i class="fas fa-chevron-right"></i>
            </button>

            <div class="text-center mt-6 pt-5 border-t-2 border-[#e2e8f0]">
    <p class="text-sm text-[#64748b]">
        Already have an account?
        <a href="{{ route('donor.login') }}" 
           class="font-semibold text-[#3b82f6] hover:text-[#2563eb] transition-colors duration-300 hover:underline ml-1">
            Sign in here
            <i class="fas fa-arrow-right text-xs ml-1"></i>
        </a>
    </p>
</div>

        </div>
    </div>
</div>

<script>
const INITIATE_URL = '{{ route("donation.initialize") }}';
let selectedMembership = 'annual';
let selectedAmount = 350;

function selectPlan(type, amount, cardEl) {
    selectedMembership = type;
    selectedAmount = amount;
    document.getElementById('membershipAmount').value = amount;
    document.getElementById('membershipType').value = type;

    document.querySelectorAll('.membership-card').forEach(c => {
        c.classList.remove('selected');
        const cb = c.querySelector('.plan-checkbox-wrap');
        const lbl = c.querySelector('.plan-checkbox-label');
        if (cb) cb.classList.remove('checked');
        if (lbl) lbl.textContent = 'Select ' + (c.querySelector('h3')?.textContent.trim() || '') + ' Plan';
    });

    cardEl.classList.add('selected');
    const cb = cardEl.querySelector('.plan-checkbox-wrap');
    const lbl = cardEl.querySelector('.plan-checkbox-label');
    if (cb) cb.classList.add('checked');
    const planName = cardEl.querySelector('h3')?.textContent.trim() || '';
    if (lbl) lbl.textContent = planName + ' Plan Selected';
    document.getElementById('joinBtnText').textContent = 'Register — ' + planName + ' Plan';
}

const COUNTRIES = [
    {code:'DZ',name:'Algeria',flag:'🇩🇿'},{code:'AO',name:'Angola',flag:'🇦🇴'},
    {code:'BJ',name:'Benin',flag:'🇧🇯'},{code:'BW',name:'Botswana',flag:'🇧🇼'},
    {code:'BF',name:'Burkina Faso',flag:'🇧🇫'},{code:'BI',name:'Burundi',flag:'🇧🇮'},
    {code:'CV',name:'Cape Verde',flag:'🇨🇻'},{code:'CF',name:'Central African Republic',flag:'🇨🇫'},
    {code:'TD',name:'Chad',flag:'🇹🇩'},{code:'KM',name:'Comoros',flag:'🇰🇲'},
    {code:'CG',name:'Congo',flag:'🇨🇬'},{code:'CD',name:'DR Congo',flag:'🇨🇩'},
    {code:'CI',name:"Côte d'Ivoire",flag:'🇨🇮'},{code:'DJ',name:'Djibouti',flag:'🇩🇯'},
    {code:'EG',name:'Egypt',flag:'🇪🇬'},{code:'GQ',name:'Equatorial Guinea',flag:'🇬🇶'},
    {code:'ER',name:'Eritrea',flag:'🇪🇷'},{code:'SZ',name:'Eswatini',flag:'🇸🇿'},
    {code:'ET',name:'Ethiopia',flag:'🇪🇹'},{code:'GA',name:'Gabon',flag:'🇬🇦'},
    {code:'GM',name:'Gambia',flag:'🇬🇲'},{code:'GH',name:'Ghana',flag:'🇬🇭'},
    {code:'GN',name:'Guinea',flag:'🇬🇳'},{code:'GW',name:'Guinea-Bissau',flag:'🇬🇼'},
    {code:'KE',name:'Kenya',flag:'🇰🇪'},{code:'LS',name:'Lesotho',flag:'🇱🇸'},
    {code:'LR',name:'Liberia',flag:'🇱🇷'},{code:'LY',name:'Libya',flag:'🇱🇾'},
    {code:'MG',name:'Madagascar',flag:'🇲🇬'},{code:'MW',name:'Malawi',flag:'🇲🇼'},
    {code:'ML',name:'Mali',flag:'🇲🇱'},{code:'MR',name:'Mauritania',flag:'🇲🇷'},
    {code:'MU',name:'Mauritius',flag:'🇲🇺'},{code:'YT',name:'Mayotte',flag:'🇾🇹'},
    {code:'MA',name:'Morocco',flag:'🇲🇦'},{code:'MZ',name:'Mozambique',flag:'🇲🇿'},
    {code:'NA',name:'Namibia',flag:'🇳🇦'},{code:'NE',name:'Niger',flag:'🇳🇪'},
    {code:'NG',name:'Nigeria',flag:'🇳🇬'},{code:'RE',name:'Réunion',flag:'🇷🇪'},
    {code:'RW',name:'Rwanda',flag:'🇷🇼'},{code:'SH',name:'Saint Helena',flag:'🇸🇭'},
    {code:'ST',name:'São Tomé & Príncipe',flag:'🇸🇹'},{code:'SN',name:'Senegal',flag:'🇸🇳'},
    {code:'SC',name:'Seychelles',flag:'🇸🇨'},{code:'SL',name:'Sierra Leone',flag:'🇸🇱'},
    {code:'SO',name:'Somalia',flag:'🇸🇴'},{code:'ZA',name:'South Africa',flag:'🇿🇦'},
    {code:'SS',name:'South Sudan',flag:'🇸🇸'},{code:'SD',name:'Sudan',flag:'🇸🇩'},
    {code:'TZ',name:'Tanzania',flag:'🇹🇿'},{code:'TG',name:'Togo',flag:'🇹🇬'},
    {code:'TN',name:'Tunisia',flag:'🇹🇳'},{code:'UG',name:'Uganda',flag:'🇺🇬'},
    {code:'ZM',name:'Zambia',flag:'🇿🇲'},{code:'ZW',name:'Zimbabwe',flag:'🇿🇼'},
    {code:'AG',name:'Antigua & Barbuda',flag:'🇦🇬'},{code:'AR',name:'Argentina',flag:'🇦🇷'},
    {code:'BS',name:'Bahamas',flag:'🇧🇸'},{code:'BB',name:'Barbados',flag:'🇧🇧'},
    {code:'BZ',name:'Belize',flag:'🇧🇿'},{code:'BO',name:'Bolivia',flag:'🇧🇴'},
    {code:'BR',name:'Brazil',flag:'🇧🇷'},{code:'CA',name:'Canada',flag:'🇨🇦'},
    {code:'CL',name:'Chile',flag:'🇨🇱'},{code:'CO',name:'Colombia',flag:'🇨🇴'},
    {code:'CR',name:'Costa Rica',flag:'🇨🇷'},{code:'CU',name:'Cuba',flag:'🇨🇺'},
    {code:'DM',name:'Dominica',flag:'🇩🇲'},{code:'DO',name:'Dominican Republic',flag:'🇩🇴'},
    {code:'EC',name:'Ecuador',flag:'🇪🇨'},{code:'SV',name:'El Salvador',flag:'🇸🇻'},
    {code:'GD',name:'Grenada',flag:'🇬🇩'},{code:'GT',name:'Guatemala',flag:'🇬🇹'},
    {code:'GY',name:'Guyana',flag:'🇬🇾'},{code:'HT',name:'Haiti',flag:'🇭🇹'},
    {code:'HN',name:'Honduras',flag:'🇭🇳'},{code:'JM',name:'Jamaica',flag:'🇯🇲'},
    {code:'MX',name:'Mexico',flag:'🇲🇽'},{code:'NI',name:'Nicaragua',flag:'🇳🇮'},
    {code:'PA',name:'Panama',flag:'🇵🇦'},{code:'PY',name:'Paraguay',flag:'🇵🇾'},
    {code:'PE',name:'Peru',flag:'🇵🇪'},{code:'KN',name:'Saint Kitts & Nevis',flag:'🇰🇳'},
    {code:'LC',name:'Saint Lucia',flag:'🇱🇨'},{code:'VC',name:'Saint Vincent',flag:'🇻🇨'},
    {code:'SR',name:'Suriname',flag:'🇸🇷'},{code:'TT',name:'Trinidad & Tobago',flag:'🇹🇹'},
    {code:'US',name:'United States',flag:'🇺🇸'},{code:'UY',name:'Uruguay',flag:'🇺🇾'},
    {code:'VE',name:'Venezuela',flag:'🇻🇪'},
    {code:'AF',name:'Afghanistan',flag:'🇦🇫'},{code:'AM',name:'Armenia',flag:'🇦🇲'},
    {code:'AZ',name:'Azerbaijan',flag:'🇦🇿'},{code:'BH',name:'Bahrain',flag:'🇧🇭'},
    {code:'BD',name:'Bangladesh',flag:'🇧🇩'},{code:'BT',name:'Bhutan',flag:'🇧🇹'},
    {code:'BN',name:'Brunei',flag:'🇧🇳'},{code:'KH',name:'Cambodia',flag:'🇰🇭'},
    {code:'CN',name:'China',flag:'🇨🇳'},{code:'CY',name:'Cyprus',flag:'🇨🇾'},
    {code:'GE',name:'Georgia',flag:'🇬🇪'},{code:'IN',name:'India',flag:'🇮🇳'},
    {code:'ID',name:'Indonesia',flag:'🇮🇩'},{code:'IR',name:'Iran',flag:'🇮🇷'},
    {code:'IQ',name:'Iraq',flag:'🇮🇶'},{code:'IL',name:'Israel',flag:'🇮🇱'},
    {code:'JP',name:'Japan',flag:'🇯🇵'},{code:'JO',name:'Jordan',flag:'🇯🇴'},
    {code:'KZ',name:'Kazakhstan',flag:'🇰🇿'},{code:'KW',name:'Kuwait',flag:'🇰🇼'},
    {code:'KG',name:'Kyrgyzstan',flag:'🇰🇬'},{code:'LA',name:'Laos',flag:'🇱🇦'},
    {code:'LB',name:'Lebanon',flag:'🇱🇧'},{code:'MY',name:'Malaysia',flag:'🇲🇾'},
    {code:'MV',name:'Maldives',flag:'🇲🇻'},{code:'MN',name:'Mongolia',flag:'🇲🇳'},
    {code:'MM',name:'Myanmar',flag:'🇲🇲'},{code:'NP',name:'Nepal',flag:'🇳🇵'},
    {code:'KP',name:'North Korea',flag:'🇰🇵'},{code:'OM',name:'Oman',flag:'🇴🇲'},
    {code:'PK',name:'Pakistan',flag:'🇵🇰'},{code:'PS',name:'Palestine',flag:'🇵🇸'},
    {code:'PH',name:'Philippines',flag:'🇵🇭'},{code:'QA',name:'Qatar',flag:'🇶🇦'},
    {code:'SA',name:'Saudi Arabia',flag:'🇸🇦'},{code:'SG',name:'Singapore',flag:'🇸🇬'},
    {code:'KR',name:'South Korea',flag:'🇰🇷'},{code:'LK',name:'Sri Lanka',flag:'🇱🇰'},
    {code:'SY',name:'Syria',flag:'🇸🇾'},{code:'TW',name:'Taiwan',flag:'🇹🇼'},
    {code:'TJ',name:'Tajikistan',flag:'🇹🇯'},{code:'TH',name:'Thailand',flag:'🇹🇭'},
    {code:'TL',name:'Timor-Leste',flag:'🇹🇱'},{code:'TR',name:'Turkey',flag:'🇹🇷'},
    {code:'TM',name:'Turkmenistan',flag:'🇹🇲'},{code:'AE',name:'United Arab Emirates',flag:'🇦🇪'},
    {code:'UZ',name:'Uzbekistan',flag:'🇺🇿'},{code:'VN',name:'Vietnam',flag:'🇻🇳'},
    {code:'YE',name:'Yemen',flag:'🇾🇪'},
    {code:'AL',name:'Albania',flag:'🇦🇱'},{code:'AD',name:'Andorra',flag:'🇦🇩'},
    {code:'AT',name:'Austria',flag:'🇦🇹'},{code:'BY',name:'Belarus',flag:'🇧🇾'},
    {code:'BE',name:'Belgium',flag:'🇧🇪'},{code:'BA',name:'Bosnia & Herzegovina',flag:'🇧🇦'},
    {code:'BG',name:'Bulgaria',flag:'🇧🇬'},{code:'HR',name:'Croatia',flag:'🇭🇷'},
    {code:'CZ',name:'Czech Republic',flag:'🇨🇿'},{code:'DK',name:'Denmark',flag:'🇩🇰'},
    {code:'EE',name:'Estonia',flag:'🇪🇪'},{code:'FI',name:'Finland',flag:'🇫🇮'},
    {code:'FR',name:'France',flag:'🇫🇷'},{code:'DE',name:'Germany',flag:'🇩🇪'},
    {code:'GR',name:'Greece',flag:'🇬🇷'},{code:'HU',name:'Hungary',flag:'🇭🇺'},
    {code:'IS',name:'Iceland',flag:'🇮🇸'},{code:'IE',name:'Ireland',flag:'🇮🇪'},
    {code:'IT',name:'Italy',flag:'🇮🇹'},{code:'XK',name:'Kosovo',flag:'🇽🇰'},
    {code:'LV',name:'Latvia',flag:'🇱🇻'},{code:'LI',name:'Liechtenstein',flag:'🇱🇮'},
    {code:'LT',name:'Lithuania',flag:'🇱🇹'},{code:'LU',name:'Luxembourg',flag:'🇱🇺'},
    {code:'MT',name:'Malta',flag:'🇲🇹'},{code:'MD',name:'Moldova',flag:'🇲🇩'},
    {code:'MC',name:'Monaco',flag:'🇲🇨'},{code:'ME',name:'Montenegro',flag:'🇲🇪'},
    {code:'NL',name:'Netherlands',flag:'🇳🇱'},{code:'MK',name:'North Macedonia',flag:'🇲🇰'},
    {code:'NO',name:'Norway',flag:'🇳🇴'},{code:'PL',name:'Poland',flag:'🇵🇱'},
    {code:'PT',name:'Portugal',flag:'🇵🇹'},{code:'RO',name:'Romania',flag:'🇷🇴'},
    {code:'RU',name:'Russia',flag:'🇷🇺'},{code:'SM',name:'San Marino',flag:'🇸🇲'},
    {code:'RS',name:'Serbia',flag:'🇷🇸'},{code:'SK',name:'Slovakia',flag:'🇸🇰'},
    {code:'SI',name:'Slovenia',flag:'🇸🇮'},{code:'ES',name:'Spain',flag:'🇪🇸'},
    {code:'SE',name:'Sweden',flag:'🇸🇪'},{code:'CH',name:'Switzerland',flag:'🇨🇭'},
    {code:'UA',name:'Ukraine',flag:'🇺🇦'},{code:'GB',name:'United Kingdom',flag:'🇬🇧'},
    {code:'VA',name:'Vatican City',flag:'🇻🇦'},
    {code:'AU',name:'Australia',flag:'🇦🇺'},{code:'FJ',name:'Fiji',flag:'🇫🇯'},
    {code:'KI',name:'Kiribati',flag:'🇰🇮'},{code:'MH',name:'Marshall Islands',flag:'🇲🇭'},
    {code:'FM',name:'Micronesia',flag:'🇫🇲'},{code:'NR',name:'Nauru',flag:'🇳🇷'},
    {code:'NZ',name:'New Zealand',flag:'🇳🇿'},{code:'PW',name:'Palau',flag:'🇵🇼'},
    {code:'PG',name:'Papua New Guinea',flag:'🇵🇬'},{code:'WS',name:'Samoa',flag:'🇼🇸'},
    {code:'SB',name:'Solomon Islands',flag:'🇸🇧'},{code:'TO',name:'Tonga',flag:'🇹🇴'},
    {code:'TV',name:'Tuvalu',flag:'🇹🇻'},{code:'VU',name:'Vanuatu',flag:'🇻🇺'},
].sort((a,b) => a.name.localeCompare(b.name));

let countryDropdownOpen = false;

function buildCountryList(filter = '') {
    const list = document.getElementById('countryList');
    const q = filter.toLowerCase();
    const filtered = COUNTRIES.filter(c => c.name.toLowerCase().includes(q));
    if (filtered.length === 0) { list.innerHTML = '<div class="country-no-results">No countries found</div>'; return; }
    list.innerHTML = filtered.map(c => `<div class="country-item" onclick="selectCountry('${c.code}','${c.name}','${c.flag}')"><span class="ci-flag">${c.flag}</span><span class="ci-name">${c.name}</span></div>`).join('');
}

function toggleCountryDropdown() {
    const dropdown = document.getElementById('countryDropdown');
    const trigger = document.getElementById('countryTrigger');
    countryDropdownOpen = !countryDropdownOpen;
    dropdown.classList.toggle('open', countryDropdownOpen);
    trigger.classList.toggle('open', countryDropdownOpen);
    if (countryDropdownOpen) { buildCountryList(); setTimeout(() => document.getElementById('countrySearch').focus(), 50); }
}

function filterCountries(q) { buildCountryList(q); }

function selectCountry(code, name, flag) {
    document.getElementById('country').value = name;
    document.getElementById('selectedFlag').textContent = flag;
    document.getElementById('selectedCountryName').textContent = name;
    document.querySelectorAll('.country-item').forEach(el => el.classList.remove('selected'));
    event.currentTarget.classList.add('selected');
    document.getElementById('countryDropdown').classList.remove('open');
    document.getElementById('countryTrigger').classList.remove('open');
    countryDropdownOpen = false;
}

document.addEventListener('click', function(e) {
    const picker = document.getElementById('countryPicker');
    if (picker && !picker.contains(e.target)) {
        document.getElementById('countryDropdown').classList.remove('open');
        document.getElementById('countryTrigger').classList.remove('open');
        countryDropdownOpen = false;
    }
});

const GHANA_REGIONS = [
    {name:'Ahafo',capital:'Goaso'},{name:'Ashanti',capital:'Kumasi'},
    {name:'Bono',capital:'Sunyani'},{name:'Bono East',capital:'Techiman'},
    {name:'Central',capital:'Cape Coast'},{name:'Eastern',capital:'Koforidua'},
    {name:'Greater Accra',capital:'Accra'},{name:'North East',capital:'Nalerigu'},
    {name:'Northern',capital:'Tamale'},{name:'Oti',capital:'Dambai'},
    {name:'Savannah',capital:'Damongo'},{name:'Upper East',capital:'Bolgatanga'},
    {name:'Upper West',capital:'Wa'},{name:'Volta',capital:'Ho'},
    {name:'Western',capital:'Sekondi-Takoradi'},{name:'Western North',capital:'Sefwi Wiawso'},
];

let regionDropdownOpen = false;

function buildRegionList() {
    const list = document.getElementById('regionList');
    list.innerHTML = GHANA_REGIONS.map(r => `<div class="region-item" onclick="selectRegion('${r.name}','${r.capital}')"><div><div class="ri-name">${r.name}</div><div class="ri-cap">Capital: ${r.capital}</div></div></div>`).join('');
}

function toggleRegionDropdown() {
    const dropdown = document.getElementById('regionDropdown');
    const trigger = document.getElementById('regionTrigger');
    regionDropdownOpen = !regionDropdownOpen;
    dropdown.classList.toggle('open', regionDropdownOpen);
    trigger.classList.toggle('open', regionDropdownOpen);
    if (regionDropdownOpen) { buildRegionList(); setTimeout(() => document.getElementById('regionCustomInput').focus(), 80); }
}

function selectRegion(name, capital) {
    document.getElementById('region').value = name;
    document.getElementById('selectedRegionName').textContent = name + ' (' + capital + ')';
    document.getElementById('regionCustomInput').value = '';
    document.querySelectorAll('.region-item').forEach(el => el.classList.remove('selected'));
    event.currentTarget.classList.add('selected');
    document.getElementById('regionDropdown').classList.remove('open');
    document.getElementById('regionTrigger').classList.remove('open');
    regionDropdownOpen = false;
}

function onRegionCustomInput(val) {
    document.getElementById('region').value = val;
    document.getElementById('selectedRegionName').textContent = val || 'Select or type region';
    document.querySelectorAll('.region-item').forEach(el => el.classList.remove('selected'));
}

document.addEventListener('click', function(e) {
    const picker = document.getElementById('regionPicker');
    if (picker && !picker.contains(e.target)) {
        document.getElementById('regionDropdown')?.classList.remove('open');
        document.getElementById('regionTrigger')?.classList.remove('open');
        regionDropdownOpen = false;
    }
});

function showError(msg) {
    const el = document.getElementById('errorAlert');
    document.getElementById('errorMsg').textContent = msg;
    el.classList.remove('hidden');
    el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}
function hideError() { document.getElementById('errorAlert').classList.add('hidden'); }

function getFormData(extraAmount, extraType) {
    return {
        amount: extraAmount,
        membership_type: extraType,
        email: document.getElementById('donorEmail').value.trim(),
        firstname: document.getElementById('firstname').value.trim(),
        lastname: document.getElementById('lastname').value.trim(),
        phone: document.getElementById('phone').value.trim() || '',
        country: document.getElementById('country').value.trim() || '',
        city: document.getElementById('city').value.trim() || '',
        region: document.getElementById('region').value.trim() || '',
        email_updates: true,
        text_updates: false,
    };
}

async function callPaystack(payload) {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!token) throw new Error('Security token not found. Please refresh the page.');
    const response = await fetch(INITIATE_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
        body: JSON.stringify(payload)
    });
    const ct = response.headers.get('content-type');
    if (!response.ok) {
        if (ct && ct.includes('application/json')) { const d = await response.json(); throw new Error(d.message || `Server error: ${response.status}`); }
        throw new Error(`Server error (${response.status}). Please try again.`);
    }
    if (!ct || !ct.includes('application/json')) throw new Error('Invalid response from server. Please try again.');
    return await response.json();
}

function validate() {
    if (!selectedMembership) { showError('Please select a membership plan.'); return false; }
    const fn = document.getElementById('firstname').value.trim();
    const ln = document.getElementById('lastname').value.trim();
    const em = document.getElementById('donorEmail').value.trim();
    if (!fn || !ln) { showError('Please enter your first and last name.'); return false; }
    if (!em || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(em)) { showError('Please enter a valid email address.'); return false; }
    return true;
}

async function processMembership() {
    hideError();
    if (!validate()) return;
    const btn = document.getElementById('joinBtn');
    const btnText = document.getElementById('joinBtnText');
    const orig = btnText.textContent;
    btn.disabled = true; btnText.textContent = 'Processing...';
    try {
        const data = await callPaystack(getFormData(selectedAmount, selectedMembership));
        if (data.status === true && data.data?.authorization_url) { window.location.href = data.data.authorization_url; }
        else throw new Error(data.message || 'Failed to process membership');
    } catch (e) {
        btn.disabled = false; btnText.textContent = orig;
        showError(e.message || 'Failed to process membership. Please try again.');
    }
}

// Initialize join button text
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('joinBtnText').textContent = 'Register — Annual Plan';
});
</script>
@endsection