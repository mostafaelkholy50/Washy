<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\OrderController;

Route::get('lang/{locale}', [App\Http\Controllers\LanguageController::class, 'switch'])->name('lang.switch');

Route::get('/', function () {
    $locale = request()->get('lang', 'ar');
    app()->setLocale($locale);
    $slides = \App\Models\Slide::where('is_active', true)->orderBy('sort_order')->get();
    $setting = \App\Models\Setting::first();
    $services = \App\Models\Service::all();
    $members = \App\Models\Member::all();
    $skills = \App\Models\Skill::all();
    $categories = \App\Models\Category::all();
    $portfolios = \App\Models\Portfolio::with('category')->get();
    $posts = \App\Models\Post::latest()->take(3)->get();
    $timelines = \App\Models\Timeline::orderBy('year', 'desc')->get();
    return view('index', compact('slides', 'setting', 'services', 'members', 'skills', 'categories', 'portfolios', 'posts', 'timelines'));
});

// Auth Routes
Route::get('login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Settings Routes
    Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

    // Slides Routes
    Route::resource('slides', App\Http\Controllers\Admin\SlideController::class)->except(['show']);

    // Services Routes
    Route::resource('services', App\Http\Controllers\Admin\ServiceController::class)->except(['show']);

    // Portfolios Routes
    Route::resource('portfolios', App\Http\Controllers\Admin\PortfolioController::class)->except(['show']);

    // Posts Routes
    Route::resource('posts', App\Http\Controllers\Admin\PostController::class)->except(['show']);

    // Members Routes
    Route::resource('members', App\Http\Controllers\Admin\MemberController::class)->except(['show']);

    // Users Routes
    Route::resource('users', App\Http\Controllers\Admin\UserController::class)->except(['show']);

    // Categories Routes
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class)->except(['show']);

    // Skills Routes
    Route::resource('skills', App\Http\Controllers\Admin\SkillController::class)->except(['show']);

    // Timelines Routes
    Route::resource('timelines', App\Http\Controllers\Admin\TimelineController::class)->except(['show']);

    //  Customers Routes
    Route::resource('customers', CustomerController::class)->names('customers');

    // Product Routes
    Route::resource('products', ProductController::class)->names('products');

    // Payment Routes
    Route::resource('payments', PaymentController::class)->names('payments');
    Route::get('payments/{payment}/print', [PaymentController::class, 'printView'])
        ->name('payments.print');

    //Orders
    Route::get('orders/{order}/pdf', [OrderController::class, 'downloadPdf'])->name('orders.pdf');
    Route::get('orders/{order}/print', [OrderController::class, 'printView'])->name('orders.print');
    Route::resource('orders', OrderController::class)->names('orders');

    // Currencies
    Route::post('currencies/{currency}/favorite', [App\Http\Controllers\Admin\CurrencyController::class, 'makeFavorite'])->name('currencies.favorite');
    Route::resource('currencies', App\Http\Controllers\Admin\CurrencyController::class)->names('currencies');
    // Balances
    Route::get('balances', [App\Http\Controllers\Admin\BalanceController::class, 'index'])
    ->name('balances.index');
});
