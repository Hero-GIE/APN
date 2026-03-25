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
    
    /* Breadcrumb styling matching other pages */
    .breadcrumb-link {
        font-family: 'Open Sans', sans-serif;
        font-size: 0.95rem;
    }
    
    .application-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    .field-apn {
        width: 100%;
        padding: 0.8rem 1rem;
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        outline: none;
    }
    .field-apn:focus {
        border-color: #3b82f6;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
    }
    .field-apn.error {
        border-color: #ef4444;
        background: #fef2f2;
    }
    .resume-upload-area {
        border: 2px dashed #e2e8f0;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .resume-upload-area:hover {
        border-color: #3b82f6;
        background: #eff6ff;
    }
    .resume-upload-area.has-file {
        border-color: #10b981;
        background: #f0fdf4;
    }
    .resume-upload-area.has-error {
        border-color: #ef4444;
        background: #fef2f2;
    }
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(4px);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }
    .loading-overlay.active {
        display: flex;
    }
    .loading-spinner {
        width: 60px;
        height: 60px;
        border: 4px solid #e2e8f0;
        border-top-color: #4f46e5;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: 1rem;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    .file-error {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .file-error i {
        font-size: 1rem;
    }
</style>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="loading-overlay">
    <div class="loading-spinner"></div>
    <p class="text-lg font-urbanist font-semibold text-gray-900">Submitting Your Application...</p>
    <p class="text-sm text-gray-500 mt-2">Please don't close this window</p>
</div>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb - Updated to match other pages -->
        <div class="mb-8">
            <div class="flex items-center text-sm text-gray-500 mb-2 breadcrumb-link">
                @php
                    $donor = Auth::guard('donor')->user();
                @endphp
                @if($donor && \App\Models\Member::where('donor_id', $donor->id)->exists())
                    <a href="{{ route('member.dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                @else
                    <a href="{{ route('donor.dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                @endif
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <a href="{{ route('member.jobs.index') }}" class="hover:text-indigo-600">Job Opportunities</a>
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <a href="{{ route('member.jobs.show', $job->slug) }}" class="hover:text-indigo-600">{{ $job->title }}</a>
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700">Apply</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 font-urbanist">Submit Your Application</h1>
            <p class="text-gray-600 mt-2">Complete the form below to apply for {{ $job->title }}</p>
        </div>

        @if(isset($hasApplied) && $hasApplied)
            <div class="application-card p-8 text-center">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900 mb-2 font-urbanist">You've Already Applied!</h2>
                <p class="text-gray-600 mb-6">Your application for {{ $job->title }} at {{ $job->company }} has been received.</p>
                <div class="flex justify-center gap-4">
                    <a href="{{ route('member.jobs.show', $job->slug) }}" 
                       class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                        Back to Job
                    </a>
                    <a href="{{ route('member.jobs.applications') }}" 
                       class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-medium">
                        View My Applications
                    </a>
                </div>
            </div>
        @else
            <!-- Job Summary Card -->
            <div class="bg-white rounded-lg p-6 mb-6 border border-gray-200">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 font-urbanist">{{ $job->title }}</h2>
                        <p class="text-gray-600 mt-1">{{ $job->company }} • {{ $job->location }}</p>
                    </div>
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-sm font-medium">
                        {{ $job->job_type }}
                    </span>
                </div>
                <div class="flex flex-wrap gap-4 mt-4 text-sm text-gray-500">
                    <span><i class="far fa-clock mr-1"></i> {{ $job->experience_level }}</span>
                    <span><i class="far fa-money-bill-alt mr-1"></i> {{ $job->salary_range }}</span>
                    <span><i class="far fa-calendar mr-1"></i> Posted {{ $job->formatted_posted_date }}</span>
                </div>
            </div>

            <!-- Application Form -->
            <div class="application-card p-6">
                <form id="applicationForm" action="{{ route('member.jobs.apply.submit', $job->slug) }}" method="POST" enctype="multipart/form-data" onsubmit="return validateForm(event)">
                    @csrf

                    <!-- Cover Letter -->
                  <!-- Cover Letter -->
<div class="mb-6">
    <label class="block text-sm font-medium text-gray-700 mb-2">
        Cover Letter <span class="text-gray-400">(Optional)</span>
    </label>
    <textarea 
        name="cover_letter" 
        rows="6" 
        maxlength="5000"
        class="field-apn @error('cover_letter') error @enderror"
        placeholder="Tell us why you're interested in this position and what makes you a great candidate..."
        oninput="updateCharCount(this)">{{ old('cover_letter') }}</textarea>
    
    <!-- Character Counter -->
    <div class="flex justify-between items-center mt-1">
        <p class="text-xs text-gray-500">
            <i class="fas fa-info-circle mr-1"></i>
            Maximum 5000 characters
        </p>
        <p class="text-xs text-gray-500">
            <span id="charCount">0</span> / 5000 characters
        </p>
    </div>
    
    @error('cover_letter')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

                    <!-- Resume Upload with File Validation -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Resume/CV <span class="text-gray-400">(Optional)</span>
                        </label>
                        
                        <div class="resume-upload-area" id="resumeUploadArea" onclick="document.getElementById('resume').click()">
                            <input type="file" id="resume" name="resume" class="hidden" accept=".pdf,.doc,.docx" onchange="validateFile(this)">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3" id="uploadIcon"></i>
                            <p class="text-gray-600 mb-2" id="uploadText">
                                Drag & drop your resume here or <span class="text-indigo-600 font-semibold">browse</span>
                            </p>
                            <p class="text-xs text-gray-500" id="fileTypes">
                                <i class="fas fa-info-circle mr-1"></i>
                                Supports: PDF, DOC, DOCX (Max 5MB)
                            </p>
                            <div id="fileInfo" class="hidden mt-3 text-left bg-white p-3 rounded-lg"></div>
                        </div>
                        
                        <!-- File Error Message -->
                        <div id="fileErrorMessage" class="file-error hidden">
                            <i class="fas fa-exclamation-circle"></i>
                            <span id="fileErrorText"></span>
                        </div>
                        
                        @error('resume')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Additional Notes -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Additional Notes <span class="text-gray-400">(Optional)</span>
                        </label>
                        <textarea 
                            name="notes" 
                            rows="3" 
                            class="field-apn @error('notes') error @enderror"
                            placeholder="Any additional information you'd like to share...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Disclaimer -->
                    <div class="bg-blue-50 rounded-lg p-4 mb-6">
                        <p class="text-sm text-blue-800 flex items-start gap-2">
                            <i class="fas fa-info-circle mt-0.5 flex-shrink-0"></i>
                            <span>
                                By submitting this application, you agree that APN may share your information with 
                                {{ $job->company }} for recruitment purposes. Your data will be handled according to our 
                                <a href="#" class="underline hover:text-blue-900">Privacy Policy</a>.
                            </span>
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3">
                        <button type="submit" 
                                id="submitBtn"
                                class="flex-1 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-urbanist font-bold hover:from-indigo-700 hover:to-purple-700 transition-all duration-300">
                            <span id="submitText">Submit Application</span>
                            <span id="submitSpinner" class="hidden">
                                <i class="fas fa-spinner fa-spin mr-2"></i>
                                Submitting...
                            </span>
                        </button>
                        <a href="{{ route('member.jobs.show', $job->slug) }}" 
                           class="flex-1 py-3 bg-gray-100 text-gray-700 rounded-xl font-urbanist font-bold text-center hover:bg-gray-200 transition-all duration-300">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        @endif

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
function validateFile(input) {
    const file = input.files[0];
    const area = document.getElementById('resumeUploadArea');
    const icon = document.getElementById('uploadIcon');
    const uploadText = document.getElementById('uploadText');
    const fileInfo = document.getElementById('fileInfo');
    const fileTypes = document.getElementById('fileTypes');
    const errorMessage = document.getElementById('fileErrorMessage');
    const errorText = document.getElementById('fileErrorText');
    
    area.classList.remove('has-error');
    errorMessage.classList.add('hidden');
    
    if (file) {
        const maxSize = 5 * 1024 * 1024; 
        
        if (file.size > maxSize) {
            area.classList.add('has-error');
            errorText.textContent = `File is too large (${(file.size / 1024 / 1024).toFixed(2)}MB). Maximum size is 5MB.`;
            errorMessage.classList.remove('hidden');
            input.value = '';
            area.classList.remove('has-file');
            icon.className = 'fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3';
            uploadText.innerHTML = 'Drag & drop your resume here or <span class="text-indigo-600 font-semibold">browse</span>';
            fileTypes.innerHTML = '<i class="fas fa-info-circle mr-1"></i>Supports: PDF, DOC, DOCX (Max 5MB)';
            fileInfo.classList.add('hidden');
            return false;
        }
        
        const validTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        const fileExtension = file.name.split('.').pop().toLowerCase();
        const validExtensions = ['pdf', 'doc', 'docx'];
        
        if (!validTypes.includes(file.type) && !validExtensions.includes(fileExtension)) {
            area.classList.add('has-error');
            errorText.textContent = 'Invalid file type. Please upload PDF, DOC, or DOCX.';
            errorMessage.classList.remove('hidden');
            input.value = '';
            area.classList.remove('has-file');
            icon.className = 'fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3';
            uploadText.innerHTML = 'Drag & drop your resume here or <span class="text-indigo-600 font-semibold">browse</span>';
            fileTypes.innerHTML = '<i class="fas fa-info-circle mr-1"></i>Supports: PDF, DOC, DOCX (Max 5MB)';
            fileInfo.classList.add('hidden');
            return false;
        }
        
        area.classList.remove('has-error');
        area.classList.add('has-file');
        icon.className = 'fas fa-check-circle text-4xl text-green-500 mb-3';
        uploadText.innerHTML = 'File selected:';
        fileTypes.innerHTML = '';
        
        fileInfo.classList.remove('hidden');
        fileInfo.innerHTML = `
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                    <span class="font-medium">${file.name}</span>
                </div>
                <span class="text-xs text-gray-500">${(file.size / 1024).toFixed(2)} KB</span>
            </div>
        `;
        
        return true;
    }
}

function updateCharCount(textarea) {
    const count = textarea.value.length;
    const charCountSpan = document.getElementById('charCount');
    if (charCountSpan) {
        charCountSpan.textContent = count;
        
        // Add warning when approaching limit
        if (count > 4500) {
            charCountSpan.style.color = '#ef4444';
        } else if (count > 4000) {
            charCountSpan.style.color = '#f59e0b';
        } else {
            charCountSpan.style.color = '#6b7280';
        }
    }
}

// Initialize char count on page load
document.addEventListener('DOMContentLoaded', function() {
    const coverLetter = document.querySelector('textarea[name="cover_letter"]');
    if (coverLetter) {
        updateCharCount(coverLetter);
    }
});

function validateForm(event) {
    event.preventDefault();
    
    const form = document.getElementById('applicationForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const submitSpinner = document.getElementById('submitSpinner');
    const loadingOverlay = document.getElementById('loadingOverlay');
    
    const fileErrorMessage = document.getElementById('fileErrorMessage');
    if (!fileErrorMessage.classList.contains('hidden')) {
        alert('Please fix the file error before submitting.');
        return false;
    }
    
    submitBtn.disabled = true;
    submitText.classList.add('hidden');
    submitSpinner.classList.remove('hidden');
    loadingOverlay.classList.add('active');
    
    form.submit();
    
    return true;
}

const dropZone = document.getElementById('resumeUploadArea');
if (dropZone) {
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropZone.classList.add('border-indigo-500', 'bg-indigo-50');
    }

    function unhighlight(e) {
        dropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
    }

    dropZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        const input = document.getElementById('resume');
        input.files = files;
        validateFile(input);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('applicationForm');
    if (form) {
        form.addEventListener('submit', function() {
            const submitBtn = document.getElementById('submitBtn');
            if (submitBtn.disabled) {
                event.preventDefault();
                return false;
            }
        });
    }
});
</script>
@endsection