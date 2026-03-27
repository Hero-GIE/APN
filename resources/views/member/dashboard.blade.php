@extends('layouts.guest')

@section('content')
<style>
    body {
        font-family: 'Open Sans', sans-serif;
        font-size: 16px;
        line-height: 1.6;
    }
    h1, h2, h3, h4, h5, h6, .heading-font, .font-urbanist, .btn, button, [class*="font-bold"] {
        font-family: 'Urbanist', sans-serif;
    }
    
    @keyframes pageReveal {
        from { opacity: 0; transform: scale(1.02); }
        to { opacity: 1; transform: scale(1); }
    }
    @keyframes patternMove {
        from { background-position: 0 0; }
        to { background-position: 200px 200px; }
    }
    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    .animate-page-reveal { animation: pageReveal 0.9s cubic-bezier(0.22,1,0.36,1) both; }
    .animate-pattern { animation: patternMove 60s linear infinite; }
    .animate-gradient { animation: gradientShift 5s ease infinite; background-size: 200% 200%; }

    .apn-scrollbar::-webkit-scrollbar { width: 6px; }
    .apn-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
    .apn-scrollbar::-webkit-scrollbar-thumb { background: #3b82f6; border-radius: 3px; }

    /* Text size adjustments */
    .text-xs {
        font-size: 0.8rem !important;
    }
    .text-sm {
        font-size: 0.95rem !important;
    }
    .text-base {
        font-size: 1rem !important;
    }
    .text-lg {
        font-size: 1.125rem !important;
    }
    .text-xl {
        font-size: 1.3rem !important;
    }
    .text-2xl {
        font-size: 1.65rem !important;
    }
    .text-3xl {
        font-size: 2rem !important;
    }

    .membership-card {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .membership-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 28px -10px rgba(59,130,246,0.2);
    }
    .popular-badge {
        position: absolute;
        top: 12px; right: -30px;
        background: linear-gradient(135deg, #3b82f6, #1d61ce);
        color: white;
        padding: 8px 40px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        transform: rotate(45deg);
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        z-index: 10;
    }
    .feature-list { list-style: none; padding: 0; margin: 0 0 1.5rem 0; }
    .feature-list li {
        display: flex; align-items: center; gap: 0.75rem;
        padding: 0.5rem 0;
        font-size: 0.95rem;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
    }
    .feature-list li:last-child { border-bottom: none; }
    .feature-list li i { color: #10b981; font-size: 0.9rem; width: 18px; text-align: center; }
    .price-tag { font-family: 'Urbanist', sans-serif; font-size: 2.2rem; font-weight: 800; color: #1e1b4b; line-height: 1.2; }
    .price-period { font-size: 0.95rem; color: #64748b; font-weight: 400; }

    /* Donation Modal Styles */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(4px);
        z-index: 50;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }

/* ── CAROUSEL ──────────────────────────────────────────────────────── */

/* Kente-inspired geometric pattern (SVG data URI) */
.carousel-kente-pattern {
    position: absolute;
    inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60'%3E%3Crect width='60' height='60' fill='none'/%3E%3Cpath d='M0 30h60M30 0v60' stroke='%23D4AF37' stroke-width='0.4' opacity='0.25'/%3E%3Cpath d='M0 0l60 60M60 0L0 60' stroke='%23D4AF37' stroke-width='0.3' opacity='0.12'/%3E%3Crect x='22' y='22' width='16' height='16' fill='none' stroke='%23D4AF37' stroke-width='0.5' opacity='0.18'/%3E%3Ccircle cx='30' cy='30' r='4' fill='none' stroke='%23D4AF37' stroke-width='0.4' opacity='0.15'/%3E%3C/svg%3E");
    background-size: 70px 70px;
    pointer-events: none;
    z-index: 2;
    animation: patternDrift 70s linear infinite;
}
@keyframes patternDrift {
    from { background-position: 0 0; }
    to   { background-position: 120px 120px; }
}

.featured-carousel {
    position: relative;
    margin-bottom: 2rem;
    border-radius: 20px;
    overflow: hidden;
    box-shadow:
        0 25px 50px -12px rgba(0,0,0,0.35),
        0 0 0 1px rgba(212,175,55,0.15);
}

.carousel-container {
    position: relative;
    width: 100%;
    height: 520px;
    overflow: hidden;
}

/* Each slide */
.carousel-slide {
    position: absolute;
    inset: 0;
    opacity: 0;
    transition: opacity 1s ease-in-out;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    transform: scale(1.04);
    transition: opacity 1s ease-in-out, transform 8s ease-in-out;
    pointer-events: none;
}
.carousel-slide.active {
    opacity: 1;
    transform: scale(1);
    pointer-events: auto;
}

/* Multi-layer overlay — dark base + gold radial + gradient */
.carousel-overlay {
    position: absolute;
    inset: 0;
    background:
        linear-gradient(to top,  rgba(2,6,23,0.92) 0%, rgba(2,6,23,0.5) 45%, rgba(2,6,23,0.15) 100%),
        linear-gradient(to right, rgba(2,6,23,0.6) 0%, transparent 60%),
        radial-gradient(ellipse 70% 60% at 5% 90%, rgba(55, 73, 212, 0.18) 0%, transparent 55%);
    display: flex;
    align-items: flex-end;
    padding: 3rem 3.5rem;
    z-index: 3;
}

/* Gold accent bar — left edge */
.carousel-overlay::before {
    content: '';
    position: absolute;
    left: 0; top: 15%; bottom: 15%;
    width: 3px;
    background: linear-gradient(to bottom, transparent, #3b82f6 30%, #1d61ce 70%, transparent);
    border-radius: 2px;
    opacity: 0.7;
}

/* Top-right corner ornament */
.carousel-overlay::after {
    content: '';
    position: absolute;
    top: 1.5rem; right: 1.5rem;
    width: 60px; height: 60px;
    border-top: 2px solid rgba(55, 63, 212, 0.35);
    border-right: 2px solid rgba(55, 63, 212, 0.35);
    border-radius: 0 8px 0 0;
}

.carousel-content {
    color: white;
    max-width: 740px;
    position: relative;
    z-index: 1;
}

/* Slide-up on active */
.carousel-slide.active .carousel-content {
    animation: slideUpIn 0.8s cubic-bezier(0.2,0,0,1) both;
}
@keyframes slideUpIn {
    from { opacity: 0; transform: translateY(28px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* Category tag */
.carousel-category {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.35rem 1rem;
    background: rgba(202, 201, 224, 0.15);
    border: 1px solid white;
    border-radius: 999px;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: white;
    margin-bottom: 1rem;
    backdrop-filter: blur(8px);
}
.carousel-category::before {
    content: '';
    width: 5px; height: 5px;
    border-radius: 10%;
    background: white;
    animation: pulse 2s infinite;
}
@keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(1.6)} }

/* Title */
.carousel-title {
    font-size: clamp(1.6rem, 3.5vw, 2.8rem);
    font-weight: 900;
    margin-bottom: 0.85rem;
    line-height: 1.15;
    text-shadow: 0 2px 12px rgba(0,0,0,0.4);
    font-family: 'Urbanist', sans-serif;
    letter-spacing: -0.02em;
}

/* Gold underline accent on title */
.carousel-title::after {
    content: '';
    display: block;
    width: 48px; height: 3px;
    background: linear-gradient(90deg, white, transparent);
    border-radius: 2px;
    margin-top: 0.65rem;
}

/* Excerpt */
.carousel-excerpt {
    font-size: clamp(0.9rem, 1.5vw, 1.05rem);
    margin-bottom: 1.25rem;
    opacity: 0.8;
    line-height: 1.65;
    max-width: 560px;
    font-family: 'Open Sans', sans-serif;
}

/* Meta row */
.carousel-meta {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 1.25rem;
    font-size: 0.82rem;
    font-family: 'Open Sans', sans-serif;
    color: white;
    margin-bottom: 1.5rem;
}
.carousel-meta-item {
    display: flex;
    align-items: center;
    gap: 0.4rem;
}
.carousel-meta-item i { color: white; font-size: 0.78rem; }

/* CTA button */
.carousel-button {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.75rem 1.75rem;
    background: #3b82f6;
    color: white;
    border-radius: 10px;
    font-weight: 700;
    font-size: 0.88rem;
    text-decoration: none;
    transition: all 0.25s ease;
    font-family: 'Urbanist', sans-serif;
    letter-spacing: 0.02em;
    position: relative;
    overflow: hidden;
    margin-top: 0 !important;
    position: relative;
    top: -17px; 
}
.carousel-button::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.25), transparent);
    opacity: 0;
    transition: opacity 0.25s;
}
.carousel-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 28px rgba(18, 28, 219, 0.45);
    color: #000;
}
.carousel-button:hover::before { opacity: 1; }

/* Progress bar at bottom */
/* .carousel-progress {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 2px;
    background: rgba(255,255,255,0.08);
    z-index: 10;
    overflow: hidden;
} */
/* .carousel-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #D4AF37, #F0D060);
    width: 0%;
    transition: width linear;
    border-radius: 0 2px 2px 0;
} */

/* Slide counter top-right */
.carousel-counter {
    position: absolute;
    top: 1.5rem; right: 5rem;
    z-index: 10;
    font-family: 'Urbanist', sans-serif;
    font-size: 0.8rem;
    font-weight: 700;
    color: rgba(255,255,255,0.5);
    letter-spacing: 0.08em;
}
.carousel-counter .current { color: white; font-size: 1.1rem; }

/* Nav dots */
.carousel-nav {
    position: absolute;
    bottom: 1.5rem; right: 2rem;
    display: flex;
    gap: 0.5rem;
    z-index: 10;
    align-items: center;
}
.carousel-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: white;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 1px solid rgba(255,255,255,0.2);
}
.carousel-dot.active {
    background: white;
    width: 22px;
    border-radius: 1px;
    box-shadow: 0 0 8px rgba(55, 55, 212, 0.5);
    border-color: #3b82f6;
}

/* Arrows */
.carousel-arrow {
    position: absolute;
    top: 50%; transform: translateY(-50%);
    width: 44px; height: 44px;
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    transition: all 0.25s ease;
    z-index: 10;
    color: white;
    font-size: 1rem;
}
.carousel-arrow:hover {
    background: rgba(212,175,55,0.2);
    border-color: white;
    transform: translateY(-50%) scale(1.08);
    color: white;
}
.carousel-arrow.prev { left: 1.5rem; }
.carousel-arrow.next { right: 1.5rem; }

/* Thumbnail strip at bottom-left */
.carousel-thumbs {
    position: absolute;
    bottom: 1.25rem; left: 3.5rem;
    z-index: 10;
    display: flex;
    gap: 0.5rem;
}

.absolute.right-0.mt-2.w-48 {
    z-index: 9999 !important;
}
.carousel-thumb {
    width: 48px; height: 32px;
    border-radius: 6px;
    border: 1px solid rgba(255,255,255,0.15);
    background-size: cover;
    background-position: center;
    cursor: pointer;
    opacity: 0.45;
    transition: all 0.25s ease;
    overflow: hidden;
}
.carousel-thumb.active,
.carousel-thumb:hover {
    opacity: 1;
    border-color: white;
    box-shadow: 0 0 0 2px rgba(212,175,55,0.3);
}

/* Responsive */
@media (max-width: 1024px) {
    .carousel-container { height: 460px; }
    .carousel-title { font-size: 2rem; }
    .carousel-thumbs { display: none; }
}
@media (max-width: 768px) {
    .featured-carousel { border-radius: 12px; }
    .carousel-container { height: 380px; }
    .carousel-overlay { padding: 2rem 1.75rem; }
    .carousel-title { font-size: 1.6rem; }
    .carousel-excerpt { font-size: 0.88rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .carousel-meta { gap: 0.75rem; font-size: 0.78rem; margin-bottom: 1rem; }
    .carousel-arrow { width: 38px; height: 38px; font-size: 0.85rem; }
    .carousel-arrow.prev { left: 0.75rem; }
    .carousel-arrow.next { right: 0.75rem; }
    .carousel-counter { display: none; }
}
@media (max-width: 640px) {
    .carousel-container { height: 340px; }
    .carousel-overlay { padding: 1.5rem; }
    .carousel-title { font-size: 1.35rem; }
    .carousel-excerpt { -webkit-line-clamp: 2; }
    .carousel-arrow { display: none; }
    .carousel-nav { right: 1rem; bottom: 1rem; }
}
@media (max-width: 480px) {
    .carousel-container { height: 300px; }
    .carousel-overlay { padding: 1.25rem; }
    .carousel-title { font-size: 1.15rem; }
    .carousel-category { font-size: 0.65rem; padding: 0.25rem 0.75rem; }
    .carousel-button { padding: 0.6rem 1.25rem; font-size: 0.8rem; }
}








/* File extension badge */
.bg-gray-200.text-gray-700.text-xs.rounded-full.uppercase {
    font-size: 0.7rem !important;
    font-weight: 600;
    letter-spacing: 0.02em;
}
/* Scrollable container for resources */
.resources-scrollable {
    max-height: 400px;
    overflow-y: auto;
    padding-right: 8px;
}

.resources-scrollable::-webkit-scrollbar {
    width: 6px;
}

.resources-scrollable::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.resources-scrollable::-webkit-scrollbar-thumb {
    background: #cbd5e0;
    border-radius: 10px;
}

.resources-scrollable::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Individual section scrollable if needed */
.section-scrollable {
    max-height: 300px;
    overflow-y: auto;
    padding-right: 8px;
    margin-bottom: 16px;
}

.section-scrollable::-webkit-scrollbar {
    width: 4px;
}

.section-scrollable::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.section-scrollable::-webkit-scrollbar-thumb {
    background: #cbd5e0;
    border-radius: 10px;
}
/* File icon hover effect */
.fa-file-pdf, .fa-file-word, .fa-file-excel, .fa-file-powerpoint, .fa-file-alt, .fa-file-image {
    transition: transform 0.2s ease;
}

.fa-file-pdf:hover, .fa-file-word:hover, .fa-file-excel:hover, .fa-file-powerpoint:hover, .fa-file-alt:hover, .fa-file-image:hover {
    transform: scale(1.1);
}

.carousel-nav {
    position: absolute;
    bottom: 2rem;
    right: 2rem;
    display: flex;
    gap: 0.5rem;
    z-index: 10;
}

.carousel-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: rgba(255,255,255,0.5);
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.carousel-dot.active {
    background: white;
    transform: scale(1.3);
    box-shadow: 0 0 10px rgba(255,255,255,0.5);
}

.featured-carousel {
    border-radius: 0.5rem; 
   
}

.carousel-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 50px;
    height: 50px;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 10;
    color: white;
    font-size: 1.5rem;
}

.carousel-arrow:hover {
    background: rgba(255,255,255,0.3);
    transform: translateY(-50%) scale(1.1);
}

.carousel-arrow.prev {
    left: 2rem;
}

.carousel-arrow.next {
    right: 2rem;
}

@media (max-width: 768px) {
    .carousel-container {
        height: 400px;
    }
    
    .carousel-title {
        font-size: 1.8rem;
    }
    
    .carousel-excerpt {
        font-size: 1rem;
    }
    
    .carousel-overlay {
        padding: 2rem;
    }
    
    .carousel-arrow {
        width: 40px;
        height: 40px;
        font-size: 1.2rem;
    }
    
    .carousel-arrow.prev {
        left: 1rem;
    }
    
    .carousel-arrow.next {
        right: 1rem;
    }
    }
    .modal-container {
        background: white;
        border-radius: 10px !important;
        max-width: 500px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        transform: translateY(20px);
        transition: all 0.3s ease;
    }
    .active .modal-container {
        transform: translateY(0);
    }
    .donation-option {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem;
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: center;
        font-weight: 600;
        font-size: 1rem;
    }

    /* Responsive Member Card Updates */
@media (max-width: 1024px) {
    .membership-card .grid {
        gap: 1rem;
    }
}

@media (max-width: 768px) {
    .membership-card {
        padding: 1.5rem !important;
    }
    
    .membership-card .flex.justify-between {
        flex-direction: column;
        gap: 1.5rem;
    }
    
    .membership-card .flex-1 {
        width: 100%;
    }
    
    .membership-card .grid {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 1rem;
    }
    
    .membership-card .ml-6 {
        margin-left: 0 !important;
        width: 100%;
    }
    
    .membership-card .flex.items-center {
        justify-content: flex-start;
    }
    
    .membership-card h2 {
        font-size: 1.5rem !important;
    }
    
    .membership-card .text-xs {
        font-size: 0.7rem !important;
    }
    
    .membership-card .text-base {
        font-size: 0.95rem !important;
    }
}

@media (max-width: 640px) {
    .membership-card {
        padding: 1.2rem !important;
    }
    
    .membership-card .flex.items-center.space-x-2 {
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .membership-card .grid {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 0.75rem;
    }
    
    .membership-card .grid > div {
        padding: 0.5rem;
        background: #f8fafc;
        border-radius: 0.5rem;
    }
    
    .membership-card h2 {
        font-size: 1.3rem !important;
        line-height: 1.3;
    }
    
    .membership-card p.text-gray-600 {
        font-size: 0.85rem !important;
        margin-bottom: 1rem;
    }
    
    .membership-card .text-xl {
        font-size: 1.2rem !important;
    }
    
    .membership-card .p-3 {
        padding: 0.6rem !important;
    }
    
    .membership-card .h-6.w-6 {
        height: 1.2rem;
        width: 1.2rem;
    }
}

@media (max-width: 480px) {
    .membership-card {
        padding: 1rem !important;
    }
    
    .membership-card .grid {
        grid-template-columns: 1fr !important;
        gap: 0.5rem;
    }
    
    .membership-card .grid > div {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem;
    }
    
    .membership-card .grid > div p:first-child {
        margin-bottom: 0;
    }
    
    .membership-card .flex.items-center.space-x-2 {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .membership-card .px-3.py-1 {
        font-size: 0.7rem !important;
        padding: 0.25rem 0.75rem !important;
    }
    
    .membership-card h2 {
        font-size: 1.2rem !important;
    }
    
    .membership-card .ml-3 p:first-child {
        font-size: 0.7rem !important;
    }
    
    .membership-card .text-xl.font-bold {
        font-size: 1.1rem !important;
    }
}
    .donation-option:hover {
        border-color: #3b82f6;
        background: #f0f9ff;
    }
    .donation-option.selected {
        border-color: #3b82f6;
        background: #eff6ff;
    }

    .field-apn {
        width: 100%;
        padding: 0.8rem 0.8rem 0.8rem 2.8rem;
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 0.95rem;
        color: #1e293b;
        transition: all 0.2s ease;
        outline: none;
        font-family: 'Open Sans', sans-serif;
    }
    .field-apn:focus {
        border-color: #3b82f6;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
    }
    .field-wrap { position: relative; }
    .field-wrap i {
        position: absolute; left: 0.9rem; top: 50%; transform: translateY(-50%);
        color: #94a3b8; font-size: 0.9rem; pointer-events: none;
    }

    /* Table styles */
    table td, table th {
        font-size: 0.95rem;
    }

    /* Responsive Carousel Updates */
@media (max-width: 1024px) {
    .featured-carousel {
        margin-bottom: 1.5rem;
    }
    
    .carousel-container {
        height: 450px;
    }
    
    .carousel-title {
        font-size: 2.2rem;
    }
}

@media (max-width: 768px) {
    .featured-carousel {
        margin-bottom: 1.2rem;
        border-radius: 0.5rem;
    }
    
    .carousel-container {
        height: 380px;
    }
    
    .carousel-overlay {
        padding: 2rem 1.5rem;
    }
    
    .carousel-title {
        font-size: 1.8rem;
        margin-bottom: 0.75rem;
    }
    
    .carousel-excerpt {
        font-size: 1rem;
        margin-bottom: 1rem;
        line-height: 1.5;
    }
    
    .carousel-category {
        padding: 0.4rem 1.2rem;
        font-size: 0.8rem;
        margin-bottom: 0.75rem;
    }

    
    
    .carousel-meta {
        flex-wrap: wrap;
        gap: 1rem;
        font-size: 0.9rem;
    }
    
    .carousel-meta-item {
        gap: 0.4rem;
    }
    
    .carousel-button {
        padding: 0.6rem 1.5rem;
        font-size: 0.9rem;
        margin-top: 1.2rem;
    }
    
    .carousel-arrow {
        width: 40px;
        height: 40px;
        font-size: 1.2rem;
    }
    
    .carousel-arrow.prev {
        left: 1rem;
    }
    
    .carousel-arrow.next {
        right: 1rem;
    }
    
    .carousel-nav {
        bottom: 1.5rem;
        right: 1.5rem;
    }
    
    .carousel-dot {
        width: 10px;
        height: 10px;
    }
}

@media (max-width: 640px) {
    .carousel-container {
        height: 350px;
    }
    
    .carousel-overlay {
        padding: 1.5rem;
    }
    
    .carousel-title {
        font-size: 1.5rem;
    }
    
    .carousel-excerpt {
        font-size: 0.9rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .carousel-meta {
        flex-direction: column;
        gap: 0.5rem;
        align-items: flex-start;
    }

      /* Additional styles for expired content */
    .expired-content-card {
        background: linear-gradient(135deg, #fef2f2 0%, #fff5f5 100%);
        border: 1px solid #fee2e2;
        border-radius: 1rem;
        padding: 3rem 2rem;
        text-align: center;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    }
    
    .expired-icon {
        background: linear-gradient(135deg, #fecaca, #fee2e2);
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }
    
    .renew-button {
        background: linear-gradient(135deg, #dc2626, #ef4444);
        transition: all 0.3s ease;
    }
    
    .renew-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(220, 38, 38, 0.3);
    }
    
    .carousel-meta-item {
        font-size: 0.85rem;
    }
    
    .carousel-button {
        padding: 0.5rem 1.2rem;
        font-size: 0.85rem;
    }
    
    .carousel-arrow {
        width: 35px;
        height: 35px;
        font-size: 1rem;
    }
    
    .carousel-nav {
        bottom: 1rem;
        right: 1rem;
    }
    
    .carousel-dot {
        width: 8px;
        height: 8px;
    }
}

@media (max-width: 480px) {
    .carousel-container {
        height: 300px;
    }
    
    .carousel-overlay {
        padding: 1rem;
    }
    
    .carousel-title {
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
    }
    
    .carousel-category {
        padding: 0.3rem 1rem;
        font-size: 0.75rem;
        margin-bottom: 0.5rem;
    }
    
    .carousel-excerpt {
        font-size: 0.8rem;
        -webkit-line-clamp: 2;
    }
    
    .carousel-arrow {
        width: 30px;
        height: 30px;
        font-size: 0.9rem;
    }
    
    .carousel-arrow.prev {
        left: 0.5rem;
    }
    
    .carousel-arrow.next {
        right: 0.5rem;
    }
}   

    th.text-xs.font-medium {
        font-size: 0.8rem !important;
        letter-spacing: 0.03em;
    }

    /* Game Cards Enhancement */
.group {
    position: relative;
}

/* Smooth background zoom on hover */
.group:hover .absolute.inset-0.bg-cover {
    transform: scale(1.1);
}

/* Optional: Add a subtle shine effect on hover */
.group::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
    transition: left 0.5s ease;
    z-index: 5;
    pointer-events: none;
}

.group:hover::before {
    left: 100%;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .group .p-8 {
        padding: 1.5rem;
    }
    
    .group .w-20.h-20 {
        width: 4rem;
        height: 4rem;
    }
    
    .group h3 {
        font-size: 1.25rem;
    }
    
    .group p {
        font-size: 0.875rem;
        margin-bottom: 0.75rem;
    }
}
    
    /* Status badges */
    .px-2.py-1.inline-flex.text-xs {
        font-size: 0.8rem !important;
        padding: 0.3rem 0.8rem !important;
    }
    
    /* Dropdown menu items */
    .dropdown-menu a, .dropdown-menu button,
    .absolute.w-48 a, .absolute.w-48 button {
        font-size: 0.95rem;
    }
    
    /* Banner text */
    .text-pink-800 .text-sm {
        font-size: 0.95rem;
    }
    
    /* Member Since, Renewal Date values */
    .text-base.font-semibold {
        font-size: 1.1rem;
    }
    
    /* Days Left value */
    .text-base.font-semibold small {
        font-size: 0.8rem;
    }
    
    /* Quick actions text */
    .space-y-3 .font-medium {
        font-size: 0.95rem;
    }

    /* Filter type option selected state */
.filter-type-option.selected {
    border-color: #8b5cf6 !important;
    background-color: #f5f3ff !important;
}

/* Modal overlay transitions */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    backdrop-filter: blur(4px);
    z-index: 50;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.modal-overlay.active {
    opacity: 1;
    visibility: visible;
}

.modal-container {
    background: white;
    border-radius: 24px;
    max-width: 600px;
    width: 90%;
    max-height: 90vh;
    overflow-y: auto;
    transform: translateY(20px);
    transition: all 0.3s ease;
}

.active .modal-container {
    transform: translateY(0);
}

    #libraryContent::-webkit-scrollbar {
        width: 6px;
    }
    #libraryContent::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    #libraryContent::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 3px;
    }
    #libraryContent::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    
    /* Footer/security note */
    .text-\[0\.7rem\] {
        font-size: 0.8rem !important;
    }
    
    /* Benefit items */
    .benefit-text {
        font-size: 0.95rem;
    }
    .benefit-text small {
        font-size: 0.8rem;
    }

    [x-cloak] { display: none !important; }
.tab-content { display: none; }
.tab-content[x-cloak] { display: none; }

    /* Tab styles */
    .dashboard-tabs {
        border-bottom: 2px solid #e5e7eb;
        margin-bottom: 2rem;
        display: flex;
        gap: 0.5rem;
        overflow-x: auto;
        padding-bottom: 0;
    }
    .tab-button {
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        color: #6b7280;
        border-bottom: 2px solid transparent;
        margin-bottom: -2px;
        transition: all 0.2s ease;
        cursor: pointer;
        background: none;
        border: none;
        white-space: nowrap;
    }
    .tab-button:hover {
        color: #4f46e5;
    }
    .tab-button.active {
        color: #4f46e5;
        border-bottom-color: #4f46e5;
    }
    .tab-content {
        display: none;
    }
    .tab-content.active {
        display: block;
    }
    
    /* News Card Styles */
    .news-card {
        background: white;
        border-radius: 0.5rem;
        padding: 1.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        border: 1px solid #f3f4f6;
    }
    .news-card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        transform: translateY(-2px);
    }
    
    .event-card {
        background: white;
        border-radius: 0.5rem;
        padding: 1.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        border: 1px solid #f3f4f6;
    }
    .event-card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    /* Donation reason options */
.donation-reason-option {
    transition: all 0.2s ease;
    cursor: pointer;
}

.donation-reason-option.selected {
    border-color: #4f46e5;
    background: #eef2ff;
    transform: scale(1.02);
    box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.1);
}

.donation-reason-option i {
    font-size: 1.25rem;
}
    
    .job-card {
        background: white;
        border-radius: 0.5rem;
        padding: 1.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        border: 1px solid #f3f4f6;
    }
    .job-card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    /* Responsive adjustments */
    @media (max-width: 640px) {
        body {
            font-size: 15px;
        }
        .text-xs {
            font-size: 0.75rem !important;
        }
        .text-sm {
            font-size: 0.875rem !important;
        }
        h1 {
            font-size: 1.75rem !important;
        }
        .tab-button {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
    }
</style>

    <div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ $donor->firstname }}!</h1>
                <p class="text-gray-600 mt-2">
                    @if($member->status == 'active')
                        Here's your membership overview and benefits.
                    @elseif($member->status == 'expired')
                        Your membership has expired. Renew to continue enjoying member benefits.
                    @elseif($member->status == 'cancelled')
                        Your membership has been cancelled. You can rejoin anytime.
                    @endif
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <!-- User Dropdown Menu -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center overflow-hidden flex-shrink-0" id="navAvatar">
                            @if(isset($latestFilteredImage) && $latestFilteredImage)
                                <img src="{{ url('storage/' . $latestFilteredImage->filtered_image) }}"
                                     alt="{{ $donor->firstname }}"
                                     class="w-full h-full object-cover rounded-full">
                            @else
                                <span class="text-indigo-600 font-semibold text-lg">
                                    {{ strtoupper(substr($donor->firstname, 0, 1)) }}{{ strtoupper(substr($donor->lastname, 0, 1)) }}
                                </span>
                            @endif
                        </div>
                        <span class="text-gray-700 font-medium">{{ $donor->firstname }} {{ $donor->lastname }}</span>
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open"
                         x-cloak
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         @click.away="open = false"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-[9999]">
                        
                        <!-- Always show these -->
                        <a href="{{ route('member.profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Profile</a>
                        <a href="{{ route('member.support') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Help & Support</a>
                        
                        <!-- Only show Member Benefits if membership is active -->
                        @if($member->status == 'active')
                            <a href="{{ route('member.benefits') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Member Benefits</a>
                            <a href="{{ route('member.payments') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Payment History</a>
                            <a href="{{ route('member.badges') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Digital Badge</a>
                        @endif
                        
                        <!-- Always show Switch to Donor Dashboard -->
                        <a href="{{ route('donor.dashboard') }}" class="block px-4 py-2 text-sm text-indigo-600 hover:bg-gray-100 font-medium">
                            Switch to Donor Dashboard
                        </a>
                        
                        <div class="border-t border-gray-100"></div>
                        <button @click="open = false; $dispatch('open-logout-modal')" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                            Logout
                        </button>
                    </div>
                </div>
            </div>
        </div>

         <!-- EXPIRATION BANNER -->
        @if($member->status == 'active' && $member->isExpiringSoon())
        <div class="mb-6 bg-gradient-to-r from-amber-50 to-orange-50 border-l-4 border-amber-500 rounded-lg shadow-sm overflow-hidden">
            <div class="p-5">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-3 flex-1">
                        <div class="bg-amber-100 rounded-full p-2.5 flex-shrink-0">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-amber-800 font-semibold text-base">
                                ⚠️ Your membership expires in <strong>{{ $member->daysLeft() }} days</strong>
                                @if($member->end_date)
                                <span class="text-amber-600 text-sm font-normal ml-1">({{ $member->end_date->format('M d, Y') }})</span>
                                @endif
                            </p>
                            <p class="text-amber-600 text-sm mt-0.5">Renew now to continue enjoying all member benefits without interruption.</p>
                        </div>
                    </div>
                    <div class="flex gap-3 flex-shrink-0">
                        <a href="{{ route('donor.membership', ['renew' => true, 'type' => $member->membership_type]) }}" 
                           class="px-5 py-2.5 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-all duration-200 font-medium text-sm shadow-sm whitespace-nowrap flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Renew Now →
                        </a>
                        <a href="{{ route('member.benefits') }}" 
                           class="px-4 py-2.5 bg-white text-amber-700 border border-amber-200 rounded-lg hover:bg-amber-50 transition-all duration-200 text-sm font-medium whitespace-nowrap">
                            View Benefits
                        </a>
                    </div>
                </div>
            </div>
            <div class="bg-amber-100/50 px-5 pb-3">
                <div class="flex justify-between text-xs text-amber-700 mb-1">
                    <span>Expiring soon</span>
                    <span>{{ $member->daysLeft() }} days remaining</span>
                </div>
                <div class="w-full bg-amber-200 rounded-full h-1.5 overflow-hidden">
                    <div class="bg-amber-600 h-1.5 rounded-full transition-all duration-500" 
                         style="width: {{ min(100, ($member->daysLeft() / 7) * 100) }}%"></div>
                </div>
            </div>
        </div>
        @endif
         <!-- ========== END OF EXPIRATION BANNER ========== -->

     <!-- STATIC DONATION BANNER - Always visible -->
        <div class="mb-6 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-4 sm:p-5 md:p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-start sm:items-center w-full sm:w-auto">
                <div class="bg-blue-100 rounded-full p-2 mr-3 flex-shrink-0">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm sm:text-base text-blue-800">
                        <span class="font-lg block sm:inline">Want to make an additional donation?</span> 
                        <span class="font-lg sm:text-sm block sm:inline sm:ml-1">Your support helps us expand our impact across Africa.</span>
                    </p>
                </div>
            </div>
            <button onclick="openDonationModal()" class="w-full sm:w-auto text-md font-medium text-blue-600 hover:text-blue-700 hover:underline flex items-center justify-center sm:justify-start px-4 py-2 sm:px-0 sm:py-0 bg-blue-50 sm:bg-transparent rounded-lg sm:rounded-none">
                Donate Now
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>



     <!-- CONTENT -->
@if($member->status == 'active')
    <!-- ACTIVE MEMBERSHIP -->
    <div x-data="{ 
        activeTab: localStorage.getItem('dashboard_active_tab') || 'dashboard',
        init() {
            const returnTab = sessionStorage.getItem('return_to_dashboard_tab');
            if (returnTab) {
                this.activeTab = returnTab;
                localStorage.setItem('dashboard_active_tab', returnTab);
                sessionStorage.removeItem('return_to_dashboard_tab');
            }
            this.$watch('activeTab', value => {
                localStorage.setItem('dashboard_active_tab', value);
            });
        }
    }" x-cloak>

        <!-- Navigation Tabs -->
        <div class="flex justify-center mb-8">
            <div class="dashboard-tabs inline-flex flex-wrap justify-center gap-1 border-b-2 border-gray-200 pb-0">
                <button class="tab-button px-4 py-2 md:px-6 md:py-3 font-semibold text-sm md:text-base transition-all duration-200 hover:text-indigo-600" onclick="switchTab('dashboard')" id="tab-dashboard">
                    <i class="fas fa-chart-pie mr-2"></i>Dashboard
                </button>
                <button class="tab-button px-4 py-2 md:px-6 md:py-3 font-semibold text-sm md:text-base transition-all duration-200 hover:text-indigo-600" onclick="switchTab('news')" id="tab-news">
                    <i class="fas fa-newspaper mr-2"></i>News
                </button>
                <button class="tab-button px-4 py-2 md:px-6 md:py-3 font-semibold text-sm md:text-base transition-all duration-200 hover:text-indigo-600" onclick="switchTab('calendar')" id="tab-calendar">
                    <i class="fas fa-calendar-alt mr-2"></i>Event Calendar
                </button>
                <button class="tab-button px-4 py-2 md:px-6 md:py-3 font-semibold text-sm md:text-base transition-all duration-200 hover:text-indigo-600" onclick="switchTab('jobs')" id="tab-jobs">
                    <i class="fas fa-briefcase mr-2"></i>Job Opportunities
                </button>
                <button class="tab-button px-4 py-2 md:px-6 md:py-3 font-semibold text-sm md:text-base transition-all duration-200 hover:text-indigo-600" onclick="switchTab('resources')" id="tab-resources">
                    <i class="fas fa-book-open mr-2"></i>Resources
                </button>
                <button class="tab-button px-4 py-2 md:px-6 md:py-3 font-semibold text-sm md:text-base transition-all duration-200 hover:text-indigo-600" onclick="switchTab('games')" id="tab-games">
                    <i class="fas fa-puzzle-piece mr-2"></i>Games & Puzzles
                </button>
            </div>
        </div>



        <!-- Tab Content - Dashboard -->
       <div id="content-dashboard" class="tab-content active">
    <!-- Membership Card -->
    <div class="bg-white rounded-lg shadow p-6 md:p-8 mb-6 md:mb-8 membership-card">
        <div class="flex flex-col lg:flex-row justify-between items-start gap-4 lg:gap-6">
            <div class="flex-1 w-full">
                <div class="flex flex-wrap items-center gap-2 mb-3 md:mb-4">
                    <span class="px-2 md:px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-semibold tracking-wide">
                        {{ $member->plan_name }}
                    </span>
                    <span class="px-2 md:px-3 py-1 bg-{{ $statusConfig['color'] }}-100 text-{{ $statusConfig['color'] }}-700 rounded-full text-xs font-semibold flex items-center">
                        <span class="w-1.5 h-1.5 md:w-2 md:h-2 bg-{{ $statusConfig['color'] }}-500 rounded-full mr-1 {{ $statusConfig['pulse'] ? 'animate-pulse' : '' }}"></span>
                        {{ $statusConfig['text'] }}
                    </span>
                </div>
                
                <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-1">
                    @if($member->status == 'active')
                        Member Benefits Active
                    @elseif($member->status == 'expired')
                        Membership Expired
                    @elseif($member->status == 'cancelled')
                        Membership Cancelled
                    @elseif($member->status == 'pending')
                        Membership Pending
                    @endif
                </h2>
                
                <p class="text-gray-600 text-xs md:text-sm mb-4 md:mb-6">
                    @if($member->status == 'active')
                        Your membership gives you access to exclusive APN benefits
                    @elseif($member->status == 'expired')
                        Your membership has expired. Renew to continue enjoying benefits.
                    @elseif($member->status == 'cancelled')
                        Your membership has been cancelled. You can rejoin anytime.
                    @elseif($member->status == 'pending')
                        Your membership is being processed. This may take 24-48 hours.
                    @endif
                </p>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4 lg:gap-6">
                    <div class="bg-gray-50 md:bg-transparent p-2 md:p-0 rounded-lg md:rounded-none">
                        <p class="text-gray-500 text-xs">Member Since</p>
                        <p class="text-sm md:text-base font-semibold text-gray-900">{{ $member->start_date->format('M Y') }}</p>
                    </div>
                    <div class="bg-gray-50 md:bg-transparent p-2 md:p-0 rounded-lg md:rounded-none">
                        <p class="text-gray-500 text-xs">Renewal Date</p>
                        <p class="text-sm md:text-base font-semibold text-gray-900">
                            @if($member->end_date)
                                {{ $member->end_date->format('M d, Y') }}
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                    <div class="bg-gray-50 md:bg-transparent p-2 md:p-0 rounded-lg md:rounded-none">
                        <p class="text-gray-500 text-xs">Days Left</p>
                        <p class="text-sm md:text-base font-semibold text-gray-900">
                            @if($member->status == 'active')
                                {{ $member->daysLeft() }} days
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div class="bg-gray-50 md:bg-transparent p-2 md:p-0 rounded-lg md:rounded-none">
                        <p class="text-gray-500 text-xs">Auto-Renew</p>
                        <p class="text-sm md:text-base font-semibold text-gray-900">{{ $member->renewal_count > 0 ? 'Yes' : 'No' }}</p>
                    </div>
                </div>
            </div>
            
            <div class="w-full lg:w-auto lg:ml-6 flex-shrink-0">
                <div class="flex items-center justify-start lg:justify-center bg-indigo-50 lg:bg-transparent p-3 lg:p-0 rounded-lg lg:rounded-none w-full lg:w-auto">
                    <div class="p-2 md:p-3 bg-indigo-100 rounded-full">
                        <svg class="h-5 w-5 md:h-6 md:w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-gray-500 text-xs">Membership</p>
                        <p class="text-lg md:text-xl font-bold text-gray-900">${{ $member->price }}</p>
                        <p class="text-xs text-gray-500">per {{ $member->membership_type }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Total Payments</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $payments->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Total Spent</p>
                    <p class="text-lg font-semibold text-gray-900">${{ number_format($payments->sum('amount'), 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-full">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Renewals</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $member->renewal_count }}</p>
                </div>
            </div>
        </div>
    </div>

  <!-- CAROUSEL - Featured Content -->
@if((isset($featuredNews) && $featuredNews->count() > 0) || (isset($featuredEvents) && $featuredEvents->count() > 0) || (isset($featuredJobs) && $featuredJobs->count() > 0))
<div class="featured-carousel mb-6 md:mb-8">
    <div class="carousel-container">

        {{-- Kente geometric pattern layer --}}
        <div class="carousel-kente-pattern"></div>

        {{-- Slide counter --}}
        <div class="carousel-counter">
            <span class="current" id="carouselCurrent">01</span>
            <span> / </span>
            <span id="carouselTotal">01</span>
        </div>

        @php
            $featuredItems = collect();

            if(isset($featuredNews)) {
                foreach($featuredNews as $newsItem) {
                    $featuredItems->push([
                        'type'           => 'news',
                        'id'             => $newsItem->id,
                        'title'          => $newsItem->title,
                        'excerpt'        => $newsItem->excerpt,
                        'image'          => $newsItem->featured_image ?? 'https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?w=1600&q=80',
                        'category'       => $newsItem->category,
                        'category_color' => $newsItem->category_color,
                        'date'           => $newsItem->published_date->format('M d, Y'),
                        'slug'           => $newsItem->slug,
                        'route'          => route('member.news.show', $newsItem->slug),
                        'icon'           => 'fa-newspaper'
                    ]);
                }
            }

            if(isset($featuredEvents)) {
                foreach($featuredEvents as $event) {
                    $featuredItems->push([
                        'type'           => 'event',
                        'id'             => $event->id,
                        'title'          => $event->title,
                        'excerpt'        => $event->description,
                        'image'          => $event->featured_image ?? 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=1600&q=80',
                        'category'       => $event->category,
                        'category_color' => $event->badge_color ?? 'indigo',
                        'date'           => $event->start_date->format('M d, Y'),
                        'location'       => $event->location,
                        'slug'           => $event->slug,
                        'route'          => route('member.events.show', $event->slug),
                        'icon'           => 'fa-calendar-alt'
                    ]);
                }
            }

            if(isset($featuredJobs)) {
                foreach($featuredJobs as $job) {
                    $featuredItems->push([
                        'type'           => 'job',
                        'id'             => $job->id,
                        'title'          => $job->title,
                        'excerpt'        => $job->summary,
                        'image'          => $job->company_logo ?? 'https://images.unsplash.com/photo-1521791136064-7986c2920216?w=1600&q=80',
                        'category'       => $job->category,
                        'category_color' => $job->category_color,
                        'date'           => $job->posted_date->format('M d, Y'),
                        'company'        => $job->company,
                        'location'       => $job->location,
                        'slug'           => $job->slug,
                        'route'          => route('member.jobs.show', $job->slug),
                        'icon'           => 'fa-briefcase'
                    ]);
                }
            }

            if ($featuredItems->isEmpty()) {
                if (isset($news) && $news->isNotEmpty()) {
                    $newsItem = $news->first();
                    $featuredItems->push(['type'=>'news','id'=>$newsItem->id,'title'=>$newsItem->title,'excerpt'=>$newsItem->excerpt,'image'=>$newsItem->featured_image ?? 'https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?w=1600&q=80','category'=>$newsItem->category,'category_color'=>$newsItem->category_color,'date'=>$newsItem->published_date->format('M d, Y'),'slug'=>$newsItem->slug,'route'=>route('member.news.show', $newsItem->slug),'icon'=>'fa-newspaper']);
                }
                if (isset($events) && $events->isNotEmpty()) {
                    $event = $events->first();
                    $featuredItems->push(['type'=>'event','id'=>$event->id,'title'=>$event->title,'excerpt'=>$event->description,'image'=>$event->featured_image ?? 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=1600&q=80','category'=>$event->category,'category_color'=>$event->badge_color ?? 'indigo','date'=>$event->start_date->format('M d, Y'),'location'=>$event->location,'slug'=>$event->slug,'route'=>route('member.events.show', $event->slug),'icon'=>'fa-calendar-alt']);
                }
                if (isset($jobs) && $jobs->isNotEmpty()) {
                    $job = $jobs->first();
                    $featuredItems->push(['type'=>'job','id'=>$job->id,'title'=>$job->title,'excerpt'=>$job->summary,'image'=>$job->company_logo ?? 'https://images.unsplash.com/photo-1521791136064-7986c2920216?w=1600&q=80','category'=>$job->category,'category_color'=>$job->category_color,'date'=>$job->posted_date->format('M d, Y'),'company'=>$job->company,'location'=>$job->location,'slug'=>$job->slug,'route'=>route('member.jobs.show', $job->slug),'icon'=>'fa-briefcase']);
                }
            }
        @endphp

        {{-- Slides --}}
        @foreach($featuredItems as $index => $item)
        <div class="carousel-slide {{ $index === 0 ? 'active' : '' }}"
             style="background-image: url('{{ $item['image'] }}');"
             data-index="{{ $index }}"
             data-route="{{ $item['route'] }}">
            <div class="carousel-overlay">
                <div class="carousel-content">
                    <div class="carousel-category">
                        <i class="fas {{ $item['icon'] }}"></i>
                        {{ $item['category'] }}
                    </div>
                    <h2 class="carousel-title">{{ $item['title'] }}</h2>
                    <p class="carousel-excerpt">{{ Str::limit($item['excerpt'], 130) }}</p>
                    <div class="carousel-meta">
                        <span class="carousel-meta-item">
                            <i class="far fa-calendar-alt"></i>
                            {{ $item['date'] }}
                        </span>
                        @if(isset($item['location']))
                        <span class="carousel-meta-item">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $item['location'] }}
                        </span>
                        @endif
                        @if(isset($item['company']))
                        <span class="carousel-meta-item">
                            <i class="fas fa-building"></i>
                            {{ $item['company'] }}
                        </span>
                        @endif
                    </div>
                    <a href="{{ $item['route'] }}" class="carousel-button" data-slide-index="{{ $index }}">
                        Learn More
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach

        {{-- Arrows --}}
        <div class="carousel-arrow prev hidden sm:flex" onclick="prevSlide()">
            <i class="fas fa-chevron-left"></i>
        </div>
        <div class="carousel-arrow next hidden sm:flex" onclick="nextSlide()">
            <i class="fas fa-chevron-right"></i>
        </div>

        {{-- Dot navigation --}}
        <div class="carousel-nav">
            @foreach($featuredItems as $index => $item)
            <div class="carousel-dot {{ $index === 0 ? 'active' : '' }}"
                 onclick="goToSlide({{ $index }})"
                 data-index="{{ $index }}"></div>
            @endforeach
        </div>

        {{-- Thumbnail strip --}}
        <div class="carousel-thumbs hidden md:flex">
            @foreach($featuredItems as $index => $item)
            <div class="carousel-thumb {{ $index === 0 ? 'active' : '' }}"
                 style="background-image: url('{{ $item['image'] }}');"
                 onclick="goToSlide({{ $index }})"
                 data-thumb="{{ $index }}"></div>
            @endforeach
        </div>

    </div>
</div>
@endif

    <!-- Quick Actions Card -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <!-- About Us -->
            <a href="{{ route('member.about') }}" class="flex items-center justify-between p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                <div class="flex items-center">
                    <div class="bg-purple-100 rounded-lg p-2 mr-3">
                        <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="font-medium text-gray-700">About Us</span>
                </div>
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            <!-- View All Benefits -->
            <a href="{{ route('member.benefits') }}" class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                <div class="flex items-center">
                    <div class="bg-indigo-100 rounded-lg p-2 mr-3">
                        <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                    <span class="font-medium text-gray-700">View All Benefits</span>
                </div>
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            <!-- Payment History -->
            <a href="{{ route('member.payments') }}" class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                <div class="flex items-center">
                    <div class="bg-green-100 rounded-lg p-2 mr-3">
                        <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <span class="font-medium text-gray-700">Payment History</span>
                </div>
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            <!-- Update Profile -->
            <a href="{{ route('member.profile.edit') }}" class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                <div class="flex items-center">
                    <div class="bg-purple-100 rounded-lg p-2 mr-3">
                        <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <span class="font-medium text-gray-700">Update Profile</span>
                </div>
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            <!-- Help & Support -->
            <a href="{{ route('member.support') }}" class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                <div class="flex items-center">
                    <div class="bg-blue-100 rounded-lg p-2 mr-3">
                        <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <span class="font-medium text-gray-700">Help & Support</span>
                </div>
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            @if($member->status == 'active')
            <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                <form action="{{ route('member.cancel') }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel your membership? This action cannot be undone.')" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-red-100 rounded-lg p-2 mr-3">
                                <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </div>
                            <span class="font-medium text-red-700">Cancel Membership</span>
                        </div>
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>

    <!-- Recent Payments Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">Recent Membership Payments</h2>
            <a href="{{ route('member.payments') }}" class="text-sm text-indigo-600 hover:text-indigo-900">View All →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Period</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Receipt</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($payments as $payment)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $payment->payment_date->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                            {{ substr($payment->transaction_id, 0, 8) }}...
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                            ${{ number_format($payment->amount, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($payment->period_start && $payment->period_end)
                                {{ $payment->period_start->format('M d') }} - {{ $payment->period_end->format('M d, Y') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Paid
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button onclick="downloadReceipt('{{ $payment->transaction_id }}', {{ $payment->amount }}, '{{ $payment->payment_date }}', '{{ $payment->payment_method ?? 'Card' }}')" 
                                    class="text-indigo-600 hover:text-indigo-900 font-medium">
                                Download
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">
                            No payment records found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Donation History -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">Your Donation History</h2>
            <a href="{{ route('member.transactions') }}" class="text-sm text-indigo-600 hover:text-indigo-900">View All Donations →</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Receipt</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($donations as $donation)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $donation->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                            {{ substr($donation->transaction_id, 0, 8) }}...
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                            ${{ number_format($donation->amount, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                {{ ucfirst($donation->payment_status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button onclick="downloadDonationReceipt('{{ $donation->transaction_id }}', {{ $donation->amount }}, '{{ $donation->created_at }}', '{{ $donation->payment_method ?? 'Card' }}')" 
                                    class="text-indigo-600 hover:text-indigo-900 font-medium">
                                Download
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">
                            No donations found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

    <!-- Tab Content - News -->
<div id="content-news" class="tab-content">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">Latest News</h2>
        <a href="{{ route('member.news.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">View All News →</a>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($news as $newsItem)
        <div class="news-card">
            <span class="text-xs 
                @if($newsItem->category_color == 'indigo') text-indigo-600
                @elseif($newsItem->category_color == 'green') text-green-600
                @elseif($newsItem->category_color == 'blue') text-blue-600
                @elseif($newsItem->category_color == 'purple') text-purple-600
                @else text-indigo-600
                @endif font-semibold uppercase tracking-wider">
                {{ $newsItem->category }}
            </span>
            <h3 class="text-lg font-bold text-gray-900 mt-2">{{ $newsItem->title }}</h3>
            <p class="text-gray-600 text-sm mt-2">{{ $newsItem->excerpt }}</p>
            <div class="flex items-center justify-between mt-4">
                <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($newsItem->published_date)->format('M d, Y') }}</span>
            <a href="{{ route('member.news.show', $newsItem->slug) }}#from-dashboard-news" class="text-sm text-indigo-600 hover:text-indigo-900">Read More →</a>
            </div>
        </div>
        @empty
        <div class="col-span-2 text-center py-8">
            <p class="text-gray-500">No news articles available at the moment.</p>
        </div>
        @endforelse
    </div>

    @if($news->count() > 0)
    <div class="text-center mt-8">
        <a href="{{ route('puzzles.index') }}" class="inline-block px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors text-sm font-medium">
            Browse All News
        </a>
    </div>
    @endif
</div>

<!-- Tab Content - Event Calendar -->
<div id="content-calendar" class="tab-content">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">Upcoming Events</h2>
        <a href="{{ route('member.events.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">View Full Calendar →</a>
    </div>

    <!-- Events List -->
    <div class="space-y-4">
        @forelse($events as $event)
        <div class="event-card flex items-start space-x-4">
            <div class="bg-indigo-50 rounded-lg p-3 text-center min-w-[80px]">
                <span class="block text-2xl font-bold text-indigo-600">{{ \Carbon\Carbon::parse($event->start_date)->format('d') }}</span>
                <span class="text-xs text-gray-600">{{ strtoupper(\Carbon\Carbon::parse($event->start_date)->format('M')) }}</span>
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-gray-900">{{ $event->title }}</h3>
                <p class="text-sm text-gray-600 mt-1">{{ $event->location }} • {{ \Carbon\Carbon::parse($event->start_date)->format('g:i A') }} - {{ \Carbon\Carbon::parse($event->end_date)->format('g:i A T') }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ $event->description }}</p>
                <div class="flex items-center space-x-4 mt-3">
                    @if($event->badge_type)
                    <span class="text-xs 
                        @if($event->badge_color == 'green') bg-green-100 text-green-700
                        @elseif($event->badge_color == 'yellow') bg-yellow-100 text-yellow-700
                        @elseif($event->badge_color == 'blue') bg-blue-100 text-blue-700
                        @else bg-green-100 text-green-700
                        @endif px-2 py-1 rounded-full">
                        {{ $event->badge_type }}
                    </span>
                    @endif
                   <a href="{{ route('member.events.show', $event->slug) }}#from-dashboard-calendar" class="text-sm text-indigo-600 hover:text-indigo-900">View Details →</a>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-8">
            <p class="text-gray-500">No upcoming events at the moment.</p>
        </div>
        @endforelse
    </div>

    <!-- Download Calendar -->
    <div class="mt-6 p-4 bg-gray-50 rounded-lg text-center">
        <p class="text-sm text-gray-600 mb-3">Add these events to your calendar</p>
        <div class="flex justify-center space-x-3">
            <button class="px-4 py-2 bg-white text-gray-700 rounded-lg hover:bg-gray-100 text-sm">Google Calendar</button>
            <button class="px-4 py-2 bg-white text-gray-700 rounded-lg hover:bg-gray-100 text-sm">iCal</button>
            <button class="px-4 py-2 bg-white text-gray-700 rounded-lg hover:bg-gray-100 text-sm">Outlook</button>
        </div>
    </div>
</div>

<!-- Tab Content - Job Opportunities -->
<div id="content-jobs" class="tab-content">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">Featured Job Opportunities</h2>
        <a href="{{ route('member.jobs.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">View All Jobs →</a>
    </div>

    <!-- Job Filters -->
    <div class="flex flex-wrap gap-2 mb-6">
        <button class="filter-job-btn px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium" data-category="all">All Jobs</button>
        <button class="filter-job-btn px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200" data-category="executive">Executive</button>
        <button class="filter-job-btn px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200" data-category="finance">Finance</button>
        <button class="filter-job-btn px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200" data-category="technology">Technology</button>
        <button class="filter-job-btn px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200" data-category="operations">Operations</button>
        <button class="filter-job-btn px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200" data-category="consulting">Consulting</button>
    </div>

    <!-- Jobs List Container -->
    <div id="jobs-list-container" class="space-y-4">
        @forelse($jobs as $job)
        <div class="job-card" data-job-category="{{ strtolower($job->category) }}">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">{{ $job->title }}</h3>
                    <p class="text-sm text-gray-600 mt-1">{{ $job->company }} • {{ $job->location }}</p>
                </div>
                @if($job->badge_type)
                <span class="text-xs 
                    @if($job->badge_color == 'green') bg-green-100 text-green-700
                    @elseif($job->badge_color == 'orange') bg-orange-100 text-orange-700
                    @else bg-green-100 text-green-700
                    @endif px-2 py-1 rounded-full">
                    {{ $job->badge_type }}
                </span>
                @endif
            </div>
            <p class="text-sm text-gray-600 mt-3">{{ $job->summary }}</p>
            <div class="flex flex-wrap items-center gap-4 mt-4">
                <span class="text-xs text-gray-500"><i class="far fa-clock mr-1"></i> {{ $job->job_type }}</span>
                <span class="text-xs text-gray-500"><i class="far fa-money-bill-alt mr-1"></i> {{ $job->salary_range }}</span>
                <span class="text-xs text-gray-500"><i class="far fa-calendar mr-1"></i> {{ $job->formatted_posted_date }}</span>
                <span class="text-xs 
                    @if($job->category_color == 'indigo') bg-indigo-100 text-indigo-700
                    @elseif($job->category_color == 'purple') bg-purple-100 text-purple-700
                    @elseif($job->category_color == 'blue') bg-blue-100 text-blue-700
                    @elseif($job->category_color == 'green') bg-green-100 text-green-700
                    @else bg-indigo-100 text-indigo-700
                    @endif px-2 py-1 rounded-full ml-auto">
                    {{ $job->experience_level }}
                </span>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <a href="{{ route('member.jobs.show', $job->slug) }}" class="text-sm text-indigo-600 hover:text-indigo-900">View Details →</a>
                
                @php
                    $hasApplied = $job->hasApplied(Auth::guard('donor')->id());
                @endphp
                
                @if($hasApplied)
                    <span class="px-4 py-2 bg-green-100 text-green-700 rounded-lg text-sm font-medium flex items-center gap-2">
                        <i class="fas fa-check-circle"></i>
                        Application Submitted
                    </span>
                @else
                    <a href="{{ route('member.jobs.apply', $job->slug) }}" 
                       class="px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg text-sm hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-md flex items-center gap-2">
                        <i class="fas fa-paper-plane"></i>
                        Apply Now
                    </a>
                @endif
            </div>
            
            @if($job->application_deadline && $job->application_deadline->diffInDays(now()) < 7)
            <div class="mt-3 text-xs text-amber-600 bg-amber-50 rounded-lg px-3 py-1 inline-block">
                <i class="far fa-clock mr-1"></i> Deadline: {{ $job->application_deadline->format('M d, Y') }}
            </div>
            @endif
        </div>
        @empty
        <div class="text-center py-12">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No jobs available</h3>
            <p class="text-gray-500">Check back soon for new opportunities.</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Tab Content - Resources -->
<div id="content-resources" class="tab-content">
    <!-- Picture Filter Upload Section -->
    <div class="mb-8 bg-gradient-to-r from-blue-50 to-blue-50 rounded-xl p-6 border-2 border-blue-200 shadow-sm">
        <div class="flex flex-col md:flex-row items-start md:items-center gap-4">
            <div class="flex-shrink-0">
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-camera-retro text-3xl text-blue-600"></i>
                </div>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-bold text-gray-900 mb-1">Create an image petition</h3>
                <p class="text-gray-600 text-sm mb-2">
                    Upload your photo to apply the official <span class="font-semibold text-blue-600">"Member of Africa Prosperity Network"</span> filter. 
                    Share on social media to show you signed the petition!
                </p>
                <div class="flex flex-wrap gap-3 mt-2">
                    <span class="inline-flex items-center text-xs bg-white px-3 py-1 rounded-full text-gray-700 shadow-sm">
                        <i class="fas fa-check-circle text-green-500 mr-1"></i>Petition Signature
                    </span>
                    <span class="inline-flex items-center text-xs bg-white px-3 py-1 rounded-full text-gray-700 shadow-sm">
                        <i class="fas fa-x-twitter text-black mr-1"></i>Twitter
                    </span>
                    <span class="inline-flex items-center text-xs bg-white px-3 py-1 rounded-full text-gray-700 shadow-sm">
                        <i class="fab fa-linkedin text-blue-600 mr-1"></i> LinkedIn Ready
                    </span>
                    <span class="inline-flex items-center text-xs bg-white px-3 py-1 rounded-full text-gray-700 shadow-sm">
                        <i class="fab fa-instagram text-pink-600 mr-1"></i> Instagram Ready
                    </span>
                </div>
            </div>
            
            <div class="flex-shrink-0">
                <!-- Upload Button that opens modal -->
                <button onclick="openFilterUploadModal()" 
                        class="px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-xl font-semibold hover:from-purple-700 hover:to-indigo-700 transition-all shadow-md flex items-center gap-2 whitespace-nowrap">
                    <i class="fas fa-cloud-upload-alt"></i>
                    Upload Photo & Apply Filter
                </button>
            </div>
            
        </div>
        
    </div>

    <!-- APN Member Library Section (Original content) -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">APN Member Library</h2>
        <p class="text-sm text-gray-500">Access magazines, reports, and newsletters</p>
    </div>

    <!-- Rest of Resources Content -->
    <div class="space-y-6">
        <!-- Magazines Section -->
        <div class="bg-white rounded-lg p-4 border border-gray-200">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-lg font-semibold text-gray-800">Magazines</h3>
                <span class="text-xs text-gray-500" id="magazinesCount"></span>
            </div>
            <div id="magazinesList" class="section-scrollable"></div>
        </div>

        <!-- Reports Section -->
        <div class="bg-white rounded-lg p-4 border border-gray-200">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-lg font-semibold text-gray-800">Special Reports</h3>
                <span class="text-xs text-gray-500" id="reportsCount"></span>
            </div>
            <div id="reportsList" class="section-scrollable"></div>
        </div>

        <!-- Newsletters Section -->
        <div class="bg-white rounded-lg p-4 border border-gray-200">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-lg font-semibold text-gray-800">Newsletters</h3>
                <span class="text-xs text-gray-500" id="newslettersCount"></span>
            </div>
            <div id="newslettersList" class="section-scrollable"></div>
        </div>

        <!-- Loading State -->
        <div id="resourcesLoading" class="text-center py-12">
            <svg class="animate-spin h-8 w-8 text-purple-600 mx-auto" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="mt-3 text-gray-500">Loading resources...</p>
        </div>

        <!-- Empty State -->
        <div id="resourcesEmptyState" class="hidden text-center py-12">
            <svg class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No publications available</h3>
            <p class="text-gray-500">Check back soon for new content.</p>
        </div>
    </div>
</div>

<!-- Tab Content - Games & Puzzles -->
<div id="content-games" class="tab-content">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <!-- Game Type Cards -->
       <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <!-- Quiz Card with Background Image -->
    <a href="{{ route('quiz.index') }}" 
       class="group relative rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
        <!-- Background Image -->
        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-110" 
             style="background-image: url('https://res.cloudinary.com/dvsacegwf/image/upload/v1774378076/84630ad2-4a44-481d-bfad-e8556e33ae42_pcretq.jpg');">
        </div>
        <!-- Light Overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-900/70 via-indigo-800/60 to-purple-900/70 group-hover:opacity-90 transition-opacity duration-300"></div>
        
        <div class="relative p-8 text-center z-10">
            <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                <i class="fas fa-question-circle text-4xl text-white"></i>
            </div>
            <h3 class="text-2xl font-bold text-white mb-2">Quizzes</h3>
            <p class="text-indigo-100 mb-4">Test your knowledge about African history, culture, and heritage.</p>
            <span class="inline-flex items-center text-white font-medium group-hover:translate-x-2 transition-transform">
                Browse Quizzes
                <i class="fas fa-arrow-right ml-2"></i>
            </span>
        </div>
    </a>

    <!-- Word Search Card with Background Image -->
    <a href="{{ route('wordsearch.index') }}" 
       class="group relative rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
        <!-- Background Image -->
        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-110" 
             style="background-image: url('https://res.cloudinary.com/dvsacegwf/image/upload/v1774380503/wordsearch-game-word-corporation-business_joawdj.jpg');">
        </div>
        <!-- Light Overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-gray-900/60 via-gray-800/50 to-gray-700/60 group-hover:opacity-80 transition-opacity duration-300"></div>
        
        <div class="relative p-8 text-center z-10">
            <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                <i class="fas fa-search text-4xl text-white"></i>
            </div>
            <h3 class="text-2xl font-bold text-white mb-2">Word Search</h3>
            <p class="text-gray-100 mb-4">
                Find hidden words about African countries, leaders, and cultural terms.
            </p>
            <span class="inline-flex items-center text-white font-medium group-hover:translate-x-2 transition-transform">
                Play Word Search
                <i class="fas fa-arrow-right ml-2"></i>
            </span>
        </div>
    </a>
</div>

        <!-- Featured Word Searches Section -->
        @if(isset($featuredWordsearches) && $featuredWordsearches->count() > 0)
        <div class="mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Featured Word Searches</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($featuredWordsearches as $wordsearch)
                <div class="bg-gray-50 rounded-lg border border-gray-200 overflow-hidden hover:shadow-md transition-all">
                    @if($wordsearch->featured_image)
                    <div class="h-32 overflow-hidden">
                        <img src="{{ $wordsearch->featured_image }}" class="w-full h-full object-cover">
                    </div>
                    @endif
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs px-2 py-1 rounded-full 
                                @if($wordsearch->difficulty == 'beginner') bg-green-100 text-green-700
                                @elseif($wordsearch->difficulty == 'intermediate') bg-blue-100 text-blue-700
                                @else bg-orange-100 text-orange-700 @endif">
                                {{ ucfirst($wordsearch->difficulty) }}
                            </span>
                            <span class="text-xs text-gray-500">{{ $wordsearch->questions->count() }} words</span>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-1">{{ $wordsearch->title }}</h3>
                        <p class="text-xs text-gray-600 mb-3">{{ Str::limit($wordsearch->short_description, 70) }}</p>
                        <a href="{{ route('wordsearch.show', $wordsearch->slug) }}" class="text-indigo-600 text-sm font-medium hover:text-indigo-800">
                            Play Now →
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Popular Puzzles Section -->
        @if(isset($popularPuzzles) && $popularPuzzles->count() > 0)
        <div class="mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Popular Puzzles</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($popularPuzzles as $puzzle)
                <div class="bg-gray-50 rounded-lg border border-gray-200 p-4 hover:shadow-md transition-all">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs px-2 py-1 rounded-full 
                            @if($puzzle->difficulty == 'beginner') bg-green-100 text-green-700
                            @elseif($puzzle->difficulty == 'intermediate') bg-blue-100 text-blue-700
                            @elseif($puzzle->difficulty == 'advanced') bg-orange-100 text-orange-700
                            @else bg-red-100 text-red-700 @endif">
                            {{ ucfirst($puzzle->difficulty) }}
                        </span>
                        <div class="flex items-center text-xs text-yellow-500">
                            <i class="fas fa-star mr-1"></i>
                            <span>{{ number_format($puzzle->average_rating ?? 4.5, 1) }}</span>
                        </div>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">{{ $puzzle->title }}</h3>
                    <p class="text-xs text-gray-600 mb-3">{{ Str::limit($puzzle->short_description, 70) }}</p>
                    <a href="{{ route('puzzles.show', $puzzle->slug) }}" class="text-indigo-600 text-sm font-medium hover:text-indigo-800">
                        Play Now →
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

   <!-- Word Search Categories -->
<div class="mb-8">
    <h2 class="text-lg font-semibold text-gray-800 mb-4 font-urbanist">Word Search Categories</h2>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
        <!-- All Word Searches Card -->
        <a href="{{ route('wordsearch.index') }}" class="bg-white rounded-lg border border-gray-200 p-4 hover:shadow-md transition-all hover:-translate-y-1 group">
            <div class="flex flex-col items-center text-center">
                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-indigo-200 transition-colors">
                    <i class="fas fa-globe-africa text-indigo-600 text-xl"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-1 font-urbanist text-sm">All Word Search Puzzles</h3>
                <p class="text-xs text-gray-500">Browse all word searches</p>
                <div class="mt-2 text-indigo-600 text-xs font-medium group-hover:underline">
                    Explore →
                </div>
            </div>
        </a>

        <!-- Countries Card -->
        <a href="{{ route('wordsearch.show', 'african-countries') }}" class="bg-white rounded-lg border border-gray-200 p-4 hover:shadow-md transition-all hover:-translate-y-1 group">
            <div class="flex flex-col items-center text-center">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-green-200 transition-colors">
                    <i class="fas fa-map text-green-600 text-xl"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-1 font-urbanist text-sm">Countries</h3>
                <p class="text-xs text-gray-500">Find African nations</p>
                <div class="mt-2 text-indigo-600 text-xs font-medium group-hover:underline">
                    Play →
                </div>
            </div>
        </a>

        <!-- Capitals Card -->
        <a href="{{ route('wordsearch.show', 'african-capitals') }}" class="bg-white rounded-lg border border-gray-200 p-4 hover:shadow-md transition-all hover:-translate-y-1 group">
            <div class="flex flex-col items-center text-center">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-blue-200 transition-colors">
                    <i class="fas fa-city text-blue-600 text-xl"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-1 font-urbanist text-sm">Capitals</h3>
                <p class="text-xs text-gray-500">Find capital cities</p>
                <div class="mt-2 text-indigo-600 text-xs font-medium group-hover:underline">
                    Play →
                </div>
            </div>
        </a>

        <!-- Animals Card -->
        <a href="{{ route('wordsearch.show', 'african-animals') }}" class="bg-white rounded-lg border border-gray-200 p-4 hover:shadow-md transition-all hover:-translate-y-1 group">
            <div class="flex flex-col items-center text-center">
                <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-amber-200 transition-colors">
                    <i class="fas fa-paw text-amber-600 text-xl"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-1 font-urbanist text-sm">Animals</h3>
                <p class="text-xs text-gray-500">African wildlife</p>
                <div class="mt-2 text-indigo-600 text-xs font-medium group-hover:underline">
                    Play →
                </div>
            </div>
        </a>

        <!-- Landmarks Card -->
        <a href="{{ route('wordsearch.show', 'african-landmarks') }}" class="bg-white rounded-lg border border-gray-200 p-4 hover:shadow-md transition-all hover:-translate-y-1 group">
            <div class="flex flex-col items-center text-center">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-purple-200 transition-colors">
                    <i class="fas fa-landmark text-purple-600 text-xl"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-1 font-urbanist text-sm">Landmarks</h3>
                <p class="text-xs text-gray-500">Famous places</p>
                <div class="mt-2 text-indigo-600 text-xs font-medium group-hover:underline">
                    Play →
                </div>
            </div>
        </a>

        <!-- Cultures Card -->
        <a href="{{ route('wordsearch.show', 'african-cultures') }}" class="bg-white rounded-lg border border-gray-200 p-4 hover:shadow-md transition-all hover:-translate-y-1 group">
            <div class="flex flex-col items-center text-center">
                <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-pink-200 transition-colors">
                    <i class="fas fa-drumstick-bite text-pink-600 text-xl"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-1 font-urbanist text-sm">Cultures</h3>
                <p class="text-xs text-gray-500">African traditions</p>
                <div class="mt-2 text-indigo-600 text-xs font-medium group-hover:underline">
                    Play →
                </div>
            </div>
        </a>
    </div>
</div>

        <!-- View All Button -->
        <div class="text-center">
            <a href="{{ route('puzzles.index') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-medium">
                <i class="fas fa-th-large mr-2"></i>
                Browse All Games
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>

 @elseif($member->status == 'expired')
    <!-- EXPIRED MEMBERSHIP - Show renewal div -->
    <div class="expired-content-card">
        <div class="expired-icon">
            <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        
        <h2 class="text-2xl font-bold text-gray-900 mb-3">
            Your Membership Has Expired
        </h2>
        
        <p class="text-gray-600 mb-4 max-w-md mx-auto">
            Your membership expired on <strong class="text-red-600">{{ $member->end_date ? $member->end_date->format('M d, Y') : 'N/A' }}</strong>.
            You've lost access to member benefits including news, events, job opportunities, resources, and games.
        </p>
        
        <div class="bg-red-50 rounded-lg p-4 mb-6 max-w-md mx-auto">
            <p class="text-sm text-red-700">
                <i class="fas fa-info-circle mr-2"></i>
                Renew your membership to:
            </p>
            <ul class="text-sm text-red-600 mt-2 space-y-1 text-left inline-block">
                <li><i class="fas fa-check-circle text-green-500 mr-2"></i>Access exclusive member content</li>
                <li><i class="fas fa-check-circle text-green-500 mr-2"></i>Get 10% discount on events</li>
                <li><i class="fas fa-check-circle text-green-500 mr-2"></i>Receive APN Magazine digitally</li>
                <li><i class="fas fa-check-circle text-green-500 mr-2"></i>Network with fellow members</li>
            </ul>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('donor.membership') }}" 
               class="renew-button inline-flex items-center justify-center px-6 py-3 bg-red-600 text-white rounded-xl font-semibold text-base shadow-md transition-all duration-300 gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Renew Membership Now
            </a>
            <a href="{{ route('donor.membership') }}" 
               class="inline-flex items-center justify-center px-6 py-3 bg-white text-red-600 border-2 border-red-200 rounded-xl font-semibold text-base hover:bg-red-50 transition-all duration-300 gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                View Membership Plans
            </a>
        </div>
        
        <div class="mt-6 pt-6 border-t border-gray-200">
            <p class="text-xs text-gray-500">
                <i class="fas fa-lock mr-1"></i> Secure payment via Paystack
            </p>
        </div>
    </div>

@elseif($member->status == 'cancelled')
    <!-- CANCELLED MEMBERSHIP -->
    <div class="expired-content-card">
        <div class="expired-icon">
            <svg class="w-10 h-10 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
            </svg>
        </div>
        
        <h2 class="text-2xl font-bold text-gray-900 mb-3">
            Your Membership is Cancelled
        </h2>
        
        <p class="text-gray-600 mb-4 max-w-md mx-auto">
            Your membership was cancelled on <strong class="text-orange-600">{{ $member->updated_at->format('M d, Y') }}</strong>.
            You can rejoin at any time to regain access to member benefits.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('donor.membership') }}" 
               class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 text-white rounded-xl font-semibold text-base shadow-md transition-all duration-300 gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Rejoin as Member
            </a>
        </div>
    </div>

@else
    <!-- PENDING OR OTHER STATUS -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-8 text-center">
        <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-hourglass-half text-2xl text-yellow-600"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Membership {{ ucfirst($member->status) }}</h2>
        <p class="text-gray-600">
            @if($member->status == 'pending')
                Your membership is being processed. This typically takes 24-48 hours.
            @else
                Your membership status is {{ $member->status }}. Please contact support if you have questions.
            @endif
        </p>
    </div>
@endif
</div>

</div>

</div>


{{-- DONATION MODAL --}}
<div id="donationModal" class="modal-overlay">
    <div class="modal-container p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-urbanist text-xl font-bold text-gray-900">Make a Donation</h3>
            <button onclick="closeDonationModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <div id="modalErrorContainer"></div>

        {{-- Donation Reasons --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-3">Select Donation Purpose</label>
            <div class="grid grid-cols-2 gap-3">
                <button type="button" onclick="selectDonationReason('campaign')" 
                        class="donation-reason-option p-3 border-2 border-gray-200 rounded-xl text-left hover:border-purple-500 hover:bg-purple-50 transition-all" data-reason="campaign">
                    <i class="fas fa-bullhorn text-purple-600 mb-1"></i>
                    <p class="font-medium text-gray-900">Campaign Support</p>
                    <p class="text-xs text-gray-500">Support our advocacy campaigns</p>
                </button>
                
                <button type="button" onclick="selectDonationReason('youth')" 
                        class="donation-reason-option p-3 border-2 border-gray-200 rounded-xl text-left hover:border-blue-500 hover:bg-blue-50 transition-all" data-reason="youth">
                    <i class="fas fa-users text-blue-600 mb-1"></i>
                    <p class="font-medium text-gray-900">Youth Initiatives</p>
                    <p class="text-xs text-gray-500">Empower young Africans</p>
                </button>
                
                <button type="button" onclick="selectDonationReason('events')" 
                        class="donation-reason-option p-3 border-2 border-gray-200 rounded-xl text-left hover:border-green-500 hover:bg-green-50 transition-all" data-reason="events">
                    <i class="fas fa-calendar-alt text-green-600 mb-1"></i>
                    <p class="font-medium text-gray-900">Events</p>
                    <p class="text-xs text-gray-500">Support APN events and programs</p>
                </button>
                
                <button type="button" onclick="selectDonationReason('advocacy')" 
                        class="donation-reason-option p-3 border-2 border-gray-200 rounded-xl text-left hover:border-orange-500 hover:bg-orange-50 transition-all" data-reason="advocacy">
                    <i class="fas fa-gavel text-orange-600 mb-1"></i>
                    <p class="font-medium text-gray-900">Advocacy Work</p>
                    <p class="text-xs text-gray-500">Support policy advocacy</p>
                </button>
                
                <button type="button" onclick="selectDonationReason('projects')" 
                        class="donation-reason-option p-3 border-2 border-gray-200 rounded-xl text-left hover:border-indigo-500 hover:bg-indigo-50 transition-all" data-reason="projects">
                    <i class="fas fa-project-diagram text-indigo-600 mb-1"></i>
                    <p class="font-medium text-gray-900">Special Projects</p>
                    <p class="text-xs text-gray-500">Fund specific initiatives</p>
                </button>
                
                <button type="button" onclick="selectDonationReason('other')" 
                        class="donation-reason-option p-3 border-2 border-gray-200 rounded-xl text-left hover:border-gray-500 hover:bg-gray-50 transition-all" data-reason="other">
                    <i class="fas fa-heart text-gray-600 mb-1"></i>
                    <p class="font-medium text-gray-900">Other</p>
                    <p class="text-xs text-gray-500">Custom purpose</p>
                </button>
            </div>
            
            {{-- Custom reason input (hidden by default) --}}
            <div id="customReasonContainer" class="mt-3 hidden">
                <label class="block text-sm font-medium text-gray-700 mb-2">Specify purpose (optional)</label>
                <input type="text" id="customReason" 
                       class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:outline-none"
                       placeholder="e.g., Education fund, Healthcare initiative...">
            </div>
        </div>

        {{-- Quick amount options --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-3">Select Amount</label>
            <div class="grid grid-cols-3 gap-3">
                <button onclick="setDonationAmount(10)" class="donation-option">$10</button>
                <button onclick="setDonationAmount(25)" class="donation-option">$25</button>
                <button onclick="setDonationAmount(50)" class="donation-option">$50</button>
                <button onclick="setDonationAmount(100)" class="donation-option">$100</button>
                <button onclick="setDonationAmount(250)" class="donation-option">$250</button>
                <button onclick="setDonationAmount(500)" class="donation-option">$500</button>
            </div>
        </div>

        {{-- Custom amount --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Or enter custom amount</label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-semibold">$</span>
                <input type="number" id="donationAmount" min="1" step="1" 
                       class="w-full pl-8 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:outline-none"
                       placeholder="Enter amount">
            </div>
        </div>

        <div class="bg-blue-50 p-4 rounded-xl mb-6">
            <p class="text-sm text-blue-800 flex items-start gap-2">
                <i class="fas fa-info-circle mt-0.5"></i>
                <span>Your donation helps us continue our mission of building Africa's prosperity through economic integration and development programs.</span>
            </p>
        </div>

        <div class="flex gap-3">
            <button onclick="processDonation()" 
                    class="flex-1 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-urbanist font-bold hover:from-blue-700 hover:to-indigo-700 transition-all duration-300">
                Complete Donation
            </button>
            <button onclick="closeDonationModal()" 
                    class="flex-1 py-3 bg-gray-100 text-gray-700 rounded-xl font-urbanist font-bold hover:bg-gray-200 transition-all duration-300">
                Cancel
            </button>
        </div>
    </div>
</div>

<!-- Picture Filter Upload Modal -->
<div id="filterUploadModal" class="modal-overlay">
    <div class="modal-container p-6 max-w-2xl">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-urbanist text-xl font-bold text-gray-900">Create Your Petition Filter Image</h3>
            <button onclick="closeFilterUploadModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Preview of the filter -->
        <div class="text-center mb-8 p-4 bg-gray-50 rounded-xl">
            <div class="relative inline-block">
               <img src="{{ asset('images/filtered-image.png') }}" 
                alt="Filter Preview" 
                class="block mx-auto object-cover rounded-lg shadow-md max-h-48">
                <p class="text-sm text-gray-600 mt-2">Your image will be placed inside this frame</p>
            </div>
        </div>
        <!-- Filter Type Selection -->
<div class="mb-6">
    <label class="block text-sm font-medium text-gray-700 mb-3">Select Filter Type</label>
    <div class="grid grid-cols-2 gap-3">
        <button type="button" onclick="selectFilterType('ceremony')" 
                class="filter-type-option p-4 border-2 border-gray-200 rounded-xl text-center hover:border-purple-500 transition-all" data-type="ceremony">
            <i class="fas fa-certificate text-2xl text-purple-600 mb-2"></i>
            <p class="font-medium text-gray-900">Ceremony</p>
            <p class="text-xs text-gray-500">"I Attended the APN Ceremony!"</p>
        </button>
        
        <button type="button" onclick="selectFilterType('petition')" 
                class="filter-type-option p-4 border-2 border-gray-200 rounded-xl text-center hover:border-purple-500 transition-all" data-type="petition">
            <i class="fas fa-pen-fancy text-2xl text-indigo-600 mb-2"></i>
            <p class="font-medium text-gray-900">Petition</p>
            <p class="text-xs text-gray-500">"I Signed the MABN Petition!"</p>
        </button>
    </div>
</div>
        <!-- File Upload -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-3">Upload Your Image</label>
            <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-purple-500 transition-colors" id="dropZone">
                <input type="file" id="filterPhotoInput" accept="image/*" class="hidden" onchange="handleFileSelect(this)">
                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                <p class="text-gray-600 mb-2">Drag & drop your photo here or <button type="button" onclick="document.getElementById('filterPhotoInput').click()" class="text-purple-600 font-semibold hover:underline">browse</button></p>
                <p class="text-xs text-gray-500">Supports: JPG, PNG, JPEG (Max 2MB)</p>
            </div>

            <!-- Image Preview -->
            <div id="imagePreviewContainer" class="hidden mt-4">
                <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg">
                    <div class="flex items-center">
                        <img id="imagePreview" src="#" alt="Preview" class="w-12 h-12 object-cover rounded-lg mr-3">
                        <div>
                            <p id="imageFileName" class="font-medium text-gray-900">filename.jpg</p>
                            <p id="imageFileSize" class="text-xs text-gray-500">0 KB</p>
                        </div>
                    </div>
                    <button type="button" onclick="removeSelectedFile()" class="text-red-500 hover:text-red-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Error Container -->
        <div id="filterModalErrorContainer" class="mb-4"></div>

        <!-- Action Buttons -->
        <div class="flex gap-3">
            <button onclick="processFilterUpload()" 
                    id="processFilterBtn"
                    disabled
                    class="flex-1 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-xl font-urbanist font-bold hover:from-purple-700 hover:to-indigo-700 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                Apply Filter
            </button>
            <button onclick="closeFilterUploadModal()" 
                    class="flex-1 py-3 bg-gray-100 text-gray-700 rounded-xl font-urbanist font-bold hover:bg-gray-200 transition-all duration-300">
                Cancel
            </button>
        </div>
    </div>
</div>

<!-- Filter Result Modal-->
<div id="filterResultModal" class="modal-overlay">
    <div class="modal-container p-6 max-w-2xl">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-urbanist text-xl font-bold text-gray-900">Your Filtered Image is Ready!</h3>
            <button onclick="closeFilterResultModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Result Image -->
        <div class="text-center mb-6">
            <img id="filteredResultImage" src="#" alt="Filtered Result" class="max-w-full max-h-96 mx-auto rounded-lg shadow-lg">
        </div>

        <!-- Share Buttons -->
        <div class="mb-6">
            <p class="text-sm font-medium text-gray-700 mb-3 text-center">Share your achievement:</p>
            <div class="flex justify-center gap-3">
                <a href="#" id="linkedinShareFilter" target="_blank" class="w-12 h-12 bg-[#0077b5] text-white rounded-full flex items-center justify-center hover:scale-110 transition-transform">
                    <i class="fab fa-linkedin-in text-xl"></i>
                </a>
                <a href="#" id="twitterShareFilter" target="_blank" class="w-12 h-12 bg-[#1da1f2] text-white rounded-full flex items-center justify-center hover:scale-110 transition-transform">
                    <i class="fab fa-twitter text-xl"></i>
                </a>
                <a href="#" id="instagramShareFilter" target="_blank" class="w-12 h-12 bg-gradient-to-r from-purple-500 via-pink-500 to-orange-500 text-white rounded-full flex items-center justify-center hover:scale-110 transition-transform">
                    <i class="fab fa-instagram text-xl"></i>
                </a>
                <button onclick="downloadFilteredImage()" class="w-12 h-12 bg-green-600 text-white rounded-full flex items-center justify-center hover:scale-110 transition-transform">
                    <i class="fas fa-download"></i>
                </button>
            </div>
        </div>

        <!-- Close Button -->
        <button onclick="closeFilterResultModal()" class="w-full py-3 bg-gray-100 text-gray-700 rounded-xl font-urbanist font-bold hover:bg-gray-200 transition-all duration-300">
            Close
        </button>
    </div>
</div>

<!-- Logout Modal -->
<div x-data="{ showLogoutModal: false, isLoggingOut: false }" 
     @open-logout-modal.window="showLogoutModal = true"
     x-cloak>
    <div x-show="showLogoutModal" 
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">
        
        <div class="flex items-center justify-center min-h-screen px-4">
            <div x-show="showLogoutModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-black/40 backdrop-blur-sm"
                 @click="showLogoutModal = false">
            </div>
            <div x-show="showLogoutModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="relative bg-white rounded-2xl max-w-md w-full mx-auto shadow-2xl transform transition-all border border-gray-100">
                <div class="p-8 pt-10">
                    <div class="flex justify-center mb-4">
                        <div class="bg-gradient-to-br from-red-50 to-orange-50 rounded-2xl p-4">
                            <svg class="h-12 w-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </div>
                    </div>
                
                    <h3 class="text-xl font-bold text-center text-gray-900 mb-2">
                        Ready to logout?
                    </h3>
                    
                    <p class="text-gray-500 text-center mb-6 text-sm">
                        We'll miss you!<br>
                        Come back soon to see what's new.
                    </p>
                    
                    <div class="flex gap-3">
                        <button @click="showLogoutModal = false" 
                                :disabled="isLoggingOut"
                                class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all font-medium text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                            Cancel
                        </button>
                        
                        <form method="POST" action="{{ route('donor.logout') }}" 
                              @submit="isLoggingOut = true"
                              class="flex-1">
                            @csrf
                            <button type="submit" 
                                    :disabled="isLoggingOut"
                                    class="w-full px-4 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all font-medium text-sm shadow-md disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                                <template x-if="!isLoggingOut">
                                    <span>Logout</span>
                                </template>
                                <template x-if="isLoggingOut">
                                    <span class="flex items-center gap-2">
                                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Logging out...
                                    </span>
                                </template>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
    
    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(4px);
        z-index: 50;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    .modal-container {
        background: white;
        border-radius: 24px;
        max-width: 500px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        transform: translateY(20px);
        transition: all 0.3s ease;
    }
    .active .modal-container {
        transform: translateY(0);
    }
    .donation-option {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem;
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: center;
        font-weight: 600;
    }
    .donation-option:hover {
        border-color: #3b82f6;
        background: #f0f9ff;
    }
    .donation-option.selected {
        border-color: #3b82f6;
        background: #eff6ff;
    }
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin {
        animation: spin 1s linear infinite;
    }
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>

    let selectedFilterType = '';
let selectedFile = null;
  let selectedDonationAmount = 0;
let selectedDonationReason = '';

function selectDonationReason(reason) {
    // Remove selected class from all options
    document.querySelectorAll('.donation-reason-option').forEach(opt => {
        opt.classList.remove('selected');
    });
    
    // Add selected class to clicked option
    event.currentTarget.classList.add('selected');
    selectedDonationReason = reason;
    
    // Show/hide custom reason input
    const customContainer = document.getElementById('customReasonContainer');
    if (reason === 'other') {
        customContainer.classList.remove('hidden');
    } else {
        customContainer.classList.add('hidden');
        document.getElementById('customReason').value = '';
    }
    
    clearModalError();
}

let currentSlide = 0;
const slides = document.querySelectorAll('.carousel-slide');
const dots = document.querySelectorAll('.carousel-dot');
const thumbs = document.querySelectorAll('.carousel-thumb');
const totalSlides = slides.length;
const SLIDE_DURATION = 6000; // ms

// Update counter
const counterCurrent = document.getElementById('carouselCurrent');
const counterTotal = document.getElementById('carouselTotal');

if (counterTotal) counterTotal.textContent = String(totalSlides).padStart(2, '0');

function showSlide(index) {
    if (index < 0) index = totalSlides - 1;
    if (index >= totalSlides) index = 0;

    slides.forEach(s => {
        s.classList.remove('active');
        s.style.pointerEvents = 'none'; 
        const btn = s.querySelector('.carousel-button');
        if (btn) btn.setAttribute('tabindex', '-1'); 
    });
    
    dots.forEach(d => d.classList.remove('active'));
    thumbs.forEach(t => t.classList.remove('active'));

    // Activate the correct slide
    const activeSlide = slides[index];
    activeSlide.classList.add('active');
    activeSlide.style.pointerEvents = 'auto'; 

    const route = activeSlide.getAttribute('data-route');
    const btn = activeSlide.querySelector('.carousel-button');
    if (btn && route) {
        btn.setAttribute('href', route);
        btn.setAttribute('tabindex', '0');
    }

    if (dots[index]) dots[index].classList.add('active');
    if (thumbs[index]) thumbs[index].classList.add('active');

    if (counterCurrent) counterCurrent.textContent = String(index + 1).padStart(2, '0');

    currentSlide = index;
}

function nextSlide() { showSlide(currentSlide + 1); }
function prevSlide() { showSlide(currentSlide - 1); }
function goToSlide(i) { showSlide(i); }

const carouselContainer = document.querySelector('.carousel-container');
if (carouselContainer) {
    carouselContainer.addEventListener('click', function(e) {
        const btn = e.target.closest('.carousel-button');
        if (btn) {
            const route = btn.getAttribute('href');
            if (route) window.location.href = route;
        }
    });
}

// Wrap ALL carousel JS in a guard
const carouselEl = document.querySelector('.carousel-container');
if (carouselEl) {
    // Touch swipe
    let touchStartX = 0;
    carouselEl.addEventListener('touchstart', e => { touchStartX = e.changedTouches[0].screenX; }, { passive: true });
    carouselEl.addEventListener('touchend', e => {
        const diff = touchStartX - e.changedTouches[0].screenX;
        if (Math.abs(diff) > 50) diff > 0 ? nextSlide() : prevSlide();
    });
    showSlide(0);
} 

// ==================== TAB SWITCHING WITH PERSISTENCE ====================
function switchTab(tabName) {
    document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
    document.getElementById(`tab-${tabName}`).classList.add('active');
    document.getElementById(`content-${tabName}`).classList.add('active');
    
    // Save the active tab to sessionStorage
    sessionStorage.setItem('active_dashboard_tab', tabName);
    
    // Load resources if needed
    if (tabName === 'resources') {
        loadResources();
    }
}

// ==================== STORE RETURN TAB FOR EXTERNAL LINKS ====================
document.querySelectorAll('.news-card a[href*="news"]').forEach(link => {
    link.addEventListener('click', function() {
        sessionStorage.setItem('return_to_dashboard_tab', 'news');
    });
});

document.querySelectorAll('.event-card a[href*="events"]').forEach(link => {
    link.addEventListener('click', function() {
        sessionStorage.setItem('return_to_dashboard_tab', 'calendar');
    });
});

document.querySelectorAll('.job-card a[href*="jobs"]').forEach(link => {
    link.addEventListener('click', function() {
        sessionStorage.setItem('return_to_dashboard_tab', 'jobs');
    });
});

document.querySelectorAll('.game-card a[href*="quiz"], a[href*="wordsearch"], .games a').forEach(link => {
    link.addEventListener('click', function() {
        sessionStorage.setItem('return_to_dashboard_tab', 'games');
    });
});

document.querySelectorAll('[href*="resources"], [href*="publications"]').forEach(link => {
    link.addEventListener('click', function() {
        sessionStorage.setItem('return_to_dashboard_tab', 'resources');
    });
});

// ==================== PAGE INITIALIZATION ====================
document.addEventListener('DOMContentLoaded', function() {

    const returnTab = sessionStorage.getItem('return_to_dashboard_tab');
    if (returnTab) {
        switchTab(returnTab);
        sessionStorage.removeItem('return_to_dashboard_tab');
    } 
    else {
        const savedTab = sessionStorage.getItem('active_dashboard_tab');
        if (savedTab && document.getElementById(`tab-${savedTab}`)) {
            switchTab(savedTab);
        } else {
               const dashTab = document.getElementById('tab-dashboard');
    if (dashTab) switchTab('dashboard');
        }
    }
    

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('tab') === 'games') {
        switchTab('games');
    }
    
  const resourcesTab = document.getElementById('tab-resources');
if (resourcesTab && resourcesTab.classList.contains('active')) {
    loadResources();
}
});

// Add this to your existing JavaScript
document.addEventListener('DOMContentLoaded', function() {
    const linksToIntercept = [
        { selector: '.news-card a', tab: 'news' },
        { selector: '.event-card a', tab: 'calendar' },
        { selector: '.job-card a', tab: 'jobs' },
        { selector: '[href*="wordsearch"], [href*="quiz"]', tab: 'games' },
        { selector: '[href*="resources"], [href*="publications"]', tab: 'resources' }
    ];
    
    linksToIntercept.forEach(item => {
        document.querySelectorAll(item.selector).forEach(link => {
            link.addEventListener('click', function(e) {
                if (this.href.includes('#') || 
                    (this.href.includes('http') && !this.href.includes(window.location.hostname))) {
                    return;
                }
                
                e.preventDefault();
                sessionStorage.setItem('return_to_dashboard_tab', item.tab);
                window.location.href = this.href;
            });
        });
    });
});
// Save current tab when leaving the page
window.addEventListener('beforeunload', function() {
    const activeTab = document.querySelector('.tab-button.active');
    if (activeTab) {
        const tabId = activeTab.id.replace('tab-', '');
        sessionStorage.setItem('active_dashboard_tab', tabId);
    }
});

// ==================== MODAL FUNCTIONS ====================
function openDonationModal() {
    document.getElementById('donationModal').classList.add('active');
    document.body.style.overflow = 'hidden';
    clearModalError();
}

function closeDonationModal() {
    document.getElementById('donationModal').classList.remove('active');
    document.body.style.overflow = '';
    
    document.querySelectorAll('.donation-option, .donation-reason-option').forEach(opt => {
        opt.classList.remove('selected');
    });
    
    document.getElementById('donationAmount').value = '';
    document.getElementById('customReasonContainer').classList.add('hidden');
    document.getElementById('customReason').value = '';
    
    selectedDonationAmount = 0;
    selectedDonationReason = '';
    clearModalError();
}

function clearModalError() {
    const container = document.getElementById('modalErrorContainer');
    if (container) container.innerHTML = '';
}

function showModalError(message) {
    const errorHtml = `
        <div class="bg-red-50 border-2 border-red-200 rounded-xl p-4 mb-4 flex items-center gap-3 text-red-600 text-sm">
            <i class="fas fa-exclamation-circle"></i>
            <span>${message}</span>
            <button onclick="this.parentElement.remove()" class="ml-auto hover:opacity-70">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    document.getElementById('modalErrorContainer').innerHTML = errorHtml;
}

function setDonationAmount(amount) {
    document.querySelectorAll('.donation-option').forEach(opt => opt.classList.remove('selected'));
    event.target.classList.add('selected');
    document.getElementById('donationAmount').value = amount;
    selectedDonationAmount = amount;
    clearModalError();
}

// ==================== RESOURCES FUNCTIONS ====================
function loadResources() {
    const loadingEl = document.getElementById('resourcesLoading');
    const magazinesList = document.getElementById('magazinesList');
    const reportsList = document.getElementById('reportsList');
    const newslettersList = document.getElementById('newslettersList');
    const emptyState = document.getElementById('resourcesEmptyState');
    
    if (!loadingEl) return;
    
    loadingEl.classList.remove('hidden');
    
    fetch('/member/publications', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        loadingEl.classList.add('hidden');
        
        if (data.success) {
            let hasContent = false;
            
            // Magazines
            if (data.publications.magazine && data.publications.magazine.length > 0) {
                renderResourceItems('magazinesList', data.publications.magazine);
                hasContent = true;
            }
            
            // Reports
            if (data.publications.report && data.publications.report.length > 0) {
                renderResourceItems('reportsList', data.publications.report);
                hasContent = true;
            }
            
            // Newsletters
            if (data.publications.newsletter && data.publications.newsletter.length > 0) {
                renderResourceItems('newslettersList', data.publications.newsletter);
                hasContent = true;
            }
            
            if (!hasContent) {
                emptyState.classList.remove('hidden');
            } else {
                emptyState.classList.add('hidden');
            }
        } else {
            emptyState.classList.remove('hidden');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        loadingEl.classList.add('hidden');
        emptyState.classList.remove('hidden');
    });
}

function renderResourceItems(listId, items) {
    const list = document.getElementById(listId);
    let html = '';
    
    // Update count badge
    const countId = listId.replace('List', 'Count');
    const countEl = document.getElementById(countId);
    if (countEl) {
        countEl.textContent = `${items.length} item${items.length !== 1 ? 's' : ''}`;
    }
    
    items.forEach(item => {
        const fileExtension = item.file_path.split('.').pop().toLowerCase();
        
        let fileIcon = 'fa-file-pdf';
        let fileColor = 'text-red-500';
        
        if (fileExtension === 'doc' || fileExtension === 'docx') {
            fileIcon = 'fa-file-word';
            fileColor = 'text-blue-600';
        } else if (fileExtension === 'xls' || fileExtension === 'xlsx') {
            fileIcon = 'fa-file-excel';
            fileColor = 'text-green-600';
        } else if (fileExtension === 'ppt' || fileExtension === 'pptx') {
            fileIcon = 'fa-file-powerpoint';
            fileColor = 'text-orange-600';
        } else if (fileExtension === 'txt') {
            fileIcon = 'fa-file-alt';
            fileColor = 'text-gray-600';
        } else if (fileExtension === 'jpg' || fileExtension === 'jpeg' || fileExtension === 'png' || fileExtension === 'gif') {
            fileIcon = 'fa-file-image';
            fileColor = 'text-purple-600';
        }
        
        html += `
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors mb-2">
                <div class="flex items-center flex-1 min-w-0">
                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center mr-3 shadow-sm flex-shrink-0">
                        <i class="fas ${fileIcon} ${fileColor} text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h5 class="font-medium text-gray-900 text-sm truncate">${item.title}</h5>
                            <span class="px-1.5 py-0.5 bg-gray-200 text-gray-700 text-xs rounded-full uppercase flex-shrink-0">
                                ${fileExtension}
                            </span>
                        </div>
                    </div>
                </div>
                <a href="/member/download/${item.id}" 
                   class="ml-2 inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-xs font-medium shadow-sm flex-shrink-0">
                    <i class="fas fa-download mr-1"></i> Download
                </a>
            </div>
        `;
    });
    
    list.innerHTML = html;
}

// ==================== DONATION PROCESSING ====================
async function processDonation() {
    clearModalError();
    
    if (!selectedDonationReason) {
        showModalError('Please select a donation purpose');
        return;
    }
    
    const amount = document.getElementById('donationAmount').value;
    if (!amount || amount < 1) {
        showModalError('Please enter a valid donation amount');
        return;
    }
    
    let customReason = '';
    if (selectedDonationReason === 'other') {
        customReason = document.getElementById('customReason').value.trim();
    }
    
    const btn = event.target.closest('button');
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';

    try {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                     document.querySelector('input[name="_token"]')?.value;
        
        if (!token) {
            throw new Error('Security token not found. Please refresh the page.');
        }

        const response = await fetch('{{ route("donation.initialize") }}', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json', 
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                amount: amount,
                donation_reason: selectedDonationReason,
                custom_reason: customReason,
                membership_type: 'donation'
            })
        });
        
        const contentType = response.headers.get('content-type');
        
        if (!response.ok) {
            if (contentType && contentType.includes('application/json')) {
                const errorData = await response.json();
                throw new Error(errorData.message || `Server error: ${response.status}`);
            } else {
                const errorText = await response.text();
                console.error('HTML error response:', errorText.substring(0, 200));
                
                if (errorText.includes('login') || response.url.includes('login')) {
                    throw new Error('Your session has expired. Please refresh the page and login again.');
                }
                
                throw new Error(`Server error (${response.status}). Please try again.`);
            }
        }
        
        if (!contentType || !contentType.includes('application/json')) {
            const text = await response.text();
            console.error('Non-JSON response:', text.substring(0, 200));
            throw new Error('Invalid response from server. Please try again.');
        }
        
        const data = await response.json();
        
        console.log('Donation response:', data);
        
        if (data.status === true && data.data?.authorization_url) {
            window.location.href = data.data.authorization_url;
        } else {
            throw new Error(data.message || 'Failed to process donation');
        }
        
    } catch (error) {
        console.error('Donation error:', error);
        btn.disabled = false;
        btn.innerHTML = originalText;
        showModalError(error.message || 'Failed to process donation. Please try again.');
    }
}

// ==================== FILTER UPLOAD FUNCTIONS ====================


function openFilterUploadModal() {
    document.getElementById('filterUploadModal').classList.add('active');
    document.body.style.overflow = 'hidden';
    resetFilterModal();
}

function closeFilterUploadModal() {
    document.getElementById('filterUploadModal').classList.remove('active');
    document.body.style.overflow = '';
    resetFilterModal();
}

function closeFilterResultModal() {
    document.getElementById('filterResultModal').classList.remove('active');
    document.body.style.overflow = '';
}

function resetFilterModal() {
    selectedFilterType = '';
    selectedFile = null;
    document.querySelectorAll('.filter-type-option').forEach(opt => {
        opt.classList.remove('selected', 'border-purple-500', 'bg-purple-50');
    });
    document.getElementById('filterPhotoInput').value = '';
    document.getElementById('imagePreviewContainer').classList.add('hidden');
    document.getElementById('processFilterBtn').disabled = true;
    document.getElementById('filterModalErrorContainer').innerHTML = '';
}

function selectFilterType(type) {
    document.querySelectorAll('.filter-type-option').forEach(opt => {
        opt.classList.remove('selected', 'border-purple-500', 'bg-purple-50');
        if (opt.dataset.type === type) {
            opt.classList.add('selected', 'border-purple-500', 'bg-purple-50');
        }
    });
    selectedFilterType = type;
    checkFilterFormComplete();
}

function handleFileSelect(input) {
    const file = input.files[0];
    if (file) {
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!validTypes.includes(file.type)) {
            showFilterError('Please select a valid image file (JPG or PNG)');
            return;
        }
        
        if (file.size > 5 * 1024 * 1024) {
            showFilterError('File size must be less than 2MB');
            return;
        }
        
        selectedFile = file;
        
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagePreview').src = e.target.result;
            document.getElementById('imageFileName').textContent = file.name;
            document.getElementById('imageFileSize').textContent = (file.size / 1024).toFixed(2) + ' KB';
            document.getElementById('imagePreviewContainer').classList.remove('hidden');
        }
        reader.readAsDataURL(file);
        
        checkFilterFormComplete();
    }
}

function removeSelectedFile() {
    selectedFile = null;
    document.getElementById('filterPhotoInput').value = '';
    document.getElementById('imagePreviewContainer').classList.add('hidden');
    document.getElementById('processFilterBtn').disabled = true;
}

function checkFilterFormComplete() {
    const btn = document.getElementById('processFilterBtn');
    btn.disabled = !(selectedFilterType && selectedFile);
}

function showFilterError(message) {
    const errorHtml = `
        <div class="bg-red-50 border-2 border-red-200 rounded-xl p-4 flex items-center gap-3 text-red-600 text-sm">
            <i class="fas fa-exclamation-circle"></i>
            <span>${message}</span>
            <button onclick="this.parentElement.remove()" class="ml-auto hover:opacity-70">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    document.getElementById('filterModalErrorContainer').innerHTML = errorHtml;
}

async function processFilterUpload() {
    
    if (!selectedFile) {
        showFilterError('Please upload a photo');
        return;
    }
    
    const btn = document.getElementById('processFilterBtn');
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
    
    const formData = new FormData();
    formData.append('user_photo', selectedFile);
    formData.append('filter_type', 'petition');
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    
    try {
        const response = await fetch('{{ route("filter.apply") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            closeFilterUploadModal();
            document.getElementById('filteredResultImage').src = data.image_url;

            if (data.share_links) {
                document.getElementById('linkedinShareFilter').href = data.share_links.linkedin;
                document.getElementById('twitterShareFilter').href = data.share_links.twitter;
                document.getElementById('instagramShareFilter').href = data.share_links.facebook;
            }
            
            window.filteredImageUrl = data.image_url;
            document.getElementById('filterResultModal').classList.add('active');
        } else {
            showFilterError(data.message || 'Failed to process image');
        }
    } catch (error) {
        console.error('Error:', error);
        showFilterError('Failed to process image. Please try again.');
    } finally {
        btn.disabled = false;
        btn.innerHTML = originalText;
    }
}

function downloadFilteredImage() {
    if (window.filteredImageUrl) {
        const link = document.createElement('a');
        link.download = 'filtered-photo.png';
        link.href = window.filteredImageUrl;
        link.click();
    }
}

// ==================== DRAG AND DROP ====================
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('dropZone');
    if (dropZone) {
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('border-purple-500', 'bg-purple-50');
        });
        
        dropZone.addEventListener('dragleave', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-purple-500', 'bg-purple-50');
        });
        
        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-purple-500', 'bg-purple-50');
            
            const file = e.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                document.getElementById('filterPhotoInput').files = e.dataTransfer.files;
                handleFileSelect(document.getElementById('filterPhotoInput'));
            } else {
                showFilterError('Please drop a valid image file');
            }
        });
    }
});

// ==================== RECEIPT DOWNLOADS ====================
function downloadDonationReceipt(transactionId, amount, date, paymentMethod) {
    const button = event.target;
    const originalText = button.textContent;
    button.innerHTML = '<svg class="animate-spin h-4 w-4 mr-2 inline" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Generating...';
    button.disabled = true;

    setTimeout(() => {
        const receiptDate = new Date(date);
        const formattedDate = receiptDate.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
        const receiptHTML = `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Donation Receipt</title>
                <style>
                    body { font-family: 'Open Sans', sans-serif; max-width: 600px; margin: 0 auto; padding: 30px; background: #f9fafb; }
                    h1, h2, h3, h4, h5, h6 { font-family: 'Urbanist', sans-serif; }
                    .receipt-container { background: white; border-radius: 12px; padding: 30px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
                    .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #e5e7eb; padding-bottom: 20px; }
                    .logo { font-size: 24px; font-weight: bold; color: #4f46e5; font-family: 'Urbanist', sans-serif; }
                    .receipt-title { font-size: 20px; margin-top: 10px; color: #1f2937; font-family: 'Urbanist', sans-serif; }
                    .details { margin: 20px 0; }
                    .row { display: flex; justify-content: space-between; margin-bottom: 12px; padding: 8px 0; border-bottom: 1px dashed #e5e7eb; }
                    .label { font-weight: 600; color: #4b5563; font-family: 'Urbanist', sans-serif; }
                    .value { color: #1f2937; }
                    .amount { font-size: 24px; font-weight: bold; color: #059669; text-align: center; margin: 20px 0; font-family: 'Urbanist', sans-serif; }
                    .footer { margin-top: 30px; text-align: center; color: #6b7280; font-size: 14px; border-top: 2px solid #e5e7eb; padding-top: 20px; }
                    .thank-you { font-size: 18px; color: #4f46e5; margin-bottom: 10px; font-family: 'Urbanist', sans-serif; }
                </style>
            </head>
            <body>
                <div class="receipt-container">
                    <div class="header">
                        <div class="logo">Africa Prosperity Network</div>
                        <div class="receipt-title">Donation Receipt</div>
                    </div>
                    <div class="amount">$${parseFloat(amount).toFixed(2)}</div>
                    <div class="details">
                        <div class="row"><span class="label">Transaction ID:</span><span class="value">${transactionId}</span></div>
                        <div class="row"><span class="label">Date:</span><span class="value">${formattedDate}</span></div>
                        <div class="row"><span class="label">Donor Name:</span><span class="value">{{ $donor->firstname }} {{ $donor->lastname }}</span></div>
                        <div class="row"><span class="label">Donor Email:</span><span class="value">{{ $donor->email }}</span></div>
                        <div class="row"><span class="label">Payment Method:</span><span class="value">${paymentMethod.charAt(0).toUpperCase() + paymentMethod.slice(1)}</span></div>
                        <div class="row"><span class="label">Status:</span><span class="value" style="color: #059669;">Success</span></div>
                    </div>
                    <div class="footer">
                        <div class="thank-you">Thank you for your generous support!</div>
                        <p>This is a computer-generated receipt. No signature required.</p>
                    </div>
                </div>
            </body>
            </html>
        `;
        const blob = new Blob([receiptHTML], { type: 'text/html' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `donation-receipt-${transactionId}.html`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);

        button.innerHTML = originalText;
        button.disabled = false;
    }, 1000);
}

function downloadReceipt(transactionId, amount, date, paymentMethod) {
    const button = event.target;
    const originalText = button.textContent;
    button.innerHTML = '<svg class="animate-spin h-4 w-4 mr-2 inline" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Generating...';
    button.disabled = true;

    setTimeout(() => {
        const receiptDate = new Date(date);
        const formattedDate = receiptDate.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
        const receiptHTML = `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Payment Receipt</title>
                <style>
                    body { font-family: 'Open Sans', sans-serif; max-width: 600px; margin: 0 auto; padding: 30px; background: #f9fafb; }
                    h1, h2, h3, h4, h5, h6 { font-family: 'Urbanist', sans-serif; }
                    .receipt-container { background: white; border-radius: 12px; padding: 30px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
                    .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #e5e7eb; padding-bottom: 20px; }
                    .logo { font-size: 24px; font-weight: bold; color: #4f46e5; font-family: 'Urbanist', sans-serif; }
                    .receipt-title { font-size: 20px; margin-top: 10px; color: #1f2937; font-family: 'Urbanist', sans-serif; }
                    .details { margin: 20px 0; }
                    .row { display: flex; justify-content: space-between; margin-bottom: 12px; padding: 8px 0; border-bottom: 1px dashed #e5e7eb; }
                    .label { font-weight: 600; color: #4b5563; font-family: 'Urbanist', sans-serif; }
                    .value { color: #1f2937; }
                    .amount { font-size: 24px; font-weight: bold; color: #059669; text-align: center; margin: 20px 0; font-family: 'Urbanist', sans-serif; }
                    .footer { margin-top: 30px; text-align: center; color: #6b7280; font-size: 14px; border-top: 2px solid #e5e7eb; padding-top: 20px; }
                    .thank-you { font-size: 18px; color: #4f46e5; margin-bottom: 10px; font-family: 'Urbanist', sans-serif; }
                </style>
            </head>
            <body>
                <div class="receipt-container">
                    <div class="header">
                        <div class="logo">Africa Prosperity Network</div>
                        <div class="receipt-title">Payment Receipt</div>
                    </div>
                    <div class="amount">$${parseFloat(amount).toFixed(2)}</div>
                    <div class="details">
                        <div class="row"><span class="label">Transaction ID:</span><span class="value">${transactionId}</span></div>
                        <div class="row"><span class="label">Date:</span><span class="value">${formattedDate}</span></div>
                        <div class="row"><span class="label">Donor Name:</span><span class="value">{{ $donor->firstname }} {{ $donor->lastname }}</span></div>
                        <div class="row"><span class="label">Donor Email:</span><span class="value">{{ $donor->email }}</span></div>
                        <div class="row"><span class="label">Payment Method:</span><span class="value">${paymentMethod.charAt(0).toUpperCase() + paymentMethod.slice(1)}</span></div>
                        <div class="row"><span class="label">Status:</span><span class="value" style="color: #059669;">Success</span></div>
                    </div>
                    <div class="footer">
                        <div class="thank-you">Thank you for your support!</div>
                        <p>This is a computer-generated receipt. No signature required.</p>
                    </div>
                </div>
            </body>
            </html>
        `;
        const blob = new Blob([receiptHTML], { type: 'text/html' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `receipt-${transactionId}.html`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);

        button.innerHTML = originalText;
        button.disabled = false;
    }, 1000);
}

// ==================== MODAL CLOSE ON CLICK OUTSIDE ====================
document.getElementById('donationModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeDonationModal();
    }
});

// ==================== CSRF TOKEN ====================
if (!document.querySelector('meta[name="csrf-token"]')) {
    const meta = document.createElement('meta');
    meta.name = 'csrf-token';
    meta.content = '{{ csrf_token() }}';
    document.head.appendChild(meta);
}

// ==================== LIBRARY FUNCTIONS ====================
function openLibraryModal() {
    document.getElementById('libraryModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    document.getElementById('libraryLoading').classList.remove('hidden');
    document.getElementById('libraryContent').classList.add('hidden');
    fetchPublications();
}

function closeLibraryModal() {
    document.getElementById('libraryModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function fetchPublications() {
    fetch('/member/publications', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            renderPublications(data.publications);
        } else {
            showEmptyState();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showEmptyState();
    })
    .finally(() => {
        document.getElementById('libraryLoading').classList.add('hidden');
        document.getElementById('libraryContent').classList.remove('hidden');
    });
}

function renderPublications(publications) {
    let hasContent = false;
    document.getElementById('magazinesList').innerHTML = '';
    document.getElementById('reportsList').innerHTML = '';
    document.getElementById('newslettersList').innerHTML = '';
    
    if (publications.magazine && publications.magazine.length > 0) {
        renderItems('magazinesList', publications.magazine, 'Magazines');
        hasContent = true;
    }
    if (publications.report && publications.report.length > 0) {
        renderItems('reportsList', publications.report, 'Special Reports');
        hasContent = true;
    }
    if (publications.newsletter && publications.newsletter.length > 0) {
        renderItems('newslettersList', publications.newsletter, 'Newsletters');
        hasContent = true;
    }
    if (!hasContent) {
        document.getElementById('emptyState').classList.remove('hidden');
    } else {
        document.getElementById('emptyState').classList.add('hidden');
    }
}

function renderItems(listId, items, sectionTitle) {
    const list = document.getElementById(listId);
    let html = '';
    if (items.length > 0) {
        html += `<h4 class="text-lg font-semibold text-gray-800 mb-3">${sectionTitle}</h4>`;
    }
    
    items.forEach(item => {
        const fileExtension = item.file_path.split('.').pop().toLowerCase();
        let fileIcon = 'fa-file-pdf';
        let fileColor = 'text-red-500';
        
        if (fileExtension === 'doc' || fileExtension === 'docx') {
            fileIcon = 'fa-file-word';
            fileColor = 'text-blue-600';
        } else if (fileExtension === 'xls' || fileExtension === 'xlsx') {
            fileIcon = 'fa-file-excel';
            fileColor = 'text-green-600';
        } else if (fileExtension === 'ppt' || fileExtension === 'pptx') {
            fileIcon = 'fa-file-powerpoint';
            fileColor = 'text-orange-600';
        } else if (fileExtension === 'txt') {
            fileIcon = 'fa-file-alt';
            fileColor = 'text-gray-600';
        } else if (fileExtension === 'jpg' || fileExtension === 'jpeg' || fileExtension === 'png' || fileExtension === 'gif') {
            fileIcon = 'fa-file-image';
            fileColor = 'text-purple-600';
        }
        
        html += `
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors mb-2">
                <div class="flex items-center flex-1">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center mr-3 shadow-sm">
                        <i class="fas ${fileIcon} ${fileColor}"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <h5 class="font-medium text-gray-900">${item.title}</h5>
                            <span class="px-2 py-0.5 bg-gray-200 text-gray-700 text-xs rounded-full uppercase">
                                ${fileExtension}
                            </span>
                        </div>
                    </div>
                </div>
                <a href="/member/download/${item.id}" 
                   class="ml-4 inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm font-medium shadow-sm">
                    <i class="fas fa-download mr-2"></i> Download
                </a>
            </div>
        `;
    });
    
    list.innerHTML = html;
}

function showEmptyState() {
    document.getElementById('emptyState').classList.remove('hidden');
    document.getElementById('magazinesList').innerHTML = '';
    document.getElementById('reportsList').innerHTML = '';
    document.getElementById('newslettersList').innerHTML = '';
}
</script>
@endpush
@endsection