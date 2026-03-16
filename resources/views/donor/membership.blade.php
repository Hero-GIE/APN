@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <div class="flex items-center text-sm text-gray-500 mb-2">
                <a href="{{ route('donor.dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700">Become a Member</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Upgrade to Member</h1>
            <p class="text-gray-600 mt-2">You're already a valued donor. Now take the next step and become an APN Member!</p>
        </div>

        <!-- Pre-filled donor info notice -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-8">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        We'll use your existing information: <strong>{{ $donor->firstname }} {{ $donor->lastname }} ({{ $donor->email }})</strong>
                    </p>
                </div>
            </div>
        </div>

        <!-- Membership Cards -->
        <div class="grid md:grid-cols-2 gap-6 max-w-4xl mx-auto">
            <!-- Monthly Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-gray-200 hover:border-indigo-500 transition-all duration-300">
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Monthly</h3>
                    <div class="flex items-baseline gap-1 mb-4">
                        <span class="text-4xl font-bold text-indigo-600">$35</span>
                        <span class="text-gray-500">/month</span>
                    </div>
                    <p class="text-gray-600 mb-6">Perfect for getting started with full member benefits.</p>
                    
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Full APN membership access</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>10% discount on all APN events</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Priority registration for events</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Exclusive member directory access</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>APN Magazine digital access</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Borderless campaign enrollment</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Monthly newsletters</span>
                        </li>
                    </ul>
                    
                    <form method="POST" action="{{ route('donation.initialize') }}" id="monthlyForm">
                        @csrf
                        <input type="hidden" name="amount" value="35">
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
                                class="w-full py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center gap-2">
                            <span>Upgrade to Monthly Member</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Annual Card (Recommended) -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-indigo-500 relative transform scale-105">
                <div class="absolute top-4 right-4 bg-yellow-400 text-yellow-900 px-3 py-1 rounded-full text-xs font-bold">
                    BEST VALUE
                </div>
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Annual</h3>
                    <div class="flex items-baseline gap-1 mb-4">
                        <span class="text-4xl font-bold text-indigo-600">$350</span>
                        <span class="text-gray-500">/year</span>
                    </div>
                    <p class="text-gray-600 mb-6">Save 17% with annual commitment (2 months free!)</p>
                    
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span><strong>Everything in Monthly, plus:</strong></span>
                        </li>
                        <li class="flex items-start gap-2 ml-4">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Priority event registration</span>
                        </li>
                        <li class="flex items-start gap-2 ml-4">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Exclusive member directory listing</span>
                        </li>
                        <li class="flex items-start gap-2 ml-4">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Awards & recognition eligibility</span>
                        </li>
                        <li class="flex items-start gap-2 ml-4">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>APD conference discounts</span>
                        </li>
                        <li class="flex items-start gap-2 ml-4">
                            <svg class="w-5 h-5 text-yellow-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-semibold">2 months free ($70 value)</span>
                        </li>
                    </ul>
                    
                    <form method="POST" action="{{ route('donation.initialize') }}" id="annualForm">
                        @csrf
                        <input type="hidden" name="amount" value="350">
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
                                class="w-full py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-lg font-semibold hover:from-yellow-600 hover:to-yellow-700 transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center gap-2">
                            <span>Upgrade to Annual Member</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- What changes after upgrading -->
        <div class="mt-12 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">Your Journey as a Member</h3>
            <div class="grid md:grid-cols-4 gap-6">
                <div class="flex flex-col items-center text-center">
                    <div class="bg-indigo-100 rounded-full p-3 mb-3">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900">Member Dashboard</h4>
                    <p class="text-sm text-gray-600">Exclusive member-only area with benefits</p>
                </div>
                <div class="flex flex-col items-center text-center">
                    <div class="bg-indigo-100 rounded-full p-3 mb-3">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900">Event Discounts</h4>
                    <p class="text-sm text-gray-600">10% off all APN events</p>
                </div>
                <div class="flex flex-col items-center text-center">
                    <div class="bg-indigo-100 rounded-full p-3 mb-3">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900">Member Directory</h4>
                    <p class="text-sm text-gray-600">Network with other members</p>
                </div>
                <div class="flex flex-col items-center text-center">
                    <div class="bg-indigo-100 rounded-full p-3 mb-3">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900">Digital Magazine</h4>
                    <p class="text-sm text-gray-600">APN Magazine access</p>
                </div>
            </div>
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
    // Handle form submissions to redirect to Paystack
    document.getElementById('monthlyForm')?.addEventListener('submit', async function(e) {
        e.preventDefault(); // Prevent default form submission
        
        const form = this;
        const btn = form.querySelector('button[type="submit"]');
        const originalContent = btn.innerHTML;
        
        // Show loading state
        btn.disabled = true;
        btn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2 inline" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Processing...';
        
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

    document.getElementById('annualForm')?.addEventListener('submit', async function(e) {
        e.preventDefault(); 
        
        const form = this;
        const btn = form.querySelector('button[type="submit"]');
        const originalContent = btn.innerHTML;
        
        btn.disabled = true;
        btn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2 inline" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Processing...';
        
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