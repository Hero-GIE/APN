<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Welcome to APN Membership</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Open Sans', Arial, sans-serif;
            background-color: #f9fafb;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
            color: #1f2937;
        }
        
        /* Headings */
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Urbanist', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            font-weight: 700;
            line-height: 1.3;
            margin: 0 0 12px 0;
        }
        
        /* Container */
        .email-container {
            max-width: 600px;
            width: 100%;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        }
        
        /* Header */
        .header {
            background: linear-gradient(135deg, #000000 0%, #1a1a2e 100%);
            padding: 40px 30px;
            text-align: center;
        }
        
        .header-logo {
            max-width: 120px;
            width: 100%;
            height: auto;
            margin-bottom: 20px;
        }
        
        .header-brand {
            color: #dbeafe;
            font-size: 12px;
            letter-spacing: 3px;
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 12px;
        }
        
        .header-title {
            color: #ffffff;
            font-size: 28px;
            font-weight: 800;
            margin: 0;
            line-height: 1.2;
        }
        
        .header-sub {
            color: #dbeafe;
            font-size: 14px;
            margin-top: 12px;
            line-height: 1.4;
        }
        
        /* Content */
        .content {
            padding: 40px 35px;
            background: #ffffff;
        }
        
        /* Greeting */
        .greeting {
            font-size: 28px;
            color: #1f2937;
            margin-bottom: 16px;
            word-break: break-word;
        }
        
        .message {
            color: #6b7280;
            font-size: 16px;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        
        /* Membership Card */
        .membership-card {
            background: linear-gradient(135deg, #f0f9ff, #e6f0fa);
            border: 2px solid #bfdbfe;
            border-radius: 16px;
            padding: 28px;
            margin-bottom: 30px;
        }
        
        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .card-title {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #2563eb;
            margin-bottom: 6px;
        }
        
        .plan-name {
            font-size: 28px;
            font-weight: 800;
            color: #1f2937;
            word-break: break-word;
        }
        
        .status-badge {
            background: #2563eb;
            color: white;
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }
        
        .status-dot {
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            display: inline-block;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                opacity: 1;
                transform: scale(1);
            }
            50% {
                opacity: 0.6;
                transform: scale(1.2);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 16px;
            margin-top: 20px;
        }
        
        .info-box {
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 14px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .info-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        
        .info-label {
            font-size: 11px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }
        
        .info-value {
            font-size: 20px;
            font-weight: 700;
            color: #1f2937;
            word-break: break-word;
        }
        
        .info-value small {
            font-size: 12px;
            font-weight: normal;
            color: #6b7280;
        }
        
        /* Credentials Card */
        .credentials-card {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 30px;
            color: white;
        }
        
        .credentials-title {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 12px;
        }
        
        .credentials-sub {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 25px;
            line-height: 1.5;
        }
        
        .credential-box {
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.25);
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 14px;
            word-break: break-all;
        }
        
        .credential-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.8;
            margin-bottom: 6px;
        }
        
        .credential-value {
            font-family: 'SF Mono', 'Monaco', 'Inconsolata', monospace;
            font-size: 15px;
            word-break: break-all;
        }
        
        .credential-password {
            letter-spacing: 1px;
            font-size: 18px;
            font-weight: 600;
        }
        
        /* Button */
        .button {
            display: inline-block;
            background: white;
            color: #2563eb;
            padding: 14px 32px;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 15px;
            margin-top: 20px;
            transition: all 0.3s ease;
            text-align: center;
            width: auto;
            min-width: 200px;
        }
        
        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        
        .button:active {
            transform: translateY(0);
        }
        
        /* Security Notice */
        .security-notice {
            background: #eff6ff;
            border: 2px solid #bfdbfe;
            border-radius: 12px;
            padding: 18px 20px;
            margin-bottom: 30px;
        }
        
        .security-text {
            font-size: 13px;
            color: #1e40af;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            line-height: 1.5;
        }
        
        .security-icon {
            font-size: 20px;
            flex-shrink: 0;
        }
        
        /* Footer */
        .footer {
            background: #f9fafb;
            border-top: 2px solid #e5e7eb;
            padding: 30px 35px;
            text-align: center;
        }
        
        .footer-copyright {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 10px;
        }
        
        .footer-email {
            font-size: 13px;
            margin-bottom: 10px;
        }
        
        .footer-email a {
            color: #3b82f6;
            text-decoration: none;
            transition: color 0.2s ease;
        }
        
        .footer-email a:hover {
            color: #2563eb;
            text-decoration: underline;
        }
        
        .footer-note {
            font-size: 11px;
            color: #9ca3af;
            line-height: 1.4;
        }
        
        /* Impact Quote */
        .impact-quote {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
        }
        
        .quote-text {
            color: #6b7280;
            font-style: italic;
            margin-bottom: 8px;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .quote-author {
            color: #3b82f6;
            font-size: 12px;
            font-weight: 600;
        }
        
        /* Responsive Design */
        @media screen and (max-width: 600px) {
            body {
                padding: 10px;
            }
            
            .email-container {
                border-radius: 16px;
            }
            
            .header {
                padding: 30px 20px;
            }
            
            .header-title {
                font-size: 24px;
            }
            
            .header-sub {
                font-size: 13px;
            }
            
            .content {
                padding: 25px 20px;
            }
            
            .greeting {
                font-size: 24px;
                margin-bottom: 12px;
            }
            
            .message {
                font-size: 15px;
                margin-bottom: 25px;
            }
            
            .membership-card {
                padding: 20px;
                margin-bottom: 25px;
            }
            
            .card-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .plan-name {
                font-size: 24px;
            }
            
            .status-badge {
                align-self: flex-start;
                white-space: normal;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }
            
            .info-box {
                padding: 12px;
            }
            
            .info-value {
                font-size: 18px;
            }
            
            .credentials-card {
                padding: 20px;
                margin-bottom: 25px;
            }
            
            .credentials-title {
                font-size: 16px;
            }
            
            .credential-password {
                font-size: 16px;
            }
            
            .button {
                padding: 12px 24px;
                font-size: 14px;
                min-width: 180px;
                width: 100%;
                max-width: 280px;
            }
            
            .security-text {
                font-size: 12px;
                flex-direction: column;
                text-align: center;
                gap: 8px;
            }
            
            .security-icon {
                font-size: 24px;
            }
            
            .footer {
                padding: 25px 20px;
            }
            
            .impact-quote {
                margin-top: 25px;
            }
            
            .quote-text {
                font-size: 13px;
            }
        }
        
        /* Extra small devices */
        @media screen and (max-width: 380px) {
            .header-title {
                font-size: 20px;
            }
            
            .greeting {
                font-size: 20px;
            }
            
            .plan-name {
                font-size: 20px;
            }
            
            .info-value {
                font-size: 16px;
            }
            
            .credential-password {
                font-size: 14px;
            }
        }
        
        /* Print styles */
        @media print {
            body {
                background-color: white;
                padding: 0;
            }
            
            .button {
                display: none;
            }
            
            .status-badge {
                background: #e5e7eb;
                color: #1f2937;
            }
        }
        
        /* Accessibility */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
        
        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            @media screen and (max-width: 600px) {
                body {
                    background-color: #1a1a2e;
                }
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        
        <!-- Header -->
        <div class="header">
            <img src="{{url('images/logo/apn-membership.png')}}" class="header-logo" alt="APN Logo" width="100" height="auto">
            <div class="header-brand">Africa Prosperity Network</div>
            <h1 class="header-title">Welcome to APN Membership</h1>
            <p class="header-sub">Your membership is building a prosperous Africa</p>
        </div>
        
        <!-- Content -->
        <div class="content">
            
            <h2 class="greeting">Welcome, {{ $member->firstname ?? $member->donor->firstname ?? 'Member' }}! 🎉</h2>
            
            <p class="message">
                @if(isset($password) && $password)
                    Thank you for becoming an APN Member! Your membership has been successfully activated and you now have access to exclusive member benefits.
                @else
                    Thank you for your continued membership with APN. Your support is helping build a prosperous Africa.
                @endif
            </p>
            
            @if(isset($membership) && $membership)
            <!-- Membership Card -->
            <div class="membership-card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Membership Activated</div>
                        <div class="plan-name">{{ ucfirst($membership->membership_type) }} Plan</div>
                    </div>
                    <div class="status-badge">
                        <span class="status-dot"></span>
                        ACTIVE
                    </div>
                </div>
                
                <div class="info-grid">
                    <div class="info-box">
                        <div class="info-label">Amount</div>
                        <div class="info-value">${{ number_format($membership->amount ?? 350, 2) }}</div>
                    </div>
                    <div class="info-box">
                        <div class="info-label">Valid Until</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($membership->end_date)->format('M d, Y') }}</div>
                    </div>
                    <div class="info-box">
                        <div class="info-label">Member Since</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($membership->start_date)->format('M d, Y') }}</div>
                    </div>
                    <div class="info-box">
                        <div class="info-label">Days Remaining</div>
                        <div class="info-value">{{ $membership->daysLeft() }} <small>days</small></div>
                    </div>
                </div>
                
                @if(isset($membership->transaction_id))
                <div style="margin-top: 20px; padding-top: 15px; border-top: 2px solid #e5e7eb;">
                    <div class="info-label">Transaction Reference</div>
                    <div style="font-family: monospace; font-size: 13px; color: #1f2937; word-break: break-all;">{{ $membership->transaction_id }}</div>
                </div>
                @endif
            </div>
            @endif
            
            @if(isset($password) && $password)
            <!-- Login Credentials -->
            <div class="credentials-card">
                <div class="credentials-title">🔐 Your Secure Login Credentials</div>
                <p class="credentials-sub">Use these details to access your member dashboard</p>
                
                <div class="credential-box">
                    <div class="credential-label">Email Address</div>
                    <div class="credential-value">{{ $member->email ?? $member->donor->email }}</div>
                </div>
                
                <div class="credential-box">
                    <div class="credential-label">Temporary Password</div>
                    <div class="credential-value credential-password">{{ $password }}</div>
                </div>
                
                <div style="text-align: center;">
                    <a href="{{ route('donor.login') }}" class="button">
                        Login to Your Account →
                    </a>
                </div>
            </div>
            
            <!-- Security Notice -->
            <div class="security-notice">
                <div class="security-text">
                    <span class="security-icon">🔒</span>
                    <span><strong>Security tip:</strong> For your safety, please log in and change your password immediately. Never share your credentials with anyone.</span>
                </div>
            </div>
            @endif
            
            <!-- Impact Quote -->
            <div class="impact-quote">
                <p class="quote-text">"Alone we can do so little; together we can do so much."</p>
                <p class="quote-author">— Building Africa's Prosperity, Together —</p>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p class="footer-copyright">© {{ date('Y') }} Africa Prosperity Network · All rights reserved</p>
            <p class="footer-email">
                <a href="mailto:membership@africaprosperitynetwork.com">membership@africaprosperitynetwork.com</a>
            </p>
            <p class="footer-note">
                ✦ This is an automated email. Please do not reply directly. ✦
            </p>
        </div>
        
    </div>
</body>
</html>