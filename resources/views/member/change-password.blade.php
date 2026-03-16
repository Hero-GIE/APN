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
    
    .breadcrumb-link {
        font-family: 'Open Sans', sans-serif;
        font-size: 0.95rem;
    }
    
    .security-tip-title {
        font-family: 'Urbanist', sans-serif;
        font-size: 0.95rem;
        font-weight: 600;
    }
    
    .security-tip-text {
        font-size: 0.95rem;
    }
    
    .form-label {
        font-size: 0.95rem;
        font-weight: 600;
        font-family: 'Urbanist', sans-serif;
    }
    
    .form-input {
        font-size: 0.95rem;
        font-family: 'Open Sans', sans-serif;
    }
    
    .match-message {
        font-size: 0.95rem;
    }
    
    .activity-text {
        font-size: 0.95rem;
    }
    
    .activity-time {
        font-size: 0.95rem;
        font-weight: 600;
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
    }
</style>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <div class="flex items-center text-sm text-gray-500 mb-2 breadcrumb-link">
                <a href="{{ route('member.dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <a href="{{ route('member.profile.show') }}" class="hover:text-indigo-600">Profile</a>
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700">Change Password</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Change Password</h1>
            <p class="text-gray-600 mt-2">Update your password to keep your account secure.</p>
        </div>


        <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-6 shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <div class="bg-amber-100 rounded-full p-2">
                        <svg class="h-5 w-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-amber-800 security-tip-title">Password Security Tips</h3>
                    <div class="mt-2 text-sm text-amber-700 security-tip-text">
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
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-800">Change Your Password</h2>
                <p class="text-gray-500 text-sm mt-1">Fill in the form below to update your password</p>
            </div>

            <form method="POST" action="{{ route('member.password.update') }}" class="p-6" id="passwordForm">
                @csrf
                @method('PUT')

                <!-- Success Message -->
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg relative">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg relative">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(config('app.debug'))
                    <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg" id="passwordDebug">
                        <h4 class="font-medium text-blue-800 mb-2">🔍 Password Match Debug</h4>
                        <div id="debugContent" class="text-sm"></div>
                    </div>
                @endif

                <!-- Current Password -->
                <div class="mb-6">
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2 form-label">
                        Current Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative" x-data="{ show: false }">
                        <input :type="show ? 'text' : 'password'" 
                               name="current_password" 
                               id="current_password" 
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pr-10 @error('current_password') border-red-500 @enderror form-input"
                               placeholder="Enter your current password"
                               required>
                        <button type="button" 
                                @click="show = !show" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
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
                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2 form-label">
                        New Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative" x-data="{ showNew: false }">
                        <input :type="showNew ? 'text' : 'password'" 
                               name="new_password" 
                               id="new_password" 
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pr-10 @error('new_password') border-red-500 @enderror password-field form-input"
                               placeholder="Enter new password"
                                      autocomplete="new-password"
                               required>
                        <button type="button" 
                                @click="showNew = !showNew" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                            <svg x-show="!showNew" class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg x-show="showNew" class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                            </svg>
                        </button>
                    </div>
                    @error('new_password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm New Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2 form-label">
                        Confirm New Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative" x-data="{ showConfirm: false }">
                        <input :type="showConfirm ? 'text' : 'password'" 
                               name="new_password_confirmation"
                               id="new_password_confirmation"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pr-10 password-field form-input"
                               placeholder="Confirm new password"
                                      autocomplete="new-password"
                               required>
                        <button type="button" 
                                @click="showConfirm = !showConfirm" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                            <svg x-show="!showConfirm" class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg x-show="showConfirm" class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Password Match Indicator -->
                <div class="mb-6" id="passwordMatchIndicator">
                    <div class="flex items-center text-sm">
                        <div id="matchMessage" class="flex items-center match-message">
                            <span class="text-gray-600">Password must be at least 8 characters</span>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('member.profile.show') }}" 
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
        <div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Account Activity</h3>
            <div class="space-y-3">
                <div class="flex items-center text-sm text-gray-600 bg-gray-50 p-3 rounded-lg activity-text">
                    <div class="bg-blue-100 rounded-full p-1 mr-3">
                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <span>Last password change: <span class="font-medium text-gray-900 activity-time">{{ Auth::guard('donor')->user()->updated_at->format('F j, Y \a\t g:i A') }}</span></span>
                </div>
                <div class="flex items-center text-sm text-gray-600 bg-gray-50 p-3 rounded-lg activity-text">
                    <div class="bg-green-100 rounded-full p-1 mr-3">
                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <span>Last login: <span class="font-medium text-gray-900 activity-time">{{ now()->format('F j, Y \a\t g:i A') }}</span></span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const newPassword = document.getElementById('new_password');
        const confirmPassword = document.getElementById('new_password_confirmation');
        const matchMessage = document.getElementById('matchMessage');
        const submitButton = document.getElementById('submitButton');
        const cancelButton = document.getElementById('cancelButton');
        const buttonText = document.getElementById('buttonText');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const debugDiv = document.getElementById('passwordDebug');
        const debugContent = document.getElementById('debugContent');
        const form = document.getElementById('passwordForm');
        
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
            
            // Update UI
            updatePasswordFieldsStyle(newVal, confirmVal, isValidLength, doMatch);
            updateMatchMessage(isValidLength, doMatch, newVal, confirmVal);
            updateSubmitButton(isValid);
            
            if (debugDiv && debugContent) {
                updateDebugInfo(newVal, confirmVal, isValidLength, doMatch);
            }
            
            console.log('Password Check:', {
                newLength: newVal.length,
                confirmLength: confirmVal.length,
                isValidLength: isValidLength,
                doMatch: doMatch,
                isValid: isValid
            });
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
                matchMessage.innerHTML = '<span class="text-gray-600">Password must be at least 8 characters</span>';
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
                
                // Prevent double submission
                if (submitButton.disabled) {
                    e.preventDefault();
                    return;
                }
                
                if (newVal !== confirmVal) {
                    e.preventDefault();
                    alert('Passwords do not match! Please check both password fields.');
                    return;
                }
                
                if (newVal.length < 8) {
                    e.preventDefault();
                    alert('Password must be at least 8 characters long.');
                    return;
                }
                
                // Show loading state
                submitButton.disabled = true;
                submitButton.classList.add('opacity-50', 'cursor-not-allowed');
                buttonText.textContent = 'Updating...';
                loadingSpinner.classList.remove('hidden');
                
                // Disable cancel button
                if (cancelButton) {
                    cancelButton.style.pointerEvents = 'none';
                    cancelButton.classList.add('opacity-50');
                }
                
                console.log('Form submitting with valid passwords');
            });
        }
    });
</script>

<style>
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
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin {
        animation: spin 1s linear infinite;
    }
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush
@endsection