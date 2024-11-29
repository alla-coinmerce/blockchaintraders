<?php

use App\Http\Controllers\AnnualFinancialOverviewController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FactsheetController;
use App\Http\Controllers\KnowledgeBasePortalController;
use App\Http\Controllers\KnowledgeBaseSecureAssetController;
use App\Http\Controllers\MyAccountController;
use App\Http\Controllers\PortalHomePageController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Portal Routes
|--------------------------------------------------------------------------
|
| Here is where you can register portal routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware([
    'auth',
    'auth.session'
])->group(function () {
    Route::view('/email/verify', 'auth.verify-email')->name('verification.notice');
    
    Route::middleware([
        'signed'
    ])->group(function () {
        Route::get('/email/verify/{id}/{hash}', [AuthenticationController::class, 'verifyEmail'])->name('verification.verify');
    });

    Route::middleware([
        'throttle:6,1'
    ])->group(function () {
        Route::post('/email/verification-notification', [AuthenticationController::class, 'resendVerificationEmail'])->name('verification.send');
    });

    Route::middleware([
        'verified'
    ])->group(function () {
        Route::get('/', PortalHomePageController::class);

        Route::get('/{fund:slug}/factsheet/{year}-{week}', [FactsheetController::class, 'show'])
            ->where('year', '([0-9]+)')
            ->where('week', '([0-9]+)')
            ->name('my_factsheet');

        Route::get('/persoonelijk-document/{id}/{name}', [AnnualFinancialOverviewController::class, 'show_for_auth_user'])
            // ->where('year', '([0-9]+)')
            ->name('persoonlijkdocument');


        Route::get('/mijn-account', [MyAccountController::class, 'show'])->name('my-account');

        Route::put('logout', [AuthenticationController::class, 'logout']);

        Route::get('/knowledge-base/archive', [KnowledgeBasePortalController::class, 'index'])->name('kb.archive');
        Route::get('/knowledge-base/news-article/{article:slug}', [KnowledgeBasePortalController::class, 'show'])->name('kb.news-article');
        Route::view('/contact', 'portal.knowledgebase.contact')->name('kb.contact');

        Route::view('/wat-zijn-cryptocurrencies', 'portal.knowledgebase.article.wat-zijn-cryptocurrencies')->name('article.whatAreCryptoCurrencies');

        Route::get('/download-invoice/{orderId}', function($orderId){
            return (request()->user()->downloadInvoice($orderId));
        });

        Route::get('/update-betaalmethode', [SubscriptionController::class, 'updatePaymentMethod'])->name('subscription.updatePaymentMethod');   
    });

    Route::get('/dashboard', DashboardController::class);
});

Route::middleware([
    'knowledge_base_secure_assets'
])->group(function () {
    Route::get('/knowledge-base-assets/downloads/{filename}', [KnowledgeBaseSecureAssetController::class, 'download'])->name('kb.asset.download');

    // https://laracasts.com/discuss/channels/general-discussion/how-to-secure-assets-images-and-docs
    // https://www.blog.plint-sites.nl/protect-images-laravel/
    Route::get('/knowledge-base-assets/images/{filename}', [KnowledgeBaseSecureAssetController::class, 'image'])->name('kb.asset.image');

    // https://www.linkedin.com/pulse/how-prevent-video-download-laravel-farrokhpey-ghayyem/
    Route::get('/knowledge-base-assets/videos/{filename}', [KnowledgeBaseSecureAssetController::class, 'video'])->name('kb.asset.video');
});


Route::middleware([
    'guest',
])->group(function () {
    Route::get('/wachtwoord-instellen/{user}/{hash}', [AuthenticationController::class, 'verifyAccount'])->name('verifyAccount');
    Route::post('/new-set-password-link/{user}', [AuthenticationController::class, 'sendNewSetPassWordLink'])->name('newSetPasswordLink');
    Route::post('/set-password/{user}', [AuthenticationController::class, 'setPassword'])->name('setPassword');

    Route::view('/login', 'auth.login')->name('login');
    Route::post('login', [AuthenticationController::class, 'authenticate'])->middleware('throttle:login');
    
    Route::view('/wachtwoord-vergeten', 'auth.forgot-password')->name('password.request');
    Route::post('/forgot-password', [AuthenticationController::class, 'sendPasswordResetLink'])->name('password.email');
    Route::get('/wachtwoord-reset/{token}', [AuthenticationController::class, 'showPasswordResetView'])->name('password.reset');
    Route::post('/reset-password', [AuthenticationController::class, 'resetPassword'])->name('password.update');

});

Route::get('.well-known/apple-app-site-association', function () {
    return response()->file(public_path('apple-app-site-association'));
});

Route::get('.well-known/assetlinks.json', function () {
    return response()->file(public_path('assetlinks.json'));
});


