@extends('layouts.guest')

@section('content')
<style>
    body {
        font-family: 'Open Sans', sans-serif;
        font-size: 16px;
        line-height: 1.6;
        background-color: #f9fafb;
    }
    h1, h2, h3, h4, h5, h6, .font-urbanist, button, .btn {
        font-family: 'Urbanist', sans-serif;
    }
    
    /* Breadcrumb styles matching other pages */
    .breadcrumb-link {
        font-family: 'Open Sans', sans-serif;
        font-size: 0.95rem;
    }
    
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    .border-green-500 {
        border-color: #10b981 !important;
    }
    .bg-green-50 {
        background-color: #f0fdf4 !important;
    }
    .border-red-500 {
        border-color: #ef4444 !important;
    }
    .bg-red-50 {
        background-color: #fef2f2 !important;
    }
    button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    /* Smooth transitions */
    input, button, a {
        transition: all 0.2s ease-in-out;
    }
    /* Focus styles */
    input:focus {
        outline: none;
        ring: 2px solid #4f46e5;
    }
</style>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header with breadcrumb - Updated to match other pages -->
        <div class="mb-8">
            <div class="flex items-center text-sm text-gray-500 mb-2 breadcrumb-link">
                @php
                    $donor = Auth::guard('donor')->user();
                @endphp
                @if($donor && \App\Models\Member::where('donor_id', $donor->id)->exists())
                    <a href="{{ route('member.dashboard') }}" class="hover:text-indigo-600 transition-colors">Dashboard</a>
                @else
                    <a href="{{ route('donor.dashboard') }}" class="hover:text-indigo-600 transition-colors">Dashboard</a>
                @endif
                <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <a href="{{ route('donor.profile.show') }}" class="hover:text-indigo-600 transition-colors">My Profile</a>
                <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700 font-medium">Change Password</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 font-urbanist">Change Password</h1>
            <p class="text-gray-600 mt-2">Update your password to keep your account secure.</p>
        </div>

        <!-- Security Tips Card -->
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6 shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <div class="bg-amber-100 rounded-full p-2">
                        <svg class="h-5 w-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-amber-800">Password Security Tips</h3>
                    <div class="mt-2 text-sm text-amber-700">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Use at least 8 characters</li>
                            <li>Include uppercase and lowercase letters</li>
                            <li>Add numbers and special characters</li>
                            <li>Avoid common words or personal information</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Change Password Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-800 font-urbanist">Change Your Password</h2>
                <p class="text-gray-500 text-sm mt-1">Fill in the form below to update your password</p>
            </div>

            <form method="POST" action="{{ route('donor.password.update') }}" id="passwordForm" class="p-6">
                @csrf
                @method('PUT')

                <!-- Success Message -->
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg relative flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Error Message -->
                @if(session('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg relative flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Validation Errors -->
                @if($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                        <ul class="list-disc list-inside text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Current Password -->
                <div class="mb-6">
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                        Current Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative" x-data="{ show: false }">
                        <input :type="show ? 'text' : 'password'" 
                               name="current_password" 
                               id="current_password" 
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pr-10 @error('current_password') border-red-500 @enderror"
                               placeholder="Enter your current password"
                               autocomplete="current-password"
                               required>
                        <button type="button" 
                                @click="show = !show" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 focus:outline-none">
                            <svg x-show="!show" class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg x-show="show" class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                            </svg>
                        </button>
                    </div>
                    @error('current_password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        New Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative" x-data="{ show: false }">
                        <input :type="show ? 'text' : 'password'" 
                               name="password" 
                               id="password" 
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pr-10 @error('password') border-red-500 @enderror"
                               placeholder="Enter new password"
                               autocomplete="new-password"
                               required>
                        <button type="button" 
                                @click="show = !show" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 focus:outline-none">
                            <svg x-show="!show" class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg x-show="show" class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm New Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Confirm New Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative" x-data="{ show: false }">
                        <input :type="show ? 'text' : 'password'" 
                               name="password_confirmation" 
                               id="password_confirmation" 
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pr-10"
                               placeholder="Confirm new password"
                               autocomplete="new-password"
                               required>
                        <button type="button" 
                                @click="show = !show" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 focus:outline-none">
                            <svg x-show="!show" class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg x-show="show" class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Password Match Indicator -->
                <div class="mb-6" id="passwordMatchIndicator">
                    <div class="flex items-center text-sm">
                        <div id="matchMessage" class="flex items-center">
                            <span class="text-gray-600">Use a strong password with at least 8 characters</span>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('donor.profile.show') }}" 
                       id="cancelButton"
                       class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-colors font-medium text-sm">
                        Cancel
                    </a>
                    <button type="submit" 
                           id="submitButton"
                           class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors font-medium text-sm shadow-sm min-w-[140px]">
                        <span id="buttonText">Update Password</span>
                        <span id="loadingSpinner" class="hidden ml-2">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Recent Activity -->
        <div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 font-urbanist">Recent Account Activity</h3>
            <div class="space-y-3">
                <div class="flex items-center text-sm text-gray-600 bg-gray-50 p-3 rounded-lg">
                    <div class="bg-blue-100 rounded-full p-1 mr-3">
                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <span>Last password change: <span class="font-medium text-gray-900">{{ Auth::guard('donor')->user()->updated_at->format('F j, Y \a\t g:i A') }}</span></span>
                </div>
                <div class="flex items-center text-sm text-gray-600 bg-gray-50 p-3 rounded-lg">
                    <div class="bg-green-100 rounded-full p-1 mr-3">
                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <span>Last login: <span class="font-medium text-gray-900">{{ now()->format('F j, Y \a\t g:i A') }}</span></span>
                </div>
            </div>
        </div>

        <!-- Security Footer Note -->
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
        const newPassword = document.getElementById('password');
        const confirmPassword = document.getElementById('password_confirmation');
        const matchMessage = document.getElementById('matchMessage');
        const submitButton = document.getElementById('submitButton');
        const cancelButton = document.getElementById('cancelButton');
        const buttonText = document.getElementById('buttonText');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const form = document.getElementById('passwordForm');
        const currentPassword = document.getElementById('current_password');
        
        if (!newPassword || !confirmPassword) {
            console.error('Password fields not found!');
            return;
        }

        function checkPasswords() {
            const newVal = newPassword.value;
            const confirmVal = confirmPassword.value;
            const minLength = 8;
            
            const isValidLength = newVal.length >= minLength;
            const doMatch = newVal === confirmVal;
            const isValid = isValidLength && doMatch && newVal.length > 0;
            
            updatePasswordFieldsStyle(newVal, confirmVal, isValidLength, doMatch);
            updateMatchMessage(isValidLength, doMatch, newVal, confirmVal);
            updateSubmitButton(isValid);
        }

        function updatePasswordFieldsStyle(newVal, confirmVal, isValidLength, doMatch) {
            if (newVal.length > 0) {
                if (!isValidLength) {
                    newPassword.classList.add('border-red-500', 'bg-red-50');
                    newPassword.classList.remove('border-green-500', 'bg-green-50');
                } else {
                    newPassword.classList.remove('border-red-500', 'bg-red-50');
                    newPassword.classList.add('border-green-500', 'bg-green-50');
                }
            } else {
                newPassword.classList.remove('border-red-500', 'bg-red-50', 'border-green-500', 'bg-green-50');
            }
            
            if (confirmVal.length > 0) {
                if (!doMatch) {
                    confirmPassword.classList.add('border-red-500', 'bg-red-50');
                    confirmPassword.classList.remove('border-green-500', 'bg-green-50');
                } else {
                    confirmPassword.classList.remove('border-red-500', 'bg-red-50');
                    confirmPassword.classList.add('border-green-500', 'bg-green-50');
                }
            } else {
                confirmPassword.classList.remove('border-red-500', 'bg-red-50', 'border-green-500', 'bg-green-50');
            }
        }

        function updateMatchMessage(isValidLength, doMatch, newVal, confirmVal) {
            if (newVal.length === 0 && confirmVal.length === 0) {
                matchMessage.innerHTML = '<span class="text-gray-600">Use a strong password with at least 8 characters</span>';
                return;
            }
            
            let message = '';
            let color = 'text-gray-600';
            
            if (!isValidLength) {
                message = '❌ Password must be at least 8 characters';
                color = 'text-red-600';
            } else if (newVal.length > 0 && confirmVal.length === 0) {
                message = '⏳ Confirm your password';
                color = 'text-yellow-600';
            } else if (!doMatch) {
                message = '❌ Passwords do not match';
                color = 'text-red-600';
            } else if (doMatch && isValidLength) {
                message = '✅ Passwords match!';
                color = 'text-green-600';
            }
            
            matchMessage.innerHTML = `<span class="${color} font-medium">${message}</span>`;
        }

        function updateSubmitButton(isValid) {
            if (isValid) {
                submitButton.disabled = false;
                submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                submitButton.disabled = true;
                submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }

        newPassword.addEventListener('input', checkPasswords);
        confirmPassword.addEventListener('input', checkPasswords);
        
        checkPasswords();
        
        if (form) {
            form.addEventListener('submit', function(e) {
                const newVal = newPassword.value;
                const confirmVal = confirmPassword.value;
                
                if (submitButton.disabled) {
                    e.preventDefault();
                    return;
                }
                
                if (newVal !== confirmVal) {
                    e.preventDefault();
                    matchMessage.innerHTML = '<span class="text-red-600 font-medium">❌ Passwords do not match! Please check both fields.</span>';
                    newPassword.classList.add('border-red-500', 'bg-red-50');
                    confirmPassword.classList.add('border-red-500', 'bg-red-50');
                    matchMessage.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    return;
                }
                
                if (newVal.length < 8) {
                    e.preventDefault();
                    matchMessage.innerHTML = '<span class="text-red-600 font-medium">❌ Password must be at least 8 characters long.</span>';
                    newPassword.classList.add('border-red-500', 'bg-red-50');
                    matchMessage.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    return;
                }
                
                submitButton.disabled = true;
                submitButton.classList.add('opacity-50', 'cursor-not-allowed');
                buttonText.textContent = 'Updating...';
                loadingSpinner.classList.remove('hidden');
                
                if (cancelButton) {
                    cancelButton.style.pointerEvents = 'none';
                    cancelButton.classList.add('opacity-50');
                }
                currentPassword.disabled = true;
                newPassword.disabled = true;
                confirmPassword.disabled = true;
                
                console.log('Password change form submitting...');
            });
        }
        
        if (currentPassword) {
            currentPassword.addEventListener('focus', function() {
                this.classList.remove('border-red-500', 'bg-red-50');
            });
        }
    });
</script>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush
@endsection