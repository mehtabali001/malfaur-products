<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'title',
        'name',
        'slug',
        'category_id',
        'category',
        'brand_id',
        'image',
        'short_description',
        'description',
        'specifications',
        'specs',
        'is_featured',
        'is_active'
    ];

    protected $casts = [
        'specifications' => 'array',
        'specs' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean'
    ];

    /**
     * Boot the model. Auto-generate slug if missing.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->title ?: $product->name ?: 'product');
            }
            if (empty($product->title) && !empty($product->name)) {
                $product->title = $product->name;
            }
            if (empty($product->name) && !empty($product->title)) {
                $product->name = $product->title;
            }
            // Auto map category_id if only category string provided
            if (empty($product->category_id) && !empty($product->category)) {
                $catMap = [
                    'Cutting Tools' => 1,
                    'Measuring Equipment' => 2,
                    'Standard Parts' => 3,
                    'Aerospace Parts' => 4,
                    'Raw Materials' => 5
                ];
                $product->category_id = $catMap[$product->category] ?? 1;
            }
        });
    }

    /**
     * Relationship to dynamic Category model.
     */
    public function categoryItem(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Map 'title' to 'name' for the view.
     */
    public function getNameAttribute()
    {
        return $this->attributes['name'] ?? $this->attributes['title'] ?? '';
    }

    /**
     * Map 'category_id' to category string name.
     */
    public function getCategoryAttribute()
    {
        if ($this->categoryItem) {
            return $this->categoryItem->name;
        }
        if (!empty($this->attributes['category'])) {
            return $this->attributes['category'];
        }
        return 'Cutting Tools';
    }

    /**
     * Category Breadcrumb Path (e.g. Cutting Tools > Reamers & Deburring > Machine Reamers).
     */
    public function getCategoryBreadcrumbAttribute(): string
    {
        return $this->categoryItem ? $this->categoryItem->breadcrumb_path : $this->category;
    }

    /**
     * Convert 'specifications' JSON object to specs array format.
     */
    public function getSpecsAttribute()
    {
        if (!empty($this->attributes['specs'])) {
            $decoded = is_string($this->attributes['specs']) ? json_decode($this->attributes['specs'], true) : $this->attributes['specs'];
            if (is_array($decoded) && count($decoded) > 0) {
                return $decoded;
            }
        }
        $specs = [];
        $rawSpecs = $this->specifications;
        if (is_array($rawSpecs)) {
            foreach ($rawSpecs as $key => $val) {
                if ($key !== 'dimensions' && $key !== 'dimension_image' && !str_ends_with($key, '_state') && is_string($val)) {
                    $specs[] = [$key, $val];
                }
            }
        }
        return $specs;
    }
}
