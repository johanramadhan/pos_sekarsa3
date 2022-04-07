<?php

namespace App\Http\Controllers\Kasir;

use App\Kaskecil;
use App\Pengeluaran;
use App\Transaction;
use App\TransactionDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\KaskecilDetail;
use App\Pembelian;
use App\PengeluaranDetail;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $tanggalAkhir = date('Y-m-d');
        $kaskecil = Kaskecil::whereDate('created_at', $tanggalAkhir)->sum('kredit');
        $kaskecil_detail = KaskecilDetail::whereDate('created_at', $tanggalAkhir)->get();
        $bayar = Transaction::whereDate('created_at', $tanggalAkhir)->sum('bayar');
        $total_harga = Transaction::whereDate('created_at', $tanggalAkhir)->sum('total_harga');
        $diskon = Transaction::whereDate('created_at', $tanggalAkhir)->sum('diskon');

        $pengeluaran = Pengeluaran::whereDate('tgl_pengeluaran', $tanggalAkhir)->where('users_id', Auth::user()->id)->sum('bayar');
        $pengeluaranDetail = Pengeluaran::whereDate('tgl_pengeluaran', $tanggalAkhir)
            ->where('users_id', Auth::user()->id)
            ->get();

        $total_piutang_today = Transaction::whereDate('created_at', $tanggalAkhir)->where('transaction_status','piutang')->sum('bayar');
        $list_piutang_today = Transaction::whereDate('created_at', $tanggalAkhir)->where('transaction_status','piutang')->get();

        $pembelian = Pembelian::whereDate('tgl_pembelian', $tanggalAkhir)->where('users_id', Auth::user()->id)->sum('bayar');
        $keluar = $pengeluaran + $pembelian;
        $sisakas = $kaskecil + $bayar - $keluar - $total_piutang_today;
        $total_menu_today = TransactionDetail::whereDate('created_at', $tanggalAkhir)->sum('jumlah');
        $menu_terjual_today = TransactionDetail::whereDate('created_at', $tanggalAkhir)
            ->select('products_id')
            ->selectRaw("SUM(jumlah) as total_jumlah")
            ->groupBy('products_id')
            ->orderBy('total_jumlah', 'desc')
            ->get();
        

        return view('pages.kasir.dashboard', [
            'kaskecil' => $kaskecil,
            'kaskecil_detail' => $kaskecil_detail,
            'bayar' => $bayar,
            'total_harga' => $total_harga,
            'diskon' => $diskon,
            'pengeluaran' => $pengeluaran,
            'pengeluaranDetail' => $pengeluaranDetail,
            'total_piutang_today' => $total_piutang_today,
            'list_piutang_today' => $list_piutang_today,
            'sisakas' => $sisakas,
            'total_menu_today' => $total_menu_today,
            'keluar' => $keluar,
            'menu_terjual_today' => $menu_terjual_today,
        ]);
    }
}
