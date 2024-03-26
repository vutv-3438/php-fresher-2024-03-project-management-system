<?php

use App\Http\Controllers\WorkFlowController;
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
    Route::resource('workFlows', WorkFlowController::class);
});
