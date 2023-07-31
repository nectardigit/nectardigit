<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RiderController;
use App\Http\Controllers\SocketTestController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\API\SliderController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\ClientController;
use App\Http\Controllers\API\TeamController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\BlogController;
use App\Http\Controllers\API\AboutController;
use App\Http\Controllers\API\MarketingController;
use App\Http\Controllers\API\AboutusController;
use App\Http\Controllers\API\CareerController;
use App\Http\Controllers\API\FaqController;
use App\Http\Controllers\API\ApplyController;
use App\Http\Controllers\API\HomeController;






/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//,'middleware' => 'throttle:60,1'
//rider routes

    Route::group(['prefix' => 'v1'], function() {
        Route::post('firebase-testing', [CustomerController::class, 'testfirebase']);
    });
Route::post('/searchRider',[RiderController::class,'searchRider'])->name('searchRider');
Route::get('/v1/hello-socket-programming', [SocketTestController::class, 'testSocketEvent']);

Route::fallback(function () {
    return response()->json(['message' => ['Server was not able to retrieve the requested page.']], 404);
});

// API new added routes


Route::post('login', [AuthController::class, 'signin']);
Route::post('register', [AuthController::class, 'signup']);

Route::resource('slider', SliderController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('clients', ClientController::class);
    Route::resource('team', TeamController::class);
    Route::resource('contact', ContactController::class);
    Route::resource('blogs', BlogController::class);
    Route::resource('about', AboutController::class);
    Route::resource('aboutus', AboutusController::class);
    Route::resource('marketing', MarketingController::class);
    Route::resource('career', CareerController::class);
    Route::resource('faq', FaqController::class);
    Route::resource('apply', ApplyController::class);
    Route::resource('home', HomeController::class);

Route::middleware('auth:sanctum')->group( function () {





});
