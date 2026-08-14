<?php /*

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\UserController;

Route::middleware('guest')->group(function () {

    Route::get('/login', [UserController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [UserController::class, 'login']);

    Route::get('/register', [UserController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [UserController::class, 'register']);

    Route::get('/forgot-password', [UserController::class, 'showForgotPassword'])
        ->name('password.request');

    Route::post('/forgot-password', [UserController::class, 'sendResetLink'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [UserController::class, 'showResetPassword'])
        ->name('password.reset');

    Route::post('/reset-password', [UserController::class, 'resetPassword'])
        ->name('password.update');
});

Route::middleware('auth')->group(function () {

    Route::post('/logout', [UserController::class, 'logout'])
        ->name('logout');

});

Route::get('/', [HomeController::class,'index'])->name('home');

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');
});

Route::get('/admin', function () {
    return view('admin.dashboard.index');
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
        ->name('logout');

});
*/


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Admin\DashboardController;

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

    Route::get('/login', [UserController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [UserController::class, 'login'])
        ->name('login.submit');

    Route::get('/register', [UserController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [UserController::class, 'register'])
        ->name('register.submit');

    Route::get('/forgot-password', [UserController::class, 'showForgotPassword'])
        ->name('password.request');

    Route::post('/forgot-password', [UserController::class, 'sendResetLink'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [UserController::class, 'showResetPassword'])
        ->name('password.reset');

    Route::post('/reset-password', [UserController::class, 'resetPassword'])
        ->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Authenticated User
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::post('/logout', [UserController::class, 'logout'])
        ->name('logout');
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
