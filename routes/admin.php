<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AnnualFinancialOverviewController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CoinInvestmentController;
use App\Http\Controllers\DashboardFundsController;
use App\Http\Controllers\DeribitController;
use App\Http\Controllers\FundValueController;
use App\Http\Controllers\FactsheetController;
use App\Http\Controllers\FundController;
use App\Http\Controllers\KnowledgeBaseNewsArticleAdminController;
use App\Http\Controllers\KnowledgeBaseSecureAssetController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ParticipationController;
use App\Http\Controllers\ParticipationInvestmentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Subscriber;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDocumentController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Order\Invoice;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware([
    'auth.admin',
    'auth.session'
])->group(function () {
    Route::middleware([
        'localize:en'
    ])->group(function () {
        Route::view('/email/verify', 'auth.verify-email')->name('admin.verification.notice');
        
        Route::middleware([
            'signed'
        ])->group(function () {
            Route::get('/email/verify/{id}/{hash}', [AuthenticationController::class, 'verifyEmail'])->name('admin.verification.verify');
        });

        Route::middleware([
            'throttle:6,1'
        ])->group(function () {
            Route::post('/email/verification-notification', [AuthenticationController::class, 'resendVerificationEmail'])->name('admin.verification.send');
        });

        Route::middleware([
            'verified:admin.verification.notice'
        ])->group(function () {
            Route::get('/', AdminDashboardController::class);

            Route::put('/dashboard-funds', DashboardFundsController::class)->name('updateDashboardFunds');

            Route::resource('funds', FundController::class);
            Route::resource('funds.coininvestments', CoinInvestmentController::class)->except([
                'index', 'store', 'show', 'update'
            ])->scoped();
            Route::resource('funds.participationinvestments', ParticipationInvestmentController::class)->except([
                'index', 'store', 'show'
            ])->scoped();
            Route::resource('funds.fundvalues', FundValueController::class)->except([
                'index', 'show'
            ])->scoped();
            Route::resource('funds.factsheets', FactsheetController::class)->except([
                'index', 'show', 'edit', 'update'
            ])->scoped();
            Route::get('/{fund:slug}/factsheet/{year}-{week}', [FactsheetController::class, 'show'])
                ->where('year', '([0-9]+)')
                ->where('week', '([0-9]+)')
                ->name('factsheet');
            
            Route::get('/deribit/create', [DeribitController::class, 'create'])->name('deribit.create');
            Route::post('/deribit/store', [DeribitController::class, 'store'])->name('deribit.store');
            Route::delete('/deribit/delete', [DeribitController::class, 'destroy'])->name('deribit.destroy');
            
            Route::put('/users/activate/{user}', [UserController::class, 'activate'])->name('users.activate');
            Route::put('/users/resend-welcome/{user}', [UserController::class, 'resendWelcomeNotification'])->name('users.resendWelcomeNotification');
            Route::resource('users', UserController::class);
            Route::resource('users.participations', ParticipationController::class)->except([
                'index', 'store', 'show'
            ])->scoped();
            Route::resource('users.annualFinancialOverviews', AnnualFinancialOverviewController::class)->except([
                'index', 'show', 'edit', 'update'
            ])->scoped();
            Route::get('/annualfinancialoverview/{annualFinancialOverview}/{name}', [AnnualFinancialOverviewController::class, 'show'])
                // ->where('name', '([0-9]+)')
                ->name('annualFinancialOverview');
            Route::resource('users.documents', UserDocumentController::class)->except([
                'index', 'show', 'edit', 'update'
            ])->scoped();
            Route::get('/document/{document}/{display_name}', [UserDocumentController::class, 'show'])
                ->name('document');

            Route::resource('tags', TagController::class)->except([
                    'show'
            ]);

            Route::resource('messages', MessageController::class)->except([
                'create', 'store', 'edit'
            ]);

            Route::get('/knowledge-base/subscribers', [Subscriber::class, 'index'])->name('knowledgebase.subscribers');
            Route::delete('/knowledge-base/subscription/cancel/{user}', [Subscriber::class, 'delete'])->name('knowledgebase.subscription.cancel');
            Route::get('/knowledge-base/assets', [KnowledgeBaseSecureAssetController::class, 'index'])->name('knowledgebase.assets');

            Route::get('/user/{user}/download-invoice/{orderId}', function(User $user, $orderId){
                return ($user->downloadInvoice($orderId));
            });

            Route::put('logout', [AuthenticationController::class, 'logout']);

            Route::get('/invoice', function() {
                $invoice = new Invoice('EUR');
                
                return view('vendor.cashier.receipt', [
                    'invoice' => $invoice
                 ]);
            });
        });  
    });

    Route::middleware([
        'localize'
    ])->group(function () {
        Route::resource('posts', PostController::class);
        Route::resource('knowledgebase-news', KnowledgeBaseNewsArticleAdminController::class);
    });

    Route::get('language/{locale}', function ($locale) {
        app()->setLocale($locale);
        session()->put('locale', $locale);
    
        return redirect()->back();
    });
});

Route::middleware([
    'knowledge_base_secure_assets'
])->group(function () {
    Route::get('/knowledge-base-assets/downloads/{filename}', [KnowledgeBaseSecureAssetController::class, 'download'])->name('admin.kb.asset.download');
    Route::get('/knowledge-base-assets/images/{filename}', [KnowledgeBaseSecureAssetController::class, 'image'])->name('admin.kb.asset.image');
    Route::get('/knowledge-base-assets/videos/{filename}', [KnowledgeBaseSecureAssetController::class, 'video'])->name('admin.kb.asset.video');
});

Route::middleware([
    'guest',
])->group(function () {
    Route::get('/wachtwoord-instellen/{user}/{hash}', [AuthenticationController::class, 'verifyAccount'])->name('admin.verifyAccount');
    Route::post('/new-set-password-link/{user}', [AuthenticationController::class, 'sendNewSetPassWordLink'])->name('admin.newSetPasswordLink');
    Route::post('/set-password/{user}', [AuthenticationController::class, 'setPassword'])->name('admin.setPassword');

    Route::view('/login', 'auth.login')->name('adminLogin');
    Route::post('login', [AuthenticationController::class, 'adminAuthenticate'])->middleware('throttle:login');
    
    Route::view('/wachtwoord-vergeten', 'auth.forgot-password')->name('admin.password.request');
    Route::post('/forgot-password', [AuthenticationController::class, 'sendPasswordResetLink'])->name('admin.password.email');
    Route::get('/wachtwoord-reset/{token}', [AuthenticationController::class, 'showPasswordResetView'])->name('admin.password.reset');
    Route::post('/reset-password', [AuthenticationController::class, 'resetPassword'])->name('admin.password.update');
});