<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BankAccountController;
use App\Http\Controllers\Admin\CampaignController as AdminCampaignController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DonationController as AdminDonationController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonationTrackingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CampaignController::class, 'index'])->name('campaigns.index');
Route::get('/campaign/{slug}', [CampaignController::class, 'show'])->name('campaigns.show');
Route::post('/campaign/{slug}/donation', [DonationController::class, 'store'])->name('campaigns.donate');
Route::get('/donations/{token}/confirmation', [DonationController::class, 'confirmation'])->name('donations.confirmation');
Route::get('/cek/{token}', [DonationTrackingController::class, 'show'])->name('donation.track');
Route::get('/lacak', [DonationTrackingController::class, 'index'])->name('donation.track.index');
Route::post('/lacak', [DonationTrackingController::class, 'search'])->name('donation.track.search');
Route::post('/admin/login', [AuthController::class, 'login']);
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Admin Protected
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Bank Accounts
    Route::resource('bank-accounts', BankAccountController::class)->except(['show']);

    // Campaigns
    Route::resource('campaigns', AdminCampaignController::class)->except(['show']);

    // Donations
    Route::get('donations', [AdminDonationController::class, 'index'])->name('donations.index');
    Route::get('donations/{donation}', [AdminDonationController::class, 'show'])->name('donations.show');
    Route::post('donations/{donation}/verify', [AdminDonationController::class, 'verify'])->name('donations.verify');
    Route::post('donations/{donation}/reject', [AdminDonationController::class, 'reject'])->name('donations.reject');
});
