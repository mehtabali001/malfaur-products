<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\PageContentController;
use App\Http\Controllers\Admin\SettingController;

/*
|--------------------------------------------------------------------------
| Public Web Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/products', function () {
    $products = \App\Models\Product::orderBy('created_at', 'desc')->get();
    return view('pages.products', compact('products'));
})->name('products');

Route::get('/products/{slug}', function ($slug) {
    try {
        $product = \App\Models\Product::where('slug', $slug)
            ->orWhere('id', $slug)
            ->firstOrFail();

        $relatedProducts = \App\Models\Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(10)
            ->get();

        if ($relatedProducts->count() < 6) {
            $extraProducts = \App\Models\Product::where('id', '!=', $product->id)
                ->whereNotIn('id', $relatedProducts->pluck('id'))
                ->limit(10 - $relatedProducts->count())
                ->get();
            $relatedProducts = $relatedProducts->concat($extraProducts);
        }
    } catch (\Exception $e) {
        abort(404, "Product not found");
    }

    return view('pages.product-details', compact('product', 'relatedProducts'));
})->name('products.show');

Route::get('/who-we-are', function () {
    return view('pages.about');
})->name('about');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Global login alias redirect
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes (Guest Access)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout.get');
});

/*
|--------------------------------------------------------------------------
| Protected Admin Control Panel Routes (Auth Required)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Admin Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Products Management (CRUD)
    Route::resource('products', ProductController::class);

    // Category Tree Hierarchy Management (CRUD)
    Route::resource('categories', CategoryController::class);

    // Customer Enquiries Management
    Route::resource('enquiries', EnquiryController::class)->only(['index', 'show', 'update', 'destroy']);

    // Page Content Management
    Route::get('pages', [PageContentController::class, 'index'])->name('pages.index');
    Route::post('pages', [PageContentController::class, 'update'])->name('pages.update');

    // Global Website Settings (Logo, Favicon, Contact Info, Footer)
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
});
