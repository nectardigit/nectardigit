<?php

use App\Http\Controllers\Admin\BenefitController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BreakingNewsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CkeditorController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\InformationController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\NewsGuestController;
use App\Http\Controllers\Admin\PhotoFeatureNewsController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ReporterController;
use App\Http\Controllers\Admin\SpecialNewsController;
use App\Http\Controllers\Admin\SubscriberBackEndController;
use App\Http\Controllers\Admin\UsefullLinksController;
use App\Http\Controllers\ContactBakEndController;
use App\Http\Controllers\ContainerController;
use App\Http\Controllers\CounterController;
use App\Http\Controllers\Front\SubscriberController;
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

Route::post('ckeditor/upload', [CkeditorController::class, 'upload'])->name('ckeditor.upload');
Route::get('two-factor-recovery', [UserController::class, 'recovery'])->middleware('guest');
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'verified']], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    include_once('appsetting_routes.php');
    Route::resource('clients', ClientController::class);
    Route::resource('container', ContainerController::class);
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('video', VideoController::class);
    Route::resource('reporters', ReporterController::class);
    Route::resource('profile', ProfileController::class);
    Route::get('profiledetail', [UserController::class, 'profiledetail'])->name('profiledetail')->middleware('password.confirm');

    Route::resource('news', NewsController::class);
    Route::get('/breaking-news', [BreakingNewsController::class, 'breakingNews'])->name('news.breaking_news');
    Route::get('/photo-feature-news', [PhotoFeatureNewsController::class, 'photoFeatureNews'])->name('photoFeatureNews');
    Route::get('/special-news', [SpecialNewsController::class, 'specialNews'])->name('specialNews');
    Route::get('newsReporter/{id}', [ReporterController::class,'showReporterNews'])->name('newsReporter');

    Route::get('/create-news-in-english', [NewsController::class, 'createNewsInEnglish'])->name('createNewsInEnglish');
    Route::get('/create-news-in-nepali', [NewsController::class, 'createNewsInNepali'])->name('createNewsInNepali');
    Route::get('/edit-news-in-english/{id}', [NewsController::class, 'edit'])->name('editNewsInEnglish');
    Route::get('/edit-news-in-nepali/{id}', [NewsController::class, 'edit'])->name('editNewsInNepali');
    Route::get('/getNewsByAdminSearch', [NewsController::class, 'getNewsByAdminSearch'])->name('getNewsByAdminSearch');
    Route::resource('guests', NewsGuestController::class);
    Route::resource('slider', SliderController::class);
    Route::resource('content', ContentController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('tag', TagController::class);
    Route::resource('blog', BlogController::class);
    Route::resource('testimonial', TestimonialController::class);
    Route::resource('faq', FaqController::class);
    Route::resource('information', InformationController::class);
    Route::resource('usefullinks', UsefullLinksController::class);
    Route::get('reporter-news/{slug}' , [ReporterController::class, 'newsByReporter'])->name('newsByReporter');
    Route::get('/users-news/{slug}', [UserController::class, 'usersNews'])->name('usersNews');
    Route::post('/add-guest', [NewsGuestController::class, 'addGuest'])->name('addGuest');
    include_once('advertisement_routes.php');

    Route::get('contact', [ContactController::class, 'index'])->name('contact.index');

    Route::get('contact/view/{contact}', [ContactController::class, 'view'])->name('contact.show');

    Route::get('menu/original/order', [MenuController::class, 'resetorder'])->name('menu.resetoreder');
    Route::resource('subscriber', SubscriberBackEndController::class);
    Route::resource('counter', CounterController::class);
    Route::get('message',[ContactBakEndController::class, 'show'])->name('message.show');
    Route::get('message/delete/{id}',[ContactBakEndController::class, 'delete'])->name('message.delete');
    Route::get('message/repaly/{id}',[ContactBakEndController::class, 'repaly'])->name('message.repaly');
    Route::Post('message/sendrepaly/{id}',[ContactBakEndController::class, 'sendrepaly'])->name('message.sendrepaly');

});

Route::get('/content/{slug}', [SliderController::class, 'sliderDetail'])->name('sliderDetail');

