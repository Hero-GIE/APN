@extends('layouts.guest')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700;800;900&family=Open+Sans:wght@300;400;500;600;700&display=swap');

    * { box-sizing: border-box; }
    body { font-family: 'Open Sans', sans-serif; overflow-x: hidden; }
    h1,h2,h3,h4,h5,h6,.font-urbanist { font-family: 'Urbanist', sans-serif !important; }

    /* ── KEYFRAMES ── */
    @keyframes float       { 0%,100%{transform:translateY(0)}            50%{transform:translateY(-20px)} }
    @keyframes floatReverse{ 0%,100%{transform:translateY(0) rotate(0)}  50%{transform:translateY(20px) rotate(5deg)} }
    @keyframes pulse-glow  { 0%,100%{opacity:.5;transform:scale(1)}      50%{opacity:1;transform:scale(1.08)} }
    @keyframes shimmer     { 0%{background-position:-200% center}        100%{background-position:200% center} }
    @keyframes fadeUp      { from{opacity:0;transform:translateY(40px)}  to{opacity:1;transform:translateY(0)} }
    @keyframes borderPulse { 0%,100%{box-shadow:0 0 0 0 rgba(212,175,55,.4)} 50%{box-shadow:0 0 0 12px rgba(212,175,55,0)} }
    @keyframes slideInNav  { from{opacity:0;transform:translateY(-100%)} to{opacity:1;transform:translateY(0)} }
    @keyframes bounce      { 0%,100%{transform:translateY(0)}            40%{transform:translateY(-12px)}  60%{transform:translateY(-6px)} }
    @keyframes spinSlow    { from{transform:rotate(0deg)}                to{transform:rotate(360deg)} }
    @keyframes orb1        { 0%{transform:translate(0,0) scale(1)}       33%{transform:translate(60px,-40px) scale(1.1)} 66%{transform:translate(-30px,50px) scale(.95)} 100%{transform:translate(0,0) scale(1)} }
    @keyframes orb2        { 0%{transform:translate(0,0) scale(1)}       33%{transform:translate(-50px,30px) scale(1.05)} 66%{transform:translate(40px,-60px) scale(1.1)} 100%{transform:translate(0,0) scale(1)} }
    @keyframes slowZoom    { from{transform:scale(1.03)}                  to{transform:scale(1.09)} }
    @keyframes scrollLine  { 0%{transform:scaleY(0);transform-origin:top} 50%{transform:scaleY(1);transform-origin:top} 51%{transform-origin:bottom} 100%{transform:scaleY(0);transform-origin:bottom} }
    @keyframes floatBob    { 0%,100%{transform:translateY(0)}            50%{transform:translateY(-14px)} }
    @keyframes pulse       { 0%,100%{opacity:1;transform:scale(1)}       50%{opacity:.5;transform:scale(1.5)} }
    @keyframes orbFloat    { 0%,100%{transform:translateY(0) scale(1)}   50%{transform:translateY(-30px) scale(1.05)} }
    @keyframes timelineDot { from{transform:scale(0);opacity:0}          to{transform:scale(1);opacity:1} }

    /* ── ANIMATION CLASSES ── */
    .animate-float      { animation: float 6s ease-in-out infinite; }
    .animate-float-rev  { animation: floatReverse 7s ease-in-out infinite; }
    .animate-pulse-glow { animation: pulse-glow 4s ease-in-out infinite; }
    .animate-spin-slow  { animation: spinSlow 20s linear infinite; }
    .animate-bounce     { animation: bounce 2.5s ease-in-out infinite; }
    .animate-nav        { animation: slideInNav 0.6s cubic-bezier(0.2,0,0,1) both; }

    /* ── SHIMMER TEXT (gold version) ── */
    .shimmer-text {
        background: linear-gradient(90deg,#fff 20%,#fbbf24 40%,#fff 60%,#f59e0b 80%,#fff 100%);
        background-size: 200% auto;
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: shimmer 4s linear infinite;
    }

    /* ── SCROLL REVEAL ── */
    .reveal {
        opacity:0; transform:translateY(40px);
        transition: opacity 0.7s cubic-bezier(0.2,0,0,1), transform 0.7s cubic-bezier(0.2,0,0,1);
    }
    .reveal.from-left  { transform: translateX(-40px); }
    .reveal.from-right { transform: translateX(40px); }
    .reveal.zoom       { transform: scale(0.85); }
    .reveal.visible    { opacity:1 !important; transform:none !important; }
    .reveal-d1 { transition-delay:.1s; }
    .reveal-d2 { transition-delay:.2s; }
    .reveal-d3 { transition-delay:.3s; }
    .reveal-d4 { transition-delay:.4s; }

    /* ── BRAND COLOURS ── */
    :root {
        --gold: #D4AF37;
        --gold-light: #F0D060;
        --gold-dim: rgba(212,175,55,0.15);
        --dark: #020617;
        --surface: #f8f7f4;
        --text: #0f172a;
        --muted: #64748b;
        --border: #e2e8f0;
        --radius: 16px;
    }
    .gradient-text {
        background: linear-gradient(135deg,#f59e0b,#d97706);
        -webkit-background-clip:text; -webkit-text-fill-color:transparent;
        background-clip:text;
    }

    /* ── NAV ── */
    .nav-link { position:relative; color:#374151; text-decoration:none; transition:color .2s; }
    .nav-link::after {
        content:''; position:absolute; bottom:-2px; left:0;
        width:0; height:2px;
        background:linear-gradient(90deg,#f59e0b,#d97706);
        border-radius:2px; transition:width .3s ease;
    }
    .nav-link:hover { color:#f59e0b; }
    .nav-link:hover::after { width:100%; }

    /* ── HERO ── */
    .hero {
        position:relative; height:68vh; min-height:480px; max-height:700px;
        display:flex; align-items:center; background:var(--dark); overflow:visible;
    }
    .hero-bg {
        position:fixed; top:0; left:0; right:0;
        height:68vh; min-height:480px; max-height:700px;
        background-image:url('https://membership.africaprosperitynetwork.com/wp-content/uploads/2026/03/Group-599.jpg');
        background-size:cover; background-position:center;
        opacity:0.45; z-index:0;
        animation: slowZoom 18s ease-in-out infinite alternate;
    }
    .hero-overlay-1 {
        position:fixed; top:0; left:0; right:0;
        height:68vh; min-height:480px; max-height:700px;
        background:linear-gradient(135deg,rgba(2,6,2,.75) 0%,rgba(2,6,23,.45) 55%,rgba(10,15,30,.2) 100%);
        z-index:1;
    }
    .hero-overlay-2 {
        position:fixed; top:0; left:0; right:0;
        height:68vh; min-height:480px; max-height:700px;
        background:radial-gradient(ellipse 80% 60% at 10% 80%,rgba(212,175,55,.18) 0%,transparent 60%);
        z-index:1;
    }
    .hero-overlay-3 {
        position:fixed; top:0; left:0; right:0;
        height:68vh; min-height:480px; max-height:700px;
        background:radial-gradient(ellipse 60% 50% at 85% 20%,rgba(245,158,11,.1) 0%,transparent 55%);
        z-index:1;
    }
    .hero-dots {
        position:fixed; top:0; left:0; right:0;
        height:68vh; min-height:480px; max-height:700px;
        background-image:radial-gradient(rgba(212,175,55,.15) 1px,transparent 1px);
        background-size:48px 48px;
        mask-image:linear-gradient(135deg,transparent 30%,black 70%);
        pointer-events:none; z-index:1;
    }

    /* Rings */
    .hero-ring {
        position:absolute; border-radius:50%;
        border:1px solid rgba(212,175,55,.1); pointer-events:none; z-index:2;
    }
    .hero-ring-1 { width:500px;height:500px;top:50%;left:50%;transform:translate(-50%,-50%);animation:spinSlow 30s linear infinite; }
    .hero-ring-2 { width:700px;height:700px;top:50%;left:50%;transform:translate(-50%,-50%);animation:spinSlow 45s linear infinite reverse;border-color:rgba(212,175,55,.06); }

    /* Orbs */
    .hero-orb { position:absolute;border-radius:50%;filter:blur(80px);pointer-events:none;z-index:2; }
    .orb-1 { width:400px;height:400px;background:rgba(212,175,55,.09);bottom:-100px;left:-100px;animation:orb1 14s ease-in-out infinite; }
    .orb-2 { width:300px;height:300px;background:rgba(245,158,11,.07);top:50px;right:200px;animation:orb2 17s ease-in-out infinite; }
    .orb-3 { width:200px;height:200px;background:rgba(212,175,55,.05);top:30%;right:15%;animation:orbFloat 9s 2s ease-in-out infinite; }

    /* Floating icons */
    .hero-float-icon {
        position:absolute;border-radius:12px;
        background:rgba(255,255,255,.1);backdrop-filter:blur(8px);
        border:1px solid rgba(255,255,255,.15);
        display:flex;align-items:center;justify-content:center;
        color:rgba(255,255,255,.7);font-size:1.1rem;
        z-index:3;pointer-events:none;
    }
    .fi-1 { width:44px;height:44px;top:28%;right:12%;animation:floatBob 5s ease-in-out infinite; }
    .fi-2 { width:38px;height:38px;top:55%;left:6%;animation:floatBob 7s 1s ease-in-out infinite;border-radius:50%; }
    .fi-3 { width:34px;height:34px;top:38%;left:9%;animation:floatBob 6s 2s ease-in-out infinite; }

    /* Hero circle */
    .hero-circle {
        position:absolute;right:-180px;top:50%;transform:translateY(-50%);
        width:700px;height:700px;border-radius:50%;
        border:1px solid rgba(212,175,55,.12);pointer-events:none;z-index:2;
    }
    .hero-circle::before { content:'';position:absolute;inset:40px;border-radius:50%;border:1px solid rgba(212,175,55,.08); }
    .hero-circle::after  { content:'';position:absolute;inset:100px;border-radius:50%;border:1px solid rgba(212,175,55,.05); }

    .hero-inner { position:relative;z-index:10;max-width:1200px;margin:0 auto;padding:5rem 2rem 4rem;width:100%; }

    /* Hero text elements */
    .hero-breadcrumb {
        display:inline-flex;align-items:center;gap:.4rem;
        padding:.4rem 1rem;border:1px solid rgba(255,255,255,.15);border-radius:999px;
        font-size:.8rem;font-weight:600;letter-spacing:.12em;text-transform:uppercase;
        color:rgba(255,255,255,.7);margin-bottom:2rem;
        backdrop-filter:blur(8px);background:rgba(255,255,255,.04);
        opacity:0;animation:fadeUp .8s .1s ease forwards;
    }
    .hero-breadcrumb a { color:rgba(255,255,255,.7);text-decoration:none;transition:color .2s; }
    .hero-breadcrumb a:hover { color:#f59e0b; }
    .hero-breadcrumb .sep { color:rgba(255,255,255,.3); }

    .hero-tag {
        display:inline-flex;align-items:center;gap:.6rem;
        padding:.35rem 1rem;
        background:rgba(245,158,11,.15);border:1px solid rgba(245,158,11,.3);border-radius:999px;
        font-size:.8rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;
        color:#f59e0b;margin-bottom:1.5rem;
        opacity:0;animation:fadeUp .8s .25s ease forwards;
    }
    .hero-tag-dot { width:6px;height:6px;border-radius:50%;background:#f59e0b;animation:pulse 2s infinite; }

    .hero-h1 {
        font-size:clamp(3.5rem,8vw,6.5rem);
        font-weight:900;color:white;margin:0 0 .2rem;line-height:.95;
        opacity:0;animation:fadeUp .9s .4s ease forwards;
    }
    .hero-h1 .line-gold {
        display:block;font-size:clamp(3rem,7vw,6rem);font-style:italic;
        background:linear-gradient(90deg,#f59e0b,#fbbf24,#f59e0b);
        -webkit-background-clip:text;-webkit-text-fill-color:transparent;
        background-clip:text;background-size:200%;
        animation:fadeUp .9s .4s ease forwards,shimmer 4s 1.5s linear infinite;
    }
    .hero-sub {
        font-size:clamp(1.1rem,2.2vw,1.35rem);color:rgba(255,255,255,.65);
        max-width:520px;margin:1.5rem 0 2.5rem;font-weight:400;
        opacity:0;animation:fadeUp .8s .6s ease forwards;
    }
    .hero-cta { display:flex;flex-wrap:wrap;gap:1rem;opacity:0;animation:fadeUp .8s .8s ease forwards; }

    /* Scroll cue */
    .scroll-cue {
        position:absolute;bottom:2rem;left:50%;transform:translateX(-50%);
        z-index:10;display:flex;flex-direction:column;align-items:center;gap:.5rem;
        cursor:pointer;opacity:0;animation:fadeUp 1s 1.4s ease forwards;
    }
    .scroll-cue-mouse { width:22px;height:34px;border:2px solid rgba(255,255,255,.4);border-radius:11px;display:flex;justify-content:center;padding-top:5px; }
    .scroll-cue-wheel { width:3px;height:7px;background:rgba(255,255,255,.6);border-radius:2px;animation:floatBob 1.8s ease-in-out infinite; }
    .scroll-cue-text  { font-size:.65rem;letter-spacing:.15em;text-transform:uppercase;color:rgba(255,255,255,.35);font-weight:600; }

    /* ── PAGE CONTENT ── */
    .page-content { position:relative;z-index:20;background:var(--surface); }

    /* ── SECTIONS ── */
    .section     { padding:7rem 0; }
    .section-alt { background:white; }
    .container   { max-width:1200px;margin:0 auto;padding:0 2rem; }

    .section-eyebrow {
        display:inline-block;font-size:.72rem;font-weight:800;
        letter-spacing:.16em;text-transform:uppercase;color:#f59e0b;margin-bottom:1.25rem;
    }
    .section-eyebrow::before { content:'—';margin-right:.5rem;opacity:.5; }
    .section-h2 { font-size:clamp(2.2rem,4vw,3.2rem);font-weight:800;color:var(--text);margin:0 0 1.5rem; }
    .section-h2-center { text-align:center; }

    /* ── BUTTONS ── */
    .btn-gold {
        display:inline-flex;align-items:center;gap:.6rem;
        padding:.95rem 2rem;background:#f59e0b;color:#000;
        font-weight:700;font-size:1rem;border-radius:12px;
        text-decoration:none;transition:all .25s ease;position:relative;overflow:hidden;
    }
    .btn-gold::before { content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(255,255,255,.2),transparent);opacity:0;transition:opacity .25s; }
    .btn-gold:hover { transform:translateY(-3px);box-shadow:0 14px 32px rgba(245,158,11,.45);color:#000; }
    .btn-gold:hover::before { opacity:1; }

    .btn-ghost {
        display:inline-flex;align-items:center;gap:.6rem;
        padding:.95rem 2rem;background:rgba(255,255,255,.06);
        color:rgba(255,255,255,.85);font-weight:600;font-size:1rem;
        border-radius:12px;text-decoration:none;border:1px solid rgba(255,255,255,.14);
        backdrop-filter:blur(8px);transition:all .25s ease;
    }
    .btn-ghost:hover { background:rgba(255,255,255,.12);color:white;transform:translateY(-3px); }

    .btn-gold-sm { display:inline-flex;align-items:center;gap:.5rem;padding:.75rem 1.5rem;background:#f59e0b;color:#000;font-weight:700;font-size:.9rem;border-radius:10px;text-decoration:none;transition:all .25s ease; }
    .btn-gold-sm:hover { filter:brightness(1.1);transform:translateY(-2px);box-shadow:0 8px 20px rgba(245,158,11,.35);color:#000; }

    /* ── CARDS ── */
    .card {
        background:white;border-radius:var(--radius);border:1px solid var(--border);
        padding:2rem;transition:all .3s cubic-bezier(.2,0,0,1);
        position:relative;overflow:hidden;
    }
    .card::before {
        content:'';position:absolute;inset:0;
        background:linear-gradient(135deg,rgba(245,158,11,.04),transparent);
        opacity:0;transition:opacity .3s;
    }
    .card:hover { border-color:rgba(245,158,11,.4);box-shadow:0 10px 36px rgba(245,158,11,.1),0 2px 8px rgba(0,0,0,.04);transform:translateY(-4px); }
    .card:hover::before { opacity:1; }
    .card:hover .icon-box { background:#f59e0b;border-color:#f59e0b; }
    .card:hover .icon-box svg { color:white; }

    .icon-box {
        width:52px;height:52px;border-radius:14px;
        background:rgba(245,158,11,.15);border:1px solid rgba(245,158,11,.2);
        display:flex;align-items:center;justify-content:center;margin-bottom:1.5rem;transition:all .3s;
    }
    .icon-box svg { width:24px;height:24px;color:#f59e0b;transition:color .3s; }
    .icon-box-lg { width:64px;height:64px;border-radius:18px; }
    .icon-box-lg svg { width:32px;height:32px; }

    /* ── STAT CARDS ── */
    .stat-card {
        background:white;border-radius:var(--radius);border:1px solid var(--border);
        padding:1.75rem;text-align:center;transition:all .3s cubic-bezier(.2,0,0,1);
        position:relative;overflow:hidden;
    }
    .stat-card::after {
        content:'';position:absolute;bottom:0;left:0;right:0;height:3px;
        background:linear-gradient(90deg,#f59e0b,#fbbf24);
        transform:scaleX(0);transform-origin:left;transition:transform .35s ease;
    }
    .stat-card:hover { border-color:rgba(245,158,11,.4);box-shadow:0 8px 28px rgba(245,158,11,.08);transform:translateY(-3px); }
    .stat-card:hover::after { transform:scaleX(1); }
    .stat-val   { font-size:2.4rem;font-weight:900;color:#f59e0b;letter-spacing:-.05em;line-height:1; }
    .stat-label { font-size:.72rem;text-transform:uppercase;letter-spacing:.1em;color:var(--muted);font-weight:700;margin-top:.4rem; }

    /* ── HERO STAT CARDS (on parallax) ── */
    .hero-stat-card { background:rgba(255,255,255,.12);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,.25); }

    /* ── CAMPAIGN ── */
    .campaign-wrap {
        border-radius:24px;overflow:hidden;display:grid;grid-template-columns:1fr 1fr;
        background:var(--dark);transition:box-shadow .3s;
    }
    .campaign-wrap:hover { box-shadow:0 24px 60px rgba(0,0,0,.3); }
    .campaign-content { padding:4rem; }
    .campaign-img {
        background-image:url('https://membership.africaprosperitynetwork.com/wp-content/uploads/2026/03/Group-600.jpg');
        background-size:cover;background-position:center;min-height:420px;position:relative;
        transition:transform .6s ease;
    }
    .campaign-wrap:hover .campaign-img { transform:scale(1.03); }
    .campaign-img::before { content:'';position:absolute;inset:0;background:linear-gradient(to right,var(--dark) 0%,transparent 40%); }

    /* ── DIVIDERS ── */
    .divider        { width:48px;height:3px;background:#f59e0b;border-radius:2px;margin:0 0 2rem; }
    .divider-center { margin:0 auto 2rem; }

    /* ── TICKER (stats band) ── */
    .ticker-section { background:linear-gradient(135deg,#fffbeb 0%,#fef3c7 100%); }

    /* ── FEATURE CARDS ── */
    .feature-card { transition:all .35s cubic-bezier(.2,0,0,1);position:relative;overflow:hidden; }
    .feature-card::before { content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(245,158,11,.05),transparent);opacity:0;transition:opacity .3s; }
    .feature-card:hover { transform:translateY(-10px);box-shadow:0 24px 40px -8px rgba(245,158,11,.2); }
    .feature-card:hover::before { opacity:1; }
    .feature-card:hover .feature-icon { animation:bounce 1s ease-in-out; }
    .feature-icon {
        width:64px;height:64px;
        background:linear-gradient(135deg,#fef3c7,#fde68a);
        border-radius:50%;display:flex;align-items:center;justify-content:center;
        margin:0 auto 1.25rem;transition:all .3s;
        box-shadow:0 4px 12px rgba(245,158,11,.15);
    }
    .feature-card:hover .feature-icon { background:linear-gradient(135deg,#f59e0b,#d97706);box-shadow:0 8px 20px rgba(245,158,11,.4); }
    .feature-card:hover .feature-icon i { color:white !important; }

    /* ── STEP CARDS ── */
    .step-card {
        background:rgba(255,255,255,.10);backdrop-filter:blur(10px);
        border:1px solid rgba(255,255,255,.22);border-radius:1.25rem;
        padding:2rem;text-align:center;transition:all .35s cubic-bezier(.2,0,0,1);
    }
    .step-card:hover { background:rgba(255,255,255,.20);transform:translateY(-6px) scale(1.02);border-color:rgba(255,255,255,.45);box-shadow:0 20px 40px rgba(0,0,0,.2); }
    .step-num {
        width:72px;height:72px;background:rgba(255,255,255,.15);backdrop-filter:blur(8px);
        border:2px solid rgba(255,255,255,.4);border-radius:50%;
        display:flex;align-items:center;justify-content:center;
        margin:0 auto 1.25rem;font-size:1.75rem;font-weight:800;color:white;
        transition:all .3s;animation:borderPulse 3s infinite;
    }
    .step-card:hover .step-num { background:rgba(255,255,255,.30);transform:scale(1.1); }

    /* ── PARALLAX ── */
    .parallax-section { position:relative;overflow:hidden;min-height:520px;display:flex;align-items:center; }
    .parallax-bg { position:absolute;inset:-25%;background-size:cover;background-position:center;will-change:transform;z-index:0; }
    .parallax-overlay { position:absolute;inset:0;z-index:1; }
    .parallax-content { position:relative;z-index:3;width:100%; }

    .parallax-badge {
        display:inline-flex;align-items:center;gap:.5rem;
        padding:.35rem 1rem;background:rgba(245,158,11,.15);border:1px solid rgba(245,158,11,.35);border-radius:999px;
        font-size:.75rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:#f59e0b;margin-bottom:1.5rem;
    }
    .parallax-h2 { font-size:clamp(2.2rem,5vw,3.8rem);font-weight:900;color:white;line-height:1.05;margin:0 0 1.25rem;letter-spacing:-.03em; }
    .parallax-p  { font-size:clamp(1rem,2vw,1.15rem);color:rgba(255,255,255,.7);max-width:560px;line-height:1.7;margin-bottom:2rem; }
    .parallax-stats { display:flex;flex-wrap:wrap;gap:2.5rem;margin-top:2rem; }
    .parallax-stat-val   { font-size:2.2rem;font-weight:900;color:#f59e0b;line-height:1;letter-spacing:-.04em; }
    .parallax-stat-label { font-size:.72rem;text-transform:uppercase;letter-spacing:.1em;color:rgba(255,255,255,.45);font-weight:700;margin-top:.25rem; }
    .parallax-split { display:grid;grid-template-columns:1fr 1fr;gap:4rem;align-items:center; }

    /* Glassmorphism parallax card */
    .parallax-card {
        background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.1);
        border-radius:14px;padding:1.5rem;backdrop-filter:blur(8px);
        transition:all .3s cubic-bezier(.2,0,0,1);position:relative;overflow:hidden;
    }
    .parallax-card::before { content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(245,158,11,.05),transparent);opacity:0;transition:opacity .3s; }
    .parallax-card:hover { background:rgba(255,255,255,.13);border-color:rgba(245,158,11,.35);transform:translateY(-4px);box-shadow:0 16px 40px rgba(0,0,0,.25); }
    .parallax-card:hover::before { opacity:1; }
    .parallax-card-icon { width:40px;height:40px;border-radius:10px;background:rgba(245,158,11,.15);border:1px solid rgba(245,158,11,.3);display:flex;align-items:center;justify-content:center;margin-bottom:.85rem;transition:all .3s; }
    .parallax-card:hover .parallax-card-icon { background:#f59e0b; }
    .parallax-card:hover .parallax-card-icon svg { color:black; }

    /* Fund bars */
    .fund-bar { background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.08);border-radius:12px;padding:1rem 1.25rem;backdrop-filter:blur(8px);transition:all .3s; }
    .fund-bar:hover { background:rgba(255,255,255,.09);border-color:rgba(245,158,11,.25); }
    .fund-bar-track { height:4px;background:rgba(255,255,255,.08);border-radius:2px;overflow:hidden;margin-bottom:.4rem; }
    .fund-bar-fill  { height:100%;border-radius:2px;background:linear-gradient(90deg,#f59e0b,#fbbf24);width:0;transition:width 1.4s cubic-bezier(.2,0,0,1); }

    /* Testimonial cards */
    .testi-card {
        background:white;border-radius:1.25rem;padding:1.75rem;
        box-shadow:0 4px 16px rgba(0,0,0,.06);transition:all .35s cubic-bezier(.2,0,0,1);
        border:1px solid #f3f4f6;position:relative;
    }
    .testi-card::before {
        content:'"';position:absolute;top:1rem;right:1.5rem;
        font-size:5rem;color:#fef3c7;font-family:'Urbanist',sans-serif;line-height:1;pointer-events:none;
    }
    .testi-card:hover { transform:translateY(-6px);box-shadow:0 20px 40px rgba(245,158,11,.12);border-color:#fde68a; }

    /* Timeline */
    .timeline-item { position:relative;padding-left:3rem;padding-bottom:2.5rem; }
    .timeline-item::before { content:'';position:absolute;left:7px;top:16px;bottom:0;width:1px;background:var(--border);transition:background .3s; }
    .timeline-item.visible::before { background:linear-gradient(to bottom,#f59e0b,var(--border)); }
    .timeline-item:last-child::before { display:none; }
    .timeline-dot {
        position:absolute;left:0;top:6px;width:16px;height:16px;border-radius:50%;
        background:#f59e0b;box-shadow:0 0 0 4px white,0 0 0 5px rgba(245,158,11,.3);
        transform:scale(0);transition:transform .4s cubic-bezier(.2,0,0,1);
    }
    .timeline-item.visible .timeline-dot { transform:scale(1); }
    .timeline-year  { font-size:.75rem;font-weight:800;letter-spacing:.1em;text-transform:uppercase;color:#f59e0b; }
    .timeline-title { font-size:1.15rem;font-weight:700;margin:.25rem 0 .4rem; }
    .timeline-desc  { color:var(--muted);font-size:.95rem; }

    /* CTA section */
    .cta-section {
        background:var(--dark);border-radius:28px;padding:6rem 3rem;text-align:center;
        position:relative;overflow:hidden;transition:transform .3s;
    }
    .cta-section:hover { transform:translateY(-2px); }
    .cta-section::before { content:'';position:absolute;inset:0;background-image:radial-gradient(rgba(245,158,11,.06) 1px,transparent 1px);background-size:40px 40px; }
    .cta-glow { position:absolute;width:600px;height:300px;border-radius:50%;background:radial-gradient(rgba(245,158,11,.12),transparent 70%);top:50%;left:50%;transform:translate(-50%,-50%);pointer-events:none; }

    /* Grids */
    .grid-2   { display:grid;grid-template-columns:1fr 1fr;gap:2rem; }
    .grid-3   { display:grid;grid-template-columns:repeat(3,1fr);gap:2rem; }
    .grid-4   { display:grid;grid-template-columns:repeat(4,1fr);gap:1.5rem; }
    .grid-4-8 { display:grid;grid-template-columns:repeat(4,1fr);gap:1.5rem; }

    /* Prog bars */
    .prog-bar  { height:4px;border-radius:2px;background:#fef3c7;overflow:hidden;margin-top:.5rem; }
    .prog-fill { height:100%;border-radius:2px;background:linear-gradient(90deg,#f59e0b,#d97706);width:0%;transition:width 1.2s cubic-bezier(.2,0,0,1); }

    /* ── RESPONSIVE ── */
    @media(max-width:768px){
        .parallax-split{grid-template-columns:1fr;gap:2.5rem;}
        .hero-ring,.hero-float-icon{display:none;}
    }
    @media(max-width:900px){
        .campaign-wrap{grid-template-columns:1fr;}
        .campaign-img{min-height:260px;}
        .grid-2,.grid-3,.grid-4,.grid-4-8{grid-template-columns:1fr 1fr !important;}
    }
    @media(max-width:600px){
        .grid-2,.grid-3,.grid-4,.grid-4-8{grid-template-columns:1fr !important;}
        .hero{height:auto;min-height:520px;max-height:none;}
        .hero-bg,.hero-overlay-1,.hero-overlay-2,.hero-overlay-3,.hero-dots{height:auto;min-height:520px;max-height:none;position:absolute;}
        .hero-inner{padding:5rem 1.25rem 4rem;}
        .hero-sub{font-size:1rem;}
        .btn-gold,.btn-ghost{padding:.85rem 1.5rem;font-size:.9rem;}
        .orb-1,.orb-2,.orb-3,.hero-circle{display:none;}
        .section{padding:4rem 0;}
        .section-h2{font-size:1.8rem !important;}
        .parallax-content{padding:3.5rem 1.25rem;}
        .parallax-h2{font-size:2rem !important;}
        .campaign-wrap{grid-template-columns:1fr !important;}
        .cta-section{padding:3.5rem 1.5rem;}
        .campaign-content{padding:2rem 1.5rem;}
    }
    @media(max-width:400px){
        .hero-h1{font-size:2.8rem !important;}
        .hero-h1 .line-gold{font-size:2.5rem !important;}
        .parallax-h2{font-size:1.75rem !important;}
    }
</style>

<!-- ══════════ HERO ══════════ -->
<section class="hero" id="hero-section">
    <div class="hero-bg" id="heroBg"></div>
    <div class="hero-overlay-1" id="heroOv1"></div>
    <div class="hero-overlay-2" id="heroOv2"></div>
    <div class="hero-overlay-3" id="heroOv3"></div>
    <div class="hero-dots" id="heroDots"></div>
    <div class="hero-ring hero-ring-1"></div>
    <div class="hero-ring hero-ring-2"></div>
    <div class="hero-orb orb-1"></div>
    <div class="hero-orb orb-2"></div>
    <div class="hero-orb orb-3"></div>
    <div class="hero-float-icon fi-1">🌍</div>
    <div class="hero-float-icon fi-2">✦</div>
    <div class="hero-float-icon fi-3">◈</div>
    <div class="hero-circle"></div>

    <div class="hero-inner">
        <div class="hero-breadcrumb">
            <a href="{{ route('member.dashboard') }}">Dashboard</a>
            <span class="sep">/</span>
            <span>About Us</span>
        </div>
        <div class="hero-tag">
            <span class="hero-tag-dot"></span>
            Pan-African Movement
        </div>
        <h1 class="hero-h1">
            Africa<br>
            <span class="line-gold">Prosperity</span>
            Network
        </h1>
        <p class="hero-sub">Building a borderless, prosperous Africa through unity, innovation, and collective action across 54 nations.</p>
        <div class="hero-cta">
            <a href="#mission" class="btn-gold">
                Explore Our Story
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
            </a>
            <a href="{{ route('member.benefits') }}" class="btn-ghost">View Benefits</a>
        </div>
    </div>

    <div class="scroll-cue" onclick="document.getElementById('mission').scrollIntoView({behavior:'smooth'})">
        <div class="scroll-cue-mouse"><div class="scroll-cue-wheel"></div></div>
        <span class="scroll-cue-text">Scroll</span>
    </div>

    <!-- Wave -->
    <div class="absolute bottom-0 left-0 right-0" style="z-index:4;">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" class="w-full">
            <path fill="#f8f7f4" d="M0,64L60,58.7C120,53,240,43,360,48C480,53,600,75,720,80C840,85,960,75,1080,64C1200,53,1320,43,1380,37.3L1440,32L1440,120L0,120Z"/>
        </svg>
    </div>
</section>

<!-- ══════════ PAGE CONTENT ══════════ -->
<div class="page-content">

    <!-- WHO WE ARE -->
    <section class="section" id="mission">
        <div class="container">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:5rem;align-items:center;">
                <div class="reveal from-left">
                    <span class="section-eyebrow">Who We Are</span>
                    <h2 class="section-h2">A Movement Built for Africa's Future</h2>
                    <div class="divider"></div>
                    <p style="color:var(--muted);font-size:1.05rem;margin-bottom:1.25rem;">
                        The <strong style="color:var(--text);">Africa Prosperity Network (APN)</strong> is a pan-African organization dedicated to driving economic transformation and shared prosperity across the continent. Founded in 2020, we bring together leaders, innovators, and change-makers committed to a united Africa.
                    </p>
                    <p style="color:var(--muted);font-size:1.05rem;margin-bottom:2.5rem;">
                        We believe Africa's greatest resource is its people. By breaking down barriers and fostering collaboration, we unlock the continent's immense potential across 54 countries.
                    </p>
                    <div style="display:flex;align-items:center;gap:1rem;">
                        <div style="display:flex;">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" style="width:36px;height:36px;border-radius:50%;border:2px solid white;margin-right:-10px;object-fit:cover;">
                            <img src="https://randomuser.me/api/portraits/men/46.jpg"   style="width:36px;height:36px;border-radius:50%;border:2px solid white;margin-right:-10px;object-fit:cover;">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg" style="width:36px;height:36px;border-radius:50%;border:2px solid white;margin-right:-10px;object-fit:cover;">
                            <img src="https://randomuser.me/api/portraits/men/75.jpg"   style="width:36px;height:36px;border-radius:50%;border:2px solid white;object-fit:cover;">
                        </div>
                        <span style="color:var(--muted);font-size:.88rem;font-weight:600;">Join 10,000+ members across Africa</span>
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">
                    @php $miniStats=[['val'=>'54','label'=>'Countries'],['val'=>'10k+','label'=>'Members'],['val'=>'100+','label'=>'Partners'],['val'=>'$5M+','label'=>'Impact']]; @endphp
                    @foreach($miniStats as $i => $s)
                    <div class="stat-card reveal reveal-d{{ $i+1 }}">
                        <div class="stat-val">{{ $s['val'] }}</div>
                        <div class="stat-label">{{ $s['label'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- TICKER STATS -->
    <section class="ticker-section py-16">
        <div class="max-w-5xl mx-auto px-4">
            <div class="grid-4" style="text-align:center;">
                <div class="reveal reveal-d1">
                    <div class="text-4xl font-bold gradient-text mb-1 counter-val" style="font-family:'Urbanist',sans-serif;" data-target="54" data-suffix="">0</div>
                    <div style="color:var(--muted);font-size:.85rem;font-weight:600;text-transform:uppercase;letter-spacing:.08em;">Countries</div>
                </div>
                <div class="reveal reveal-d2">
                    <div class="text-4xl font-bold gradient-text mb-1 counter-val" style="font-family:'Urbanist',sans-serif;" data-target="10000" data-suffix="+">0</div>
                    <div style="color:var(--muted);font-size:.85rem;font-weight:600;text-transform:uppercase;letter-spacing:.08em;">Members</div>
                </div>
                <div class="reveal reveal-d3">
                    <div class="text-4xl font-bold gradient-text mb-1 counter-val" style="font-family:'Urbanist',sans-serif;" data-target="100" data-suffix="+">0</div>
                    <div style="color:var(--muted);font-size:.85rem;font-weight:600;text-transform:uppercase;letter-spacing:.08em;">Partners</div>
                </div>
                <div class="reveal reveal-d4">
                    <div class="text-4xl font-bold gradient-text mb-1" style="font-family:'Urbanist',sans-serif;">$5M+</div>
                    <div style="color:var(--muted);font-size:.85rem;font-weight:600;text-transform:uppercase;letter-spacing:.08em;">Impact</div>
                </div>
            </div>
        </div>
    </section>

    <!-- BORDERLESS CAMPAIGN -->
    <section class="section section-alt">
        <div class="container">
            <div class="campaign-wrap reveal zoom">
                <div class="campaign-content">
                    <span class="section-eyebrow" style="color:#f59e0b;">Flagship Initiative</span>
                    <h2 style="font-size:clamp(2rem,3.5vw,2.8rem);font-weight:800;color:white;margin:0 0 1.25rem;">The Borderless Campaign</h2>
                    <div class="divider"></div>
                    <p style="color:rgba(255,255,255,.6);margin-bottom:2rem;line-height:1.7;">Our flagship initiative advocating for the removal of trade barriers and the free movement of people, goods, and services across Africa.</p>
                    <ul style="list-style:none;padding:0;margin:0 0 2.5rem;display:flex;flex-direction:column;gap:1rem;">
                        @php $features=[['title'=>'Free Movement','desc'=>'Visa-free travel across all African countries'],['title'=>'Trade Integration','desc'=>'Removing barriers to cross-border commerce'],['title'=>'Digital Unity','desc'=>'A digital single market for African businesses']]; @endphp
                        @foreach($features as $f)
                        <li style="display:flex;align-items:flex-start;gap:.9rem;">
                            <div style="width:22px;height:22px;border-radius:50%;background:rgba(245,158,11,.15);border:1px solid rgba(245,158,11,.3);display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:.15rem;">
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M2 6l3 3 5-5" stroke="#f59e0b" stroke-width="2" stroke-linecap="round"/></svg>
                            </div>
                            <span><strong style="color:white;">{{ $f['title'] }}:</strong> <span style="color:rgba(255,255,255,.55);">{{ $f['desc'] }}</span></span>
                        </li>
                        @endforeach
                    </ul>
                    <a href="#" class="btn-gold-sm">Learn About the Campaign <svg width="14" height="14" viewBox="0 0 16 16" fill="none"><path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2"/></svg></a>
                </div>
                <div class="campaign-img"></div>
            </div>
        </div>
    </section>

    <!-- MISSION & VISION -->
    <section class="section">
        <div class="container">
            <div style="text-align:center;margin-bottom:3.5rem;" class="reveal">
                <span class="section-eyebrow">Purpose</span>
                <h2 class="section-h2 section-h2-center">Mission &amp; Vision</h2>
                <div class="divider divider-center"></div>
            </div>
            <div class="grid-2">
                <div class="card reveal from-left">
                    <div class="icon-box icon-box-lg"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg></div>
                    <h3 style="font-size:1.6rem;font-weight:800;margin:0 0 1rem;">Our Mission</h3>
                    <p style="color:var(--muted);">To catalyze Africa's economic transformation through strategic partnerships, policy advocacy, and community building — creating an environment where businesses thrive, innovations flourish, and people connect across borders.</p>
                </div>
                <div class="card reveal from-right reveal-d2">
                    <div class="icon-box icon-box-lg"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg></div>
                    <h3 style="font-size:1.6rem;font-weight:800;margin:0 0 1rem;">Our Vision</h3>
                    <p style="color:var(--muted);">A fully integrated, prosperous, and borderless Africa where every citizen has the opportunity to thrive — where the movement of people, goods, and ideas is seamless, and collective prosperity is the norm.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CORE VALUES -->
    <section class="section section-alt">
        <div class="container">
            <div style="text-align:center;margin-bottom:3.5rem;" class="reveal">
                <span class="section-eyebrow">What We Stand For</span>
                <h2 class="section-h2 section-h2-center">Core Values</h2>
                <div class="divider divider-center"></div>
            </div>
            <div class="grid-4">
                @php $values=[['icon'=>'<path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>','t'=>'Unity','d'=>'Power through cross-border collaboration.'],['icon'=>'<path d="M13 10V3L4 14h7v7l9-11h-7z"/>','t'=>'Innovation','d'=>"Creative solutions to Africa's challenges."],['icon'=>'<circle cx="12" cy="12" r="10"/><path d="M9 12l2 2 4-4"/>','t'=>'Integrity','d'=>'Transparent and ethical leadership.'],['icon'=>'<circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/>','t'=>'Impact','d'=>'Success measured by real change.']]; @endphp
                @foreach($values as $i => $v)
                <div class="card feature-card reveal reveal-d{{ $i+1 }}" style="text-align:center;">
                    <div class="feature-icon" style="margin:0 auto 1.5rem;"><i class="fas fa-star" style="color:#f59e0b;font-size:1.4rem;"></i></div>
                    <h3 style="font-size:1.2rem;font-weight:800;margin:0 0 .5rem;">{{ $v['t'] }}</h3>
                    <p style="color:var(--muted);font-size:.9rem;margin:0;">{{ $v['d'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- PARALLAX 1 — HOW WE WORK (membership impact) -->
    <section class="parallax-section" id="how-it-works">
        <div class="parallax-bg" id="hiw-bg" data-speed="0.35" style="background-image:url('https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?w=1920&q=80');"></div>
        <div class="parallax-overlay" id="hiw-overlay" style="background:linear-gradient(135deg,rgba(2,6,23,.93) 0%,rgba(10,15,30,.82) 55%,rgba(2,6,23,.9) 100%);"></div>
        <div class="absolute inset-0" style="z-index:2;"></div>

        <!-- wave top -->
        <div class="absolute top-0 left-0 right-0" style="z-index:4;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 80" class="w-full">
                <path fill="white" d="M0,48L60,42.7C120,37,240,27,360,32C480,37,600,59,720,64C840,69,960,59,1080,48C1200,37,1320,27,1380,21.3L1440,16L1440,0L0,0Z"/>
            </svg>
        </div>

        <div class="parallax-content text-center px-4 py-24 max-w-7xl mx-auto">
            <div style="text-align:center;margin-bottom:3.5rem;" class="reveal">
                <div class="parallax-badge" style="margin:0 auto 1.5rem;">
                    <span style="width:6px;height:6px;border-radius:50%;background:#f59e0b;display:inline-block;animation:pulse 2s infinite;"></span>
                    Member Impact
                </div>
                <h2 class="parallax-h2" style="max-width:700px;margin:0 auto 1rem;">Why Your Membership <span style="color:#f59e0b;">Matters</span></h2>
                <p class="parallax-p" style="margin:0 auto;text-align:center;max-width:520px;">As a member, you're not just supporting a cause — you're shaping Africa's future. Every contribution ripples across 54 nations.</p>
            </div>

            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;max-width:1000px;margin:0 auto 3rem;" class="reveal">
                @php $impactCards=[['num'=>'01','icon'=>'<path d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.952 9.168-5v10c-1.543-3.048-5.068-5-9.168-5H7a3.99 3.99 0 00-1.564.317z"/>','title'=>'Amplify Your Voice','desc'=>'Join thousands of advocates pushing for policy changes across the continent.','stat'=>'10k+','stat_label'=>'Advocates'],['num'=>'02','icon'=>'<path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>','title'=>'Network & Collaborate','desc'=>'Connect with change-makers, entrepreneurs and leaders across 54 nations.','stat'=>'54','stat_label'=>'Countries'],['num'=>'03','icon'=>'<path d="M13 10V3L4 14h7v7l9-11h-7z"/>','title'=>'Drive Real Change','desc'=>'Your membership directly funds initiatives that create tangible, lasting impact.','stat'=>'$5M+','stat_label'=>'Impact Fund']]; @endphp
                @foreach($impactCards as $i => $card)
                <div class="parallax-card reveal reveal-d{{ $i+1 }}" style="padding:2rem;text-align:center;">
                    <div class="parallax-card-icon" style="margin:0 auto 1.25rem;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2">{!! $card['icon'] !!}</svg>
                    </div>
                    <div style="font-size:.68rem;font-weight:800;letter-spacing:.15em;color:rgba(245,158,11,.6);text-transform:uppercase;margin-bottom:.75rem;">{{ $card['num'] }}</div>
                    <h3 style="font-size:1.1rem;font-weight:800;color:white;margin:0 0 .6rem;">{{ $card['title'] }}</h3>
                    <p style="font-size:.85rem;color:rgba(255,255,255,.5);line-height:1.6;margin:0 0 1.5rem;">{{ $card['desc'] }}</p>
                    <div style="border-top:1px solid rgba(255,255,255,.07);padding-top:1.25rem;">
                        <div style="font-size:1.8rem;font-weight:900;color:#f59e0b;letter-spacing:-.04em;line-height:1;">{{ $card['stat'] }}</div>
                        <div style="font-size:.68rem;text-transform:uppercase;letter-spacing:.1em;color:rgba(255,255,255,.35);font-weight:700;margin-top:.2rem;">{{ $card['stat_label'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>

            <div style="text-align:center;" class="reveal">
                <a href="{{ route('member.benefits') }}" class="btn-gold" style="font-size:.95rem;padding:.9rem 2rem;">
                    Explore Member Benefits
                    <svg width="14" height="14" viewBox="0 0 16 16" fill="none"><path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2"/></svg>
                </a>
            </div>
        </div>

        <!-- wave bottom -->
        <div class="absolute bottom-0 left-0 right-0" style="z-index:4;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 80" class="w-full">
                <path fill="#f8f7f4" d="M0,32L60,37.3C120,43,240,53,360,48C480,43,600,21,720,16C840,11,960,21,1080,32C1200,43,1320,53,1380,58.7L1440,64L1440,80L0,80Z"/>
            </svg>
        </div>
    </section>

    <!-- IMPACT BY NUMBERS -->
    <section class="section section-alt">
        <div class="container">
            <div style="text-align:center;margin-bottom:3.5rem;" class="reveal">
                <span class="section-eyebrow">By The Numbers</span>
                <h2 class="section-h2 section-h2-center">Our Impact</h2>
                <div class="divider divider-center"></div>
            </div>
            <div class="grid-4-8 reveal">
                @php $stats=[['v'=>'54','l'=>'African Countries'],['v'=>'10k+','l'=>'Active Members'],['v'=>'100+','l'=>'Partner Orgs'],['v'=>'$5M+','l'=>'Funds Raised'],['v'=>'50+','l'=>'Policy Changes'],['v'=>'200+','l'=>'Events Hosted'],['v'=>'15k+','l'=>'Jobs Created'],['v'=>'1.4B','l'=>'People Impacted']]; @endphp
                @foreach($stats as $s)
                <div class="stat-card"><div class="stat-val">{{ $s['v'] }}</div><div class="stat-label">{{ $s['l'] }}</div></div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- TIMELINE -->
    <section class="section">
        <div class="container">
            <div style="text-align:center;margin-bottom:3.5rem;" class="reveal">
                <span class="section-eyebrow">History</span>
                <h2 class="section-h2 section-h2-center">Our Journey</h2>
                <div class="divider divider-center"></div>
            </div>
            <div style="max-width:580px;margin:0 auto;">
                @php $milestones=[['y'=>'2020','t'=>'APN Founded','d'=>"Launched with a vision to connect Africa's changemakers."],['y'=>'2021','t'=>'Borderless Campaign Launch','d'=>'Introduced our flagship initiative for free movement.'],['y'=>'2022','t'=>'10,000 Members Milestone','d'=>'Reached 10,000 active members across 54 countries.'],['y'=>'2023','t'=>'First Annual Prosperity Summit','d'=>'Hosted 500+ leaders from across the continent.'],['y'=>'2024','t'=>'$5M Impact Fund','d'=>'Launched fund to support cross-border initiatives.']]; @endphp
                @foreach($milestones as $i => $m)
                <div class="timeline-item reveal reveal-d{{ min($i+1,4) }}">
                    <div class="timeline-dot"></div>
                    <div class="timeline-year">{{ $m['y'] }}</div>
                    <div class="timeline-title">{{ $m['t'] }}</div>
                    <div class="timeline-desc">{{ $m['d'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- PARALLAX 2 — PROSPERITY FUND -->
    <section class="parallax-section" id="cta-section">
        <div class="parallax-bg" id="cta-bg" data-speed="0.3" style="background-image:url('https://images.unsplash.com/photo-1611348586804-61bf6c080437?w=1920&q=80');"></div>
        <div class="parallax-overlay" id="cta-overlay" style="background:linear-gradient(to right,rgba(2,6,23,.95) 0%,rgba(2,6,23,.8) 50%,rgba(10,15,30,.6) 100%);"></div>

        <div class="absolute top-0 left-0 right-0" style="z-index:4;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 80" class="w-full">
                <path fill="#f8f7f4" d="M0,48L60,42.7C120,37,240,27,360,32C480,37,600,59,720,64C840,69,960,59,1080,48C1200,37,1320,27,1380,21.3L1440,16L1440,0L0,0Z"/>
            </svg>
        </div>

        <!-- Orbs -->
        <div class="absolute top-10 left-10 w-64 h-64 rounded-full blur-3xl" style="z-index:2;background:rgba(245,158,11,.1);animation:orb2 14s ease-in-out infinite;"></div>
        <div class="absolute bottom-10 right-10 w-72 h-72 rounded-full blur-3xl" style="z-index:2;background:rgba(245,158,11,.08);animation:orb1 11s ease-in-out infinite;"></div>

        <div class="parallax-content px-4 py-24 max-w-7xl mx-auto" style="z-index:3;">
            <div class="parallax-split reveal">
                <div>
                    <div class="parallax-badge">
                        <span style="width:6px;height:6px;border-radius:50%;background:#f59e0b;display:inline-block;animation:pulse 2s infinite;"></span>
                        Prosperity Fund
                    </div>
                    <h2 class="parallax-h2">$5M+ Invested in<br><span style="color:#f59e0b;">Africa's Future</span></h2>
                    <p class="parallax-p">Our impact fund channels member contributions directly into cross-border trade initiatives, youth entrepreneurship, and policy advocacy.</p>
                    <div class="parallax-stats" style="margin-bottom:2.5rem;">
                        <div><div class="parallax-stat-val">$5M+</div><div class="parallax-stat-label">Funds Raised</div></div>
                        <div><div class="parallax-stat-val">15k+</div><div class="parallax-stat-label">Jobs Created</div></div>
                        <div><div class="parallax-stat-val">50+</div><div class="parallax-stat-label">Policy Wins</div></div>
                    </div>
                    <a href="{{ route('member.dashboard') }}" class="btn-gold" style="font-size:.95rem;padding:.9rem 1.9rem;">
                        Go to Dashboard
                        <svg width="14" height="14" viewBox="0 0 16 16" fill="none"><path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2"/></svg>
                    </a>
                </div>
                <div style="display:flex;flex-direction:column;gap:1rem;" class="reveal reveal-d2">
                    @php $fundItems=[['pct'=>45,'label'=>'Trade & Commerce','desc'=>'Cross-border trade facilitation programs'],['pct'=>28,'label'=>'Youth Enterprise','desc'=>'Startup support and mentorship for young Africans'],['pct'=>17,'label'=>'Policy Advocacy','desc'=>'Lobbying for continental integration policies'],['pct'=>10,'label'=>'Community Events','desc'=>'Summits, forums, and networking events']]; @endphp
                    @foreach($fundItems as $item)
                    <div class="fund-bar">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.5rem;">
                            <span style="font-weight:700;color:white;font-size:.9rem;">{{ $item['label'] }}</span>
                            <span style="font-weight:800;color:#f59e0b;font-size:.9rem;">{{ $item['pct'] }}%</span>
                        </div>
                        <div class="fund-bar-track">
                            <div class="fund-bar-fill" data-width="{{ $item['pct'] }}"></div>
                        </div>
                        <p style="font-size:.78rem;color:rgba(255,255,255,.4);margin:0;">{{ $item['desc'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0" style="z-index:4;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 80" class="w-full">
                <path fill="#f8f7f4" d="M0,32L60,37.3C120,43,240,53,360,48C480,43,600,21,720,16C840,11,960,21,1080,32C1200,43,1320,53,1380,58.7L1440,64L1440,80L0,80Z"/>
            </svg>
        </div>
    </section>

    <!-- CTA -->
    <section class="section">
        <div class="container">
            <div class="cta-section reveal">
                <div class="cta-glow"></div>
                <div style="position:relative;z-index:1;max-width:600px;margin:0 auto;">
                    <span class="section-eyebrow" style="color:#f59e0b;">Join Us</span>
                    <h2 style="font-size:clamp(2rem,4vw,3rem);font-weight:800;color:white;margin:.75rem 0 1.25rem;">Ready to Make a Difference?</h2>
                    <p style="color:rgba(255,255,255,.5);font-size:1.05rem;margin-bottom:2.5rem;">Join thousands of members across Africa who are building a prosperous, borderless future together.</p>
                    <div style="display:flex;justify-content:center;gap:1rem;flex-wrap:wrap;">
                        <a href="{{ route('member.dashboard') }}" class="btn-gold" style="font-size:1rem;padding:.95rem 2rem;">Go to Dashboard</a>
                        <a href="{{ route('member.benefits') }}" class="btn-ghost" style="font-size:1rem;padding:.95rem 2rem;">View Benefits</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div><!-- end page-content -->

<script>
// ── Hero fixed-bg: hide when scrolled out of view ──
(function(){
    const heroSection = document.getElementById('hero-section');
    const fixedEls = ['heroBg','heroOv1','heroOv2','heroOv3','heroDots'].map(id=>document.getElementById(id));
    function onScroll(){
        const hide = heroSection.getBoundingClientRect().bottom <= 0;
        fixedEls.forEach(el=>{ if(el) el.style.visibility = hide?'hidden':'visible'; });
    }
    window.addEventListener('scroll', onScroll, {passive:true});
    onScroll();
})();

// ── PARALLAX ──
const parallaxEls = document.querySelectorAll('.parallax-bg');
const isMobile = ()=>window.innerWidth<=768;
function updateParallax(){
    if(isMobile()) return;
    parallaxEls.forEach(el=>{
        const section = el.closest('.parallax-section');
        const rect    = section.getBoundingClientRect();
        const speed   = parseFloat(el.dataset.speed)||0.4;
        if(rect.bottom<-300||rect.top>window.innerHeight+300) return;
        const offset = (window.scrollY - section.offsetTop) * speed;
        el.style.transform = `translateY(${offset}px)`;
    });
}
window.addEventListener('scroll', updateParallax, {passive:true});
window.addEventListener('resize', updateParallax);
updateParallax();

// ── SCROLL REVEAL ──
const revealObs = new IntersectionObserver(entries=>{
    entries.forEach(e=>{
        if(e.isIntersecting){
            e.target.classList.add('visible');
            e.target.querySelectorAll('.prog-fill, .fund-bar-fill').forEach(bar=>{
                bar.style.width = bar.dataset.width+'%';
            });
            revealObs.unobserve(e.target);
        }
    });
},{threshold:0.1,rootMargin:'0px 0px -60px 0px'});
document.querySelectorAll('.reveal').forEach(el=>revealObs.observe(el));

// Fund bars direct observer
const barObs = new IntersectionObserver(entries=>{
    entries.forEach(e=>{
        if(e.isIntersecting){ e.target.style.width=e.target.dataset.width+'%'; barObs.unobserve(e.target); }
    });
},{threshold:0.3});
document.querySelectorAll('.fund-bar-fill').forEach(b=>barObs.observe(b));

// ── COUNTER ANIMATION ──
function animateCounter(el){
    const target = parseInt(el.dataset.target);
    const suffix = el.dataset.suffix||'';
    const inc    = target/(1800/16);
    let   cur    = 0;
    const t = setInterval(()=>{
        cur += inc;
        if(cur>=target){ cur=target; clearInterval(t); }
        const display = target>=1000 ? Math.floor(cur).toLocaleString() : Math.floor(cur);
        el.textContent = display+suffix;
    },16);
}
const counterObs = new IntersectionObserver(entries=>{
    entries.forEach(e=>{ if(e.isIntersecting){ animateCounter(e.target); counterObs.unobserve(e.target); } });
},{threshold:0.5});
document.querySelectorAll('.counter-val').forEach(el=>counterObs.observe(el));
</script>
@endsection