<?php

use App\Http\Controllers\KnowledgeBaseRegistrationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::view('/test', 'web.test');

Route::view('/', 'web.home');
Route::view('/onze-fondsen', 'web.funds')->name('funds');
Route::view('/growth-fund', 'web.growth-fund')->name('growth-fund');
Route::view('/liquidity-fund', 'web.liquidity-fund')->name('liquidity-fund');
Route::view('/over-ons', 'web.about')->name('about');
Route::view('/veiligheid', 'web.safety')->name('safety');
Route::view('/zakelijk-beleggen-in-crypto', 'web.investing-in-crypto-with-your-business')->name('investing-in-crypto-with-your-business');
Route::view('/crypto-vermogensbeheer', 'web.what-is-crypto-asset-management')->name('what-is-cryto-asset-management');
Route::view('/wat-is-een-bitcoin-fonds', 'web.what-is-a-bitcoin-fund')->name('what-is-a-bitcoin-fund');
Route::view('/portaal', 'web.portal')->name('portal');
Route::view('/faq', 'web.faq')->name('faq');

Route::get('/blog/zakelijk-beleggen-in-crypto', function () {
    return redirect('/wat-is-een-bitcoin-fonds');
});

Route::get('/blog', [PostController::class, 'webIndex'])->name('blog');
Route::get('/blog/{post:slug}', [PostController::class, 'webShow'])->name('post');

Route::view('/privacy', 'web.privacy')->name('privacy');
Route::view('/algemene-voorwaarden', 'web.terms-and-conditions')->name('terms_and_conditions');

Route::get('/inschrijven/{fund:slug}', [RegistrationController::class, 'create'])->name('registrationform');
Route::post('/inschrijven/{fund:slug}', [RegistrationController::class, 'store'])->name('register');
Route::view('/bedankt-voor-uw-inschrijving', '/web.register-thank-you')->name('register-thank-you');

Route::get('/kennisbank', [KnowledgeBaseRegistrationController::class, 'knowledgeBaseLandingPage'])->name('knowledgebase.landing');
Route::post('/kennisbank', [KnowledgeBaseRegistrationController::class, 'knowledgeBaseRegister'])->name('knowledgebase.register');
Route::get('/check-payment/{payment_id}', [KnowledgeBaseRegistrationController::class, 'knowledgeBaseAfterPayment'])->name('knowledgebase.after_payment');
Route::get('/subscription-thank-you', [KnowledgeBaseRegistrationController::class, 'knowledgeBaseThankYou'])->name('knowledgebase.subscription.thankyou');
Route::get('/subscription-payment-error', [KnowledgeBaseRegistrationController::class, 'knowledgeBasePaymentError'])->name('knowledgebase.subscription.payment.error');

Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);

    return redirect()->back();
});
