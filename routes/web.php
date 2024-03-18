<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
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

Route::get('/', [LandingPageController::class, 'landingPage']);

Route::get('/dashboard', [DashboardController::class, 'dashboard'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::resource('users', UserController::class)->middleware('admin');

Route::controller(ProjectController::class)->group(function () {
    Route::prefix('projects')->group(function () {
        Route::get('', 'index')->name('projects.index');
        Route::get('create', 'create')->name('projects.create');
        Route::post('', 'store')->name('projects.store');
        Route::get('{project}', 'show')->name('projects.show');
        Route::get('{project}/edit', 'edit')->name('projects.edit');
        Route::put('{project}', 'update')->name('projects.update');
        Route::delete('{project}', 'delete')->name('projects.delete');
    });
});

require __DIR__ . '/auth.php';
