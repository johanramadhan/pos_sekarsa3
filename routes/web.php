<?php

use App\Http\Controllers\Admin\PembelianController;
use App\Http\Controllers\Admin\PembelianDetailController;
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
    ->group(function() {
        Route::get('/', 'DashboardController@index')->name('dashboard-admin');
        
        Route::resource('category', 'CategoryController');
        Route::resource('supplier', 'SupplierController');
        Route::resource('customer', 'CustomerController');
        Route::resource('user', 'UserController');
        Route::resource('data-product/products', 'ProductController');
        Route::resource('data-product/product-gallery', 'ProductGalleryController');
        Route::resource('data-transaction/pengeluaran', 'PengeluaranController');

        Route::resource('data-product/produk', 'ProdukController');

        Route::get('/pembelian/{id_pembelian}/tambah', 'PembelianController@tambah')->name('tambah-pembelian');
        Route::resource('data-transaction/pembelian', 'PembelianController');

        Route::get('/pembelian_detail/{id}/data', 'PembelianDetailController@data')->name('data_pembelian');
        Route::resource('data-transaction/pembelian_detail', 'PembelianDetailController');

        Route::resource('data-transaction/transaction', 'TransactionController');

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
        Route::get('aset/exportpdfppbj', 'ProductController@exportPdfTables')->name('productExportPPBJ');

        Route::resource('data-proposaal/proposal', 'ProposalController');
        // dashboard proposal export
        Route::get('proposal/exportpdftables', 'ProposalController@exportPdfTables')->name('proposalExportPPBJ');
        Route::get('proposal/exportpdf', 'ProposalController@exportPdfs')->name('proposalExports');

    });

Route::prefix('user')
    ->namespace('User')
    ->middleware(['auth', 'user'])
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


