<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'level',
        'color',
        'icon',
        'sort_order',
        'description',
        'image',
        'is_active',
    ];

    protected $casts = [
        'level' => 'integer',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Boot method to auto-generate slug and compute hierarchical level.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function (Category $category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }

            if (!empty($category->parent_id)) {
                $parent = Category::find($category->parent_id);
                $category->level = $parent ? min(4, $parent->level + 1) : 1;
            } else {
                $category->level = 1;
            }
        });
    }

    /**
     * Parent category relationship.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Direct child categories.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Recursive child categories.
     */
    public function allChildren(): HasMany
    {
        return $this->children()->with('allChildren');
    }

    /**
     * Direct products in this category.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    /**
     * Get all descendant category IDs (including self).
     */
    public function getAllCategoryIds(): array
    {
        $ids = [$this->id];
        foreach ($this->children as $child) {
            $ids = array_merge($ids, $child->getAllCategoryIds());
        }
        return $ids;
    }

    /**
     * Get full breadcrumb path (e.g., "Cutting Tools > Reamers & Deburring > Machine Reamers").
     */
    public function getBreadcrumbPathAttribute(): string
    {
        $parts = [$this->name];
        $curr = $this->parent;
        while ($curr) {
            array_unshift($parts, $curr->name);
            $curr = $curr->parent;
        }
        return implode(' > ', $parts);
    }

    /**
     * Get level badge name (Level 1 Root, Level 2 Subcategory, Level 3 Sub-sub, Level 4 Series).
     */
    public function getLevelNameAttribute(): string
    {
        return match ($this->level) {
            1 => 'Level 1: Root',
            2 => 'Level 2: Subcategory',
            3 => 'Level 3: Sub-Subcategory',
            4 => 'Level 4: Series / Leaf',
            default => 'Level ' . $this->level,
        };
    }

    /**
     * Return a flat list with indentation tree prefixes for dropdown menus.
     * Example output:
     * [
     *   ['id' => 1, 'name' => 'Cutting Tools', 'level' => 1, 'display' => 'Cutting Tools (Level 1)'],
     *   ['id' => 6, 'name' => 'Reamers & Deburring', 'level' => 2, 'display' => '── Reamers & Deburring (Level 2)'],
     *   ['id' => 12, 'name' => 'Machine Reamers', 'level' => 3, 'display' => '──── Machine Reamers (Level 3)'],
     * ]
     */
    public static function getSelectTree($excludeId = null, $maxLevel = 4): array
    {
        $roots = self::whereNull('parent_id')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->with('allChildren')
            ->get();

        $list = [];
        foreach ($roots as $root) {
            self::flattenTree($root, $list, 0, $excludeId, $maxLevel);
        }

        return $list;
    }

    /**
     * Recursively flatten tree for select options.
     */
    private static function flattenTree(Category $category, array &$list, int $depth = 0, $excludeId = null, int $maxLevel = 4): void
    {
        if ($excludeId && $category->id == $excludeId) {
            return;
        }

        if ($category->level > $maxLevel) {
            return;
        }

        $indent = str_repeat('── ', $depth);
        $prefix = $depth > 0 ? '└' . $indent : '';

        $list[] = [
            'id' => $category->id,
            'name' => $category->name,
            'level' => $category->level,
            'display' => ($prefix ? $prefix . ' ' : '') . $category->name,
            'breadcrumb' => $category->breadcrumb_path,
            'color' => $category->color,
        ];

        foreach ($category->children as $child) {
            self::flattenTree($child, $list, $depth + 1, $excludeId, $maxLevel);
        }
    }
}
