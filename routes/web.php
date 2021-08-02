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
Route::get('/categories', 'CategoryController@index')->name('categories');
Route::get('/categories/{id}', 'CategoryController@detail')->name('categories-detail');

Route::get('/details/{id}', 'DetailController@index')->name('detail');
Route::post('/details/{id}', 'DetailController@add')->name('detail-add');

Route::get('/register/success', 'Auth\RegisterController@success')->name('register-success');

Route::prefix('admin')
    ->namespace('Admin')
    ->middleware(['auth', 'admin'])
    ->group(function() {
        Route::get('/', 'DashboardController@index')->name('dashboard-admin');
        Route::post('/', 'DashboardController@add')->name('countdown');
        Route::get('/countdown/edit/{id}', 'DashboardController@edit')->name('countdown-edit');
        Route::post('/countdown/{id}', 'DashboardController@update')->name('countdown-update');
        Route::delete('/countdown/{id}', 'DashboardController@destroy')->name('countdown-delete');
        
        Route::resource('category', 'CategoryController');
        Route::resource('user', 'UserController');
        Route::resource('data-aset/asets', 'ProductController');
        Route::resource('data-aset/product-gallery', 'ProductGalleryController');
        Route::resource('data-proposal/pengajuan', 'ProposalController');
        Route::resource('data-proposal/proposal-galleries', 'ProposalGalleryController');

        // dashboard product gallery
        Route::post('data-aset/aset/gallery/upload', 'ProductController@uploadGallery')->name('product-gallery-upload');
        Route::get('data-aset/aset/gallery/delete/{id}', 'ProductController@deleteGallery')->name('product-gallery-delete');
        // dashboard product export
        Route::get('aset/exportpdf', 'ProductController@exportPdfTable')->name('productExportPdf');

        // dashboard proposal gallery
        Route::post('data-proposal/proposal/gallery/upload', 'ProposalController@uploadGallery')->name('proposal-gallery-upload');
        Route::get('data-proposal/proposal/gallery/delete/{id}', 'ProposalController@deleteGallery')->name('proposal-gallery-delete');
        // dashboard proposal export
        Route::get('proposal/exportpdftable', 'ProposalController@exportPdfTable')->name('proposalExportPdf');
        Route::get('proposal/exportpdf', 'ProposalController@exportPdf')->name('proposalExport');
    });

Route::prefix('ppbj')
    ->namespace('Ppbj')
    ->middleware(['auth', 'ppbj'])
    ->group(function() {
        Route::get('/', 'DashboardController@index')->name('dashboard-ppbj');

        Route::resource('data-asett/asett', 'ProductController');
        // dashboard product export
        Route::get('aset/exportpdfppbj ', 'ProductController@exportPdfTable')->name('productExportPPBJ');

        Route::resource('data-proposaal/proposal', 'ProposalController');

    });

Route::prefix('user')
    ->namespace('User')
    ->middleware(['auth'])
    ->group(function() {
        Route::get('/', 'DashboardController@index')->name('dashboard-user');

        Route::resource('data-aset/aset', 'ProductController');
        Route::resource('data-proposal/pengajuans', 'ProposalController');
        Route::resource('data-proposal/proposal-gallery', 'ProposalGalleryController');

        // dashboard proposal gallery
        Route::post('data-proposal/proposal/gallery/upload', 'ProposalController@uploadGallery')->name('proposal-gallery-upload');
        Route::get('data-proposal/proposal/gallery/delete/{id}', 'ProposalController@deleteGallery')->name('proposal-gallery-delete');

         // dashboard proposal export
        Route::get('proposal/exportpdftable', 'ProposalController@pdfTable')->name('pdfTable');
        Route::get('proposal/exportpdf', 'ProposalController@exportPdf')->name('exportpdf');

});


Auth::routes();


