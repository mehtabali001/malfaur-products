@extends('layouts.admin')

@section('title', 'Page Content Manager')
@section('page-title', 'Page Content Manager')

@section('content')
<div style="max-width: 950px; margin: 0 auto;">
    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <h2 class="admin-card-title">Edit Website Pages Content</h2>
                <p style="font-size:0.8rem;color:var(--admin-text-muted);margin:0.25rem 0 0;">Customize titles, hero banners, missions, and story copy dynamically across the frontend pages.</p>
            </div>
        </div>

        <!-- Page Switcher Tabs -->
        <div style="display: flex; gap: 0.5rem; margin-bottom: 1.5rem; border-bottom: 1px solid #E2E8F0; padding-bottom: 0.75rem; flex-wrap: wrap;">
            <a href="{{ route('admin.pages.index', ['tab' => 'home']) }}" class="admin-btn {{ $activeTab === 'home' ? 'admin-btn-primary' : 'admin-btn-outline' }} admin-btn-sm">
                🏠 Home Page Hero
            </a>
            <a href="{{ route('admin.pages.index', ['tab' => 'about']) }}" class="admin-btn {{ $activeTab === 'about' ? 'admin-btn-primary' : 'admin-btn-outline' }} admin-btn-sm">
                🏢 Who We Are (About)
            </a>
            <a href="{{ route('admin.pages.index', ['tab' => 'contact']) }}" class="admin-btn {{ $activeTab === 'contact' ? 'admin-btn-primary' : 'admin-btn-outline' }} admin-btn-sm">
                ✉️ Contact Page Info
            </a>
            <a href="{{ route('admin.pages.index', ['tab' => 'products']) }}" class="admin-btn {{ $activeTab === 'products' ? 'admin-btn-primary' : 'admin-btn-outline' }} admin-btn-sm">
                📦 Products Catalogue Banner
            </a>
        </div>

        {{-- ── TAB 1: HOME PAGE ── --}}
        @if($activeTab === 'home')
            <form action="{{ route('admin.pages.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="page" value="home">
                <input type="hidden" name="section" value="hero">

                <div class="form-group">
                    <label class="form-label" for="badge">Top Pill Badge</label>
                    <input type="text" id="badge" name="badge" value="{{ old('badge', $homeHero['meta_data']['badge'] ?? 'PREMIER INDUSTRIAL SUPPLY UK') }}" class="form-control" placeholder="e.g. PREMIER INDUSTRIAL SUPPLY UK">
                </div>

                <div class="form-group">
                    <label class="form-label" for="title">Hero Main Headline *</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $homeHero['title'] ?? 'Precision Engineering, Cutting Tools & Aerospace Components') }}" required class="form-control">
                    <span style="font-size: 0.72rem; color: #94A3B8;">The prominent H1 title in the home hero banner.</span>
                </div>

                <div class="form-group">
                    <label class="form-label" for="subtitle">Hero Subtitle / Value Proposition</label>
                    <textarea id="subtitle" name="subtitle" rows="3" class="form-control">{{ old('subtitle', $homeHero['subtitle'] ?? 'Delivering high-performance cutting tools, aerospace grade fasteners, precision measuring instruments, and specialized engineering raw materials across the UK.') }}</textarea>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label" for="primary_btn_text">Primary Button Label</label>
                        <input type="text" id="primary_btn_text" name="primary_btn_text" value="{{ old('primary_btn_text', $homeHero['meta_data']['primary_btn_text'] ?? 'Explore Products') }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="secondary_btn_text">Secondary Button Label</label>
                        <input type="text" id="secondary_btn_text" name="secondary_btn_text" value="{{ old('secondary_btn_text', $homeHero['meta_data']['secondary_btn_text'] ?? 'Request a Quote') }}" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Hero Background / Feature Image</label>
                    <div style="display: flex; gap: 0.75rem; align-items: center; margin-bottom: 0.5rem;">
                        @if(!empty($homeHero['image']))
                            <img src="{{ asset($homeHero['image']) }}" alt="Hero Preview" style="width: 70px; height: 45px; object-fit: cover; border-radius: 6px; border: 1px solid #CBD5E1;" onerror="this.src='{{ asset('images/hero-engineering.png') }}'">
                        @endif
                        <input type="file" name="image_file" class="form-control" accept="image/*" style="padding: 0.45rem 0.75rem;">
                    </div>
                    <div>
                        <span style="font-size: 0.72rem; color: #94A3B8;">Or specify image path/URL:</span>
                        <input type="text" name="image_url" value="{{ old('image_url', $homeHero['image'] ?? 'hero-engineering.png') }}" class="form-control" style="font-size: 0.78rem; padding: 0.35rem 0.6rem; margin-top: 0.2rem;">
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; margin-top: 1.5rem; border-top: 1px solid #E2E8F0; padding-top: 1.25rem;">
                    <button type="submit" class="admin-btn admin-btn-accent" style="padding: 0.65rem 1.5rem;">
                        Save Home Page Content
                    </button>
                </div>
            </form>
        @endif

        {{-- ── TAB 2: ABOUT / WHO WE ARE ── --}}
        @if($activeTab === 'about')
            <form action="{{ route('admin.pages.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="page" value="about">
                <input type="hidden" name="section" value="story">

                <div class="form-group">
                    <label class="form-label" for="title">About Page Headline *</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $aboutStory['title'] ?? 'Excellence in Precision Engineering & Industrial Supply') }}" required class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label" for="subtitle">About Subtitle</label>
                    <input type="text" id="subtitle" name="subtitle" value="{{ old('subtitle', $aboutStory['subtitle'] ?? 'Serving the UK manufacturing, aerospace, and precision engineering sectors with high-grade components.') }}" class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label" for="content">Company Story & Detailed Narrative</label>
                    <textarea id="content" name="content" rows="6" class="form-control" placeholder="Write the complete company background, quality assurance practices, and history...">{{ old('content', $aboutStory['content'] ?? 'Malfaur Engineering Products is a trusted UK supplier of high-precision tools, components, and raw materials. Our commitment to strict tolerances, rapid turnaround times, and verified quality standards makes us the partner of choice for aerospace, automotive, and precision manufacturing workshops across the country.') }}</textarea>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label" for="mission">Our Mission</label>
                        <textarea id="mission" name="mission" rows="3" class="form-control">{{ old('mission', $aboutStory['meta_data']['mission'] ?? 'To empower UK manufacturers and engineers with peerless tooling quality, robust supply chain reliability, and bespoke technical guidance.') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="vision">Our Vision</label>
                        <textarea id="vision" name="vision" rows="3" class="form-control">{{ old('vision', $aboutStory['meta_data']['vision'] ?? 'To be recognized as the premier British distributor for mission-critical engineering components, aerospace parts, and advanced cutting solutions.') }}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">About Page Feature Image</label>
                    <div style="display: flex; gap: 0.75rem; align-items: center; margin-bottom: 0.5rem;">
                        @if(!empty($aboutStory['image']))
                            <img src="{{ asset($aboutStory['image']) }}" alt="About Preview" style="width: 70px; height: 45px; object-fit: cover; border-radius: 6px; border: 1px solid #CBD5E1;" onerror="this.src='{{ asset('images/hero-engineering.png') }}'">
                        @endif
                        <input type="file" name="image_file" class="form-control" accept="image/*" style="padding: 0.45rem 0.75rem;">
                    </div>
                    <div>
                        <span style="font-size: 0.72rem; color: #94A3B8;">Or specify image path/URL:</span>
                        <input type="text" name="image_url" value="{{ old('image_url', $aboutStory['image'] ?? 'hero-engineering.png') }}" class="form-control" style="font-size: 0.78rem; padding: 0.35rem 0.6rem; margin-top: 0.2rem;">
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; margin-top: 1.5rem; border-top: 1px solid #E2E8F0; padding-top: 1.25rem;">
                    <button type="submit" class="admin-btn admin-btn-accent" style="padding: 0.65rem 1.5rem;">
                        Save About Page Content
                    </button>
                </div>
            </form>
        @endif

        {{-- ── TAB 3: CONTACT PAGE ── --}}
        @if($activeTab === 'contact')
            <form action="{{ route('admin.pages.update') }}" method="POST">
                @csrf
                <input type="hidden" name="page" value="contact">
                <input type="hidden" name="section" value="info">

                <div class="form-group">
                    <label class="form-label" for="title">Contact Page Title *</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $contactInfo['title'] ?? 'Get in Touch with Our Engineering Specialists') }}" required class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label" for="subtitle">Contact Page Subtitle / Intro</label>
                    <textarea id="subtitle" name="subtitle" rows="3" class="form-control">{{ old('subtitle', $contactInfo['subtitle'] ?? 'Have a custom specification, volume enquiry, or need technical guidance? Reach out to our technical team today.') }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label" for="content">Customer Service Note / Response Guarantee</label>
                    <textarea id="content" name="content" rows="3" class="form-control">{{ old('content', $contactInfo['content'] ?? 'All requests for quotation (RFQs) and technical enquiries are acknowledged within 2-4 business hours by our qualified engineering team.') }}</textarea>
                </div>

                <div style="display: flex; justify-content: flex-end; margin-top: 1.5rem; border-top: 1px solid #E2E8F0; padding-top: 1.25rem;">
                    <button type="submit" class="admin-btn admin-btn-accent" style="padding: 0.65rem 1.5rem;">
                        Save Contact Page Content
                    </button>
                </div>
            </form>
        @endif

        {{-- ── TAB 4: PRODUCTS CATALOGUE BANNER ── --}}
        @if($activeTab === 'products')
            <form action="{{ route('admin.pages.update') }}" method="POST">
                @csrf
                <input type="hidden" name="page" value="products">
                <input type="hidden" name="section" value="hero">

                <div class="form-group">
                    <label class="form-label" for="title">Products Page Main Title *</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $productsHero['title'] ?? 'Precision Engineering Products & Tooling Catalogue') }}" required class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label" for="subtitle">Products Page Subtitle</label>
                    <textarea id="subtitle" name="subtitle" rows="3" class="form-control">{{ old('subtitle', $productsHero['subtitle'] ?? 'Explore our complete inventory of cutting tools, measuring equipment, standard parts, aerospace components, and raw materials.') }}</textarea>
                </div>

                <div style="display: flex; justify-content: flex-end; margin-top: 1.5rem; border-top: 1px solid #E2E8F0; padding-top: 1.25rem;">
                    <button type="submit" class="admin-btn admin-btn-accent" style="padding: 0.65rem 1.5rem;">
                        Save Products Page Content
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection
