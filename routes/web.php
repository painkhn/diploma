<?php

use App\Http\Controllers\Auth\GithubAuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/', function() {
    return Inertia::render('Welcome');
})->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::controller(ProfileController::class)->group(function() {
        Route::get('/profile', 'show')->name('profile.show');
        Route::post('/profile/update_avatar', 'updateAvatar')->name('profile.avatar.update');
    });
    // Route::get('/profile', [::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/auth/github', [GithubAuthController::class, 'redirect'])->name('github.login');
Route::get('/auth/github/callback', [GithubAuthController::class, 'callback']);

require __DIR__.'/auth.php';
