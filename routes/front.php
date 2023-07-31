<?php

use App\Http\Controllers\CareerController;
use App\Http\Controllers\DetailPageController;

use App\Http\Controllers\Front\FrontEndController;

use App\Http\Controllers\Front\SubscriberController;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;


Route::get('/locale/{locale}', function ($locale) {
    $validLocale = in_array($locale, ['en', 'np']);
    if ($validLocale) {
        App::setLocale($locale);
        session(['locale' => $locale]);
    }
    redirect()->back();
})->name('setLanguage');
Route::get('/', [FrontEndController::class, 'home'])->name('index');
Route::get('/verifiy-email/{verificationCode}', [CareerController::class, 'careerVerification'])->name('career-verification');
Route::post('/contact-form', [FrontEndController::class, 'contactStore'])->name('contactStore');
Route::get('/subscribe', [SubscriberController::class, 'store'])->name('subscriberStore');
Route::get('/career/{slug}', [CareerController::class, 'careerDetails'])->name('front.careerDetails');
Route::post('/add-career/{slug}', [CareerController::class, 'careerAdd'])->name('careerAdd');
Route::get('/{page}', [FrontEndController::class, 'page'])->name('page');
Route::get('{type}/{slug}', [DetailPageController::class, 'detailpage'])->name('detailpage');
Route::post('/search-data', [FrontEndController::class, 'blogsearchdata'])->name('blog.blogsearchdata');
Route::get('/blog', [FrontEndController::class, 'featch_data']);
