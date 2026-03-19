@extends('layouts.guest')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Urbanist:wght@300;400;500;600;700;800;900&display=swap');

    :root {
        --primary: 45 92% 47%;
        --primary-foreground: 0 0% 0%;
        --background: 0 0% 100%;
        --foreground: 222 47% 11%;
        --muted: 210 40% 96.1%;
        --muted-foreground: 215.4 16.3% 46.9%;
        --border: 214.3 31.8% 91.4%;
        --surface: 210 20% 98%;
        --radius: 12px;
        --shadow-md: 0 0 0 1px rgba(0,0,0,.03), 0 2px 4px rgba(0,0,0,.05), 0 12px 24px rgba(0,0,0,.05);
        --shadow-lg: 0 0 0 1px rgba(0,0,0,.03), 0 4px 8px rgba(0,0,0,.05), 0 20px 40px rgba(0,0,0,.08);
        --ease: cubic-bezier(0.2, 0, 0, 1);
    }

    body {
        font-family: 'Urbanist', sans-serif;
        background-color: hsl(var(--background));
        color: hsl(var(--foreground));
        -webkit-font-smoothing: antialiased;
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: 'Urbanist', sans-serif;
        letter-spacing: -0.03em;
        text-wrap: balance;
        line-height: 1.1;
    }
    p { text-wrap: pretty; line-height: 1.6; }

    /* Reveal Animations */
    .reveal {
        opacity: 0;
        transform: translateY(12px);
        transition: all 0.6s var(--ease);
    }
    .reveal.visible {
        opacity: 1;
        transform: translateY(0);
    }
    
    .stagger-item {
        opacity: 0;
        transform: translateY(12px);
        transition: all 0.5s var(--ease);
    }
    
    .stagger-item.visible {
        opacity: 1;
        transform: translateY(0);
    }
    
    .stagger-item:nth-child(1) { transition-delay: 0.1s; }
    .stagger-item:nth-child(2) { transition-delay: 0.2s; }
    .stagger-item:nth-child(3) { transition-delay: 0.3s; }
    .stagger-item:nth-child(4) { transition-delay: 0.4s; }

    /* Hero */
    .hero-container {
        position: relative;
        min-height: 85vh;
        display: flex;
        align-items: center;
        background: #020617;
        overflow: hidden;
        margin-top: -2rem;
    }
    .hero-image {
        position: absolute;
        inset: 0;
        background-image: linear-gradient(to right, rgba(2,6,23,0.95) 30%, rgba(2,6,23,0.4)),
                          url('https://membership.africaprosperitynetwork.com/wp-content/uploads/2026/03/Group-599.jpg');
        background-size: cover;
        background-position: center;
        z-index: 1;
    }

    /* Glass Card */
    .glass-card {
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow-md);
        transition: transform 0.2s var(--ease), box-shadow 0.2s var(--ease);
        padding: 2rem;
    }
    .glass-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    /* Dark Card */
    .glass-card-dark {
        background: hsl(var(--foreground));
        border-radius: var(--radius);
        box-shadow: var(--shadow-md);
        padding: 2.5rem;
        position: relative;
        overflow: hidden;
    }

    /* Stat */
    .stat-value {
        font-variant-numeric: tabular-nums;
        font-weight: 800;
        letter-spacing: -0.05em;
    }

    /* Timeline */
    .timeline-path {
        position: relative;
        padding-left: 2.5rem;
    }
    .timeline-path::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 1px;
        background: hsl(var(--border));
    }
    .timeline-path:last-child::before {
        display: none;
    }
    .timeline-node {
        position: absolute;
        left: -4px;
        top: 0.5rem;
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background: hsl(var(--primary));
        box-shadow: 0 0 0 4px white, 0 0 0 5px hsl(var(--primary));
    }

    /* Buttons */
    .btn-prosperity {
        background: hsl(var(--primary));
        color: black;
        font-weight: 600;
        padding: 0.75rem 1.75rem;
        border-radius: 8px;
        transition: all 0.2s var(--ease);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        font-size: 1rem;
    }
    .btn-prosperity:hover {
        filter: brightness(1.1);
        transform: translateY(-1px);
        color: black;
    }
    .btn-prosperity-lg {
        padding: 1rem 2.5rem;
        font-size: 1.1rem;
        border-radius: 10px;
    }

    .btn-outline-hero {
        background: transparent;
        color: white;
        font-weight: 600;
        padding: 0.75rem 1.75rem;
        border-radius: 8px;
        border: 1px solid rgba(255,255,255,0.2);
        transition: all 0.2s var(--ease);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        font-size: 1rem;
    }
    .btn-outline-hero:hover {
        background: rgba(255,255,255,0.05);
        color: white;
        transform: translateY(-1px);
    }

    .btn-outline-dark {
        background: transparent;
        color: hsl(var(--foreground));
        font-weight: 600;
        padding: 0.75rem 1.75rem;
        border-radius: 8px;
        border: 1px solid hsl(var(--border));
        transition: all 0.2s var(--ease);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }
    .btn-outline-dark:hover {
        background: hsl(var(--surface));
        transform: translateY(-1px);
    }

    /* Section backgrounds */
    .bg-surface { background: hsl(var(--surface)); }

    /* Value icon container */
    .icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: hsl(var(--primary) / 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.25rem;
    }
    .icon-box svg {
        width: 24px;
        height: 24px;
        color: hsl(var(--primary));
    }

    /* Benefit step number */
    .benefit-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: hsl(var(--primary) / 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.25rem;
    }
    .benefit-icon svg {
        width: 28px;
        height: 28px;
        color: hsl(var(--primary));
    }

    .benefit-number {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: hsl(var(--primary));
        color: black;
        font-weight: 700;
        font-size: 1.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }

    /* Section titles */
    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        position: relative;
    }
    
    .section-title-center {
        text-align: center;
    }

    /* Breadcrumb */
    .breadcrumb {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        background: rgba(217,169,23,0.1);
        color: hsl(var(--primary));
        border-radius: 9999px;
        font-size: 0.85rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 1.5rem;
    }
    
    .breadcrumb a {
        color: hsl(var(--primary));
        text-decoration: none;
    }
    
    .breadcrumb a:hover {
        text-decoration: underline;
    }

    /* Dot pattern */
    .dot-pattern {
        background-image: radial-gradient(white 1px, transparent 1px);
        background-size: 40px 40px;
    }

    /* Campaign card */
    .campaign-card {
        background: linear-gradient(135deg, hsl(var(--primary)), #8b5cf6);
        border-radius: 2rem;
        overflow: hidden;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-container { min-height: 70vh; }
        .hero-container h1 { font-size: 2.5rem !important; }
        .stats-grid { grid-template-columns: repeat(2, 1fr) !important; }
        .two-col { grid-template-columns: 1fr !important; }
        .four-col { grid-template-columns: repeat(2, 1fr) !important; }
        .three-col { grid-template-columns: 1fr !important; }
        .cta-inner { padding: 3rem 1.5rem !important; }
        .section-title { font-size: 2rem; }
    }
</style>

<!-- ==================== HERO ==================== -->
<section class="hero-container">
    <div class="hero-image"></div>
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 1.5rem; position: relative; z-index: 10; width: 100%;">
        <div style="max-width: 720px;">
            <div class="breadcrumb reveal">
                <a href="{{ route('member.dashboard') }}">Dashboard</a> • About Us
            </div>
            <h1 class="reveal" style="font-size: 4rem; font-weight: 800; color: white; margin-bottom: 1.5rem; transition-delay: 100ms; line-height: 1.1;">
                Africa <span style="color: hsl(var(--primary));">Prosperity</span> Network
            </h1>
            <p class="reveal hero-desc" style="font-size: 1.25rem; color: #cbd5e1; margin-bottom: 2.5rem; transition-delay: 200ms; max-width: 600px;">
                Building a borderless, prosperous Africa through unity, innovation, and collective action
            </p>
            <div class="reveal" style="display: flex; flex-wrap: wrap; gap: 1rem; transition-delay: 300ms;">
                <a href="#mission" class="btn-prosperity btn-prosperity-lg">
                    Learn More
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
                <a href="{{ route('member.benefits') }}" class="btn-outline-hero btn-prosperity-lg">View Benefits</a>
            </div>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="scroll-indicator" onclick="document.getElementById('mission').scrollIntoView({behavior: 'smooth'})" style="position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%); z-index: 10; cursor: pointer; animation: bounce 2s infinite;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
            <path d="M12 5v14M5 12l7 7 7-7" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>
</section>

<style>
@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {transform: translateX(-50%) translateY(0);}
    40% {transform: translateX(-50%) translateY(-20px);}
    60% {transform: translateX(-50%) translateY(-10px);}
}
</style>

<!-- ==================== MAIN CONTENT ==================== -->
<div class="bg-surface" style="padding: 6rem 0;">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 1.5rem;">
        
        <!-- ==================== WHO WE ARE ==================== -->
        <div id="mission" class="reveal" style="margin-bottom: 6rem;">
            <h2 class="section-title">Who We Are</h2>
            <div class="two-col" style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center;">
                <div class="reveal" style="transition-delay: 100ms;">
                    <p style="color: hsl(var(--muted-foreground)); font-size: 1.1rem; margin-bottom: 1.5rem;">
                        The <strong style="color: hsl(var(--primary));">Africa Prosperity Network (APN)</strong> is a pan-African organization dedicated to driving economic transformation and shared prosperity across the continent. Founded in 2020, we bring together leaders, innovators, entrepreneurs, and change-makers committed to building a united and prosperous Africa.
                    </p>
                    <p style="color: hsl(var(--muted-foreground)); font-size: 1.1rem; margin-bottom: 2rem;">
                        We believe that Africa's greatest resource is its people, and by breaking down barriers and fostering collaboration, we can unlock the continent's immense potential. Our network spans across 54 countries, creating a community of individuals and organizations working towards a common goal: a borderless, prosperous Africa.
                    </p>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="display: flex;">
                            <img class="w-10 h-10 rounded-full border-2 border-white" src="https://randomuser.me/api/portraits/women/44.jpg" alt="Member" style="border-radius: 50%; width: 40px; height: 40px; object-fit: cover; margin-right: -8px;">
                            <img class="w-10 h-10 rounded-full border-2 border-white" src="https://randomuser.me/api/portraits/men/46.jpg" alt="Member" style="border-radius: 50%; width: 40px; height: 40px; object-fit: cover; margin-right: -8px;">
                            <img class="w-10 h-10 rounded-full border-2 border-white" src="https://randomuser.me/api/portraits/women/68.jpg" alt="Member" style="border-radius: 50%; width: 40px; height: 40px; object-fit: cover; margin-right: -8px;">
                            <img class="w-10 h-10 rounded-full border-2 border-white" src="https://randomuser.me/api/portraits/men/75.jpg" alt="Member" style="border-radius: 50%; width: 40px; height: 40px; object-fit: cover;">
                        </div>
                        <span style="color: hsl(var(--muted-foreground)); font-size: 0.9rem;">Join 10,000+ members across Africa</span>
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
                    @php
                        $miniStats = [
                            ['val' => '54', 'label' => 'African Countries'],
                            ['val' => '10k+', 'label' => 'Active Members'],
                            ['val' => '100+', 'label' => 'Partner Orgs'],
                            ['val' => '$5M+', 'label' => 'Impact Fund'],
                        ];
                    @endphp
                    @foreach($miniStats as $i => $s)
                    <div class="glass-card stagger-item" style="padding: 1.5rem; text-align: center;">
                        <div class="stat-value" style="font-size: 1.75rem; color: hsl(var(--primary)); margin-bottom: 0.25rem;">{{ $s['val'] }}</div>
                        <div style="font-size: 0.75rem; font-weight: 600; color: hsl(var(--muted-foreground)); text-transform: uppercase; letter-spacing: 0.1em;">{{ $s['label'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- ==================== BORDERLESS CAMPAIGN ==================== -->
        <div class="reveal" style="margin-bottom: 6rem;">
            <div class="campaign-card" style="display: grid; grid-template-columns: 1fr 1fr; background: linear-gradient(135deg, hsl(var(--primary)), #8b5cf6);">
                <div style="padding: 4rem;">
                    <h2 style="font-size: 2.5rem; font-weight: 700; color: black; margin-bottom: 1.5rem;">The Borderless Campaign</h2>
                    <p style="color: rgba(0,0,0,0.7); font-size: 1.1rem; line-height: 1.6; margin-bottom: 2rem;">
                        Our flagship initiative advocating for the removal of trade barriers and the free movement of people, goods, and services across Africa.
                    </p>
                    <ul style="margin-bottom: 2.5rem;">
                        @php
                            $campaignFeatures = [
                                ['title' => 'Free Movement', 'desc' => 'Advocating for visa-free travel across all African countries'],
                                ['title' => 'Trade Integration', 'desc' => 'Removing barriers to cross-border trade and investment'],
                                ['title' => 'Digital Unity', 'desc' => 'Creating a digital single market for African businesses'],
                            ];
                        @endphp
                        @foreach($campaignFeatures as $f)
                        <li style="display: flex; align-items: flex-start; gap: 0.75rem; margin-bottom: 1rem;">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" style="flex-shrink: 0; margin-top: 0.2rem;">
                                <circle cx="10" cy="10" r="8" fill="black" fill-opacity="0.2"/>
                                <path d="M6 10L9 13L14 7" stroke="black" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            <span><strong style="color: black;">{{ $f['title'] }}:</strong> <span style="color: rgba(0,0,0,0.7);">{{ $f['desc'] }}</span></span>
                        </li>
                        @endforeach
                    </ul>
                    <a href="#" class="btn-prosperity" style="background: black; color: white; padding: 0.75rem 2rem;">
                        Learn More About the Campaign
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor"><path d="M6 12L10 8L6 4" stroke-width="2"/></svg>
                    </a>
                </div>
                <div style="background-image: url('https://membership.africaprosperitynetwork.com/wp-content/uploads/2026/03/Group-600.jpg'); background-size: cover; background-position: center; min-height: 400px;"></div>
            </div>
        </div>

        <!-- ==================== MISSION & VISION ==================== -->
        <div class="reveal" style="margin-bottom: 6rem;">
            <h2 class="section-title section-title-center">Our Mission & Vision</h2>
            <div class="two-col" style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-top: 3rem;">
                <div class="glass-card reveal" style="padding: 2.5rem;">
                    <div class="icon-box" style="width: 64px; height: 64px; border-radius: 16px;">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 1rem;">Our Mission</h3>
                    <p style="color: hsl(var(--muted-foreground)); font-size: 1.05rem;">
                        To catalyze Africa's economic transformation through strategic partnerships, policy advocacy, and community building. We work to create an enabling environment for businesses to thrive, innovations to flourish, and people to connect across borders.
                    </p>
                </div>
                <div class="glass-card reveal" style="padding: 2.5rem; transition-delay: 100ms;">
                    <div class="icon-box" style="width: 64px; height: 64px; border-radius: 16px; background: hsl(var(--primary) / 0.15);">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </div>
                    <h3 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 1rem;">Our Vision</h3>
                    <p style="color: hsl(var(--muted-foreground)); font-size: 1.05rem;">
                        A fully integrated, prosperous, and borderless Africa where every citizen has the opportunity to thrive. We envision a continent where the movement of people, goods, and ideas is seamless, and where collective prosperity is the norm, not the exception.
                    </p>
                </div>
            </div>
        </div>

        <!-- ==================== CORE VALUES ==================== -->
        <div class="reveal" style="margin-bottom: 6rem;">
            <h2 class="section-title section-title-center">Our Core Values</h2>
            <div class="four-col" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem; margin-top: 3rem;">
                @php
                    $values = [
                        ['icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>', 'title' => 'Unity', 'desc' => 'We believe in the power of coming together across borders and cultures.'],
                        ['icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>', 'title' => 'Innovation', 'desc' => 'We champion creative solutions to Africa\'s challenges.'],
                        ['icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9 12l2 2 4-4"/></svg>', 'title' => 'Integrity', 'desc' => 'We operate with transparency and ethical leadership.'],
                        ['icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>', 'title' => 'Impact', 'desc' => 'We measure success by tangible positive change.'],
                    ];
                @endphp
                @foreach($values as $i => $v)
                <div class="glass-card stagger-item" style="padding: 2rem; text-align: center;">
                    <div class="icon-box" style="margin: 0 auto 1.25rem;">{!! $v['icon'] !!}</div>
                    <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem;">{{ $v['title'] }}</h3>
                    <p style="color: hsl(var(--muted-foreground));">{{ $v['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- ==================== WHY MEMBERSHIP MATTERS ==================== -->
        <div class="reveal" style="margin-bottom: 6rem;">
            <div style="max-width: 800px; margin: 0 auto 3rem; text-align: center;">
                <h2 class="section-title section-title-center">Why Your Membership Matters</h2>
                <p style="font-size: 1.1rem; color: hsl(var(--muted-foreground));">
                    As a member, you're not just supporting a cause – you're becoming an integral part of a movement that's shaping Africa's future.
                </p>
            </div>
            <div class="three-col" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem;">
                @php
                    $benefits = [
                        ['number' => '1', 'title' => 'Amplify Your Voice', 'desc' => 'Join thousands of advocates pushing for policy changes that matter.'],
                        ['number' => '2', 'title' => 'Network & Collaborate', 'desc' => 'Connect with like-minded individuals and organizations across the continent.'],
                        ['number' => '3', 'title' => 'Drive Real Change', 'desc' => 'Your membership directly funds initiatives that create tangible impact.'],
                    ];
                @endphp
                @foreach($benefits as $i => $b)
                <div class="glass-card stagger-item" style="padding: 2rem; text-align: center;">
                    <div class="benefit-number">{{ $b['number'] }}</div>
                    <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem;">{{ $b['title'] }}</h3>
                    <p style="color: hsl(var(--muted-foreground));">{{ $b['desc'] }}</p>
                </div>
                @endforeach
            </div>
            <div style="text-align: center; margin-top: 3rem;">
                <a href="{{ route('member.benefits') }}" class="btn-prosperity btn-prosperity-lg">
                    Explore Your Member Benefits
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2"/></svg>
                </a>
            </div>
        </div>

        <!-- ==================== IMPACT STATS ==================== -->
        <div class="reveal" style="margin-bottom: 6rem;">
            <h2 class="section-title section-title-center">Our Impact</h2>
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem; margin-top: 3rem;">
                @php
                    $impactStats = [
                        ['val' => '54', 'label' => 'African Countries'],
                        ['val' => '10k+', 'label' => 'Active Members'],
                        ['val' => '100+', 'label' => 'Partner Orgs'],
                        ['val' => '$5M+', 'label' => 'Funds Raised'],
                        ['val' => '50+', 'label' => 'Policy Changes'],
                        ['val' => '200+', 'label' => 'Events Hosted'],
                        ['val' => '15k+', 'label' => 'Jobs Created'],
                        ['val' => '1.4B', 'label' => 'People Impacted'],
                    ];
                @endphp
                @foreach($impactStats as $i => $s)
                <div class="glass-card stagger-item" style="padding: 2rem; text-align: center;">
                    <div class="stat-value" style="font-size: 2.25rem; color: hsl(var(--primary)); margin-bottom: 0.25rem;">{{ $s['val'] }}</div>
                    <div style="font-size: 0.85rem; font-weight: 600; color: hsl(var(--muted-foreground)); text-transform: uppercase; letter-spacing: 0.08em;">{{ $s['label'] }}</div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- ==================== JOURNEY TIMELINE ==================== -->
        <div class="reveal" style="margin-bottom: 6rem;">
            <h2 class="section-title section-title-center">Our Journey</h2>
            <div style="max-width: 600px; margin: 3rem auto 0;">
                @php
                    $milestones = [
                        ['year' => '2020', 'title' => 'APN Founded', 'desc' => 'Launched with a vision to connect Africa\'s changemakers.'],
                        ['year' => '2021', 'title' => 'Borderless Campaign Launch', 'desc' => 'Introduced our flagship initiative for free movement across Africa.'],
                        ['year' => '2022', 'title' => '10,000 Members Milestone', 'desc' => 'Reached 10,000 active members across 54 countries.'],
                        ['year' => '2023', 'title' => 'First Annual Prosperity Summit', 'desc' => 'Hosted 500+ leaders from across the continent.'],
                        ['year' => '2024', 'title' => '$5M Impact Fund', 'desc' => 'Launched fund to support cross-border initiatives.'],
                    ];
                @endphp
                @foreach($milestones as $i => $m)
                <div class="timeline-path reveal" style="transition-delay: {{ $i * 80 }}ms; padding-bottom: 2rem;">
                    <div class="timeline-node"></div>
                    <span style="color: hsl(var(--primary)); font-weight: 700; font-size: 0.875rem; letter-spacing: -0.02em;">{{ $m['year'] }}</span>
                    <h4 style="font-size: 1.25rem; font-weight: 700; margin-top: 0.25rem;">{{ $m['title'] }}</h4>
                    <p style="color: hsl(var(--muted-foreground)); margin-top: 0.5rem;">{{ $m['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- ==================== CTA ==================== -->
        <div class="reveal">
            <div style="background: hsl(var(--foreground)); border-radius: 2rem; padding: 5rem 3rem; text-align: center; position: relative; overflow: hidden;">
                <div style="position: relative; z-index: 1; max-width: 640px; margin: 0 auto;">
                    <h2 style="font-size: 2.75rem; font-weight: 700; color: white; margin-bottom: 1.5rem;">Ready to Make a Difference?</h2>
                    <p style="color: #94a3b8; font-size: 1.1rem; margin-bottom: 2.5rem;">
                        Join thousands of members across Africa who are building a prosperous, borderless future.
                    </p>
                    <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                        <a href="{{ route('member.dashboard') }}" class="btn-prosperity btn-prosperity-lg">Go to Dashboard</a>
                        <a href="{{ route('member.benefits') }}" class="btn-outline-hero btn-prosperity-lg">View Benefits</a>
                    </div>
                </div>
                <div class="dot-pattern" style="position: absolute; inset: 0; opacity: 0.07;"></div>
            </div>
        </div>
    </div>
</div>

<script>
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
    
    document.querySelectorAll('.reveal, .stagger-item').forEach(el => observer.observe(el));
    
    document.querySelector('.scroll-indicator')?.addEventListener('click', function() {
        document.getElementById('mission').scrollIntoView({ behavior: 'smooth' });
    });
</script>
@endsection