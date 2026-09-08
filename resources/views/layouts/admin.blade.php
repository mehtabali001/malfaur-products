<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') | {{ \App\Models\Setting::get('site_name', 'Malfaur Engineering') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/malfaur.css') }}">
    <link rel="icon" href="{{ asset(\App\Models\Setting::get('favicon', 'favicon.ico')) }}">
    
    <style>
        * {
            box-sizing: border-box;
        }

        :root {
            --admin-sidebar-w: 260px;
            --admin-navy: #081528;
            --admin-navy-dark: #040c17;
            --admin-accent: #EAB308;
            --admin-accent-hover: #F59E0B;
            --admin-bg: #F8FAFC;
            --admin-card: #FFFFFF;
            --admin-border: #E2E8F0;
            --admin-text-main: #0F172A;
            --admin-text-muted: #64748B;
        }

        body.admin-body {
            background: var(--admin-bg);
            font-family: 'Inter', system-ui, sans-serif;
            color: var(--admin-text-main);
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
            width: 100%;
            overflow-x: hidden;
        }

        /* Sidebar */
        .admin-sidebar {
            width: var(--admin-sidebar-w);
            max-width: var(--admin-sidebar-w);
            min-width: var(--admin-sidebar-w);
            background: var(--admin-navy);
            color: #FFFFFF;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            height: 100vh;
            z-index: 1000;
            border-right: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.12);
            overflow: hidden;
        }

        .admin-sidebar-header {
            padding: 1.5rem 1.4rem;
            display: flex;
            align-items: center;
            gap: 0.85rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            background: var(--admin-navy-dark);
        }

        .admin-sidebar-logo {
            height: 38px;
            width: auto;
            object-fit: contain;
        }

        .admin-sidebar-brand-text {
            display: flex;
            flex-direction: column;
        }

        .admin-sidebar-brand-title {
            font-size: 0.95rem;
            font-weight: 800;
            color: #FFFFFF;
            letter-spacing: -0.01em;
            line-height: 1.2;
        }

        .admin-sidebar-brand-badge {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--admin-accent);
        }

        .admin-sidebar-nav {
            padding: 1.25rem 0.85rem;
            flex: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }

        .admin-nav-group-title {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: rgba(255, 255, 255, 0.35);
            padding: 0.6rem 0.75rem 0.3rem;
        }

        .admin-nav-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.65rem 0.85rem;
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none;
            border-radius: 8px;
            font-size: 0.84rem;
            font-weight: 500;
            transition: all 0.18s ease;
        }

        .admin-nav-link-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .admin-nav-link svg {
            width: 18px;
            height: 18px;
            color: rgba(255, 255, 255, 0.5);
            transition: color 0.18s ease;
        }

        .admin-nav-link:hover {
            color: #FFFFFF;
            background: rgba(255, 255, 255, 0.07);
        }

        .admin-nav-link:hover svg {
            color: var(--admin-accent);
        }

        .admin-nav-link.active {
            color: #0F172A;
            background: var(--admin-accent);
            font-weight: 700;
            box-shadow: 0 4px 14px rgba(234, 179, 8, 0.3);
        }

        .admin-nav-link.active svg {
            color: #0F172A;
        }

        .admin-nav-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.15rem 0.45rem;
            font-size: 0.68rem;
            font-weight: 800;
            border-radius: 999px;
            background: #EF4444;
            color: #FFFFFF;
        }

        .admin-sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            background: var(--admin-navy-dark);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .admin-live-site-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.78rem;
            font-weight: 600;
            text-decoration: none;
            padding: 0.45rem 0.75rem;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            transition: all 0.2s ease;
            width: 100%;
            justify-content: center;
        }

        .admin-live-site-btn:hover {
            background: rgba(255, 255, 255, 0.16);
            color: #FFFFFF;
        }

        /* Main Wrapper */
        .admin-main-wrapper {
            margin-left: var(--admin-sidebar-w);
            width: calc(100% - var(--admin-sidebar-w));
            max-width: calc(100% - var(--admin-sidebar-w));
            min-width: 0;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: var(--admin-bg);
            box-sizing: border-box;
        }

        /* Top Header */
        .admin-topbar {
            height: 68px;
            background: #FFFFFF;
            border-bottom: 1px solid var(--admin-border);
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 990;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        }

        .admin-topbar-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .admin-page-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--admin-text-main);
            letter-spacing: -0.015em;
            margin: 0;
        }

        .admin-topbar-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .admin-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.52rem 1rem;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .admin-btn-primary {
            background: var(--admin-navy);
            color: #FFFFFF;
        }

        .admin-btn-primary:hover {
            background: #0d2344;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(8, 21, 40, 0.15);
        }

        .admin-btn-accent {
            background: var(--admin-accent);
            color: #0F172A;
            font-weight: 700;
        }

        .admin-btn-accent:hover {
            background: var(--admin-accent-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(234, 179, 8, 0.35);
        }

        .admin-btn-outline {
            background: #FFFFFF;
            border-color: var(--admin-border);
            color: var(--admin-text-main);
        }

        .admin-btn-outline:hover {
            background: #F1F5F9;
            border-color: #CBD5E1;
        }

        .admin-btn-danger {
            background: #EF4444;
            color: #FFFFFF;
        }

        .admin-btn-danger:hover {
            background: #DC2626;
        }

        .admin-btn-sm {
            padding: 0.35rem 0.65rem;
            font-size: 0.76rem;
            border-radius: 6px;
        }

        /* Content Canvas */
        .admin-content {
            padding: 2rem;
            flex: 1;
        }

        /* Cards */
        .admin-card {
            background: var(--admin-card);
            border: 1px solid var(--admin-border);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            margin-bottom: 1.5rem;
        }

        .admin-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
            padding-bottom: 0.85rem;
            border-bottom: 1px solid var(--admin-border);
        }

        .admin-card-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--admin-text-main);
            margin: 0;
        }

        /* Tables */
        .admin-table-wrap {
            overflow-x: auto;
            border-radius: 8px;
            border: 1px solid var(--admin-border);
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.84rem;
        }

        .admin-table th {
            background: #F8FAFC;
            padding: 0.75rem 1rem;
            font-weight: 700;
            color: #475569;
            border-bottom: 1px solid var(--admin-border);
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 0.05em;
        }

        .admin-table td {
            padding: 0.85rem 1rem;
            border-bottom: 1px solid #F1F5F9;
            color: #334155;
            vertical-align: middle;
        }

        .admin-table tr:hover td {
            background: #F8FAFC;
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.2rem 0.55rem;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 600;
        }

        .badge-emerald { background: #DCFCE7; color: #15803D; }
        .badge-amber   { background: #FEF3C7; color: #B45309; }
        .badge-blue    { background: #DBEAFE; color: #1D4ED8; }
        .badge-purple  { background: #F3E8FF; color: #7E22CE; }
        .badge-slate   { background: #F1F5F9; color: #475569; }

        /* Form Inputs */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--admin-text-main);
            margin-bottom: 0.4rem;
        }

        .form-control {
            width: 100%;
            padding: 0.6rem 0.85rem;
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            font-size: 0.85rem;
            color: var(--admin-text-main);
            background: #FFFFFF;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
            box-sizing: border-box;
            outline: none;
        }

        .form-control:focus {
            border-color: #0F172A;
            box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.1);
        }

        .form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
        }

        .form-grid-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 1.25rem;
        }

        /* Toast Alert */
        .admin-toast {
            padding: 0.85rem 1.25rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.84rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: space-between;
            animation: megaFadeIn 0.25s ease;
        }

        .admin-toast-success {
            background: #ECFDF5;
            border: 1px solid #A7F3D0;
            color: #065F46;
        }

        .admin-toast-error {
            background: #FEF2F2;
            border: 1px solid #FECACA;
            color: #991B1B;
        }

        /* ── PAGINATION SYSTEM ── */
        .admin-pagination-container {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 0.4rem;
            flex-wrap: wrap;
        }

        .admin-pagination-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.42rem 0.75rem;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--admin-text-main);
            background: #FFFFFF;
            border: 1px solid var(--admin-border);
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .admin-pagination-btn:hover:not(.disabled) {
            background: #F1F5F9;
            border-color: #CBD5E1;
            color: #0F172A;
        }

        .admin-pagination-btn.disabled {
            color: #94A3B8;
            background: #F8FAFC;
            border-color: #E2E8F0;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .admin-pagination-numbers {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .admin-pagination-num {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 32px;
            padding: 0 0.4rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: #475569;
            background: #FFFFFF;
            border: 1px solid var(--admin-border);
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .admin-pagination-num:hover:not(.active):not(.dots) {
            background: #F1F5F9;
            color: #0F172A;
        }

        .admin-pagination-num.active {
            background: var(--admin-navy);
            color: #FFFFFF;
            border-color: var(--admin-navy);
            font-weight: 700;
        }

        .admin-pagination-num.dots {
            border: none;
            background: transparent;
            color: #94A3B8;
            cursor: default;
        }

        /* Enforce absolute SVG size boundaries on any fallback pagination */
        nav[role="navigation"] svg {
            width: 16px !important;
            height: 16px !important;
            max-width: 16px !important;
            max-height: 16px !important;
            display: inline-block !important;
            vertical-align: middle;
        }
        nav[role="navigation"] {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        nav[role="navigation"] p {
            margin: 0;
            font-size: 0.8rem;
            color: #64748B;
        }
    </style>
    @stack('admin-head')
</head>
<body class="admin-body">

    {{-- ── ADMIN SIDEBAR ── --}}
    <aside class="admin-sidebar">
        <div class="admin-sidebar-header">
            <img src="{{ asset(\App\Models\Setting::get('logo', 'images/logo-transparent.png')) }}" alt="Malfaur Engineering" class="admin-sidebar-logo">
            <div class="admin-sidebar-brand-text">
                <span class="admin-sidebar-brand-title">Malfaur Admin</span>
                <span class="admin-sidebar-brand-badge">Control Panel</span>
            </div>
        </div>

        <nav class="admin-sidebar-nav">
            <span class="admin-nav-group-title">Main Navigation</span>
            <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <div class="admin-nav-link-left">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    <span>Dashboard</span>
                </div>
            </a>

            <a href="{{ route('admin.products.index') }}" class="admin-nav-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                <div class="admin-nav-link-left">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <span>Products Catalogue</span>
                </div>
            </a>

            <a href="{{ route('admin.categories.index') }}" class="admin-nav-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                <div class="admin-nav-link-left">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h10M4 18h7M18 15a3 3 0 100 6 3 3 0 000-6z"/></svg>
                    <span>Category Tree</span>
                </div>
                <span class="badge badge-amber" style="font-size: 0.65rem; padding: 0.1rem 0.4rem;">
                    {{ \App\Models\Category::count() }}
                </span>
            </a>

            <a href="{{ route('admin.enquiries.index') }}" class="admin-nav-link {{ request()->routeIs('admin.enquiries*') ? 'active' : '' }}">
                <div class="admin-nav-link-left">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span>Enquiries / Leads</span>
                </div>
                @php
                    $newEnquiryCount = \App\Models\Enquiry::where('status', 'new')->count();
                @endphp
                @if($newEnquiryCount > 0)
                    <span class="admin-nav-badge">{{ $newEnquiryCount }}</span>
                @endif
            </a>

            <span class="admin-nav-group-title">Site Content & Settings</span>
            <a href="{{ route('admin.pages.index') }}" class="admin-nav-link {{ request()->routeIs('admin.pages*') ? 'active' : '' }}">
                <div class="admin-nav-link-left">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>Pages Content</span>
                </div>
            </a>

            <a href="{{ route('admin.settings.index') }}" class="admin-nav-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                <div class="admin-nav-link-left">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>Website Settings</span>
                </div>
            </a>
        </nav>

        <div class="admin-sidebar-footer" style="flex-direction: column; gap: 0.75rem; align-items: stretch;">
            @auth
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.5rem 0.65rem; background: rgba(255, 255, 255, 0.04); border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.08);">
                    <div style="display: flex; align-items: center; gap: 0.6rem; overflow: hidden;">
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--admin-accent); color: #0F172A; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.8rem; flex-shrink: 0;">
                            {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                        </div>
                        <div style="overflow: hidden;">
                            <div style="font-size: 0.78rem; font-weight: 700; color: #FFFFFF; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ auth()->user()->name ?? 'Administrator' }}</div>
                            <div style="font-size: 0.68rem; color: rgba(255, 255, 255, 0.5); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ auth()->user()->email ?? 'admin' }}</div>
                        </div>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" title="Sign Out" style="background: none; border: none; color: #EF4444; cursor: pointer; padding: 0.35rem; display: flex; align-items: center; justify-content: center; border-radius: 6px; transition: background 0.15s ease;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
            @endauth

            <a href="{{ route('home') }}" target="_blank" class="admin-live-site-btn">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6M15 3h6v6M10 14L21 3"/></svg>
                <span>View Live Site</span>
            </a>
        </div>
    </aside>

    {{-- ── MAIN CONTENT AREA ── --}}
    <div class="admin-main-wrapper">
        <header class="admin-topbar">
            <div class="admin-topbar-left">
                <h1 class="admin-page-title">@yield('page-title', 'Dashboard')</h1>
            </div>
            <div class="admin-topbar-actions">
                <a href="{{ route('admin.products.create') }}" class="admin-btn admin-btn-accent">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    <span>Add New Product</span>
                </a>
                <a href="{{ route('home') }}" target="_blank" class="admin-btn admin-btn-outline">
                    <span>Visit Website ↗</span>
                </a>
                @auth
                    <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0; display: inline;">
                        @csrf
                        <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm" style="padding: 0.52rem 0.85rem;" title="Sign out of Admin Panel">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            <span>Logout</span>
                        </button>
                    </form>
                @endauth
            </div>
        </header>

        <main class="admin-content">
            @if(session('success'))
                <div class="admin-toast admin-toast-success">
                    <div style="display:flex;align-items:center;gap:0.5rem;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;cursor:pointer;color:inherit;font-weight:700;">✕</button>
                </div>
            @endif

            @if($errors->any())
                <div class="admin-toast admin-toast-error">
                    <div>
                        <strong>Please resolve the following errors:</strong>
                        <ul style="margin:0.25rem 0 0 1.25rem;padding:0;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;cursor:pointer;color:inherit;font-weight:700;">✕</button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('admin-scripts')
</body>
</html>
