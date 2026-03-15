<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Membership Payment Receipt</title>
    <style>
        body {
            font-family: 'Inter', Arial, sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 40px 20px;
            background: #f9fafb;
        }
        .receipt-container {
            background: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
            border: 1px solid #e2e8f0;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 20px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            background: linear-gradient(135deg, #3730a3, #4f46e5);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
        }
        .receipt-title {
            font-size: 20px;
            color: #1a1f36;
            margin-top: 10px;
        }
        .amount {
            font-size: 48px;
            font-weight: bold;
            color: #4f46e5;
            text-align: center;
            margin: 20px 0;
        }
        .details {
            background: #f8fafc;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
        }
        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            padding: 8px 0;
            border-bottom: 1px dashed #e2e8f0;
        }
        .row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: 600;
            color: #64748b;
        }
        .value {
            color: #1a1f36;
            font-weight: 500;
        }
        .status {
            background: #dcfce7;
            color: #166534;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #e2e8f0;
            color: #94a3b8;
            font-size: 14px;
        }
        .thank-you {
            font-size: 18px;
            color: #4f46e5;
            margin-bottom: 10px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="header">
            <div class="logo">Africa Prosperity Network</div>
            <div class="receipt-title">Membership Payment Receipt</div>
        </div>

        <div class="amount">${{ number_format($payment->amount, 2) }}</div>

        <div class="details">
            <div class="row">
                <span class="label">Transaction ID:</span>
                <span class="value">{{ $payment->donation->transaction_id }}</span>
            </div>
            <div class="row">
                <span class="label">Date:</span>
                <span class="value">{{ $payment->payment_date->format('F d, Y \a\t h:i A') }}</span>
            </div>
            <div class="row">
                <span class="label">Membership Type:</span>
                <span class="value">{{ ucfirst($payment->membership_type) }}</span>
            </div>
            <div class="row">
                <span class="label">Period:</span>
                <span class="value">
                    {{ $payment->period_start->format('M d, Y') }} - 
                    {{ $payment->period_end->format('M d, Y') }}
                </span>
            </div>
            <div class="row">
                <span class="label">Member Name:</span>
                <span class="value">{{ $donor->firstname }} {{ $donor->lastname }}</span>
            </div>
            <div class="row">
                <span class="label">Member Email:</span>
                <span class="value">{{ $donor->email }}</span>
            </div>
            <div class="row">
                <span class="label">Payment Method:</span>
                <span class="value">{{ ucfirst($payment->donation->payment_method ?? 'Card') }}</span>
            </div>
            <div class="row">
                <span class="label">Status:</span>
                <span class="value">
                    <span class="status">Paid</span>
                </span>
            </div>
        </div>

        <div class="footer">
            <div class="thank-you">Thank you for your membership!</div>
            <p>This is a computer-generated receipt. No signature required.</p>
            <p style="margin-top: 10px;">For any questions, contact support@africaprosperitynetwork.com</p>
        </div>
    </div>
</body>
</html>