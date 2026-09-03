<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\TemplateCategoryController;
use App\Http\Controllers\Admin\TemplateController;
use App\Http\Controllers\Admin\ContactCategoryController;
use App\Http\Controllers\Admin\ResourceCategoryController;
use App\Http\Controllers\Admin\ResourceArticleController;
use App\Http\Controllers\Admin\CmsArticleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\MailTemplateController;
use App\Http\Controllers\Admin\ProfileController;
use Illuminate\Support\Facades\Auth;

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');
});

Route::get('/admin', function () {
    return view('admin.dashboard.index');
});

Route::get('/', function () {

    if (Auth::check()) {

        if (Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        return abort(403);
    }

    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');

    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');

    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});




// Protected Routes
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('admin.dashboard');
        

        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('admin.logout');


        Route::get('/create-package', [DashboardController::class, 'create_package'])
            ->name('admin.createpackage');

        Route::get('/all-packages', [DashboardController::class, 'all_package'])
            ->name('admin.allpackages');

        Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
        Route::post('/packages/store', [PackageController::class, 'store'])->name('packages.store');
        Route::get('/packages/{id}/edit', [PackageController::class, 'edit'])->name('packages.edit');
        Route::put('/packages/{id}/update', [PackageController::class, 'update'])->name('packages.update');
        Route::delete('/packages/{id}/delete', [PackageController::class, 'destroy'])->name('packages.destroy');

        Route::get('/template-categories', [TemplateCategoryController::class, 'index'])->name('template-categories.index');
        Route::post('/template-categories/store', [TemplateCategoryController::class, 'store'])->name('template-categories.store');
        Route::get('/template-categories/{id}/edit', [TemplateCategoryController::class, 'edit'])->name('template-categories.edit');
        Route::put('/template-categories/{id}/update', [TemplateCategoryController::class, 'update'])->name('template-categories.update');
        Route::delete('/template-categories/{id}/delete', [TemplateCategoryController::class, 'destroy'])->name('template-categories.destroy');


        Route::get('/templates', [TemplateController::class, 'index'])->name('templates.index');
        Route::get('/templates/create', [TemplateController::class, 'create'])->name('templates.create');
        Route::post('/templates/store', [TemplateController::class, 'store'])->name('templates.store');
        Route::get('/templates/{id}/edit', [TemplateController::class, 'edit'])->name('templates.edit');
        Route::put('/templates/{id}/update', [TemplateController::class, 'update'])->name('templates.update');
        Route::delete('/templates/{id}/delete', [TemplateController::class, 'destroy'])->name('templates.destroy');

        Route::get('/contact-categories', [ContactCategoryController::class, 'index'])->name('contact-categories.index');
        Route::post('/contact-categories/store', [ContactCategoryController::class, 'store'])->name('contact-categories.store');
        Route::put('/contact-categories/{id}/update', [ContactCategoryController::class, 'update'])->name('contact-categories.update');
        Route::delete('/contact-categories/{id}/delete', [ContactCategoryController::class, 'destroy'])->name('contact-categories.destroy');


        Route::resource('resource-categories', ResourceCategoryController::class)->except(['create', 'edit', 'show']);
        Route::post('resource-categories/{id}/update', [ResourceCategoryController::class, 'update'])->name('resource-categories.update');


        Route::resource('resource-articles', ResourceArticleController::class)->except(['show']);

        Route::resource('cms-articles', CmsArticleController::class)->except(['show']);

        Route::resource('users', UserController::class)->except(['show']);

        Route::resource('email-templates', MailTemplateController::class)->except(['show']);

        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');

        Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile');
        Route::post('/profile/update-details', [ProfileController::class, 'updateDetails'])->name('admin.profile.update');
        Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('admin.profile.password');

    });
