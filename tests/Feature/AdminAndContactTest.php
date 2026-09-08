<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use App\Models\Enquiry;
use App\Models\Setting;
use App\Models\PageContent;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminAndContactTest extends TestCase
{
    use RefreshDatabase;

    protected function createAdminUser()
    {
        return User::create([
            'name' => 'Malfaur Administrator',
            'email' => 'admin@malfaurengineering.co.uk',
            'password' => Hash::make('admin12345'),
        ]);
    }

    public function test_guest_is_redirected_to_admin_login()
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/admin/login');

        $loginPage = $this->get('/admin/login');
        $loginPage->assertStatus(200);
        $loginPage->assertSee('Admin Control Panel');
    }

    public function test_admin_can_login_with_valid_credentials()
    {
        $admin = $this->createAdminUser();

        $response = $this->post('/admin/login', [
            'email' => 'admin@malfaurengineering.co.uk',
            'password' => 'admin12345',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($admin);
    }

    public function test_admin_cannot_login_with_invalid_password()
    {
        $this->createAdminUser();

        $response = $this->post('/admin/login', [
            'email' => 'admin@malfaurengineering.co.uk',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_admin_can_logout()
    {
        $admin = $this->createAdminUser();

        $response = $this->actingAs($admin)->post('/admin/logout');
        $response->assertRedirect('/admin/login');
        $this->assertGuest();
    }

    public function test_authenticated_admin_dashboard_is_accessible()
    {
        $admin = $this->createAdminUser();

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('Overview Dashboard');
        $response->assertSee('Logout');
    }

    public function test_admin_products_crud_routes()
    {
        $admin = $this->createAdminUser();

        $response = $this->actingAs($admin)->get('/admin/products');
        $response->assertStatus(200);
        $response->assertSee('Manage Products');

        $createResponse = $this->actingAs($admin)->get('/admin/products/create');
        $createResponse->assertStatus(200);
        $createResponse->assertSee('Create New Product');

        // Store a new product
        $storeResponse = $this->actingAs($admin)->post('/admin/products', [
            'title' => 'Test High Feed Milling Cutter',
            'category' => 'Cutting Tools',
            'description' => 'Test precision indexable cutter for high-feed roughing operations.',
            'short_description' => 'High-feed roughing indexable cutter',
            'spec_keys' => ['Diameter', 'Flutes'],
            'spec_values' => ['50mm', '4']
        ]);

        $storeResponse->assertRedirect('/admin/products');
        $this->assertDatabaseHas('products', [
            'title' => 'Test High Feed Milling Cutter'
        ]);
    }

    public function test_admin_enquiries_flow()
    {
        // Submit a contact enquiry (public)
        $submitResponse = $this->post('/contact', [
            'name' => 'Sarah Connor',
            'email' => 'sarah@skynetengineering.co.uk',
            'phone' => '+44 7800 123456',
            'company' => 'Cyberdyne Systems',
            'subject' => 'Product Enquiry',
            'message' => 'We need immediate quote for aerospace titanium fasteners.'
        ]);

        $submitResponse->assertSessionHas('success');
        $this->assertDatabaseHas('enquiries', [
            'email' => 'sarah@skynetengineering.co.uk'
        ]);

        // Check enquiry in admin panel as authenticated admin
        $admin = $this->createAdminUser();
        $enquiry = Enquiry::where('email', 'sarah@skynetengineering.co.uk')->first();
        $this->assertNotNull($enquiry);

        $adminEnquiryResponse = $this->actingAs($admin)->get('/admin/enquiries/' . $enquiry->id);
        $adminEnquiryResponse->assertStatus(200);
        $adminEnquiryResponse->assertSee('Cyberdyne Systems');
    }

    public function test_admin_settings_update()
    {
        $admin = $this->createAdminUser();

        $response = $this->actingAs($admin)->get('/admin/settings');
        $response->assertStatus(200);
        $response->assertSee('Global Website Configuration');

        $updateResponse = $this->actingAs($admin)->put('/admin/settings', [
            'site_name' => 'Malfaur Engineering Products Ltd',
            'site_tagline' => 'Precision Engineering Components & Industrial Supply UK',
            'contact_email' => 'enquiries@malfaurengineering.co.uk',
            'contact_phone' => '+44 (0) 20 7946 0991',
            'contact_address' => 'Precision House, Industrial Park, Birmingham, UK',
            'contact_hours' => 'Monday – Friday: 08:00 – 17:30 (GMT)',
            'footer_copyright' => '© 2026 Malfaur Engineering Products Ltd. All rights reserved.'
        ]);

        $updateResponse->assertRedirect('/admin/settings');
        $this->assertEquals('enquiries@malfaurengineering.co.uk', Setting::get('contact_email'));
    }

    public function test_admin_page_content_update()
    {
        $admin = $this->createAdminUser();

        $response = $this->actingAs($admin)->get('/admin/pages?tab=home');
        $response->assertStatus(200);
        $response->assertSee('Edit Website Pages Content');

        $updateResponse = $this->actingAs($admin)->post('/admin/pages', [
            'page' => 'home',
            'section' => 'hero',
            'title' => 'Precision Engineering, Cutting Tools & Aerospace Components UK',
            'subtitle' => 'Supplying premier industrial components to manufacturing leaders nationwide.',
            'badge' => 'ESTABLISHED UK SUPPLIER'
        ]);

        $updateResponse->assertRedirect('/admin/pages?tab=home');
        $section = PageContent::getSection('home', 'hero');
        $this->assertEquals('Precision Engineering, Cutting Tools & Aerospace Components UK', $section['title']);
    }
}
