<!DOCTYPE html>
<html>
<head>
    <title>APN Membership Notification</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; background: #f0f7f2;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">

        {{-- Header --}}
        <div style="background: linear-gradient(135deg, #0f4226, #1a6b3c); color: white; padding: 28px 30px; text-align: center; border-radius: 12px 12px 0 0;">
            <p style="margin: 0 0 6px; font-size: 12px; letter-spacing: 3px; text-transform: uppercase; color: #c8a850; font-weight: bold;">APN Membership</p>
            <h1 style="margin: 0; font-size: 22px; font-weight: 700;">Africa Prosperity Network</h1>
        </div>

        {{-- Body --}}
        <div style="background: #f8fafc; padding: 30px; border: 1px solid #d4edd9; border-top: none;">
            <h2 style="color: #0f4226; margin-top: 0;">New Notification</h2>

            <div style="background: white; padding: 20px; border-radius: 8px; border-left: 4px solid #1a6b3c; margin: 20px 0;">
                @if(isset($data['title']))
                    <h3 style="margin-top: 0; color: #0f4226;">{{ $data['title'] }}</h3>
                @endif

                @if(isset($data['message']))
                    <p style="color: #4a6b4a;">{{ $data['message'] }}</p>
                @endif

                @if(isset($data['user_info']))
                    <p style="margin-bottom: 0;"><strong>User:</strong> {{ $data['user_info'] }}</p>
                @endif

                @if(isset($data['time']))
                    <p style="margin-bottom: 0;"><strong>Time:</strong> {{ $data['time'] }}</p>
                @endif
            </div>

            @if(isset($data['action_url']))
                <div style="text-align: center; margin: 30px 0;">
                    <a href="{{ $data['action_url'] }}"
                       style="background: #1a6b3c; color: white; padding: 12px 30px; text-decoration: none; border-radius: 40px; display: inline-block; font-weight: 600;">
                        View Details
                    </a>
                </div>
            @endif

            <p style="color: #718096; font-size: 13px; margin-bottom: 0;">
                This is an automated notification from the APN Membership system.
            </p>
        </div>

        {{-- Footer --}}
        <div style="text-align: center; padding: 20px; color: #718096; font-size: 12px; border-top: 1px solid #d4edd9; background: white; border-radius: 0 0 12px 12px;">
            <p style="margin: 0 0 4px;">© {{ date('Y') }} Africa Prosperity Network</p>
            <p style="margin: 0;">membership@api.africaprosperitynetwork.com</p>
        </div>

    </div>
</body>
</html>