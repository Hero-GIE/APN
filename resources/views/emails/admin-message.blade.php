<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APN Admin Notification</title>
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
        .notification-card {
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 28px;
            margin-bottom: 30px;
        }
        .notification-badge {
            background: #e0e7ff;
            color: #4f46e5;
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 20px;
        }
        .notification-type {
            font-family: 'Urbanist', sans-serif;
            font-size: 20px;
            font-weight: 700;
            color: #1a1f36;
            line-height: 1.3;
            margin: 0 0 15px;
        }
        .notification-message {
            color: #475569;
            font-size: 15px;
            margin: 15px 0;
            line-height: 1.6;
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
        .details-section {
            background: #f8fafc;
            border-radius: 16px;
            padding: 20px;
            margin: 25px 0;
        }
        .details-section h4 {
            font-family: 'Urbanist', sans-serif;
            font-size: 14px;
            font-weight: 700;
            color: #1a1f36;
            margin: 0 0 12px;
        }
        .details-content {
            background: white;
            padding: 12px;
            border-radius: 12px;
            font-size: 12px;
            font-family: monospace;
            color: #334155;
            overflow-x: auto;
            white-space: pre-wrap;
            word-wrap: break-word;
            margin: 10px 0 0;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: white !important;
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
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">

        <div class="header">
            <div class="header-content">
                <img src="{{ url('images/logo/apn-membership.png') }}" class="logo" alt="APN Logo">
                <h1 class="header-title">{{ $title ?? 'Admin Notification' }}</h1>
                <p class="header-sub">{{ $subtitle ?? 'Africa Prosperity Network' }}</p>
            </div>
        </div>
  
        <div class="content">
            <h2 class="greeting">Hello Admin,</h2>
            
            <p class="greeting-message">
                {{ $greeting ?? 'You have a new notification from the APN system.' }}
            </p>

            <div class="notification-card">
                @if(!empty($type))
                    <div class="notification-badge">{{ strtoupper($type) }}</div>
                @endif
                
                @if(!empty($title))
                    <div class="notification-type">{{ $title }}</div>
                @endif
                
                @if(!empty($content))
                    <div class="notification-message">{{ $content }}</div>
                @endif
                
                @if(!empty($reference_id))
                    <div class="renewal-ref" style="background: white; display: inline-block; margin-top: 10px;">
                        Reference: {{ $reference_id }}
                    </div>
                @endif
            </div>

            @if(!empty($user_info) || !empty($time) || !empty($priority))
                <div class="info-grid">
                    @if(!empty($user_info))
                        <div class="info-box">
                            <div class="info-label">User/Related Info</div>
                            <div class="info-value">{{ $user_info }}</div>
                        </div>
                    @endif
                    
                    @if(!empty($time))
                        <div class="info-box">
                            <div class="info-label">Time</div>
                            <div class="info-value">{{ $time }}</div>
                        </div>
                    @endif
                    
                    @if(!empty($priority))
                        <div class="info-box">
                            <div class="info-label">Priority</div>
                            <div class="info-value" style="color: {{ $priority == 'high' ? '#dc2626' : ($priority == 'medium' ? '#f59e0b' : '#10b981') }}">
                                {{ ucfirst($priority) }}
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            @if(!empty($details))
                <div class="details-section">
                    <h4>📋 Additional Details</h4>
                    <div class="details-content">
                        @if(is_array($details) || is_object($details))
                            {{ json_encode($details, JSON_PRETTY_PRINT) }}
                        @else
                            {{ $details }}
                        @endif
                    </div>
                </div>
            @endif

            @if(!empty($action_url))
                <div style="text-align: center;">
                    <a href="{{ $action_url }}" class="button">
                        View Details →
                    </a>
                </div>
            @endif

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
                This is an automated notification from the APN Admin System.
            </p>
        </div>

    </div>
</body>
</html>