<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APN Membership Expired</title>
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
            background: linear-gradient(135deg, #dc2626, #ef4444);
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
        .expired-badge {
            background: #fee2e2;
            color: #dc2626;
            padding: 8px 16px;
            border-radius: 40px;
            font-size: 13px;
            font-weight: 700;
            display: inline-block;
            margin-bottom: 20px;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #dc2626, #ef4444);
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
        .benefits-list {
            margin: 20px 0;
            padding-left: 20px;
        }
        .benefits-list li {
            margin-bottom: 8px;
            color: #475569;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1 class="header-title">⏰ Your Membership Has Expired</h1>
        </div>
        
        <div class="content">
            <div style="text-align: center;">
                <div class="expired-badge">MEMBERSHIP EXPIRED</div>
                
                <p style="color: #64748b; margin-top: 20px;">
                    Your APN membership expired on <strong>{{ $member->end_date ? $member->end_date->format('M d, Y') : 'N/A' }}</strong>.
                </p>
                
                <p>You've lost access to member benefits including:</p>
                <ul class="benefits-list" style="text-align: left;">
                    <li>✓ Exclusive member content</li>
                    <li>✓ 10% discount on events</li>
                    <li>✓ APN Magazine subscription</li>
                    <li>✓ Member networking opportunities</li>
                </ul>
                
                <p>Don't miss out! Renew your membership to continue enjoying these benefits.</p>
                
                <a href="{{ route('donor.membership') }}" class="button">
                    Renew Your Membership →
                </a>
            </div>
        </div>
        
        <div class="footer">
            <p style="font-size: 12px; color: #64748b;">Africa Prosperity Network</p>
            <p style="font-size: 11px; color: #94a3b8; margin-top: 10px;">
                If you have any questions, please contact our support team.
            </p>
        </div>
    </div>
</body>
</html>