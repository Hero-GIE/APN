<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PaystackCallbackController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\MemberController; 


Route::get('/', function () {
    return view('donation.donate');
})->name('home');

Route::get('/donate', function () {
    return view('donation.donate');
})->name('donate');

Route::get('/donation/callback', [PaystackCallbackController::class, 'handle'])
    ->name('donation.callback');

Route::get('/donation/success', function (Request $request) {
    $reference = $request->reference;
    $donation  = \App\Models\Donation::where('transaction_id', $reference)->first();
    return view('donation.success', compact('reference', 'donation'));
})->name('donation.success');

Route::get('/member/success', function (Request $request) {
    $reference = $request->reference;
    $membership = \App\Models\MemberPayment::with(['donation', 'member'])
        ->whereHas('donation', function($query) use ($reference) {
            $query->where('transaction_id', $reference);
        })
        ->first();
    
    return view('member.success', compact('reference', 'membership'));
})->name('member.success');

Route::post('/donation/initialize', [DonationController::class, 'initialize'])->name('donation.initialize');

// Donor routes (guests)
Route::middleware('guest:donor')->prefix('donor')->name('donor.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Donor routes (authenticated)
Route::middleware('auth:donor')->prefix('donor')->name('donor.')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/transactions', [AuthController::class, 'transactions'])->name('transactions');
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile.show');
    Route::get('/profile/edit', [AuthController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::get('/password/change', [AuthController::class, 'showChangePasswordForm'])->name('password.change');
    Route::put('/password/change', [AuthController::class, 'changePassword'])->name('password.update');
    Route::get('/membership', [DonorController::class, 'membership'])->name('membership');
    Route::get('/support', [DonorController::class, 'support'])->name('support');
    Route::post('/support/ticket', [DonorController::class, 'submitTicket'])->name('support.ticket');
});

// Member Routes
Route::middleware(['auth:donor', 'member.active'])->prefix('member')->name('member.')->group(function() {
    // Dashboard
    Route::get('/dashboard', [MemberController::class, 'dashboard'])->name('dashboard');
    
    // Benefits
    Route::get('/benefits', [MemberController::class, 'benefits'])->name('benefits');
    
    // Payments & Transactions
    Route::get('/payments', [MemberController::class, 'payments'])->name('payments');
    Route::get('/transactions', [MemberController::class, 'transactions'])->name('transactions');
    
    // Profile Management
    Route::get('/profile', [MemberController::class, 'profile'])->name('profile.show');
    Route::get('/profile/edit', [MemberController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [MemberController::class, 'updateProfile'])->name('profile.update');
    
    // Password Change
    Route::get('/password/change', [MemberController::class, 'showChangePasswordForm'])->name('password.change');
    Route::put('/password/change', [MemberController::class, 'changePassword'])->name('password.update');
    
    // Support
    Route::get('/support', [MemberController::class, 'support'])->name('support');
    Route::post('/support/ticket', [MemberController::class, 'submitTicket'])->name('support.ticket');
    
    // Membership Actions
    Route::post('/cancel', [MemberController::class, 'cancelMembership'])->name('cancel');
    Route::get('/renew', [MemberController::class, 'renew'])->name('renew');
    
    // Receipt Download
    Route::get('/receipt/{payment}', [MemberController::class, 'downloadReceipt'])->name('receipt');
});

// Add this redirect at the end
Route::get('/login', function() {
    return redirect()->route('donor.login');
})->name('login');