<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Product;
use App\Proposal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pembelian;
use App\PembelianDetail;
use App\Pengeluaran;
use App\PengeluaranDetail;
use App\Produk;
use App\Transaction;
use App\TransactionDetail;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tanggalAwal = date('Y-m-01');
        $tanggalAkhir = date('Y-m-d');

        $total_menu = TransactionDetail::sum('jumlah');
        $menu_terjual = TransactionDetail::select('products_id')
            ->selectRaw("SUM(jumlah) as total_jumlah")
            ->groupBy('products_id')
            ->orderBy('total_jumlah', 'desc')
            ->get();

        $total_menu_today = TransactionDetail::whereDate('created_at', $tanggalAkhir)->sum('jumlah');
        $menu_terjual_today = TransactionDetail::whereDate('created_at', $tanggalAkhir)
            ->select('products_id')
            ->selectRaw("SUM(jumlah) as total_jumlah")
            ->groupBy('products_id')
            ->orderBy('total_jumlah', 'desc')
            ->get();
        
        $total_penjualan = Transaction::sum('bayar');
        $total_penjualan_today = Transaction::whereDate('created_at', $tanggalAkhir)->sum('bayar');

        $total_piutang = Transaction::where('transaction_status','piutang')->sum('bayar');
        $list_total_piutang = Transaction::where('transaction_status','piutang')->get();
        $total_piutang_today = Transaction::whereDate('created_at', $tanggalAkhir)->where('transaction_status','piutang')->sum('bayar');
        $list_piutang_today = Transaction::whereDate('created_at', $tanggalAkhir)->where('transaction_status','piutang')->get();

        $pengeluaran = Pengeluaran::sum('bayar');
        $pembelian = Pembelian::sum('bayar');
        $total_pengeluaran = $pengeluaran + $pembelian;

        $pengeluaran_today = Pengeluaran::whereDate('tgl_pengeluaran', $tanggalAkhir)->sum('bayar');
        $pembelian_today = Pembelian::whereDate('tgl_pembelian', $tanggalAkhir)->sum('bayar');
        $total_pengeluaran_today = $pengeluaran_today + $pembelian_today;

        $sisa_kas = $total_penjualan - $total_pengeluaran - $total_piutang;
        $sisa_kas_today = $total_penjualan_today - $total_pengeluaran_today - $total_piutang_today;

        $pembelianDetail = PembelianDetail::whereDate('created_at', $tanggalAkhir)->get();
        $pembelianDetailSum = PembelianDetail::whereDate('created_at', $tanggalAkhir)->sum('subtotal');

        $pengeluaranDetail = PengeluaranDetail::whereDate('created_at', $tanggalAkhir)->get();
        $pengeluaranDetailSum = PengeluaranDetail::whereDate('created_at', $tanggalAkhir)->sum('subtotal');

        $total_penjualan_report = Transaction::where('transaction_status', 'sukses')->sum('bayar');
        $jumlah_penjualan_report = Transaction::where('transaction_status', 'sukses')->sum('total_item');

        $total_pembelian_report = Pembelian::where('status', 'Sukses')->sum('total_harga');
        $total_pengeluaran_report = Pengeluaran::where('status', 'Sukses')->sum('total_harga');
        $total_pengeluaran_sum = $total_pembelian_report + $total_pengeluaran_report;
        $sisa_kas_repot = $total_penjualan_report - $total_pengeluaran_sum;

        $data_tanggal = array();
        $data_penjualan = array();
        $data_pengeluaran = array();

        while (strtotime($tanggalAwal) <= strtotime($tanggalAkhir)) {
            $data_tanggal[] = (int) substr($tanggalAwal, 8, 2);                       

            
            $penjualan = Transaction::where('created_at', 'LIKE', "%$tanggalAwal%")->sum('bayar');
            $total_pembelian = Pembelian::where('tgl_pembelian', 'LIKE', "%$tanggalAwal%")->sum('bayar');
            $pengeluaran = Pengeluaran::where('tgl_pengeluaran', 'LIKE', "%$tanggalAwal%")->sum('total_harga');

            
            $penjualan = $penjualan - $total_pembelian - $pengeluaran;
            $pengeluaran = $total_pembelian + $pengeluaran;
            $data_penjualan[] += $penjualan;
            $data_pengeluaran[] += $pengeluaran;


            $tanggalAwal = date('Y-m-d', strtotime("+1 day", strtotime($tanggalAwal)));

        };

        
        return view('pages.admin.dashboard', [
            'total_menu'=> $total_menu,
            'total_menu_today'=> $total_menu_today,
            'total_penjualan'=> $total_penjualan,
            'total_penjualan_today'=> $total_penjualan_today,
            'total_piutang'=> $total_piutang,
            'list_total_piutang'=> $list_total_piutang,
            'total_piutang_today'=> $total_piutang_today,
            'list_piutang_today'=> $list_piutang_today,
            'total_pengeluaran'=> $total_pengeluaran,
            'total_pengeluaran_today'=> $total_pengeluaran_today,
            'sisa_kas'=> $sisa_kas,
            'sisa_kas_today'=> $sisa_kas_today,
            'menu_terjual_today'=> $menu_terjual_today,
            'menu_terjual'=> $menu_terjual,
            'tanggalAwal' => $tanggalAwal,
            'tanggalAkhir' => $tanggalAkhir,
            'pembelianDetail' => $pembelianDetail,
            'pembelianDetailSum' => $pembelianDetailSum,
            'pengeluaranDetail' => $pengeluaranDetail,
            'pengeluaranDetailSum' => $pengeluaranDetailSum,
            'total_penjualan_report' => $total_penjualan_report,
            'jumlah_penjualan_report' => $jumlah_penjualan_report,
            'total_pengeluaran_sum' => $total_pengeluaran_sum,
            'sisa_kas_repot' => $sisa_kas_repot,
            'data_tanggal' => $data_tanggal,
            'data_penjualan' => $data_penjualan,
            'data_pengeluaran' => $data_pengeluaran,

        ]);
    }

    public function menuterjual()
    {
        $tanggalAkhir = date('Y-m-d');
        $menu_terjual_today = TransactionDetail::whereDate('created_at', $tanggalAkhir)
            ->select('products_id')
            ->selectRaw("SUM(jumlah) as total_jumlah")
            ->groupBy('products_id')
            ->orderBy('total_jumlah', 'desc')
            ->get();
        
        $no = 1;
        $data = array();
        $total_menu = 0;
        $total_modal = 0;
        $total_penjualan = 0;
        $total_keuntungan = 0;

        foreach($menu_terjual_today as $item) {

            $row = array();
            $row['DT_RowIndex'] = $no++;
            $row['code'] = $item->produk->code;
            $row['name_product'] = $item->produk->name_product . ' '.$item->produk->diskon.'%';
            $row['jumlah_terjual'] = $item->total_jumlah;
            $row['modal'] = 'Rp'.format_uang($item->total_jumlah * $item->produk->harga_beli);
            $row['penjualan'] = 'Rp'.format_uang($item->total_jumlah * $item->produk->harga_jual);
            $row['keuntungan'] = 'Rp'.format_uang(($item->total_jumlah * $item->produk->harga_jual) -  ($item->total_jumlah * $item->produk->harga_beli));

            $data[] = $row;

            $total_menu += $item->total_jumlah;
            $total_modal += $item->total_jumlah * $item->produk->harga_beli;
            $total_penjualan += $item->total_jumlah * $item->produk->harga_jual;
            $total_keuntungan += ($item->total_jumlah * $item->produk->harga_jual) -  ($item->total_jumlah * $item->produk->harga_beli);
            
            
        }
        $data[] = [
            'DT_RowIndex' => '',
            'code' => '',
            'name_product' => 'TOTAL',
            'jumlah_terjual' => ''. $total_menu .'',
            'modal' => 'Rp'.format_uang($total_modal) .'',
            'penjualan' => 'Rp'.format_uang($total_penjualan) .'',
            'keuntungan' => 'Rp'.format_uang($total_keuntungan) .'',
        ];

         return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['name_product'])
            ->make(true);
    }

    public function pengeluaran()
    {
        $tanggalAkhir = date('Y-m-d');

        $pengeluaranDetail = PengeluaranDetail::whereDate('created_at', $tanggalAkhir)->get();
        
        $no = 1;
        $data = array();
        $total_pengeluaran = 0;

        foreach($pengeluaranDetail as $item) {
            $row = array();
            $row['DT_RowIndex'] = $no++;
            $row['code'] = $item->code;
            $row['uraian'] = $item->uraian;
            $row['jumlah'] = format_uang($item->jumlah);
            $row['satuan'] = $item->satuan;
            $row['harga_beli'] = 'Rp'.format_uang($item->harga_beli);
            $row['subtotal'] = 'Rp'.format_uang($item->subtotal);

            $data[] = $row;

            $total_pengeluaran += $item->subtotal;
        }

        $data[] = [
            'DT_RowIndex' => '',
            'code' => 'TOTAL',
            'uraian' => '',
            'jumlah' => '',
            'satuan' => '',
            'harga_beli' => '',
            'subtotal' => 'Rp'.format_uang($total_pengeluaran) .'',
        ];

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['code'])
            ->make(true);
    }
}
