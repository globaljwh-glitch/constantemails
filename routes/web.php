<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\FrontAuthController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Frontend\GroupController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\TemplateCategoryController;
use App\Http\Controllers\Admin\TemplateController;
use App\Http\Controllers\Admin\ContactCategoryController;
use App\Http\Controllers\Admin\ResourceCategoryController;
use App\Http\Controllers\Admin\ResourceArticleController;
use App\Http\Controllers\Admin\CmsArticleController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\MailTemplateController;
use App\Http\Controllers\Admin\ProfileController;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Frontend\CampaignController;

use App\Http\Controllers\Admin\AuthController as AdminAuthController;

Route::get('/privacy-policy', [HomeController::class, 'privacy'])
    ->name('privacy');
Route::get('/terms', [HomeController::class, 'terms'])
    ->name('terms');
Route::get('/pricing', [HomeController::class, 'pricing'])
    ->name('pricing');
Route::get('/antispam', [HomeController::class, 'antispam'])
    ->name('antispam');
Route::get('/contact', [HomeController::class, 'contact'])
    ->name('contact');
Route::get('/resource', [HomeController::class, 'resource'])
    ->name('resource');
Route::get('/feature', [HomeController::class, 'feature'])
    ->name('feature');
Route::get('/template', [HomeController::class, 'template'])
    ->name('template');

Route::middleware(['auth'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        // Route::get('/dashboard', [DashboardController::class, 'index'])
        //     ->name('dashboard');
        Route::get('/dashboard', [UserController::class, 'dashboard'])
            ->name('dashboard');

        Route::resource('groups', GroupController::class);

        // Route::get('/contacts/import', [ContactController::class,'createImport'])
        //     ->name('user.contacts.import.create');
    
        // Route::post('/contacts/import', [ContactController::class,'import'])
        //     ->name('user.contacts.import');
    
        Route::get('/contacts/import', [ContactController::class, 'createImport'])
            ->name('contacts.import');


    });

Route::get('/test-logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
});


// Route::middleware('auth')->group(function () {

//     Route::get('/dashboard', [UserController::class, 'dashboard'])
//         ->name('user.dashboard');

//     Route::post('/logout', [FrontAuthController::class, 'logout'])
//         ->name('user.logout');
// });

Route::middleware('auth')
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        Route::get('/dashboard', [UserController::class, 'dashboard'])
            ->name('dashboard');

        Route::post('/logout', [FrontAuthController::class, 'logout'])
            ->name('logout');

        Route::resource('groups', GroupController::class);

        Route::get('/contacts/import', [ContactController::class, 'createImport'])
            ->name('contacts.import');

        // Route::post('/contacts/import', [ContactController::class, 'storeImport'])
        //     ->name('contacts.import.store');
    
        Route::post('/contacts/import', [ContactController::class, 'import'])
            ->name('contacts.import.store');

        Route::post('/groups/activate', [GroupController::class, 'activate'])
            ->name('groups.activate');

        Route::post('/groups/deactivate', [GroupController::class, 'deactivate'])
            ->name('groups.deactivate');

        Route::post('/groups/delete', [GroupController::class, 'bulkDelete'])
            ->name('groups.bulk-delete');

        Route::get('/groups/{group}/contacts', [ContactController::class, 'index'])
            ->name('groups.contacts.index');

        Route::get('/groups/{group}/edit', [GroupController::class, 'edit'])
            ->name('groups.edit');

        Route::put('/groups/{group}', [GroupController::class, 'update'])
            ->name('groups.update');

        Route::get('/contacts/{contact}/edit', [ContactController::class, 'edit'])
            ->name('contacts.edit');

        Route::put('/contacts/{contact}', [ContactController::class, 'update'])
            ->name('contacts.update');

        Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])
            ->name('contacts.destroy');

        Route::get('/contacts/create', [ContactController::class, 'create'])
            ->name('contacts.create');

        Route::post('/contacts', [ContactController::class, 'store'])
            ->name('contacts.store');

        // Route::get('/contacts/{contact}/edit', [ContactController::class, 'edit'])
        //     ->name('contacts.edit');
    
        // Route::put('/contacts/{contact}', [ContactController::class, 'update'])
        //     ->name('contacts.update');
    
        Route::post('/contacts/activate', [ContactController::class, 'activate'])
            ->name('contacts.activate');

        Route::post('/contacts/deactivate', [ContactController::class, 'deactivate'])
            ->name('contacts.deactivate');

        Route::post('/contacts/bulk-delete', [ContactController::class, 'bulkDelete'])
            ->name('contacts.bulk-delete');

        Route::resource('campaigns', CampaignController::class);

        Route::get(
            '/campaigns/{campaign}/groups',
            [CampaignController::class, 'groups']
        )->name('campaigns.groups');

        Route::post(
            '/campaigns/{campaign}/groups',
            [CampaignController::class, 'saveGroups']
        )->name('campaigns.groups.store');

        Route::get(
            '/campaigns/{campaign}/templates',
            [CampaignController::class, 'templates']
        )->name('campaigns.templates');

        Route::post(
            '/campaigns/{campaign}/templates',
            [CampaignController::class, 'saveTemplate']
        )->name('campaigns.templates.store');

        Route::get(
            '/campaigns/{campaign}/editor',
            [CampaignController::class, 'editor']
        )->name('campaigns.editor');

        Route::post(
            '/campaigns/{campaign}/editor',
            [CampaignController::class, 'saveEditor']
        )->name('campaigns.editor.store');

        Route::get(
            '/campaigns/{campaign}/send',
            [CampaignController::class, 'send']
        )->name('campaigns.send');

        Route::post(
            '/campaigns/{campaign}/send',
            [CampaignController::class, 'sendCampaign']
        )->name('campaigns.send.store');

    });

Route::get('/pricing', [HomeController::class, 'pricing'])->name('pricing');
/*
|--------------------------------------------------------------------------
| Frontend
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Route::get('/login', [FrontAuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [FrontAuthController::class, 'login'])
        ->name('login.submit');

    Route::get('/register', [FrontAuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [FrontAuthController::class, 'register'])
        ->name('register.submit');

    Route::get('/forgot-password', [FrontAuthController::class, 'showForgotPassword'])
        ->name('password.request');

    Route::post('/forgot-password', [FrontAuthController::class, 'sendResetLink'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [FrontAuthController::class, 'showResetPassword'])
        ->name('password.reset');

    Route::post('/reset-password', [FrontAuthController::class, 'resetPassword'])
        ->name('password.update');
});




// Protected Routes

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

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

        Route::resource('users', AdminUserController::class)->except(['show']);

        Route::resource('email-templates', MailTemplateController::class)->except(['show']);

        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');

        Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile');
        Route::post('/profile/update-details', [ProfileController::class, 'updateDetails'])->name('admin.profile.update');
        Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('admin.profile.password');

    });
