<?php

namespace App\Http\Controllers\Kasir;

use App\Kaskecil;
use App\Pengeluaran;
use App\Transaction;
use App\TransactionDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pembelian;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $tanggalAkhir = date('Y-m-d');
        $kaskecil = Kaskecil::whereDate('created_at', $tanggalAkhir)->sum('kredit');
        $bayar = Transaction::whereDate('created_at', $tanggalAkhir)->sum('bayar');
        $pengeluaran = Pengeluaran::whereDate('tgl_pengeluaran', $tanggalAkhir)->where('users_id', Auth::user()->id)->sum('bayar');
        $pembelian = Pembelian::whereDate('tgl_pembelian', $tanggalAkhir)->where('users_id', Auth::user()->id)->sum('bayar');
        $keluar = $pengeluaran + $pembelian;
        $sisakas = $kaskecil + $bayar - $keluar;
        $total_menu_today = TransactionDetail::whereDate('created_at', $tanggalAkhir)->sum('jumlah');
        

        return view('pages.kasir.dashboard', [
            'kaskecil' => $kaskecil,
            'bayar' => $bayar,
            'pengeluaran' => $pengeluaran,
            'sisakas' => $sisakas,
            'total_menu_today' => $total_menu_today,
            'keluar' => $keluar,
        ]);
    }
}
