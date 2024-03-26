<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web project routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(ProjectController::class)->group(function () {
    Route::prefix('projects')->group(function () {
        Route::get('', 'index')->name('projects.index');
        Route::get('create', 'create')->name('projects.create');
        Route::post('', 'store')->name('projects.store');
        Route::get('{id}/edit', 'edit')->name('projects.edit');
        Route::put('{id}', 'update')->name('projects.update');
        Route::delete('{id}', 'destroy')->name('projects.destroy');
    });
});
