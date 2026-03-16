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
    
    .card-title {
        font-family: 'Urbanist', sans-serif;
        font-size: 1.2rem;
        font-weight: 600;
    }
    
    .card-text {
        font-size: 0.95rem;
    }
    
    .section-title {
        font-family: 'Urbanist', sans-serif;
        font-size: 1.3rem;
        font-weight: 600;
    }
    
    .form-label {
        font-size: 0.95rem;
        font-family: 'Urbanist', sans-serif;
        font-weight: 600;
    }
    
    .form-input, .form-select, .form-textarea {
        font-size: 0.95rem;
        font-family: 'Open Sans', sans-serif;
    }
    
    .table-header {
        font-size: 0.8rem;
        font-family: 'Urbanist', sans-serif;
        font-weight: 600;
        letter-spacing: 0.03em;
    }
    
    .table-cell {
        font-size: 0.95rem;
    }
    
    .badge {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.25rem 0.75rem;
    }
    
    .faq-question {
        font-family: 'Urbanist', sans-serif;
        font-size: 1rem;
        font-weight: 600;
    }
    
    .faq-answer {
        font-size: 0.95rem;
    }
    
    .modal-title {
        font-family: 'Urbanist', sans-serif;
        font-size: 1.2rem;
        font-weight: 600;
    }
    
    .contact-info-label {
        font-size: 0.85rem;
        font-family: 'Urbanist', sans-serif;
        font-weight: 600;
    }
    
    .contact-info-value {
        font-size: 0.95rem;
    }
    
    .contact-info-small {
        font-size: 0.8rem;
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
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <div class="flex items-center text-sm text-gray-500 mb-2 breadcrumb-link">
                <a href="{{ route('member.dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700">Help & Support</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Help & Support</h1>
            <p class="text-gray-600 mt-2">We're here to help you with any questions or issues.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Email Support Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="card-title text-gray-800 ml-3">Email Support</h3>
                </div>
                <p class="text-gray-600 card-text mb-3">Get help via email. We respond within 24 hours.</p>
                <a href="mailto:support@africaprosperitynetwork.com" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm flex items-center">
                    support@africaprosperitynetwork.com
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="p-3 bg-green-100 rounded-full">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <h3 class="card-title text-gray-800 ml-3">Live Chat</h3>
                </div>
                <p class="text-gray-600 card-text mb-3">Chat with our support team in real-time.</p>
                <button class="text-indigo-600 hover:text-indigo-800 font-medium text-sm flex items-center">
                    Start Chat (Coming Soon)
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </button>
            </div>

            <!-- FAQ Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="p-3 bg-purple-100 rounded-full">
                        <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="card-title text-gray-800 ml-3">FAQs</h3>
                </div>
                <p class="text-gray-600 card-text mb-3">Find answers to common questions.</p>
                <a href="#faqs" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm flex items-center">
                    Browse FAQs
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </a>
            </div>
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Contact Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-lg font-semibold text-gray-800 card-title">Submit a Support Ticket</h2>
                        <p class="text-gray-500 text-sm mt-1">Fill out the form below and we'll get back to you within 24 hours.</p>
                    </div>

                    <form method="POST" action="{{ route('member.support.ticket') }}" enctype="multipart/form-data" class="p-6" id="supportTicketForm">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="md:col-span-2">
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2 form-label">
                                    Subject <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="subject" 
                                       id="subject" 
                                       value="{{ old('subject') }}"
                                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('subject') border-red-500 @enderror form-input"
                                       placeholder="Brief summary of your issue"
                                       required>
                                @error('subject')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-2 form-label">
                                    Category <span class="text-red-500">*</span>
                                </label>
                                <select name="category" 
                                        id="category" 
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('category') border-red-500 @enderror form-select"
                                        required>
                                    <option value="">Select a category</option>
                                    <option value="technical" {{ old('category') == 'technical' ? 'selected' : '' }}>Technical Issue</option>
                                    <option value="billing" {{ old('category') == 'billing' ? 'selected' : '' }}>Billing & Payments</option>
                                    <option value="account" {{ old('category') == 'account' ? 'selected' : '' }}>Account Management</option>
                                    <option value="donation" {{ old('category') == 'donation' ? 'selected' : '' }}>Donation Questions</option>
                                    <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('category')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Priority -->
                            <div>
                                <label for="priority" class="block text-sm font-medium text-gray-700 mb-2 form-label">
                                    Priority <span class="text-red-500">*</span>
                                </label>
                                <select name="priority" 
                                        id="priority" 
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('priority') border-red-500 @enderror form-select"
                                        required>
                                    <option value="">Select priority</option>
                                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low - General question</option>
                                    <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium - Need help</option>
                                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High - Urgent issue</option>
                                </select>
                                @error('priority')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Message -->
                            <div class="md:col-span-2">
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-2 form-label">
                                    Message <span class="text-red-500">*</span>
                                </label>
                                <textarea name="message" 
                                          id="message" 
                                          rows="6" 
                                          class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('message') border-red-500 @enderror form-textarea"
                                          placeholder="Please describe your issue in detail..."
                                          required>{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                            <button type="reset" 
                                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-colors font-medium text-sm">
                                Clear
                            </button>
                            <button type="submit" 
                                    class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors font-medium text-sm shadow-sm">
                                Submit Ticket
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-1 space-y-6">
                <!-- Contact Info Card -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="font-semibold text-gray-800 card-title">Contact Information</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-start">
                            <div class="bg-indigo-100 rounded-full p-2 mr-3">
                                <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Email Support</p>
                                <a href="mailto:support@africaprosperitynetwork.com" class="text-sm text-indigo-600 hover:text-indigo-800">support@africaprosperitynetwork.com</a>
                                <p class="text-xs text-gray-500 mt-1">Response time: 24 hours</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-green-100 rounded-full p-2 mr-3">
                                <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Phone Support</p>
                                <p class="text-sm text-gray-600">+233 (0) 30 123 4567</p>
                                <p class="text-xs text-gray-500 mt-1">Mon-Fri, 9am - 5pm GMT</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-purple-100 rounded-full p-2 mr-3">
                                <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Support Hours</p>
                                <p class="text-sm text-gray-600">Monday - Friday: 9am - 5pm</p>
                                <p class="text-sm text-gray-600">Saturday: 10am - 2pm</p>
                                <p class="text-sm text-gray-600">Sunday: Closed</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($tickets->count() > 0)
        <div class="mt-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 section-title">Your Recent Support Tickets</h2>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider table-header">Ticket #</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider table-header">Subject</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider table-header">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider table-header">Priority</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider table-header">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider table-header">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider table-header">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($tickets as $ticket)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-600 table-cell">
                                    {{ $ticket->ticket_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 table-cell">
                                    {{ Str::limit($ticket->subject, 30) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 table-cell">
                                    {{ ucfirst($ticket->category) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full badge
                                        @if($ticket->priority == 'low') bg-green-100 text-green-800
                                        @elseif($ticket->priority == 'medium') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full badge
                                        @if($ticket->status == 'open') bg-blue-100 text-blue-800
                                        @elseif($ticket->status == 'in_progress') bg-yellow-100 text-yellow-800
                                        @elseif($ticket->status == 'resolved') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 table-cell">
                                    {{ $ticket->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <button onclick="openTicketModal({{ $ticket->id }})" 
                                            class="text-indigo-600 hover:text-indigo-900 font-medium">
                                        View
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($tickets->hasPages())
                <div class="px-6 py-4 bg-white border-t border-gray-200">
                    {{ $tickets->links() }}
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- FAQs Section -->
        <div id="faqs" class="mt-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 section-title">Frequently Asked Questions</h2>
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="divide-y divide-gray-200">
                    <!-- FAQ 1 -->
                    <div class="p-6" x-data="{ open: false }">
                        <button @click="open = !open" class="flex justify-between items-center w-full text-left">
                            <span class="text-base font-medium text-gray-900 faq-question">How do I update my payment method?</span>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform" 
                                 :class="{ 'rotate-180': open }" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-collapse class="mt-3 text-sm text-gray-600 faq-answer">
                            You can update your payment method by going to Your Profile → Edit Profile → Payment Information. If you need assistance, please contact our support team.
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="p-6" x-data="{ open: false }">
                        <button @click="open = !open" class="flex justify-between items-center w-full text-left">
                            <span class="text-base font-medium text-gray-900 faq-question">How do I get a receipt for my donation?</span>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform" 
                                 :class="{ 'rotate-180': open }" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-collapse class="mt-3 text-sm text-gray-600 faq-answer">
                            You can download receipts from your Dashboard under "Donation History" or from the Transactions page. Click the "Receipt" button next to any donation.
                        </div>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="p-6" x-data="{ open: false }">
                        <button @click="open = !open" class="flex justify-between items-center w-full text-left">
                            <span class="text-base font-medium text-gray-900 faq-question">How do I cancel my recurring donation?</span>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform" 
                                 :class="{ 'rotate-180': open }" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-collapse class="mt-3 text-sm text-gray-600 faq-answer">
                            To cancel a recurring donation, please contact our support team with your donor information and the donation details. We'll process your request within 24 hours.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Still Need Help? Section -->
        <div class="mt-8 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg shadow-lg p-8 text-center">
            <h3 class="text-xl font-bold text-white mb-2">Still Need Help?</h3>
            <p class="text-indigo-100 mb-4">Our support team is always ready to assist you.</p>
            <div class="flex justify-center space-x-4">
                <a href="mailto:support@africaprosperitynetwork.com" class="inline-flex items-center px-6 py-3 bg-white text-indigo-600 rounded-lg font-semibold hover:bg-indigo-50 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Email Us
                </a>
                <a href="#" class="inline-flex items-center px-6 py-3 bg-indigo-700 text-white rounded-lg font-semibold hover:bg-indigo-800 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    Live Chat (Soon)
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Ticket Details Modal -->
<div id="ticketModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div id="modalOverlay" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <!-- Modal Header -->
                <div class="flex justify-between items-center border-b border-gray-200 pb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 modal-title" id="modal-title">Ticket Details</h3>
                        <p id="ticketNumber" class="text-sm text-gray-500 font-mono mt-1"></p>
                    </div>
                    <button onclick="closeTicketModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Ticket Details Content -->
                <div class="mt-4" id="ticketDetails">

                    <div id="modalLoading" class="text-center py-8">
                        <svg class="animate-spin h-8 w-8 text-indigo-600 mx-auto" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">Loading ticket details...</p>
                    </div>
                    <div id="ticketContent" class="hidden">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <span class="text-xs text-gray-500 block mb-1">Status</span>
                                <span id="statusBadge" class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full badge"></span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-500 block mb-1">Priority</span>
                                <span id="priorityBadge" class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full badge"></span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-500 block mb-1">Category</span>
                                <span id="category" class="text-sm font-medium text-gray-900"></span>
                            </div>
                        </div>

                        <!-- Subject -->
                        <div class="bg-indigo-50 rounded-lg p-4 mb-4">
                            <p class="text-xs text-indigo-500 mb-1">Subject</p>
                            <p id="ticketSubject" class="text-base font-medium text-gray-900"></p>
                        </div>

                        <!-- Message -->
                        <div class="bg-gray-50 rounded-lg p-4 mb-4">
                            <p class="text-xs text-gray-500 mb-2">Message</p>
                            <p id="ticketMessage" class="text-sm text-gray-700 whitespace-pre-wrap"></p>
                        </div>

                        <!-- Attachment -->
                        <div id="attachmentSection" class="hidden mb-4">
                            <div class="bg-gray-50 rounded-lg p-3 flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                    </svg>
                                    <div>
                                        <p id="attachmentName" class="text-sm font-medium text-gray-700"></p>
                                        <p id="attachmentSize" class="text-xs text-gray-500"></p>
                                    </div>
                                </div>
                                <a id="attachmentLink" href="#" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                    Download
                                </a>
                            </div>
                        </div>
                        <div class="border-t border-gray-200 pt-4">
                            <h4 class="text-sm font-semibold text-gray-700 mb-3">Timeline</h4>
                            <div class="space-y-3">
                                <div class="flex items-start">
                                    <div class="bg-green-100 rounded-full p-1 mr-3">
                                        <svg class="h-4 w-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-900">Ticket created</p>
                                        <p id="createdAt" class="text-xs text-gray-500"></p>
                                    </div>
                                </div>
                                <div id="resolvedAtContainer" class="flex items-start hidden">
                                    <div class="bg-blue-100 rounded-full p-1 mr-3">
                                        <svg class="h-4 w-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-900">Resolved</p>
                                        <p id="resolvedAt" class="text-xs text-gray-500"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button onclick="closeTicketModal()" 
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Hidden div to store tickets data -->
<div id="ticketsData" style="display: none;">{{ json_encode($tickets->items()) }}</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    // Store tickets data
    const tickets = @json($tickets->items());
    
    function openTicketModal(ticketId) {
        const ticket = tickets.find(t => t.id === ticketId);
        
        if (!ticket) {
            alert('Ticket not found');
            return;
        }
        document.getElementById('ticketModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        document.getElementById('modalLoading').classList.remove('hidden');
        document.getElementById('ticketContent').classList.add('hidden');
        
        setTimeout(() => {
            document.getElementById('modalLoading').classList.add('hidden');
            document.getElementById('ticketContent').classList.remove('hidden');
            
            populateTicketModal(ticket);
        }, 500);
    }

    function populateTicketModal(ticket) {
        document.getElementById('ticketNumber').textContent = ticket.ticket_number;
        const statusBadge = document.getElementById('statusBadge');
        statusBadge.textContent = ticket.status.replace('_', ' ').charAt(0).toUpperCase() + ticket.status.replace('_', ' ').slice(1);
        statusBadge.className = 'px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full badge';
        
        if (ticket.status === 'open') {
            statusBadge.classList.add('bg-blue-100', 'text-blue-800');
        } else if (ticket.status === 'in_progress') {
            statusBadge.classList.add('bg-yellow-100', 'text-yellow-800');
        } else if (ticket.status === 'resolved') {
            statusBadge.classList.add('bg-green-100', 'text-green-800');
        } else {
            statusBadge.classList.add('bg-gray-100', 'text-gray-800');
        }

        const priorityBadge = document.getElementById('priorityBadge');
        priorityBadge.textContent = ticket.priority.charAt(0).toUpperCase() + ticket.priority.slice(1);
        priorityBadge.className = 'px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full badge';
        
        if (ticket.priority === 'low') {
            priorityBadge.classList.add('bg-green-100', 'text-green-800');
        } else if (ticket.priority === 'medium') {
            priorityBadge.classList.add('bg-yellow-100', 'text-yellow-800');
        } else if (ticket.priority === 'high') {
            priorityBadge.classList.add('bg-red-100', 'text-red-800');
        }

        document.getElementById('category').textContent = ticket.category.charAt(0).toUpperCase() + ticket.category.slice(1);

        document.getElementById('ticketSubject').textContent = ticket.subject;
        document.getElementById('ticketMessage').textContent = ticket.message;

        if (ticket.attachment) {
            document.getElementById('attachmentSection').classList.remove('hidden');
            document.getElementById('attachmentName').textContent = ticket.attachment.split('/').pop();
            document.getElementById('attachmentSize').textContent = 'Click to download';
            document.getElementById('attachmentLink').href = '/storage/' + ticket.attachment;
        } else {
            document.getElementById('attachmentSection').classList.add('hidden');
        }
        const createdDate = new Date(ticket.created_at);
        document.getElementById('createdAt').textContent = createdDate.toLocaleDateString('en-US', { 
            month: 'long', 
            day: 'numeric', 
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });

        if (ticket.resolved_at) {
            document.getElementById('resolvedAtContainer').classList.remove('hidden');
            const resolvedDate = new Date(ticket.resolved_at);
            document.getElementById('resolvedAt').textContent = resolvedDate.toLocaleDateString('en-US', { 
                month: 'long', 
                day: 'numeric', 
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        } else {
            document.getElementById('resolvedAtContainer').classList.add('hidden');
        }
    }

    function closeTicketModal() {
        document.getElementById('ticketModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    document.getElementById('modalOverlay').addEventListener('click', function() {
        closeTicketModal();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeTicketModal();
        }
    });
</script>

<style>
    /* Modal animations */
    #ticketModal {
        transition: opacity 0.3s ease;
    }
    
    #ticketModal .transform {
        transition: transform 0.3s ease;
    }
    
    #ticketModal.hidden {
        display: none;
    }
    
    /* Custom scrollbar for modal */
    #ticketDetails {
        max-height: 70vh;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e0 #f1f5f9;
    }
    
    #ticketDetails::-webkit-scrollbar {
        width: 6px;
    }
    
    #ticketDetails::-webkit-scrollbar-track {
        background: #f1f5f9;
    }
    
    #ticketDetails::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 3px;
    }
    
    #ticketDetails::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>
@endpush
@endsection