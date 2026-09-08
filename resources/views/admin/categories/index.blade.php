@extends('layouts.admin')

@section('title', 'Category Tree Management')
@section('page-title', 'Category Tree Hierarchy')

@section('content')

<style>
    .cat-tree-stats {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .cat-stat-card {
        background: #FFFFFF;
        border: 1px solid var(--admin-border);
        border-radius: 10px;
        padding: 1rem 1.25rem;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
    }
    .cat-stat-num {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--admin-text-main);
        line-height: 1;
    }
    .cat-stat-label {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--admin-text-muted);
        margin-top: 0.35rem;
    }

    .tree-table {
        width: 100%;
        border-collapse: collapse;
    }
    .tree-table th {
        background: #F8FAFC;
        padding: 0.75rem 1rem;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #475569;
        border-bottom: 1px solid var(--admin-border);
        text-align: left;
    }
    .tree-table td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #F1F5F9;
        vertical-align: middle;
        font-size: 0.84rem;
    }
    .tree-table tr:hover td {
        background: #F8FAFC;
    }

    /* Level Indentation Styles */
    .tree-node-level-1 {
        background: #FFFFFF;
        font-weight: 700;
    }
    .tree-node-level-1 td {
        border-top: 1px solid #E2E8F0;
        background: #FAFCFF;
    }
    .tree-node-level-2 td {
        padding-left: 2.2rem;
    }
    .tree-node-level-3 td {
        padding-left: 3.8rem;
    }
    .tree-node-level-4 td {
        padding-left: 5.4rem;
    }

    .level-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.15rem 0.5rem;
        border-radius: 999px;
        font-size: 0.68rem;
        font-weight: 700;
    }
    .lvl-1 { background: #EEF2FF; color: #3730A3; border: 1px solid #C7D2FE; }
    .lvl-2 { background: #ECFDF5; color: #065F46; border: 1px solid #A7F3D0; }
    .lvl-3 { background: #FEF3C7; color: #92400E; border: 1px solid #FDE68A; }
    .lvl-4 { background: #F3E8FF; color: #6B21A8; border: 1px solid #E9D5FF; }

    .color-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        flex-shrink: 0;
    }
    .dot-orange { background-color: #F97316; }
    .dot-blue   { background-color: #3B82F6; }
    .dot-green  { background-color: #10B981; }
    .dot-purple { background-color: #8B5CF6; }
    .dot-amber  { background-color: #EAB308; }
    .dot-slate  { background-color: #64748B; }

    .tree-branch-line {
        color: #94A3B8;
        font-family: monospace;
        font-size: 0.95rem;
        margin-right: 0.35rem;
        user-select: none;
    }
</style>

<!-- Stats Grid -->
<div class="cat-tree-stats">
    <div class="cat-stat-card">
        <div class="cat-stat-num">{{ $totalCount }}</div>
        <div class="cat-stat-label">Total Categories</div>
    </div>
    <div class="cat-stat-card">
        <div class="cat-stat-num" style="color: #3730A3;">{{ $level1Count }}</div>
        <div class="cat-stat-label">Level 1 Roots</div>
    </div>
    <div class="cat-stat-card">
        <div class="cat-stat-num" style="color: #065F46;">{{ $level2Count }}</div>
        <div class="cat-stat-label">Level 2 Subcategories</div>
    </div>
    <div class="cat-stat-card">
        <div class="cat-stat-num" style="color: #92400E;">{{ $level3Count }}</div>
        <div class="cat-stat-label">Level 3 Sub-Sub</div>
    </div>
    <div class="cat-stat-card">
        <div class="cat-stat-num" style="color: #6B21A8;">{{ $level4Count }}</div>
        <div class="cat-stat-label">Level 4 Series</div>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header" style="flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 class="admin-card-title">Category Tree Structure</h2>
            <p style="font-size:0.8rem;color:var(--admin-text-muted);margin:0.25rem 0 0;">
                Organize your catalogue in a 1 to 4 level hierarchy. Assign subcategories to parents and products to any level.
            </p>
        </div>
        <div style="display:flex;align-items:center;gap:0.75rem;">
            <a href="{{ route('admin.categories.create') }}" class="admin-btn admin-btn-accent">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>Add Root Category (Level 1)</span>
            </a>
        </div>
    </div>

    <!-- Search Form -->
    <form method="GET" action="{{ route('admin.categories.index') }}" style="display: flex; gap: 0.75rem; margin-bottom: 1.25rem;">
        <div style="flex: 1; position: relative;">
            <input type="text" name="search" value="{{ $search }}" placeholder="Search categories by name or slug..." class="form-control" style="padding-left: 2.2rem;">
            <svg style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); width: 15px; height: 15px; color: #94A3B8;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        </div>
        <button type="submit" class="admin-btn admin-btn-primary">Search</button>
        @if($isSearching)
            <a href="{{ route('admin.categories.index') }}" class="admin-btn admin-btn-outline">Clear</a>
        @endif
    </form>

    @if($isSearching)
        <!-- Search Results Flat View -->
        <div style="margin-bottom: 1rem; font-size: 0.85rem; color: #64748B;">
            Found <strong>{{ $searchResults->count() }}</strong> matching categories:
        </div>
        <div class="admin-table-wrap">
            <table class="tree-table">
                <thead>
                    <tr>
                        <th>Category Name</th>
                        <th>Hierarchy Level</th>
                        <th>Full Breadcrumb Path</th>
                        <th>Products</th>
                        <th style="text-align: right; width: 180px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($searchResults as $cat)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <span class="color-dot dot-{{ $cat->color ?? 'amber' }}"></span>
                                    <strong>{{ $cat->name }}</strong>
                                </div>
                                <div style="font-size: 0.72rem; color: #64748B; font-family: monospace;">/{{ $cat->slug }}</div>
                            </td>
                            <td>
                                <span class="level-badge lvl-{{ $cat->level }}">Level {{ $cat->level }}</span>
                            </td>
                            <td style="font-size: 0.78rem; color: #475569;">
                                {{ $cat->breadcrumb_path }}
                            </td>
                            <td>
                                <span class="badge badge-blue">{{ $cat->products_count }} items</span>
                            </td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; gap: 0.4rem; justify-content: flex-end;">
                                    @if($cat->level < 4)
                                        <a href="{{ route('admin.categories.create', ['parent_id' => $cat->id]) }}" class="admin-btn admin-btn-accent admin-btn-sm" title="Add Subcategory">
                                            + Sub
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.categories.edit', $cat->id) }}" class="admin-btn admin-btn-outline admin-btn-sm">
                                        Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 2rem; color: #64748B;">
                                No categories match your search.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @else
        <!-- Hierarchical Recursive Tree Table -->
        <div class="admin-table-wrap">
            <table class="tree-table">
                <thead>
                    <tr>
                        <th style="min-width: 280px;">Category Hierarchy</th>
                        <th>Depth Level</th>
                        <th>URL Slug</th>
                        <th>Assigned Products</th>
                        <th style="text-align: right; min-width: 200px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rootCategories as $root)
                        {{-- ── LEVEL 1 (ROOT) ── --}}
                        <tr class="tree-node-level-1">
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.6rem;">
                                    <span class="color-dot dot-{{ $root->color ?? 'amber' }}"></span>
                                    <span style="font-size: 0.95rem; color: #0F172A; font-weight: 800;">{{ $root->name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="level-badge lvl-1">Level 1 (Root)</span>
                            </td>
                            <td style="font-family: monospace; font-size: 0.75rem; color: #64748B;">
                                /{{ $root->slug }}
                            </td>
                            <td>
                                <span class="badge badge-blue">{{ $root->products_count }} direct products</span>
                            </td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; gap: 0.4rem; justify-content: flex-end;">
                                    <a href="{{ route('admin.categories.create', ['parent_id' => $root->id]) }}" class="admin-btn admin-btn-accent admin-btn-sm" title="Add Level 2 Subcategory">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                        <span>+ Subcategory</span>
                                    </a>
                                    <a href="{{ route('admin.categories.edit', $root->id) }}" class="admin-btn admin-btn-outline admin-btn-sm">
                                        Edit
                                    </a>
                                </div>
                            </td>
                        </tr>

                        {{-- ── LEVEL 2 (SUBCATEGORIES) ── --}}
                        @foreach($root->children as $sub)
                            <tr class="tree-node-level-2">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.4rem;">
                                        <span class="tree-branch-line">├─</span>
                                        <span class="color-dot dot-{{ $sub->color ?? $root->color }}" style="width: 8px; height: 8px;"></span>
                                        <span style="font-weight: 700; color: #1E293B;">{{ $sub->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="level-badge lvl-2">Level 2 (Sub)</span>
                                </td>
                                <td style="font-family: monospace; font-size: 0.75rem; color: #64748B;">
                                    /{{ $sub->slug }}
                                </td>
                                <td>
                                    <span class="badge badge-emerald">{{ $sub->products_count }} direct</span>
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: inline-flex; gap: 0.35rem; justify-content: flex-end;">
                                        <a href="{{ route('admin.categories.create', ['parent_id' => $sub->id]) }}" class="admin-btn admin-btn-primary admin-btn-sm" title="Add Level 3 Sub-subcategory">
                                            <span>+ Sub-Sub</span>
                                        </a>
                                        <a href="{{ route('admin.categories.edit', $sub->id) }}" class="admin-btn admin-btn-outline admin-btn-sm">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $sub->id) }}" method="POST" onsubmit="return confirm('Delete \'{{ addslashes($sub->name) }}\' and all nested categories?');" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">✕</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            {{-- ── LEVEL 3 (SUB-SUBCATEGORIES) ── --}}
                            @foreach($sub->children as $subSub)
                                <tr class="tree-node-level-3">
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 0.4rem;">
                                            <span class="tree-branch-line">│&nbsp;&nbsp;└─</span>
                                            <span style="color: #334155; font-weight: 600;">{{ $subSub->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="level-badge lvl-3">Level 3 (Sub-Sub)</span>
                                    </td>
                                    <td style="font-family: monospace; font-size: 0.75rem; color: #94A3B8;">
                                        /{{ $subSub->slug }}
                                    </td>
                                    <td>
                                        <span class="badge badge-amber">{{ $subSub->products_count }} direct</span>
                                    </td>
                                    <td style="text-align: right;">
                                        <div style="display: inline-flex; gap: 0.35rem; justify-content: flex-end;">
                                            <a href="{{ route('admin.categories.create', ['parent_id' => $subSub->id]) }}" class="admin-btn admin-btn-outline admin-btn-sm" style="font-size:0.72rem;padding:0.25rem 0.5rem;" title="Add Level 4 Series">
                                                <span>+ Series (L4)</span>
                                            </a>
                                            <a href="{{ route('admin.categories.edit', $subSub->id) }}" class="admin-btn admin-btn-outline admin-btn-sm">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.categories.destroy', $subSub->id) }}" method="POST" onsubmit="return confirm('Delete \'{{ addslashes($subSub->name) }}\'?');" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">✕</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                {{-- ── LEVEL 4 (SERIES / LEAF) ── --}}
                                @foreach($subSub->children as $leaf)
                                    <tr class="tree-node-level-4">
                                        <td>
                                            <div style="display: flex; align-items: center; gap: 0.4rem;">
                                                <span class="tree-branch-line">│&nbsp;&nbsp;&nbsp;&nbsp;└─</span>
                                                <span style="color: #64748B; font-weight: 500;">{{ $leaf->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="level-badge lvl-4">Level 4 (Series)</span>
                                        </td>
                                        <td style="font-family: monospace; font-size: 0.72rem; color: #CBD5E1;">
                                            /{{ $leaf->slug }}
                                        </td>
                                        <td>
                                            <span class="badge badge-purple">{{ $leaf->products_count }} items</span>
                                        </td>
                                        <td style="text-align: right;">
                                            <div style="display: inline-flex; gap: 0.35rem; justify-content: flex-end;">
                                                <a href="{{ route('admin.categories.edit', $leaf->id) }}" class="admin-btn admin-btn-outline admin-btn-sm">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.categories.destroy', $leaf->id) }}" method="POST" onsubmit="return confirm('Delete \'{{ addslashes($leaf->name) }}\'?');" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">✕</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection
