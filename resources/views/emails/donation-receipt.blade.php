<!DOCTYPE html>
<html>
<head>
    <title>Your Donation Receipt — APN</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #1a2e1a; background: #f0f7f2; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto;">

        {{-- Header --}}
        <div style="background: linear-gradient(135deg, #0f4226, #1a6b3c); padding: 40px 30px; text-align: center; border-radius: 16px 16px 0 0;">
            <p style="margin: 0 0 8px; font-size: 11px; letter-spacing: 3px; text-transform: uppercase; color: #c8a850; font-weight: bold;">APN Membership</p>
            <h1 style="color: white; margin: 0; font-size: 26px; font-weight: 700;">🙏 Thank You for Your Donation!</h1>
        </div>

        {{-- Body --}}
        <div style="background: white; padding: 40px 35px; border: 1px solid #d4edd9; border-top: none;">

            <p style="font-size: 17px; text-align: center; color: #0f4226; margin: 0 0 24px;">
                Dear <strong>{{ $donor->firstname }} {{ $donor->lastname }}</strong>,
            </p>

            {{-- Receipt Box --}}
            <div style="background: #f0f7f2; border-radius: 16px; padding: 30px; margin: 0 0 25px; border: 2px dashed #1a6b3c;">
                <h2 style="text-align: center; color: #0f4226; margin: 0 0 20px; font-size: 18px; letter-spacing: 1px; text-transform: uppercase;">Donation Receipt</h2>

                {{-- Amount --}}
                <p style="font-size: 52px; font-weight: 800; color: #0f4226; text-align: center; margin: 0 0 20px; line-height: 1;">
                    {{ $donation->formatted_amount }}
                </p>

                {{-- Details --}}
                <div style="background: white; border-radius: 12px; padding: 20px; margin: 0;">

                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td style="padding: 12px 0; border-bottom: 1px solid #e8f5ee; color: #5a8a6a; font-size: 14px;">Transaction ID</td>
                            <td style="padding: 12px 0; border-bottom: 1px solid #e8f5ee; color: #0f4226; font-weight: 600; font-size: 14px; text-align: right; font-family: monospace;">{{ $donation->transaction_id }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 12px 0; border-bottom: 1px solid #e8f5ee; color: #5a8a6a; font-size: 14px;">Date</td>
                            <td style="padding: 12px 0; border-bottom: 1px solid #e8f5ee; color: #0f4226; font-weight: 600; font-size: 14px; text-align: right;">{{ $donation->created_at->format('F j, Y g:i A') }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 12px 0; border-bottom: 1px solid #e8f5ee; color: #5a8a6a; font-size: 14px;">Payment Method</td>
                            <td style="padding: 12px 0; border-bottom: 1px solid #e8f5ee; color: #0f4226; font-weight: 600; font-size: 14px; text-align: right;">{{ ucfirst($donation->payment_method ?? 'Card') }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 12px 0; border-bottom: 1px solid #e8f5ee; color: #5a8a6a; font-size: 14px;">Status</td>
                            <td style="padding: 12px 0; border-bottom: 1px solid #e8f5ee; text-align: right;">
                                <span style="background: #d4edd9; color: #1a6b3c; font-size: 12px; font-weight: 700; padding: 4px 12px; border-radius: 20px;">✓ Successful</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 12px 0; color: #5a8a6a; font-size: 14px;">Donor Email</td>
                            <td style="padding: 12px 0; color: #0f4226; font-weight: 600; font-size: 14px; text-align: right;">{{ $donor->email }}</td>
                        </tr>
                    </table>

                </div>

                <div style="text-align: center; margin-top: 24px;">
                    <a href="{{ route('donor.dashboard') }}"
                       style="display: inline-block; background: #1a6b3c; color: white; padding: 14px 35px; text-decoration: none; border-radius: 40px; font-weight: 700; font-size: 15px;">
                        View Donation History →
                    </a>
                </div>
            </div>

            {{-- Tax Note --}}
            <div style="background: #e8f5ee; border-radius: 12px; padding: 20px; margin: 0 0 20px;">
                <p style="margin: 0; color: #0f4226; font-size: 14px;">
                    <strong>Tax Information:</strong> This receipt serves as your official record for tax purposes. Please keep it for your records.
                </p>
            </div>

            <p style="text-align: center; color: #5a8a6a; font-size: 14px; margin: 0;">
                Your generosity makes our work possible. Thank you for being part of our community!
            </p>

        </div>

        {{-- Footer --}}
        <div style="background: #f0f7f2; border-top: 1px solid #d4edd9; padding: 24px 35px; text-align: center; border-radius: 0 0 16px 16px;">
            <p style="font-size: 12px; color: #7a9a7a; margin: 0 0 4px;">© {{ date('Y') }} Africa Prosperity Network · All rights reserved</p>
            <p style="font-size: 12px; margin: 0;">
                <a href="mailto:membership@api.africaprosperitynetwork.com" style="color: #1a6b3c; text-decoration: none;">membership@api.africaprosperitynetwork.com</a>
            </p>
        </div>

    </div>
</body>
</html>