<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', \App\Models\Setting::get('site_tagline', 'Malfaur Engineering Products — Precision engineering components and industrial products for professional applications across the UK.'))">
    <meta name="robots" content="index, follow">
    <title>@yield('title', \App\Models\Setting::get('site_name', 'Malfaur Engineering Products')) | UK Engineering Supplier</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/malfaur.css') }}">
    <link rel="icon" href="{{ asset(\App\Models\Setting::get('favicon', 'favicon.ico')) }}">
    @stack('head')
</head>
<body>

    {{-- ═══════════════════════════════════════
         HEADER
    ═══════════════════════════════════════ --}}
    <header id="site-header">
        <div class="container">
            <div class="header-inner">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="logo" aria-label="{{ \App\Models\Setting::get('site_name', 'Malfaur Engineering Products') }} — Home">
                    <img src="{{ asset(\App\Models\Setting::get('logo', 'images/logo-transparent.png')) }}" class="site-logo" alt="{{ \App\Models\Setting::get('site_name', 'Malfaur Engineering') }}">
                </a>

                {{-- Desktop Navigation --}}
                <nav class="main-nav" role="navigation" aria-label="Main navigation">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                    <div class="nav-item has-mega-dropdown" id="navProductsItem">
                        <a href="{{ route('products') }}" class="nav-link nav-link-dropdown {{ request()->routeIs('products*') ? 'active' : '' }}" id="navProductsTrigger" aria-haspopup="true" aria-expanded="false">
                            Products
                            <svg class="nav-dropdown-caret" width="9" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                    <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">Who We Are</a>
                    <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
                </nav>

                {{-- CTA --}}
                <div class="header-cta">
                    <a href="{{ route('contact') }}" class="btn btn-primary btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Enquire Now
                    </a>
                </div>

                {{-- Hamburger --}}
                <button class="hamburger" id="hamburger" aria-label="Toggle navigation" aria-expanded="false">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>

        {{-- 3-Way Cascading Mega Dropdown --}}
        <div class="products-mega-dropdown" id="productsMegaDropdown" role="region" aria-label="Products Cascade Menu">
            <div class="container mega-container">
                {{-- Top Category Title Link --}}
                <div class="mega-top-bar">
                    <a href="{{ route('products') }}" class="mega-top-link">
                        Products <span class="mega-top-arrow">&gt;</span>
                    </a>
                </div>

                {{-- 3-Way Grid Layout (Dynamic Database Categories Tree) --}}
                <div class="mega-grid">
                    @php
                        $navRootCategories = \App\Models\Category::whereNull('parent_id')
                            ->where('is_active', true)
                            ->orderBy('sort_order')
                            ->orderBy('name')
                            ->with(['children.children', 'children.products' => function($q) { $q->limit(6); }, 'products' => function($q) { $q->limit(6); }])
                            ->get();
                    @endphp
                    
                    {{-- ── COLUMN 1: CATEGORIES (Level 1) ── --}}
                    <div class="mega-col mega-col-1" role="tablist" aria-label="Product Categories">
                        <div class="mega-col-inner">
                            @foreach($navRootCategories as $cat)
                                <a href="{{ route('products') }}?category_id={{ $cat->id }}" class="mega-cat-item" data-cat-id="{{ $cat->slug }}" role="tab" tabindex="0">
                                    <span class="mega-cat-label">
                                        <span class="mega-cat-dot dot-{{ $cat->color ?? 'amber' }}"></span>
                                        {{ $cat->name }}
                                    </span>
                                    <span class="mega-arrow">&gt;</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- ── PLACEHOLDER: WHEN NO CATEGORY IS SELECTED ── --}}
                    <div class="mega-placeholder-panel" id="megaPlaceholderPanel">
                        <div class="mega-placeholder-content">
                            <div class="mega-placeholder-icon-wrap">
                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 6h16M4 12h10M4 18h7"></path>
                                    <circle cx="18" cy="15" r="3"></circle>
                                    <path d="m20.5 17.5 2 2"></path>
                                </svg>
                            </div>
                            <h3 class="mega-placeholder-title">Select Any Category</h3>
                            <p class="mega-placeholder-desc">Hover over any category on the left to explore subcategories and precision components.</p>
                            <div class="mega-placeholder-badge">
                                <span class="mega-hint-pulse"></span>
                                <span>Choose from {{ $navRootCategories->count() }} Categories on the left</span>
                            </div>
                        </div>
                    </div>

                    {{-- ── COLUMN 2: SUB-CATEGORIES (Level 2) ── --}}
                    <div class="mega-col mega-col-2" id="megaColSubcat">
                        <div class="mega-col-inner">
                            @foreach($navRootCategories as $cat)
                                <div class="mega-subcat-panel" data-cat="{{ $cat->slug }}">
                                    <a href="{{ route('products') }}?category_id={{ $cat->id }}" class="mega-subcat-heading-link">
                                        All {{ $cat->name }}
                                    </a>
                                    @foreach($cat->children as $subcat)
                                        <a href="{{ route('products') }}?category_id={{ $subcat->id }}" class="mega-subcat-item" data-subcat-id="subcat-{{ $subcat->slug }}">
                                            <span>{{ $subcat->name }}</span>
                                            <span class="mega-arrow">&gt;</span>
                                        </a>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- ── COLUMN 3: ITEMS / PRODUCTS / SERIES (Level 3 & 4) ── --}}
                    <div class="mega-col mega-col-3" id="megaColItems">
                        <div class="mega-col-inner">
                            @foreach($navRootCategories as $cat)
                                @foreach($cat->children as $subcat)
                                    <div class="mega-leaf-panel" data-subcat="subcat-{{ $subcat->slug }}">
                                        <a href="{{ route('products') }}?category_id={{ $subcat->id }}" class="mega-leaf-heading-link">
                                            All {{ $subcat->name }} <span class="mega-arrow">&gt;</span>
                                        </a>
                                        <ul class="mega-leaf-list">
                                            @if($subcat->children->count() > 0)
                                                @foreach($subcat->children as $leaf)
                                                    <li>
                                                        <a href="{{ route('products') }}?category_id={{ $leaf->id }}" class="mega-leaf-link">
                                                            {{ $leaf->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @elseif($subcat->products->count() > 0)
                                                @foreach($subcat->products as $prod)
                                                    <li>
                                                        <a href="{{ route('products.show', $prod->slug ?: $prod->id) }}" class="mega-leaf-link">
                                                            {{ $prod->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @else
                                                <li>
                                                    <a href="{{ route('products') }}?category_id={{ $subcat->id }}" class="mega-leaf-link">
                                                        Browse all {{ $subcat->name }}
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>

                    {{-- ── COLUMN 4: LOGO & BRAND CARD (Always Visible) ── --}}
                    <div class="mega-col mega-col-featured">
                        <div class="mega-col-inner">
                            <div class="mega-brand-showcase-card">
                                <div class="mega-brand-logo-container">
                                    <a href="{{ route('home') }}" aria-label="Malfaur Engineering — Home">
                                        <img src="{{ asset('images/logo-transparent.png') }}" alt="Malfaur Engineering" class="mega-brand-card-logo">
                                    </a>
                                </div>
                                <div class="mega-brand-card-body">
                                    <span class="mega-brand-tag">Precision Engineering</span>
                                    <h4 class="mega-brand-heading">Malfaur Engineering</h4>
                                    <p class="mega-brand-text">Supplying precision components, cutting tools, standard parts and aerospace alloys across the UK.</p>
                                    <div class="mega-brand-perks">
                                        <div class="mega-perk-row">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                            <span>Full Material Certification</span>
                                        </div>
                                        <div class="mega-perk-row">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                            <span>Nationwide Fast Dispatch</span>
                                        </div>
                                        <div class="mega-perk-row">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                            <span>Expert Technical Support</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('contact') }}" class="mega-brand-btn">
                                        <span>Request Quote / Enquire</span>
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                            <polyline points="12 5 19 12 12 19"></polyline>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </header>

    {{-- Mobile Nav --}}
    <nav class="mobile-nav" id="mobile-nav" aria-label="Mobile navigation">
        <div class="mobile-nav-links">
            <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            
            {{-- Collapsible Products in Mobile Nav --}}
            <div class="mobile-nav-group">
                <div class="mobile-nav-header-row">
                    <a href="{{ route('products') }}" class="mobile-nav-link {{ request()->routeIs('products*') ? 'active' : '' }}">Products</a>
                    <button type="button" class="mobile-cat-toggle" id="mobileCatToggle" aria-label="Toggle products categories" aria-expanded="false">
                        <svg width="12" height="8" viewBox="0 0 12 8" fill="none">
                            <path d="M1 1.5L6 6.5L11 1.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
                <div class="mobile-cat-sublist" id="mobileCatSublist">
                    <a href="{{ route('products') }}?category=Cutting+Tools" class="mobile-sub-link">
                        <span class="mega-cat-dot dot-orange"></span> Cutting Tools
                    </a>
                    <a href="{{ route('products') }}?category=Measuring+Equipment" class="mobile-sub-link">
                        <span class="mega-cat-dot dot-blue"></span> Measuring Equipment
                    </a>
                    <a href="{{ route('products') }}?category=Standard+Parts" class="mobile-sub-link">
                        <span class="mega-cat-dot dot-green"></span> Standard Parts
                    </a>
                    <a href="{{ route('products') }}?category=Aerospace+Parts" class="mobile-sub-link">
                        <span class="mega-cat-dot dot-purple"></span> Aerospace Parts
                    </a>
                    <a href="{{ route('products') }}?category=Raw+Materials" class="mobile-sub-link">
                        <span class="mega-cat-dot dot-amber"></span> Raw Materials
                    </a>
                </div>
            </div>

            <a href="{{ route('about') }}" class="mobile-nav-link {{ request()->routeIs('about') ? 'active' : '' }}">Who We Are</a>
            <a href="{{ route('contact') }}" class="mobile-nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
        </div>
        <a href="{{ route('contact') }}" class="btn btn-primary" style="width:100%;justify-content:center;">Enquire Now</a>
    </nav>

    {{-- Page Content --}}
    <main class="page-offset">
        @yield('content')
    </main>

    {{-- ═══════════════════════════════════════
         FOOTER
    ═══════════════════════════════════════ --}}
    <footer id="site-footer">
        <div class="container">
            <div class="footer-grid">

                {{-- Brand --}}
                <div class="footer-brand">
                    <a href="{{ route('home') }}" class="logo">
                        <img src="{{ asset(\App\Models\Setting::get('logo', 'images/logo-transparent.png')) }}" class="site-logo footer-logo" alt="{{ \App\Models\Setting::get('site_name', 'Malfaur Engineering') }}">
                    </a>
                    <p>{{ \App\Models\Setting::get('site_tagline', 'Supplying precision engineering components and industrial products to professional customers across the United Kingdom. Quality and reliability at the core of everything we do.') }}</p>
                </div>

                {{-- Navigation --}}
                <div>
                    <p class="footer-col-title">Navigation</p>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}" class="footer-link">Home</a></li>
                        <li><a href="{{ route('products') }}" class="footer-link">Products Catalogue</a></li>
                        <li><a href="{{ route('about') }}" class="footer-link">Who We Are</a></li>
                        <li><a href="{{ route('contact') }}" class="footer-link">Contact Us</a></li>
                    </ul>
                </div>

                {{-- Products --}}
                <div>
                    <p class="footer-col-title">Categories</p>
                    <ul class="footer-links">
                        <li><a href="{{ route('products') }}?category=Cutting+Tools" class="footer-link">Cutting Tools</a></li>
                        <li><a href="{{ route('products') }}?category=Measuring+Equipment" class="footer-link">Measuring Equipment</a></li>
                        <li><a href="{{ route('products') }}?category=Standard+Parts" class="footer-link">Standard Parts</a></li>
                        <li><a href="{{ route('products') }}?category=Aerospace+Parts" class="footer-link">Aerospace Parts</a></li>
                        <li><a href="{{ route('products') }}?category=Raw+Materials" class="footer-link">Raw Materials</a></li>
                    </ul>
                </div>

                {{-- Contact --}}
                <div>
                    <p class="footer-col-title">Contact</p>
                    <div class="footer-contact-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>{{ \App\Models\Setting::get('contact_address', 'United Kingdom') }}</span>
                    </div>
                    <div class="footer-contact-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span><a href="mailto:{{ \App\Models\Setting::get('contact_email', 'enquiries@malfaurengineering.co.uk') }}" style="color:inherit;text-decoration:none;">{{ \App\Models\Setting::get('contact_email', 'enquiries@malfaurengineering.co.uk') }}</a></span>
                    </div>
                    <div class="footer-contact-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span><a href="tel:{{ \App\Models\Setting::get('contact_phone', '+44 (0) 000 000 0000') }}" style="color:inherit;text-decoration:none;">{{ \App\Models\Setting::get('contact_phone', '+44 (0) 000 000 0000') }}</a></span>
                    </div>
                </div>

            </div>

            <div class="footer-bottom">
                <p class="footer-copy">{{ \App\Models\Setting::get('footer_copyright', '© ' . date('Y') . ' Malfaur Engineering Products Ltd. All rights reserved.') }}</p>
                <div class="footer-legal">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms &amp; Conditions</a>
                    <a href="#">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/malfaur.js') }}"></script>
    @stack('scripts')
</body>
</html>
