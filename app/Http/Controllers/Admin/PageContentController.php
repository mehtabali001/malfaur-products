<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageContent;
use Illuminate\Support\Str;

class PageContentController extends Controller
{
    /**
     * Show page contents editor.
     */
    public function index(Request $request)
    {
        $activeTab = $request->get('tab', 'home');

        $homeHero = PageContent::getSection('home', 'hero');
        $aboutStory = PageContent::getSection('about', 'story');
        $contactInfo = PageContent::getSection('contact', 'info');
        $productsHero = PageContent::getSection('products', 'hero');

        return view('admin.pages.edit', compact(
            'activeTab',
            'homeHero',
            'aboutStory',
            'contactInfo',
            'productsHero'
        ));
    }

    /**
     * Update specified page section.
     */
    public function update(Request $request)
    {
        $request->validate([
            'page' => 'required|string',
            'section' => 'required|string',
            'title' => 'nullable|string|max:500',
            'subtitle' => 'nullable|string|max:1000',
            'content' => 'nullable|string',
            'badge' => 'nullable|string|max:255',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'image_url' => 'nullable|string|max:500',
        ]);

        $imagePath = $request->image_url;
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = time() . '_' . Str::slug($request->page . '-' . $request->section) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/uploads'), $fileName);
            $imagePath = 'images/uploads/' . $fileName;
        }

        $metaData = [];
        if ($request->filled('badge')) {
            $metaData['badge'] = $request->badge;
        }
        if ($request->filled('mission')) {
            $metaData['mission'] = $request->mission;
        }
        if ($request->filled('vision')) {
            $metaData['vision'] = $request->vision;
        }
        if ($request->filled('primary_btn_text')) {
            $metaData['primary_btn_text'] = $request->primary_btn_text;
        }
        if ($request->filled('secondary_btn_text')) {
            $metaData['secondary_btn_text'] = $request->secondary_btn_text;
        }

        $data = [
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'content' => $request->content,
            'meta_data' => $metaData,
        ];

        if (!empty($imagePath)) {
            $data['image'] = $imagePath;
        }

        PageContent::setSection($request->page, $request->section, $data);

        return redirect()->route('admin.pages.index', ['tab' => $request->page])->with('success', ucfirst($request->page) . ' page content updated successfully!');
    }
}
