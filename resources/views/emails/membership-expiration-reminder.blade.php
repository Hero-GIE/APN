<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APN Membership Expiration Reminder</title>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
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
            background: linear-gradient(135deg, #f59e0b, #d97706);
            padding: 40px 20px;
            text-align: center;
        }
        .header-title {
            color: white;
            margin: 0;
            font-family: 'Urbanist', sans-serif;
            font-size: 28px;
            font-weight: 800;
        }
        .content {
            padding: 40px 35px;
        }
        .warning-badge {
            background: #fef3c7;
            color: #d97706;
            padding: 8px 16px;
            border-radius: 40px;
            font-size: 13px;
            font-weight: 700;
            display: inline-block;
            margin-bottom: 20px;
        }
        .days-left {
            font-size: 48px;
            font-weight: 800;
            color: #d97706;
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            padding: 14px 40px;
            text-decoration: none;
            border-radius: 40px;
            font-weight: 700;
            margin: 20px 0;
        }
        .footer {
            background: #f8fafc;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1 class="header-title">⚠️ Membership Expiring Soon</h1>
        </div>
        
        <div class="content">
            <div style="text-align: center;">
                <div class="warning-badge">ACTION REQUIRED</div>
                <div class="days-left">{{ $days_left }} Days Remaining</div>
                <p style="color: #64748b;">Your membership will expire on <strong>{{ $end_date }}</strong></p>
                <p>Renew now to continue enjoying all member benefits without interruption.</p>
                <a href="{{ route('donor.membership', ['renew' => true]) }}" class="button">
                    Renew My Membership →
                </a>
            </div>
        </div>
        
        <div class="footer">
            <p style="font-size: 12px; color: #64748b;">Africa Prosperity Network</p>
        </div>
    </div>
</body>
</html>