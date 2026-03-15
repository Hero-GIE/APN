@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header with breadcrumb -->
        <div class="mb-8">
            <div class="flex items-center text-sm text-gray-500 mb-2">
                <a href="{{ route('donor.dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700">Transactions</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Transaction History</h1>
            <p class="text-gray-600 mt-2">View all your donation transactions and payment history.</p>
        </div>

        <!-- Stats Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-indigo-100 rounded-full">
                        <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs text-gray-500">Total Transactions</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $transactions->total() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-full">
                        <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs text-gray-500">Total Amount</p>
                        <p class="text-lg font-semibold text-gray-900">${{ number_format($transactions->sum('amount'), 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-full">
                        <svg class="h-5 w-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs text-gray-500">Payment Methods</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $transactions->pluck('payment_method')->unique()->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 rounded-full">
                        <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs text-gray-500">Successful</p>
                        <p class="text-lg font-semibold text-green-600">{{ $transactions->where('payment_status', 'success')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">All Transactions</h2>
                <div class="flex space-x-2">
                    <select class="text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                        <option>All Status</option>
                        <option>Success</option>
                        <option>Pending</option>
                        <option>Failed</option>
                    </select>
                    <input type="text" placeholder="Search transactions..." 
                           class="text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Method</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($transactions as $transaction)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $transaction->created_at->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $transaction->created_at->format('h:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-mono text-gray-600">{{ $transaction->transaction_id }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">Donation to APN</div>
                                <div class="text-xs text-gray-500">{{ $transaction->purpose ?? 'General Donation' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold text-gray-900">${{ number_format($transaction->amount, 2) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($transaction->payment_method == 'card')
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
                                    <span class="text-sm text-gray-600">{{ ucfirst($transaction->payment_method ?? 'Card') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($transaction->payment_status == 'success')
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Success
                                    </span>
                                @elseif($transaction->payment_status == 'pending')
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                @else
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Failed
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <button onclick="openTransactionModal({{ $transaction->id }})" 
                                        class="text-indigo-600 hover:text-indigo-900 mr-3 font-medium">
                                    View
                                </button>
                                <button onclick="downloadReceipt({{ $transaction->id }})" 
                                        class="text-gray-600 hover:text-gray-900 font-medium">
                                    Receipt
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
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

            <!-- Pagination -->
            @if($transactions->hasPages())
            <div class="px-6 py-4 bg-white border-t border-gray-200">
                {{ $transactions->links() }}
            </div>
            @endif
        </div>

        <!-- Download Statement Section -->
        <div class="mt-8 bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Download Statement</h3>
                    <p class="text-sm text-gray-500 mt-1">Get a complete statement of all your transactions</p>
                </div>
                <div class="flex space-x-3">
                    <select id="statementPeriod" class="text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="30">Last 30 days</option>
                        <option value="90">Last 3 months</option>
                        <option value="180">Last 6 months</option>
                        <option value="365">Last year</option>
                        <option value="all">All time</option>
                    </select>
                    <button onclick="downloadStatement()" 
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
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
        <!-- Background overlay -->
        <div id="modalOverlay" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <!-- Modal Header -->
                <div class="flex justify-between items-center border-b border-gray-200 pb-4">
                    <h3 class="text-lg font-semibold text-gray-900" id="modal-title">Transaction Details</h3>
                    <button onclick="closeTransactionModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Transaction Details Content -->
                <div class="mt-4" id="transactionDetails">
                    <!-- Loading State -->
                    <div id="modalLoading" class="text-center py-8">
                        <svg class="animate-spin h-8 w-8 text-indigo-600 mx-auto" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">Loading transaction details...</p>
                    </div>

                    <!-- Transaction Info (populated by JavaScript) -->
                    <div id="transactionContent" class="hidden">
                        <!-- Status Badge -->
                        <div class="flex justify-center mb-6">
                            <span id="statusBadge" class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full"></span>
                        </div>

                        <!-- Transaction ID -->
                        <div class="bg-gray-50 rounded-lg p-4 mb-4">
                            <p class="text-xs text-gray-500 mb-1">Transaction ID</p>
                            <p id="transactionId" class="text-sm font-mono text-gray-900 break-all"></p>
                        </div>

                        <!-- Amount -->
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg p-4 mb-4">
                            <p class="text-xs text-gray-500 mb-1">Amount</p>
                            <p id="transactionAmount" class="text-2xl font-bold text-gray-900"></p>
                        </div>

                        <!-- Details Grid -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="bg-gray-50 rounded-lg p-3">
                                <p class="text-xs text-gray-500 mb-1">Date</p>
                                <p id="transactionDate" class="text-sm font-medium text-gray-900"></p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <p class="text-xs text-gray-500 mb-1">Time</p>
                                <p id="transactionTime" class="text-sm font-medium text-gray-900"></p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <p class="text-xs text-gray-500 mb-1">Payment Method</p>
                                <p id="paymentMethod" class="text-sm font-medium text-gray-900"></p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <p class="text-xs text-gray-500 mb-1">Purpose</p>
                                <p id="purpose" class="text-sm font-medium text-gray-900">General Donation</p>
                            </div>
                        </div>

                        <!-- Donor Information -->
                        <div class="border-t border-gray-200 pt-4">
                            <h4 class="text-sm font-semibold text-gray-700 mb-3">Donor Information</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Name</p>
                                    <p id="donorName" class="text-sm font-medium text-gray-900"></p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Email</p>
                                    <p id="donorEmail" class="text-sm font-medium text-gray-900 break-all"></p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Phone</p>
                                    <p id="donorPhone" class="text-sm font-medium text-gray-900"></p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Location</p>
                                    <p id="donorLocation" class="text-sm font-medium text-gray-900"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button onclick="downloadReceipt(document.getElementById('transactionId').textContent)" 
                        class="w-full inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Download Receipt
                </button>
                <button onclick="closeTransactionModal()" 
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Hidden div to store transaction data -->
<div id="transactionData" style="display: none;">{{ json_encode($transactions->items()) }}</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    // Store transactions data
    const transactions = @json($transactions->items());
    
    function openTransactionModal(transactionId) {
        const transaction = transactions.find(t => t.id === transactionId);
        
        if (!transaction) {
            alert('Transaction not found');
            return;
        }

        // Show modal
        document.getElementById('transactionModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        // Show loading
        document.getElementById('modalLoading').classList.remove('hidden');
        document.getElementById('transactionContent').classList.add('hidden');
        
        // Simulate loading (remove this in production)
        setTimeout(() => {
            // Hide loading
            document.getElementById('modalLoading').classList.add('hidden');
            document.getElementById('transactionContent').classList.remove('hidden');
            
            // Populate data
            populateTransactionModal(transaction);
        }, 500);
    }

    function populateTransactionModal(transaction) {
        // Set status badge
        const statusBadge = document.getElementById('statusBadge');
        statusBadge.textContent = transaction.payment_status.charAt(0).toUpperCase() + transaction.payment_status.slice(1);
        statusBadge.className = 'px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full';
        
        if (transaction.payment_status === 'success') {
            statusBadge.classList.add('bg-green-100', 'text-green-800');
        } else if (transaction.payment_status === 'pending') {
            statusBadge.classList.add('bg-yellow-100', 'text-yellow-800');
        } else {
            statusBadge.classList.add('bg-red-100', 'text-red-800');
        }

        // Transaction details
        document.getElementById('transactionId').textContent = transaction.transaction_id;
        document.getElementById('transactionAmount').textContent = `$${parseFloat(transaction.amount).toFixed(2)}`;
        
        const date = new Date(transaction.created_at);
        document.getElementById('transactionDate').textContent = date.toLocaleDateString('en-US', { 
            month: 'long', 
            day: 'numeric', 
            year: 'numeric' 
        });
        document.getElementById('transactionTime').textContent = date.toLocaleTimeString('en-US', { 
            hour: '2-digit', 
            minute: '2-digit' 
        });

        // Payment method
        const method = transaction.payment_method || 'card';
        document.getElementById('paymentMethod').textContent = method.charAt(0).toUpperCase() + method.slice(1);
        document.getElementById('purpose').textContent = transaction.purpose || 'General Donation';

        // Donor info (you'll need to adjust these based on your data structure)
        document.getElementById('donorName').textContent = '{{ Auth::guard('donor')->user()->firstname }} {{ Auth::guard('donor')->user()->lastname }}';
        document.getElementById('donorEmail').textContent = '{{ Auth::guard('donor')->user()->email }}';
        document.getElementById('donorPhone').textContent = '{{ Auth::guard('donor')->user()->phone ?? 'Not provided' }}';
        
        const location = '{{ Auth::guard('donor')->user()->city ?? '' }}' + 
                        ( '{{ Auth::guard('donor')->user()->country ?? '' }}' ? ', {{ Auth::guard('donor')->user()->country }}' : '');
        document.getElementById('donorLocation').textContent = location || 'Not provided';
    }

    function closeTransactionModal() {
        document.getElementById('transactionModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function downloadReceipt(transactionId) {
        // Show loading state
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<svg class="animate-spin h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Generating...';
        button.disabled = true;

        // Simulate PDF generation (replace with actual API call)
        setTimeout(() => {
            // Create a simple HTML receipt
            const transaction = transactions.find(t => t.id === transactionId || t.transaction_id === transactionId);
            
            if (transaction) {
                const receiptContent = generateReceiptHTML(transaction);
                
                // Create a blob and download
                const blob = new Blob([receiptContent], { type: 'text/html' });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `receipt-${transaction.transaction_id}.html`;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                window.URL.revokeObjectURL(url);
            }

            // Reset button
            button.innerHTML = originalText;
            button.disabled = false;
        }, 1500);
    }

    function generateReceiptHTML(transaction) {
        const date = new Date(transaction.created_at);
        const formattedDate = date.toLocaleDateString('en-US', { 
            month: 'long', 
            day: 'numeric', 
            year: 'numeric' 
        });
        
        return `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Donation Receipt</title>
                <style>
                    body { font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; }
                    .header { text-align: center; margin-bottom: 30px; }
                    .logo { font-size: 24px; font-weight: bold; color: #4f46e5; }
                    .receipt-title { font-size: 20px; margin-top: 10px; }
                    .details { border: 1px solid #e5e7eb; padding: 20px; border-radius: 8px; }
                    .row { display: flex; justify-content: space-between; margin-bottom: 10px; }
                    .label { font-weight: 600; color: #4b5563; }
                    .value { color: #1f2937; }
                    .status-success { color: #059669; font-weight: 600; }
                    .footer { margin-top: 30px; text-align: center; color: #6b7280; font-size: 14px; }
                </style>
            </head>
            <body>
                <div class="header">
                    <div class="logo">Africa Prosperity Network</div>
                    <div class="receipt-title">Donation Receipt</div>
                </div>
                
                <div class="details">
                    <div class="row">
                        <span class="label">Receipt Number:</span>
                        <span class="value">${transaction.transaction_id}</span>
                    </div>
                    <div class="row">
                        <span class="label">Date:</span>
                        <span class="value">${formattedDate}</span>
                    </div>
                    <div class="row">
                        <span class="label">Donor Name:</span>
                        <span class="value">{{ Auth::guard('donor')->user()->firstname }} {{ Auth::guard('donor')->user()->lastname }}</span>
                    </div>
                    <div class="row">
                        <span class="label">Donor Email:</span>
                        <span class="value">{{ Auth::guard('donor')->user()->email }}</span>
                    </div>
                    <div class="row">
                        <span class="label">Amount:</span>
                        <span class="value">$${parseFloat(transaction.amount).toFixed(2)}</span>
                    </div>
                    <div class="row">
                        <span class="label">Payment Method:</span>
                        <span class="value">${(transaction.payment_method || 'Card').charAt(0).toUpperCase() + (transaction.payment_method || 'Card').slice(1)}</span>
                    </div>
                    <div class="row">
                        <span class="label">Status:</span>
                        <span class="value status-${transaction.payment_status}">${transaction.payment_status.charAt(0).toUpperCase() + transaction.payment_status.slice(1)}</span>
                    </div>
                    <div class="row">
                        <span class="label">Purpose:</span>
                        <span class="value">${transaction.purpose || 'General Donation'}</span>
                    </div>
                </div>
                
                <div class="footer">
                    <p>Thank you for your generous support!</p>
                    <p>This is a computer-generated receipt. No signature required.</p>
                </div>
            </body>
            </html>
        `;
    }

    function downloadStatement() {
        const period = document.getElementById('statementPeriod').value;
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        
        button.innerHTML = '<svg class="animate-spin h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Generating...';
        button.disabled = true;

        // Simulate statement generation
        setTimeout(() => {
            // Generate statement HTML
            const statementHTML = generateStatementHTML(period);
            
            // Create download
            const blob = new Blob([statementHTML], { type: 'text/html' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `statement-${period}-${new Date().toISOString().split('T')[0]}.html`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);

            // Reset button
            button.innerHTML = originalText;
            button.disabled = false;
        }, 2000);
    }

    function generateStatementHTML(period) {
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
        transactions.forEach(t => {
            const tDate = new Date(t.created_at);
            transactionsHTML += `
                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">${tDate.toLocaleDateString()}</td>
                    <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">${t.transaction_id}</td>
                    <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">$${parseFloat(t.amount).toFixed(2)}</td>
                    <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">${(t.payment_method || 'Card').charAt(0).toUpperCase()}</td>
                    <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">${t.payment_status}</td>
                </tr>
            `;
        });

        const total = transactions.reduce((sum, t) => sum + parseFloat(t.amount), 0);

        return `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Transaction Statement</title>
                <style>
                    body { font-family: Arial, sans-serif; max-width: 1000px; margin: 0 auto; padding: 20px; }
                    .header { text-align: center; margin-bottom: 30px; }
                    .logo { font-size: 24px; font-weight: bold; color: #4f46e5; }
                    .title { font-size: 20px; margin-top: 10px; }
                    .period { color: #6b7280; margin-bottom: 20px; }
                    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                    th { background-color: #f3f4f6; padding: 10px; text-align: left; }
                    td { padding: 10px; border-bottom: 1px solid #e5e7eb; }
                    .total { margin-top: 20px; text-align: right; font-size: 18px; font-weight: bold; }
                    .footer { margin-top: 30px; text-align: center; color: #6b7280; font-size: 14px; }
                </style>
            </head>
            <body>
                <div class="header">
                    <div class="logo">Africa Prosperity Network</div>
                    <div class="title">Transaction Statement</div>
                    <div class="period">Period: ${periodText}</div>
                    <div>Generated on: ${formattedDate}</div>
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
                        ${transactionsHTML}
                    </tbody>
                </table>
                
                <div class="total">
                    Total: $${total.toFixed(2)}
                </div>
                
                <div class="footer">
                    <p>This statement includes all transactions for the selected period.</p>
                    <p>For any questions, please contact support@delegate.com</p>
                </div>
            </body>
            </html>
        `;
    }

    // Close modal when clicking outside
    document.getElementById('modalOverlay').addEventListener('click', function() {
        closeTransactionModal();
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeTransactionModal();
        }
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