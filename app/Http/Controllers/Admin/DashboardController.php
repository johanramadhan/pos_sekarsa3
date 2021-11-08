<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Product;
use App\Proposal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        return view('pages.admin.dashboard', [
            'total_menu'=> $total_menu,
            'total_menu_today'=> $total_menu_today,
            'total_penjualan'=> $total_penjualan,
            'total_penjualan_today'=> $total_penjualan_today,
        ]);
    }
}
