@extends('layouts.guest')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Urbanist:wght@300;400;500;600;700;800;900&display=swap');

    :root {
        --gold: #D4AF37;
        --gold-light: #F0D060;
        --gold-dim: rgba(212,175,55,0.15);
        --dark: #020617;
        --dark-2: #0a0f1e;
        --surface: #f8f7f4;
        --text: #0f172a;
        --muted: #64748b;
        --border: #e2e8f0;
        --radius: 16px;
    }

    * { box-sizing: border-box; }
    body { font-family: 'Urbanist', sans-serif; background: var(--surface); color: var(--text); -webkit-font-smoothing: antialiased; margin: 0; }
    h1,h2,h3,h4 { font-family: 'Urbanist', sans-serif; letter-spacing: -0.03em; line-height: 1.05; }
    p { line-height: 1.7; }

    /* ── HERO ────────────────────────────────────── */
    .hero {
        position: relative;
        height: 68vh;
        min-height: 480px;
        max-height: 700px;
        display: flex;
        align-items: center;
        background: var(--dark);
        overflow: visible;
    }

    /* Parallax bg — fixed so content scrolls over it */
    .hero-bg {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 68vh;
        min-height: 480px;
        max-height: 700px;
        background-image: url('https://membership.africaprosperitynetwork.com/wp-content/uploads/2026/03/Group-599.jpg');
        background-size: cover;
        background-position: center;
        opacity: 0.45;
        z-index: 0;
        /* subtle zoom animation */
        animation: slowZoom 18s ease-in-out infinite alternate;
    }

    /* Once hero is out of view, hide the fixed bg */
    .hero-bg.hidden { display: none; }

    @keyframes slowZoom {
        from { transform: scale(1.03); }
        to   { transform: scale(1.09); }
    }

    /* Overlays also fixed so they stay with the bg */
    .hero-overlay-1 {
        position: fixed;
        top: 0; left: 0; right: 0;
        height: 68vh; min-height: 480px; max-height: 700px;
  background: linear-gradient(
  135deg,
  rgba(2, 6, 2, 0.75) 0%,
  rgba(2, 6, 23, 0.45) 55%,
  rgba(10, 15, 30, 0.2) 100%
);
        z-index: 1;
    }
    .hero-overlay-2 {
        position: fixed;
        top: 0; left: 0; right: 0;
        height: 68vh; min-height: 480px; max-height: 700px;
        background: radial-gradient(ellipse 80% 60% at 10% 80%, rgba(212,175,55,0.18) 0%, transparent 60%);
        z-index: 1;
    }
    .hero-overlay-3 {
        position: fixed;
        top: 0; left: 0; right: 0;
        height: 68vh; min-height: 480px; max-height: 700px;
        background: radial-gradient(ellipse 60% 50% at 85% 20%, rgba(99,102,241,0.12) 0%, transparent 55%);
        z-index: 1;
    }

    /* Dots fixed too */
    .hero-dots {
        position: fixed;
        top: 0; left: 0; right: 0;
        height: 68vh; min-height: 480px; max-height: 700px;
        background-image: radial-gradient(rgba(212,175,55,0.15) 1px, transparent 1px);
        background-size: 48px 48px;
        mask-image: linear-gradient(135deg, transparent 30%, black 70%);
        pointer-events: none;
        z-index: 1;
    }

    /* Circle + orbs — inside hero, relative */
    .hero-circle {
        position: absolute;
        right: -180px; top: 50%;
        transform: translateY(-50%);
        width: 700px; height: 700px;
        border-radius: 50%;
        border: 1px solid rgba(212,175,55,0.12);
        pointer-events: none;
        z-index: 2;
    }
    .hero-circle::before {
        content: ''; position: absolute; inset: 40px;
        border-radius: 50%; border: 1px solid rgba(212,175,55,0.08);
    }
    .hero-circle::after {
        content: ''; position: absolute; inset: 100px;
        border-radius: 50%; border: 1px solid rgba(212,175,55,0.05);
    }

    .orb {
        position: absolute; border-radius: 50%;
        filter: blur(80px); pointer-events: none;
        animation: orbFloat 8s ease-in-out infinite;
        z-index: 2;
    }
    .orb-1 { width:400px;height:400px;background:rgba(212,175,55,0.08);bottom:-100px;left:-100px;animation-delay:0s; }
    .orb-2 { width:300px;height:300px;background:rgba(99,102,241,0.06);top:50px;right:200px;animation-delay:3s; }
    @keyframes orbFloat {
        0%,100%{transform:translateY(0) scale(1)} 50%{transform:translateY(-30px) scale(1.05)}
    }

    /* Hero content — sits on top of everything */
    .hero-inner {
        position: relative;
        z-index: 10;
        max-width: 1200px;
        margin: 0 auto;
        padding: 5rem 2rem 4rem;
        width: 100%;
    }

    /* Breadcrumb */
    .hero-breadcrumb {
        display: inline-flex; align-items: center; gap: 0.4rem;
        padding: 0.4rem 1rem;
        border: 1px solid rgba(255,255,255,0.15); border-radius: 999px;
        font-size: 0.8rem; font-weight: 600; letter-spacing: 0.12em; text-transform: uppercase;
        color: rgba(255,255,255,0.7); margin-bottom: 2rem;
        backdrop-filter: blur(8px); background: rgba(255,255,255,0.04);
        opacity: 0; animation: fadeUp 0.8s 0.1s ease forwards;
    }
    .hero-breadcrumb a { color: rgba(255,255,255,0.7); text-decoration: none; }
    .hero-breadcrumb a:hover { color: var(--gold); }
    .hero-breadcrumb .sep { color: rgba(255,255,255,0.3); }

    .hero-tag {
        display: inline-flex; align-items: center; gap: 0.6rem;
        padding: 0.35rem 1rem;
        background: var(--gold-dim); border: 1px solid rgba(212,175,55,0.3); border-radius: 999px;
        font-size: 0.8rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase;
        color: var(--gold); margin-bottom: 1.5rem;
        opacity: 0; animation: fadeUp 0.8s 0.25s ease forwards;
    }
    .hero-tag-dot {
        width:6px;height:6px;border-radius:50%;background:var(--gold);
        animation: pulse 2s infinite;
    }
    @keyframes pulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.5;transform:scale(1.5)}}

    .hero-h1 {
        font-size: clamp(3.5rem, 8vw, 6.5rem);
        font-weight: 900; color: white; margin: 0 0 0.2rem; line-height: 0.95;
        opacity: 0; animation: fadeUp 0.9s 0.4s ease forwards;
    }
    .hero-h1 .line-gold {
        display: block;
        font-size: clamp(3rem, 7vw, 6rem); font-style: italic;
        background: linear-gradient(90deg, var(--gold), var(--gold-light), var(--gold));
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        background-clip: text; background-size: 200%;
        animation: fadeUp 0.9s 0.4s ease forwards, shimmer 4s 1.5s linear infinite;
    }
    @keyframes shimmer{0%{background-position:0%}100%{background-position:200%}}

    .hero-sub {
        font-size: clamp(1.1rem, 2.2vw, 1.35rem); color: rgba(255,255,255,0.6);
        max-width: 520px; margin: 1.5rem 0 2.5rem; font-weight: 400;
        opacity: 0; animation: fadeUp 0.8s 0.6s ease forwards;
    }

    .hero-cta {
        display: flex; flex-wrap: wrap; gap: 1rem;
        opacity: 0; animation: fadeUp 0.8s 0.8s ease forwards;
    }

    .btn-gold {
        display: inline-flex; align-items: center; gap: 0.6rem;
        padding: 0.95rem 2rem; background: var(--gold); color: #000;
        font-weight: 700; font-size: 1rem; border-radius: 12px;
        text-decoration: none; transition: all 0.25s ease; position: relative; overflow: hidden;
    }
    .btn-gold::before {
        content:''; position:absolute; inset:0;
        background:linear-gradient(135deg,rgba(255,255,255,0.2),transparent);
        opacity:0; transition:opacity 0.25s;
    }
    .btn-gold:hover{transform:translateY(-2px);box-shadow:0 12px 32px rgba(212,175,55,0.4);color:#000;}
    .btn-gold:hover::before{opacity:1;}

    .btn-ghost {
        display:inline-flex;align-items:center;gap:0.6rem;
        padding:0.95rem 2rem;background:rgba(255,255,255,0.06);
        color:rgba(255,255,255,0.85);font-weight:600;font-size:1rem;
        border-radius:12px;text-decoration:none;border:1px solid rgba(255,255,255,0.14);
        backdrop-filter:blur(8px);transition:all 0.25s ease;
    }
    .btn-ghost:hover{background:rgba(255,255,255,0.1);color:white;transform:translateY(-2px);}

    /* Stats bar */
    .hero-stats {
        display:flex;flex-wrap:wrap;gap:0;margin-top:3rem;
        border:1px solid rgba(255,255,255,0.08);border-radius:16px;
        overflow:hidden;backdrop-filter:blur(12px);background:rgba(255,255,255,0.03);
        opacity:0;animation:fadeUp 0.8s 1s ease forwards;max-width:640px;
    }
    .hero-stat{flex:1;min-width:130px;padding:1.25rem 1.5rem;border-right:1px solid rgba(255,255,255,0.07);}
    .hero-stat:last-child{border-right:none;}
    .hero-stat-val{font-size:1.7rem;font-weight:900;color:var(--gold);line-height:1;letter-spacing:-0.04em;}
    .hero-stat-label{font-size:0.68rem;text-transform:uppercase;letter-spacing:0.1em;color:rgba(255,255,255,0.4);font-weight:600;margin-top:0.25rem;}

    /* Scroll cue */
    .scroll-cue {
        position: absolute; bottom: 2rem; left: 50%; transform: translateX(-50%);
        z-index: 10; display: flex; flex-direction: column; align-items: center; gap: 0.5rem;
        cursor: pointer; opacity: 0; animation: fadeIn 1s 1.4s ease forwards;
    }
    .scroll-cue-line {
        width: 1px; height: 40px;
        background: linear-gradient(to bottom, rgba(212,175,55,0.6), transparent);
        animation: scrollLine 1.8s 1.4s ease-in-out infinite;
    }
    @keyframes scrollLine{0%{transform:scaleY(0);transform-origin:top}50%{transform:scaleY(1);transform-origin:top}51%{transform-origin:bottom}100%{transform:scaleY(0);transform-origin:bottom}}
    .scroll-cue-text{font-size:0.65rem;letter-spacing:0.15em;text-transform:uppercase;color:rgba(255,255,255,0.3);font-weight:600;}

    @keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
    @keyframes fadeIn{to{opacity:1}}

    /* Content sits above hero bg */
    .page-content { position: relative; z-index: 20; background: var(--surface); }

    /* ── SECTION BASE ── */
    .section{padding:7rem 0;}
    .section-alt{background:white;}
    .container{max-width:1200px;margin:0 auto;padding:0 2rem;}

    .section-eyebrow{display:inline-block;font-size:0.72rem;font-weight:800;letter-spacing:0.16em;text-transform:uppercase;color:var(--gold);margin-bottom:1.25rem;}
    .section-eyebrow::before{content:'—';margin-right:0.5rem;opacity:0.5;}
    .section-h2{font-size:clamp(2.2rem,4vw,3.2rem);font-weight:800;color:var(--text);margin:0 0 1.5rem;}
    .section-h2-center{text-align:center;}

    /* Reveal */
    .reveal{opacity:0;transform:translateY(24px);transition:all 0.7s cubic-bezier(0.2,0,0,1);}
    .reveal.in{opacity:1;transform:none;}
    .reveal-d1{transition-delay:0.1s;}
    .reveal-d2{transition-delay:0.2s;}
    .reveal-d3{transition-delay:0.3s;}
    .reveal-d4{transition-delay:0.4s;}

    /* Cards */
    .card{background:white;border-radius:var(--radius);border:1px solid var(--border);padding:2rem;transition:all 0.25s ease;}
    .card:hover{border-color:rgba(212,175,55,0.35);box-shadow:0 8px 32px rgba(212,175,55,0.08),0 2px 8px rgba(0,0,0,0.04);transform:translateY(-3px);}
    .card-dark{background:var(--dark);border:1px solid rgba(255,255,255,0.06);border-radius:var(--radius);padding:2rem;color:white;transition:all 0.25s ease;}
    .card-dark:hover{border-color:rgba(212,175,55,0.2);box-shadow:0 12px 40px rgba(0,0,0,0.3);transform:translateY(-3px);}

    .icon-box{width:52px;height:52px;border-radius:14px;background:var(--gold-dim);border:1px solid rgba(212,175,55,0.2);display:flex;align-items:center;justify-content:center;margin-bottom:1.5rem;}
    .icon-box svg{width:24px;height:24px;color:var(--gold);}
    .icon-box-lg{width:64px;height:64px;border-radius:18px;}
    .icon-box-lg svg{width:32px;height:32px;}

    .num-badge{width:52px;height:52px;border-radius:50%;background:var(--gold);color:#000;font-weight:800;font-size:1.3rem;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;}

    .stat-card{background:white;border-radius:var(--radius);border:1px solid var(--border);padding:1.75rem;text-align:center;transition:all 0.25s ease;}
    .stat-card:hover{border-color:rgba(212,175,55,0.4);box-shadow:0 6px 24px rgba(212,175,55,0.07);transform:translateY(-2px);}
    .stat-val{font-size:2.4rem;font-weight:900;color:var(--gold);letter-spacing:-0.05em;line-height:1;}
    .stat-label{font-size:0.72rem;text-transform:uppercase;letter-spacing:0.1em;color:var(--muted);font-weight:700;margin-top:0.4rem;}

    .timeline-item{position:relative;padding-left:3rem;padding-bottom:2.5rem;}
    .timeline-item::before{content:'';position:absolute;left:7px;top:16px;bottom:0;width:1px;background:var(--border);}
    .timeline-item:last-child::before{display:none;}
    .timeline-dot{position:absolute;left:0;top:6px;width:16px;height:16px;border-radius:50%;background:var(--gold);box-shadow:0 0 0 4px white,0 0 0 5px rgba(212,175,55,0.3);}
    .timeline-year{font-size:0.75rem;font-weight:800;letter-spacing:0.1em;text-transform:uppercase;color:var(--gold);}
    .timeline-title{font-size:1.15rem;font-weight:700;margin:0.25rem 0 0.4rem;}
    .timeline-desc{color:var(--muted);font-size:0.95rem;}

    .campaign-wrap{border-radius:24px;overflow:hidden;display:grid;grid-template-columns:1fr 1fr;background:var(--dark);}
    .campaign-content{padding:4rem;}
    .campaign-img{background-image:url('https://membership.africaprosperitynetwork.com/wp-content/uploads/2026/03/Group-600.jpg');background-size:cover;background-position:center;min-height:420px;position:relative;}
    .campaign-img::before{content:'';position:absolute;inset:0;background:linear-gradient(to right,var(--dark) 0%,transparent 40%);}

    .divider{width:48px;height:3px;background:var(--gold);border-radius:2px;margin:0 0 2rem;}
    .divider-center{margin:0 auto 2rem;}

    .cta-section{background:var(--dark);border-radius:28px;padding:6rem 3rem;text-align:center;position:relative;overflow:hidden;}
    .cta-section::before{content:'';position:absolute;inset:0;background-image:radial-gradient(rgba(212,175,55,0.06) 1px,transparent 1px);background-size:40px 40px;}
    .cta-glow{position:absolute;width:600px;height:300px;border-radius:50%;background:radial-gradient(rgba(212,175,55,0.12),transparent 70%);top:50%;left:50%;transform:translate(-50%,-50%);pointer-events:none;}

    .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:2rem;}
    .grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:2rem;}
    .grid-4{display:grid;grid-template-columns:repeat(4,1fr);gap:1.5rem;}
    .grid-4-8{display:grid;grid-template-columns:repeat(4,1fr);gap:1.5rem;}

    .btn-gold-sm{display:inline-flex;align-items:center;gap:0.5rem;padding:0.75rem 1.5rem;background:var(--gold);color:#000;font-weight:700;font-size:0.9rem;border-radius:10px;text-decoration:none;transition:all 0.2s ease;}
    .btn-gold-sm:hover{filter:brightness(1.1);transform:translateY(-1px);color:#000;}
    .btn-ghost-dark{display:inline-flex;align-items:center;gap:0.5rem;padding:0.75rem 1.5rem;background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.8);font-weight:600;font-size:0.9rem;border-radius:10px;text-decoration:none;border:1px solid rgba(255,255,255,0.12);transition:all 0.2s ease;}
    .btn-ghost-dark:hover{background:rgba(255,255,255,0.1);color:white;}


    /* ── PARALLAX IMAGE SECTIONS ── */
    .parallax-section {
        position: relative;
        overflow: hidden;
        min-height: 520px;
        display: flex;
        align-items: center;
    }
    .parallax-bg {
        position: absolute;
        inset: -15%;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        z-index: 0;
        transition: transform 0.1s linear;
    }
    .parallax-overlay {
        position: absolute;
        inset: 0;
        z-index: 1;
    }
    .parallax-content {
        position: relative;
        z-index: 2;
        max-width: 1200px;
        margin: 0 auto;
        padding: 5rem 2rem;
        width: 100%;
    }
    .parallax-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.35rem 1rem;
        background: rgba(212,175,55,0.15);
        border: 1px solid rgba(212,175,55,0.35);
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 1.5rem;
    }
    .parallax-h2 {
        font-size: clamp(2.2rem, 5vw, 3.8rem);
        font-weight: 900;
        color: white;
        line-height: 1.05;
        margin: 0 0 1.25rem;
        letter-spacing: -0.03em;
    }
    .parallax-p {
        font-size: clamp(1rem, 2vw, 1.15rem);
        color: rgba(255,255,255,0.7);
        max-width: 560px;
        line-height: 1.7;
        margin-bottom: 2rem;
    }
    .parallax-stats {
        display: flex;
        flex-wrap: wrap;
        gap: 2.5rem;
        margin-top: 2rem;
    }
    .parallax-stat-val {
        font-size: 2.2rem;
        font-weight: 900;
        color: var(--gold);
        line-height: 1;
        letter-spacing: -0.04em;
    }
    .parallax-stat-label {
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: rgba(255,255,255,0.45);
        font-weight: 700;
        margin-top: 0.25rem;
    }

    /* Two-col parallax variant */
    .parallax-split {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: center;
    }
    .parallax-cards {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    .parallax-card {
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 14px;
        padding: 1.5rem;
        backdrop-filter: blur(8px);
        transition: all 0.25s ease;
    }
    .parallax-card:hover {
        background: rgba(255,255,255,0.11);
        border-color: rgba(212,175,55,0.3);
    }
    .parallax-card-icon {
        width: 40px; height: 40px;
        border-radius: 10px;
        background: var(--gold-dim);
        border: 1px solid rgba(212,175,55,0.3);
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 0.85rem;
    }
    .parallax-card-title {
        font-size: 1rem;
        font-weight: 800;
        color: white;
        margin: 0 0 0.3rem;
    }
    .parallax-card-desc {
        font-size: 0.83rem;
        color: rgba(255,255,255,0.5);
        line-height: 1.5;
        margin: 0;
    }

    /* Checklist */
    .parallax-check-list {
        list-style: none;
        padding: 0;
        margin: 0 0 2rem;
        display: flex;
        flex-direction: column;
        gap: 0.85rem;
    }
    .parallax-check-list li {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        color: rgba(255,255,255,0.75);
        font-size: 0.95rem;
    }
    .parallax-check-list li .check-icon {
        width: 20px; height: 20px;
        border-radius: 50%;
        background: rgba(212,175,55,0.15);
        border: 1px solid rgba(212,175,55,0.3);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        margin-top: 2px;
    }

    @media(max-width:768px) {
        .parallax-split { grid-template-columns: 1fr; gap: 2.5rem; }
        .parallax-bg { background-attachment: scroll; inset: 0; }
        .parallax-section { min-height: 420px; }
        .parallax-cards { grid-template-columns: 1fr 1fr; }
        .parallax-impact-grid { grid-template-columns: 1fr !important; }
        .hero-bg,.hero-overlay-1,.hero-overlay-2,.hero-overlay-3,.hero-dots { background-attachment: scroll; }
    }
    @media(max-width:480px) {
        .parallax-cards { grid-template-columns: 1fr; }
        .parallax-stats { gap: 1.5rem; }
    }

    @media(max-width:900px){
        .campaign-wrap{grid-template-columns:1fr;}
        .campaign-img{min-height:260px;}
        .grid-2,.grid-3,.grid-4,.grid-4-8{grid-template-columns:1fr 1fr !important;}
    }
    @media(max-width:600px){
        .grid-2,.grid-3,.grid-4,.grid-4-8{grid-template-columns:1fr !important;}
        .hero-stats{flex-direction:column;}
        .hero-stat{border-right:none !important;border-bottom:1px solid rgba(255,255,255,0.07);}
        .cta-section{padding:3.5rem 1.5rem;}
        .campaign-content{padding:2rem 1.5rem;}
        .campaign-img{min-height:220px;}
        .hero{height:auto;min-height:520px;max-height:none;}
        .hero-bg,.hero-overlay-1,.hero-overlay-2,.hero-overlay-3,.hero-dots{height:auto;min-height:520px;max-height:none;position:absolute;}
        .hero-inner{padding:5rem 1.25rem 4rem;}
        .hero-breadcrumb{font-size:0.7rem;padding:0.3rem 0.75rem;}
        .hero-sub{font-size:1rem;margin:1.25rem 0 2rem;}
        .hero-cta{gap:0.75rem;}
        .btn-gold,.btn-ghost{padding:0.85rem 1.5rem;font-size:0.9rem;}
        .hero-circle{display:none;}
        .orb{display:none;}
        .section{padding:4rem 0;}
        .section-h2{font-size:1.8rem !important;}
        .parallax-content{padding:3.5rem 1.25rem;}
        .parallax-h2{font-size:2rem !important;}
        [style*="grid-template-columns:repeat(3,1fr)"]{grid-template-columns:1fr !important;}
        [style*="grid-template-columns:1fr 1fr"]{grid-template-columns:1fr !important;}
        [style*="gap:5rem"]{gap:2.5rem !important;}
        [style*="gap:4rem"]{gap:2rem !important;}
        .campaign-wrap{grid-template-columns:1fr !important;}
        .divider-center{margin:0 auto 1.5rem;}
        .timeline-item{padding-left:2.25rem;}
    }
    @media(max-width:400px){
        .hero-h1{font-size:2.8rem !important;}
        .hero-h1 .line-gold{font-size:2.5rem !important;}
        .parallax-h2{font-size:1.75rem !important;}
    }
</style>

<!-- ══════════════════════════════ HERO ══════════════════════════════ -->
<section class="hero" id="hero-section">
    <div class="hero-bg" id="heroBg"></div>
    <div class="hero-overlay-1" id="heroOv1"></div>
    <div class="hero-overlay-2" id="heroOv2"></div>
    <div class="hero-overlay-3" id="heroOv3"></div>
    <div class="hero-dots" id="heroDots"></div>
    <div class="hero-circle"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>

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

        <p class="hero-sub">
            Building a borderless, prosperous Africa through unity, innovation, and collective action across 54 nations.
        </p>

        <div class="hero-cta">
            <a href="#mission" class="btn-gold">
                Explore Our Story
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
            </a>
            <a href="{{ route('member.benefits') }}" class="btn-ghost">View Benefits</a>
        </div>
    </div>

    <div class="scroll-cue" onclick="document.getElementById('mission').scrollIntoView({behavior:'smooth'})">
        <div class="scroll-cue-line"></div>
        <span class="scroll-cue-text">Scroll</span>
    </div>
</section>

<!-- ══════════════════════════════ MAIN ══════════════════════════════ -->
<div class="page-content">

    <section class="section" id="mission">
        <div class="container">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:5rem;align-items:center;">
                <div class="reveal">
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
                            <img src="https://randomuser.me/api/portraits/men/46.jpg" style="width:36px;height:36px;border-radius:50%;border:2px solid white;margin-right:-10px;object-fit:cover;">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg" style="width:36px;height:36px;border-radius:50%;border:2px solid white;margin-right:-10px;object-fit:cover;">
                            <img src="https://randomuser.me/api/portraits/men/75.jpg" style="width:36px;height:36px;border-radius:50%;border:2px solid white;object-fit:cover;">
                        </div>
                        <span style="color:var(--muted);font-size:0.88rem;font-weight:600;">Join 10,000+ members across Africa</span>
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

    <section class="section section-alt">
        <div class="container">
            <div class="campaign-wrap reveal">
                <div class="campaign-content">
                    <span class="section-eyebrow" style="color:var(--gold);">Flagship Initiative</span>
                    <h2 style="font-size:clamp(2rem,3.5vw,2.8rem);font-weight:800;color:white;margin:0 0 1.25rem;">The Borderless Campaign</h2>
                    <div class="divider"></div>
                    <p style="color:rgba(255,255,255,0.6);margin-bottom:2rem;line-height:1.7;">
                        Our flagship initiative advocating for the removal of trade barriers and the free movement of people, goods, and services across Africa.
                    </p>
                    <ul style="list-style:none;padding:0;margin:0 0 2.5rem;display:flex;flex-direction:column;gap:1rem;">
                        @php $features=[['title'=>'Free Movement','desc'=>'Visa-free travel across all African countries'],['title'=>'Trade Integration','desc'=>'Removing barriers to cross-border commerce'],['title'=>'Digital Unity','desc'=>'A digital single market for African businesses']]; @endphp
                        @foreach($features as $f)
                        <li style="display:flex;align-items:flex-start;gap:0.9rem;">
                            <div style="width:22px;height:22px;border-radius:50%;background:var(--gold-dim);border:1px solid rgba(212,175,55,0.3);display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:0.15rem;">
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M2 6l3 3 5-5" stroke="var(--gold)" stroke-width="2" stroke-linecap="round"/></svg>
                            </div>
                            <span><strong style="color:white;">{{ $f['title'] }}:</strong> <span style="color:rgba(255,255,255,0.55);">{{ $f['desc'] }}</span></span>
                        </li>
                        @endforeach
                    </ul>
                    <a href="#" class="btn-gold-sm">Learn About the Campaign <svg width="14" height="14" viewBox="0 0 16 16" fill="none"><path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2"/></svg></a>
                </div>
                <div class="campaign-img"></div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div style="text-align:center;margin-bottom:3.5rem;" class="reveal">
                <span class="section-eyebrow">Purpose</span>
                <h2 class="section-h2 section-h2-center">Mission &amp; Vision</h2>
                <div class="divider divider-center"></div>
            </div>
            <div class="grid-2">
                <div class="card reveal">
                    <div class="icon-box icon-box-lg"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg></div>
                    <h3 style="font-size:1.6rem;font-weight:800;margin:0 0 1rem;">Our Mission</h3>
                    <p style="color:var(--muted);">To catalyze Africa's economic transformation through strategic partnerships, policy advocacy, and community building — creating an environment where businesses thrive, innovations flourish, and people connect across borders.</p>
                </div>
                <div class="card reveal reveal-d2">
                    <div class="icon-box icon-box-lg"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg></div>
                    <h3 style="font-size:1.6rem;font-weight:800;margin:0 0 1rem;">Our Vision</h3>
                    <p style="color:var(--muted);">A fully integrated, prosperous, and borderless Africa where every citizen has the opportunity to thrive — where the movement of people, goods, and ideas is seamless, and collective prosperity is the norm.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-alt">
        <div class="container">
            <div style="text-align:center;margin-bottom:3.5rem;" class="reveal">
                <span class="section-eyebrow">What We Stand For</span>
                <h2 class="section-h2 section-h2-center">Core Values</h2>
                <div class="divider divider-center"></div>
            </div>
            <div class="grid-4 reveal">
                @php $values=[['icon'=>'<path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>','t'=>'Unity','d'=>'Power through cross-border collaboration.'],['icon'=>'<path d="M13 10V3L4 14h7v7l9-11h-7z"/>','t'=>'Innovation','d'=>"Creative solutions to Africa's challenges."],['icon'=>'<circle cx="12" cy="12" r="10"/><path d="M9 12l2 2 4-4"/>','t'=>'Integrity','d'=>'Transparent and ethical leadership.'],['icon'=>'<circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/>','t'=>'Impact','d'=>'Success measured by real change.']]; @endphp
                @foreach($values as $i => $v)
                <div class="card reveal reveal-d{{ $i+1 }}" style="text-align:center;">
                    <div class="icon-box" style="margin:0 auto 1.5rem;"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="24" height="24">{!! $v['icon'] !!}</svg></div>
                    <h3 style="font-size:1.2rem;font-weight:800;margin:0 0 0.5rem;">{{ $v['t'] }}</h3>
                    <p style="color:var(--muted);font-size:0.9rem;margin:0;">{{ $v['d'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>


    <!-- ── PARALLAX SECTION 3: MEMBERSHIP IMPACT ── -->
    <section class="parallax-section">
        <div class="parallax-bg" style="background-image: url('https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?w=1600&q=80');"></div>
        <div class="parallax-overlay" style="background: linear-gradient(135deg, rgba(2,6,23,0.93) 0%, rgba(10,15,30,0.82) 55%, rgba(2,6,23,0.9) 100%);"></div>
        <div class="parallax-content">
            <div style="text-align:center;margin-bottom:3.5rem;" class="reveal">
                <div class="parallax-badge" style="margin:0 auto 1.5rem;">
                    <span style="width:6px;height:6px;border-radius:50%;background:var(--gold);display:inline-block;animation:pulse 2s infinite;"></span>
                    Member Impact
                </div>
                <h2 class="parallax-h2" style="max-width:700px;margin:0 auto 1rem;">Why Your Membership <span style="color:var(--gold);">Matters</span></h2>
                <p class="parallax-p" style="margin:0 auto;text-align:center;max-width:520px;">
                    As a member, you're not just supporting a cause — you're shaping Africa's future. Every contribution ripples across 54 nations.
                </p>
            </div>

            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;max-width:1000px;margin:0 auto 3rem;" class="reveal">
                @php $impactCards = [
                    ['num'=>'01','icon'=>'<path d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.952 9.168-5v10c-1.543-3.048-5.068-5-9.168-5H7a3.99 3.99 0 00-1.564.317z"/>','title'=>'Amplify Your Voice','desc'=>'Join thousands of advocates pushing for policy changes across the continent.','stat'=>'10k+','stat_label'=>'Advocates'],
                    ['num'=>'02','icon'=>'<path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>','title'=>'Network & Collaborate','desc'=>'Connect with change-makers, entrepreneurs and leaders across 54 nations.','stat'=>'54','stat_label'=>'Countries'],
                    ['num'=>'03','icon'=>'<path d="M13 10V3L4 14h7v7l9-11h-7z"/>','title'=>'Drive Real Change','desc'=>'Your membership directly funds initiatives that create tangible, lasting impact.','stat'=>'$5M+','stat_label'=>'Impact Fund'],
                ]; @endphp
                @foreach($impactCards as $i => $card)
                <div class="parallax-card reveal reveal-d{{ $i+1 }}" style="padding:2rem;text-align:center;">
                    <div style="width:52px;height:52px;border-radius:14px;background:var(--gold-dim);border:1px solid rgba(212,175,55,0.25);display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2">{!! $card['icon'] !!}</svg>
                    </div>
                    <div style="font-size:0.68rem;font-weight:800;letter-spacing:0.15em;color:rgba(212,175,55,0.6);text-transform:uppercase;margin-bottom:0.75rem;">{{ $card['num'] }}</div>
                    <h3 style="font-size:1.1rem;font-weight:800;color:white;margin:0 0 0.6rem;">{{ $card['title'] }}</h3>
                    <p style="font-size:0.85rem;color:rgba(255,255,255,0.5);line-height:1.6;margin:0 0 1.5rem;">{{ $card['desc'] }}</p>
                    <div style="border-top:1px solid rgba(255,255,255,0.07);padding-top:1.25rem;">
                        <div style="font-size:1.8rem;font-weight:900;color:var(--gold);letter-spacing:-0.04em;line-height:1;">{{ $card['stat'] }}</div>
                        <div style="font-size:0.68rem;text-transform:uppercase;letter-spacing:0.1em;color:rgba(255,255,255,0.35);font-weight:700;margin-top:0.2rem;">{{ $card['stat_label'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>

            <div style="text-align:center;" class="reveal">
                <a href="{{ route('member.benefits') }}" class="btn-gold" style="font-size:0.95rem;padding:0.9rem 2rem;">
                    Explore Member Benefits
                    <svg width="14" height="14" viewBox="0 0 16 16" fill="none"><path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2"/></svg>
                </a>
            </div>
        </div>
    </section>

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


    <!-- ── PARALLAX SECTION 2: PROSPERITY FUND ── -->
    <section class="parallax-section">
        <div class="parallax-bg" style="background-image: url('https://images.unsplash.com/photo-1611348586804-61bf6c080437?w=1600&q=80');"></div>
        <div class="parallax-overlay" style="background: linear-gradient(to right, rgba(2,6,23,0.95) 0%, rgba(2,6,23,0.8) 50%, rgba(10,15,30,0.6) 100%);"></div>
        <div class="parallax-content">
            <div class="parallax-split reveal">
                <div>
                    <div class="parallax-badge">
                        <span style="width:6px;height:6px;border-radius:50%;background:var(--gold);display:inline-block;animation:pulse 2s infinite;"></span>
                        Prosperity Fund
                    </div>
                    <h2 class="parallax-h2">$5M+ Invested in<br><span style="color:var(--gold);">Africa's Future</span></h2>
                    <p class="parallax-p">
                        Our impact fund channels member contributions directly into cross-border trade initiatives, youth entrepreneurship programs, and policy advocacy across the continent.
                    </p>
                    <div class="parallax-stats" style="margin-bottom:2.5rem;">
                        <div><div class="parallax-stat-val">$5M+</div><div class="parallax-stat-label">Funds Raised</div></div>
                        <div><div class="parallax-stat-val">15k+</div><div class="parallax-stat-label">Jobs Created</div></div>
                        <div><div class="parallax-stat-val">50+</div><div class="parallax-stat-label">Policy Wins</div></div>
                    </div>
                    <a href="{{ route('member.dashboard') }}" class="btn-gold" style="font-size:0.95rem; padding:0.9rem 1.9rem;">
                        Go to Dashboard
                        <svg width="14" height="14" viewBox="0 0 16 16" fill="none"><path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2"/></svg>
                    </a>
                </div>
                <div style="display:flex;flex-direction:column;gap:1rem;">
                    @php $fundItems = [
                        ['pct'=>'45','label'=>'Trade & Commerce','desc'=>'Cross-border trade facilitation programs'],
                        ['pct'=>'28','label'=>'Youth Enterprise','desc'=>'Startup support and mentorship for young Africans'],
                        ['pct'=>'17','label'=>'Policy Advocacy','desc'=>'Lobbying for continental integration policies'],
                        ['pct'=>'10','label'=>'Community Events','desc'=>'Summits, forums, and networking events'],
                    ]; @endphp
                    @foreach($fundItems as $item)
                    <div style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);border-radius:12px;padding:1rem 1.25rem;backdrop-filter:blur(8px);">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.5rem;">
                            <span style="font-weight:700;color:white;font-size:0.9rem;">{{ $item['label'] }}</span>
                            <span style="font-weight:800;color:var(--gold);font-size:0.9rem;">{{ $item['pct'] }}%</span>
                        </div>
                        <div style="height:4px;background:rgba(255,255,255,0.08);border-radius:2px;overflow:hidden;margin-bottom:0.4rem;">
                            <div style="height:100%;width:{{ $item['pct'] }}%;background:linear-gradient(90deg,var(--gold),var(--gold-light));border-radius:2px;"></div>
                        </div>
                        <p style="font-size:0.78rem;color:rgba(255,255,255,0.4);margin:0;">{{ $item['desc'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="cta-section reveal">
                <div class="cta-glow"></div>
                <div style="position:relative;z-index:1;max-width:600px;margin:0 auto;">
                    <span class="section-eyebrow" style="color:var(--gold);">Join Us</span>
                    <h2 style="font-size:clamp(2rem,4vw,3rem);font-weight:800;color:white;margin:0.75rem 0 1.25rem;">Ready to Make a Difference?</h2>
                    <p style="color:rgba(255,255,255,0.5);font-size:1.05rem;margin-bottom:2.5rem;">Join thousands of members across Africa who are building a prosperous, borderless future together.</p>
                    <div style="display:flex;justify-content:center;gap:1rem;flex-wrap:wrap;">
                        <a href="{{ route('member.dashboard') }}" class="btn-gold" style="font-size:1rem;padding:0.95rem 2rem;">Go to Dashboard</a>
                        <a href="{{ route('member.benefits') }}" class="btn-ghost" style="font-size:1rem;padding:0.95rem 2rem;">View Benefits</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
// ── Scroll-over effect: hide fixed hero bg once hero is out of view ──
(function() {
    const heroSection = document.getElementById('hero-section');
    const fixedEls = ['heroBg','heroOv1','heroOv2','heroOv3','heroDots'].map(id => document.getElementById(id));

    function onScroll() {
        const heroBottom = heroSection.getBoundingClientRect().bottom;
        const hide = heroBottom <= 0;
        fixedEls.forEach(el => {
            if (el) el.style.visibility = hide ? 'hidden' : 'visible';
        });
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
})();

// ── Reveal on scroll ──
const obs = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); obs.unobserve(e.target); } });
}, { threshold: 0.1, rootMargin: '0px 0px -60px 0px' });
document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
</script>
@endsection