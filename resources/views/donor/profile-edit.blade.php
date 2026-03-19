@extends('layouts.guest')

@section('content')
<style>
    body {
        font-family: 'Open Sans', sans-serif;
        font-size: 16px;
        line-height: 1.6;
    }
    h1, h2, h3, h4, h5, h6, .heading-font, .font-urbanist, .btn, button, [class*="font-bold"] {
        font-family: 'Urbanist', sans-serif;
    }
    
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
    .animate-page-reveal { animation: pageReveal 0.9s cubic-bezier(0.22,1,0.36,1) both; }
    .animate-pattern { animation: patternMove 60s linear infinite; }
    .animate-gradient { animation: gradientShift 5s ease infinite; background-size: 200% 200%; }

    .apn-scrollbar::-webkit-scrollbar { width: 6px; }
    .apn-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
    .apn-scrollbar::-webkit-scrollbar-thumb { background: #3b82f6; border-radius: 3px; }

    /* Text size adjustments */
    .text-xs {
        font-size: 0.8rem !important;
    }
    .text-sm {
        font-size: 0.95rem !important;
    }
    .text-base {
        font-size: 1rem !important;
    }
    .text-lg {
        font-size: 1.125rem !important;
    }
    .text-xl {
        font-size: 1.3rem !important;
    }
    .text-2xl {
        font-size: 1.65rem !important;
    }
    .text-3xl {
        font-size: 2rem !important;
    }

    /* Form field styling - matching the field-apn from member dashboard */
    .field-apn {
        width: 100%;
        padding: 0.8rem 0.8rem 0.8rem 1rem;
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 0.95rem;
        color: #1e293b;
        transition: all 0.2s ease;
        outline: none;
        font-family: 'Open Sans', sans-serif;
    }
    .field-apn:focus {
        border-color: #3b82f6;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
    }
    .field-apn.error {
        border-color: #ef4444;
    }

    /* Checkbox styling */
    .checkbox-apn {
        width: 1.2rem;
        height: 1.2rem;
        border-radius: 6px;
        border: 2px solid #d1d5db;
        background: #fff;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .checkbox-apn:checked {
        background: #3b82f6;
        border-color: #3b82f6;
    }

    /* Card styling */
    .profile-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 20px 40px -15px rgba(0,0,0,0.15), inset 0 0 0 1px rgba(0,0,0,0.02);
        overflow: hidden;
    }

    /* Breadcrumb styling */
    .breadcrumb {
        display: flex;
        align-items: center;
        font-size: 0.95rem;
        color: #64748b;
        margin-bottom: 0.5rem;
        font-family: 'Open Sans', sans-serif;
    }
    .breadcrumb a {
        color: #3b82f6;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    .breadcrumb a:hover {
        color: #1d4ed8;
        text-decoration: underline;
    }
    .breadcrumb svg {
        width: 1rem;
        height: 1rem;
        margin: 0 0.5rem;
        fill: #94a3b8;
    }

    /* Section headers */
    .section-header {
        font-size: 1.2rem;
        font-weight: 600;
        color: #1e1b4b;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #f1f5f9;
        font-family: 'Urbanist', sans-serif;
    }

    /* Button styling */
    .btn-primary {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        border: none;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px -1px rgba(59,130,246,0.2);
        min-width: 140px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-family: 'Urbanist', sans-serif;
    }
    .btn-primary:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(59,130,246,0.3);
    }
    .btn-primary:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .btn-secondary {
        background: #f1f5f9;
        color: #475569;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        border: none;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-family: 'Urbanist', sans-serif;
    }
    .btn-secondary:hover:not(:disabled) {
        background: #e2e8f0;
        transform: translateY(-2px);
    }

    /* Alert styling */
    .alert-success {
        background: #dcfce7;
        border: 2px solid #86efac;
        color: #166534;
        padding: 1rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
    }

    .alert-error {
        background: #fee2e2;
        border: 2px solid #fca5a5;
        color: #991b1b;
        padding: 1rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
    }

    /* Responsive adjustments */
    @media (max-width: 640px) {
        body {
            font-size: 15px;
        }
        .text-xs {
            font-size: 0.75rem !important;
        }
        .text-sm {
            font-size: 0.875rem !important;
        }
        h1 {
            font-size: 1.75rem !important;
        }
        .btn-primary, .btn-secondary {
            padding: 0.6rem 1rem;
            font-size: 0.875rem;
        }
    }

    /* Footer/security note */
    .text-\[0\.7rem\] {
        font-size: 0.8rem !important;
    }

    /* Card hover effects */
    .bg-white.rounded-lg.shadow {
        transition: all 0.3s ease;
    }
    .bg-white.rounded-lg.shadow:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
    }

    [x-cloak] { display: none !important; }
    
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    
    /* Smooth transitions */
    .btn-primary, .btn-secondary, .field-apn, .checkbox-apn {
        transition: all 0.3s ease;
    }
</style>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="breadcrumb">
                <a href="{{ route('donor.dashboard') }}">Dashboard</a>
                <svg viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <a href="{{ route('donor.profile.show') }}">Profile</a>
                <svg viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700 font-medium">Edit Profile</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Profile</h1>
            <p class="text-gray-600 mt-2">Update your personal information and preferences.</p>
        </div>

        <div class="profile-card">
            <form method="POST" action="{{ route('donor.profile.update') }}" id="profileForm">
                @csrf
                @method('PUT')

                <div class="p-8 space-y-8">
                    @if(session('success'))
                        <div class="alert-success">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-check-circle"></i>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert-error">
                            <div class="flex items-start gap-2">
                                <i class="fas fa-exclamation-circle mt-1"></i>
                                <ul class="list-disc list-inside">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <!-- Personal Information -->
                    <div>
                        <h3 class="section-header">Personal Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- First Name -->
                            <div>
                                <label for="firstname" class="block text-sm font-semibold text-gray-700 mb-2">
                                    First Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="firstname" 
                                       id="firstname" 
                                       value="{{ old('firstname', $donor->firstname) }}" 
                                       class="field-apn @error('firstname') error @enderror"
                                       placeholder="Enter your first name">
                                @error('firstname')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Last Name -->
                            <div>
                                <label for="lastname" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Last Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="lastname" 
                                       id="lastname" 
                                       value="{{ old('lastname', $donor->lastname) }}" 
                                       class="field-apn @error('lastname') error @enderror"
                                       placeholder="Enter your last name">
                                @error('lastname')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="md:col-span-2">
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       value="{{ old('email', $donor->email) }}" 
                                       class="field-apn @error('email') error @enderror"
                                       placeholder="you@example.com">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="md:col-span-2">
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Phone Number
                                </label>
                                <input type="tel" 
                                       name="phone" 
                                       id="phone" 
                                       value="{{ old('phone', $donor->phone) }}" 
                                       class="field-apn @error('phone') error @enderror"
                                       placeholder="+233 XX XXX XXXX">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="border-t border-gray-200 pt-8">
                        <h3 class="section-header">Address Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Country -->
                            <div class="md:col-span-2">
                                <label for="country" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Country
                                </label>
                                <input type="text" 
                                       name="country" 
                                       id="country" 
                                       value="{{ old('country', $donor->country) }}" 
                                       class="field-apn @error('country') error @enderror"
                                       placeholder="e.g. Ghana">
                                @error('country')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Street Address -->
                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Street Address
                                </label>
                                <input type="text" 
                                       name="address" 
                                       id="address" 
                                       value="{{ old('address', $donor->address) }}" 
                                       class="field-apn @error('address') error @enderror"
                                       placeholder="Your street address">
                                @error('address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- City -->
                            <div>
                                <label for="city" class="block text-sm font-semibold text-gray-700 mb-2">
                                    City
                                </label>
                                <input type="text" 
                                       name="city" 
                                       id="city" 
                                       value="{{ old('city', $donor->city) }}" 
                                       class="field-apn @error('city') error @enderror"
                                       placeholder="e.g. Accra">
                                @error('city')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Region/State -->
                            <div>
                                <label for="region" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Region/State
                                </label>
                                <input type="text" 
                                       name="region" 
                                       id="region" 
                                       value="{{ old('region', $donor->region) }}" 
                                       class="field-apn @error('region') error @enderror"
                                       placeholder="e.g. Greater Accra">
                                @error('region')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Communication Preferences -->
                    <div class="border-t border-gray-200 pt-8">
                        <h3 class="section-header">Communication Preferences</h3>
                        
                        <div class="space-y-4 bg-gray-50 p-6 rounded-xl">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" 
                                       name="email_updates" 
                                       id="email_updates" 
                                       value="1" 
                                       {{ old('email_updates', $donor->email_updates) ? 'checked' : '' }}
                                       class="checkbox-apn">
                                <label for="email_updates" class="text-sm text-gray-700">
                                    <span class="font-medium">Email updates</span> - Receive updates about campaigns and news
                                </label>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                <input type="checkbox" 
                                       name="text_updates" 
                                       id="text_updates" 
                                       value="1" 
                                       {{ old('text_updates', $donor->text_updates) ? 'checked' : '' }}
                                       class="checkbox-apn">
                                <label for="text_updates" class="text-sm text-gray-700">
                                    <span class="font-medium">SMS updates</span> - Receive text updates (standard rates may apply)
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-8 py-6 bg-gray-50 border-t border-gray-200 flex items-center justify-end gap-4">
                    <a href="{{ route('donor.profile.show') }}" 
                       id="cancelButton"
                       class="btn-secondary">
                        <i class="fas fa-times"></i>
                        Cancel
                    </a>
                    
                    <button type="submit" 
                            id="submitButton"
                            class="btn-primary">
                        <span id="buttonText">Save Changes</span>
                        <span id="loadingSpinner" class="hidden">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </button>
                </div>
            </form>
        </div>

        <div class="flex items-center justify-center gap-3 mt-8 text-xs text-gray-400">
            <i class="fas fa-circle text-yellow-500" style="font-size:0.35rem;"></i>
            <span>256-bit encrypted</span>
            <i class="fas fa-circle text-yellow-500" style="font-size:0.35rem;"></i>
            <span>Powered by Paystack</span>
            <i class="fas fa-circle text-yellow-500" style="font-size:0.35rem;"></i>
            <span>Secure transactions</span>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('profileForm');
        const submitButton = document.getElementById('submitButton');
        const cancelButton = document.getElementById('cancelButton');
        const buttonText = document.getElementById('buttonText');
        const loadingSpinner = document.getElementById('loadingSpinner');
        
        if (form) {
            form.addEventListener('submit', function(e) {
                if (submitButton.disabled) {
                    e.preventDefault();
                    return;
                }
                
                submitButton.disabled = true;
                
                buttonText.textContent = 'Saving...';
                loadingSpinner.classList.remove('hidden');
                
                if (cancelButton) {
                    cancelButton.style.pointerEvents = 'none';
                    cancelButton.classList.add('opacity-50');
                }
                
                console.log('Profile update form submitting...');
            });
        }

        const inputs = document.querySelectorAll('.field-apn');
        inputs.forEach(input => {
            if (input.value) {
                input.classList.add('has-value');
            }
            input.addEventListener('blur', function() {
                if (this.value) {
                    this.classList.add('has-value');
                } else {
                    this.classList.remove('has-value');
                }
            });
        });
    });
</script>
@endsection