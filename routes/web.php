<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\FrontAuthController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Frontend\GroupController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\CampaignController;
use App\Http\Controllers\Frontend\ReferralController;
use App\Http\Controllers\Frontend\MailingListController;
use App\Http\Controllers\Frontend\AutoresponderController;
use App\Http\Controllers\Frontend\EmailStatsController;
use App\Http\Controllers\Frontend\SavedTemplateController;
use App\Http\Controllers\Frontend\ImageGalleryController;
use App\Http\Controllers\Frontend\ContactMessageController;

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
use App\Http\Controllers\Admin\CampaignController as AdmincampaignController;
use App\Http\Controllers\Admin\ContactQueryController;
use App\Http\Controllers\Admin\UserTemplateController;

use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/privacy-policy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
Route::get('/pricing', [HomeController::class, 'pricing'])->name('pricing');
Route::get('/antispam', [HomeController::class, 'antispam'])->name('antispam');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/resource', [HomeController::class, 'resource'])->name('resource');
Route::get('/feature', [HomeController::class, 'feature'])->name('feature');
Route::get('/template', [HomeController::class, 'template'])->name('template');
Route::get('/email/track/open/{recipient}', [CampaignController::class, 'trackOpen'])
    ->name('email.track.open');
Route::get('/contact', [ContactMessageController::class, 'index'])
    ->name('contact');
Route::post('/contact', [ContactMessageController::class, 'store'])
    ->name('contact.store');
Route::get('/managed-accounts', [HomeController::class, 'managedAccounts'])
    ->name('managed-accounts');

/*
|--------------------------------------------------------------------------
| Guest Routes (Frontend Auth)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [FrontAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [FrontAuthController::class, 'login'])->name('login.submit');

    Route::get('/register', [FrontAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [FrontAuthController::class, 'register'])->name('register.submit');

    Route::get('/forgot-password', [FrontAuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [FrontAuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [FrontAuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [FrontAuthController::class, 'resetPassword'])->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Protected User Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/account/details', [UserController::class, 'edit'])
        ->name('account.edit');
    Route::get('/account/details', [UserController::class, 'profile'])
        ->name('account.profile');
    Route::put('/account/details', [UserController::class, 'updateProfile'])
        ->name('account.update');
    Route::get('/account/billing', [UserController::class, 'billing'])
        ->name('account.billing');
    Route::get('/account/subscription', [UserController::class, 'subscription'])
        ->name('account.subscription');
    Route::get('/account/change-password', [UserController::class, 'changePassword'])
        ->name('account.password');
    Route::put('/account/change-password', [UserController::class, 'updatePassword'])
        ->name('account.password.update');
    Route::get('/account/upgrade-package', [UserController::class, 'upgradePackage'])
        ->name('account.upgrade');
    Route::post('/account/upgrade-package', [UserController::class, 'upgradePackageStore'])
        ->name('account.upgrade.store');
    Route::get('/account/payment-history', [UserController::class, 'paymentHistory'])
        ->name('account.payment.history');
    Route::resource('image-gallery', ImageGalleryController::class)
        ->except(['show'])
        ->names('image-gallery');
    Route::post('/logout', [FrontAuthController::class, 'logout'])->name('logout');

    Route::resource('groups', GroupController::class);
    Route::post('/groups/activate', [GroupController::class, 'activate'])->name('groups.activate');
    Route::post('/groups/deactivate', [GroupController::class, 'deactivate'])->name('groups.deactivate');
    Route::post('/groups/delete', [GroupController::class, 'bulkDelete'])->name('groups.bulk-delete');
    Route::get('/groups/{group}/contacts', [ContactController::class, 'index'])->name('groups.contacts.index');

    Route::get('/contacts/import', [ContactController::class, 'createImport'])->name('contacts.import');
    Route::post('/contacts/import', [ContactController::class, 'import'])->name('contacts.import.store');

    Route::post('/contacts/activate', [ContactController::class, 'activate'])->name('contacts.activate');
    Route::post('/contacts/deactivate', [ContactController::class, 'deactivate'])->name('contacts.deactivate');
    Route::post('/contacts/bulk-delete', [ContactController::class, 'bulkDelete'])->name('contacts.bulk-delete');

    Route::resource('campaigns', CampaignController::class);

    Route::get('/campaigns/{campaign}/groups', [CampaignController::class, 'groups'])->name('campaigns.groups');
    Route::post('/campaigns/{campaign}/groups', [CampaignController::class, 'saveGroups'])->name('campaigns.groups.store');
    Route::get('/campaigns/{campaign}/templates', [CampaignController::class, 'templates'])->name('campaigns.templates');
    Route::post('/campaigns/{campaign}/templates', [CampaignController::class, 'saveTemplate'])->name('campaigns.templates.store');
    Route::get('/campaigns/{campaign}/editor', [CampaignController::class, 'editor'])->name('campaigns.editor');
    Route::post('/campaigns/{campaign}/editor', [CampaignController::class, 'saveEditor'])->name('campaigns.editor.store');
    Route::get('/campaigns/{campaign}/send', [CampaignController::class, 'send'])->name('campaigns.send');
    Route::post('/campaigns/{campaign}/send', [CampaignController::class, 'sendCampaign'])->name('campaigns.send.store');

    Route::get('/referral', [ReferralController::class, 'index'])
        ->name('referral');

    Route::post('/referral', [ReferralController::class, 'store'])
        ->name('referral.store');

    Route::get('/mailing-list', [MailingListController::class, 'index'])
        ->name('mailing-list');

    Route::post('/mailing-list', [MailingListController::class, 'store'])
        ->name('mailing-list.store');

    Route::get('/contacts/assign', [ContactController::class, 'assignContacts'])
        ->name('contacts.assign');

    Route::post('/contacts/assign', [ContactController::class, 'assignContactsStore'])
        ->name('contacts.assign.store');

    // Auto Responders routes

    Route::get('/autoresponders', [
        AutoresponderController::class,
        'index'
    ])->name('autoresponders.index');


    Route::get('/autoresponders/create', [
        AutoresponderController::class,
        'create'
    ])->name('autoresponders.create');


    Route::post('/autoresponders/create', [
        AutoresponderController::class,
        'selectType'
    ])->name('autoresponders.type');


    Route::get('/autoresponders/copy', [
        AutoresponderController::class,
        'copy'
    ])->name('autoresponders.copy');


    Route::post('/autoresponders/copy', [
        AutoresponderController::class,
        'copyCampaign'
    ])->name('autoresponders.copy.store');


    Route::post('/autoresponders', [
        AutoresponderController::class,
        'store'
    ])->name('autoresponders.store');


    Route::get('/autoresponders/{autoresponder}/edit', [
        AutoresponderController::class,
        'edit'
    ])->name('autoresponders.edit');


    Route::put('/autoresponders/{autoresponder}', [
        AutoresponderController::class,
        'update'
    ])->name('autoresponders.update');


    Route::post('/autoresponders/{autoresponder}/activate', [
        AutoresponderController::class,
        'activate'
    ])->name('autoresponders.activate');


    Route::post('/autoresponders/{autoresponder}/pause', [
        AutoresponderController::class,
        'pause'
    ])->name('autoresponders.pause');


    Route::post('/autoresponders/{autoresponder}/duplicate', [
        AutoresponderController::class,
        'duplicate'
    ])->name('autoresponders.duplicate');


    Route::delete('/autoresponders/{autoresponder}', [
        AutoresponderController::class,
        'destroy'
    ])->name('autoresponders.destroy');

    Route::post('/autoresponders/delete', [
        AutoresponderController::class,
        'bulkDestroy'
    ])->name('autoresponders.destroy.bulk');

    Route::get('/autoresponders/{autoresponder}/groups', [
        AutoresponderController::class,
        'groups'
    ])->name('autoresponders.groups');

    Route::get('/autoresponders/{autoresponder}/schedule', [
        AutoresponderController::class,
        'schedule'
    ])->name('autoresponders.schedule');

    Route::get('/autoresponders/info', [
        AutoresponderController::class,
        'info'
    ])->name('autoresponders.info');

    // email stats routes

    Route::get('/email-stats', [
        EmailStatsController::class,
        'index'
    ])->name('email-stats.index');

    Route::get('/email-stats/{campaign}', [
        EmailStatsController::class,
        'show'
    ])->name('email-stats.show');

    Route::get('/email-stats/{campaign}/itemized', [
        EmailStatsController::class,
        'itemized'
    ])->name('email-stats.itemized');

    Route::get('/email-stats/export', [
        EmailStatsController::class,
        'export'
    ])->name('email-stats.export');

    Route::post('/email-stats/delete', [
        EmailStatsController::class,
        'destroy'
    ])->name('email-stats.destroy');

    // bad contacts 
    // Special contact routes

    Route::get('/contacts/assign', [
        ContactController::class,
        'assignContacts'
    ])->name('contacts.assign');

    Route::post('/contacts/assign', [
        ContactController::class,
        'assignContactsStore'
    ])->name('contacts.assign.store');

    Route::get('/contacts/bad-report', [
        ContactController::class,
        'badContactsReport'
    ])->name('contacts.bad-report');

    Route::get('/contacts/bad-report/{report}', [
        ContactController::class,
        'badContactsDetails'
    ])->name('contacts.bad-report.show');

    Route::post('/contacts/bad-report/delete', [
        ContactController::class,
        'deleteBadContactReports'
    ])->name('contacts.bad-report.delete');

    Route::resource('contacts', ContactController::class);

    // Templates routes

    Route::get('/saved-templates', [
        SavedTemplateController::class,
        'index'
    ])->name('saved-templates.index');

    Route::get('/saved-templates/create', [
        SavedTemplateController::class,
        'create'
    ])->name('saved-templates.create');

    Route::post('/saved-templates', [
        SavedTemplateController::class,
        'store'
    ])->name('saved-templates.store');

    Route::get('/saved-templates/{template}', [
        SavedTemplateController::class,
        'show'
    ])->name('saved-templates.show');

    Route::get('/saved-templates/{template}/edit', [
        SavedTemplateController::class,
        'edit'
    ])->name('saved-templates.edit');

    Route::put('/saved-templates/{template}', [
        SavedTemplateController::class,
        'update'
    ])->name('saved-templates.update');

    Route::post('/saved-templates/delete', [
        SavedTemplateController::class,
        'destroy'
    ])->name('saved-templates.destroy');

    Route::post('/saved-templates/{template}/activate', [
        SavedTemplateController::class,
        'activate'
    ])->name('saved-templates.activate');

    Route::post('/saved-templates/{template}/deactivate', [
        SavedTemplateController::class,
        'deactivate'
    ])->name('saved-templates.deactivate');

    Route::post('/saved-templates/{template}/duplicate', [
        SavedTemplateController::class,
        'duplicate'
    ])->name('saved-templates.duplicate');

});

Route::get('/test-logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
});

/*
|--------------------------------------------------------------------------
| Admin Guest Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('admin.password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('admin.password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('admin.password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('admin.password.update');
});

/*
|--------------------------------------------------------------------------
| Admin Protected Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
    Route::get('/create-package', [DashboardController::class, 'create_package'])
        ->name('admin.createpackage');

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

    Route::resource('campaigns', AdminCampaignController::class)->names('admin.campaigns');
    Route::get('/campaigns/{id}/contacts-json', [AdminCampaignController::class, 'getCampaignContacts'])->name('campaigns.contacts.json');

    Route::get('/contact-queries', [ContactQueryController::class, 'index'])->name('admin.contact-queries.index');
    Route::delete('/contact-queries/{id}', [ContactQueryController::class, 'destroy'])->name('admin.contact-queries.destroy');

    Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::post('/profile/update-details', [ProfileController::class, 'updateDetails'])->name('admin.profile.update');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('admin.profile.password');

    Route::resource('user-templates', UserTemplateController::class)->names('admin.user-templates')->except(['show']);


});