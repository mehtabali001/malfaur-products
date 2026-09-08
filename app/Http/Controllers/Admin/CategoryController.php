<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display the hierarchical category tree.
     */
    public function index(Request $request)
    {
        $query = Category::whereNull('parent_id')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->with(['allChildren' => function ($q) {
                $q->withCount('products');
            }])
            ->withCount('products');

        if ($request->filled('search')) {
            $search = $request->search;
            // If searching, also search across all categories
            $matchingCategories = Category::where('name', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%")
                ->with(['parent', 'products'])
                ->withCount('products')
                ->get();

            return view('admin.categories.index', [
                'rootCategories' => [],
                'searchResults' => $matchingCategories,
                'isSearching' => true,
                'search' => $search,
                'totalCount' => Category::count(),
                'level1Count' => Category::where('level', 1)->count(),
                'level2Count' => Category::where('level', 2)->count(),
                'level3Count' => Category::where('level', 3)->count(),
                'level4Count' => Category::where('level', 4)->count(),
            ]);
        }

        $rootCategories = $query->get();

        return view('admin.categories.index', [
            'rootCategories' => $rootCategories,
            'searchResults' => [],
            'isSearching' => false,
            'search' => '',
            'totalCount' => Category::count(),
            'level1Count' => Category::where('level', 1)->count(),
            'level2Count' => Category::where('level', 2)->count(),
            'level3Count' => Category::where('level', 3)->count(),
            'level4Count' => Category::where('level', 4)->count(),
        ]);
    }

    /**
     * Show form to create a new category.
     */
    public function create(Request $request)
    {
        $preselectedParentId = $request->query('parent_id');
        $selectTree = Category::getSelectTree();

        return view('admin.categories.create', [
            'selectTree' => $selectTree,
            'preselectedParentId' => $preselectedParentId,
            'colors' => [
                'orange' => 'Amber Orange (#F97316)',
                'blue' => 'Cobalt Blue (#3B82F6)',
                'green' => 'Emerald Green (#10B981)',
                'purple' => 'Royal Purple (#8B5CF6)',
                'amber' => 'Industrial Gold (#EAB308)',
                'slate' => 'Slate Gray (#64748B)',
            ]
        ]);
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'parent_id' => 'nullable|exists:categories,id',
            'color' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->name);
        // Ensure unique slug
        $origSlug = $slug;
        $counter = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = "{$origSlug}-{$counter}";
            $counter++;
        }

        $parent = $request->parent_id ? Category::find($request->parent_id) : null;
        $level = $parent ? min(4, $parent->level + 1) : 1;
        $color = $request->color ?: ($parent ? $parent->color : 'amber');

        $category = Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'parent_id' => $request->parent_id ?: null,
            'level' => $level,
            'color' => $color,
            'icon' => $request->icon ?: null,
            'sort_order' => (int) ($request->sort_order ?? 0),
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? (bool) $request->is_active : true,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', "Category '{$category->name}' (Level {$category->level}) created successfully!");
    }

    /**
     * Show form to edit an existing category.
     */
    public function edit(Category $category)
    {
        // Exclude self from parent select tree to avoid cyclic loops
        $selectTree = Category::getSelectTree($category->id);

        return view('admin.categories.edit', [
            'category' => $category,
            'selectTree' => $selectTree,
            'colors' => [
                'orange' => 'Amber Orange (#F97316)',
                'blue' => 'Cobalt Blue (#3B82F6)',
                'green' => 'Emerald Green (#10B981)',
                'purple' => 'Royal Purple (#8B5CF6)',
                'amber' => 'Industrial Gold (#EAB308)',
                'slate' => 'Slate Gray (#64748B)',
            ]
        ]);
    }

    /**
     * Update an existing category.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => "nullable|string|max:255|unique:categories,slug,{$category->id}",
            'parent_id' => [
                'nullable',
                'exists:categories,id',
                function ($attribute, $value, $fail) use ($category) {
                    if ($value == $category->id) {
                        $fail('A category cannot be its own parent.');
                    }
                    if ($value && in_array($value, $category->getAllCategoryIds())) {
                        $fail('A category cannot have one of its descendant subcategories as its parent.');
                    }
                }
            ],
            'color' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->name);
        $parent = $request->parent_id ? Category::find($request->parent_id) : null;
        $level = $parent ? min(4, $parent->level + 1) : 1;

        $category->update([
            'name' => $request->name,
            'slug' => $slug,
            'parent_id' => $request->parent_id ?: null,
            'level' => $level,
            'color' => $request->color ?: ($parent ? $parent->color : $category->color),
            'icon' => $request->icon ?: $category->icon,
            'sort_order' => (int) ($request->sort_order ?? 0),
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? (bool) $request->is_active : true,
        ]);

        // Recursively update levels of any child categories
        $this->updateDescendantLevels($category);

        return redirect()->route('admin.categories.index')
            ->with('success', "Category '{$category->name}' updated successfully!");
    }

    /**
     * Recursively update descendant levels after re-parenting.
     */
    private function updateDescendantLevels(Category $category): void
    {
        foreach ($category->children as $child) {
            $child->level = min(4, $category->level + 1);
            $child->saveQuietly();
            $this->updateDescendantLevels($child);
        }
    }

    /**
     * Delete a category.
     */
    public function destroy(Category $category)
    {
        $name = $category->name;
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', "Category '{$name}' and its subcategories deleted successfully.");
    }
}
