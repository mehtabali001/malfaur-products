@extends('layouts.admin')

@section('title', 'Add New Product')
@section('page-title', 'Add New Product')

@section('content')
<div style="max-width: 900px; margin: 0 auto;">
    <div style="margin-bottom: 1rem;">
        <a href="{{ route('admin.products.index') }}" style="color: var(--admin-text-muted); text-decoration: none; font-size: 0.84rem; display: inline-flex; align-items: center; gap: 0.35rem;">
            ← Back to Products List
        </a>
    </div>

    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <h2 class="admin-card-title">Create New Product</h2>
                <p style="font-size:0.8rem;color:var(--admin-text-muted);margin:0.25rem 0 0;">Add a new engineering product with custom technical specifications and images.</p>
            </div>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label" for="title">Product Title / Name *</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required class="form-control" placeholder="e.g., Solid Carbide End Mill 4-Flute">
                </div>

                <div class="form-group">
                    <label class="form-label" for="category_id">Category / Subcategory *</label>
                    <select id="category_id" name="category_id" required class="form-control" style="font-family: monospace; font-size: 0.86rem;" onchange="updateProductCategoryPath()">
                        <option value="">-- Select Category from Tree --</option>
                        @foreach($selectTree as $item)
                            <option value="{{ $item['id'] }}" data-path="{{ $item['breadcrumb'] }}" data-level="{{ $item['level'] }}" {{ old('category_id') == $item['id'] ? 'selected' : '' }}>
                                {{ $item['display'] }} (Level {{ $item['level'] }})
                            </option>
                        @endforeach
                    </select>
                    <div id="catBreadcrumbPreview" style="margin-top: 0.35rem; font-size: 0.76rem; color: #475569; font-weight: 500;">
                        Selected Path: <span id="catPathText" style="color: #0F172A; font-weight: 700;">Please select a category</span>
                    </div>
                </div>
            </div>

            <script>
                function updateProductCategoryPath() {
                    const sel = document.getElementById('category_id');
                    const opt = sel.options[sel.selectedIndex];
                    const path = opt.getAttribute('data-path') || 'Please select a category';
                    document.getElementById('catPathText').innerText = path;
                }
                document.addEventListener('DOMContentLoaded', updateProductCategoryPath);
            </script>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label" for="slug">Custom URL Slug (optional)</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug') }}" class="form-control" placeholder="auto-generated-from-title">
                    <span style="font-size: 0.72rem; color: #94A3B8;">Leave empty to automatically generate from product title.</span>
                </div>

                <div class="form-group">
                    <label class="form-label">Product Image</label>
                    <input type="file" name="image_file" class="form-control" accept="image/*" style="padding: 0.45rem 0.75rem;">
                    <div style="margin-top: 0.35rem;">
                        <span style="font-size: 0.72rem; color: #94A3B8;">Or specify image path/URL:</span>
                        <input type="text" name="image_url" value="{{ old('image_url') }}" placeholder="e.g. hero-engineering.png" class="form-control" style="font-size: 0.78rem; padding: 0.35rem 0.6rem; margin-top: 0.2rem;">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="short_description">Short Summary</label>
                <input type="text" id="short_description" name="short_description" value="{{ old('short_description') }}" class="form-control" placeholder="A brief one-line summary for product cards and meta descriptions">
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Full Product Description *</label>
                <textarea id="description" name="description" rows="5" required class="form-control" placeholder="Provide full details, precision tolerances, typical industrial applications, and compliance standards...">{{ old('description') }}</textarea>
            </div>

            <!-- Dynamic Specifications Builder -->
            <div class="form-group" style="margin-top: 1.75rem; border-top: 1px solid #E2E8F0; padding-top: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.85rem;">
                    <div>
                        <label class="form-label" style="margin: 0; font-size: 0.95rem;">Technical Specifications (Key - Value Pairs)</label>
                        <p style="font-size: 0.75rem; color: #64748B; margin: 0.15rem 0 0;">These appear in the interactive technical table on the product details page.</p>
                    </div>
                    <button type="button" id="add-spec-btn" class="admin-btn admin-btn-outline admin-btn-sm">
                        + Add Spec Row
                    </button>
                </div>

                <div id="specs-container" style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <div class="spec-row" style="display: flex; gap: 0.75rem; align-items: center;">
                        <input type="text" name="spec_keys[]" value="Material" placeholder="Property / Spec Name (e.g., Material)" class="form-control" style="flex: 1;">
                        <input type="text" name="spec_values[]" value="Micrograin Solid Carbide" placeholder="Value (e.g., Micrograin Solid Carbide)" class="form-control" style="flex: 1.5;">
                        <button type="button" class="remove-spec-btn admin-btn admin-btn-danger admin-btn-sm" style="padding: 0.5rem 0.65rem;">✕</button>
                    </div>
                    <div class="spec-row" style="display: flex; gap: 0.75rem; align-items: center;">
                        <input type="text" name="spec_keys[]" value="Coating" placeholder="Property / Spec Name (e.g., Coating)" class="form-control" style="flex: 1;">
                        <input type="text" name="spec_values[]" value="AlTiN (Titanium Aluminium Nitride)" placeholder="Value" class="form-control" style="flex: 1.5;">
                        <button type="button" class="remove-spec-btn admin-btn admin-btn-danger admin-btn-sm" style="padding: 0.5rem 0.65rem;">✕</button>
                    </div>
                    <div class="spec-row" style="display: flex; gap: 0.75rem; align-items: center;">
                        <input type="text" name="spec_keys[]" value="Tolerance" placeholder="Property / Spec Name" class="form-control" style="flex: 1;">
                        <input type="text" name="spec_values[]" value="h6 precision ground" placeholder="Value" class="form-control" style="flex: 1.5;">
                        <button type="button" class="remove-spec-btn admin-btn admin-btn-danger admin-btn-sm" style="padding: 0.5rem 0.65rem;">✕</button>
                    </div>
                </div>
            </div>

            <div style="display: flex; gap: 0.75rem; justify-content: flex-end; margin-top: 2rem; border-top: 1px solid #E2E8F0; padding-top: 1.25rem;">
                <a href="{{ route('admin.products.index') }}" class="admin-btn admin-btn-outline">Cancel</a>
                <button type="submit" class="admin-btn admin-btn-accent" style="padding: 0.65rem 1.5rem; font-size: 0.9rem;">
                    Save & Publish Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('admin-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('specs-container');
        const addBtn = document.getElementById('add-spec-btn');

        addBtn.addEventListener('click', function() {
            const row = document.createElement('div');
            row.className = 'spec-row';
            row.style = 'display: flex; gap: 0.75rem; align-items: center; animation: megaFadeIn 0.2s ease;';
            row.innerHTML = `
                <input type="text" name="spec_keys[]" placeholder="Property (e.g. Standard)" class="form-control" style="flex: 1;">
                <input type="text" name="spec_values[]" placeholder="Value (e.g. DIN 6527)" class="form-control" style="flex: 1.5;">
                <button type="button" class="remove-spec-btn admin-btn admin-btn-danger admin-btn-sm" style="padding: 0.5rem 0.65rem;">✕</button>
            `;
            container.appendChild(row);
        });

        container.addEventListener('click', function(e) {
            if (e.target.closest('.remove-spec-btn')) {
                const rows = container.querySelectorAll('.spec-row');
                if (rows.length > 1) {
                    e.target.closest('.spec-row').remove();
                } else {
                    const inputs = rows[0].querySelectorAll('input');
                    inputs.forEach(input => input.value = '');
                }
            }
        });
    });
</script>
@endpush
