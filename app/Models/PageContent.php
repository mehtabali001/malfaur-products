<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PageContent extends Model
{
    protected $fillable = [
        'page',
        'section',
        'title',
        'subtitle',
        'content',
        'image',
        'meta_data'
    ];

    protected $casts = [
        'meta_data' => 'array'
    ];

    /**
     * Get section content for a page as array.
     */
    public static function getSection(string $page, string $section)
    {
        try {
            return Cache::remember("page_content_{$page}_{$section}", 3600, function () use ($page, $section) {
                $record = static::where('page', $page)->where('section', $section)->first();
                return $record ? $record->toArray() : [];
            });
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Update or create a page section.
     */
    public static function setSection(string $page, string $section, array $data)
    {
        Cache::forget("page_content_{$page}_{$section}");
        return static::updateOrCreate(
            ['page' => $page, 'section' => $section],
            $data
        );
    }
}
