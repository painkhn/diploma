<?php

use App\Http\Controllers\Auth\GithubAuthController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectInvitationController;
use App\Http\Controllers\ProjectUserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TaskController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
        Route::get('/project/page/{id}', 'index')->name('project.index');
        Route::patch('/project/{project}/update', 'update')->name('project.update');
        Route::post('/project/create', 'store')->name('project.store');
        Route::delete('/project/{project}/delete', 'destroy')->name('project.delete');
    });
    Route::controller(ProjectInvitationController::class)->group(function() {
        Route::post('/project/{project}/invitations', 'store')->name('project.invitation.store');
        Route::post('/invitations/{invitation}/accept', 'accept')->name('project.invitation.accept');
        Route::post('/invitations/{invitation}/reject', 'reject')->name('project.invitation.reject');
    });
    Route::controller(ProjectUserController::class)->group(function() {
        Route::delete('/project/{projectId}/user/{userId}', 'destroy')->name('project.user.delete');
        Route::patch('/project/{projectId}/user/{userId}/update', 'updateRole')->name('project.user.role.update');
    });
    Route::controller(TaskController::class)->group(function() {
        Route::post('/project/{id}/task/create', 'store')->name('task.store');
    });
    Route::controller(ReportController::class)->group(function() {
        Route::post('/task/{id}/report', 'store')->name('report.store');
    });
    Route::controller(TaskController::class)->group(function() {
        Route::patch('/task/{task}/update', 'update')->name('task.update');
        Route::patch('/task/{task}/cancel', 'cancel')->name('task.cancel');
        Route::patch('/task/{task}/returnBack', 'returnBack')->name('task.returnBack');
    });
    Route::controller(FriendController::class)->group(function() {
        Route::get('/profile/{id}/friends', 'index')->name('friend.index');
        Route::post('/friend/store', 'store')->name('friend.store');
        Route::patch('/friend/invitation/{id}/accept', 'accept')->name('friend.accept');
    });
});

Route::get('/auth/github', [GithubAuthController::class, 'redirect'])->name('github.login');
Route::get('/auth/github/callback', [GithubAuthController::class, 'callback']);

require __DIR__.'/auth.php';



