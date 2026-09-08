@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Overview Dashboard')

@section('content')

<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
        margin-bottom: 1.75rem;
    }
    .stat-card {
        background: #FFFFFF;
        border: 1px solid var(--admin-border);
        border-radius: 12px;
        padding: 1.25rem 1.4rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .stat-val {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--admin-text-main);
        line-height: 1.1;
    }
    .stat-label {
        font-size: 0.78rem;
        color: var(--admin-text-muted);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-top: 0.25rem;
    }
    .stat-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .icon-navy { background: #EEF2FF; color: #4338CA; }
    .icon-amber { background: #FEF3C7; color: #D97706; }
    .icon-emerald { background: #ECFDF5; color: #059669; }
    .icon-purple { background: #FAF5FF; color: #7E22CE; }

    .dashboard-grid-2 {
        display: grid;
        grid-template-columns: 1.4fr 1fr;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .cat-bar-row {
        margin-bottom: 0.85rem;
    }
    .cat-bar-header {
        display: flex;
        justify-content: space-between;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    .cat-bar-track {
        height: 7px;
        background: #F1F5F9;
        border-radius: 999px;
        overflow: hidden;
    }
    .cat-bar-fill {
        height: 100%;
        background: var(--admin-navy);
        border-radius: 999px;
    }
</style>

{{-- ── 4 KEY METRICS ── --}}
<div class="stats-grid">
    <div class="stat-card">
        <div>
            <div class="stat-val">{{ $totalProducts }}</div>
            <div class="stat-label">Total Products</div>
        </div>
        <div class="stat-icon icon-navy">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        </div>
    </div>

    <div class="stat-card">
        <div>
            <div class="stat-val" style="color:#D97706;">{{ $newEnquiries }}</div>
            <div class="stat-label">New Enquiries</div>
        </div>
        <div class="stat-icon icon-amber">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
    </div>

    <div class="stat-card">
        <div>
            <div class="stat-val">{{ $totalEnquiries }}</div>
            <div class="stat-label">Total Leads Received</div>
        </div>
        <div class="stat-icon icon-emerald">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
        </div>
    </div>

    <div class="stat-card">
        <div>
            <div class="stat-val">5</div>
            <div class="stat-label">Core Categories</div>
        </div>
        <div class="stat-icon icon-purple">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
        </div>
    </div>
</div>

<div class="dashboard-grid-2">
    {{-- Recent Products --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="admin-card-title">Recently Added Products</h2>
            <a href="{{ route('admin.products.index') }}" class="admin-btn admin-btn-outline admin-btn-sm">View All Products →</a>
        </div>
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Specs</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentProducts as $p)
                    @php
                        $pImg = $p->image ?: 'hero-engineering.png';
                        if (!str_starts_with($pImg, 'http') && !str_starts_with($pImg, 'images/')) {
                            $pImg = 'images/' . $pImg;
                        }
                        $pSpecs = is_array($p->specs) ? $p->specs : [];
                    @endphp
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:0.75rem;">
                                <img src="{{ asset($pImg) }}" style="width:36px;height:36px;object-fit:cover;border-radius:6px;border:1px solid #e2e8f0;background:#f8fafc;" onerror="this.src='{{ asset('images/hero-engineering.png') }}'">
                                <div>
                                    <div style="font-weight:600;color:var(--admin-text-main);">{{ $p->name }}</div>
                                    <div style="font-size:0.72rem;color:var(--admin-text-muted);">{{ $p->slug }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-slate">{{ $p->category }}</span>
                        </td>
                        <td>
                            <span style="font-size:0.75rem;color:var(--admin-text-muted);">{{ count($pSpecs) }} items</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.products.edit', $p->id) }}" class="admin-btn admin-btn-outline admin-btn-sm">Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align:center;color:var(--admin-text-muted);padding:2rem;">No products in database yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Category Distribution Breakdown --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="admin-card-title">Category Breakdown</h2>
            <span style="font-size:0.75rem;color:var(--admin-text-muted);">{{ $totalProducts }} total items</span>
        </div>
        <div>
            @foreach($categoriesCount as $catName => $count)
            @php
                $pct = $totalProducts > 0 ? round(($count / $totalProducts) * 100) : 0;
            @endphp
            <div class="cat-bar-row">
                <div class="cat-bar-header">
                    <span>{{ $catName }}</span>
                    <span><strong>{{ $count }}</strong> ({{ $pct }}%)</span>
                </div>
                <div class="cat-bar-track">
                    <div class="cat-bar-fill" style="width: {{ $pct }}%;"></div>
                </div>
            </div>
            @endforeach
        </div>
        <div style="margin-top:1.5rem;padding-top:1rem;border-top:1px solid var(--admin-border);display:flex;gap:0.5rem;">
            <a href="{{ route('admin.products.create') }}" class="admin-btn admin-btn-accent admin-btn-sm" style="width:100%;justify-content:center;">+ Add Product to Catalogue</a>
        </div>
    </div>
</div>

{{-- Latest Customer Enquiries --}}
<div class="admin-card">
    <div class="admin-card-header">
        <h2 class="admin-card-title">Latest Customer Enquiries & Quotes</h2>
        <a href="{{ route('admin.enquiries.index') }}" class="admin-btn admin-btn-outline admin-btn-sm">Open Enquiries Inbox →</a>
    </div>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Product of Interest</th>
                    <th>Message Snippet</th>
                    <th>Status</th>
                    <th>Received</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentEnquiries as $enq)
                <tr>
                    <td>
                        <div style="font-weight:600;color:var(--admin-text-main);">{{ $enq->name }}</div>
                        <div style="font-size:0.75rem;color:var(--admin-text-muted);">{{ $enq->email }} {{ $enq->company ? '· ' . $enq->company : '' }}</div>
                    </td>
                    <td>
                        <span class="badge badge-amber">{{ $enq->product_category ?: 'General Enquiry' }}</span>
                    </td>
                    <td>
                        <div style="max-width:280px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-size:0.8rem;color:#475569;">
                            {{ $enq->message }}
                        </div>
                    </td>
                    <td>
                        <span class="badge {{ $enq->status_badge }}">{{ strtoupper($enq->status) }}</span>
                    </td>
                    <td style="font-size:0.75rem;color:var(--admin-text-muted);">
                        {{ $enq->created_at ? $enq->created_at->diffForHumans() : 'Just now' }}
                    </td>
                    <td>
                        <a href="{{ route('admin.enquiries.show', $enq->id) }}" class="admin-btn admin-btn-outline admin-btn-sm">View & Reply</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;color:var(--admin-text-muted);padding:2rem;">
                        No customer enquiries received yet. Quote requests submitted from the Contact page will appear here.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
