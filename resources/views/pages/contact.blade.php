@extends('layouts.app')

@section('title', 'Contact Us — Malfaur Engineering Products')
@section('meta_description', 'Contact Malfaur Engineering Products to discuss your engineering product requirements. Send an enquiry or speak with our UK-based team.')

@section('content')

@php
    $contactInfo = \App\Models\PageContent::getSection('contact', 'info');
    $contactTitle = $contactInfo['title'] ?? 'Let\'s Discuss Your Requirements';
    $contactSubtitle = $contactInfo['subtitle'] ?? 'Whether you have a specific product enquiry or would like to discuss your engineering supply requirements, our team is here to help.';
    $contactDesc = $contactInfo['content'] ?? 'We welcome enquiries from engineering professionals, maintenance teams, trade customers and businesses throughout the UK. Use the form to get in touch — we\'ll respond promptly.';
@endphp

{{-- ═══════════════════════════════════════
     PAGE HERO
═══════════════════════════════════════ --}}
<section class="page-hero" aria-labelledby="contact-hero-heading">
    <div class="page-hero-image" aria-hidden="true">
        <img src="{{ asset('images/hero-engineering.png') }}" alt="" loading="eager">
    </div>
    <div class="container">
        <div class="page-hero-content">
            <nav class="page-hero-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span aria-hidden="true">›</span>
                <span class="current">Contact</span>
            </nav>
            <span class="section-label" style="color:var(--accent);">Get In Touch</span>
            <h1 class="display-2" id="contact-hero-heading">{{ $contactTitle }}</h1>
            <p class="lead">{{ $contactSubtitle }}</p>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════
     CONTACT MAIN
═══════════════════════════════════════ --}}
<section class="section-pad" aria-labelledby="contact-section-heading">
    <div class="container">
        <h2 class="sr-only" id="contact-section-heading">Contact Information and Enquiry Form</h2>

        @if(session('success'))
            <div style="background: #ECFDF5; border: 1px solid #A7F3D0; color: #065F46; padding: 1rem 1.5rem; border-radius: 8px; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.75rem;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                <span style="font-weight: 600;">{{ session('success') }}</span>
            </div>
        @endif

        <div class="contact-grid">

            {{-- LEFT: Contact Info --}}
            <div class="contact-info fade-up">
                <span class="section-label">Contact Details</span>
                <h2 class="heading-1" style="margin-bottom:0.75rem;">Talk to the Malfaur Team</h2>
                <span class="divider-accent"></span>
                <p>
                    {{ $contactDesc }}
                </p>

                <div class="contact-details">

                    <div class="contact-detail-item">
                        <div class="contact-detail-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="contact-detail-label">Email</p>
                            <p class="contact-detail-value">
                                <a href="mailto:{{ \App\Models\Setting::get('contact_email', 'enquiries@malfaurengineering.co.uk') }}" style="color: inherit; text-decoration: none;">
                                    {{ \App\Models\Setting::get('contact_email', 'enquiries@malfaurengineering.co.uk') }}
                                </a>
                            </p>
                        </div>
                    </div>

                    <div class="contact-detail-item">
                        <div class="contact-detail-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="contact-detail-label">Phone</p>
                            <p class="contact-detail-value">
                                <a href="tel:{{ \App\Models\Setting::get('contact_phone', '+44 (0) 000 000 0000') }}" style="color: inherit; text-decoration: none;">
                                    {{ \App\Models\Setting::get('contact_phone', '+44 (0) 000 000 0000') }}
                                </a>
                            </p>
                        </div>
                    </div>

                    <div class="contact-detail-item">
                        <div class="contact-detail-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="contact-detail-label">Address</p>
                            <p class="contact-detail-value">{{ \App\Models\Setting::get('contact_address', 'United Kingdom') }}</p>
                        </div>
                    </div>

                    <div class="contact-detail-item">
                        <div class="contact-detail-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="contact-detail-label">Business Hours</p>
                            <p class="contact-detail-value">
                                {{ \App\Models\Setting::get('contact_hours', 'Monday – Friday: 08:00 – 17:30 (GMT)') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Quick Info Note --}}
                <div style="margin-top:2.5rem;padding:1.5rem;background:var(--accent-pale);border:1px solid rgba(200,134,10,0.2);border-radius:var(--radius-md);">
                    <p style="font-size:0.8rem;font-weight:700;color:var(--accent);text-transform:uppercase;letter-spacing:0.07em;margin-bottom:0.5rem;">Trade &amp; Professional Enquiries Welcome</p>
                    <p style="font-size:0.875rem;color:var(--text-secondary);line-height:1.65;">
                        We work with manufacturers, maintenance departments, engineering contractors and trade buyers across the UK. All enquiries are logged directly into our system and handled by our technical team.
                    </p>
                </div>
            </div>

            {{-- RIGHT: Contact Form --}}
            <div class="fade-up fade-up-delay-2">
                <div class="contact-form-wrap">
                    <h3 class="contact-form-title">Send an Enquiry</h3>
                    <p class="contact-form-sub">Complete the form below and a member of our team will respond within one business day.</p>

                    <form id="contact-form" action="{{ route('contact.submit') }}" method="POST" aria-label="Product enquiry form">
                        @csrf

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="contact-name">Name <span class="required" aria-label="required">*</span></label>
                                <input class="form-input" type="text" id="contact-name" name="name" value="{{ old('name') }}" placeholder="Your full name" required autocomplete="name">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="contact-company">Company</label>
                                <input class="form-input" type="text" id="contact-company" name="company" value="{{ old('company') }}" placeholder="Company or organisation" autocomplete="organization">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="contact-email">Email <span class="required" aria-label="required">*</span></label>
                                <input class="form-input" type="email" id="contact-email" name="email" value="{{ old('email') }}" placeholder="your@email.com" required autocomplete="email">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="contact-phone">Phone</label>
                                <input class="form-input" type="tel" id="contact-phone" name="phone" value="{{ old('phone') }}" placeholder="+44 (0) 000 000 0000" autocomplete="tel">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="contact-subject">Subject <span class="required" aria-label="required">*</span></label>
                            <select class="form-input" id="contact-subject" name="subject" required>
                                <option value="" disabled {{ !request()->has('product') && !old('subject') ? 'selected' : '' }}>Select enquiry type</option>
                                <option value="Product Enquiry" {{ request()->has('product') || old('subject') == 'Product Enquiry' ? 'selected' : '' }}>Product Enquiry</option>
                                <option value="Request a Quote" {{ old('subject') == 'Request a Quote' ? 'selected' : '' }}>Request a Quote</option>
                                <option value="Technical Information" {{ old('subject') == 'Technical Information' ? 'selected' : '' }}>Technical Information</option>
                                <option value="Product Availability" {{ old('subject') == 'Product Availability' ? 'selected' : '' }}>Product Availability</option>
                                <option value="Trade Account" {{ old('subject') == 'Trade Account' ? 'selected' : '' }}>Trade Account</option>
                                <option value="General Enquiry" {{ old('subject') == 'General Enquiry' ? 'selected' : '' }}>General Enquiry</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="contact-message">Message <span class="required" aria-label="required">*</span></label>
                            <textarea class="form-input" id="contact-message" name="message" placeholder="Please describe your requirements, including any relevant product specifications, quantities or application details..." required rows="5">@if(old('message')){{ old('message') }}@elseif(request()->has('product'))Hello, I would like to request an enquiry regarding the product: {{ request('product') }}@if(request()->has('sku')) (SKU: {{ request('sku') }})@endif. Please provide more details on pricing and availability.@endif</textarea>
                        </div>

                        <div class="form-submit">
                            <button type="submit" class="btn btn-primary" id="contact-submit-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                Send Enquiry
                            </button>
                        </div>

                        <p style="font-size:0.775rem;color:var(--text-muted);margin-top:1rem;line-height:1.6;">
                            By submitting this form you agree to Malfaur Engineering Products contacting you regarding your enquiry. Your information will not be shared with third parties.
                        </p>
                    </form>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════
     WHY ENQUIRE STRIP
═══════════════════════════════════════ --}}
<div style="background:var(--light-bg);border-top:1px solid var(--border);border-bottom:1px solid var(--border);padding:3rem 0;">
    <div class="container">
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:2rem;text-align:center;">
            <div class="fade-up">
                <div style="width:48px;height:48px;background:var(--accent-pale);border-radius:var(--radius-md);display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:24px;height:24px;color:var(--accent);">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <p style="font-weight:700;color:var(--text-primary);margin-bottom:0.35rem;">Fast Response</p>
                <p style="font-size:0.875rem;color:var(--text-secondary);">All enquiries responded to within one business day by our technical team.</p>
            </div>
            <div class="fade-up fade-up-delay-1">
                <div style="width:48px;height:48px;background:var(--accent-pale);border-radius:var(--radius-md);display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:24px;height:24px;color:var(--accent);">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <p style="font-weight:700;color:var(--text-primary);margin-bottom:0.35rem;">Technical Expertise</p>
                <p style="font-size:0.875rem;color:var(--text-secondary);">Speak to people who understand engineering products, not a generic call centre.</p>
            </div>
            <div class="fade-up fade-up-delay-2">
                <div style="width:48px;height:48px;background:var(--accent-pale);border-radius:var(--radius-md);display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:24px;height:24px;color:var(--accent);">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <p style="font-weight:700;color:var(--text-primary);margin-bottom:0.35rem;">No Obligation</p>
                <p style="font-size:0.875rem;color:var(--text-secondary);">Enquire freely about products, specifications, and pricing with no commitment required.</p>
            </div>
        </div>
    </div>
</div>

@endsection
