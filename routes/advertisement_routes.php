<?php

use App\Http\Controllers\Admin\AdvertisementController;
use App\Http\Controllers\Admin\AdvertisementPositionController;

Route::resource('advertisementposition', AdvertisementPositionController::class);
Route::resource('advertisement', AdvertisementController::class);
Route::get('/getAdpositions', [AdvertisementPositionController::class, 'getAdpositions'])->name('getAdpositions');
Route::get('advertisements/sorting', [AdvertisementController::class, 'advertisementssorting'])->name('advertisements.sort');
Route::get('advertisement/ordering/{id}', [AdvertisementController::class, 'advertisementording'])->name('advertisement.ordering');
Route::post('advertisement/update/ordering', [AdvertisementController::class, 'updateadvertisementOrder'])->name('advertisement.updae.order');
Route::get('advertisement/original/ordering', [AdvertisementController::class, 'originaladvertisementOrder'])->name('advertisements.original.order');
Route::get('/update-ad-status/{id}/{status}', [AdvertisementController::class, 'changeAdStatus'])->name('changeAdStatus');