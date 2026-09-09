@extends('layouts.app')

@section('title', 'Engineering Products Catalogue — Malfaur Engineering Products')
@section('meta_description', 'Browse the full Malfaur Engineering Products catalogue — cutting tools, measuring equipment, standard parts, aerospace parts and raw materials for UK engineering professionals.')

@section('content')

{{-- ═══════════════════════════════════════
     PAGE HERO
═══════════════════════════════════════ --}}
@php
    $productsHero = \App\Models\PageContent::getSection('products', 'hero');
    $prodTitle = $productsHero['title'] ?? 'Product Catalogue';
    $prodSubtitle = $productsHero['subtitle'] ?? 'Browse our comprehensive range of precision engineering components, cutting tools, aerospace alloys, and raw materials. All products are verified for UK industrial, manufacturing, and trade supply.';
@endphp

{{-- ═══════════════════════════════════════
     PAGE HERO
═══════════════════════════════════════ --}}
<section class="page-hero catalogue-hero" aria-labelledby="catalogue-heading">
    <div class="page-hero-image" aria-hidden="true">
        <img src="{{ asset('images/products-hero-banner.jpg') }}" alt="Engineering Tools Workshop Banner" loading="eager" onerror="this.src='{{ asset('images/hero-engineering.png') }}'">
        <div class="hero-mesh-overlay"></div>
    </div>
    <div class="container">
        <div class="page-hero-content">
            <nav class="page-hero-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span aria-hidden="true">›</span>
                <span class="current">Products</span>
            </nav>
            
            <div class="catalogue-hero-badge">
                <span class="pulse-dot-accent"></span>
                <span>Industrial Precision Range · Malfaur UK</span>
            </div>

            <h1 class="display-2" id="catalogue-heading">{{ $prodTitle }}</h1>
            <p class="lead">{{ $prodSubtitle }}</p>

            <div class="catalogue-hero-chips">
                <div class="hero-chip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    <span>5 Core Categories</span>
                </div>
                <div class="hero-chip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <span>DIN & ISO Standard</span>
                </div>
                <div class="hero-chip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <span>Fast UK Quotation & Dispatch</span>
                </div>
                <div class="hero-chip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>Certified Traceability</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════
     FILTER BAR
═══════════════════════════════════════ --}}
<div class="catalogue-filter-sticky" role="search" aria-label="Product search and filters">
    <div class="container">
        <div class="filter-main-card">
            <div class="filter-row">
                <div class="search-box">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="search" id="product-search" placeholder="Search by name, spec, or standard (e.g. Hex Bar, Caliper, Reamer)..." aria-label="Search products" autocomplete="off">
                    <button type="button" id="search-clear-btn" class="search-clear-btn" aria-label="Clear search" style="display:none;">✕</button>
                </div>

                @php
                    $filterRootCats = $categoryTree ?? \App\Models\Category::whereNull('parent_id')->where('is_active', true)->orderBy('sort_order')->orderBy('name')->with('allChildren')->get();
                    $iconMap = [
                        'Cutting Tools' => '⚙',
                        'Measuring Equipment' => '📐',
                        'Standard Parts' => '🔩',
                        'Aerospace Parts' => '✈',
                        'Raw Materials' => '🧱'
                    ];

                    $categoriesForJs = $filterRootCats->map(function($cat) {
                        return [
                            'id' => (int) $cat->id,
                            'name' => $cat->name,
                            'slug' => $cat->slug,
                            'color' => $cat->color,
                            'all_ids' => array_values(array_unique($cat->getAllCategoryIds())),
                            'children' => $cat->children->map(function($sub) {
                                return [
                                    'id' => (int) $sub->id,
                                    'name' => $sub->name,
                                    'slug' => $sub->slug,
                                    'all_ids' => array_values(array_unique($sub->getAllCategoryIds())),
                                    'children' => $sub->children->map(function($leaf) {
                                        return [
                                            'id' => (int) $leaf->id,
                                            'name' => $leaf->name,
                                            'slug' => $leaf->slug,
                                            'all_ids' => array_values(array_unique($leaf->getAllCategoryIds())),
                                        ];
                                    })
                                ];
                            })
                        ];
                    });
                @endphp

                <script>
                    window.MALFAUR_CATEGORIES = @json($categoriesForJs);
                </script>

                <div class="filter-cats" role="group" aria-label="Filter by category">
                    <button class="filter-btn active" data-filter="all" data-cat-id="all" id="filter-all">
                        <span class="f-dot"></span>
                        <span>All Products</span>
                    </button>
                    @foreach($filterRootCats as $fCat)
                        <button class="filter-btn" data-filter="{{ $fCat->name }}" data-cat-id="{{ $fCat->id }}" data-cat-slug="{{ $fCat->slug }}" id="filter-{{ $fCat->slug }}">
                            <span class="f-icon">{{ $iconMap[$fCat->name] ?? '✦' }}</span>
                            <span>{{ $fCat->name }}</span>
                        </button>
                    @endforeach
                </div>

                <button class="filter-clear" id="filter-clear" aria-label="Clear all filters">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.4"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    <span>Clear</span>
                </button>
            </div>

            {{-- Dynamic Subcategory Tags Filter Bar --}}
            <div class="subcat-filter-wrapper" id="subcatFilterWrapper" style="display:none;" aria-label="Subcategory filter tags">
                <div class="subcat-filter-inner">
                    <span class="subcat-filter-label">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                        </svg>
                        <span>Subcategories:</span>
                    </span>
                    <div class="subcat-pills" id="subcatPillsContainer" role="group" aria-label="Filter by subcategory">
                        {{-- Injected dynamically via JS --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════
     PRODUCT GRID
═══════════════════════════════════════ --}}
<section class="section-pad catalogue-grid-section bg-light" aria-labelledby="products-list-heading">
    <div class="container">
        {{-- Catalogue Status Toolbar --}}
        <div class="catalogue-toolbar">
            <div class="toolbar-left">
                <span class="live-pulse-dot" aria-hidden="true"></span>
                <p class="products-count" id="products-count" aria-live="polite">Loading products...</p>
            </div>
            <div class="toolbar-right">
                <div class="catalogue-category-indicator" id="category-indicator">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    <span id="active-category-label">All Categories</span>
                </div>
            </div>
        </div>

        <h2 class="sr-only" id="products-list-heading">Products List</h2>

        {{-- Product Grid Skeleton Loader (Fast Shimmer Transition) --}}
        <div class="product-grid-4 product-skeleton-grid" id="productSkeletonGrid" style="display:none;" aria-hidden="true">
            @for($i = 0; $i < 8; $i++)
            <div class="product-card-skeleton">
                <div class="skeleton-img-box skeleton-shimmer"></div>
                <div class="skeleton-content">
                    <div class="skeleton-line skeleton-tag skeleton-shimmer"></div>
                    <div class="skeleton-line skeleton-title skeleton-shimmer"></div>
                    <div class="skeleton-line skeleton-desc-1 skeleton-shimmer"></div>
                    <div class="skeleton-line skeleton-desc-2 skeleton-shimmer"></div>
                    <div class="skeleton-footer-box">
                        <div class="skeleton-line skeleton-meta skeleton-shimmer"></div>
                        <div class="skeleton-line skeleton-btn skeleton-shimmer"></div>
                    </div>
                </div>
            </div>
            @endfor
        </div>

        <div class="product-grid-4" id="mainProductsGrid">
            @foreach($products as $product)
            <article class="product-card fade-up"
                data-category="{{ $product->root_category_name }}"
                data-root-category="{{ $product->root_category_name }}"
                data-category-name="{{ $product->category_name }}"
                data-category-ids="{{ json_encode($product->all_category_ids) }}"
                data-name="{{ $product->name }}"
                data-slug="{{ $product->slug }}"
                data-desc="{{ $product->description }}"
                data-img="{{ asset(Str::startsWith($product->image ?? '', 'http') ? $product->image : 'images/' . ($product->image ?? 'hero-engineering.png')) }}"
                data-specs='{!! json_encode($product->specs) !!}'>
                <a href="{{ route('products.show', $product->slug) }}" class="product-card-image" aria-label="View details for {{ $product->name }}">
                    <img src="{{ asset(Str::startsWith($product->image ?? '', 'http') ? $product->image : 'images/' . ($product->image ?? 'hero-engineering.png')) }}" alt="{{ $product->name }}" loading="lazy">
                </a>
                <div class="product-card-body">
                    <span class="product-card-category-tag">{{ $product->category_breadcrumb }}</span>
                    <h3 class="product-card-name">
                        <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                    </h3>
                    <p class="product-card-desc">{{ $product->short_description ?? Str::limit($product->description, 100) }}</p>
                    <div class="product-card-footer">
                        @php
                            $variantCount = isset($product->specifications['dimensions']) && is_array($product->specifications['dimensions']) ? count($product->specifications['dimensions']) : 0;
                        @endphp
                        @if($variantCount > 0)
                            <span class="product-card-spec-meta">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
                                </svg>
                                {{ $variantCount }} Sizes
                            </span>
                        @else
                            <span class="product-card-spec-meta">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                DIN / ISO
                            </span>
                        @endif
                        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-accent-outline" id="cat-product-{{ $product->id }}">View Details</a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        {{-- Enhanced No Results Card --}}
        <div id="no-results" style="display:none;" class="no-product-card">
            <div class="no-product-icon-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <h3 class="no-product-title">No Matching Products Found</h3>
            <p class="no-product-desc">We couldn't find any engineering products matching your current search or category filter. Try clearing your search keyword or selecting a different category.</p>
            <div class="no-product-suggestions">
                <span class="suggestion-title">Popular searches:</span>
                <button type="button" class="suggestion-chip js-suggest-chip" data-query="Hex Bar">Alloy Steel</button>
                <button type="button" class="suggestion-chip js-suggest-chip" data-query="Micrometer">Micrometer</button>
                <button type="button" class="suggestion-chip js-suggest-chip" data-query="Reamers">Reamers</button>
                <button type="button" class="suggestion-chip js-suggest-chip" data-query="Spring Plungers">Spring Plungers</button>
            </div>
            <button type="button" class="btn btn-primary" id="no-results-reset-btn">Reset All Filters</button>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════
     BOTTOM CTA
═══════════════════════════════════════ --}}
<section class="catalogue-cta-section" aria-labelledby="products-cta-heading">
    <div class="container">
        <div class="catalogue-cta-card">
            <div class="cta-inner-content">
                <div class="cta-pill-label">
                    <span class="sparkle">✦</span>
                    <span>Bespoke Tooling & Sourcing</span>
                </div>
                <h2 class="display-2" id="products-cta-heading">Can't Find Your Exact Engineering Component?</h2>
                <p class="cta-desc">Beyond our catalogue items, Malfaur Engineering specializes in sourcing custom alloys, bespoke cutting geometry, hard-to-find aerospace grades, and precision components manufactured to your CAD drawings.</p>
                
                <div class="cta-trust-features">
                    <div class="cta-trust-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        <span>Material Test Certs (EN 10204 3.1)</span>
                    </div>
                    <div class="cta-trust-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        <span>Custom CAD & Drawing Quotations</span>
                    </div>
                    <div class="cta-trust-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        <span>Fast UK Technical Response</span>
                    </div>
                </div>

                <div class="cta-actions">
                    <a href="{{ route('contact') }}" class="btn btn-primary btn-lg" id="products-enquire-btn">Send a Custom Component Enquiry</a>
                    <a href="{{ route('contact') }}#quote" class="btn btn-accent-outline btn-lg">Request CAD Quotation</a>
                </div>
            </div>
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
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
