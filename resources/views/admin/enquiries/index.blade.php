@extends('layouts.admin')

@section('title', 'Customer Enquiries & Leads')
@section('page-title', 'Enquiries & Quotation Requests')

@section('content')
<div class="admin-card">
    <div class="admin-card-header" style="flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 class="admin-card-title">Customer Enquiries & Leads</h2>
            <p style="font-size:0.8rem;color:var(--admin-text-muted);margin:0.25rem 0 0;">Review RFQs, sample requests, and contact inquiries submitted through the website.</p>
        </div>
    </div>

    <!-- Status Tabs -->
    <div style="display: flex; gap: 0.5rem; margin-bottom: 1.25rem; border-bottom: 1px solid #E2E8F0; padding-bottom: 0.75rem; flex-wrap: wrap;">
        <a href="{{ route('admin.enquiries.index', ['status' => 'all']) }}" class="admin-btn {{ request('status', 'all') === 'all' ? 'admin-btn-primary' : 'admin-btn-outline' }} admin-btn-sm">
            All Enquiries ({{ $statusCounts['all'] }})
        </a>
        <a href="{{ route('admin.enquiries.index', ['status' => 'new']) }}" class="admin-btn {{ request('status') === 'new' ? 'admin-btn-accent' : 'admin-btn-outline' }} admin-btn-sm">
            <span style="display:inline-block;width:7px;height:7px;border-radius:50%;background:#EF4444;margin-right:4px;"></span>
            New ({{ $statusCounts['new'] }})
        </a>
        <a href="{{ route('admin.enquiries.index', ['status' => 'in_progress']) }}" class="admin-btn {{ request('status') === 'in_progress' ? 'admin-btn-primary' : 'admin-btn-outline' }} admin-btn-sm">
            In Progress ({{ $statusCounts['in_progress'] }})
        </a>
        <a href="{{ route('admin.enquiries.index', ['status' => 'replied']) }}" class="admin-btn {{ request('status') === 'replied' ? 'admin-btn-primary' : 'admin-btn-outline' }} admin-btn-sm">
            Replied ({{ $statusCounts['replied'] }})
        </a>
    </div>

    <!-- Search Form -->
    <form method="GET" action="{{ route('admin.enquiries.index') }}" style="display: flex; gap: 0.75rem; margin-bottom: 1.25rem;">
        <input type="hidden" name="status" value="{{ request('status', 'all') }}">
        <div style="flex: 1; position: relative;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by customer name, email, company, or message..." class="form-control" style="padding-left: 2.2rem;">
            <svg style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); width: 15px; height: 15px; color: #94A3B8;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        </div>
        <button type="submit" class="admin-btn admin-btn-primary">Search</button>
        @if(request('search'))
            <a href="{{ route('admin.enquiries.index', ['status' => request('status', 'all')]) }}" class="admin-btn admin-btn-outline">Clear</a>
        @endif
    </form>

    @if($enquiries->count() > 0)
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 100px;">Status</th>
                        <th>Sender / Customer</th>
                        <th>Subject & Preview</th>
                        <th>Product Context</th>
                        <th>Received Date</th>
                        <th style="text-align: right; width: 130px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enquiries as $enquiry)
                        <tr style="{{ $enquiry->status === 'new' ? 'background-color: #FEF9C320; font-weight: 500;' : '' }}">
                            <td>
                                @if($enquiry->status === 'new')
                                    <span class="badge badge-amber" style="background: #FEE2E2; color: #DC2626;">New Lead</span>
                                @elseif($enquiry->status === 'in_progress')
                                    <span class="badge badge-blue">In Progress</span>
                                @elseif($enquiry->status === 'replied')
                                    <span class="badge badge-emerald">Replied</span>
                                @else
                                    <span class="badge badge-slate">{{ ucfirst($enquiry->status) }}</span>
                                @endif
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #0F172A;">{{ $enquiry->name }}</div>
                                <div style="font-size: 0.75rem; color: #64748B;">
                                    <a href="mailto:{{ $enquiry->email }}" style="color: #2563EB; text-decoration: none;">{{ $enquiry->email }}</a>
                                    @if($enquiry->phone) • {{ $enquiry->phone }} @endif
                                </div>
                                @if($enquiry->company)
                                    <div style="font-size: 0.72rem; color: #475569; font-weight: 600;">🏢 {{ $enquiry->company }}</div>
                                @endif
                            </td>
                            <td>
                                <div style="font-weight: 600; color: #1E293B;">{{ $enquiry->subject ?: 'General Inquiry' }}</div>
                                <div style="font-size: 0.76rem; color: #64748B; max-width: 320px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    {{ $enquiry->message }}
                                </div>
                            </td>
                            <td>
                                @if($enquiry->product_name)
                                    <span class="badge badge-purple" style="font-size: 0.72rem;">{{ $enquiry->product_name }}</span>
                                @else
                                    <span style="font-size: 0.75rem; color: #94A3B8;">—</span>
                                @endif
                            </td>
                            <td style="font-size: 0.78rem; color: #64748B;">
                                <div>{{ $enquiry->created_at->format('M d, Y') }}</div>
                                <div style="font-size: 0.7rem; color: #94A3B8;">{{ $enquiry->created_at->format('h:i A') }}</div>
                            </td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; gap: 0.4rem; justify-content: flex-end;">
                                    <a href="{{ route('admin.enquiries.show', $enquiry->id) }}" class="admin-btn admin-btn-outline admin-btn-sm">
                                        <span>View</span>
                                    </a>
                                    <form action="{{ route('admin.enquiries.destroy', $enquiry->id) }}" method="POST" onsubmit="return confirm('Delete this enquiry?');" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm" title="Delete">✕</button>
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
                Showing <strong>{{ $enquiries->firstItem() }}</strong> to <strong>{{ $enquiries->lastItem() }}</strong> of <strong>{{ $enquiries->total() }}</strong> enquiries
            </div>
            <div>
                {{ $enquiries->links('admin.partials.pagination') }}
            </div>
        </div>
    @else
        <div style="text-align: center; padding: 3rem 1rem; color: #64748B;">
            <svg style="width: 48px; height: 48px; margin-bottom: 0.75rem; color: #CBD5E1;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            <h3 style="font-size: 1.1rem; color: #1E293B; margin: 0 0 0.25rem;">No enquiries found</h3>
            <p style="font-size: 0.85rem; margin: 0;">New customer submissions from the website contact and RFQ forms will appear here.</p>
        </div>
    @endif
</div>
@endsection
