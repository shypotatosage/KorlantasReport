<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [UserController::class, 'store']);
Route::post('/login', [UserController::class, 'login']);

// Route::middleware('auth:sanctum')->group(function () {
    Route::post('/update-profile', [UserController::class, 'update']);
    Route::get('/get-user-info/{user_id}', [UserController::class, 'edit']);
    Route::get('/get-user-list', [UserController::class, 'index']);
    // Route::get('/get-user-list', [UserController::class, 'index'])->middleware('abilities:Admin');
    Route::post('/change-user-status', [UserController::class, 'changeUserStatus']);
    // Route::post('/change-user-status', [UserController::class, 'changeUserStatus'])->middleware('abilities:Admin');

    Route::post('/submit-report', [ReportController::class, 'store']);
    Route::post('/update-report', [ReportController::class, 'update']);
    Route::post('/process-report', [ReportController::class, 'processReport']);
    // Route::post('/process-report', [ReportController::class, 'processReport'])->middleware('abilities:Admin');
    Route::get('/get-user-reports/{user_id}', [ReportController::class, 'getUserReports']);
    Route::get('/get-report/{report_id}', [ReportController::class, 'getReport']);
    Route::get('/get-reports', [ReportController::class, 'getReports']);
    // Route::get('/get-reports', [ReportController::class, 'getReports'])->middleware('abilities:Admin');
// });