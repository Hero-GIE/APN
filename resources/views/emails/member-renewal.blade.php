<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APN Membership Renewal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@100;200;300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.7;
            color: #1a1f36;
            background: #f1f5f9;
            margin: 0;
            padding: 20px;
        }
        .email-container {
            max-width: 520px;
            margin: 0 auto;
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
        }
        .header {
            background: linear-gradient(135deg, #1e1b4b 0%, #4f46e5 100%);
            padding: 40px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .header-content {
            position: relative;
            z-index: 2;
        }
        .logo {
            width: 80px;
            margin-bottom: 20px;
        }
        .header-title {
            color: white;
            margin: 0;
            font-family: 'Urbanist', sans-serif;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        .header-sub {
            color: #c7d2fe;
            margin: 10px 0 0;
            font-size: 16px;
        }
        .content {
            padding: 40px 35px;
            background: white;
        }
        .greeting {
            font-family: 'Urbanist', sans-serif;
            font-size: 24px;
            font-weight: 700;
            color: #1a1f36;
            margin: 0 0 12px;
        }
        .greeting-message {
            color: #64748b;
            font-size: 15px;
            margin: 0 0 30px;
            line-height: 1.6;
        }
        .renewal-card {
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 28px;
            margin-bottom: 30px;
            text-align: center;
        }
        .renewal-badge {
            background: #e0e7ff;
            color: #4f46e5;
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 20px;
        }
        .renewal-amount {
            font-family: 'Urbanist', sans-serif;
            font-size: 48px;
            font-weight: 800;
            color: #1a1f36;
            line-height: 1;
            margin: 0 0 10px;
        }
        .renewal-amount small {
            font-size: 16px;
            font-weight: 400;
            color: #64748b;
        }
        .renewal-ref {
            font-size: 12px;
            color: #64748b;
            background: white;
            display: inline-block;
            padding: 6px 16px;
            border-radius: 30px;
            border: 1px solid #e2e8f0;
            font-family: monospace;
            margin: 10px 0;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin: 25px 0;
        }
        .info-box {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 15px;
            text-align: left;
        }
        .info-label {
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0 0 6px;
        }
        .info-value {
            font-family: 'Urbanist', sans-serif;
            font-size: 16px;
            font-weight: 700;
            color: #1a1f36;
            margin: 0;
        }
        .membership-dates {
            background: linear-gradient(135deg, #eef2ff, #e0e7ff);
            border-radius: 16px;
            padding: 20px;
            margin: 25px 0;
            text-align: center;
        }
        .date-label {
            font-size: 12px;
            color: #4f46e5;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0 0 8px;
            font-weight: 600;
        }
        .date-value {
            font-family: 'Urbanist', sans-serif;
            font-size: 18px;
            font-weight: 700;
            color: #1a1f36;
            margin: 0;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: white;
            padding: 14px 40px;
            text-decoration: none;
            border-radius: 40px;
            font-family: 'Urbanist', sans-serif;
            font-weight: 700;
            font-size: 15px;
            margin: 20px 0;
            transition: all 0.3s ease;
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
        }
        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(79, 70, 229, 0.4);
        }
        .benefits-list {
            background: #f8fafc;
            border-radius: 16px;
            padding: 20px;
            margin: 25px 0;
        }
        .benefits-list h4 {
            font-family: 'Urbanist', sans-serif;
            font-size: 14px;
            font-weight: 700;
            color: #1a1f36;
            margin: 0 0 12px;
        }
        .benefits-list ul {
            margin: 0;
            padding-left: 20px;
        }
        .benefits-list li {
            font-size: 13px;
            color: #475569;
            margin-bottom: 8px;
        }
        .footer {
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
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
        .footer-auto {
            font-size: 11px;
            color: #94a3b8;
            margin: 0;
        }
        @media (max-width: 600px) {
            .content {
                padding: 30px 20px;
            }
            .renewal-amount {
                font-size: 36px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">

        <div class="header">
            <div class="header-content">
             <img src="{{ url('images/logo/apn-membership.png') }}" class="logo" alt="APN Logo">
                <h1 class="header-title">Membership Renewed! 🎉</h1>
                <p class="header-sub">Thank you for continuing your journey with us</p>
            </div>
        </div>
  
        <div class="content">
            <h2 class="greeting">Welcome back, {{ $donor->firstname ?? 'Valued Member' }}!</h2>
            
            <p class="greeting-message">
                Your membership has been successfully renewed. We're thrilled to have you continue as part of the APN community. Your support helps us build Africa's prosperity together.
            </p>

            <div class="renewal-card">
                <div class="renewal-badge">✓ RENEWAL COMPLETE</div>
                <div class="renewal-amount">
                    ${{ number_format($payment->amount ?? 0, 2) }}
                    <br><small>{{ ucfirst($member->membership_type ?? 'monthly') }} plan</small>
                </div>
                <div class="renewal-ref">
                    Transaction: {{ $payment->transaction_id ?? 'N/A' }}
                </div>
            </div>

            <div class="info-grid">
                <div class="info-box">
                    <div class="info-label">Member Since</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($member->start_date)->format('M d, Y') }}</div>
                </div>
                <div class="info-box">
                    <div class="info-label">Renewal Count</div>
                    <div class="info-value">{{ $member->renewal_count }} {{ $member->renewal_count == 1 ? 'time' : 'times' }}</div>
                </div>
            </div>

            <div class="membership-dates">
                <div class="date-label">Your New Membership Period</div>
                <div class="date-value">
                    {{ \Carbon\Carbon::parse($member->start_date)->format('M d, Y') }} — 
                    {{ \Carbon\Carbon::parse($member->end_date)->format('M d, Y') }}
                </div>
            </div>

            <div class="benefits-list">
                <h4>✨ Your Active Benefits Include:</h4>
                <ul>
                    <li>✓ 10% discount on APN Gala tickets and merchandise</li>
                    <li>✓ Exclusive access to APN Magazine (digital edition)</li>
                    <li>✓ Monthly newsletters with insider updates</li>
                    <li>✓ Visibility and branding opportunities</li>
                    <li>✓ Access to APN events and conference materials</li>
                    <li>✓ Eligibility for awards and nominations</li>
                </ul>
            </div>

            <div style="text-align: center;">
                <a href="{{ route('member.dashboard') }}" class="button">
                    Go to Your Dashboard →
                </a>
            </div>

            <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
                <p style="color: #64748b; font-size: 14px; margin: 0 0 5px; font-style: italic;">
                    "Together, we are building Africa's prosperity."
                </p>
                <p style="color: #4f46e5; font-size: 12px; font-weight: 600; margin: 0;">
                    — Africa Prosperity Network —
                </p>
            </div>
        </div>

        <div class="footer">
            <p class="footer-copyright">© {{ date('Y') }} Africa Prosperity Network · All rights reserved</p>
            <p class="footer-email">
                Need help? <a href="mailto:membership@africaprosperitynetwork.com">membership@africaprosperitynetwork.com</a>
            </p>
            <p class="footer-auto">
                This is an automated confirmation. Please keep this email for your records.
            </p>
        </div>

    </div>
</body>
</html>