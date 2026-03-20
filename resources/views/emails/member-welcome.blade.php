<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to APN Membership</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700;800&family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700;800&family=Open+Sans:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Open Sans', sans-serif;
        }
        h1, h2, h3, h4, h5, h6, .font-urbanist {
            font-family: 'Urbanist', sans-serif !important;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
        }
        @keyframes pulse {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-pulse-slow {
            animation: pulse 4s ease-in-out infinite;
        }
        .animate-rotate {
            animation: rotate 20s linear infinite;
        }
        .bg-gradient-primary {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 60%, #60a5fa 100%);
        }
        .bg-gradient-card {
            background: linear-gradient(135deg, #f0f9ff, #e6f0fa);
        }
        .bg-gradient-credentials {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
        }
    </style>
</head>
<body class="bg-slate-50 p-5 m-0">
    <div class="email-container">

        <!-- Header with gradient -->
        <div class="bg-gradient-primary px-8 py-10 text-center relative overflow-hidden rounded-t-2xl">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_50%,rgba(255,255,255,0.2)_0%,transparent_50%)] animate-pulse-slow"></div>
            <div class="relative">
                <p class="text-blue-100 text-xs tracking-[3px] uppercase font-bold mb-2">✦ APN MEMBERSHIP ✦</p>
                <h1 class="text-white text-3xl font-urbanist font-extrabold tracking-tight mb-1">Africa Prosperity Network</h1>
                <p class="text-blue-100 text-sm font-['Open_Sans']">Your membership is building a prosperous Africa</p>
            </div>
        </div>

        <!-- Body -->
        <div class="bg-white px-8 py-10">

            <h2 class="font-urbanist text-2xl font-bold text-slate-800 mb-4">Welcome, {{ $member->firstname }}! 🎉</h2>
            
            <p class="text-slate-500 text-[15px] mb-8 leading-relaxed font-['Open_Sans']">
                @if(isset($password) && $password)
                    Thank you for becoming an APN Member! Your membership has been successfully activated and you now have access to exclusive member benefits. Below is a summary of your membership and your secure login credentials.
                @else
                    Thank you for your continued membership with APN. Your support is helping build a prosperous Africa.
                @endif
            </p>

            @if(isset($membership) && $membership)
            <!-- Membership Card -->
            <div class="bg-gradient-card border-2 border-blue-200 rounded-xl p-7 mb-8 transition-all hover:border-blue-500">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <div class="text-xs font-bold tracking-wider uppercase text-blue-600 mb-1">Membership Activated</div>
                        <div class="font-urbanist text-3xl font-extrabold text-slate-800">{{ ucfirst($membership->membership_type) }} Plan</div>
                    </div>
                    <div class="bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-semibold">
                        <span class="w-2 h-2 bg-green-400 rounded-full inline-block mr-1"></span>
                        ACTIVE
                    </div>
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-2 gap-4 mt-5">
                    <div class="bg-white border-2 border-slate-200 rounded-lg p-3">
                        <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Amount</div>
                        <div class="font-urbanist text-lg font-bold text-slate-800">${{ number_format($membership->amount, 2) }}</div>
                    </div>
                    <div class="bg-white border-2 border-slate-200 rounded-lg p-3">
                        <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Valid Until</div>
                        <div class="font-urbanist text-lg font-bold text-slate-800">{{ \Carbon\Carbon::parse($membership->end_date)->format('M d, Y') }}</div>
                    </div>
                    <div class="bg-white border-2 border-slate-200 rounded-lg p-3">
                        <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Member Since</div>
                        <div class="font-urbanist text-lg font-bold text-slate-800">{{ \Carbon\Carbon::parse($membership->start_date)->format('M d, Y') }}</div>
                    </div>
                    <div class="bg-white border-2 border-slate-200 rounded-lg p-3">
                        <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Days Remaining</div>
                        <div class="font-urbanist text-lg font-bold text-slate-800">{{ $membership->daysLeft() }} <span class="text-sm font-normal text-slate-500">days</span></div>
                    </div>
                </div>

                @if(isset($membership->transaction_id))
                <div class="mt-4 pt-4 border-t-2 border-slate-200">
                    <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Transaction Reference</div>
                    <div class="font-mono text-sm text-slate-800">{{ $membership->transaction_id }}</div>
                </div>
                @endif 
            </div>
            @endif

            <!-- Login Credentials Card -->
            @if(isset($password) && $password)
            <div class="bg-gradient-credentials rounded-xl p-8 mb-8 relative overflow-hidden">
                <div class="absolute top-[-50%] right-[-50%] w-[200%] h-[200%] bg-[radial-gradient(circle,rgba(255,255,255,0.15)_0%,transparent_70%)] animate-rotate"></div>
                <div class="relative">
                    <div class="font-urbanist text-blue-100 text-base font-bold tracking-wider uppercase mb-2">🔐 Your Secure Login Credentials</div>
                    <p class="text-blue-100 text-sm mb-6 opacity-90">Use these details to access your member dashboard</p>

                    <div class="bg-white/15 border-2 border-white/25 rounded-lg p-4 mb-3 backdrop-blur-sm">
                        <div class="text-blue-100 text-xs uppercase tracking-wider mb-1">Email Address</div>
                        <div class="text-white font-mono text-base">{{ $member->email }}</div>
                    </div>

                    <div class="bg-white/15 border-2 border-white/25 rounded-lg p-4 mb-3 backdrop-blur-sm">
                        <div class="text-blue-100 text-xs uppercase tracking-wider mb-1">Temporary Password</div>
                        <div class="text-white font-mono text-lg tracking-[3px]">{{ $password }}</div>
                    </div>

                    <div class="text-center mt-6">
                        <a href="{{ route('donor.login') }}" class="inline-block bg-white text-blue-600 px-10 py-3 rounded-lg font-urbanist font-bold text-sm shadow-lg hover:-translate-y-0.5 hover:shadow-blue-300/30 transition-all">
                            LOGIN TO YOUR ACCOUNT →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Security notice -->
            <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-5 mb-8">
                <p class="text-sm text-blue-900 m-0 flex items-center gap-3">
                    <span class="text-lg">🔒</span>
                    <span><strong class="font-urbanist">Security tip:</strong> For your safety, please log in and change your password immediately. Never share your credentials with anyone.</span>
                </p>
            </div>
            @endif

            <!-- Impact Message -->
            <div class="text-center mt-8 pt-5 border-t-2 border-slate-200">
                <p class="text-slate-500 text-sm mb-1 italic">
                    "Alone we can do so little; together we can do so much."
                </p>
                <p class="text-blue-600 text-xs font-urbanist font-semibold m-0">
                    — Building Africa's Prosperity, Together —
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-slate-50 border-t-2 border-slate-200 px-8 py-6 text-center rounded-b-2xl">
            <p class="text-xs text-slate-500 mb-2">© {{ date('Y') }} Africa Prosperity Network · All rights reserved</p>
            <p class="text-sm mb-2">
                <a href="mailto:membership@africaprosperitynetwork.com" class="text-blue-600 font-medium no-underline hover:underline">membership@africaprosperitynetwork.com</a>
            </p>
            <p class="text-[11px] text-slate-400 m-0">
                <span class="text-blue-600">✦</span> This is an automated email. Please do not reply directly. <span class="text-blue-600">✦</span>
            </p>
        </div>

    </div>
</body>
</html>