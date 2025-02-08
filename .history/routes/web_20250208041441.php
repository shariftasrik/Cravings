<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;

use App\Http\Controllers\ClientController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware('admin')->group(function (){
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');

    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/password/update', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');
});



Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');

Route::post('/admin/login_submit', [AdminController::class, 'AdminLoginSubmit'])->name('admin.login_submit');

Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');

Route::get('/admin/forget_password', [AdminController::class, 'AdminForgetPassword'])->name('admin.forget_password');

Route::post('/admin/password_submit', [AdminController::class, 'AdminPasswordSubmit'])->name('admin.password_submit');

Route::get('/admin/reset_password/{token}/{email}', [AdminController::class, 'AdminResetPassword']);

Route::post('/admin/reset_password_submit', [AdminController::class, 'AdminResetPasswordSubmit'])->name('admin.reset_password_submit');



// Clients (Restaurants Route)

Route::middleware('client')->group(function () {
    Route::get('/client/client_dashboard', [ClientController::class, 'ClientDashboard'])->name('client.dashboard');
    Route::get('/client/client_profile', [ClientController::class, 'ClientProfile'])->name('client.profile');

    Route::post('/client/profile/client_store', [ClientController::class, 'ClientProfileStore'])->name('client.profile.store');
    Route::get('/client/change/client_password', [ClientController::class, 'ClientChangePassword'])->name('client.change.password');
    Route::post('/client/password/client_update', [ClientController::class, 'ClientPasswordUpdate'])->name('client.password.update');
});

Route::get('/client/login', [ClientController::class, 'ClientLogin'])->name('client.login');
Route::post('/client/login_submit', [ClientController::class, 'ClientLoginSubmit'])->name('client.login_submit');

Route::get('/client/logout', [ClientController::class, 'ClientLogout'])->name('client.logout');

Route::get('/client/forget_password', [ClientController::class, 'ClientForgetPassword'])->name('client.forget_password');
Route::post('/client/password_submit', [ClientController::class, 'ClientPasswordSubmit'])->name('client.password_submit');

Route::get('/client/reset_password/{token}/{email}', [ClientController::class, 'ClientResetPassword']);
Route::post('/client/reset_password_submit', [ClientController::class, 'ClientResetPasswordSubmit'])->name('client.reset_password_submit');
