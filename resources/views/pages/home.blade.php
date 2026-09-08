@extends('layouts.app')

@section('title', 'Malfaur Engineering Products — Precision Engineering Supplier, UK')
@section('meta_description', 'Malfaur Engineering Products supplies precision-engineered components, industrial fasteners, hydraulic systems, bearings and measurement tools to professional customers across the United Kingdom.')

@section('content')

@php
    $hero = \App\Models\PageContent::getSection('home', 'hero');
    $heroTitle = $hero['title'] ?? 'Engineering Products Built for Precision and Performance';
    $heroSubtitle = $hero['subtitle'] ?? 'Malfaur Engineering Products supplies quality-assured engineering components and industrial products to professional customers throughout the United Kingdom. Reliability you can depend on.';
    $heroBadge = $hero['meta_data']['badge'] ?? 'Established Engineering Supplier · United Kingdom';
    $heroBtn1 = $hero['meta_data']['primary_btn_text'] ?? 'Explore Products';
    $heroBtn2 = $hero['meta_data']['secondary_btn_text'] ?? 'Contact Us';
    $heroImg = $hero['image'] ?? 'images/hero-engineering.png';
    if (!str_starts_with($heroImg, 'http') && !str_starts_with($heroImg, 'images/')) {
        $heroImg = 'images/' . $heroImg;
    }
@endphp

{{-- ═══════════════════════════════════════
     HERO
═══════════════════════════════════════ --}}
<section class="hero" aria-label="Hero section">
    <div class="hero-content">
        <div class="container-half">
            <span class="hero-eyebrow">{{ $heroBadge }}</span>

            <h1 class="display-1">
                {{ $heroTitle }}
            </h1>

            <p class="hero-desc">
                {{ $heroSubtitle }}
            </p>

            <div class="hero-actions">
                <a href="{{ route('products') }}" class="btn btn-primary btn-lg" id="hero-explore-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                    {{ $heroBtn1 }}
                </a>
                <a href="{{ route('contact') }}" class="btn btn-secondary btn-lg" id="hero-contact-btn">
                    {{ $heroBtn2 }}
                </a>
            </div>

            <div class="hero-stats">
                <div>
                    <div class="hero-stat-num">25<span>+</span></div>
                    <div class="hero-stat-label">Years Experience</div>
                </div>
                <div>
                    <div class="hero-stat-num">500<span>+</span></div>
                    <div class="hero-stat-label">Products Stocked</div>
                </div>
                <div>
                    <div class="hero-stat-num">UK<span>&#x2714;</span></div>
                    <div class="hero-stat-label">Based &amp; Operated</div>
                </div>
            </div>
        </div>
    </div>

    <div class="hero-image-col" aria-hidden="true">
        <img src="{{ asset($heroImg) }}" alt="Precision engineering components" loading="eager" onerror="this.src='{{ asset('images/hero-engineering.png') }}'">
    </div>
</section>

{{-- ═══════════════════════════════════════
     TRUST BAR
═══════════════════════════════════════ --}}
<div class="trust-bar" aria-label="Trust indicators">
    <div class="container">
        <div class="trust-bar-inner">
            <div class="trust-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                Quality Assured Products
            </div>
            <div class="trust-divider" aria-hidden="true"></div>
            <div class="trust-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                UK-Based Supplier
            </div>
            <div class="trust-divider" aria-hidden="true"></div>
            <div class="trust-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                Fast, Reliable Delivery
            </div>
            <div class="trust-divider" aria-hidden="true"></div>
            <div class="trust-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                Dedicated Technical Support
            </div>
            <div class="trust-divider" aria-hidden="true"></div>
            <div class="trust-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                Industrial &amp; Trade Supply
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════
     COMPANY INTRODUCTION
═══════════════════════════════════════ --}}
<section class="section-pad" aria-labelledby="intro-heading">
    <div class="container">
        <div class="intro-grid">
            <div class="intro-image fade-up">
                <img src="{{ asset('images/company-workshop.png') }}" alt="Malfaur Engineering facility" loading="lazy">
                <div class="intro-badge">
                    <div class="intro-badge-num">25+</div>
                    <div class="intro-badge-label">Years of engineering expertise</div>
                </div>
            </div>

            <div class="intro-content fade-up fade-up-delay-2">
                <span class="section-label">About Malfaur</span>
                <h2 class="heading-1" id="intro-heading">A Trusted Name in UK Engineering Supply</h2>
                <span class="divider-accent"></span>
                <p class="body-lg" style="color:var(--text-secondary);margin-bottom:1rem;">
                    Malfaur Engineering Products has built its reputation on supplying high-quality, precision-engineered components to professional customers across the United Kingdom.
                </p>
                <p style="color:var(--text-secondary);line-height:1.8;margin-bottom:1rem;">
                    From bearings and hydraulic fittings to industrial fasteners and precision measurement tools, our catalogue covers the demanding requirements of modern manufacturing, maintenance, and industrial operations.
                </p>
                <p style="color:var(--text-secondary);line-height:1.8;">
                    We understand that engineering professionals require products they can rely on — every time, without compromise. That commitment to quality is embedded in everything we do.
                </p>

                <div class="intro-pillars">
                    <div class="intro-pillar">
                        <div class="intro-pillar-label">Quality</div>
                        <div class="intro-pillar-text">Products sourced and verified to exacting standards</div>
                    </div>
                    <div class="intro-pillar">
                        <div class="intro-pillar-label">Precision</div>
                        <div class="intro-pillar-text">Engineered components for demanding applications</div>
                    </div>
                    <div class="intro-pillar">
                        <div class="intro-pillar-label">Reliability</div>
                        <div class="intro-pillar-text">Consistent supply with professional service</div>
                    </div>
                    <div class="intro-pillar">
                        <div class="intro-pillar-label">UK Based</div>
                        <div class="intro-pillar-text">British-operated, understanding UK requirements</div>
                    </div>
                </div>

                <div style="margin-top:2rem;">
                    <a href="{{ route('about') }}" class="btn btn-outline" id="learn-more-btn">
                        Learn More About Us
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════
     FEATURED PRODUCTS
═══════════════════════════════════════ --}}
<section class="section-pad products-bg" aria-labelledby="products-heading">
    <div class="container">
        <div class="section-header">
            <div class="section-header-row">
                <div>
                    <span class="section-label fade-up">Our Products</span>
                    <h2 class="heading-1 fade-up fade-up-delay-1" id="products-heading">Featured Engineering Products</h2>
                    <span class="divider-accent"></span>
                    <p class="fade-up fade-up-delay-2" style="color:var(--text-secondary);max-width:520px;margin-top:0.5rem;">
                        A selection from our range of precision-engineered components available for professional and industrial applications.
                    </p>
                </div>
                <a href="{{ route('products') }}" class="btn btn-accent-outline fade-up fade-up-delay-3" id="view-catalogue-btn" style="flex-shrink:0;">
                    View Full Catalogue
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>

        <div class="product-grid">

            {{-- Product 1 --}}
            <article class="product-card fade-up"
                data-category="Bearings &amp; Bushings"
                data-name="Precision Ball Bearings"
                data-desc="High-grade steel ball bearings manufactured to exacting tolerances for demanding rotary applications. Available in a comprehensive range of sizes and load ratings."
                data-img="{{ asset('images/product-bearings.png') }}"
                data-specs='[["Type","Deep Groove Ball Bearing"],["Material","52100 Chrome Steel"],["Tolerance","ISO P5 / P6"],["Lubrication","Grease / Open"],["Standard","DIN 625"]]'>
                <div class="product-card-image">
                    <img src="{{ asset('images/product-bearings.png') }}" alt="Precision Ball Bearings" loading="lazy">
                </div>
                <div class="product-card-body">
                    <span class="product-card-category-tag">Bearings</span>
                    <h3 class="product-card-name">Precision Ball Bearings</h3>
                    <p class="product-card-desc">High-grade steel ball bearings manufactured to exacting tolerances for demanding rotary and load-bearing applications.</p>
                    <div class="product-card-footer">
                        <span class="caption text-muted">Deep Groove / Chrome Steel</span>
                        <button class="btn btn-sm btn-accent-outline js-view-product" id="view-product-1">View Details</button>
                    </div>
                </div>
            </article>

            {{-- Product 2 --}}
            <article class="product-card fade-up fade-up-delay-1"
                data-category="Hydraulic Components"
                data-name="Hydraulic Fittings &amp; Connectors"
                data-desc="Professional-grade hydraulic fittings and connectors engineered for high-pressure fluid systems. Manufactured from chrome-plated steel and brass for long service life."
                data-img="{{ asset('images/product-hydraulics.png') }}"
                data-specs='[["Pressure Rating","Up to 400 Bar"],["Material","Steel / Brass"],["Thread","BSP / Metric / JIC"],["Seal Type","O-Ring / Cone"],["Standard","ISO 8434"]]'>
                <div class="product-card-image">
                    <img src="{{ asset('images/product-hydraulics.png') }}" alt="Hydraulic Fittings" loading="lazy">
                </div>
                <div class="product-card-body">
                    <span class="product-card-category-tag">Hydraulics</span>
                    <h3 class="product-card-name">Hydraulic Fittings &amp; Connectors</h3>
                    <p class="product-card-desc">High-pressure rated hydraulic fittings and connectors for professional fluid power systems and industrial machinery.</p>
                    <div class="product-card-footer">
                        <span class="caption text-muted">Up to 400 Bar · BSP / Metric</span>
                        <button class="btn btn-sm btn-accent-outline js-view-product" id="view-product-2">View Details</button>
                    </div>
                </div>
            </article>

            {{-- Product 3 --}}
            <article class="product-card fade-up fade-up-delay-2"
                data-category="Fasteners &amp; Fixings"
                data-name="Industrial Grade Fasteners"
                data-desc="Full range of industrial fasteners including bolts, nuts, washers and thread-forming screws. Available in stainless steel, high-tensile and zinc-plated finishes."
                data-img="{{ asset('images/product-fasteners.png') }}"
                data-specs='[["Grade","8.8 / 10.9 / A2 / A4"],["Material","Steel / Stainless Steel"],["Finish","Zinc / HDG / Plain"],["Thread","Metric / UNC / UNF"],["Standard","DIN / ISO / BS"]]'>
                <div class="product-card-image">
                    <img src="{{ asset('images/product-fasteners.png') }}" alt="Industrial Fasteners" loading="lazy">
                </div>
                <div class="product-card-body">
                    <span class="product-card-category-tag">Fasteners</span>
                    <h3 class="product-card-name">Industrial Grade Fasteners</h3>
                    <p class="product-card-desc">Comprehensive fastener range including high-tensile bolts, nuts, washers and fixings for structural and engineering applications.</p>
                    <div class="product-card-footer">
                        <span class="caption text-muted">Grade 8.8–10.9 · Metric / Imperial</span>
                        <button class="btn btn-sm btn-accent-outline js-view-product" id="view-product-3">View Details</button>
                    </div>
                </div>
            </article>

        </div>

        <div style="text-align:center;margin-top:3rem;">
            <a href="{{ route('products') }}" class="btn btn-primary btn-lg" id="browse-all-btn">
                Browse Full Product Catalogue
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════
     WHY CHOOSE MALFAUR
═══════════════════════════════════════ --}}
<section class="section-pad" aria-labelledby="why-heading">
    <div class="container">
        <div style="text-align:center;margin-bottom:3rem;">
            <span class="section-label fade-up" style="justify-content:center;">Why Choose Us</span>
            <h2 class="heading-1 fade-up fade-up-delay-1" id="why-heading" style="margin-bottom:0.75rem;">The Malfaur Difference</h2>
            <p class="fade-up fade-up-delay-2" style="color:var(--text-secondary);max-width:520px;margin:0 auto;">
                Engineering professionals choose Malfaur for our uncompromising approach to product quality, technical knowledge, and dependable service.
            </p>
        </div>

        <div class="features-grid">
            <div class="feature-card fade-up">
                <div class="feature-icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="feature-title">Engineering Quality</h3>
                <p class="feature-desc">Every product in our catalogue is selected to meet the exacting standards demanded by professional engineering and manufacturing environments.</p>
            </div>

            <div class="feature-card fade-up fade-up-delay-1">
                <div class="feature-icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 class="feature-title">Precision Components</h3>
                <p class="feature-desc">Our range includes precision-manufactured components with tight tolerances, appropriate for use in critical engineering applications.</p>
            </div>

            <div class="feature-card fade-up fade-up-delay-2">
                <div class="feature-icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="feature-title">Reliable Supply</h3>
                <p class="feature-desc">Consistency matters in engineering. We maintain strong supplier relationships to ensure dependable product availability when you need it most.</p>
            </div>

            <div class="feature-card fade-up fade-up-delay-3">
                <div class="feature-icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="feature-title">UK Technical Support</h3>
                <p class="feature-desc">Our UK-based team understands British engineering standards and requirements, providing informed technical support and product guidance.</p>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════
     QUALITY SECTION
═══════════════════════════════════════ --}}
<section class="quality-section" aria-labelledby="quality-heading">
    <div class="quality-grid">
        <div class="quality-image" aria-hidden="true">
            <img src="{{ asset('images/quality-section.png') }}" alt="Precision engineering manufacturing" loading="lazy">
        </div>
        <div class="quality-content">
            <span class="section-label">Our Standard</span>
            <h2 class="display-2" id="quality-heading">Precision.<br>Reliability.<br>Engineering Excellence.</h2>
            <p>
                In engineering, there is no margin for compromise. Malfaur Engineering Products holds itself to the same standards as the industries it serves — technical credibility, product consistency, and dependable performance.
            </p>
            <p>
                Every product we supply is selected and verified against professional engineering requirements. We don't stock generic products — we stock engineering products.
            </p>
            <ul class="quality-list">
                <li class="quality-list-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Products verified against industry standards
                </li>
                <li class="quality-list-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Trusted by UK manufacturing and maintenance professionals
                </li>
                <li class="quality-list-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Technical specifications available for all products
                </li>
                <li class="quality-list-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Consistent supply from established supplier network
                </li>
            </ul>
            <a href="{{ route('about') }}" class="btn btn-primary" id="quality-learn-btn">
                Our Approach to Quality
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════
     CTA SECTION
═══════════════════════════════════════ --}}
<section class="cta-section" aria-labelledby="cta-heading">
    <div class="container">
        <span class="section-label fade-up" style="justify-content:center;color:rgba(255,255,255,0.4);">Get In Touch</span>
        <h2 class="display-2 fade-up fade-up-delay-1" id="cta-heading">Looking for the Right Engineering Product?</h2>
        <p class="fade-up fade-up-delay-2">Speak with our team about your specific requirements. We're here to help you find the right components for your application.</p>
        <div class="cta-buttons fade-up fade-up-delay-3">
            <a href="{{ route('contact') }}" class="btn btn-primary btn-lg" id="cta-contact-btn">Contact Malfaur</a>
            <a href="{{ route('products') }}" class="btn btn-secondary btn-lg" id="cta-products-btn">Browse Products</a>
        </div>
    </div>
</section>

{{-- Product Detail Modal --}}
<div class="modal-overlay" id="product-modal" role="dialog" aria-modal="true" aria-labelledby="modal-name">
    <div class="modal-box" style="position:relative;">
        <button class="modal-close" id="modal-close" aria-label="Close product details">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <div class="modal-inner">
            <div class="modal-image">
                <img id="modal-img" src="" alt="">
            </div>
            <div class="modal-content">
                <p class="modal-category" id="modal-category"></p>
                <h3 class="modal-name" id="modal-name"></h3>
                <p class="modal-desc" id="modal-desc"></p>
                <div class="modal-specs">
                    <p class="modal-specs-title">Technical Specifications</p>
                    <div id="modal-specs-body"></div>
                </div>
                <div class="modal-actions">
                    <a href="{{ route('contact') }}" class="btn btn-primary">Enquire About This Product</a>
                    <a href="{{ route('products') }}" class="btn btn-outline">View Full Catalogue</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
