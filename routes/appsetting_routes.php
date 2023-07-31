<?php

use App\Http\Controllers\Admin\AppSettingController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/website-content-format', [AppSettingController::class, 'websiteContentFormat'])->name('websiteContentFormat');
Route::post('/setup-website-content', [AppSettingController::class, 'setupWebsiteContentFormat'])->name('setupWebsiteContentFormat');
Route::get('/website-content', [AppSettingController::class, 'websiteContent'])->name('websiteContent');
Route::post('/upate-website-content', [AppSettingController::class, 'updateWebsiteContent'])->name('updateWebsiteContent');

Route::put('{id}/changepassword', [UserController::class, 'updatePassword'])->name('update-password');
Route::get('setting/sms', [AppSettingController::class, 'smsApi'])->name('smsApi.index')->middleware('password.confirm');
Route::post('setting/sms', [AppSettingController::class, 'smsApiSave'])->name('smsApi.store');
Route::put('setting/sms/{id}/update', [AppSettingController::class, 'smsApiUpdate'])->name('smsApi.update');
Route::resource('setting', AppSettingController::class)->middleware('password.confirm');
