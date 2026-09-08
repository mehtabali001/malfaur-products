@extends('layouts.app')

@section('title', $product->name . ' — Malfaur Engineering Products')
@section('meta_description', Str::limit($product->description, 150))

@section('content')

{{-- Breadcrumbs & Back --}}
<div class="pdp-breadcrumb-strip">
    <div class="container pdp-breadcrumb-inner">
        <nav class="pdp-breadcrumb-nav" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="sep">/</span>
            <a href="{{ route('products') }}">Products</a>
            <span class="sep">/</span>
            <span style="color:var(--text-secondary);">{{ $product->category }}</span>
            <span class="sep">/</span>
            <span class="current">{{ $product->name }}</span>
        </nav>
        <a href="{{ route('products') }}" class="pdp-back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Catalogue
        </a>
    </div>
</div>

{{-- Product Details Hero Area --}}
<section class="section-pad">
    <div class="container">
        <div class="pdp-hero-grid">
            
            {{-- Left column: Image Showcase & Certifications --}}
            <div class="fade-up">
                <div class="pdp-image-card">
                    <span class="pdp-image-tag">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        Precision Grade
                    </span>
                    <img src="{{ asset(Str::startsWith($product->image ?? '', 'http') ? $product->image : 'images/' . ($product->image ?? 'hero-engineering.png')) }}" 
                         alt="{{ $product->name }}" 
                         loading="eager">
                </div>
                
                {{-- Engineering Certification Badges --}}
                <div class="pdp-trust-strip">
                    <div class="pdp-trust-item">
                        <span class="pdp-trust-label">Standard</span>
                        <span class="pdp-trust-val">DIN / ISO Certified</span>
                    </div>
                    <div class="pdp-trust-item">
                        <span class="pdp-trust-label">Quality</span>
                        <span class="pdp-trust-val">AS9100 Compliant</span>
                    </div>
                    <div class="pdp-trust-item">
                        <span class="pdp-trust-label">Traceability</span>
                        <span class="pdp-trust-val">Batch Certified</span>
                    </div>
                </div>
            </div>

            {{-- Right column: Product Info & Actions --}}
            <div class="fade-up fade-up-delay-1" style="display:flex; flex-direction:column; justify-content:flex-start;">
                
                {{-- Category & In-Stock Badges --}}
                <div class="pdp-meta-row">
                    <span class="pdp-category-badge">{{ $product->category }}</span>
                    <span class="pdp-stock-badge">
                        <span class="pdp-stock-dot"></span>
                        In Stock
                    </span>
                </div>

                {{-- Title & Divider --}}
                <h1 class="pdp-title">{{ $product->name }}</h1>
                <div class="pdp-accent-divider"></div>

                {{-- Description (Render as points if separated by • or newlines) --}}
                @php
                    $descRaw = trim($product->description ?? '');
                    $descPoints = [];
                    if (str_contains($descRaw, '•')) {
                        $descPoints = array_filter(array_map('trim', explode('•', $descRaw)));
                    } elseif (str_contains($descRaw, "\n")) {
                        $descPoints = array_filter(array_map('trim', explode("\n", $descRaw)));
                    }
                @endphp

                @if(count($descPoints) > 1)
                    <ul class="pdp-points-list">
                        @foreach($descPoints as $point)
                            <li>
                                <svg class="pdp-point-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>{{ ucfirst($point) }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="pdp-description">
                        {{ $descRaw }}
                    </p>
                @endif



                {{-- Existing Action Buttons --}}
                <div class="pdp-actions-wrap">
                    <a href="{{ route('contact', ['product' => $product->name]) }}" class="btn btn-primary btn-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Request Quote / Enquiry
                    </a>
                    <a href="mailto:{{ \App\Models\Setting::get('contact_email', 'enquiries@malfaurengineering.co.uk') }}?subject=Technical Inquiry: {{ rawurlencode($product->name) }}" class="btn btn-outline btn-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        Email Specifications
                    </a>
                </div>



            </div>

        </div>
    </div>
</section>

{{-- Material Suitability / ISO Badges --}}
@if(isset($product->specifications['P_state']) || isset($product->specifications['M_state']) || isset($product->specifications['K_state']) || isset($product->specifications['N_state']) || isset($product->specifications['S_state']) || isset($product->specifications['H_state']))
<section class="section-pad bg-light" style="border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
    <div class="container">
        <div style="margin-bottom:2.25rem;">
            <span class="section-label">Performance</span>
            <h2 class="heading-1" style="color:var(--navy); margin-bottom:0.25rem;">Material Suitability &amp; Application (ISO 513)</h2>
            <p style="color:var(--text-secondary); font-size:0.925rem; margin:0;">Standard ISO cutting material application classifications for this tooling.</p>
        </div>

        <div class="pdp-iso-grid">
            @php
                $isoLetters = [
                    'P' => ['label' => 'Steel / Carbon Steel', 'color' => '#ffffff', 'bg' => '#0092D8', 'desc' => 'Structural steels, carbon & alloy steels'],
                    'M' => ['label' => 'Stainless Steel', 'color' => '#000000', 'bg' => '#FFD800', 'desc' => 'Austenitic, ferritic & duplex stainless'],
                    'K' => ['label' => 'Cast Iron', 'color' => '#ffffff', 'bg' => '#E30613', 'desc' => 'Grey cast iron (GG) & nodular (GGG)'],
                    'N' => ['label' => 'Non-Ferrous / Al', 'color' => '#ffffff', 'bg' => '#009640', 'desc' => 'Aluminium alloys, brass & copper'],
                    'S' => ['label' => 'Exotics / Titanium', 'color' => '#ffffff', 'bg' => '#FF5F00', 'desc' => 'Heat-resistant superalloys & titanium'],
                    'H' => ['label' => 'Hardened Steel', 'color' => '#ffffff', 'bg' => '#7D7D7D', 'desc' => 'High hardness steel alloys 45–65 HRC']
                ];
            @endphp

            @foreach($isoLetters as $letter => $meta)
                @if(isset($product->specifications[$letter . '_state']))
                    @php $state = $product->specifications[$letter . '_state']; @endphp
                    <div class="pdp-iso-card" style="--iso-accent: {{ $meta['bg'] }};">
                        <span class="pdp-iso-badge" style="background:{{ $meta['bg'] }}; color:{{ $meta['color'] }};">
                            {{ $letter }}
                        </span>
                        <strong class="pdp-iso-label">{{ $meta['label'] }}</strong>
                        <span style="font-size:0.75rem; color:var(--text-secondary); line-height:1.4; margin-bottom:1rem;">
                            {{ $meta['desc'] }}
                        </span>
                        <span class="pdp-iso-status {{ $state == 'optimal' ? 'optimal' : 'suitable' }}">
                            {{ $state == 'optimal' ? '★ Optimal Choice' : '✓ Suitable' }}
                        </span>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Full Width Technical Specifications Table --}}
@if(count($product->specs) > 0)
<section class="section-pad bg-white">
    <div class="container">
        <div style="margin-bottom:2rem;">
            <span class="section-label">Specifications</span>
            <h2 class="heading-1" style="color:var(--navy); margin-bottom:0.25rem;">Technical Specifications</h2>
            <p style="color:var(--text-secondary); font-size:0.925rem; margin:0;">Comprehensive engineering characteristics and tolerance ratings</p>
        </div>
        <div class="pdp-specs-card">
            <table class="pdp-specs-table">
                <tbody>
                    @foreach($product->specs as $index => $spec)
                        <tr>
                            <th>{{ $spec[0] }}</th>
                            <td>{{ $spec[1] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endif

{{-- Dimension Image --}}
@if(isset($product->specifications['dimension_image']))
<section class="section-pad bg-light" style="border-top:1px solid var(--border);">
    <div class="container">
        <div style="margin-bottom:2rem;">
            <span class="section-label">Dimensions</span>
            <h2 class="heading-1" style="color:var(--navy); margin-bottom:0.25rem;">Technical Drawings &amp; Geometry</h2>
            <p style="color:var(--text-secondary); font-size:0.925rem; margin:0;">Dimensional schematic and manufacturing reference geometry</p>
        </div>
        <div class="pdp-drawing-card">
            <img src="{{ $product->specifications['dimension_image'] }}" alt="Technical drawing for {{ $product->name }}" loading="lazy">
            <p class="pdp-drawing-note">
                * All dimensions are subject to standard engineering manufacturing tolerances according to DIN ISO 2768. 3D CAD step files available upon request.
            </p>
        </div>
    </div>
</section>
@endif

{{-- Dimensions & Variant Table --}}
@if(isset($product->specifications['dimensions']) && is_array($product->specifications['dimensions']) && count($product->specifications['dimensions']) > 0)
<section class="section-pad">
    <div class="container">
        <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:2rem; flex-wrap:wrap; gap:1.5rem;">
            <div>
                <span class="section-label">Inventory</span>
                <h2 class="heading-1" style="color:var(--navy); margin-bottom:0.25rem;">Available Dimensions &amp; Variants</h2>
                <p style="color:var(--text-secondary); font-size:0.925rem; margin:0;">Select standard stock items from the schedule below. Custom geometries available on order.</p>
            </div>
            <div class="pdp-table-search-wrap">
                <input type="text" id="dimensions-search" class="pdp-table-search-input" placeholder="Search SKU, Diameter, Shank..." aria-label="Search dimensions">
                <svg class="pdp-table-search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </div>

        <div class="pdp-variants-wrapper">
            <div class="pdp-table-scroll-wrap">
                <table class="pdp-variants-table" id="dimensions-table">
                    <thead>
                        @php
                            $firstRow = $product->specifications['dimensions'][0];
                            $headers = array_values(array_filter(array_keys($firstRow), function($h) {
                                $trimmed = trim($h);
                                if ($trimmed === '') return false;
                                return !in_array(strtolower($trimmed), ['recommendations', 'recommendation', 'add to cart', 'cart', 'action', 'actions']);
                            }));
                        @endphp
                        <tr>
                            @foreach($headers as $header)
                                <th>{{ $header }}</th>
                            @endforeach
                            <th style="text-align:right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($product->specifications['dimensions'] as $index => $row)
                            <tr class="dimension-row">
                                @foreach($headers as $header)
                                    <td>
                                        @if(strtoupper($header) === 'SKU')
                                            <span class="pdp-sku-badge">
                                                {{ $row[$header] }}
                                                <button type="button" class="pdp-sku-copy-btn" onclick="copySku('{{ $row[$header] }}', this)" title="Copy SKU" aria-label="Copy SKU">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                    </svg>
                                                </button>
                                            </span>
                                        @elseif(strtoupper($header) === 'PRICE')
                                            @php
                                                $priceVal = trim($row[$header] ?? '');
                                            @endphp
                                            @if(is_numeric($priceVal))
                                                <strong style="color:var(--navy);">£{{ number_format((float)$priceVal, 2) }}</strong>
                                            @elseif(Str::contains(strtolower($priceVal), ['see prices', 'log in', 'login', 'account', 'quotation', 'request']))
                                                <span class="pdp-poa-badge" title="{{ $priceVal }}">Price on Request</span>
                                            @else
                                                <span style="font-weight:600; color:var(--navy);">{{ Str::limit($priceVal, 22) }}</span>
                                            @endif
                                        @else
                                            <span style="font-weight:{{ in_array(strtolower($header), ['d1', 'diameter', 'nominal ø mm']) ? '600' : '400' }};">{{ $row[$header] }}</span>
                                        @endif
                                    </td>
                                @endforeach
                                <td>
                                    <a href="{{ route('contact', ['product' => $product->name, 'sku' => $row['SKU'] ?? '']) }}" class="pdp-enquire-link">
                                        Enquire Item →
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination Bar --}}
            <div class="pdp-pagination-bar">
                <span style="color:var(--text-secondary); font-weight:500;" id="pagination-info">Showing 1 to 10 of 0 entries</span>
                <div style="display:flex; gap:0.3rem; align-items:center;" id="pagination-buttons">
                    <!-- Buttons will be generated by JS -->
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    window.copySku = function(sku, btn) {
        if (!navigator.clipboard) return;
        navigator.clipboard.writeText(sku).then(() => {
            btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="#16a34a" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>`;
            setTimeout(() => {
                btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>`;
            }, 1800);
        });
    };

    const allRows = Array.from(document.querySelectorAll('.dimension-row'));
    const searchInput = document.getElementById('dimensions-search');
    const rowsPerPage = 10;
    let currentPage = 1;
    let filteredRows = [...allRows];

    function showPage(page) {
        currentPage = page;
        const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        // Hide all rows first
        allRows.forEach(row => row.style.display = 'none');

        // Show only matching filtered rows for the current page
        filteredRows.forEach((row, index) => {
            if (index >= start && index < end) {
                row.style.display = '';
            }
        });

        // Update info text
        const infoSpan = document.getElementById('pagination-info');
        if (filteredRows.length === 0) {
            infoSpan.innerHTML = 'No matching entries found';
        } else {
            const actualEnd = Math.min(end, filteredRows.length);
            infoSpan.innerHTML = `Showing <strong>${start + 1}</strong> to <strong>${actualEnd}</strong> of <strong>${filteredRows.length}</strong> entries`;
        }

        renderButtons(totalPages);
    }

    function renderButtons(totalPages) {
        const container = document.getElementById('pagination-buttons');
        container.innerHTML = '';

        if (totalPages <= 1) return;

        // Previous button
        const prevBtn = document.createElement('button');
        prevBtn.innerText = '‹ Previous';
        prevBtn.disabled = currentPage === 1;
        styleButton(prevBtn, currentPage === 1);
        prevBtn.addEventListener('click', () => {
            if (currentPage > 1) showPage(currentPage - 1);
        });
        container.appendChild(prevBtn);

        // Page number buttons
        for (let i = 1; i <= totalPages; i++) {
            const pageBtn = document.createElement('button');
            pageBtn.innerText = i;
            const isActive = i === currentPage;
            styleButton(pageBtn, false, isActive);
            pageBtn.addEventListener('click', () => showPage(i));
            container.appendChild(pageBtn);
        }

        // Next button
        const nextBtn = document.createElement('button');
        nextBtn.innerText = 'Next ›';
        nextBtn.disabled = currentPage === totalPages;
        styleButton(nextBtn, currentPage === totalPages);
        nextBtn.addEventListener('click', () => {
            if (currentPage < totalPages) showPage(currentPage + 1);
        });
        container.appendChild(nextBtn);
    }

    function styleButton(btn, disabled, active) {
        btn.style.padding = '0.4rem 0.85rem';
        btn.style.fontSize = '0.825rem';
        btn.style.fontWeight = '600';
        btn.style.border = '1px solid var(--border)';
        btn.style.borderRadius = 'var(--radius-sm)';
        btn.style.cursor = disabled ? 'not-allowed' : 'pointer';
        btn.style.margin = '0 0.15rem';
        btn.style.transition = 'all 0.2s ease';
        
        if (active) {
            btn.style.background = 'var(--navy)';
            btn.style.color = '#ffffff';
            btn.style.borderColor = 'var(--navy)';
        } else if (disabled) {
            btn.style.background = '#f8fafc';
            btn.style.color = '#cbd5e1';
            btn.style.borderColor = 'var(--border)';
        } else {
            btn.style.background = '#ffffff';
            btn.style.color = 'var(--text-secondary)';
            btn.style.borderColor = 'var(--border)';
            
            btn.onmouseenter = () => {
                btn.style.borderColor = 'var(--navy)';
                btn.style.color = 'var(--navy)';
                btn.style.background = '#f8fafc';
            };
            btn.onmouseleave = () => {
                btn.style.borderColor = 'var(--border)';
                btn.style.color = 'var(--text-secondary)';
                btn.style.background = '#ffffff';
            };
        }
    }

    // Real-time search filter handler
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const term = searchInput.value.toLowerCase().trim();
            
            if (term === '') {
                filteredRows = [...allRows];
            } else {
                filteredRows = allRows.filter(row => {
                    return Array.from(row.querySelectorAll('td')).some(td => {
                        return td.textContent.toLowerCase().includes(term);
                    });
                });
            }
            
            showPage(1);
        });
    }

    // Initialize
    if (allRows.length > 0) {
        showPage(1);
    }
});
</script>
@endif

{{-- Related Products Slider --}}
@if($relatedProducts->count() > 0)
<section class="section-pad bg-light related-slider-section" style="border-top:1px solid var(--border);">
    <div class="container">
        {{-- Section Header --}}
        <div class="related-slider-header">
            <div>
                <span class="section-label" style="display:inline-block; margin-bottom:0.35rem;">Related</span>
                <h2 class="heading-1" style="color:var(--navy); margin-bottom:0.3rem;">Related Products</h2>
                <p style="color:var(--text-secondary); font-size:0.875rem; margin:0;">Explore precision engineering components and tooling in this category</p>
            </div>
        </div>

        {{-- Slider Viewport --}}
        <div class="related-slider-container">
            <div class="related-slider-track" id="relatedSliderTrack" tabindex="0" role="region" aria-label="Related Products Carousel">
                @foreach($relatedProducts as $relProduct)
                    <div class="related-slider-slide">
                        <article class="product-card" data-category="{{ $relProduct->category }}">
                            <a href="{{ route('products.show', $relProduct->slug) }}" class="product-card-image" aria-label="{{ $relProduct->name }}">
                                <img src="{{ asset(Str::startsWith($relProduct->image ?? '', 'http') ? $relProduct->image : 'images/' . ($relProduct->image ?? 'hero-engineering.png')) }}" alt="{{ $relProduct->name }}" loading="lazy">
                            </a>
                            <div class="product-card-body">
                                <span class="product-card-category-tag">{{ $relProduct->category }}</span>
                                <h3 class="product-card-name">
                                    <a href="{{ route('products.show', $relProduct->slug) }}">
                                        {{ $relProduct->name }}
                                    </a>
                                </h3>
                                <p class="product-card-desc">
                                    {{ Str::limit($relProduct->description, 75) }}
                                </p>
                                <div class="product-card-footer">
                                    @php
                                        $relVariantCount = isset($relProduct->specifications['dimensions']) && is_array($relProduct->specifications['dimensions']) ? count($relProduct->specifications['dimensions']) : 0;
                                    @endphp
                                    @if($relVariantCount > 0)
                                        <span class="product-card-spec-meta">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
                                            </svg>
                                            {{ $relVariantCount }} Sizes
                                        </span>
                                    @else
                                        <span class="product-card-spec-meta">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                            DIN / ISO
                                        </span>
                                    @endif
                                    <a href="{{ route('products.show', $relProduct->slug) }}" class="btn btn-sm btn-accent-outline" style="padding:0.35rem 0.85rem; font-size:0.78rem;">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Dots Indicators --}}
        <div class="related-slider-dots" id="relatedSliderDots" aria-label="Slider navigation dots"></div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const track = document.getElementById('relatedSliderTrack');
    if (!track) return;

    const dotsContainer = document.getElementById('relatedSliderDots');
    const slides = track.querySelectorAll('.related-slider-slide');

    if (slides.length === 0) return;

    function getCardStep() {
        const firstSlide = slides[0];
        if (!firstSlide) return 320;
        // Slide width + gap (24px gap is 1.5rem)
        const style = window.getComputedStyle(track);
        const gap = parseFloat(style.columnGap || style.gap) || 24;
        return firstSlide.getBoundingClientRect().width + gap;
    }

    function getVisibleCount() {
        const trackWidth = track.clientWidth;
        const cardStep = getCardStep();
        return Math.max(1, Math.round(trackWidth / cardStep));
    }

    function getTotalPages() {
        const visible = getVisibleCount();
        return Math.max(1, Math.ceil(slides.length / visible));
    }

    function getCurrentPage() {
        const visible = getVisibleCount();
        const cardStep = getCardStep();
        const index = Math.round(track.scrollLeft / cardStep);
        const page = Math.floor(index / visible) + 1;
        const total = getTotalPages();
        return Math.min(Math.max(1, page), total);
    }

    // Build Dots
    function buildDots() {
        dotsContainer.innerHTML = '';
        const total = getTotalPages();

        if (total <= 1) {
            dotsContainer.style.display = 'none';
            return;
        } else {
            dotsContainer.style.display = 'flex';
        }

        for (let i = 1; i <= total; i++) {
            const dot = document.createElement('button');
            dot.className = 'related-slider-dot' + (i === 1 ? ' active' : '');
            dot.setAttribute('aria-label', 'Go to page ' + i);
            dot.addEventListener('click', function() {
                const visible = getVisibleCount();
                const cardStep = getCardStep();
                const targetScroll = (i - 1) * visible * cardStep;
                track.scrollTo({ left: targetScroll, behavior: 'smooth' });
            });
            dotsContainer.appendChild(dot);
        }
    }

    function updateNavState() {
        const page = getCurrentPage();

        const dots = dotsContainer.querySelectorAll('.related-slider-dot');
        dots.forEach((dot, idx) => {
            dot.classList.toggle('active', (idx + 1) === page);
        });
    }

    buildDots();
    updateNavState();

    let scrollTimeout;
    track.addEventListener('scroll', function() {
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(updateNavState, 60);
    }, { passive: true });

    window.addEventListener('resize', function() {
        buildDots();
        updateNavState();
    });

    // Keyboard accessibility
    track.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowRight') {
            const cardStep = getCardStep();
            track.scrollBy({ left: cardStep, behavior: 'smooth' });
        } else if (e.key === 'ArrowLeft') {
            const cardStep = getCardStep();
            track.scrollBy({ left: -cardStep, behavior: 'smooth' });
        }
    });

    // Drag to scroll functionality
    let isDown = false;
    let startX = 0;
    let scrollStart = 0;
    let isDragging = false;

    track.addEventListener('mousedown', function(e) {
        // Only left mouse button
        if (e.button !== 0) return;
        isDown = true;
        isDragging = false;
        track.classList.add('is-dragging');
        startX = e.pageX - track.offsetLeft;
        scrollStart = track.scrollLeft;
    });

    window.addEventListener('mousemove', function(e) {
        if (!isDown) return;
        const x = e.pageX - track.offsetLeft;
        const walk = x - startX;
        if (Math.abs(walk) > 6) {
            isDragging = true;
        }
        track.scrollLeft = scrollStart - walk;
    });

    window.addEventListener('mouseup', function(e) {
        if (!isDown) return;
        isDown = false;
        track.classList.remove('is-dragging');
        setTimeout(() => { isDragging = false; }, 50);
    });

    // Prevent link click while dragging
    track.querySelectorAll('a').forEach(function(link) {
        link.addEventListener('click', function(e) {
            if (isDragging) {
                e.preventDefault();
                e.stopPropagation();
            }
        });
    });

    // Gentle Autoplay (pauses on hover)
    let autoPlayTimer = null;
    function startAutoPlay() {
        stopAutoPlay();
        autoPlayTimer = setInterval(function() {
            const maxScroll = track.scrollWidth - track.clientWidth - 10;
            if (track.scrollLeft >= maxScroll) {
                track.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                const cardStep = getCardStep();
                track.scrollBy({ left: cardStep, behavior: 'smooth' });
            }
        }, 3000);
    }

    function stopAutoPlay() {
        if (autoPlayTimer) {
            clearInterval(autoPlayTimer);
            autoPlayTimer = null;
        }
    }

    track.addEventListener('mouseenter', stopAutoPlay);
    track.addEventListener('mouseleave', startAutoPlay);
    track.addEventListener('touchstart', stopAutoPlay, { passive: true });

    startAutoPlay();
});
</script>
@endif

@endsection
