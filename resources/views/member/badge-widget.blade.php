<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: transparent;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 200px;
        }
        .badge-widget {
            width: 100%;
            max-width: 200px;
            text-align: center;
        }
        .badge-container {
            background: white;
            border-radius: 12px;
            padding: 20px 15px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
            border: 1px solid #e2e8f0;
        }
        .badge-image {
            width: 80px;
            height: 80px;
            margin: 0 auto 10px;
        }
        .member-name {
            font-weight: 600;
            font-size: 14px;
            color: #1e293b;
            margin-bottom: 4px;
        }
        .member-status {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 9999px;
            font-size: 10px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        .status-active {
            background: #dcfce7;
            color: #166534;
        }
        .status-inactive {
            background: #f1f5f9;
            color: #475569;
        }
        .member-since {
            font-size: 10px;
            color: #64748b;
            margin-bottom: 12px;
        }
        .verify-link {
            display: inline-block;
            font-size: 10px;
            color: #3b82f6;
            text-decoration: none;
            border: 1px solid #bfdbfe;
            padding: 4px 10px;
            border-radius: 6px;
            transition: all 0.2s;
        }
        .verify-link:hover {
            background: #eff6ff;
        }
        .error {
            color: #ef4444;
            font-size: 12px;
            text-align: center;
            padding: 20px;
        }
    </style>
</head>
<body>
    @if(isset($error) || !$member)
        <div class="badge-widget">
            <div class="badge-container">
                <div class="error">
                    <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Member not found
                </div>
            </div>
        </div>
    @else
        <div class="badge-widget">
            <div class="badge-container">
                <img src="{{ route('member.badge.image', ['token' => $member->badge_token]) }}" 
                     alt="APN Member Badge" 
                     class="badge-image">
                
                <div class="member-name">
                    {{ $member->donor->firstname }} {{ $member->donor->lastname }}
                </div>
                
                <div class="member-status {{ $member->status === 'active' ? 'status-active' : 'status-inactive' }}">
                    {{ $member->status === 'active' ? '● Active Member' : '● ' . ucfirst($member->status) }}
                </div>
                
                <div class="member-since">
                    Member since {{ $member->start_date->format('M Y') }}
                </div>
                
                <a href="{{ route('member.badge.verify', ['token' => $member->badge_token]) }}" 
                   target="_blank" 
                   class="verify-link">
                    Verify Membership
                </a>
            </div>
        </div>
    @endif
</body>
</html>