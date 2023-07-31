<?php

use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\Admin\AppSettingController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CareerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CategorySeederController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DesignationController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\ImageCropController;
use App\Http\Controllers\Admin\MediaLibraryController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserLogController;
use App\Http\Controllers\Admin\WordpressBackupController;
use App\Http\Controllers\AppNoticeController;
use App\Http\Controllers\ComplimentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\HoroscopeController;
use App\Http\Controllers\Admin\InformationController;
use App\Http\Controllers\Admin\TextController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\ContainerController;
use App\Http\Controllers\Front\FrontEndController;
use App\Http\Controllers\GalleryCategoryController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\NoticeController;
use App\Models\Category;
use App\Models\Horoscope;
use App\Models\Slider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

Route::get('two-factor-recovery', [UserController::class, 'recovery'])->middleware('guest');
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'verified']], function () {
    Route::get('text', [TextController::class, 'index'])->name('text.index');
    Route::post('text', [TextController::class, 'update'])->name('text.update');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::match(['get', 'post'], 'logout', [UserController::class, 'logout'])->name('user.logout');
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('profile', ProfileController::class);
    Route::resource('wordpressbackup', WordpressBackupController::class);
    Route::post('/ajax-upload', [ImageCropController::class, 'ajaxImageUpload'])->name('ajaxImageUpload');
    Route::post('/crop-image', [ImageCropController::class, 'uploadCropImage'])->name('uploadCropImage');
    Route::get('/settings/advertisement', [AppSettingController::class, 'editAdvertisemntDetail']);
    Route::post('/settings/advertisement', [AppSettingController::class, 'updateAdvertisemntDetail'])->name("settings.advertisement");
    // Route::get('profile', [UserController::class, 'profile'])->name('profile')->middleware('password.confirm');
    Route::put('{id}/changepassword', [UserController::class, 'updatePassword'])->name('update-password');
    // Route::get('setting/sms', [AppSettingController::class, 'smsApi'])->name('smsApi.index')->middleware('password.confirm');
    // Route::post('setting/sms', [AppSettingController::class, 'smsApiSave'])->name('smsApi.store');
    // Route::put('setting/sms/{id}/update', [AppSettingController::class, 'smsApiUpdate'])->name('smsApi.update');
    Route::resource('setting', AppSettingController::class)->middleware('password.confirm');

    Route::resource('slider', SliderController::class);
    Route::get('application', [ApplicationController::class, 'index'])->name('application.index');
    Route::get('application/{id}', [ApplicationController::class, 'show'])->name('application.show');
    Route::post('download-application/{id}', [ApplicationController::class, 'download'])->name('application.download');

    Route::resource('career', CareerController::class);
    Route::resource('feature', FeatureController::class);
    Route::resource('information', InformationController::class);
    Route::resource('compliment', ComplimentController::class);
    Route::resource('appnotice', AppNoticeController::class);
    Route::get('clear-log', [UserLogController::class, 'ClearAll'])->name('clear-log');
    Route::get('user-log', UserLogController::class)->name('user-log.index');
    Route::post('update', [MenuController::class, 'updateMenuOrder'])->name('update.menu');

    Route::get('additional-menu/{id}', [MenuController::class, 'additional_menu'])->name('menu.additonal');
    Route::resource('menu', MenuController::class)->middleware('password.confirm');
    Route::resource('categoryseedding', CategorySeederController::class);
    Route::resource('team', TeamController::class);
    Route::resource('horoscope', HoroscopeController::class);

    Route::resource('designations', DesignationController::class);
    Route::post('updateDesignation', [DesignationController::class, 'updateDesignationOrder'])->name('update.designation');
    Route::get('designation/original/order', [DesignationController::class, 'resetorder'])->name('designation.resetorder');

    Route::resource('medialibrary', MediaLibraryController::class);
    Route::post('slider/changeStatus', [SliderController::class, 'changeStatus'])->name('slider.changeStatus');
    Route::post('slider/changedisplayhome', [SliderController::class, 'changedisplayhome'])->name('slider.changedisplayhome');
    Route::post('client/changeStatus', [ClientController::class, 'changeStatus'])->name('client.changeStatus');
    Route::post('client/changedisplayhome', [ClientController::class, 'changedisplayhome'])->name('client.changedisplayhome');
    Route::post('service/changeStatus', [InformationController::class, 'changeStatus'])->name('service.changeStatus');
    Route::post('service/changedisplayhome', [InformationController::class, 'changedisplayhome'])->name('service.changedisplayhome');
    Route::post('container/changeStatus', [ContainerController::class, 'changeStatus'])->name('container.changeStatus');
    Route::post('blog/changeStatus', [BlogController::class, 'changeStatus'])->name('blog.changeStatus');
    Route::post('blog/changeStatus', [BlogController::class, 'changeStatus'])->name('blog.changeStatus');
    Route::post('blog/changedisplayhome', [BlogController::class, 'changedisplayhome'])->name('blog.changedisplayhome');
    Route::post('team/changeStatus', [TeamController::class, 'changeStatus'])->name('team.changeStatus');
    Route::post('faq/changeStatus', [FaqController::class, 'changeStatus'])->name('faq.changeStatus');
    Route::post('faq/changedisplayhome', [FaqController::class, 'changedisplayhome'])->name('faq.changedisplayhome');
    Route::post('video/changeStatus', [VideoController::class, 'changeStatus'])->name('video.changeStatus');
    Route::post('video/changedisplayhome', [VideoController::class, 'changedisplayhome'])->name('video.changedisplayhome');
    // Route::view('medias', 'admin.mediaLibrary.medialibrary')->name('admin.media.list');
    Route::resource('gallery', GalleryController::class);
    Route::resource('gallerycategory', GalleryCategoryController::class);
    Route::resource('notice', NoticeController::class);
    Route::post('notice/changeStatus', [NoticeController::class, 'changeStatus'])->name('notice.changeStatus');
    Route::post('gallery/changeStatus', [GalleryController::class, 'changeStatus'])->name('gallery.changeStatus');
    Route::post('blogcategory/changeStatus', [CategoryController::class, 'changeStatus'])->name('blogcategory.changeStatus');
    Route::post('gallery/removeimage', [GalleryController::class, 'removeimage'])->name('gallery.removeimage');
});

Route::get('/content/{slug}', [SliderController::class, 'sliderDetail'])->name('sliderDetail');

/* Route::get('/map', function () {
return view('admin.mapdashboard.map-dashboard');
})->name('map.dashbaord')->middleware('auth'); */

Route::group(['prefix' => 'rider', 'middleware' => ['auth']], function () {
    return 'hello';
});
Route::get('sitemap', [FrontEndController::class, 'sitemap'])->name('sitemap');

Route::get('feed', [FrontEndController::class, 'feed'])->name('feed');
