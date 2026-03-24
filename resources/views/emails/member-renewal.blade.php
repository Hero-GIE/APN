<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APN Membership Renewal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@100;200;300;400;500;600;700;800&family=Lora:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            max-width: 420px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
        }
        .header {
            /* background: linear-gradient(135deg, #3730a3 0%, #4f46e5 60%, #6366f1 100%); */
            background: url('images/backgrounds/interoperability-1.webp');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: top center;
            padding: 20px 10px;
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
            font-size: 13px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #ffffff;
            font-weight: 400;
            position: relative;
        }
        .header-title {
            color: white;
            margin: 0;
            font-family: 'Urbanist', sans-serif;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.5px;
            position: relative;
        }
        .header-sub {
            color: #c7d2fe;
            margin: 8px 0 0;
            font-size: 18px;
            letter-spacing: 0.7px;
            font-family: 'Urbanist', serif;
            position: relative;
        }

        .header img{
            width: 90px;
        }

        .content {
            padding: 40px 35px;
            background: white;
        }
        .greeting {
            font-family: 'Urbanist', sans-serif;
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
        .renewal-card {
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 28px;
            margin-bottom: 30px;
            text-align: center;
        }
        .renewal-badge {
            background: #4e46e513;
            color: #3f32b7;
            padding: 4px 8px;
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
            font-weight: 300;
            color: #64748b;
        }
        .renewal-ref {
            font-size: 13px;
            color: #64748b;
            background: white;
            display: inline-block;
            padding: 6px 16px;
            border-radius: 30px;
            border: 2px solid #e2e8f0;
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
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 15px;
            text-align: left;
        }
        .info-label {
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0 0 4px;
        }
        .info-value {
            font-family: 'Urbanist', sans-serif;
            font-size: 16px;
            font-weight: 700;
            color: #1a1f36;
            margin: 0;
        }
        .membership-dates {
            background: #e8f0fe;
            border: 2px solid #c7d2fe;
            border-radius: 12px;
            padding: 20px;
            margin: 25px 0;
            text-align: center;
        }
        .date-label {
            font-size: 12px;
            color: #4f46e5;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0 0 5px;
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
            background: #4f46e5;
            color: white;
            padding: 14px 40px;
            text-decoration: none;
            border-radius: 40px;
            font-family: 'Urbanist', sans-serif;
            font-weight: 700;
            font-size: 15px;
            margin: 20px 0;
            transition: all 0.3s ease;
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.2);
        }
        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(79, 70, 229, 0.3);
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
            <img src="{{asset('images/logo/APN-Logo-01-white.png')}}" class="img-fluid" alt="">
            {{-- <h1 class="header-title">Africa Prosperity Network</h1> --}}
            <div class="header-brand mt-3">MEMBERSHIP RENEWAL</div>
            {{-- <p class="header-sub">Thank you for renewing your membership</p> --}}
        </div>

        {{-- Body --}}
        <div class="content">

            {{-- Greeting --}}
            <h2 class="greeting">Thank you for renewing, {{ $member->donor->firstname ?? $donor->firstname ?? 'Valued Member' }}! 🎉</h2>
            
            <p class="greeting-message">
                Your membership has been successfully renewed. We're thrilled to have you continue as part of the APN community. Below is a summary of your renewal.
            </p>

            {{-- Renewal Card --}}
            <div class="renewal-card">
                <div class="renewal-badge">✓ RENEWAL COMPLETE</div>
                <div class="renewal-amount">
                    {{ $donation->currency ?? 'GHS' }} {{ number_format($donation->amount ?? 0, 2) }}
                    <br><small>{{ ucfirst($membership_type ?? $member->membership_type ?? 'monthly') }} plan</small>
                </div>
                <div class="renewal-ref">
                    Ref: {{ $donation->transaction_id ?? 'N/A' }}
                </div>
            </div>

            {{-- Membership Details --}}
            <div class="info-grid">
                <div class="info-box">
                    <div class="info-label">Member Since</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($member->start_date ?? now())->format('M d, Y') }}</div>
                </div>
                <div class="info-box">
                    <div class="info-label">Renewal Count</div>
                    <div class="info-value">{{ ($member->renewal_count ?? 0) + 1 }}</div>
                </div>
            </div>

            {{-- New Membership Period --}}
            <div class="membership-dates">
                <div class="date-label">New Membership Period</div>
                <div class="date-value">
                    {{ \Carbon\Carbon::parse($member->start_date ?? now())->format('M d, Y') }} — 
                    {{ \Carbon\Carbon::parse($member->end_date ?? now()->addMonth())->format('M d, Y') }}
                </div>
            </div>

            {{-- Call to Action --}}
            <div style="text-align: center;">
                <a href="{{ route('member.dashboard') }}" class="button">
                    Go to Your Dashboard →
                </a>
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
                 This is an automated email. Please do not reply directly. 
            </p>
        </div>

    </div>
</body>
</html>