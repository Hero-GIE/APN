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
        font-size: 0.75rem !important;
    }
    .text-sm {
        font-size: 0.875rem !important;
    }
    .text-base {
        font-size: 1rem !important;
    }
    .text-lg {
        font-size: 1.125rem !important;
    }
    .text-xl {
        font-size: 1.25rem !important;
    }
    .text-2xl {
        font-size: 1.5rem !important;
    }
    .text-3xl {
        font-size: 1.875rem !important;
    }
    
    .breadcrumb-link {
        font-family: 'Open Sans', sans-serif;
        font-size: 0.875rem;
    }
    
    .stat-label {
        font-size: 0.7rem;
        letter-spacing: 0.02em;
    }
    
    .stat-value {
        font-size: 1.25rem;
        font-family: 'Urbanist', sans-serif;
        font-weight: 600;
    }
    
    .section-title {
        font-family: 'Urbanist', sans-serif;
        font-size: 1.125rem;
        font-weight: 600;
    }
    
    .table-header {
        font-size: 0.7rem;
        font-family: 'Urbanist', sans-serif;
        font-weight: 600;
        letter-spacing: 0.03em;
    }
    
    .badge {
        font-size: 0.7rem;
        font-weight: 600;
        padding: 0.2rem 0.6rem;
    }
    
    .modal-title {
        font-family: 'Urbanist', sans-serif;
        font-size: 1.1rem;
        font-weight: 600;
    }
    
    .filter-select, .search-input {
        font-size: 0.875rem;
        padding: 0.5rem;
    }
    
    .download-button {
        font-size: 0.8rem;
    }
    
    /* Mobile card view for transactions */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 0.75rem !important;
        }
        
        .filter-controls {
            flex-direction: column;
            gap: 0.75rem;
            width: 100%;
        }
        
        .filter-controls select,
        .filter-controls input {
            width: 100%;
        }
        
        .transaction-card {
            background: white;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 1px 3px 0 rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .transaction-card:hover {
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        
        .transaction-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.75rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .transaction-amount {
            font-size: 1.125rem;
            font-weight: 700;
            color: #1f2937;
        }
        
        .transaction-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }
        
        .transaction-detail-item {
            display: flex;
            flex-direction: column;
        }
        
        .transaction-detail-label {
            font-size: 0.65rem;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.02em;
            margin-bottom: 0.25rem;
        }
        
        .transaction-detail-value {
            font-size: 0.8rem;
            font-weight: 500;
            color: #1f2937;
            word-break: break-word;
        }
        
        .transaction-actions {
            display: flex;
            gap: 1rem;
            margin-top: 0.75rem;
            padding-top: 0.75rem;
            border-top: 1px solid #f3f4f6;
        }
        
        .desktop-table {
            display: none;
        }
        
        .download-section {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
        
        .download-section .flex {
            width: 100%;
            flex-direction: column;
        }
        
        .download-section select,
        .download-section button {
            width: 100%;
        }
        
        .stat-value {
            font-size: 1.125rem;
        }
        
        .stat-label {
            font-size: 0.65rem;
        }
    }
    
    @media (min-width: 769px) {
        .mobile-cards {
            display: none;
        }
        
        .desktop-table {
            display: block;
        }
    }
    
    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr !important;
        }
        
        .transaction-details {
            grid-template-columns: 1fr !important;
        }
        
        .transaction-header {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .breadcrumb-link {
            font-size: 0.75rem;
        }
        
        h1 {
            font-size: 1.5rem !important;
        }
        
        .stat-value {
            font-size: 1rem;
        }
        
        .section-title {
            font-size: 1rem;
        }
    }
    
    /* Filter select styling */
    .filter-select,
    #statusFilter,
    #statementPeriod {
        min-width: 100px;
        width: auto;
        padding: 0.5rem 2rem 0.5rem 0.75rem;
        font-size: 0.875rem;
    }
    
    .search-input,
    #searchInput {
        min-width: 200px;
        width: auto;
    }
    
    @media (max-width: 768px) {
        .filter-select,
        #statusFilter,
        #statementPeriod,
        .search-input,
        #searchInput {
            width: 100% !important;
            min-width: 100% !important;
        }
    }
    
    /* Modal responsive */
    @media (max-width: 640px) {
        .modal-container {
            margin: 1rem !important;
            width: calc(100% - 2rem) !important;
        }
        
        .modal-grid {
            grid-template-columns: 1fr !important;
            gap: 0.75rem !important;
        }
    }
</style>

<div class="min-h-screen bg-gray-50 py-4 sm:py-6 md:py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header with breadcrumb -->
        <div class="mb-6 md:mb-8">
            <div class="flex items-center text-sm text-gray-500 mb-2 breadcrumb-link flex-wrap">
                <a href="{{ route('member.dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                <svg class="w-4 h-4 mx-1 sm:mx-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700">Transactions</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Transaction History</h1>
            <p class="text-sm sm:text-base text-gray-600 mt-2">View all your donation transactions and payment history.</p>
        </div>

        <!-- Stats Summary Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 mb-6 md:mb-8 stats-grid">
            <div class="bg-white rounded-lg shadow p-3 sm:p-4">
                <div class="flex items-center">
                    <div class="p-1.5 sm:p-2 bg-indigo-100 rounded-full flex-shrink-0">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div class="ml-2 sm:ml-3">
                        <p class="stat-label text-gray-500">Total Transactions</p>
                        <p class="stat-value text-gray-900">{{ $transactions->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-3 sm:p-4">
                <div class="flex items-center">
                    <div class="p-1.5 sm:p-2 bg-green-100 rounded-full flex-shrink-0">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-2 sm:ml-3">
                        <p class="stat-label text-gray-500">Total Amount</p>
                        <p class="stat-value text-gray-900">${{ number_format($transactions->sum('amount'), 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-3 sm:p-4">
                <div class="flex items-center">
                    <div class="p-1.5 sm:p-2 bg-purple-100 rounded-full flex-shrink-0">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-2 sm:ml-3">
                        <p class="stat-label text-gray-500">Membership Payments</p>
                        <p class="stat-value text-gray-900">{{ $memberPayments->count() ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-3 sm:p-4">
                <div class="flex items-center">
                    <div class="p-1.5 sm:p-2 bg-yellow-100 rounded-full flex-shrink-0">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-2 sm:ml-3">
                        <p class="stat-label text-gray-500">Member Since</p>
                        <p class="stat-value text-gray-900">{{ $member->start_date->format('M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transactions Table/ Cards -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 filter-controls">
                    <h2 class="text-base sm:text-xl font-semibold text-gray-800 section-title">All Transactions</h2>
                    <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto filter-controls">
                        <select id="statusFilter" class="text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 filter-select px-3 py-2">
                            <option value="all">All Status</option>
                            <option value="success">Success</option>
                            <option value="pending">Pending</option>
                            <option value="failed">Failed</option>
                        </select>
                        <input type="text" id="searchInput" placeholder="Search transactions..." 
                               class="text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 search-input px-3 py-2">
                    </div>
                </div>
            </div>
            
            <!-- Desktop Table View -->
            <div class="desktop-table overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 sm:px-6 py-3 text-left table-header text-gray-500 uppercase tracking-wider">Date & Time</th>
                            <th class="px-4 sm:px-6 py-3 text-left table-header text-gray-500 uppercase tracking-wider">Transaction ID</th>
                            <th class="px-4 sm:px-6 py-3 text-left table-header text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-4 sm:px-6 py-3 text-left table-header text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-4 sm:px-6 py-3 text-left table-header text-gray-500 uppercase tracking-wider">Payment Method</th>
                            <th class="px-4 sm:px-6 py-3 text-left table-header text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-4 sm:px-6 py-3 text-left table-header text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($paginated as $transaction)
                        <tr class="hover:bg-gray-50 transition-colors" data-status="{{ $transaction['status'] ?? 'success' }}" data-search="{{ strtolower($transaction['description'] ?? '') }} {{ strtolower($transaction['transaction_id'] ?? '') }}">
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                @if(isset($transaction['date']))
                                    <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($transaction['date'])->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($transaction['date'])->format('h:i A') }}</div>
                                @endif
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                <span class="text-xs sm:text-sm font-mono text-gray-600">{{ substr($transaction['transaction_id'] ?? 'N/A', 0, 12) }}...</span>
                            </td>
                            <td class="px-4 sm:px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $transaction['description'] ?? 'Donation to APN' }}</div>
                                <div class="text-xs text-gray-500 mt-1">{{ $transaction['type'] == 'membership' ? 'Membership Payment' : 'One-time Donation' }}</div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold text-gray-900">${{ number_format($transaction['amount'] ?? 0, 2) }}</span>
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if(($transaction['payment_method'] ?? 'card') == 'card')
                                        <svg class="w-4 h-4 text-blue-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                                            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                                            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"></path>
                                        </svg>
                                    @endif
                                    <span class="text-xs sm:text-sm text-gray-600">{{ ucfirst($transaction['payment_method'] ?? 'Card') }}</span>
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                @if(($transaction['status'] ?? '') == 'success')
                                    <span class="badge px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Success</span>
                                @elseif(($transaction['status'] ?? '') == 'pending')
                                    <span class="badge px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                @else
                                    <span class="badge px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Failed</span>
                                @endif
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm">
                                <button onclick="openTransactionModal('{{ $transaction['id'] ?? '' }}')" class="text-indigo-600 hover:text-indigo-900 mr-2 sm:mr-3 font-medium text-xs sm:text-sm">View</button>
                                <button onclick="downloadReceipt('{{ $transaction['transaction_id'] ?? '' }}', {{ $transaction['amount'] ?? 0 }}, '{{ $transaction['date'] ?? '' }}', '{{ $transaction['payment_method'] ?? 'card' }}')" class="text-gray-600 hover:text-gray-900 font-medium text-xs sm:text-sm">Receipt</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 sm:px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No transactions</h3>
                                <p class="mt-1 text-sm text-gray-500">You haven't made any donations yet.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="mobile-cards p-4">
                @forelse($paginated as $transaction)
                <div class="transaction-card" data-status="{{ $transaction['status'] ?? 'success' }}" data-search="{{ strtolower($transaction['description'] ?? '') }} {{ strtolower($transaction['transaction_id'] ?? '') }}">
                    <div class="transaction-header">
                        <div>
                            <div class="text-xs text-gray-500">{{ isset($transaction['date']) ? \Carbon\Carbon::parse($transaction['date'])->format('M d, Y') : 'N/A' }} at {{ isset($transaction['date']) ? \Carbon\Carbon::parse($transaction['date'])->format('h:i A') : 'N/A' }}</div>
                            <div class="text-xs font-mono text-gray-500 mt-1">{{ substr($transaction['transaction_id'] ?? 'N/A', 0, 12) }}...</div>
                        </div>
                        <div class="transaction-amount">${{ number_format($transaction['amount'] ?? 0, 2) }}</div>
                    </div>
                    
                    <div class="transaction-details">
                        <div class="transaction-detail-item">
                            <span class="transaction-detail-label">Description</span>
                            <span class="transaction-detail-value">{{ $transaction['description'] ?? 'Donation to APN' }}</span>
                        </div>
                        <div class="transaction-detail-item">
                            <span class="transaction-detail-label">Type</span>
                            <span class="transaction-detail-value">{{ $transaction['type'] == 'membership' ? 'Membership Payment' : 'One-time Donation' }}</span>
                        </div>
                        <div class="transaction-detail-item">
                            <span class="transaction-detail-label">Payment Method</span>
                            <span class="transaction-detail-value flex items-center gap-1">
                                @if(($transaction['payment_method'] ?? 'card') == 'card')
                                    <svg class="w-3 h-3 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"></path>
                                    </svg>
                                @else
                                    <svg class="w-3 h-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"></path>
                                    </svg>
                                @endif
                                {{ ucfirst($transaction['payment_method'] ?? 'Card') }}
                            </span>
                        </div>
                        <div class="transaction-detail-item">
                            <span class="transaction-detail-label">Status</span>
                            <span class="transaction-detail-value">
                                @if(($transaction['status'] ?? '') == 'success')
                                    <span class="px-2 py-0.5 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">Success</span>
                                @elseif(($transaction['status'] ?? '') == 'pending')
                                    <span class="px-2 py-0.5 inline-flex text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                @else
                                    <span class="px-2 py-0.5 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-800">Failed</span>
                                @endif
                            </span>
                        </div>
                    </div>
                    
                    <div class="transaction-actions">
                        <button onclick="openTransactionModal('{{ $transaction['id'] ?? '' }}')" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">View Details</button>
                        <button onclick="downloadReceipt('{{ $transaction['transaction_id'] ?? '' }}', {{ $transaction['amount'] ?? 0 }}, '{{ $transaction['date'] ?? '' }}', '{{ $transaction['payment_method'] ?? 'card' }}')" class="text-gray-600 hover:text-gray-900 text-sm font-medium">Download Receipt</button>
                    </div>
                </div>
                @empty
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No transactions</h3>
                    <p class="mt-1 text-sm text-gray-500">You haven't made any donations yet.</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if(isset($paginated) && $paginated->hasPages())
            <div class="px-4 sm:px-6 py-4 bg-white border-t border-gray-200">
                {{ $paginated->links() }}
            </div>
            @endif
        </div>

        <!-- Download Statement Section -->
        <div class="mt-6 md:mt-8 bg-white rounded-lg shadow p-4 sm:p-6 download-section">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800 section-title">Download Statement</h3>
                    <p class="text-xs sm:text-sm text-gray-500 mt-1">Get a complete statement of all your transactions</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 w-full sm:w-auto">
                    <select id="statementPeriod" class="text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 filter-select px-3 py-2">
                        <option value="30">Last 30 days</option>
                        <option value="90">Last 3 months</option>
                        <option value="180">Last 6 months</option>
                        <option value="365">Last year</option>
                        <option value="all">All time</option>
                    </select>
                    <button onclick="downloadStatement()" 
                            class="download-button inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download PDF
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Transaction Details Modal -->
<div id="transactionModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div id="modalOverlay" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full w-full modal-container">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex justify-between items-center border-b border-gray-200 pb-4">
                    <h3 class="modal-title text-gray-900" id="modal-title">Transaction Details</h3>
                    <button onclick="closeTransactionModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="mt-4" id="transactionDetails">
                    <div id="modalLoading" class="text-center py-8">
                        <svg class="animate-spin h-8 w-8 text-indigo-600 mx-auto" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">Loading transaction details...</p>
                    </div>

                    <div id="transactionContent" class="hidden">
                        <div class="flex justify-center mb-4 sm:mb-6">
                            <span id="statusBadge" class="badge px-2 sm:px-3 py-1 inline-flex text-xs sm:text-sm leading-5 font-semibold rounded-full"></span>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-3 sm:p-4 mb-3 sm:mb-4">
                            <p class="text-xs text-gray-500 mb-1">Transaction ID</p>
                            <p id="transactionId" class="text-xs sm:text-sm font-mono text-gray-900 break-all"></p>
                        </div>

                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg p-3 sm:p-4 mb-3 sm:mb-4">
                            <p class="text-xs text-gray-500 mb-1">Amount</p>
                            <p id="transactionAmount" class="text-xl sm:text-2xl font-bold text-gray-900"></p>
                        </div>

                        <div class="grid grid-cols-2 gap-3 sm:gap-4 mb-3 sm:mb-4 modal-grid">
                            <div class="bg-gray-50 rounded-lg p-2 sm:p-3">
                                <p class="text-xs text-gray-500 mb-1">Date</p>
                                <p id="transactionDate" class="text-xs sm:text-sm font-medium text-gray-900"></p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-2 sm:p-3">
                                <p class="text-xs text-gray-500 mb-1">Time</p>
                                <p id="transactionTime" class="text-xs sm:text-sm font-medium text-gray-900"></p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-2 sm:p-3">
                                <p class="text-xs text-gray-500 mb-1">Payment Method</p>
                                <p id="paymentMethod" class="text-xs sm:text-sm font-medium text-gray-900"></p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-2 sm:p-3">
                                <p class="text-xs text-gray-500 mb-1">Type</p>
                                <p id="transactionType" class="text-xs sm:text-sm font-medium text-gray-900"></p>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-3 sm:pt-4">
                            <h4 class="text-xs sm:text-sm font-semibold text-gray-700 mb-2 sm:mb-3">Donor Information</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Name</p>
                                    <p id="donorName" class="text-xs sm:text-sm font-medium text-gray-900">{{ Auth::guard('donor')->user()->firstname }} {{ Auth::guard('donor')->user()->lastname }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Email</p>
                                    <p id="donorEmail" class="text-xs sm:text-sm font-medium text-gray-900 break-all">{{ Auth::guard('donor')->user()->email }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Phone</p>
                                    <p id="donorPhone" class="text-xs sm:text-sm font-medium text-gray-900">{{ Auth::guard('donor')->user()->phone ?? 'Not provided' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Location</p>
                                    <p id="donorLocation" class="text-xs sm:text-sm font-medium text-gray-900">
                                        {{ Auth::guard('donor')->user()->city ?? '' }}{{ Auth::guard('donor')->user()->city && Auth::guard('donor')->user()->country ? ', ' : '' }}{{ Auth::guard('donor')->user()->country ?? 'Not provided' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button onclick="downloadReceiptFromModal()" 
                        class="download-button w-full inline-flex justify-center items-center px-3 sm:px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Download Receipt
                </button>
                <button onclick="closeTransactionModal()" 
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-3 sm:px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    const transactions = @json($paginated->items());
    let currentTransaction = null;

    // Filter and search functionality
    function filterTransactions() {
        const statusFilter = document.getElementById('statusFilter')?.value || 'all';
        const searchTerm = document.getElementById('searchInput')?.value.toLowerCase() || '';
        
        const desktopRows = document.querySelectorAll('.desktop-table tbody tr');
        const mobileCards = document.querySelectorAll('.mobile-cards .transaction-card');
        
        // Filter desktop rows
        desktopRows.forEach(row => {
            const status = row.getAttribute('data-status') || 'success';
            const searchText = row.getAttribute('data-search') || '';
            
            const statusMatch = statusFilter === 'all' || status === statusFilter;
            const searchMatch = searchTerm === '' || searchText.includes(searchTerm);
            
            row.style.display = statusMatch && searchMatch ? '' : 'none';
        });
        
        // Filter mobile cards
        mobileCards.forEach(card => {
            const status = card.getAttribute('data-status') || 'success';
            const searchText = card.getAttribute('data-search') || '';
            
            const statusMatch = statusFilter === 'all' || status === statusFilter;
            const searchMatch = searchTerm === '' || searchText.includes(searchTerm);
            
            card.style.display = statusMatch && searchMatch ? 'block' : 'none';
        });
    }

    function openTransactionModal(transactionId) {
        currentTransaction = transactions.find(t => String(t.id) === String(transactionId));
        
        if (!currentTransaction) {
            alert('Transaction not found');
            return;
        }

        document.getElementById('transactionModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        document.getElementById('modalLoading').classList.remove('hidden');
        document.getElementById('transactionContent').classList.add('hidden');
        
        setTimeout(() => {
            document.getElementById('modalLoading').classList.add('hidden');
            document.getElementById('transactionContent').classList.remove('hidden');
            populateTransactionModal(currentTransaction);
        }, 500);
    }

    function populateTransactionModal(transaction) {
        const statusBadge = document.getElementById('statusBadge');
        const status = transaction.status || 'success';
        statusBadge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
        statusBadge.className = 'badge px-2 sm:px-3 py-1 inline-flex text-xs sm:text-sm leading-5 font-semibold rounded-full';
        
        if (status === 'success') {
            statusBadge.classList.add('bg-green-100', 'text-green-800');
        } else if (status === 'pending') {
            statusBadge.classList.add('bg-yellow-100', 'text-yellow-800');
        } else {
            statusBadge.classList.add('bg-red-100', 'text-red-800');
        }
        
        document.getElementById('transactionId').textContent = transaction.transaction_id || 'N/A';
        document.getElementById('transactionAmount').textContent = `$${parseFloat(transaction.amount || 0).toFixed(2)}`;
        
        if (transaction.date) {
            const date = new Date(transaction.date);
            document.getElementById('transactionDate').textContent = date.toLocaleDateString('en-US', { 
                month: 'long', 
                day: 'numeric', 
                year: 'numeric' 
            });
            document.getElementById('transactionTime').textContent = date.toLocaleTimeString('en-US', { 
                hour: '2-digit', 
                minute: '2-digit' 
            });
        }

        const method = transaction.payment_method || 'card';
        document.getElementById('paymentMethod').textContent = method.charAt(0).toUpperCase() + method.slice(1);
        const type = transaction.type || 'donation';
        document.getElementById('transactionType').textContent = type === 'membership' ? 'Membership Payment' : 'One-time Donation';
    }

    function closeTransactionModal() {
        document.getElementById('transactionModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        currentTransaction = null;
    }

    function downloadReceipt(transactionId, amount, date, paymentMethod) {
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<svg class="animate-spin h-4 w-4 mr-2 inline" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Generating...';
        button.disabled = true;

        setTimeout(() => {
            generateAndDownloadReceipt(transactionId, amount, date, paymentMethod);
            button.innerHTML = originalText;
            button.disabled = false;
        }, 1000);
    }

    function downloadReceiptFromModal() {
        if (!currentTransaction) return;
        
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<svg class="animate-spin h-4 w-4 mr-2 inline" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Generating...';
        button.disabled = true;

        setTimeout(() => {
            generateAndDownloadReceipt(
                currentTransaction.transaction_id, 
                currentTransaction.amount, 
                currentTransaction.date, 
                currentTransaction.payment_method
            );
            button.innerHTML = originalText;
            button.disabled = false;
        }, 1000);
    }

    function generateAndDownloadReceipt(transactionId, amount, date, paymentMethod) {
        const receiptDate = date ? new Date(date) : new Date();
        const formattedDate = receiptDate.toLocaleDateString('en-US', { 
            month: 'long', 
            day: 'numeric', 
            year: 'numeric' 
        });

        const donorName = '{{ Auth::guard('donor')->user()->firstname }} {{ Auth::guard('donor')->user()->lastname }}';
        const donorEmail = '{{ Auth::guard('donor')->user()->email }}';

        const receiptHTML = `
            <!DOCTYPE html>
            <html>
            <head>
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Payment Receipt</title>
                <style>
                    body { font-family: 'Inter', Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; background: #f9fafb; }
                    .receipt-container { background: white; border-radius: 16px; padding: 20px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); border: 1px solid #e2e8f0; }
                    .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #e2e8f0; padding-bottom: 20px; }
                    .logo { font-size: 20px; font-weight: bold; background: linear-gradient(135deg, #3730a3, #4f46e5); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
                    .receipt-title { font-size: 18px; color: #1a1f36; margin-top: 10px; }
                    .amount { font-size: 36px; font-weight: bold; color: #4f46e5; text-align: center; margin: 20px 0; }
                    .details { background: #f8fafc; border-radius: 12px; padding: 15px; margin: 20px 0; }
                    .row { display: flex; justify-content: space-between; margin-bottom: 12px; padding: 8px 0; border-bottom: 1px dashed #e2e8f0; flex-wrap: wrap; gap: 8px; }
                    .row:last-child { border-bottom: none; }
                    .label { font-weight: 600; color: #64748b; }
                    .value { color: #1a1f36; font-weight: 500; word-break: break-word; }
                    .status { background: #dcfce7; color: #166534; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-block; }
                    .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 2px solid #e2e8f0; color: #94a3b8; font-size: 12px; }
                    .thank-you { font-size: 16px; color: #4f46e5; margin-bottom: 10px; font-weight: 600; }
                    @media (max-width: 480px) {
                        body { padding: 10px; }
                        .receipt-container { padding: 15px; }
                        .logo { font-size: 18px; }
                        .amount { font-size: 28px; }
                        .row { flex-direction: column; gap: 4px; }
                    }
                </style>
            </head>
            <body>
                <div class="receipt-container">
                    <div class="header">
                        <div class="logo">Africa Prosperity Network</div>
                        <div class="receipt-title">Payment Receipt</div>
                    </div>

                    <div class="amount">$${parseFloat(amount || 0).toFixed(2)}</div>

                    <div class="details">
                        <div class="row"><span class="label">Transaction ID:</span><span class="value">${transactionId || 'N/A'}</span></div>
                        <div class="row"><span class="label">Date:</span><span class="value">${formattedDate}</span></div>
                        <div class="row"><span class="label">Donor Name:</span><span class="value">${donorName}</span></div>
                        <div class="row"><span class="label">Donor Email:</span><span class="value">${donorEmail}</span></div>
                        <div class="row"><span class="label">Payment Method:</span><span class="value">${(paymentMethod || 'Card').charAt(0).toUpperCase() + (paymentMethod || 'Card').slice(1)}</span></div>
                        <div class="row"><span class="label">Status:</span><span class="value"><span class="status">Success</span></span></div>
                    </div>

                    <div class="footer">
                        <div class="thank-you">Thank you for your support!</div>
                        <p>This is a computer-generated receipt. No signature required.</p>
                    </div>
                </div>
            </body>
            </html>
        `;

        const blob = new Blob([receiptHTML], { type: 'text/html' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `receipt-${transactionId || 'download'}.html`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
    }

    function downloadStatement() {
        const period = document.getElementById('statementPeriod').value;
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        
        button.innerHTML = '<svg class="animate-spin h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Generating...';
        button.disabled = true;

        setTimeout(() => {
            generateAndDownloadStatement(period);
            button.innerHTML = originalText;
            button.disabled = false;
        }, 1500);
    }

    function generateAndDownloadStatement(period) {
        const periods = {
            '30': 'Last 30 Days',
            '90': 'Last 3 Months',
            '180': 'Last 6 Months',
            '365': 'Last Year',
            'all': 'All Time'
        };

        const periodText = periods[period] || 'Selected Period';
        const date = new Date();
        const formattedDate = date.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });

        let transactionsHTML = '';
        const allTransactions = @json($transactions);
        
        allTransactions.forEach(t => {
            const tDate = t.date ? new Date(t.date) : new Date();
            transactionsHTML += `
                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">${tDate.toLocaleDateString()}</td>
                    <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">${t.transaction_id || 'N/A'}</td>
                    <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">$${parseFloat(t.amount || 0).toFixed(2)}</td>
                    <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">${(t.payment_method || 'Card').charAt(0).toUpperCase()}</td>
                    <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">${t.status || 'success'}</td>
                </tr>
            `;
        });

        const total = allTransactions.reduce((sum, t) => sum + parseFloat(t.amount || 0), 0);
        const donorName = '{{ Auth::guard('donor')->user()->firstname }} {{ Auth::guard('donor')->user()->lastname }}';

        const statementHTML = `
            <!DOCTYPE html>
            <html>
            <head>
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Transaction Statement</title>
                <style>
                    body { font-family: 'Inter', Arial, sans-serif; max-width: 1000px; margin: 0 auto; padding: 20px; background: #f9fafb; }
                    .statement-container { background: white; border-radius: 16px; padding: 20px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); }
                    .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #e2e8f0; padding-bottom: 20px; }
                    .logo { font-size: 24px; font-weight: bold; background: linear-gradient(135deg, #3730a3, #4f46e5); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
                    .title { font-size: 20px; color: #1a1f36; margin-top: 10px; }
                    .period { color: #64748b; margin-bottom: 20px; }
                    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                    th { background-color: #f8fafc; padding: 12px; text-align: left; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; }
                    td { padding: 12px; border-bottom: 1px solid #e2e8f0; font-size: 14px; }
                    .total { margin-top: 20px; text-align: right; font-size: 18px; font-weight: bold; color: #1a1f36; }
                    .footer { margin-top: 30px; text-align: center; color: #94a3b8; font-size: 14px; border-top: 2px solid #e2e8f0; padding-top: 20px; }
                    @media (max-width: 640px) {
                        body { padding: 10px; }
                        table, thead, tbody, th, td, tr { display: block; }
                        thead { display: none; }
                        tr { margin-bottom: 15px; border: 1px solid #e5e7eb; border-radius: 8px; padding: 10px; }
                        td { display: flex; justify-content: space-between; align-items: center; padding: 8px; border-bottom: 1px solid #e5e7eb; }
                        td:last-child { border-bottom: none; }
                        td:before { content: attr(data-label); font-weight: 600; margin-right: 10px; }
                    }
                </style>
            </head>
            <body>
                <div class="statement-container">
                    <div class="header">
                        <div class="logo">Africa Prosperity Network</div>
                        <div class="title">Transaction Statement</div>
                        <div class="period">Period: ${periodText}</div>
                        <div>Generated on: ${formattedDate}</div>
                        <div>Donor: ${donorName}</div>
                    </div>
                    
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Transaction ID</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${transactionsHTML || '<tr><td colspan="5" style="text-align: center; padding: 20px;">No transactions found</td></tr>'}
                        </tbody>
                    </table>
                    
                    <div class="total">
                        Total: $${total.toFixed(2)}
                    </div>
                    
                    <div class="footer">
                        <p>This statement includes all transactions for the selected period.</p>
                        <p>For any questions, please contact support@africaprosperitynetwork.com</p>
                    </div>
                </div>
            </body>
            </html>
        `;

        const blob = new Blob([statementHTML], { type: 'text/html' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `statement-${period}-${new Date().toISOString().split('T')[0]}.html`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
    }

    // Event listeners
    document.getElementById('modalOverlay')?.addEventListener('click', function() {
        closeTransactionModal();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeTransactionModal();
        }
    });

    document.getElementById('statusFilter')?.addEventListener('change', function() {
        filterTransactions();
    });

    document.getElementById('searchInput')?.addEventListener('keyup', function() {
        filterTransactions();
    });
</script>

<style>
    /* Modal animations */
    #transactionModal {
        transition: opacity 0.3s ease;
    }
    
    #transactionModal .transform {
        transition: transform 0.3s ease;
    }
    
    #transactionModal.hidden {
        display: none;
    }
    
    /* Custom scrollbar for modal */
    #transactionDetails {
        max-height: 70vh;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e0 #f1f5f9;
    }
    
    #transactionDetails::-webkit-scrollbar {
        width: 6px;
    }
    
    #transactionDetails::-webkit-scrollbar-track {
        background: #f1f5f9;
    }
    
    #transactionDetails::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 3px;
    }
    
    #transactionDetails::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>
@endpush
@endsection