<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    /**
     * Show website settings management panel.
     */
    public function index()
    {
        $settings = [
            'site_name' => Setting::get('site_name', 'Malfaur Engineering Products Ltd'),
            'site_tagline' => Setting::get('site_tagline', 'Precision Engineering Components & Industrial Supply UK'),
            'logo' => Setting::get('logo', 'images/logo-transparent.png'),
            'favicon' => Setting::get('favicon', 'favicon.ico'),
            'contact_email' => Setting::get('contact_email', 'enquiries@malfaurengineering.co.uk'),
            'contact_phone' => Setting::get('contact_phone', '+44 (0) 000 000 0000'),
            'contact_address' => Setting::get('contact_address', 'United Kingdom'),
            'contact_hours' => Setting::get('contact_hours', 'Mon – Fri: 8:00 AM – 5:30 PM (GMT)'),
            'footer_copyright' => Setting::get('footer_copyright', '© ' . date('Y') . ' Malfaur Engineering Products Ltd. All rights reserved.'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update website settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_tagline' => 'nullable|string|max:500',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'nullable|string|max:100',
            'contact_address' => 'nullable|string|max:500',
            'contact_hours' => 'nullable|string|max:255',
            'footer_copyright' => 'nullable|string|max:500',
            'logo_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'favicon_file' => 'nullable|mimes:ico,png,jpg,svg|max:2048',
        ]);

        // General settings
        Setting::set('site_name', $request->site_name, 'general');
        Setting::set('site_tagline', $request->site_tagline, 'general');
        Setting::set('contact_email', $request->contact_email, 'contact');
        Setting::set('contact_phone', $request->contact_phone, 'contact');
        Setting::set('contact_address', $request->contact_address, 'contact');
        Setting::set('contact_hours', $request->contact_hours, 'contact');
        Setting::set('footer_copyright', $request->footer_copyright, 'footer');

        // Handle Logo file upload or direct URL
        if ($request->hasFile('logo_file')) {
            $file = $request->file('logo_file');
            $fileName = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $fileName);
            Setting::set('logo', 'images/' . $fileName, 'branding', 'image');
        } elseif ($request->filled('logo_url')) {
            Setting::set('logo', $request->logo_url, 'branding', 'image');
        }

        // Handle Favicon file upload or direct URL
        if ($request->hasFile('favicon_file')) {
            $file = $request->file('favicon_file');
            $fileName = 'favicon_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $fileName);
            Setting::set('favicon', 'images/' . $fileName, 'branding', 'image');
        } elseif ($request->filled('favicon_url')) {
            Setting::set('favicon', $request->favicon_url, 'branding', 'image');
        }

        return redirect()->route('admin.settings.index')->with('success', 'Website settings updated successfully! Changes are now live.');
    }
}
