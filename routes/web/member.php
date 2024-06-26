<?php

use App\Http\Controllers\MemberController;
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

Route::prefix('projects/{projectId}')->group(function () {
    Route::resource('members', MemberController::class)
        ->except(['show', 'store']);
    Route::post('members/request', [MemberController::class, 'requestJoinProject'])
        ->name('members.request');
    Route::get('members/{token}', [MemberController::class, 'store'])
        ->name('members.store');
});
