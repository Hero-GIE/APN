@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center text-sm text-gray-500 mb-2">
                <a href="{{ route('member.dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700">Payment History</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Payment History</h1>
            <p class="text-gray-600 mt-2">View all your membership payments and transactions.</p>
        </div>

        <!-- Stats Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-indigo-100 rounded-full">
                        <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Total Payments</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $payments->total() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Total Amount</p>
                        <p class="text-2xl font-semibold text-gray-900">${{ number_format($payments->sum('amount'), 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-full">
                        <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Successful Payments</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $payments->where('donation.payment_status', 'success')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payments Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">All Membership Payments</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Period</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Method</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Receipt</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($payments as $payment)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $payment->payment_date->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $payment->payment_date->format('h:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-mono text-gray-600">{{ substr($payment->donation->transaction_id, 0, 12) }}...</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold text-gray-900">${{ number_format($payment->amount, 2) }}</span>
                                <span class="text-xs text-gray-500 block">{{ ucfirst($payment->membership_type) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $payment->period_start->format('M d, Y') }}<br>
                                <span class="text-xs">to {{ $payment->period_end->format('M d, Y') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-blue-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"></path>
                                    </svg>
                                    <span class="text-sm text-gray-600">{{ ucfirst($payment->donation->payment_method ?? 'Card') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Success
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <button onclick="downloadReceipt('{{ $payment->donation->transaction_id }}', {{ $payment->amount }}, '{{ $payment->payment_date }}', '{{ $payment->donation->payment_method ?? 'Card' }}')" 
                                        class="text-indigo-600 hover:text-indigo-900 font-medium">
                                    Download
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No payment records</h3>
                                <p class="mt-1 text-sm text-gray-500">Your membership payments will appear here.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($payments->hasPages())
            <div class="px-6 py-4 bg-white border-t border-gray-200">
                {{ $payments->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    function downloadReceipt(transactionId, amount, date, paymentMethod) {
        const button = event.target;
        const originalText = button.textContent;
        button.innerHTML = '<svg class="animate-spin h-4 w-4 mr-2 inline" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Generating...';
        button.disabled = true;

        setTimeout(() => {
            const receiptDate = new Date(date);
            const formattedDate = receiptDate.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });

            const receiptHTML = `
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Payment Receipt</title>
                    <style>
                        body { font-family: 'Inter', sans-serif; max-width: 600px; margin: 0 auto; padding: 30px; background: #f9fafb; }
                        .receipt-container { background: white; border-radius: 12px; padding: 30px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
                        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #e5e7eb; padding-bottom: 20px; }
                        .logo { font-size: 24px; font-weight: bold; color: #4f46e5; }
                        .receipt-title { font-size: 20px; margin-top: 10px; color: #1f2937; }
                        .details { margin: 20px 0; }
                        .row { display: flex; justify-content: space-between; margin-bottom: 12px; padding: 8px 0; border-bottom: 1px dashed #e5e7eb; }
                        .label { font-weight: 600; color: #4b5563; }
                        .value { color: #1f2937; }
                        .amount { font-size: 24px; font-weight: bold; color: #059669; text-align: center; margin: 20px 0; }
                        .footer { margin-top: 30px; text-align: center; color: #6b7280; font-size: 14px; border-top: 2px solid #e5e7eb; padding-top: 20px; }
                        .thank-you { font-size: 18px; color: #4f46e5; margin-bottom: 10px; }
                    </style>
                </head>
                <body>
                    <div class="receipt-container">
                        <div class="header">
                            <div class="logo">Africa Prosperity Network</div>
                            <div class="receipt-title">Payment Receipt</div>
                        </div>
                        
                        <div class="amount">$${parseFloat(amount).toFixed(2)}</div>
                        
                        <div class="details">
                            <div class="row"><span class="label">Transaction ID:</span><span class="value">${transactionId}</span></div>
                            <div class="row"><span class="label">Date:</span><span class="value">${formattedDate}</span></div>
                            <div class="row"><span class="label">Member Name:</span><span class="value">{{ $donor->firstname }} {{ $donor->lastname }}</span></div>
                            <div class="row"><span class="label">Member Email:</span><span class="value">{{ $donor->email }}</span></div>
                            <div class="row"><span class="label">Payment Method:</span><span class="value">${paymentMethod.charAt(0).toUpperCase() + paymentMethod.slice(1)}</span></div>
                            <div class="row"><span class="label">Status:</span><span class="value" style="color: #059669;">Success</span></div>
                        </div>
                        
                        <div class="footer">
                            <div class="thank-you">Thank you for your membership!</div>
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
            a.download = `receipt-${transactionId}.html`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);

            button.innerHTML = originalText;
            button.disabled = false;
        }, 1000);
    }
</script>
@endpush
@endsection