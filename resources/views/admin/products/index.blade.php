@extends('layouts.admin')

@section('title', 'Products Catalogue')
@section('page-title', 'Products Catalogue')

@section('content')
<div class="admin-card">
    <div class="admin-card-header" style="flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 class="admin-card-title">Manage Products</h2>
            <p style="font-size:0.8rem;color:var(--admin-text-muted);margin:0.25rem 0 0;">View, search, edit, or remove products from the Malfaur catalogue.</p>
        </div>
        <div style="display:flex;align-items:center;gap:0.75rem;">
            <a href="{{ route('admin.products.create') }}" class="admin-btn admin-btn-accent">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>Add Product</span>
            </a>
        </div>
    </div>

    <!-- Filters & Search Form -->
    <form method="GET" action="{{ route('admin.products.index') }}" style="display: flex; gap: 0.75rem; flex-wrap: wrap; margin-bottom: 1.25rem;">
        <div style="flex: 1; min-width: 240px; position: relative;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products by title, description, or slug..." class="form-control" style="padding-left: 2.2rem;">
            <svg style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); width: 15px; height: 15px; color: #94A3B8;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        </div>

        <div style="min-width: 260px;">
            <select name="category_id" class="form-control" onchange="this.form.submit()" style="font-family: monospace; font-size: 0.84rem;">
                <option value="all">All Categories &amp; Subcategories</option>
                @foreach($selectTree as $item)
                    <option value="{{ $item['id'] }}" {{ request('category_id') == $item['id'] ? 'selected' : '' }}>
                        {{ $item['display'] }} (L{{ $item['level'] }})
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="admin-btn admin-btn-primary">Filter</button>
        @if(request('search') || (request('category_id') && request('category_id') !== 'all') || (request('category') && request('category') !== 'all'))
            <a href="{{ route('admin.products.index') }}" class="admin-btn admin-btn-outline">Clear</a>
        @endif
    </form>

    <!-- Table of Products -->
    @if($products->count() > 0)
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 70px;">Image</th>
                        <th>Product Name</th>
                        <th>Category Hierarchy</th>
                        <th>Specifications</th>
                        <th>Created</th>
                        <th style="text-align: right; width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>
                                @php
                                    $imgSrc = $product->image;
                                    if (!str_starts_with($imgSrc, 'http') && !str_starts_with($imgSrc, 'images/')) {
                                        $imgSrc = 'images/' . $imgSrc;
                                    }
                                @endphp
                                <img src="{{ asset($imgSrc) }}" alt="{{ $product->name }}" style="width: 50px; height: 40px; object-fit: cover; border-radius: 6px; border: 1px solid #E2E8F0; background: #F8FAFC;" onerror="this.src='{{ asset('images/hero-engineering.png') }}'">
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #0F172A;">
                                    <a href="{{ route('products.show', $product->slug ?: $product->id) }}" target="_blank" style="color: inherit; text-decoration: none;" title="View on site">
                                        {{ $product->name }} <span style="font-size: 0.75rem; color: #94A3B8;">↗</span>
                                    </a>
                                </div>
                                <div style="font-size: 0.75rem; color: #64748B; font-family: monospace;">/products/{{ $product->slug }}</div>
                            </td>
                            <td>
                                @if($product->categoryItem)
                                    <span class="badge badge-{{ $product->categoryItem->color ?? 'blue' }}" style="font-size: 0.72rem;">
                                        {{ $product->categoryItem->name }}
                                    </span>
                                    <div style="font-size: 0.7rem; color: #64748B; margin-top: 0.2rem;" title="{{ $product->category_breadcrumb }}">
                                        {{ $product->category_breadcrumb }}
                                    </div>
                                @else
                                    <span class="badge badge-blue">{{ $product->category ?: 'General' }}</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $specCount = is_array($product->specs) ? count($product->specs) : 0;
                                @endphp
                                <span class="badge badge-slate" style="font-size: 0.75rem;">
                                    {{ $specCount }} spec{{ $specCount !== 1 ? 's' : '' }}
                                </span>
                            </td>
                            <td style="font-size: 0.78rem; color: #64748B;">
                                {{ $product->created_at ? $product->created_at->format('M d, Y') : '—' }}
                            </td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; gap: 0.4rem; justify-content: flex-end;">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="admin-btn admin-btn-outline admin-btn-sm" title="Edit Product">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        <span>Edit</span>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete \'{{ addslashes($product->name) }}\'? This action cannot be undone.');" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm" title="Delete Product">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div style="font-size: 0.82rem; color: #64748B; font-weight: 500;">
                Showing <strong>{{ $products->firstItem() }}</strong> to <strong>{{ $products->lastItem() }}</strong> of <strong>{{ $products->total() }}</strong> products
            </div>
            <div>
                {{ $products->links('admin.partials.pagination') }}
            </div>
        </div>
    @else
        <div style="text-align: center; padding: 3rem 1rem; color: #64748B;">
            <svg style="width: 48px; height: 48px; margin-bottom: 0.75rem; color: #CBD5E1;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            <h3 style="font-size: 1.1rem; color: #1E293B; margin: 0 0 0.25rem;">No products found</h3>
            <p style="font-size: 0.85rem; margin: 0 0 1rem;">Try adjusting your search criteria or add a new product.</p>
            <a href="{{ route('admin.products.create') }}" class="admin-btn admin-btn-accent">Add New Product</a>
        </div>
    @endif
</div>
@endsection
