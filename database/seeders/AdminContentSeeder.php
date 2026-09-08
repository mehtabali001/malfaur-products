<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use App\Models\PageContent;

class AdminContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ── Seed Default Settings ──
        $settings = [
            ['key' => 'site_name', 'value' => 'Malfaur Engineering Products Ltd', 'group' => 'general', 'type' => 'text'],
            ['key' => 'site_tagline', 'value' => 'Precision Engineering Components & Industrial Supply UK', 'group' => 'general', 'type' => 'text'],
            ['key' => 'logo', 'value' => 'images/logo-transparent.png', 'group' => 'branding', 'type' => 'image'],
            ['key' => 'favicon', 'value' => 'favicon.ico', 'group' => 'branding', 'type' => 'image'],
            ['key' => 'contact_email', 'value' => 'enquiries@malfaurengineering.co.uk', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'contact_phone', 'value' => '+44 (0) 000 000 0000', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'contact_address', 'value' => 'United Kingdom', 'group' => 'contact', 'type' => 'textarea'],
            ['key' => 'contact_hours', 'value' => 'Mon – Fri: 8:00 AM – 5:30 PM (GMT)', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'footer_copyright', 'value' => '© ' . date('Y') . ' Malfaur Engineering Products Ltd. All rights reserved.', 'group' => 'footer', 'type' => 'text'],
        ];

        foreach ($settings as $s) {
            Setting::updateOrCreate(['key' => $s['key']], $s);
        }

        // ── Seed Default Page Contents ──
        $pages = [
            [
                'page' => 'home',
                'section' => 'hero',
                'title' => 'UK Supplier of Precision Engineering Components & Products',
                'subtitle' => 'Supplying high-performance cutting tools, measurement equipment, standard machine parts, aerospace alloys, and raw materials to manufacturing professionals across the United Kingdom.',
                'meta_data' => [
                    'badge' => 'UK Precision Engineering Supplier',
                    'primary_btn_text' => 'Explore Product Catalogue',
                    'secondary_btn_text' => 'Request Quotation',
                ]
            ],
            [
                'page' => 'about',
                'section' => 'story',
                'title' => 'Engineering Excellence Built on Precision & Reliability',
                'subtitle' => 'Malfaur Engineering Products provides industry-grade precision tools, calibrated measuring instruments, aerospace fasteners, and certified raw materials to machine shops, aerospace manufacturers, and OEM producers throughout the UK.',
                'meta_data' => [
                    'badge' => 'About Malfaur Engineering',
                    'mission' => 'To deliver highest quality certified engineering components with rapid quotation and nationwide dispatch.',
                    'vision' => 'Becoming the UK\'s most trusted supplier for bespoke tooling and exotic aerospace alloys.'
                ]
            ],
            [
                'page' => 'contact',
                'section' => 'info',
                'title' => 'Contact Our Technical Sales Team',
                'subtitle' => 'Get in touch for custom tool geometry, bulk quotation requests, material test certificates, or general component supply enquiries.',
                'meta_data' => [
                    'badge' => 'Fast Technical Response',
                    'form_heading' => 'Send Us an Enquiry / RFQ'
                ]
            ],
            [
                'page' => 'products',
                'section' => 'hero',
                'title' => 'Product Catalogue',
                'subtitle' => 'Browse our comprehensive range of precision engineering components, cutting tools, aerospace alloys, and raw materials. All products are verified for UK industrial, manufacturing, and trade supply.',
                'meta_data' => [
                    'badge' => 'Industrial Precision Range · Malfaur UK'
                ]
            ]
        ];

        foreach ($pages as $p) {
            PageContent::updateOrCreate(
                ['page' => $p['page'], 'section' => $p['section']],
                $p
            );
        }
    }
}
