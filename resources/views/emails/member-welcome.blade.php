<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to APN Membership</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=Lora:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', 'Lora', Arial, sans-serif; }
        .font-syne { font-family: 'Syne', sans-serif; }
        .font-lora { font-family: 'Lora', serif; }
        .font-inter { font-family: 'Inter', sans-serif; }
        
        @keyframes pulse {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }
        .animate-pulse-slow { animation: pulse 4s ease-in-out infinite; }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-rotate { animation: rotate 20s linear infinite; }
    </style>
</head>
<body class="bg-slate-100 p-5 m-0">
    <div class="max-w-[600px] mx-auto bg-white rounded-xl overflow-hidden shadow-[0_25px_50px_-12px_rgba(0,0,0,0.25)]">

        <!-- Header with gradient and orb effect (matching donor page) -->
        <div class="bg-gradient-to-r from-[#3730a3] via-[#4f46e5] to-[#6366f1] px-8 py-10 text-center relative overflow-hidden">
            <div class="absolute inset-0 animate-pulse-slow" 
                 style="background: radial-gradient(circle at 30% 50%, rgba(255,255,255,0.1) 0%, transparent 50%);"></div>
            <div class="relative">
                <div class="text-[#c7d2fe] text-[11px] tracking-[3px] uppercase font-bold mb-2.5">✦ APN MEMBERSHIP ✦</div>
                <h1 class="font-syne text-white text-[28px] font-extrabold tracking-tight m-0">Africa Prosperity Network</h1>
                <p class="text-[#c7d2fe] text-sm font-lora mt-2 m-0">Your membership is building a prosperous Africa</p>
            </div>
        </div>

        <!-- Body -->
        <div class="p-10 bg-white">

            <!-- Greeting with dynamic message -->
            <h2 class="font-syne text-[22px] font-bold text-[#1a1f36] mb-4">Welcome, {{ $member->firstname }}! 🎉</h2>
            
            <p class="text-[#64748b] text-[15px] leading-relaxed mb-8">
                @if(isset($password) && $password)
                    Thank you for becoming an APN Member! Your membership has been successfully activated and you now have access to exclusive member benefits. Below is a summary of your membership and your secure login credentials.
                @else
                    Thank you for your continued membership with APN. Your support is helping build a prosperous Africa.
                @endif
            </p>

            <!-- Membership Summary Card (matching donor card style) -->
            @if(isset($membership) && $membership)
            <div class="bg-gradient-to-br from-slate-50 to-slate-100 border-2 border-slate-200 rounded-xl p-7 mb-8 hover:border-[#4f46e5] transition-all duration-300">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-indigo-100 rounded-full mr-4">
                            <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-[#4f46e5] text-xs font-bold tracking-wider uppercase mb-1">Membership Activated</div>
                            <div class="font-syne text-2xl font-bold text-[#1a1f36]">{{ ucfirst($membership->membership_type) }} Plan</div>
                        </div>
                    </div>
                    <div class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold flex items-center">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-1 animate-pulse"></span>
                        ACTIVE
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white rounded-lg p-4 border border-slate-200">
                        <p class="text-xs text-slate-500 mb-1">Amount</p>
                        <p class="font-syne text-xl font-bold text-[#1a1f36]">${{ number_format($membership->amount, 2) }}</p>
                    </div>
                    <div class="bg-white rounded-lg p-4 border border-slate-200">
                        <p class="text-xs text-slate-500 mb-1">Valid Until</p>
                        <p class="font-syne text-xl font-bold text-[#1a1f36]">{{ \Carbon\Carbon::parse($membership->end_date)->format('M d, Y') }}</p>
                    </div>
                    <div class="bg-white rounded-lg p-4 border border-slate-200">
                        <p class="text-xs text-slate-500 mb-1">Member Since</p>
                        <p class="font-syne text-xl font-bold text-[#1a1f36]">{{ \Carbon\Carbon::parse($membership->start_date)->format('M d, Y') }}</p>
                    </div>
                    <div class="bg-white rounded-lg p-4 border border-slate-200">
                        <p class="text-xs text-slate-500 mb-1">Days Remaining</p>
                        <p class="font-syne text-xl font-bold text-[#1a1f36]">{{ $membership->daysLeft() }} days</p>
                    </div>
                </div>

                <!-- Transaction Reference -->
                @if(isset($membership->transaction_id))
                <div class="mt-4 pt-4 border-t border-slate-200">
                    <p class="text-xs text-slate-500 mb-1">Transaction Reference</p>
                    <p class="text-sm font-mono text-slate-700">{{ $membership->transaction_id }}</p>
                </div>
                @endif
            </div>
            @endif

            <!-- Login Credentials Card (matching donor page style) -->
            @if(isset($password) && $password)
            <div class="bg-gradient-to-br from-[#3730a3] to-[#4f46e5] rounded-2xl p-8 mb-8 relative overflow-hidden">
                <div class="absolute top-[-50%] right-[-50%] w-[200%] h-[200%] animate-rotate"
                     style="background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);"></div>
                <div class="relative">
                    <div class="flex items-center mb-6">
                        <div class="bg-white/20 rounded-full p-3 mr-4">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-[#c7d2fe] text-sm font-bold tracking-wider uppercase mb-1">🔐 Your Secure Login Credentials</div>
                            <p class="text-[#c7d2fe] text-sm opacity-90">Use these details to access your member dashboard</p>
                        </div>
                    </div>

                    <div class="bg-white/10 border-2 border-white/20 rounded-lg p-5 mb-4 backdrop-blur-sm">
                        <p class="text-[#a5b4fc] text-xs uppercase tracking-wider mb-1">Email Address</p>
                        <p class="text-white text-lg font-mono break-all">{{ $member->email }}</p>
                    </div>

                    <div class="bg-white/10 border-2 border-white/20 rounded-lg p-5 mb-6 backdrop-blur-sm">
                        <p class="text-[#a5b4fc] text-xs uppercase tracking-wider mb-1">Temporary Password</p>
                        <p class="text-white text-2xl font-mono tracking-[4px] break-all">{{ $password }}</p>
                    </div>

                    <div class="bg-yellow-400/20 border border-yellow-400/30 rounded-lg p-4 mb-6">
                        <p class="text-yellow-100 text-sm flex items-start">
                            <svg class="h-5 w-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <span><strong>Security tip:</strong> For your safety, please log in and change your password immediately. Never share your credentials with anyone.</span>
                        </p>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('member.dashboard') }}" class="inline-block bg-white text-[#4f46e5] px-10 py-4 rounded-full font-syne font-bold text-sm no-underline shadow-[0_10px_15px_-3px_rgba(0,0,0,0.2)] hover:-translate-y-0.5 hover:shadow-[0_20px_25px_-5px_rgba(0,0,0,0.3)] transition-all duration-300">
                            Go to Member Dashboard →
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Member Benefits Preview (enhanced from donor page) -->
            <div class="mb-8">
                <h3 class="font-syne text-lg font-bold text-[#1a1f36] mb-4">Your Member Benefits Include:</h3>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex items-start space-x-3">
                        <div class="bg-green-100 rounded-lg p-2 flex-shrink-0">
                            <svg class="h-4 w-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 text-sm">Event Discounts</p>
                            <p class="text-xs text-gray-500">10% off all APN events</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="bg-green-100 rounded-lg p-2 flex-shrink-0">
                            <svg class="h-4 w-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 text-sm">Priority Registration</p>
                            <p class="text-xs text-gray-500">Early access to events</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="bg-green-100 rounded-lg p-2 flex-shrink-0">
                            <svg class="h-4 w-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 text-sm">Member Directory</p>
                            <p class="text-xs text-gray-500">Exclusive networking</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="bg-green-100 rounded-lg p-2 flex-shrink-0">
                            <svg class="h-4 w-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 text-sm">APN Magazine</p>
                            <p class="text-xs text-gray-500">Digital access included</p>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <a href="{{ route('member.benefits') }}" class="text-[#4f46e5] text-sm font-semibold hover:underline">
                        View All Member Benefits →
                    </a>
                </div>
            </div>

            <!-- Impact Message (matching donor page) -->
            <div class="text-center mt-8 pt-6 border-t-2 border-slate-200">
                <p class="text-[#64748b] text-sm italic mb-2">
                    "Alone we can do so little; together we can do so much."
                </p>
                <p class="text-[#4f46e5] text-xs font-semibold">
                    — Building Africa's Prosperity, Together —
                </p>
            </div>
        </div>

        <!-- Footer (matching donor page) -->
        <div class="bg-slate-50 border-t-2 border-slate-200 px-9 py-8 text-center">
            <p class="text-xs text-slate-500 mb-2">© {{ date('Y') }} Africa Prosperity Network · All rights reserved</p>
            <p class="text-sm mb-2">
                <a href="mailto:membership@africaprosperitynetwork.com" class="text-[#4f46e5] no-underline hover:underline font-medium">
                    membership@africaprosperitynetwork.com
                </a>
            </p>
            <p class="text-[11px] text-slate-400">
                <span class="text-[#4f46e5] mx-1">✦</span> This is an automated email. Please do not reply directly. <span class="text-[#4f46e5] mx-1">✦</span>
            </p>
        </div>

    </div>
</body>
</html>