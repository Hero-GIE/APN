@extends('layouts.guest')

@section('content')

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: 'Open Sans', sans-serif;
    background: linear-gradient(135deg, #f5f7fa 0%, #f0f2f8 100%);
    min-height: 100vh;
    display: flex;
    align-items: flex-start;
    justify-content: center;
    padding: 1.5rem 1rem;
}

h1, h2, h3, h4, h5, h6 { font-family: 'Urbanist', sans-serif; }

.v-wrap {
    width: 100%;
    max-width: 460px;
}

.v-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 20px 40px -12px rgba(0,0,0,0.15);
    overflow: hidden;
    animation: slideUp 0.35s ease-out both;
}

@keyframes slideUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* Header */
.v-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    padding: 1.5rem 1.25rem 1.25rem;
    text-align: center;
}

.v-header__icon {
    width: 48px; height: 48px;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 0.75rem;
}

.v-header h1 { font-size: 1.35rem; font-weight: 700; margin-bottom: 0.2rem; }
.v-header p  { font-size: 0.82rem; opacity: 0.85; margin: 0; }

/* Body */
.v-body { padding: 1.25rem 1.25rem 1.5rem; }

/* Badges */
.badge-valid, .badge-invalid {
    display: inline-flex; align-items: center; gap: 0.35rem;
    padding: 0.3rem 1rem; border-radius: 100px;
    font-size: 0.82rem; font-weight: 600;
    margin-bottom: 1.25rem;
}
.badge-valid   { background: linear-gradient(135deg,#10b981,#059669); color: #fff; }
.badge-invalid { background: linear-gradient(135deg,#ef4444,#dc2626); color: #fff; }

/* Profile */
.profile { text-align: center; margin-bottom: 1.25rem; }

.profile-avatar {
    width: 72px; height: 72px;
    border-radius: 12px;
    object-fit: cover;
    border: 2px solid #e5e7eb;
    margin: 0 auto 0.6rem;
    display: block;
}

.initials-avatar {
    width: 72px; height: 72px;
    border-radius: 12px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 0.6rem;
}

.initials-avatar span {
    font-size: 1.6rem; font-weight: 700; color: #fff;
    font-family: 'Urbanist', sans-serif;
}

.profile__name  { font-size: 1.15rem; font-weight: 700; color: #1f2937; margin-bottom: 0.15rem; }
.profile__email { font-size: 0.8rem; color: #6b7280; }

/* Details grid */
.details {
    background: #f9fafb;
    border: 1px solid #f0f0f0;
    border-radius: 10px;
    padding: 0.25rem 0.875rem;
    margin-bottom: 1.25rem;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.6rem 0;
    border-bottom: 1px solid #e5e7eb;
    gap: 0.5rem;
}

.detail-row:last-child { border-bottom: none; }

.detail-label {
    color: #6b7280;
    font-size: 0.8rem;
    font-weight: 500;
    white-space: nowrap;
    flex-shrink: 0;
}

.detail-value {
    font-weight: 600;
    color: #1f2937;
    font-size: 0.8rem;
    text-align: right;
}

/* QR */
.qr-wrap {
    text-align: center;
    margin-bottom: 1.25rem;
}

.qr-inner {
    display: inline-block;
    padding: 8px;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
}

.qr-inner #qrcode,
.qr-inner #qrcode img {
    width: 90px !important;
    height: 90px !important;
    display: block;
}

.qr-label { font-size: 0.72rem; color: #9ca3af; margin-top: 0.4rem; }

/* Action buttons */
.action-row {
    display: flex;
    gap: 0.625rem;
    margin-bottom: 1.25rem;
}

.btn-share, .btn-print {
    flex: 1;
    padding: 0.6rem 0.75rem;
    border-radius: 10px;
    font-size: 0.8rem;
    font-weight: 600;
    font-family: 'Urbanist', sans-serif;
    display: inline-flex; align-items: center; justify-content: center;
    gap: 0.4rem;
    cursor: pointer; border: none;
    transition: all 0.2s;
}

.btn-share { background: #4f46e5; color: #fff; }
.btn-share:hover { background: #4338ca; transform: translateY(-1px); }
.btn-print { background: #f3f4f6; color: #374151; }
.btn-print:hover { background: #e5e7eb; }

/* Notice box */
.notice {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    font-size: 0.75rem;
    color: #166534;
}

.notice strong { display: block; margin-bottom: 0.25rem; font-size: 0.8rem; }

/* Error state */
.error-wrap { text-align: center; padding: 0.5rem 0 0.75rem; }
.error-wrap svg { display: block; margin: 0 auto 0.75rem; color: #9ca3af; }
.error-title   { font-size: 1rem; font-weight: 700; color: #374151; margin-bottom: 0.35rem; }
.error-msg     { font-size: 0.78rem; color: #6b7280; margin-bottom: 1rem; line-height: 1.5; }

.help-box {
    background: #fffbeb;
    border: 1px solid #fde68a;
    border-radius: 10px;
    padding: 0.875rem 1rem;
    font-size: 0.75rem;
    text-align: left;
}

.help-box strong { display: block; margin-bottom: 0.35rem; color: #92400e; }
.help-box ul { list-style: none; padding: 0; color: #b45309; line-height: 1.8; }

@media (max-width: 480px) {
    body { padding: 1rem 0.75rem; align-items: flex-start; }

    .v-header { padding: 1.25rem 1rem 1rem; }
    .v-header__icon { width: 42px; height: 42px; }
    .v-header h1 { font-size: 1.15rem; }

    .v-body { padding: 1rem 1rem 1.25rem; }

    .initials-avatar, .profile-avatar { width: 60px; height: 60px; }
    .initials-avatar span { font-size: 1.3rem; }
    .profile__name { font-size: 1rem; }

    .detail-label, .detail-value { font-size: 0.75rem; }

    .qr-inner #qrcode,
    .qr-inner #qrcode img { width: 80px !important; height: 80px !important; }

    .btn-share, .btn-print { font-size: 0.75rem; padding: 0.55rem 0.5rem; }
}
</style>

<div class="v-wrap">
    <div class="v-card">

        {{-- Header --}}
        <div class="v-header">
            <div class="v-header__icon">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <h1>Membership Verification</h1>
            <p>Africa Prosperity Network</p>
        </div>

        {{-- Body --}}
        <div class="v-body">

            @if(!isset($valid) || !$valid || !isset($member) || !$member)
                {{-- INVALID --}}
                <div style="text-align:center; margin-bottom:1rem;">
                    <span class="badge-invalid">
                        <i class="fas fa-times" style="font-size:0.7rem;"></i>
                        Invalid Membership
                    </span>
                </div>

                <div class="error-wrap">
                    <svg width="52" height="52" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="error-title">Could not verify membership</p>
                    <p class="error-msg">This badge may be for a member who has expired or cancelled, or the link may be incorrect.</p>
                </div>

                <div class="help-box">
                    <strong>What can I do?</strong>
                    <ul>
                        <li>• Check that the badge link is correct</li>
                        <li>• The member may need to renew their membership</li>
                        <li>• Contact support@africaprosperitynetwork.com</li>
                    </ul>
                </div>

            @else
                {{-- VALID --}}
                <div style="text-align:center; margin-bottom:1rem;">
                    <span class="badge-valid">
                        <i class="fas fa-check-circle" style="font-size:0.7rem;"></i>
                        Verified Active Member
                    </span>
                </div>

                <div class="profile">
                    @if(isset($profileImageUrl) && $profileImageUrl)
                        <img src="{{ $profileImageUrl }}" alt="{{ $donor->firstname }}" class="profile-avatar">
                    @else
                        <div class="initials-avatar">
                            <span>{{ strtoupper(substr($donor->firstname ?? 'M', 0, 1)) }}{{ strtoupper(substr($donor->lastname ?? 'M', 0, 1)) }}</span>
                        </div>
                    @endif
                    <p class="profile__name">{{ $donor->firstname ?? 'Member' }} {{ $donor->lastname ?? '' }}</p>
                    @if(isset($donor) && $donor->email)
                        <p class="profile__email">{{ $donor->email }}</p>
                    @endif
                </div>

                <div class="details">
                    <div class="detail-row">
                        <span class="detail-label">Membership Type</span>
                        <span class="detail-value">{{ ucfirst($member->membership_type ?? 'Standard') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Member Since</span>
                        <span class="detail-value">{{ isset($member->start_date) ? $member->start_date->format('M d, Y') : 'N/A' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Valid Until</span>
                        <span class="detail-value">{{ isset($member->end_date) ? $member->end_date->format('M d, Y') : 'N/A' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Status</span>
                        <span class="detail-value" style="color:#16a34a;">● Active</span>
                    </div>
                </div>

                <div class="qr-wrap">
                    <div class="qr-inner"><div id="qrcode"></div></div>
                    <p class="qr-label">Scan to verify</p>
                </div>

                <div class="action-row">
                    <button onclick="shareVerification()" class="btn-share">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/>
                            <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>
                        </svg>
                        Share
                    </button>
                    <button onclick="window.print()" class="btn-print">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        Print
                    </button>
                </div>

                <div class="notice">
                    <strong>Official Verification</strong>
                    This confirms {{ $donor->firstname ?? 'the member' }} is an active member of Africa Prosperity Network.
                </div>

            @endif
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const verifyUrl = '{{ $verifyUrl ?? '' }}';
    const el = document.getElementById('qrcode');
    if (verifyUrl && el && typeof QRCode !== 'undefined') {
        new QRCode(el, {
            text: verifyUrl, width: 90, height: 90,
            colorDark: '#000000', colorLight: '#ffffff',
            correctLevel: QRCode.CorrectLevel.H
        });
    }
});

function shareVerification() {
    const url = window.location.href;
    if (navigator.share) {
        navigator.share({
            title: 'Africa Prosperity Network - Membership Verification',
            text: 'Verified member of Africa Prosperity Network',
            url
        }).catch(() => copyToClipboard(url));
    } else {
        copyToClipboard(url);
    }
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        const btn = document.querySelector('.btn-share');
        if (!btn) return;
        const orig = btn.innerHTML;
        btn.innerHTML = '<svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg> Copied!';
        btn.style.background = '#059669';
        setTimeout(() => { btn.innerHTML = orig; btn.style.background = ''; }, 2000);
    }).catch(() => alert('Press Ctrl+C to copy the verification link'));
}
</script>
@endsection