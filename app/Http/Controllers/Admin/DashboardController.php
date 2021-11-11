<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Product;
use App\Proposal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pembelian;
use App\Pengeluaran;
use App\Produk;
use App\Transaction;
use App\TransactionDetail;

class DashboardController extends Controller
{
    public function index()
    {
        $tanggalAkhir = date('Y-m-d');

        $total_menu = TransactionDetail::sum('jumlah');
        $total_menu_today = TransactionDetail::whereDate('created_at', $tanggalAkhir)->sum('jumlah');
        
        $total_penjualan = Transaction::sum('bayar');
        $total_penjualan_today = Transaction::whereDate('created_at', $tanggalAkhir)->sum('bayar');

        $pengeluaran = Pengeluaran::sum('bayar');
        $pembelian = Pembelian::sum('bayar');
        $total_pengeluaran = $pengeluaran + $pembelian;

        $pengeluaran_today = Pengeluaran::whereDate('created_at', $tanggalAkhir)->sum('bayar');
        $pembelian_today = Pembelian::whereDate('created_at', $tanggalAkhir)->sum('bayar');
        $total_pengeluaran_today = $pengeluaran_today + $pembelian_today;

        $sisa_kas = $total_penjualan - $total_pengeluaran;
        $sisa_kas_today = $total_penjualan_today - $total_pengeluaran_today;

        return view('pages.admin.dashboard', [
            'total_menu'=> $total_menu,
            'total_menu_today'=> $total_menu_today,
            'total_penjualan'=> $total_penjualan,
            'total_penjualan_today'=> $total_penjualan_today,
            'total_pengeluaran'=> $total_pengeluaran,
            'total_pengeluaran_today'=> $total_pengeluaran_today,
            'sisa_kas'=> $sisa_kas,
            'sisa_kas_today'=> $sisa_kas_today,
        ]);
    }

    public function menuterjual(Request $request, $id)
    {
        $produks = Produk::orderBy('name_product', 'asc')->get();
        $produk = Produk::where('id', $id)->firstOrFail();
        $transactionDetails = TransactionDetail::with(['produks'])->where('products_id', $produk->id_produk)->paginate(32);
        return view('pages.admin.menuterjual', [
            'produks' => $produks,
            'transactionDetails' => $transactionDetails
        ]);
    }
}
