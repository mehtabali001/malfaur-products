@extends('layouts.admin')

@section('title', 'Edit Category: ' . $category->name)
@section('page-title', 'Edit Category')

@section('content')

<div style="max-width: 800px; margin: 0 auto;">
    <div style="margin-bottom: 1.25rem;">
        <a href="{{ route('admin.categories.index') }}" class="admin-btn admin-btn-outline admin-btn-sm">
            ← Back to Category Tree
        </a>
    </div>

    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <h2 class="admin-card-title">Edit Category: {{ $category->name }}</h2>
                <p style="font-size:0.8rem;color:var(--admin-text-muted);margin:0.25rem 0 0;">
                    Currently at <strong>Level {{ $category->level }}</strong> ({{ $category->breadcrumb_path }})
                </p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.categories.update', $category->id) }}">
            @csrf
            @method('PUT')

            <!-- Parent Category Hierarchy Selector -->
            <div class="form-group" style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 8px; padding: 1.25rem; margin-bottom: 1.5rem;">
                <label class="form-label" for="parent_id" style="font-size: 0.9rem; font-weight: 700; color: #0F172A;">
                    Parent Category (Nesting Tree Position)
                </label>
                <p style="font-size: 0.78rem; color: #64748B; margin: 0 0 0.75rem;">
                    Re-parenting will automatically adjust the depth level for this category and any of its child subcategories.
                </p>
                <select name="parent_id" id="parent_id" class="form-control" style="font-family: monospace; font-size: 0.88rem; padding: 0.65rem 0.85rem;" onchange="updateLevelPreview()">
                    <option value="" data-level="1" {{ empty($category->parent_id) ? 'selected' : '' }}>
                        [ROOT LEVEL 1] None (Top-Level Root Category)
                    </option>
                    @foreach($selectTree as $item)
                        <option value="{{ $item['id'] }}" data-level="{{ min(4, $item['level'] + 1) }}" {{ $category->parent_id == $item['id'] ? 'selected' : '' }}>
                            {{ $item['display'] }} (Current: Level {{ $item['level'] }})
                        </option>
                    @endforeach
                </select>

                <div id="levelPreviewBox" style="margin-top: 0.75rem; font-size: 0.8rem; padding: 0.5rem 0.75rem; border-radius: 6px; background: #EEF2FF; color: #3730A3; font-weight: 600; display: inline-flex; align-items: center; gap: 0.4rem;">
                    <span id="levelPreviewText">Depth Level: Level {{ $category->level }}</span>
                </div>
            </div>

            <!-- Category Name & Slug -->
            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label" for="name">Category Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required class="form-control" autofocus>
                </div>

                <div class="form-group">
                    <label class="form-label" for="slug">URL Slug</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug', $category->slug) }}" class="form-control" style="font-family: monospace;">
                </div>
            </div>

            <!-- Color Accent & Sort Order -->
            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label" for="color">Theme Color Accent</label>
                    <select name="color" id="color" class="form-control">
                        @foreach($colors as $val => $lbl)
                            <option value="{{ $val }}" {{ old('color', $category->color) == $val ? 'selected' : '' }}>{{ $lbl }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="sort_order">Sort Order</label>
                    <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" class="form-control">
                </div>
            </div>

            <!-- Description -->
            <div class="form-group">
                <label class="form-label" for="description">Short Description (Optional)</label>
                <textarea id="description" name="description" rows="3" class="form-control">{{ old('description', $category->description) }}</textarea>
            </div>

            <!-- Is Active -->
            <div class="form-group" style="margin-top: 1rem;">
                <label style="display: flex; align-items: center; gap: 0.6rem; cursor: pointer;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }} style="width: 16px; height: 16px; accent-color: var(--admin-accent);">
                    <span style="font-size: 0.85rem; font-weight: 600; color: #1E293B;">Active &amp; Visible in Mega-Menu</span>
                </label>
            </div>

            <div style="margin-top: 2rem; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #E2E8F0; padding-top: 1.25rem;">
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <button type="submit" class="admin-btn admin-btn-accent" style="padding: 0.65rem 1.4rem;">
                        <span>Update Category</span>
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="admin-btn admin-btn-outline">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function updateLevelPreview() {
        const sel = document.getElementById('parent_id');
        const opt = sel.options[sel.selectedIndex];
        const nextLevel = opt.getAttribute('data-level') || 1;
        const preview = document.getElementById('levelPreviewText');
        const box = document.getElementById('levelPreviewBox');
        
        const labels = {
            '1': 'Resulting Depth: Level 1 (Top-Level Root Category)',
            '2': 'Resulting Depth: Level 2 (Subcategory)',
            '3': 'Resulting Depth: Level 3 (Sub-Subcategory)',
            '4': 'Resulting Depth: Level 4 (Series / Leaf Node)'
        };

        const bgColors = {
            '1': '#EEF2FF',
            '2': '#ECFDF5',
            '3': '#FEF3C7',
            '4': '#F3E8FF'
        };

        const textColors = {
            '1': '#3730A3',
            '2': '#065F46',
            '3': '#92400E',
            '4': '#6B21A8'
        };

        preview.innerText = labels[nextLevel] || `Resulting Depth: Level ${nextLevel}`;
        box.style.background = bgColors[nextLevel] || '#EEF2FF';
        box.style.color = textColors[nextLevel] || '#3730A3';
    }

    updateLevelPreview();
</script>

@endsection
