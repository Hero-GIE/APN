@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header with conditional greeting -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ $donor->firstname }}!</h1>
                <p class="text-gray-600 mt-2">
                    @if($stats['is_member'] && $member->status == 'active')
                        Thank you for being an APN Member. Here's your activity overview.
                    @else
                        Thank you for supporting APN. Here's your donation history.
                    @endif
                </p>
            </div>
            
            <!-- User Dropdown Menu -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none">
                    <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center">
                        <span class="text-indigo-600 font-semibold text-lg">
                            {{ strtoupper(substr($donor->firstname, 0, 1)) }}{{ strtoupper(substr($donor->lastname, 0, 1)) }}
                        </span>
                    </div>
                    <span class="text-gray-700 font-medium">{{ $donor->firstname }} {{ $donor->lastname }}</span>
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                
                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                    <a href="{{ route('donor.profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Profile</a>
                    <a href="{{ route('donor.transactions') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Transactions</a>
                    
                    @if($stats['is_member'] && $member->status == 'active')
                        <a href="{{ route('member.dashboard') }}" class="block px-4 py-2 text-sm text-indigo-600 hover:bg-gray-100 font-medium">Switch to Member Dashboard →</a>
                    @else
                        <a href="{{ route('donor.membership') }}" class="block px-4 py-2 text-sm text-indigo-600 hover:bg-gray-100 font-medium">Become a Member</a>
                    @endif
                    
                    <a href="{{ route('donor.support') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Help & Support</a>
                    <div class="border-t border-gray-100"></div>
                    <button @click="open = false; $dispatch('open-logout-modal')" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                        Logout
                    </button>
                </div>
            </div>
        </div>

        <!-- Stats Cards Row -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Membership Status Card - Dynamic from Database -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Membership Status</p>
                        <p class="text-xl font-semibold text-gray-900">
                            @if($member)
                                @if($member->status == 'active')
                                    <span class="text-green-600">● Active {{ ucfirst($member->membership_type) }} Member</span>
                                @elseif($member->status == 'expired')
                                    <span class="text-red-600">● Expired</span>
                                @elseif($member->status == 'cancelled')
                                    <span class="text-orange-600">● Cancelled</span>
                                @elseif($member->status == 'pending')
                                    <span class="text-yellow-600">● Pending</span>
                                @endif
                            @else
                                <span class="text-gray-600">● Not a Member</span>
                            @endif
                        </p>
                    </div>
                </div>
                
                <div class="mt-4 text-sm">
                    @if($member)
                        @if($member->status == 'active')
                            <p class="text-gray-600">Plan: <span class="font-medium">{{ ucfirst($member->membership_type) }} Plan</span></p>
                            <p class="text-gray-600">Valid Until: <span class="font-medium">{{ $member->end_date ? $member->end_date->format('M d, Y') : 'N/A' }}</span></p>
                            <a href="{{ route('member.dashboard') }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium mt-2 inline-block">
                                Go to Member Dashboard →
                            </a>
                        @elseif($member->status == 'expired')
                            <p class="text-gray-600">Your membership expired on {{ $member->end_date ? $member->end_date->format('M d, Y') : 'N/A' }}</p>
                            <a href="{{ route('donor.membership') }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium mt-2 inline-block">
                                Renew Membership →
                            </a>
                        @elseif($member->status == 'cancelled')
                            <p class="text-gray-600">Your membership was cancelled on {{ $member->updated_at->format('M d, Y') }}</p>
                            <a href="{{ route('donor.membership') }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium mt-2 inline-block">
                                Rejoin →
                            </a>
                        @elseif($member->status == 'pending')
                            <p class="text-gray-600">Your membership is being processed</p>
                            <p class="text-xs text-gray-500 mt-1">This may take 24-48 hours</p>
                        @endif
                    @else
                        <p class="text-gray-600">You are not currently a member.</p>
                        <a href="{{ route('donor.membership') }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium mt-2 inline-block">
                            Become a Member →
                        </a>
                    @endif
                </div>
            </div>

            <!-- Payment History Summary -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Payment History</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_donations'] }} payments</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('donor.transactions') }}" class="text-sm text-indigo-600 hover:text-indigo-900">View all transactions →</a>
                </div>
            </div>

            <!-- Help/Support Quick Access -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-full">
                        <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Need Help?</p>
                        <p class="text-xs text-gray-400 mt-1">support@africaprosperitynetwork.com</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('donor.support') }}" class="text-sm text-indigo-600 hover:text-indigo-900">Contact Support →</a>
                </div>
            </div>
        </div>

        <!-- Donation Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-indigo-100 rounded-full">
                        <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Total Donations</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_donations'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full">
                        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Total Amount</p>
                        <p class="text-2xl font-semibold text-gray-900">${{ number_format($stats['total_amount'], 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-full">
                        <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Member Since</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['member_since'] ?? $donor->created_at->format('M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Member CTA Banner (for non-members) -->
        @if(!$stats['is_member'])
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="bg-white/20 rounded-full p-3">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-bold text-xl">Become an APN Member Today!</h3>
                        <p class="text-indigo-100">Get access to exclusive events, networking opportunities, and more.</p>
                    </div>
                </div>
                <a href="{{ route('donor.membership') }}" class="bg-white text-indigo-600 px-6 py-3 rounded-lg font-semibold hover:bg-indigo-50 transition-colors">
                    Join Now
                </a>
            </div>
        </div>
        @endif

        <!-- Recent Donations Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800">Recent Donations</h2>
                <a href="{{ route('donor.transactions') }}" class="text-sm text-indigo-600 hover:text-indigo-900">View All →</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Receipt</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentDonations as $donation)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $donation->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                {{ substr($donation->transaction_id, 0, 8) }}...
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                ${{ number_format($donation->amount, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($donation->payment_status == 'success')
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Success
                                    </span>
                                @elseif($donation->payment_status == 'pending')
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
                                <button onclick="downloadReceipt('{{ $donation->transaction_id }}', {{ $donation->amount }}, '{{ $donation->created_at }}', '{{ $donation->payment_method ?? 'Card' }}')" 
                                        class="text-indigo-600 hover:text-indigo-900 font-medium">
                                    Download
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">
                                No donations found. 
                                <a href="{{ route('donate') }}" class="text-indigo-600 font-medium hover:underline">Make your first donation</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Logout Modal -->
<div x-data="{ showLogoutModal: false }" 
     @open-logout-modal.window="showLogoutModal = true"
     x-cloak>
    <div x-show="showLogoutModal" 
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">
        
        <div class="flex items-center justify-center min-h-screen px-4">
            <div x-show="showLogoutModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-black/40 backdrop-blur-sm"
                 @click="showLogoutModal = false">
            </div>
            <div x-show="showLogoutModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="relative bg-white rounded-2xl max-w-md w-full mx-auto shadow-2xl transform transition-all border border-gray-100">
                <div class="p-8 pt-10">
                    <div class="flex justify-center mb-4">
                        <div class="bg-gradient-to-br from-red-50 to-orange-50 rounded-2xl p-4">
                            <svg class="h-12 w-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </div>
                    </div>
                
                    <h3 class="text-xl font-bold text-center text-gray-900 mb-2">
                        Ready to logout?
                    </h3>
                    
                    <p class="text-gray-500 text-center mb-6 text-sm">
                        We'll miss you!<br>
                        Come back soon to see what's new.
                    </p>
                    
                    <div class="flex gap-3">
                        <button @click="showLogoutModal = false" 
                                class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all font-medium text-sm">
                            Cancel
                        </button>
                        
                     <form method="POST" action="{{ route('donor.logout') }}" class="flex-1" id="logoutForm">
    @csrf
    <button type="button" onclick="clearCookiesAndLogout()" class="w-full px-4 py-2.5 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-all font-medium text-sm shadow-md">
        Logout
    </button>
</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
  
function clearCookiesAndLogout() {
    document.cookie.split(';').forEach(function(cookie) {
        const name = cookie.split('=')[0].trim();
        document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=' + window.location.hostname + ';';
    });

    try { localStorage.clear(); } catch(e) {}
    try { sessionStorage.clear(); } catch(e) {}

    document.getElementById('logoutForm').submit();
}


    const donorData = {
        name: '{{ $donor->firstname }} {{ $donor->lastname }}',
        email: '{{ $donor->email }}',
        phone: '{{ $donor->phone ?? 'Not provided' }}',
    };

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
                    <title>Donation Receipt</title>
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
                            <div class="receipt-title">Donation Receipt</div>
                        </div>
                        
                        <div class="amount">$${parseFloat(amount).toFixed(2)}</div>
                        
                        <div class="details">
                            <div class="row"><span class="label">Transaction ID:</span><span class="value">${transactionId}</span></div>
                            <div class="row"><span class="label">Date:</span><span class="value">${formattedDate}</span></div>
                            <div class="row"><span class="label">Donor Name:</span><span class="value">${donorData.name}</span></div>
                            <div class="row"><span class="label">Donor Email:</span><span class="value">${donorData.email}</span></div>
                            <div class="row"><span class="label">Payment Method:</span><span class="value">${paymentMethod.charAt(0).toUpperCase() + paymentMethod.slice(1)}</span></div>
                            <div class="row"><span class="label">Status:</span><span class="value" style="color: #059669;">Success</span></div>
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