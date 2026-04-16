<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoanAgreementTemplateController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SignatureController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Public Signature Routes (Signed URLs)
Route::get('/sign/{document}', [SignatureController::class, 'show'])->name('signature.show');
Route::post('/sign/{document}', [SignatureController::class, 'sign'])->name('signature.submit');
Route::get('/sign/{document}/complete', [SignatureController::class, 'complete'])->name('signature.complete');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::resource('loans', LoanController::class);
    Route::post('loans/{loan}/approve', [LoanController::class, 'approve'])->name('loans.approve');
    Route::resource('customers', CustomerController::class);

    Route::resource('templates', LoanAgreementTemplateController::class);
    Route::post('loans/{loan}/generate-agreement', [LoanController::class, 'generateAgreement'])->name('loans.generate-agreement');
    Route::post('documents/{document}/send-for-signature', [LoanController::class, 'sendForSignature'])->name('documents.send-for-signature');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/regulatory', [ReportController::class, 'regulatory'])->name('reports.regulatory');

    // Subscription Management (Superadmin Only)
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::get('/subscriptions/{subscription}', [SubscriptionController::class, 'show'])->name('subscriptions.show');
    Route::put('/subscriptions/{subscription}', [SubscriptionController::class, 'update'])->name('subscriptions.update');
});

require __DIR__.'/auth.php';
