<?php

use App\Http\Controllers\RoleController;
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
    Route::resource('roles', RoleController::class);
    Route::put('roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::patch('roles/{role}', [RoleController::class, 'changeRoleDefault'])
        ->name('roles.changeDefaultRole');
});
