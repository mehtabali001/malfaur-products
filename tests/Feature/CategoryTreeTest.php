<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CategoryTreeTest extends TestCase
{
    use RefreshDatabase;

    protected function createAdmin()
    {
        return User::create([
            'name' => 'Admin User',
            'email' => 'admin@malfaurengineering.co.uk',
            'password' => Hash::make('admin12345'),
        ]);
    }

    public function test_category_tree_hierarchy_levels()
    {
        // Level 1: Root
        $root = Category::create([
            'name' => 'Cutting Tools',
            'slug' => 'cutting-tools',
            'color' => 'orange',
        ]);
        $this->assertEquals(1, $root->level);

        // Level 2: Subcategory
        $sub = Category::create([
            'name' => 'Reamers & Deburring',
            'slug' => 'reamers-deburring',
            'parent_id' => $root->id,
        ]);
        $this->assertEquals(2, $sub->level);

        // Level 3: Sub-Subcategory
        $subSub = Category::create([
            'name' => 'Machine Reamers',
            'slug' => 'machine-reamers',
            'parent_id' => $sub->id,
        ]);
        $this->assertEquals(3, $subSub->level);

        // Level 4: Series / Leaf
        $leaf = Category::create([
            'name' => 'Solid Carbide Spiral Flute',
            'slug' => 'solid-carbide-spiral-flute',
            'parent_id' => $subSub->id,
        ]);
        $this->assertEquals(4, $leaf->level);

        // Check full breadcrumb path
        $this->assertEquals(
            'Cutting Tools > Reamers & Deburring > Machine Reamers > Solid Carbide Spiral Flute',
            $leaf->breadcrumb_path
        );
    }

    public function test_admin_can_view_category_tree()
    {
        $admin = $this->createAdmin();

        $root = Category::create(['name' => 'Measuring Equipment', 'slug' => 'measuring-equipment']);
        $sub = Category::create(['name' => 'Micrometers', 'slug' => 'micrometers', 'parent_id' => $root->id]);

        $response = $this->actingAs($admin)->get('/admin/categories');
        $response->assertStatus(200);
        $response->assertSee('Category Tree Structure');
        $response->assertSee('Measuring Equipment');
        $response->assertSee('Micrometers');
    }

    public function test_admin_can_create_nested_category()
    {
        $admin = $this->createAdmin();
        $root = Category::create(['name' => 'Standard Parts', 'slug' => 'standard-parts']);

        $response = $this->actingAs($admin)->post('/admin/categories', [
            'name' => 'Spring Plungers',
            'slug' => 'spring-plungers',
            'parent_id' => $root->id,
            'color' => 'green',
        ]);

        $response->assertRedirect('/admin/categories');
        $this->assertDatabaseHas('categories', [
            'name' => 'Spring Plungers',
            'parent_id' => $root->id,
            'level' => 2,
        ]);
    }

    public function test_product_assignment_to_nested_category()
    {
        $admin = $this->createAdmin();

        $root = Category::create(['name' => 'Cutting Tools', 'slug' => 'cutting-tools']);
        $sub = Category::create(['name' => 'Reamers', 'slug' => 'reamers', 'parent_id' => $root->id]);
        $subSub = Category::create(['name' => 'Machine Reamers', 'slug' => 'machine-reamers', 'parent_id' => $sub->id]);

        $response = $this->actingAs($admin)->post('/admin/products', [
            'title' => 'High Precision Machine Reamer DIN 212',
            'category_id' => $subSub->id,
            'description' => 'Precision carbide machine reamer for h6 hole tolerance.',
        ]);

        $response->assertRedirect('/admin/products');

        $product = Product::where('slug', 'high-precision-machine-reamer-din-212')->first();
        $this->assertNotNull($product);
        $this->assertEquals($subSub->id, $product->category_id);
        $this->assertEquals('Cutting Tools > Reamers > Machine Reamers', $product->category_breadcrumb);
        $this->assertEquals('Cutting Tools', $product->root_category_name);
        $this->assertContains($root->id, $product->all_category_ids);
        $this->assertContains($sub->id, $product->all_category_ids);
        $this->assertContains($subSub->id, $product->all_category_ids);
    }

    public function test_frontend_products_catalogue_renders_dynamic_categories_and_products()
    {
        $root = Category::create(['name' => 'Raw Materials', 'slug' => 'raw-materials']);
        $sub = Category::create(['name' => 'Alloy Steels & Tubes', 'slug' => 'alloy-steels-tubes', 'parent_id' => $root->id]);
        $leaf = Category::create(['name' => '4130 Chrome Moly', 'slug' => '4130-chrome-moly', 'parent_id' => $sub->id]);

        $product = Product::create([
            'title' => '4130 Chrome Moly Streamline Tube',
            'slug' => '4130-chrome-moly-streamline-tube',
            'category_id' => $leaf->id,
            'description' => 'Seamless cold drawn steel tube for aerospace.',
        ]);

        $response = $this->get('/products');
        $response->assertStatus(200);
        $response->assertSee('window.MALFAUR_CATEGORIES', false);
        $response->assertSee('Raw Materials');
        $response->assertSee('data-root-category="Raw Materials"', false);
        $response->assertSee('data-category-ids="[' . $leaf->id . ',' . $sub->id . ',' . $root->id . ']"', false);
        $response->assertSee('4130 Chrome Moly Streamline Tube');
    }
}
