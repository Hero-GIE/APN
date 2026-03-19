<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PaystackCallbackController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MemberBadgeController;
use App\Http\Controllers\PuzzleController;
use App\Http\Controllers\MagazineController;
use App\Http\Controllers\JobOpportunityController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\FilterController;




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
    $membership = \App\Models\MemberPayment::with('member')
        ->where('transaction_id', $reference)
        ->first();    
    return view('member.success', compact('reference', 'membership'));
})->name('member.success');

Route::post('/donation/initialize', [DonationController::class, 'initialize'])->name('donation.initialize');

//petition filtered image
Route::post('/filter/apply', [FilterController::class, 'applyFilter'])->name('filter.apply');
Route::post('/filter/apply', [FilterController::class, 'applyFilter'])->name('filter.apply');
Route::get('/filter/images', [FilterController::class, 'getUserImages'])->name('filter.images');
Route::get('/filter/download/{id}', [FilterController::class, 'downloadImage'])->name('filter.download');
Route::delete('/filter/delete/{id}', [FilterController::class, 'deleteImage'])->name('filter.delete');

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

    // About
    Route::get('/about', [MemberController::class, 'about'])->name('about');
    
    // Digital Badge Management
    Route::get('/badges', [MemberBadgeController::class, 'index'])->name('badges');
    Route::post('/badge/regenerate', [MemberBadgeController::class, 'regenerateToken'])->name('badge.regenerate');
    Route::get('/badge/download', [MemberBadgeController::class, 'download'])->name('badge.download');

    // Magazine routes
    Route::get('/publications', [MagazineController::class, 'getMemberPublications'])->name('publications');
    Route::get('/download/{id}', [MagazineController::class, 'download'])->name('download');
    Route::get('/view/{id}', [MagazineController::class, 'view'])->name('view');

       // News routes
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');
    
    // Events routes
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show');
    
    // Jobs routes
    Route::get('/jobs', [JobOpportunityController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/{slug}', [JobOpportunityController::class, 'show'])->name('jobs.show');
});

// ===== NEW PUBLIC BADGE ROUTES 
Route::prefix('badge')->name('member.badge.')->group(function () {
    Route::get('image/{token}', [MemberBadgeController::class, 'image'])->name('image');
    Route::get('widget/{token}', [MemberBadgeController::class, 'widget'])->name('widget');
    Route::get('verify/{token}', [MemberBadgeController::class, 'verify'])->name('verify');
});

Route::prefix('puzzles')->name('puzzles.')->group(function () {
    // Public routes
    Route::get('/', [PuzzleController::class, 'hub'])->name('hub');
    Route::get('/all', [PuzzleController::class, 'index'])->name('index');
    Route::get('/achievements', [PuzzleController::class, 'achievements'])->name('achievements');
    Route::get('/{slug}', [PuzzleController::class, 'show'])->name('show');
    Route::get('/leaderboard', [PuzzleController::class, 'globalLeaderboard'])->name('leaderboard');
    
    // Protected routes
    Route::middleware(['auth:donor'])->group(function () {
        Route::get('/{slug}/start', [PuzzleController::class, 'start'])->name('start');
        Route::get('/play/{attempt}', [PuzzleController::class, 'play'])->name('play');
        Route::post('/submit/{attempt}', [PuzzleController::class, 'submit'])->name('submit');
        Route::get('/results/{attempt}', [PuzzleController::class, 'results'])->name('results');
        Route::post('/{slug}/rate', [PuzzleController::class, 'rate'])->name('rate');
        Route::post('/{slug}/comment', [PuzzleController::class, 'comment'])->name('comment');
        Route::get('/user/stats', [PuzzleController::class, 'getUserStats'])->name('user.stats');
    });
});

Route::get('/login', function() {
    return redirect()->route('donor.login');
})->name('login');

Route::get('/paystack/callback', [PaystackCallbackController::class, 'handle'])
    ->name('paystack.callback');