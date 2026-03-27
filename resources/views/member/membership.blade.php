@extends('layouts.guest')

@section('content')
<style>
    body {
        font-family: 'Open Sans', sans-serif;
        font-size: 16px;
        line-height: 1.6;
        color: #1a1f36;
    }
    
    h1, h2, h3, h4, h5, h6, .heading-font, .font-urbanist, .btn, button, [class*="font-bold"] {
        font-family: 'Urbanist', sans-serif;
    }
    
    .breadcrumb-link {
        font-family: 'Open Sans', sans-serif;
        font-size: 0.95rem;
    }
    
    .card-title {
        font-family: 'Urbanist', sans-serif;
        font-size: 1.5rem;
        font-weight: 700;
    }
    
    .price-tag {
        font-family: 'Urbanist', sans-serif;
        font-size: 3rem;
        font-weight: 800;
        color: #4f46e5;
    }
    
    .price-period {
        font-size: 0.95rem;
        color: #64748b;
    }
    
    .benefit-text {
        font-size: 0.95rem;
        font-family: 'Open Sans', sans-serif;
    }
    
    .badge-value {
        font-family: 'Urbanist', sans-serif;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.05em;
    }
    
    /* Membership Card Hover Effects */
    .membership-card {
        transition: all 0.3s ease;
        position: relative;
    }
    
    .membership-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 28px -10px rgba(79, 70, 229, 0.2);
    }
    
    /* Best Value Badge */
    .best-value-badge {
        position: absolute;
        top: 12px;
        right: -30px;
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        padding: 6px 40px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        transform: rotate(45deg);
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        z-index: 10;
        font-family: 'Urbanist', sans-serif;
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
        font-size: 0.95rem;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        font-family: 'Open Sans', sans-serif;
    }
    
    .feature-list li:last-child {
        border-bottom: none;
    }
    
    .feature-list li i {
        color: #10b981;
        font-size: 0.9rem;
        width: 18px;
        text-align: center;
    }
    
    .savings-badge {
        background: #fef3c7;
        color: #d97706;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-block;
        margin-top: 8px;
        font-family: 'Urbanist', sans-serif;
    }
    
    @media (max-width: 768px) {
        .price-tag {
            font-size: 2.5rem;
        }
        
        .card-title {
            font-size: 1.25rem;
        }
        
        .feature-list li {
            font-size: 0.85rem;
            padding: 0.4rem 0;
        }
    }
    
    @media (max-width: 640px) {
        .price-tag {
            font-size: 2rem;
        }
        
        .best-value-badge {
            font-size: 0.6rem;
            padding: 4px 35px;
        }
    }
</style>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <div class="mb-8">
            <div class="flex items-center text-sm text-gray-500 mb-2 breadcrumb-link">
                <a href="{{ route('donor.dashboard') }}" class="hover:text-indigo-600 transition-colors">Dashboard</a>
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700 font-medium">Become a Member</span>
            </div>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 heading-font">Upgrade to Member</h1>
            <p class="text-gray-600 mt-2 font-['Open_Sans']">You're already a valued donor. Now take the next step and become an APN Member!</p>
        </div>

        <!-- Pre-filled donor info notice -->
        <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4 mb-8">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-800 font-medium">
                        We'll use your existing information: <strong>{{ $donor->firstname }} {{ $donor->lastname }}</strong> 
                        <span class="text-blue-600">({{ $donor->email }})</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Membership Cards -->
        <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto">
            
            <!-- Monthly Card -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200 membership-card">
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-900 card-title mb-2">Monthly</h3>
                    <div class="flex items-baseline gap-1 mb-4">
                        <span class="price-tag">$10</span>
                        <span class="price-period">/month</span>
                    </div>
                    <p class="text-gray-600 text-sm mb-6">Perfect for getting started with full member benefits.</p>
                    
                    <ul class="feature-list">
                        <li>
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span>Full APN membership access</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span>10% discount on all APN events</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span>Priority registration for events</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span>Exclusive member directory access</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span>APN Magazine digital access</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span>Borderless campaign enrollment</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span>Monthly newsletters</span>
                        </li>
                    </ul>
                    
                    <form method="POST" action="{{ route('donation.initialize') }}" id="monthlyForm">
                        @csrf
                        <input type="hidden" name="amount" value="10">
                        <input type="hidden" name="membership_type" value="monthly">
                        <input type="hidden" name="email" value="{{ $donor->email }}">
                        <input type="hidden" name="firstname" value="{{ $donor->firstname }}">
                        <input type="hidden" name="lastname" value="{{ $donor->lastname }}">
                        <input type="hidden" name="phone" value="{{ $donor->phone }}">
                        <input type="hidden" name="country" value="{{ $donor->country }}">
                        <input type="hidden" name="city" value="{{ $donor->city }}">
                        <input type="hidden" name="region" value="{{ $donor->region }}">
                        <input type="hidden" name="email_updates" value="1">
                        <input type="hidden" name="text_updates" value="{{ $donor->text_updates ? '1' : '0' }}">
                        <button type="submit" 
                                class="w-full py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center gap-2">
                            <i class="fas fa-arrow-right"></i>
                            <span>Upgrade to Monthly Member</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Annual Card (Recommended) -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-2 border-indigo-500 membership-card relative">
                <div class="best-value-badge">
                    BEST VALUE
                </div>
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-900 card-title mb-2">Annual</h3>
                    <div class="flex items-baseline gap-1 mb-4">
                        <span class="price-tag">$100</span>
                        <span class="price-period">/year</span>
                    </div>
                    <p class="text-gray-600 text-sm mb-6">Save 17% with annual commitment (2 months free!)</p>
                    
                    <ul class="feature-list">
                        <li>
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span><strong class="font-semibold">Everything in Monthly, plus:</strong></span>
                        </li>
                        <li class="ml-6">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span>Priority event registration</span>
                        </li>
                        <li class="ml-6">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span>Exclusive member directory listing</span>
                        </li>
                        <li class="ml-6">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span>Awards & recognition eligibility</span>
                        </li>
                        <li class="ml-6">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span>APD conference discounts</span>
                        </li>
                        <li class="ml-6">
                            <i class="fas fa-clock text-yellow-500"></i>
                            <span class="font-semibold">2 months free ($20 value)</span>
                        </li>
                    </ul>
                    
                    <div class="savings-badge text-center">
                        Save $20 compared to monthly!
                    </div>
                    
                    <form method="POST" action="{{ route('donation.initialize') }}" id="annualForm" class="mt-6">
                        @csrf
                        <input type="hidden" name="amount" value="100">
                        <input type="hidden" name="membership_type" value="annual">
                        <input type="hidden" name="email" value="{{ $donor->email }}">
                        <input type="hidden" name="firstname" value="{{ $donor->firstname }}">
                        <input type="hidden" name="lastname" value="{{ $donor->lastname }}">
                        <input type="hidden" name="phone" value="{{ $donor->phone }}">
                        <input type="hidden" name="country" value="{{ $donor->country }}">
                        <input type="hidden" name="city" value="{{ $donor->city }}">
                        <input type="hidden" name="region" value="{{ $donor->region }}">
                        <input type="hidden" name="email_updates" value="1">
                        <input type="hidden" name="text_updates" value="{{ $donor->text_updates ? '1' : '0' }}">
                        <button type="submit" 
                                class="w-full py-3 bg-gradient-to-r from-amber-500 to-orange-600 text-white rounded-xl font-semibold hover:from-amber-600 hover:to-orange-700 transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center gap-2">
                            <i class="fas fa-gem"></i>
                            <span>Upgrade to Annual Member</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- What changes after upgrading -->
        <div class="mt-12 bg-gradient-to-r from-indigo-50 via-purple-50 to-indigo-50 rounded-2xl p-8 md:p-10">
            <h3 class="text-2xl font-bold text-gray-900 heading-font mb-8 text-center">Your Journey as a Member</h3>
            <div class="grid md:grid-cols-4 gap-6">
                <div class="flex flex-col items-center text-center group">
                    <div class="bg-white rounded-2xl p-4 mb-4 shadow-md group-hover:shadow-lg transition-all group-hover:-translate-y-1">
                        <i class="fas fa-chart-line text-3xl text-indigo-600"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 heading-font mb-2">Member Dashboard</h4>
                    <p class="text-sm text-gray-600">Exclusive member-only area with benefits</p>
                </div>
                <div class="flex flex-col items-center text-center group">
                    <div class="bg-white rounded-2xl p-4 mb-4 shadow-md group-hover:shadow-lg transition-all group-hover:-translate-y-1">
                        <i class="fas fa-ticket-alt text-3xl text-indigo-600"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 heading-font mb-2">Event Discounts</h4>
                    <p class="text-sm text-gray-600">10% off all APN events</p>
                </div>
                <div class="flex flex-col items-center text-center group">
                    <div class="bg-white rounded-2xl p-4 mb-4 shadow-md group-hover:shadow-lg transition-all group-hover:-translate-y-1">
                        <i class="fas fa-users text-3xl text-indigo-600"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 heading-font mb-2">Member Directory</h4>
                    <p class="text-sm text-gray-600">Network with other members</p>
                </div>
                <div class="flex flex-col items-center text-center group">
                    <div class="bg-white rounded-2xl p-4 mb-4 shadow-md group-hover:shadow-lg transition-all group-hover:-translate-y-1">
                        <i class="fas fa-book-open text-3xl text-indigo-600"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 heading-font mb-2">Digital Magazine</h4>
                    <p class="text-sm text-gray-600">APN Magazine access</p>
                </div>
            </div>
        </div>
        
        <!-- Additional Benefits Section -->
        <div class="mt-8 text-center">
            <p class="text-gray-500 text-sm">
                <i class="fas fa-lock text-gray-400 mr-1"></i> Secure payment via Paystack
            </p>
        </div>
    </div>
</div>

<style>
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin {
        animation: spin 1s linear infinite;
    }
</style>

<script>
    // Monthly Form Submission
    document.getElementById('monthlyForm')?.addEventListener('submit', async function(e) {
        e.preventDefault(); 
        
        const form = this;
        const btn = form.querySelector('button[type="submit"]');
        const originalContent = btn.innerHTML;
        
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
        
        try {
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());
            
            const response = await fetch('{{ route("donation.initialize") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            });
            
            const result = await response.json();
            
            if (result.status === true && result.data?.authorization_url) {
                window.location.href = result.data.authorization_url;
            } else {
                throw new Error(result.message || 'Payment initialization failed');
            }
        } catch (error) {
            btn.disabled = false;
            btn.innerHTML = originalContent;
            alert('Error: ' + error.message);
        }
    });

    // Annual Form Submission
    document.getElementById('annualForm')?.addEventListener('submit', async function(e) {
        e.preventDefault(); 
        
        const form = this;
        const btn = form.querySelector('button[type="submit"]');
        const originalContent = btn.innerHTML;
        
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
        
        try {
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());
            
            const response = await fetch('{{ route("donation.initialize") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            });
            
            const result = await response.json();
            
            if (result.status === true && result.data?.authorization_url) {
                window.location.href = result.data.authorization_url;
            } else {
                throw new Error(result.message || 'Payment initialization failed');
            }
        } catch (error) {
            btn.disabled = false;
            btn.innerHTML = originalContent;
            alert('Error: ' + error.message);
        }
    });

    window.addEventListener('load', function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('error')) {
            alert('Payment failed: ' + urlParams.get('error'));
        }
    });
</script>
@endsection