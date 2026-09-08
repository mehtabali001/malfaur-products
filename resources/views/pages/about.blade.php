@extends('layouts.app')

@section('title', 'Who We Are — Malfaur Engineering Products')
@section('meta_description', 'Learn about Malfaur Engineering Products — a UK-based engineering supplier committed to precision, quality, and reliable product supply for professional customers.')

@section('content')

@php
    $aboutStory = \App\Models\PageContent::getSection('about', 'story');
    $aboutTitle = $aboutStory['title'] ?? 'Who We Are';
    $aboutSubtitle = $aboutStory['subtitle'] ?? 'A UK engineering products supplier defined by a commitment to quality, technical integrity, and genuine customer service.';
    $aboutContent = $aboutStory['content'] ?? 'Malfaur Engineering Products exists to supply quality-assured engineering components and industrial products to professional customers throughout the United Kingdom. We understand the environment our customers operate in — demanding production schedules, rigorous safety and quality standards, and the expectation that every component will perform exactly as required.';
    $aboutMission = $aboutStory['meta_data']['mission'] ?? 'To empower UK manufacturers and engineers with peerless tooling quality, robust supply chain reliability, and bespoke technical guidance.';
    $aboutVision = $aboutStory['meta_data']['vision'] ?? 'To be recognized as the premier British distributor for mission-critical engineering components, aerospace parts, and advanced cutting solutions.';
    $aboutImg = $aboutStory['image'] ?? 'images/company-workshop.png';
    if (!str_starts_with($aboutImg, 'http') && !str_starts_with($aboutImg, 'images/')) {
        $aboutImg = 'images/' . $aboutImg;
    }
@endphp

{{-- ═══════════════════════════════════════
     PAGE HERO
═══════════════════════════════════════ --}}
<section class="page-hero" aria-labelledby="about-hero-heading">
    <div class="page-hero-image" aria-hidden="true">
        <img src="{{ asset('images/about-hero.png') }}" alt="" loading="eager">
    </div>
    <div class="container">
        <div class="page-hero-content">
            <nav class="page-hero-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span aria-hidden="true">›</span>
                <span class="current">Who We Are</span>
            </nav>
            <span class="section-label" style="color:var(--accent);">About Malfaur</span>
            <h1 class="display-2" id="about-hero-heading">{{ $aboutTitle }}</h1>
            <p class="lead">{{ $aboutSubtitle }}</p>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════
     ABOUT MALFAUR
═══════════════════════════════════════ --}}
<section class="section-pad" aria-labelledby="about-intro-heading">
    <div class="container">
        <div class="about-intro-grid">
            <div class="about-text fade-up">
                <span class="section-label">Our Background</span>
                <h2 class="heading-1" id="about-intro-heading">{{ $aboutTitle }}</h2>
                <span class="divider-accent"></span>
                <div class="body-lg" style="margin-bottom: 1.25rem; white-space: pre-wrap; line-height: 1.7; color: var(--text-secondary);">
                    {!! nl2br(e($aboutContent)) !!}
                </div>

                @if(!empty($aboutMission))
                    <div style="background: rgba(8, 21, 40, 0.03); border-left: 3px solid var(--accent); padding: 1rem 1.25rem; border-radius: 0 8px 8px 0; margin-bottom: 1rem;">
                        <strong style="display:block; color: var(--navy); font-size: 0.95rem; margin-bottom: 0.25rem;">Our Mission:</strong>
                        <p style="margin:0; font-size: 0.9rem; color: var(--text-secondary);">{{ $aboutMission }}</p>
                    </div>
                @endif

                @if(!empty($aboutVision))
                    <div style="background: rgba(8, 21, 40, 0.03); border-left: 3px solid var(--accent); padding: 1rem 1.25rem; border-radius: 0 8px 8px 0; margin-bottom: 1.5rem;">
                        <strong style="display:block; color: var(--navy); font-size: 0.95rem; margin-bottom: 0.25rem;">Our Vision:</strong>
                        <p style="margin:0; font-size: 0.9rem; color: var(--text-secondary);">{{ $aboutVision }}</p>
                    </div>
                @endif

                <a href="{{ route('products') }}" class="btn btn-outline" style="margin-top:0.5rem;" id="about-products-btn">
                    View Our Products
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

            <div class="about-image fade-up fade-up-delay-2">
                <img src="{{ asset($aboutImg) }}" alt="Engineering workshop environment" loading="lazy" onerror="this.src='{{ asset('images/company-workshop.png') }}'">
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════
     VALUES STRIP
═══════════════════════════════════════ --}}
<div class="values-strip" aria-label="Company values overview">
    <div class="container">
        <div class="values-strip-grid">
            <div class="fade-up" style="text-align:center;">
                <div class="value-item-num">25+</div>
                <div class="value-item-label">Years of Experience</div>
            </div>
            <div class="fade-up fade-up-delay-1" style="text-align:center;">
                <div class="value-item-num">500+</div>
                <div class="value-item-label">Products in Catalogue</div>
            </div>
            <div class="fade-up fade-up-delay-2" style="text-align:center;">
                <div class="value-item-num">UK</div>
                <div class="value-item-label" style="font-size:0.9rem;color:rgba(255,255,255,0.5);">Based &amp; Operated</div>
            </div>
            <div class="fade-up fade-up-delay-3" style="text-align:center;">
                <div class="value-item-num">100%</div>
                <div class="value-item-label">Professional Focus</div>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════
     OUR APPROACH
═══════════════════════════════════════ --}}
<section class="section-pad bg-light" aria-labelledby="approach-heading">
    <div class="container">
        <div style="text-align:center;margin-bottom:3rem;">
            <span class="section-label fade-up" style="justify-content:center;">How We Work</span>
            <h2 class="heading-1 fade-up fade-up-delay-1" id="approach-heading">Our Approach</h2>
            <p class="fade-up fade-up-delay-2" style="color:var(--text-secondary);max-width:540px;margin:0.75rem auto 0;">
                Every aspect of how Malfaur operates is guided by the same principles — quality, precision, reliability, and putting the customer's technical requirements first.
            </p>
        </div>

        <div class="approach-grid">
            <div class="approach-card fade-up">
                <span class="approach-num" aria-hidden="true">01</span>
                <div class="feature-icon" aria-hidden="true" style="margin-bottom:1rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="approach-title">Quality Without Compromise</h3>
                <p class="approach-desc">
                    We maintain strict product standards across our catalogue. Products are selected based on their suitability for professional engineering use — not simply what is cheapest or most readily available. Every product meets or exceeds recognised industry standards.
                </p>
            </div>

            <div class="approach-card fade-up fade-up-delay-1">
                <span class="approach-num" aria-hidden="true">02</span>
                <div class="feature-icon" aria-hidden="true" style="margin-bottom:1rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 class="approach-title">Technical Precision</h3>
                <p class="approach-desc">
                    Engineering products require precise specifications. We maintain full technical data for our range, including dimensional standards, material grades, tolerances and applicable standards, so customers can specify with confidence and trust that they will receive exactly what they require.
                </p>
            </div>

            <div class="approach-card fade-up fade-up-delay-2">
                <span class="approach-num" aria-hidden="true">03</span>
                <div class="feature-icon" aria-hidden="true" style="margin-bottom:1rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="approach-title">Reliable Supply</h3>
                <p class="approach-desc">
                    We recognise that unreliable supply has real operational costs for engineering businesses. Our supplier relationships and stock management practices are focused on ensuring that product availability is consistent and that lead times are communicated clearly and accurately.
                </p>
            </div>

            <div class="approach-card fade-up fade-up-delay-3">
                <span class="approach-num" aria-hidden="true">04</span>
                <div class="feature-icon" aria-hidden="true" style="margin-bottom:1rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="approach-title">Customer-Focused Service</h3>
                <p class="approach-desc">
                    Our customers are professionals with specific technical requirements. We aim to provide accurate, informed assistance rather than generic customer service scripts. When you contact Malfaur, you speak with people who understand engineering products.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════
     OUR COMMITMENT
═══════════════════════════════════════ --}}
<section class="section-pad commitment-section" aria-labelledby="commitment-heading">
    <div class="container">
        <div class="commitment-grid">
            <div class="commitment-image fade-up">
                <img src="{{ asset('images/quality-section.png') }}" alt="Engineering quality and precision" loading="lazy">
            </div>
            <div class="commitment-content fade-up fade-up-delay-2">
                <span class="section-label">Our Commitment</span>
                <h2 class="heading-1" id="commitment-heading">What We Are Committed To</h2>
                <span class="divider-accent"></span>
                <p>
                    Malfaur Engineering Products is committed to being a genuinely useful, technically credible engineering supplier — not a transactional order-processing business.
                </p>
                <p>
                    That means maintaining the product knowledge our customers need, stocking products that meet professional standards, and providing straightforward, honest communication about what we can and cannot supply.
                </p>

                <div class="commitment-points">
                    <div class="commitment-point">
                        <div class="commitment-point-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div class="commitment-point-text">
                            <strong>Product Integrity</strong>
                            <span>We supply products that are what they say they are, meeting the specifications and standards we publish.</span>
                        </div>
                    </div>

                    <div class="commitment-point">
                        <div class="commitment-point-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                        <div class="commitment-point-text">
                            <strong>Clear Communication</strong>
                            <span>Straightforward information on availability, lead times, and technical specifications — no vague answers.</span>
                        </div>
                    </div>

                    <div class="commitment-point">
                        <div class="commitment-point-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div class="commitment-point-text">
                            <strong>Professional Relationships</strong>
                            <span>Long-term supply partnerships with our customers, built on consistent performance and trust over time.</span>
                        </div>
                    </div>

                    <div class="commitment-point">
                        <div class="commitment-point-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                            </svg>
                        </div>
                        <div class="commitment-point-text">
                            <strong>UK Industry Knowledge</strong>
                            <span>Understanding the specific standards, requirements and working practices of UK engineering and manufacturing.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════
     CTA
═══════════════════════════════════════ --}}
<section class="cta-section" aria-labelledby="about-cta-heading">
    <div class="container">
        <span class="section-label" style="justify-content:center;color:rgba(255,255,255,0.4);">Work With Us</span>
        <h2 class="display-2 fade-up" id="about-cta-heading">Ready to Discuss Your Requirements?</h2>
        <p class="fade-up fade-up-delay-1">Contact our team to discuss your engineering product requirements. We welcome trade and professional enquiries from across the United Kingdom.</p>
        <div class="cta-buttons fade-up fade-up-delay-2">
            <a href="{{ route('contact') }}" class="btn btn-primary btn-lg" id="about-contact-btn">Contact Malfaur</a>
            <a href="{{ route('products') }}" class="btn btn-secondary btn-lg" id="about-products-link">Browse Products</a>
        </div>
    </div>
</section>

@endsection
