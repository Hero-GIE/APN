<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Africa Prosperity Network</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=Lora:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', 'Lora', Arial, sans-serif;
            line-height: 1.7;
            color: #1e293b;
            background: #f8fafc;
            margin: 0;
            padding: 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.15);
        }
        .header {
            background: linear-gradient(135deg, #5b4bc4 0%, #6d5fd6 60%, #7f71e8 100%);
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
            background: radial-gradient(circle at 30% 50%, rgba(255,255,255,0.2) 0%, transparent 50%);
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
            color: #e0e7ff;
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
            color: #e0e7ff;
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
            color: #1e293b;
            margin: 0 0 15px;
        }
        .greeting-message {
            color: #64748b;
            font-size: 15px;
            margin: 0 0 30px;
            line-height: 1.7;
        }
        .donation-card {
            background: linear-gradient(135deg, #fafcff, #f5f7fa);
            border: 2px solid #e9edf2;
            border-radius: 12px;
            padding: 28px;
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }
        .donation-card:hover {
            border-color: #8b7cf0;
        }
        .donation-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .donation-badge {
            background: #8b7cf0;
            color: white;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .donation-label {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #8b7cf0;
            margin: 0 0 5px;
        }
        .donation-amount {
            font-family: 'Syne', sans-serif;
            font-size: 48px;
            font-weight: 800;
            color: #1e293b;
            line-height: 1;
            margin: 20px 0 12px;
            text-align: center;
        }
        .donation-amount small {
            font-size: 24px;
            color: #64748b;
        }
        .donation-ref {
            font-size: 13px;
            color: #64748b;
            background: white;
            display: inline-block;
            padding: 6px 16px;
            border-radius: 30px;
            border: 2px solid #e9edf2;
            font-family: monospace;
            margin: 10px 0;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 20px;
        }
        .info-box {
            background: white;
            border: 2px solid #e9edf2;
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
            font-size: 16px;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }
        .credentials-card {
            background: linear-gradient(135deg, #8b7cf0, #6d5fd6);
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
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .credentials-title {
            color: #e0e7ff;
            font-family: 'Syne', sans-serif;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin: 0 0 10px;
            position: relative;
        }
        .credentials-sub {
            color: #e0e7ff;
            font-size: 14px;
            margin: 0 0 25px;
            opacity: 0.9;
            position: relative;
        }
        .credential-box {
            background: rgba(255,255,255,0.15);
            border: 2px solid rgba(255,255,255,0.25);
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 12px;
            position: relative;
            backdrop-filter: blur(10px);
        }
        .credential-label {
            color: #e0e7ff;
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
            color: #6d5fd6;
            padding: 14px 40px;
            text-decoration: none;
            border-radius: 10px;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 15px;
            margin-top: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }
        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(109, 95, 214, 0.3);
        }
        .security-notice {
            background: #f0f3fe;
            border: 2px solid #d9e0fc;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 30px;
        }
        .security-notice p {
            font-size: 13px;
            color: #3b4b8c;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .footer {
            background: #fafcff;
            border-top: 2px solid #e9edf2;
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
            color: #8b7cf0;
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
            color: #8b7cf0;
            margin: 0 4px;
        }
    </style>
</head>
<body>
    <div class="email-container">

        <!-- Header with gradient and orb effect (lighter colors) -->
        <div class="header">
            <div class="header-brand">✦ APN DONATION ✦</div>
            <h1 class="header-title">Africa Prosperity Network</h1>
            <p class="header-sub">Your generosity is building a prosperous Africa</p>
        </div>

        <!-- Body -->
        <div class="content">

            <!-- Greeting with dynamic message -->
            <h2 class="greeting">Thank you, {{ $donor->firstname }}! 🎉</h2>
            
            <p class="greeting-message">
                @if(isset($password) && $password)
                    Your donation has been received and your APN account has been created. Below is a summary of your contribution and your secure login credentials.
                @else
                    Thank you for your continued support. Your donation has been received successfully and is making a real difference.
                @endif
            </p>

            <!-- Donation Summary Card -->
            @if(isset($donation))
            <div class="donation-card">
                <div class="text-center">
                    <div class="donation-label">Donation Received</div>
                    <div class="donation-amount">
                        {{ $donation->currency }} {{ number_format($donation->amount, 2) }}
                        <small>one-time</small>
                    </div>
                    <div class="donation-ref">
                        Ref: {{ $donation->transaction_id }}
                    </div>
                    @if(isset($donation->payment_method))
                    <p style="margin: 15px 0 0; font-size: 12px; color: #64748b;">
                        Paid via {{ ucfirst($donation->payment_method) }}
                    </p>
                    @endif
                </div>

                <div class="info-grid" style="margin-top: 25px;">
                    <div class="info-box">
                        <div class="info-label">Donor Name</div>
                        <div class="info-value">{{ $donor->firstname }} {{ $donor->lastname }}</div>
                    </div>
                    <div class="info-box">
                        <div class="info-label">Donor Email</div>
                        <div class="info-value">{{ $donor->email }}</div>
                    </div>
                    <div class="info-box">
                        <div class="info-label">Date</div>
                        <div class="info-value">{{ now()->format('M d, Y') }}</div>
                    </div>
                    <div class="info-box">
                        <div class="info-label">Status</div>
                        <div class="info-value" style="color: #10b981;">Successful</div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Login Credentials for new donors -->
            @if(isset($password) && $password)
            <div class="credentials-card">
                <div class="credentials-title">🔐 Your Secure Login Credentials</div>
                <p class="credentials-sub">Use these details to access your donor dashboard:</p>

                <div class="credential-box">
                    <div class="credential-label">Temporary Password</div>
                    <div class="credential-value password">{{ $password }}</div>
                </div>

                <div style="text-align: center;">
                    <a href="{{ route('donor.login') }}" class="login-button">
                        Login to Your Dashboard →
                    </a>
                </div>
            </div>

            <!-- Security notice -->
            <div class="security-notice">
                <p>
                    <span style="font-size: 16px;">🔒</span>
                    <span><strong>Security tip:</strong> For your safety, please log in and change your password immediately. Never share your credentials with anyone.</span>
                </p>
            </div>
            @endif

            <!-- Impact message -->
            <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 2px solid #e9edf2;">
                <p style="color: #64748b; font-size: 14px; margin: 0 0 5px; font-style: italic;">
                    "Alone we can do so little; together we can do so much."
                </p>
                <p style="color: #8b7cf0; font-size: 12px; font-weight: 600; margin: 0;">
                    — Building Africa's Prosperity, Together —
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="footer-copyright">© {{ date('Y') }} Africa Prosperity Network · All rights reserved</p>
            <p class="footer-email">
                <a href="mailto:donations@africaprosperitynetwork.com">donations@africaprosperitynetwork.com</a>
            </p>
            <p class="footer-auto">
                <i>✦</i> This is an automated email. Please do not reply directly. <i>✦</i>
            </p>
        </div>

    </div>
</body>
</html>