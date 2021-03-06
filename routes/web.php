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

// Route::get('/details/{id}', 'DetailController@index')->name('detail');
// Route::post('/details/{id}', 'DetailController@add')->name('detail-add');

Route::get('/register/success', 'Auth\RegisterController@success')->name('register-success');

Route::prefix('admin')
    ->namespace('Admin')
    ->middleware(['auth', 'admin'])
    ->group(function() {
        Route::get('/', 'DashboardController@index')->name('dashboard-admin');
        Route::get('/menuterjual', 'DashboardController@menuterjual')->name('dashboard_admin.menuterjual');
        Route::get('/pengeluaran', 'DashboardController@pengeluaran')->name('dashboard_admin.pengeluaran');
        
        Route::resource('category', 'CategoryController');
        Route::resource('satuan', 'SatuanController');
        Route::resource('supplier', 'SupplierController');
        Route::resource('customer', 'CustomerController');
        Route::resource('user', 'UserController');
        Route::resource('setting', 'SettingController');

        // Persediaan
        Route::resource('data-product/persediaan', 'PersediaanController');
        Route::get('data-product/persediaan/{id}/detail', 'PersediaanController@detail')->name('persediaan.detail');
        Route::resource('data-product/persediaan-gallery', 'PersediaanGalleryController');
        
        // Produk
        Route::resource('data-product/produk', 'ProdukController');
        Route::get('data-product/produk/{id}/detail', 'ProdukController@detail')->name('produk.detail');

        //Kas Kecil
        Route::get('kaskecil/{id}/tambah', 'KaskecilController@tambah')->name('tambah-kaskecil');
        Route::get('kaskecil/data', 'KaskecilController@data')->name('kaskecil.data');
        Route::get('kaskecil/{id}/detail', 'KaskecilController@detail')->name('kasKecil.detail');
        Route::get('kaskecil/print/{id}', 'KaskecilController@print')->name('kasKecil.print');
        Route::resource('kasKecil', 'KaskecilController');

        // Kas Kecil Detail
        Route::get('kaskecil/kaskecil_detail/{id}/data', 'KaskecilDetailController@data')->name('kaskecil_detail.data');
        Route::get('kaskecil/kaskecil_detail/loadform/{diskon}/{total}', 'KaskecilDetailController@loadForm')->name('kaskecil_detail.load_form');
        Route::resource('kaskecil/kaskecil_detail', 'KaskecilDetailController');

        // Pengeluaran
        Route::get('/pengeluaran/{id}/tambah', 'PengeluaranController@tambah')->name('tambah-pengeluaran');
        Route::get('data-transaction/pengeluaran/data', 'PengeluaranController@data')->name('pengeluaran.data');
        Route::get('data-transaction/pengeluaran/{id}/detail', 'PengeluaranController@detail')->name('pengeluaran.detail');
        Route::get('data-transaction/pengeluaran/print/{id}', 'PengeluaranController@print')->name('pengeluaran.print');
        Route::resource('data-transaction/pengeluaran', 'PengeluaranController');

        // Pengeluaran-Detail
        Route::get('data-transaction/pengeluaran_detail/{id}/data', 'PengeluaranDetailController@data')->name('pengeluaran_detail.data');
        Route::get('data-transaction/keluaran/detail', 'PengeluaranDetailController@pengeluaranAll')->name('pengeluaran.pengeluaranAll');
        Route::delete('data-transaction/keluaran/delete/{id}', 'PengeluaranDetailController@delete')->name('pengeluaran.pengeluaranDelete');

        Route::get('data-transaction/keluaran/{id}/detail-aset', 'PengeluaranDetailController@detailAset')->name('pengeluaran.pengeluaranDetailAset');
        Route::post('data-transaction/keluaran/aset', 'PengeluaranDetailController@aset')->name('tambahAset');

        Route::get('data-transaction/pengeluaran_detail/loadform/{diskon}/{total}', 'PengeluaranDetailController@loadForm')->name('pengeluaran_detail.load_form');
        Route::resource('data-transaction/pengeluaran_detail', 'PengeluaranDetailController');

        // Pembelian
        Route::get('/pembelian/{id}/tambah', 'PembelianController@tambah')->name('tambah-pembelian');
        Route::get('data-transaction/pembelian/data', 'PembelianController@data')->name('pembelian.data');
        Route::get('data-transaction/pembelian/print/{id}', 'PembelianController@print')->name('pembelian.print');
        Route::get('data-transaction/pembelian/{id}/detail', 'PembelianController@detail')->name('pembelian.detail');
        
        Route::resource('data-transaction/pembelian', 'PembelianController');

        // Pembelian-detail
        Route::get('data-transaction/pembelian_detail/{id}/data', 'PembelianDetailController@data')->name('pembelian_detail.data');
        Route::get('data-transaction/persediaan/detail', 'PembelianDetailController@pembelianAll')->name('pembelian.pembelianAll');
        Route::get('data-transaction/pembelian_detail/loadform/{diskon}/{total}', 'PembelianDetailController@loadForm')->name('pembelian_detail.load_form');
        Route::resource('data-transaction/pembelian_detail', 'PembelianDetailController');

        // Tambah Stok Produk
        Route::get('/tambahStok/{id}/tambah', 'TambahStokController@tambah')->name('tambah-stokProduk');
        Route::get('data-transaction/tambahStok/data', 'TambahStokController@data')->name('tambahStok.data');
        Route::get('data-transaction/tambahStok/print/{id}', 'TambahStokController@print')->name('tambahStok.print');
        Route::resource('data-transaction/tambahStok', 'TambahStokController');

        // Tambah Stok-detail
        Route::get('data-transaction/tambahStok_detail/{id}/data', 'TambahStokDetailController@data')->name('stok_detail.data');
        Route::get('data-transaction/tambahStok_detail/loadform/{total}/{diskon}/{total_modal}', 'TambahStokDetailController@loadForm')->name('stok_detail.load_form');
        Route::resource('data-transaction/tambahStok_detail', 'TambahStokDetailController');

        // Penjualan
        Route::get('data-transaction/transaction/data', 'TransactionController@data')->name('transactions.data');
        Route::get('data-transaction/transaction/{id}/detail', 'TransactionController@detail')->name('transactions.detail');
        Route::get('data-transaction/transactions/selesai', 'TransactionController@selesai')->name('transactions.selesai');
        Route::get('data-transaction/transaction/nota-kecil', 'TransactionController@notaKecil')->name('transactions.nota_kecil');
        Route::get('data-transaction/transaction/nota-besar', 'TransactionController@notaBesar')->name('transactions.nota_besar');
        Route::get('data-transaction/transaction/print/{id}', 'TransactionController@print')->name('transactions.print');

        Route::get('data-transaction/transaction/transactionAll', 'TransactionController@transactionAll')->name('transactions.transactionAll');
        Route::post('data-transaction/transaction/transactionAllDetail', 'TransactionController@searchByDate')->name('transactions.searchByDate');

        Route::get('data-transaction/transaction/transactionAll/dataDetail', 'TransactionController@dataDetail')->name('transactions.transactionAllDetail');
        Route::resource('data-transaction/transactions', 'TransactionController');

        // Penjualan-detail
        Route::get('data-transaction/transaction-detail/{id}/data', 'TransactionDetailController@data')->name('transaction_details.data');
        Route::get('data-transaction/transaction-detail/loadform/{diskon}/{total}/{diterima}', 'TransactionDetailController@loadForm')->name('transaction_details.load_form');
        Route::resource('data-transaction/transaction-details', 'TransactionDetailController');

        // Laporan Penjualan
        Route::get('/laporan', 'LaporanController@index')->name('laporan.index');
        Route::get('/laporan/data/{awal}/{akhir}', 'LaporanController@data')->name('laporan.data');
        Route::get('/laporan/pdf/{awal}/{akhir}', 'LaporanController@exportPDF')->name('laporan.export_pdf');
        
        // Laporan Penjualan Report
        Route::get('/laporan/data_report/{awal}/{akhir}', 'LaporanController@dataReport')->name('laporan.dataReport');
        Route::get('/laporan/pdf_report/{awal}/{akhir}', 'LaporanController@exportPDFReport')->name('laporan.export_pdf_report');


        Route::resource('data-proposal/pengajuan', 'ProposalController');
        Route::resource('data-proposal/proposal-galleries', 'ProposalGalleryController');

        // dashboard product export
        Route::get('aset/exportpdf', 'ProductController@exportPdfTable')->name('productExportPdf');

        // dashboard proposal gallery
        Route::post('data-proposal/proposal/gallery/upload', 'ProposalController@uploadGallery')->name('proposal-gallery-upload');
        Route::get('data-proposal/proposal/gallery/delete/{id}', 'ProposalController@deleteGallery')->name('proposal-gallery-delete');
        // dashboard proposal export
        Route::get('proposal/exportpdftable', 'ProposalController@exportPdfTable')->name('proposalExportPdf');
        Route::get('proposal/exportpdf', 'ProposalController@exportPdf')->name('proposalExport');
    });

Route::prefix('kasir')
    ->namespace('Kasir')
    ->middleware(['auth', 'kasir'])
    ->group(function() {
        Route::get('/', 'DashboardController@index')->name('dashboard-kasir');

        // Kas Kecil
        Route::get('kaskecil/data', 'KaskecilController@data')->name('kaskecil.data');
        Route::get('kaskecil/{id}/detail', 'KaskecilController@detail')->name('kaskecil.detail');
        Route::get('kaskecil/print/{id}', 'KaskecilController@print')->name('kaskecil.print');
        Route::resource('kaskecilkasir', 'KaskecilController');
        Route::resource('memberkasir', 'MemberController');

        // Penjualan
        Route::get('data-transaction/transaction/data', 'TransactionController@data')->name('transaction.data');
        Route::get('data-transaction/transaction/selesai', 'TransactionController@selesai')->name('transaction.selesai');
        Route::get('data-transaction/transaction/nota-kecil', 'TransactionController@notaKecil')->name('transaction.nota_kecil');
        Route::get('data-transaction/transaction/nota-besar', 'TransactionController@notaBesar')->name('transaction.nota_besar');
        Route::get('data-transaction/transaction/print/{id}', 'TransactionController@print')->name('transaction.print');
        Route::resource('data-transaction/transaction', 'TransactionController');

        // Penjualan-detail
        Route::get('data-transaction/transaction-detail/{id}/data', 'TransactionDetailController@data')->name('transaction_detail.data');
        Route::get('data-transaction/transaction-detail/loadform/{diskon}/{total}/{diterima}/{totalpoin}', 'TransactionDetailController@loadForm')->name('transaction_detail.load_form');
        Route::resource('data-transaction/transaction-detail', 'TransactionDetailController');

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


