<?php

use App\Http\Controllers\Auth\GithubAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectInvitationController;
use App\Http\Controllers\ProjectUserController;
use App\Http\Controllers\TaskController;
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
        Route::get('/profile/{id}', 'show')->name('profile.show');
        Route::post('/profile/update_avatar', 'updateAvatar')->name('profile.avatar.update');
    });
    // Route::get('/profile', [::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::controller(ProjectController::class)->group(function() {
        Route::get('/project/{id}', 'index')->name('project.index');
        Route::post('/project/create', 'store')->name('project.store');
    });
    Route::controller(ProjectInvitationController::class)->group(function() {
        Route::post('/project/{project}/invitations', 'store')->name('project.invitation.store');
        Route::post('/invitations/{invitation}/accept', 'accept')->name('project.invitation.accept');
        Route::post('/invitations/{invitation}/reject', 'reject')->name('project.invitation.reject');
    });
    Route::controller(ProjectUserController::class)->group(function() {
        Route::delete('/project/{id}/delete', 'destroy')->name('project.user.delete');
    });
    Route::controller(TaskController::class)->group(function() {
        Route::post('/project/{id}/task/create', 'store')->name('task.store');
    });
});

Route::get('/auth/github', [GithubAuthController::class, 'redirect'])->name('github.login');
Route::get('/auth/github/callback', [GithubAuthController::class, 'callback']);

require __DIR__.'/auth.php';
