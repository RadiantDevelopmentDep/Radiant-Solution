<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ServiceQueryController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\MultiServiceController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/service-query', [ServiceQueryController::class, 'store']);
Route::get('/jobs', [JobController::class, 'index']);
Route::post('/apply', [JobController::class, 'apply']);

Route::post('/multi-services-inquiry', [MultiServiceController::class, 'store']);
