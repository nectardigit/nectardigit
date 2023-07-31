<?php

use App\Http\Controllers\Admin\EnvController;
use App\Http\Controllers\Admin\FetchTableController;
use App\Http\Controllers\Admin\MigrateContentController;
use App\Http\Controllers\Admin\MigrateDatabaseController;

Route::resource('migration', MigrateDatabaseController::class);
Route::resource('/fetchtable', FetchTableController::class);
Route::post('/assignWordpressColumns/{table_id}', [MigrateDatabaseController::class, 'assignWordpressColumns'])->name('assignWordpressColumns');

Route::get('/update-image-names/{id}', [MigrateDatabaseController::class, 'updateImageName'])->name('updateImageName');
Route::post('/update-images', [MigrateDatabaseController::class, "startMigratingImages"])->name('startMigratingImages');
Route::post('/start-migrating-content', [MigrateContentController::class, 'startMigratingContent'])->name('startMigratingContent');
Route::get('fetchtables/internal/{table}', [FetchTableController::class, 'getRowInternal'])->name('fetchrowinternal');
Route::get('/fetchtables/external/{table}', [FetchTableController::class, 'getRowExternal'])->name('fetchrowexternal');
Route::get('/fetchtables/assign-table', [FetchTableController::class, 'adminGetTables'])->name('adminGetTables');
Route::post('/fetchtables/assign-table', [FetchTableController::class, 'adminUpdateAssingnedTables']);
Route::get('/migrateTableContent/{table_name}', [FetchTableController::class, 'migrateTableContent'])->name('migrateTableContent');
Route::post('/migrateTableContent/{table_name}', [FetchTableController::class, 'assignTableColumn']);
Route::get('/move-database-table-content/{external_table_name}', [FetchTableController::class, 'moveDatabaseTableContent'])->name('moveDatabaseTableContent');
//----env ---routes--//
Route::get('env', [EnvController::class, 'overview'])->name('env.index');
Route::post('env/add', [EnvController::class, 'add'])->name('add');
Route::post('env/update', [EnvController::class, 'update'])->name('update');
Route::get('env/createbackup', [EnvController::class, 'createbackup'])->name('createbackup');
Route::get('env/deletebackup/{timestamp}', [EnvController::class, 'deletebackup'])->name('deletebackup');
Route::get('env/restore/{backuptimestamp}', [EnvController::class, 'restore'])->name('restore');
Route::post('env/delete', [EnvController::class, 'delete'])->name('delete');
Route::get('env/download/{filename?}', [EnvController::class, 'download'])->name('download');
Route::post('env/upload', [EnvController::class, 'upload'])->name('upload');
Route::get('env/getdetails/{timestamp?}', [EnvController::class, 'getdetails'])->name('getdetails');
