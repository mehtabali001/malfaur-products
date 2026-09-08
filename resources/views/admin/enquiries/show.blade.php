@extends('layouts.admin')

@section('title', 'Enquiry from ' . $enquiry->name)
@section('page-title', 'Enquiry Details')

@section('content')
<div style="max-width: 900px; margin: 0 auto;">
    <div style="margin-bottom: 1rem; display: flex; justify-content: space-between; align-items: center;">
        <a href="{{ route('admin.enquiries.index') }}" style="color: var(--admin-text-muted); text-decoration: none; font-size: 0.84rem; display: inline-flex; align-items: center; gap: 0.35rem;">
            ← Back to Enquiries Inbox
        </a>
        <div style="display: flex; gap: 0.5rem;">
            <a href="mailto:{{ $enquiry->email }}?subject=Re: {{ urlencode($enquiry->subject ?: 'Your inquiry to Malfaur Engineering') }}" class="admin-btn admin-btn-accent admin-btn-sm">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                <span>Reply to Customer</span>
            </a>
            <form action="{{ route('admin.enquiries.destroy', $enquiry->id) }}" method="POST" onsubmit="return confirm('Delete this enquiry?');" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Delete</button>
            </form>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
        <!-- Left: Enquiry Content -->
        <div>
            <div class="admin-card">
                <div class="admin-card-header">
                    <div>
                        <h2 class="admin-card-title">{{ $enquiry->subject ?: 'General Customer Enquiry' }}</h2>
                        <span style="font-size: 0.78rem; color: #64748B;">Received on {{ $enquiry->created_at->format('l, F d, Y \a\t h:i A') }}</span>
                    </div>
                    <div>
                        @if($enquiry->status === 'new')
                            <span class="badge badge-amber" style="background: #FEE2E2; color: #DC2626;">New</span>
                        @elseif($enquiry->status === 'in_progress')
                            <span class="badge badge-blue">In Progress</span>
                        @elseif($enquiry->status === 'replied')
                            <span class="badge badge-emerald">Replied</span>
                        @else
                            <span class="badge badge-slate">{{ ucfirst($enquiry->status) }}</span>
                        @endif
                    </div>
                </div>

                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 8px; padding: 1.25rem; font-size: 0.92rem; line-height: 1.6; color: #1E293B; white-space: pre-wrap; margin-bottom: 1.25rem;">
{{ $enquiry->message }}
                </div>

                @if($enquiry->product_name)
                    <div style="padding: 0.85rem 1rem; background: #EFF6FF; border: 1px solid #BFDBFE; border-radius: 8px; font-size: 0.82rem; color: #1E40AF;">
                        <strong>Associated Product:</strong> {{ $enquiry->product_name }}
                    </div>
                @endif
            </div>

            <!-- Status & Notes Management -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3 class="admin-card-title" style="font-size: 0.95rem;">Update Status & Internal Notes</h3>
                </div>

                <form action="{{ route('admin.enquiries.update', $enquiry->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="form-label" for="status">Follow-up Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="new" {{ $enquiry->status === 'new' ? 'selected' : '' }}>New</option>
                            <option value="in_progress" {{ $enquiry->status === 'in_progress' ? 'selected' : '' }}>In Progress (Under Review)</option>
                            <option value="replied" {{ $enquiry->status === 'replied' ? 'selected' : '' }}>Replied (Quotation Sent)</option>
                            <option value="archived" {{ $enquiry->status === 'archived' ? 'selected' : '' }}>Archived / Closed</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="admin_notes">Internal Admin Notes</label>
                        <textarea name="admin_notes" id="admin_notes" rows="3" class="form-control" placeholder="Add internal follow-up notes, quote reference, or call summary (only visible to admin team)...">{{ old('admin_notes', $enquiry->admin_notes) }}</textarea>
                    </div>

                    <div style="display: flex; justify-content: flex-end;">
                        <button type="submit" class="admin-btn admin-btn-primary">Update Enquiry</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right: Sender Contact Info -->
        <div>
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3 class="admin-card-title" style="font-size: 0.95rem;">Customer Details</h3>
                </div>

                <div style="display: flex; flex-direction: column; gap: 0.85rem; font-size: 0.84rem;">
                    <div>
                        <div style="font-size: 0.72rem; text-transform: uppercase; color: #94A3B8; font-weight: 700;">Full Name</div>
                        <div style="font-weight: 700; color: #0F172A; margin-top: 0.15rem;">{{ $enquiry->name }}</div>
                    </div>

                    <div>
                        <div style="font-size: 0.72rem; text-transform: uppercase; color: #94A3B8; font-weight: 700;">Email Address</div>
                        <div style="margin-top: 0.15rem;">
                            <a href="mailto:{{ $enquiry->email }}" style="color: #2563EB; word-break: break-all; text-decoration: none;">{{ $enquiry->email }}</a>
                        </div>
                    </div>

                    <div>
                        <div style="font-size: 0.72rem; text-transform: uppercase; color: #94A3B8; font-weight: 700;">Phone Number</div>
                        <div style="color: #334155; margin-top: 0.15rem;">
                            {{ $enquiry->phone ?: 'Not provided' }}
                        </div>
                    </div>

                    <div>
                        <div style="font-size: 0.72rem; text-transform: uppercase; color: #94A3B8; font-weight: 700;">Company / Organisation</div>
                        <div style="color: #334155; margin-top: 0.15rem;">
                            {{ $enquiry->company ?: 'Not provided' }}
                        </div>
                    </div>

                    <div style="border-top: 1px solid #E2E8F0; padding-top: 0.75rem; margin-top: 0.25rem;">
                        <div style="font-size: 0.72rem; text-transform: uppercase; color: #94A3B8; font-weight: 700;">IP Address</div>
                        <div style="font-family: monospace; font-size: 0.75rem; color: #64748B; margin-top: 0.15rem;">
                            {{ $enquiry->ip_address ?: 'Unknown' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
