<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Pembelian;
use App\Pengeluaran;
use App\Transaction;
use App\TransactionDetail;
use Illuminate\Http\Request;
use PDF;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $tanggalAkhir = date('Y-m-d');

        if ($request->has('tanggal_awal') && $request->tanggal_awal != "" && $request->has('tanggal_akhir') && $request->tanggal_akhir) {
            $tanggalAwal = $request->tanggal_awal;
            $tanggalAkhir = $request->tanggal_akhir;
        }

        return view('pages.admin.laporan.index', [
            'tanggalAwal' => $tanggalAwal,
            'tanggalAkhir' => $tanggalAkhir
        ]);
    }

    public function getData($awal, $akhir)
    {
        $no = 1;
        $data = array();
        $pendapatan = 0;
        $menu = 0;
        $penjualan = 0;
        $pembelian = 0;
        $pengeluaran = 0;
        $total_pendapatan = 0;

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1 day", strtotime($awal)));

            $total_menu = TransactionDetail::where('created_at', 'LIKE', "%$tanggal%")->sum('jumlah');
            $total_penjualan = Transaction::where('created_at', 'LIKE', "%$tanggal%")->sum('bayar');
            $total_pembelian = Pembelian::where('tgl_pembelian', 'LIKE', "%$tanggal%")->sum('bayar');
            $total_pengeluaran = Pengeluaran::where('tgl_pengeluaran', 'LIKE', "%$tanggal%")->sum('total_harga');

            $menu += $total_menu;
            $penjualan += $total_penjualan;
            $pembelian += $total_pembelian;
            $pengeluaran += $total_pengeluaran;

            $pendapatan = $total_penjualan - $total_pembelian - $total_pengeluaran;
            $total_pendapatan += $pendapatan;

            $row = array();
            $row['DT_RowIndex'] = $no++;
            $row['tanggal'] = tanggal_indonesia($tanggal, false);
            $row['menu'] = format_uang($total_menu);
            $row['penjualan'] = format_uang($total_penjualan);
            $row['pembelian'] = format_uang($total_pembelian);
            $row['pengeluaran'] = format_uang($total_pengeluaran);
            $row['pendapatan'] = format_uang($pendapatan);

            $data[] = $row;
        }

        $data[] = [
            'DT_RowIndex' => '',
            'tanggal' => 'Total',
            'menu' => format_uang($menu),
            'penjualan' => 'Rp'.format_uang($penjualan),
            'pembelian' => 'Rp'.format_uang($pembelian),
            'pengeluaran' => 'Rp'.format_uang($pengeluaran),
            'pendapatan' => 'Rp'.format_uang($total_pendapatan),
        ];

        return $data;
    }

    public function data($awal, $akhir)
    {
        $data = $this->getData($awal, $akhir);

        return datatables()
            ->of($data)
            ->make(true);
    }

    public function exportPDF($awal, $akhir)
    {
        $data = $this->getData($awal, $akhir);
        $pdf  = PDF::loadView('pages.admin.laporan.pdf', compact('awal', 'akhir', 'data'));
        $customPaper = array(0,0,615,936);
        $pdf->setPaper($customPaper, 'potrait')->setWarnings(false);
        
        return $pdf->stream('Laporan-pendapatan-'. date('Y-m-d-his') .'.pdf');
    }


    // Laporan Report
    public function getDataReport($awal, $akhir)
    {
        $no = 1;
        $data = array();
        $pendapatan = 0;
        $menu = 0;
        $penjualan = 0;
        $pembelian = 0;
        $pengeluaran = 0;
        $total_pendapatan = 0;

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1 day", strtotime($awal)));

            $total_menu = Transaction::where('transaction_status', 'sukses')->whereDate('created_at', 'LIKE', "%$tanggal%")->sum('total_item');
            $total_penjualan = Transaction::where('transaction_status', 'sukses')->whereDate('created_at', 'LIKE', "%$tanggal%")->sum('bayar');
            $total_pembelian = Pembelian::where('status', 'Sukses')->whereDate('tgl_pembelian', 'LIKE', "%$tanggal%")->sum('bayar');
            $total_pengeluaran = Pengeluaran::where('status', 'Sukses')->whereDate('tgl_pengeluaran', 'LIKE', "%$tanggal%")->sum('total_harga');

            $menu += $total_menu;
            $penjualan += $total_penjualan;
            $pembelian += $total_pembelian;
            $pengeluaran += $total_pengeluaran;

            $pendapatan = $total_penjualan - $total_pembelian - $total_pengeluaran;
            $total_pendapatan += $pendapatan;

            $row = array();
            $row['DT_RowIndex'] = $no++;
            $row['tanggal'] = tanggal_indonesia($tanggal, false);
            $row['menu'] = format_uang($total_menu);
            $row['penjualan'] = format_uang($total_penjualan);
            // $row['pembelian'] = format_uang($total_pembelian);
            // $row['pengeluaran'] = format_uang($total_pengeluaran);
            $row['pendapatan'] = format_uang($pendapatan);

            $data[] = $row;
        }

        $data[] = [
            'DT_RowIndex' => '',
            'tanggal' => 'Total',
            'menu' => format_uang($menu),
            'penjualan' => 'Rp'.format_uang($penjualan),
            // 'pembelian' => 'Rp'.format_uang($pembelian),
            // 'pengeluaran' => 'Rp'.format_uang($pengeluaran),
            'pendapatan' => 'Rp'.format_uang($total_pendapatan),
        ];

        return $data;
    }

    public function dataReport($awal, $akhir)
    {
        $data = $this->getDataReport($awal, $akhir);

        return datatables()
            ->of($data)
            ->make(true);
    }

    public function exportPDFReport($awal, $akhir)
    {
        $data = $this->getDataReport($awal, $akhir);
        $pdf  = PDF::loadView('pages.admin.laporan.pdf', compact('awal', 'akhir', 'data'));
        $customPaper = array(0,0,615,936);
        $pdf->setPaper($customPaper, 'potrait')->setWarnings(false);
        
        return $pdf->stream('Laporan-pendapatan-'. date('Y-m-d-his') .'.pdf');
    }
}
