<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CampaignController as AdminCampaignController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BankAccountController;
use App\Http\Controllers\Admin\DonationController;
use App\Http\Controllers\CampaignController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CampaignController::class, 'index'])->name('campaigns.index');
Route::get('/campaign/{slug}', [CampaignController::class, 'show'])->name('campaigns.show');
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login']);
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Admin Protected
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Bank Accounts
    Route::resource('bank-accounts', BankAccountController::class)->except(['show']);

    // Campaigns
    Route::resource('campaigns', AdminCampaignController::class);

    // Donations
    Route::get('donations', [DonationController::class, 'index'])->name('donations.index');
    Route::get('donations/{donation}', [DonationController::class, 'show'])->name('donations.show');
    Route::post('donations/{donation}/verify', [DonationController::class, 'verify'])->name('donations.verify');
    Route::post('donations/{donation}/reject', [DonationController::class, 'reject'])->name('donations.reject');
});
