<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\JobAdminController;
/*
|--------------------------------------------------------------------------
| 1. ADMIN & AUTH ROUTES 
|--------------------------------------------------------------------------
*/

// Auth logic (Breeze routes like login, register etc)
require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Group
  Route::prefix('admin')->group(function () {
    Route::get('/inquiries', [ServiceController::class, 'inquiries'])->name('admin.inquiries.index');
    Route::patch('/inquiries/{id}/status', [ServiceController::class, 'updateStatus'])->name('admin.inquiries.update-status');
    Route::delete('/inquiries/{id}', [ServiceController::class, 'destroy'])->name('admin.inquiries.destroy');
    
    // Jobs Management
    Route::resource('jobs', JobAdminController::class);
    
    // Job Applications Management
    Route::get('job-applications', [JobAdminController::class, 'applications'])->name('jobs.applications');
    Route::delete('job-applications/{id}', [JobAdminController::class, 'destroyApplication'])->name('jobs.applications.destroy');
    
    Route::patch('job-applications/{id}/status', [JobAdminController::class, 'updateStatus'])->name('jobs.applications.updateStatus');
});
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Logout
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
});
Route::patch('/admin/multi-inquiries/{id}/status', [ServiceController::class, 'updateMultiStatus'])
    ->name('admin.multi-inquiries.update-status');
/*
|--------------------------------------------------------------------------
| 2. COMPANY FRONTEND 
|--------------------------------------------------------------------------
*/

// Route::get('/{any}', function () {
//     return file_get_contents(public_path('index.html'));
// })->where('any', '.*');

// Is route ko file ke bilkul END mein rakhein
Route::get('/{any}', function () {
    return file_get_contents(public_path('index.html'));
})->where('any', '^(?!api|login|register|dashboard|admin|logout).*$');