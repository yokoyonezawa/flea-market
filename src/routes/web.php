<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\SellController;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\StripePaymentController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\TradingController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\RatingController;

Route::get('/', [ProductController::class, 'index'])->name('index');


Route::post('/register', [RegisterController::class, 'register']);




Route::get('/verify-email', EmailVerificationPromptController::class)
    ->name('verification.notice');

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');



Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['throttle:6,1'])
    ->name('verification.send');



Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/mylist', [ProductController::class, 'mylist'])->name('product.mylist');

Route::get('/item/{id}', [ProductController::class, 'show'])->name('product.show');

Route::middleware('auth')->group(function () {

    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage');

    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('mypage.profile');

    Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/product/{product}/favorite', [ProductController::class, 'toggleFavorite'])->name('product.toggleFavorite');

    Route::post('/comments/{productId}', [CommentController::class, 'store'])->name('comments.store');

    Route::get('/purchase/{id}', [PurchaseController::class, 'purchase'])->name('purchase');

    Route::post('/purchase/{id}/process', [PurchaseController::class, 'process'])->name('purchase.process');

    Route::get('/purchase/{id}/checkout', [StripePaymentController::class, 'checkout'])->name('purchase.checkout');


    Route::get('/purchase/success/{id}', [StripePaymentController::class, 'success'])->name('purchase.success');

    Route::get('/purchase/cancel', [StripePaymentController::class, 'cancel'])->name('purchase.cancel');

    Route::get('/profile/address/edit', [ProfileController::class, 'edit'])->name('profile.address.edit');

    Route::post('/profile/address/update', [ProfileController::class, 'updateAddress'])->name('profile.address.update');

    Route::get('/edit_address', [ProfileController::class, 'editAddress'])->name('edit_address');

    Route::get('/sell', [ProductController::class, 'create'])->name('sell');

    Route::post('/products', [ProductController::class, 'store'])->name('products.store');


    Route::get('/purchase/trading/{id}', [TradingController::class, 'trading'])->name('purchase.trading');

    Route::post('/purchase/complete/{purchase}', [PurchaseController::class, 'complete'])->name('purchase.complete');

    Route::post('/messages/{purchase}', [MessageController::class, 'store'])->name('message.store');

    Route::get('/trading/{id}', [TradingController::class, 'trading'])->name('trading.show');

    Route::post('/purchase/{id}/complete', [TradingController::class, 'completeTransaction'])->name('purchase.complete');


    Route::get('/messages/{message}/edit', [MessageController::class, 'edit'])->name('message.edit');

    Route::post('/messages/{message}/update', [MessageController::class, 'update'])->name('message.update');


    Route::delete('/messages/{message}/delete', [MessageController::class, 'destroy'])->name('message.destroy');

    Route::get('/rating/{purchaseId}', [RatingController::class, 'create'])->name('rating.create');

    Route::post('/rating/{purchaseId}', [RatingController::class, 'store'])->name('rating.store');




});


Route::post('/logout', function (){
    auth()->logout();
    return redirect('/login');
})->name('logout');
