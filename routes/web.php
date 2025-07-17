<?php

use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ResourceController;
use App\Http\Controllers\Admin\UnitController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::prefix('/profile')->name('profile.')->controller(ProfileController::class)->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::patch('/user', 'updateUser')->name('user.update');
        Route::post('/profile', 'updateProfile')->name('profile.update');
        Route::delete('/', 'destroy')->name('destroy');
    });

    Route::resource('levels', LevelController::class);
    Route::resource('units', UnitController::class);

    Route::resource('resources', ResourceController::class);
    Route::get('resources/{resource}/download', [ResourceController::class, 'download'])->name('resources.download');
});

require __DIR__ . '/auth.php';
