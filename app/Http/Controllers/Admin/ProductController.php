<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of products with search & hierarchical category filter.
     */
    public function index(Request $request)
    {
        $query = Product::with('categoryItem');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('name', 'like', "%{$s}%")
                  ->orWhere('description', 'like', "%{$s}%")
                  ->orWhere('slug', 'like', "%{$s}%");
            });
        }

        if ($request->filled('category_id') && $request->category_id !== 'all') {
            $cat = Category::find($request->category_id);
            if ($cat) {
                $allCatIds = $cat->getAllCategoryIds();
                $query->whereIn('category_id', $allCatIds);
            }
        } elseif ($request->filled('category') && $request->category !== 'all') {
            $cat = Category::where('name', $request->category)->orWhere('slug', $request->category)->first();
            if ($cat) {
                $allCatIds = $cat->getAllCategoryIds();
                $query->whereIn('category_id', $allCatIds);
            } else {
                $query->where('category', $request->category);
            }
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        $selectTree = Category::getSelectTree();

        return view('admin.products.index', compact('products', 'selectTree'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $selectTree = Category::getSelectTree();
        return view('admin.products.create', compact('selectTree'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'category' => 'nullable|string',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:500',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'image_url' => 'nullable|string|max:500',
        ]);

        $catId = $request->category_id;
        $categoryModel = null;
        if ($catId) {
            $categoryModel = Category::find($catId);
        } elseif ($request->filled('category')) {
            $categoryModel = Category::where('name', $request->category)->orWhere('slug', $request->category)->first();
            if (!$categoryModel) {
                $categoryModel = Category::firstOrCreate(
                    ['slug' => Str::slug($request->category)],
                    ['name' => $request->category, 'level' => 1, 'color' => 'amber']
                );
            }
            $catId = $categoryModel?->id;
        }

        $imagePath = $request->image_url;
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/uploads'), $fileName);
            $imagePath = 'images/uploads/' . $fileName;
        }

        if (empty($imagePath)) {
            $imagePath = 'hero-engineering.png';
        }

        // Parse key-value specifications from form
        $specsMap = [];
        if ($request->has('spec_keys') && is_array($request->spec_keys)) {
            foreach ($request->spec_keys as $index => $key) {
                $val = $request->spec_values[$index] ?? '';
                if (!empty(trim($key)) && !empty(trim($val))) {
                    $specsMap[trim($key)] = trim($val);
                }
            }
        }

        $product = new Product();
        $product->title = $request->title;
        $product->name = $request->title;
        $product->slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);
        $product->category_id = $catId;
        $product->category = $categoryModel ? $categoryModel->name : ($request->category ?? 'Cutting Tools');
        $product->description = $request->description;
        $product->short_description = $request->short_description;
        $product->image = $imagePath;
        $product->specifications = $specsMap;
        $product->save();

        $path = $categoryModel ? $categoryModel->breadcrumb_path : $product->category;
        return redirect()->route('admin.products.index')
            ->with('success', "Product '{$product->title}' assigned to '{$path}' created successfully!");
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $selectTree = Category::getSelectTree();

        return view('admin.products.edit', compact('product', 'selectTree'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'category' => 'nullable|string',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:500',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'image_url' => 'nullable|string|max:500',
        ]);

        $catId = $request->category_id;
        $categoryModel = null;
        if ($catId) {
            $categoryModel = Category::find($catId);
        } elseif ($request->filled('category')) {
            $categoryModel = Category::where('name', $request->category)->orWhere('slug', $request->category)->first();
            if (!$categoryModel) {
                $categoryModel = Category::firstOrCreate(
                    ['slug' => Str::slug($request->category)],
                    ['name' => $request->category, 'level' => 1, 'color' => 'amber']
                );
            }
            $catId = $categoryModel?->id;
        }

        $imagePath = $product->image;
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/uploads'), $fileName);
            $imagePath = 'images/uploads/' . $fileName;
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->image_url;
        }

        // Parse key-value specifications from form
        $specsMap = [];
        if ($request->has('spec_keys') && is_array($request->spec_keys)) {
            foreach ($request->spec_keys as $index => $key) {
                $val = $request->spec_values[$index] ?? '';
                if (!empty(trim($key)) && !empty(trim($val))) {
                    $specsMap[trim($key)] = trim($val);
                }
            }
        }

        $product->title = $request->title;
        $product->name = $request->title;
        $product->slug = $request->slug ? Str::slug($request->slug) : ($product->slug ?: Str::slug($request->title));
        if ($catId) {
            $product->category_id = $catId;
            $product->category = $categoryModel ? $categoryModel->name : $product->category;
        }
        $product->description = $request->description;
        $product->short_description = $request->short_description;
        $product->image = $imagePath;
        $product->specifications = $specsMap;
        $product->save();

        $path = $categoryModel ? $categoryModel->breadcrumb_path : $product->category;
        return redirect()->route('admin.products.index')
            ->with('success', "Product '{$product->title}' updated and assigned to '{$path}' successfully!");
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $name = $product->name;
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product "' . $name . '" has been deleted.');
    }
}

