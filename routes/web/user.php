<?php

use App\Http\Controllers\MemberController;
use App\Http\Controllers\UserController;
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

Route::resource('users', UserController::class)
    ->middleware('admin')
    ->except(['show']);

Route::prefix('users')->name('users.')->group(function () {
    Route::patch('{user}/restore', [UserController::class, 'restore'])->name('restore');
});

