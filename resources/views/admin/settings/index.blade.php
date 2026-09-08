@extends('layouts.admin')

@section('title', 'Website Settings & Branding')
@section('page-title', 'Website Settings & Branding')

@section('content')
<div style="max-width: 900px; margin: 0 auto;">
    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <h2 class="admin-card-title">Global Website Configuration</h2>
                <p style="font-size:0.8rem;color:var(--admin-text-muted);margin:0.25rem 0 0;">Update website branding (logo, favicon), contact information, and footer details across the entire site.</p>
            </div>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Branding Section -->
            <h3 style="font-size: 0.95rem; font-weight: 700; color: #0F172A; margin: 0 0 1rem; border-bottom: 1px solid #E2E8F0; padding-bottom: 0.5rem;">
                🎨 Visual Branding (Logo & Favicon)
            </h3>

            <div class="form-grid-2" style="margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label class="form-label">Website Logo</label>
                    <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 0.5rem; background: #081528; padding: 0.75rem 1rem; border-radius: 8px;">
                        <img src="{{ asset($settings['logo']) }}" alt="Current Logo" style="height: 38px; width: auto; object-fit: contain;" onerror="this.src='{{ asset('images/logo-transparent.png') }}'">
                        <span style="font-size: 0.72rem; color: rgba(255,255,255,0.7);">Current Logo</span>
                    </div>
                    <input type="file" name="logo_file" class="form-control" accept="image/*" style="padding: 0.45rem 0.75rem;">
                    <div style="margin-top: 0.35rem;">
                        <span style="font-size: 0.72rem; color: #94A3B8;">Or logo asset path:</span>
                        <input type="text" name="logo_url" value="{{ old('logo_url', $settings['logo']) }}" class="form-control" style="font-size: 0.78rem; padding: 0.35rem 0.6rem; margin-top: 0.2rem;">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Browser Favicon</label>
                    <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 0.5rem; background: #F8FAFC; padding: 0.75rem 1rem; border-radius: 8px; border: 1px solid #E2E8F0;">
                        <img src="{{ asset($settings['favicon']) }}" alt="Favicon" style="width: 28px; height: 28px; object-fit: contain;" onerror="this.src='{{ asset('favicon.ico') }}'">
                        <span style="font-size: 0.72rem; color: #64748B;">Current Tab Icon</span>
                    </div>
                    <input type="file" name="favicon_file" class="form-control" accept=".ico,.png,.jpg,.svg" style="padding: 0.45rem 0.75rem;">
                    <div style="margin-top: 0.35rem;">
                        <span style="font-size: 0.72rem; color: #94A3B8;">Or favicon asset path:</span>
                        <input type="text" name="favicon_url" value="{{ old('favicon_url', $settings['favicon']) }}" class="form-control" style="font-size: 0.78rem; padding: 0.35rem 0.6rem; margin-top: 0.2rem;">
                    </div>
                </div>
            </div>

            <!-- General Details -->
            <h3 style="font-size: 0.95rem; font-weight: 700; color: #0F172A; margin: 1.5rem 0 1rem; border-bottom: 1px solid #E2E8F0; padding-bottom: 0.5rem;">
                🏢 Company Details
            </h3>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label" for="site_name">Company / Website Name *</label>
                    <input type="text" id="site_name" name="site_name" value="{{ old('site_name', $settings['site_name']) }}" required class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label" for="site_tagline">Tagline / Motto</label>
                    <input type="text" id="site_tagline" name="site_tagline" value="{{ old('site_tagline', $settings['site_tagline']) }}" class="form-control">
                </div>
            </div>

            <!-- Contact Information -->
            <h3 style="font-size: 0.95rem; font-weight: 700; color: #0F172A; margin: 1.5rem 0 1rem; border-bottom: 1px solid #E2E8F0; padding-bottom: 0.5rem;">
                📞 Contact & Communication
            </h3>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label" for="contact_email">Enquiries / Support Email *</label>
                    <input type="email" id="contact_email" name="contact_email" value="{{ old('contact_email', $settings['contact_email']) }}" required class="form-control">
                    <span style="font-size: 0.72rem; color: #94A3B8;">Customer enquiry notifications and public contact links will use this email.</span>
                </div>

                <div class="form-group">
                    <label class="form-label" for="contact_phone">Phone / Hotline</label>
                    <input type="text" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone']) }}" class="form-control">
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label" for="contact_address">Physical Address / Headquarters</label>
                    <textarea id="contact_address" name="contact_address" rows="2" class="form-control">{{ old('contact_address', $settings['contact_address']) }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label" for="contact_hours">Operating Hours</label>
                    <textarea id="contact_hours" name="contact_hours" rows="2" class="form-control">{{ old('contact_hours', $settings['contact_hours']) }}</textarea>
                </div>
            </div>

            <!-- Footer Section -->
            <h3 style="font-size: 0.95rem; font-weight: 700; color: #0F172A; margin: 1.5rem 0 1rem; border-bottom: 1px solid #E2E8F0; padding-bottom: 0.5rem;">
                📄 Footer & Legal
            </h3>

            <div class="form-group">
                <label class="form-label" for="footer_copyright">Footer Copyright Notice</label>
                <input type="text" id="footer_copyright" name="footer_copyright" value="{{ old('footer_copyright', $settings['footer_copyright']) }}" class="form-control">
            </div>

            <div style="display: flex; justify-content: flex-end; margin-top: 2rem; border-top: 1px solid #E2E8F0; padding-top: 1.25rem;">
                <button type="submit" class="admin-btn admin-btn-accent" style="padding: 0.65rem 1.75rem; font-size: 0.9rem;">
                    Save & Apply Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
