<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', 'HomeController@index')->name('home');

Route::prefix('admin')
    ->namespace('Admin')
    ->group(function() {
        Route::get('/', 'DashboardController@index')->name('dashboard-admin');
        Route::resource('category', 'CategoryController');
        Route::resource('user', 'UserController');
        Route::resource('data-aset/aset', 'ProductController');
        Route::resource('data-aset/product-gallery', 'ProductGalleryController');
        Route::resource('data-proposal/proposal', 'ProposalController');
        Route::resource('data-proposal/proposal-gallery', 'ProposalGalleryController');

        // dashboard product gallery
        Route::post('data-aset/aset/gallery/upload', 'ProductController@uploadGallery')->name('product-gallery-upload');
        Route::get('data-aset/aset/gallery/delete/{id}', 'ProductController@deleteGallery')->name('product-gallery-delete');

        Route::get('aset/exportpdf', 'ProductController@exportPdfTable')->name('productExportPdf');

        // dashboard proposal gallery
        Route::post('data-aset/proposal/gallery/upload', 'ProposalController@uploadGallery')->name('proposal-gallery-upload');
        Route::get('data-aset/proposal/gallery/delete/{id}', 'ProposalController@deleteGallery')->name('proposal-gallery-delete');

        Route::get('aset/exportpdf', 'ProductController@exportPdfTable')->name('productExportPdf');
    });


Auth::routes();


