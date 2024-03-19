<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\LandingPageController::class, 'landingPage']);

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'dashboard'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::resource('users', \App\Http\Controllers\UserController::class)->middleware('admin');

Route::controller(\App\Http\Controllers\ProjectController::class)->group(function () {
    Route::prefix('projects')->group(function () {
        Route::get('', 'index')->name('projects.index');
        Route::get('create', 'create')->name('projects.create');
        Route::post('', 'store')->name('projects.store');
        Route::get('{id}', 'show')->name('projects.show');
        Route::get('{id}/edit', 'edit')->name('projects.edit');
        Route::put('{id}', 'update')->name('projects.update');
        Route::delete('{id}', 'destroy')->name('projects.destroy');
    });
});

Route::get('language/{lang}', [\App\Http\Controllers\LanguageController::class, 'changeLanguage'])
    ->name('language.change');

require __DIR__ . '/auth.php';
