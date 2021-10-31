<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Kaskecil;
use App\Pengeluaran;
use App\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $tanggalAkhir = date('Y-m-d');
        $kaskecil = Kaskecil::whereDate('created_at', $tanggalAkhir)->sum('kredit');
        $bayar = Transaction::whereDate('created_at', $tanggalAkhir)->sum('bayar');
        $pengeluaran = Pengeluaran::whereDate('created_at', $tanggalAkhir)->sum('bayar');
        $sisakas = $kaskecil + $bayar - $pengeluaran;
        

        return view('pages.kasir.dashboard', [
            'kaskecil' => $kaskecil,
            'bayar' => $bayar,
            'pengeluaran' => $pengeluaran,
            'sisakas' => $sisakas,
        ]);
    }
}
