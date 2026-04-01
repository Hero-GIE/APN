<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .badge-container:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
        }
        .badge-image {
            width: 80px;
            height: 80px;
            margin: 0 auto 10px;
            border-radius: 50%;
            object-fit: cover;
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
        .status-expired {
            background: #fee2e2;
            color: #991b1b;
        }
        .status-cancelled {
            background: #fef3c7;
            color: #92400e;
        }
        .status-pending {
            background: #dbeafe;
            color: #1e40af;
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
            color: #2563eb;
        }
        .error {
            color: #ef4444;
            font-size: 12px;
            text-align: center;
            padding: 20px;
        }
        .error-icon {
            width: 32px;
            height: 32px;
            margin: 0 auto 8px;
            color: #ef4444;
        }
        .loading {
            text-align: center;
            padding: 20px;
            color: #64748b;
        }
        .spinner {
            width: 32px;
            height: 32px;
            border: 3px solid #e2e8f0;
            border-top-color: #3b82f6;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin: 0 auto 8px;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    @if(isset($error) || !isset($member) || !$member)
        <div class="badge-widget">
            <div class="badge-container">
                <div class="error">
                    <svg class="error-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p>Member not found</p>
                    <p class="text-xs text-gray-400 mt-1">Invalid or expired badge</p>
                </div>
            </div>
        </div>
    @else
        <div class="badge-widget">
            <div class="badge-container">
                <img src="{{ route('member.badge.image', ['token' => $member->badge_token]) }}" 
                     alt="APN Member Badge" 
                     class="badge-image"
                     onerror="this.src='{{ asset('images/badges/badge-placeholder.png') }}'">
                
                <div class="member-name">
                    {{ $member->donor->firstname ?? 'Member' }} {{ $member->donor->lastname ?? '' }}
                </div>
                
                <div class="member-status status-{{ $member->status }}">
                    @if($member->status === 'active')
                        ● Active Member
                    @elseif($member->status === 'expired')
                        ● Expired
                    @elseif($member->status === 'cancelled')
                        ● Cancelled
                    @else
                        ● {{ ucfirst($member->status) }}
                    @endif
                </div>
                
                @if($member->start_date)
                <div class="member-since">
                    Member since {{ $member->start_date->format('M Y') }}
                </div>
                @endif
                
                <a href="{{ route('member.badge.verify', ['token' => $member->badge_token]) }}" 
                   target="_blank" 
                   class="verify-link">
                    Verify Membership
                </a>
            </div>
        </div>
    @endif

    @if(isset($member) && $member && $member->status === 'active')
    <script>
        // Optional: Track widget impressions
        if (typeof fetch !== 'undefined') {
            fetch('{{ route('member.badge.track', ['token' => $member->badge_token]) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ type: 'widget_impression' })
            }).catch(() => {});
        }
    </script>
    @endif
</body>
</html>