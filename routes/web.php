<?php 

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\FrontAuthController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Frontend\GroupController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Admin\DashboardController;

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

        Route::post('/groups/activate', [GroupController::class,'activate'])
            ->name('groups.activate');

        Route::post('/groups/deactivate', [GroupController::class,'deactivate'])
            ->name('groups.deactivate');

        Route::post('/groups/delete', [GroupController::class,'bulkDelete'])
            ->name('groups.bulk-delete');
        
        Route::get('/groups/{group}/contacts', [ContactController::class,'index'])
            ->name('groups.contacts');

        Route::get('/groups/{group}/edit', [GroupController::class, 'edit'])
            ->name('groups.edit');

        Route::put('/groups/{group}', [GroupController::class, 'update'])
            ->name('groups.update');

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
    });

Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'admin']);


Route::prefix('admin')->middleware('guest')->group(function () {

    Route::get('/login', [AdminAuthController::class, 'showLogin'])
        ->name('admin.login');

    Route::post('/login', [AdminAuthController::class, 'login'])
        ->name('admin.login.submit');

});

Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('admin.dashboard');

        Route::post('/logout', [AdminAuthController::class, 'logout'])
            ->name('admin.logout');

});
