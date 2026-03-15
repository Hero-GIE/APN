<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to APN Membership</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=Lora:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', 'Lora', Arial, sans-serif;
            line-height: 1.7;
            color: #1a1f36;
            background: #f1f5f9;
            margin: 0;
            padding: 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
        }
        .header {
            background: linear-gradient(135deg, #3730a3 0%, #4f46e5 60%, #6366f1 100%);
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 50%, rgba(255,255,255,0.1) 0%, transparent 50%);
            animation: pulse 4s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }
        .header-brand {
            margin: 0 0 10px;
            font-size: 11px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #c7d2fe;
            font-weight: 700;
            position: relative;
        }
        .header-title {
            color: white;
            margin: 0;
            font-family: 'Syne', sans-serif;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.5px;
            position: relative;
        }
        .header-sub {
            color: #c7d2fe;
            margin: 8px 0 0;
            font-size: 14px;
            font-family: 'Lora', serif;
            position: relative;
        }
        .content {
            padding: 40px 35px;
            background: white;
        }
        .greeting {
            font-family: 'Syne', sans-serif;
            font-size: 22px;
            font-weight: 700;
            color: #1a1f36;
            margin: 0 0 15px;
        }
        .greeting-message {
            color: #64748b;
            font-size: 15px;
            margin: 0 0 30px;
            line-height: 1.7;
        }
        .membership-card {
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 28px;
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }
        .membership-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .membership-badge {
            background: #4f46e5;
            color: white;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .membership-label {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #4f46e5;
            margin: 0 0 5px;
        }
        .membership-type {
            font-family: 'Syne', sans-serif;
            font-size: 32px;
            font-weight: 800;
            color: #1a1f36;
            line-height: 1;
            margin: 0;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 20px;
        }
        .info-box {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px;
        }
        .info-label {
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0 0 4px;
        }
        .info-value {
            font-family: 'Syne', sans-serif;
            font-size: 18px;
            font-weight: 700;
            color: #1a1f36;
            margin: 0;
        }
        .info-value small {
            font-size: 12px;
            color: #64748b;
            font-weight: normal;
        }
        .credentials-card {
            background: linear-gradient(135deg, #3730a3, #4f46e5);
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }
        .credentials-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .credentials-title {
            color: #c7d2fe;
            font-family: 'Syne', sans-serif;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin: 0 0 10px;
            position: relative;
        }
        .credentials-sub {
            color: #c7d2fe;
            font-size: 14px;
            margin: 0 0 25px;
            opacity: 0.9;
            position: relative;
        }
        .credential-box {
            background: rgba(255,255,255,0.1);
            border: 2px solid rgba(255,255,255,0.2);
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 12px;
            position: relative;
            backdrop-filter: blur(10px);
        }
        .credential-label {
            color: #a5b4fc;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0 0 4px;
        }
        .credential-value {
            color: white !important;
            font-size: 16px;
            font-family: monospace;
            margin: 0;
            font-weight: 500;
            word-break: break-all;
        }
        .credential-value.password {
            letter-spacing: 3px;
            font-size: 18px;
        }
        .login-button {
            display: inline-block;
            background: white;
            color: #4f46e5;
            padding: 14px 40px;
            text-decoration: none;
            border-radius: 40px;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 15px;
            margin-top: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.2);
            position: relative;
            overflow: hidden;
        }
        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.3);
        }
        .security-notice {
            background: #e8f0fe;
            border: 2px solid #c7d2fe;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 30px;
        }
        .security-notice p {
            font-size: 13px;
            color: #1e3a8a;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .security-notice i {
            font-style: normal;
            font-size: 16px;
        }
        .benefits-preview {
            margin: 30px 0;
        }
        .benefits-title {
            font-family: 'Syne', sans-serif;
            font-size: 18px;
            font-weight: 700;
            color: #1a1f36;
            margin: 0 0 15px;
        }
        .benefits-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        .benefit-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .benefit-icon {
            background: #e8f0fe;
            border-radius: 8px;
            padding: 6px;
            display: inline-flex;
        }
        .benefit-icon svg {
            width: 16px;
            height: 16px;
            color: #4f46e5;
        }
        .benefit-text {
            font-size: 13px;
            color: #1a1f36;
            margin: 0;
        }
        .benefit-text small {
            font-size: 11px;
            color: #64748b;
            display: block;
        }
        .footer {
            background: #f8fafc;
            border-top: 2px solid #e2e8f0;
            padding: 30px 35px;
            text-align: center;
        }
        .footer-copyright {
            font-size: 12px;
            color: #64748b;
            margin: 0 0 8px;
        }
        .footer-email {
            font-size: 13px;
            margin: 0 0 8px;
        }
        .footer-email a {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 500;
        }
        .footer-email a:hover {
            text-decoration: underline;
        }
        .footer-auto {
            font-size: 11px;
            color: #94a3b8;
            margin: 0;
        }
        .footer-auto i {
            font-style: normal;
            color: #4f46e5;
            margin: 0 4px;
        }
    </style>
</head>
<body>
    <div class="email-container">

        {{-- Header with gradient and orb effect --}}
        <div class="header">
            <div class="header-brand">✦ APN MEMBERSHIP ✦</div>
            <h1 class="header-title">Africa Prosperity Network</h1>
            <p class="header-sub">Your membership is building a prosperous Africa</p>
        </div>

        {{-- Body --}}
        <div class="content">

            {{-- Greeting with dynamic message --}}
            <h2 class="greeting">Welcome, {{ $member->donor->firstname ?? $member->firstname ?? 'Valued Member' }}! 🎉</h2>
            
            <p class="greeting-message">
                @if(isset($password) && $password)
                    Thank you for becoming an APN Member! Your membership has been successfully activated and you now have access to exclusive member benefits. Below is a summary of your membership and your secure login credentials.
                @else
                    Thank you for your continued membership with APN. Your support is helping build a prosperous Africa.
                @endif
            </p>

            {{-- Membership Summary Card --}}
            @if(isset($member))
            <div class="membership-card">
                <div class="membership-header">
                    <div>
                        <div class="membership-label">Membership Activated</div>
                        <div class="membership-type">{{ ucfirst($member->membership_type) }} Plan</div>
                    </div>
                    <div class="membership-badge">
                        <span class="w-2 h-2 bg-green-500 rounded-full inline-block mr-1" style="background: #10b981; width: 8px; height: 8px; border-radius: 50%; display: inline-block;"></span>
                        ACTIVE
                    </div>
                </div>

                <div class="info-grid">
                    <div class="info-box">
                        <div class="info-label">Amount</div>
                        <div class="info-value">${{ number_format($member->price ?? 0, 2) }}</div>
                    </div>
                    <div class="info-box">
                        <div class="info-label">Valid Until</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($member->end_date)->format('M d, Y') }}</div>
                    </div>
                    <div class="info-box">
                        <div class="info-label">Member Since</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($member->start_date)->format('M d, Y') }}</div>
                    </div>
                    <div class="info-box">
                        <div class="info-label">Days Remaining</div>
                        <div class="info-value">{{ $member->daysLeft() }} <small>days</small></div>
                    </div>
                </div>

                @if(isset($transaction_id))
                <div style="margin-top: 15px; padding-top: 15px; border-top: 2px solid #e2e8f0;">
                    <div class="info-label">Transaction Reference</div>
                    <div style="font-family: monospace; font-size: 13px; color: #1a1f36;">{{ $transaction_id }}</div>
                </div>
                @endif
            </div>
            @endif

            {{-- Login Credentials for new members --}}
            @if(isset($password) && $password)
            <div class="credentials-card">
                <div class="credentials-title">🔐 Your Secure Login Credentials</div>
                <p class="credentials-sub">Use these details to access your member dashboard:</p>

                <div class="credential-box">
                    <div class="credential-label">Email Address</div>
                    <div class="credential-value">{{ $member->donor->email ?? $member->email }}</div>
                </div>

                <div class="credential-box">
                    <div class="credential-label">Temporary Password</div>
                    <div class="credential-value password">{{ $password }}</div>
                </div>

                <div style="text-align: center;">
                    <a href="{{ route('member.dashboard') }}" class="login-button">
                        Go to Member Dashboard →
                    </a>
                </div>
            </div>

            {{-- Security notice --}}
            <div class="security-notice">
                <p>
                    <i>🔒</i>
                    <span><strong>Security tip:</strong> For your safety, please log in and change your password immediately. Never share your credentials with anyone.</span>
                </p>
            </div>
            @endif

            {{-- Member Benefits Preview --}}
            <div class="benefits-preview">
                <h3 class="benefits-title">Your Member Benefits Include:</h3>
                
                <div class="benefits-grid">
                    <div class="benefit-item">
                        <span class="benefit-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </span>
                        <div>
                            <div class="benefit-text">Event Discounts</div>
                            <small>10% off all APN events</small>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <span class="benefit-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </span>
                        <div>
                            <div class="benefit-text">Priority Registration</div>
                            <small>Early access to events</small>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <span class="benefit-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </span>
                        <div>
                            <div class="benefit-text">Member Directory</div>
                            <small>Exclusive networking</small>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <span class="benefit-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </span>
                        <div>
                            <div class="benefit-text">APN Magazine</div>
                            <small>Digital access included</small>
                        </div>
                    </div>
                </div>

                <div style="text-align: center; margin-top: 20px;">
                    <a href="{{ route('member.benefits') }}" style="color: #4f46e5; font-size: 13px; font-weight: 600; text-decoration: none;">
                        View All Member Benefits →
                    </a>
                </div>
            </div>

            {{-- Impact message --}}
            <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 2px solid #e2e8f0;">
                <p style="color: #64748b; font-size: 14px; margin: 0 0 5px; font-style: italic;">
                    "Alone we can do so little; together we can do so much."
                </p>
                <p style="color: #4f46e5; font-size: 12px; font-weight: 600; margin: 0;">
                    — Building Africa's Prosperity, Together —
                </p>
            </div>
        </div>

        {{-- Footer --}}
        <div class="footer">
            <p class="footer-copyright">© {{ date('Y') }} Africa Prosperity Network · All rights reserved</p>
            <p class="footer-email">
                <a href="mailto:membership@africaprosperitynetwork.com">membership@africaprosperitynetwork.com</a>
            </p>
            <p class="footer-auto">
                <i>✦</i> This is an automated email. Please do not reply directly. <i>✦</i>
            </p>
        </div>

    </div>
</body>
</html>