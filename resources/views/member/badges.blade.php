@extends('layouts.guest')

@section('content')
<style>
    body {
        font-family: 'Open Sans', sans-serif;
        font-size: 16px;
        line-height: 1.6;
    }

    /* Badge preview with profile image */
    .badge-preview-container {
        position: relative;
        display: inline-block;
    }

    .badge-profile-image {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 70px;
        height: 70px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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
    
    /* Copy button styles */
    .copy-btn {
        transition: all 0.2s ease;
    }
    .copy-btn.copied {
        background: #10b981 !important;
        color: white !important;
    }
    
    /* Tab styles */
    .tab-button {
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        font-size: 0.95rem;
        border-bottom: 2px solid transparent;
        transition: all 0.2s ease;
        cursor: pointer;
        background: none;
        border: none;
    }
    .tab-button.active {
        border-bottom-color: #3b82f6;
        color: #3b82f6;
    }
    .tab-content {
        display: none;
    }
    .tab-content.active {
        display: block;
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
        .tab-button {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }
    }
</style>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header with breadcrumb -->
        <div class="mb-8">
            <div class="flex items-center text-sm text-gray-500 mb-2 breadcrumb-link">
                <a href="{{ route('member.dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700">Digital Membership Badge</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Your Digital Membership Badge</h1>
            <p class="text-gray-600 mt-2">Show your support for Africa Prosperity Network with your digital badge.</p>
        </div>

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

        @if($member->status !== 'active')
            <div class="mb-6 bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-yellow-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span>
                        <strong>Note:</strong> Your membership is {{ $member->status }}. 
                        The badge will show as "inactive" until your membership is active.
                        <a href="{{ route('member.renew') }}" class="underline font-medium ml-1">Renew now →</a>
                    </span>
                </div>
            </div>
        @endif

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1">
                <!-- Badge Preview -->
                <div class="bg-white rounded-lg shadow p-6 sticky top-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Badge Preview</h2>
                    <div class="bg-white rounded-xl p-8 flex justify-center mb-4">
                        <div class="text-center">
                            <!-- Badge Container -->
                            <div class="mx-auto mb-3" style="width: 150px; height: 150px;">
                                <img src="{{ route('member.badge.image', ['token' => $member->badge_token]) }}" 
                                     alt="APN Member Badge" 
                                     class="w-full h-full object-contain">
                            </div>
                            
                            <p class="font-medium text-gray-700 mt-2">{{ $donor->firstname }} {{ $donor->lastname }}</p>
                            <p class="text-xs text-gray-500">Member since {{ $member->start_date->format('M Y') }}</p>
                            @if($member->status == 'active')
                                <span class="inline-block mt-2 px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                    ● Active Member
                                </span>
                            @else
                                <span class="inline-block mt-2 px-2 py-1 bg-gray-100 text-gray-600 text-xs font-semibold rounded-full">
                                    ● {{ ucfirst($member->status) }}
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <p class="text-sm text-gray-600 mb-4">
                        This badge will automatically update to show "inactive" if your membership expires or is cancelled.
                    </p>
                    
                    <!-- Download Options -->
                    <h3 class="font-semibold text-gray-800 mb-3">Download Badge</h3>
                    <div class="flex gap-2 mb-6">
                        <a href="{{ route('member.badge.download', ['format' => 'png']) }}" 
                           class="flex-1 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 text-center transition-colors">
                            Download PNG
                        </a>
                        <a href="{{ route('member.badge.download', ['format' => 'svg']) }}" 
                           class="flex-1 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-300 text-center transition-colors">
                            Download SVG
                        </a>
                    </div>
                    
                    <!-- Verification Link -->
                    <h3 class="font-semibold text-gray-800 mb-2">Verification Link</h3>
                    <p class="text-xs text-gray-500 mb-2">Share this link to let others verify your membership:</p>
                    <div class="flex items-center gap-2 mb-4">
                        <input type="text" 
                               id="verifyUrl" 
                               value="{{ route('member.badge.verify', ['token' => $member->badge_token]) }}" 
                               class="flex-1 text-xs bg-gray-50 border border-gray-200 rounded px-2 py-1" 
                               readonly>
                        <button onclick="copyToClipboard('verifyUrl', this)" 
                                class="copy-btn px-3 py-1 bg-gray-200 text-gray-700 rounded text-xs hover:bg-gray-300">
                            Copy
                        </button>
                    </div>
                    
                    <!-- Regenerate Token -->
                    @if($member->status == 'active')
                    <div class="border-t border-gray-200 pt-4 mt-2">
                        <details class="text-sm">
                            <summary class="text-red-600 cursor-pointer font-medium">Regenerate badge token (advanced)</summary>
                            <div class="mt-3 p-3 bg-red-50 rounded-lg">
                                <p class="text-xs text-red-700 mb-2">
                                    <strong>Warning:</strong> This will invalidate all existing badge links. 
                                    You'll need to update anywhere you've placed your badge.
                                </p>
                                <form action="{{ route('member.badge.regenerate') }}" method="POST" 
                                      onsubmit="return confirm('Are you sure? All existing badge links will stop working.')">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full py-2 bg-red-600 text-white rounded-lg text-xs font-medium hover:bg-red-700">
                                        Regenerate Token
                                    </button>
                                </form>
                            </div>
                        </details>
                    </div>
                    @endif
                </div>
            </div>
            
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Embed Your Badge</h2>
                    
                    <!-- Platform Tabs -->
                    <div class="border-b border-gray-200 mb-6 overflow-x-auto">
                        <div class="flex flex-nowrap min-w-max">
                            <button onclick="showTab('html')" class="tab-button active" id="tab-html">HTML</button>
                            <button onclick="showTab('markdown')" class="tab-button" id="tab-markdown">Markdown</button>
                            <button onclick="showTab('bbcode')" class="tab-button" id="tab-bbcode">BBCode (Forums)</button>
                            <button onclick="showTab('iframe')" class="tab-button" id="tab-iframe">Iframe</button>
                        </div>
                    </div>
                    
                    <!-- Tab Contents -->
                    <div id="tab-html-content" class="tab-content active">
                        <h3 class="font-medium text-gray-800 mb-2">HTML Code</h3>
                        <p class="text-xs text-gray-500 mb-2">Use this for websites, email signatures, and anywhere HTML is supported.</p>
                        <div class="bg-gray-900 text-gray-100 p-4 rounded-lg mb-3 overflow-x-auto">
                            <code id="htmlCode" class="text-sm whitespace-pre-wrap break-all">{{ $embedCodes['html'] }}</code>
                        </div>
                        <button onclick="copyToClipboardText(document.getElementById('htmlCode').textContent, this)" 
                                class="copy-btn px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700">
                            Copy HTML
                        </button>
                    </div>
                    
                    <div id="tab-markdown-content" class="tab-content">
                        <h3 class="font-medium text-gray-800 mb-2">Markdown Code</h3>
                        <p class="text-xs text-gray-500 mb-2">Use for GitHub profiles, README files, and Markdown-supported platforms.</p>
                        <div class="bg-gray-900 text-gray-100 p-4 rounded-lg mb-3 overflow-x-auto">
                            <code id="markdownCode" class="text-sm whitespace-pre-wrap break-all">{{ $embedCodes['markdown'] }}</code>
                        </div>
                        <button onclick="copyToClipboardText(document.getElementById('markdownCode').textContent, this)" 
                                class="copy-btn px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700">
                            Copy Markdown
                        </button>
                    </div>
                    
                    <div id="tab-bbcode-content" class="tab-content">
                        <h3 class="font-medium text-gray-800 mb-2">BBCode</h3>
                        <p class="text-xs text-gray-500 mb-2">Use for forums, discussion boards, and legacy platforms.</p>
                        <div class="bg-gray-900 text-gray-100 p-4 rounded-lg mb-3 overflow-x-auto">
                            <code id="bbcodeCode" class="text-sm whitespace-pre-wrap break-all">{{ $embedCodes['bbcode'] }}</code>
                        </div>
                        <button onclick="copyToClipboardText(document.getElementById('bbcodeCode').textContent, this)" 
                                class="copy-btn px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700">
                            Copy BBCode
                        </button>
                    </div>
                    
                    <div id="tab-iframe-content" class="tab-content">
                        <h3 class="font-medium text-gray-800 mb-2">Iframe Code</h3>
                        <p class="text-xs text-gray-500 mb-2">Embed an interactive widget that shows your member status.</p>
                        <div class="bg-gray-900 text-gray-100 p-4 rounded-lg mb-3 overflow-x-auto">
                            <code id="iframeCode" class="text-sm whitespace-pre-wrap break-all">{{ $embedCodes['iframe'] }}</code>
                        </div>
                        <button onclick="copyToClipboardText(document.getElementById('iframeCode').textContent, this)" 
                                class="copy-btn px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700">
                            Copy Iframe
                        </button>
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-medium text-gray-700 mb-3">Iframe Preview</h4>
                            <div class="flex justify-center">
                                {!! $embedCodes['iframe'] !!}
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-8 border-t border-gray-200 pt-6">
                        <h3 class="font-semibold text-gray-800 mb-3">Where to display your badge</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                                <div class="bg-blue-100 rounded-full p-2">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium">LinkedIn</p>
                                    <p class="text-xs text-gray-500">Add to "Featured" section using HTML</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                                <div class="bg-purple-100 rounded-full p-2">
                                    <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M22.23 5.924c-.736.326-1.527.547-2.357.646.847-.508 1.5-1.312 1.804-2.27-.793.47-1.67.812-2.606.996-.748-.797-1.814-1.295-2.995-1.295-2.265 0-4.102 1.837-4.102 4.102 0 .322.036.635.106.935-3.41-.171-6.433-1.804-8.456-4.287-.353.607-.555 1.312-.555 2.064 0 1.423.724 2.679 1.825 3.415-.673-.022-1.305-.206-1.859-.514v.052c0 1.988 1.414 3.647 3.292 4.023-.344.094-.707.144-1.082.144-.265 0-.523-.026-.774-.074.523 1.634 2.042 2.823 3.842 2.856-1.408 1.104-3.182 1.762-5.11 1.762-.332 0-.66-.019-.982-.058 1.816 1.164 3.973 1.843 6.29 1.843 7.547 0 11.675-6.252 11.675-11.675 0-.178-.004-.355-.012-.531.802-.578 1.497-1.3 2.047-2.124z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium">X (Twitter)</p>
                                    <p class="text-xs text-gray-500">Add image to profile or tweets</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                                <div class="bg-green-100 rounded-full p-2">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.108-.775.418-1.305.762-1.604-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium">GitHub</p>
                                    <p class="text-xs text-gray-500">Add to profile README using Markdown</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                                <div class="bg-yellow-100 rounded-full p-2">
                                    <svg class="w-4 h-4 text-yellow-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451c.979 0 1.778-.773 1.778-1.729V1.729C24 .774 23.204 0 22.225 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium">Email Signature</p>
                                    <p class="text-xs text-gray-500">Add to your email signature</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                            <p class="text-sm text-blue-800 flex items-start gap-2">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>
                                    <strong>Tracking:</strong> When someone clicks your badge, we can see which website referred them. 
                                    This helps us understand how our members are promoting APN.
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Email Signature Section -->
        <div class="mt-8 bg-white rounded-lg shadow p-6" id="emailSignatureSection">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Email Signature</h2>
            <p class="text-sm text-gray-600 mb-4">
                Add your APN Member badge to your email signature to show your affiliation.
            </p>
            
            <div class="mb-4">
                <h3 class="font-medium text-gray-700 mb-2">Preview:</h3>
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <div id="emailSignaturePreview" style="font-family: Arial, sans-serif; max-width: 500px;">
                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                            <tr>
                                <td style="vertical-align: top; padding-right: 15px;">
                                    <a href="{{ $verifyUrl }}" target="_blank">
                                        <img src="{{ $badgeUrl }}" alt="APN Member" style="width: 80px; border: 0;">
                                    </a>
                                 </td>
                                <td style="vertical-align: top;">
                                    <div style="font-weight: bold; color: #1f2937;">{{ $donor->firstname }} {{ $donor->lastname }}</div>
                                    <div style="color: #6b7280; font-size: 12px;">Africa Prosperity Network Member</div>
                                    <div style="color: #4f46e5; font-size: 11px; margin-top: 5px;">
                                        <a href="{{ $verifyUrl }}" style="color: #4f46e5; text-decoration: none;">Verify membership →</a>
                                    </div>
                                 </td>
                             </tr>
                         </table>
                    </div>
                </div>
            </div>
            
            <div>
                <h3 class="font-medium text-gray-700 mb-2">Copy HTML for Email Signature:</h3>
                <div class="bg-gray-900 text-gray-100 p-4 rounded-lg mb-3 overflow-x-auto">
                    <code id="emailSignatureCode" class="text-sm whitespace-pre-wrap break-all">
                        &lt;div style="font-family: Arial, sans-serif; max-width: 500px; padding: 15px; border-top: 2px solid #4f46e5;"&gt;
                            &lt;table cellpadding="0" cellspacing="0" border="0" width="100%"&gt;
                                &lt;tr&gt;
                                    &lt;td style="vertical-align: top; padding-right: 15px;"&gt;
                                        &lt;a href="{{ $verifyUrl }}" target="_blank"&gt;
                                            &lt;img src="{{ $badgeUrl }}" alt="APN Member" style="width: 80px; border: 0;"&gt;
                                        &lt;/a&gt;
                                    &lt;/td&gt;
                                    &lt;td style="vertical-align: top;"&gt;
                                        &lt;div style="font-weight: bold; color: #1f2937;"&gt;{{ $donor->firstname }} {{ $donor->lastname }}&lt;/div&gt;
                                        &lt;div style="color: #6b7280; font-size: 12px;"&gt;Africa Prosperity Network Member&lt;/div&gt;
                                        &lt;div style="color: #4f46e5; font-size: 11px; margin-top: 5px;"&gt;
                                            &lt;a href="{{ $verifyUrl }}" style="color: #4f46e5; text-decoration: none;"&gt;Verify membership →&lt;/a&gt;
                                        &lt;/div&gt;
                                    &lt;/td&gt;
                                &lt;/tr&gt;
                            &lt;/table&gt;
                        &lt;/div&gt;
                    </code>
                </div>
                <button onclick="copyEmailSignature()" class="copy-btn px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700">
                    Copy HTML
                </button>
                <p class="text-xs text-gray-500 mt-3">
                    <strong>How to add to email signature:</strong> Gmail, Outlook, Apple Mail, or other email clients → Settings → Signature → Paste HTML
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    function showTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(el => {
            el.classList.remove('active');
        });
        
        // Remove active class from all tab buttons
        document.querySelectorAll('.tab-button').forEach(el => {
            el.classList.remove('active');
        });
        
        // Show selected tab content
        const content = document.getElementById(`tab-${tabName}-content`);
        if (content) content.classList.add('active');
        
        // Activate selected tab button
        const button = document.getElementById(`tab-${tabName}`);
        if (button) button.classList.add('active');
    }
    
    function copyToClipboard(elementId, btn) {
        const input = document.getElementById(elementId);
        if (!input) return;
        
        input.select();
        input.setSelectionRange(0, 99999);
        
        navigator.clipboard.writeText(input.value).then(() => {
            const originalText = btn.textContent;
            btn.textContent = 'Copied!';
            btn.classList.add('copied');
            
            setTimeout(() => {
                btn.textContent = originalText;
                btn.classList.remove('copied');
            }, 2000);
        }).catch(err => {
            console.error('Failed to copy:', err);
            alert('Failed to copy to clipboard');
        });
    }
    
    function copyToClipboardText(text, btn) {
        navigator.clipboard.writeText(text).then(() => {
            const originalText = btn.textContent;
            btn.textContent = 'Copied!';
            btn.classList.add('copied');
            
            setTimeout(() => {
                btn.textContent = originalText;
                btn.classList.remove('copied');
            }, 2000);
        }).catch(err => {
            console.error('Failed to copy:', err);
            alert('Failed to copy to clipboard');
        });
    }
    
    function copyEmailSignature() {
        const codeElement = document.getElementById('emailSignatureCode');
        if (!codeElement) return;
        
        // Get the raw HTML text content
        let textToCopy = codeElement.textContent || codeElement.innerText;
        
        // Clean up the text
        textToCopy = textToCopy.trim();
        
        // Find the copy button in the email signature section
        const btn = document.querySelector('#emailSignatureSection .copy-btn:last-of-type');
        
        navigator.clipboard.writeText(textToCopy).then(() => {
            if (btn) {
                const originalText = btn.textContent;
                btn.textContent = 'Copied!';
                btn.classList.add('copied');
                
                setTimeout(() => {
                    btn.textContent = originalText;
                    btn.classList.remove('copied');
                }, 2000);
            }
        }).catch(err => {
            console.error('Failed to copy:', err);
            alert('Failed to copy to clipboard. You can manually select and copy the code.');
        });
    }
    
    // Check if download links work
    document.querySelectorAll('a[href*="badge.download"]').forEach(link => {
        link.addEventListener('click', function(e) {
            const format = this.href.includes('format=png') ? 'PNG' : 'SVG';
            console.log(`Downloading ${format} badge...`);
        });
    });
</script>

<style>
    .copy-btn.copied {
        background: #10b981 !important;
        color: white !important;
    }
</style>
@endsection