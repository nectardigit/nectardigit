<?php

use Mafftor\LaravelFileManager\Controllers\CropController;
use Mafftor\LaravelFileManager\Controllers\DeleteController;
use Mafftor\LaravelFileManager\Controllers\DownloadController;
use Mafftor\LaravelFileManager\Controllers\FolderController;
use Mafftor\LaravelFileManager\Controllers\ItemsController;
use Mafftor\LaravelFileManager\Controllers\LfmController;
use Mafftor\LaravelFileManager\Controllers\RedirectController;
use Mafftor\LaravelFileManager\Controllers\RenameController;
use Mafftor\LaravelFileManager\Controllers\ResizeController;
use Mafftor\LaravelFileManager\Controllers\UploadController;

$middleware = array_merge(\Config::get('lfm.middlewares'), [
    '\Mafftor\LaravelFileManager\Middlewares\MultiUser',
    '\Mafftor\LaravelFileManager\Middlewares\CreateDefaultFolder',
]);
$prefix = \Config::get('lfm.url_prefix', \Config::get('lfm.prefix', 'laravel-filemanager'));
// dd($prefix);
$as = 'Mafftor.lfm.';
$namespace = '\Mafftor\LaravelFileManager\Controllers';

// make sure authenticated
Route::group(compact('middleware', 'prefix', 'as'), function () {

    // Show LFM
    // dd('sdfdsfs');
    Route::get('/', [ LfmController::class, 'show', 'as' => 'show']);
    // Show integration error messages
    Route::get('/errors', [ LfmController::class, 'getErrors', 'as' => 'getErrors']);
    
    
    // upload
    Route::get('/upload', [ UploadController::class, 'upload'])->name('mafftor.lfm.upload');
    
    
    // list images & files
    Route::get('/jsonitems', [ ItemsController::class, 'getItems', 'as' => 'getItems']);
    

    // folders
    Route::get('/newfolder', [ FolderController::class, 'getAddfolder', 'as' => 'getAddfolder']);
    Route::get('/deletefolder', [ FolderController::class, 'getDeletefolder', 'as' => 'getDeletefolder']);
    Route::get('/folders', [ FolderController::class, 'getFolders', 'as' => 'getFolders']);
 
    // crop
    Route::get('/folders', [ CropController::class, 'getCrop', 'as' => 'getCrop']);
    Route::get('/cropimage', [ CropController::class, 'getCropimage', 'as' => 'getCropimage']);
    Route::get('/cropnewimage', [ CropController::class, 'getCropimage', 'as' => 'getCropimage']);
    
    
    
    // rename
    Route::get('/rename', [ RenameController::class, 'getRename', 'as' => 'getRename']);
    
    
    // scale/resize
    Route::get('/resize', [ ResizeController::class, 'getResize', 'as' => 'getResize']);
    Route::get('/doresize', [ ResizeController::class, 'performResize', 'as' => 'performResize']);
    
    
    
    // download
    Route::get('/download', [ DownloadController::class, 'getDownload', 'as' => 'getDownload']);
    
    
    // delete
    Route::get('/delete', [ DeleteController::class, 'getDelete', 'as' => 'getDelete']);
    

    // Route::get('/demo', 'DemoController@index');
});

Route::group(compact('prefix', 'as', 'namespace'), function () {
    // Get file when base_directory isn't public
    $images_url = '/' . \Config::get('lfm.images_folder_name') . '/{base_path}/{image_name}';
    // dd($images_url);
    $files_url = '/' . \Config::get('lfm.files_folder_name') . '/{base_path}/{file_name}';
    Route::get($images_url, [ RedirectController::class, 'getImage', 'as' => 'getImage'])
    ->where('image_name', '.*');

    // Route::get($images_url, 'RedirectController@getImage')
    //     ->where('image_name', '.*');
    Route::get($files_url, [ RedirectController::class, 'getFile', 'as' => 'getFile'])
    ->where('file_name', '.*');
    // Route::get($files_url, 'RedirectController@getFile')
    //     ->where('file_name', '.*');
});
