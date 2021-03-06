<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Produk;
use App\Setting;
use Carbon\Carbon;
use App\Transaction;
use App\TransactionDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::orderBy('id_transaction', 'desc')->get();  
        $produk = Produk::orderBy('name_product')->get();
        $user = User::orderBy('name')->get();

        $total_penjualan_report = Transaction::where('transaction_status', 'sukses')->sum('bayar');
        $jumlah_penjualan_report = Transaction::where('transaction_status', 'sukses')->sum('total_item');

        return view('pages.admin.transaction.index', [
            'transactions' => $transactions,
            'produk' => $produk,
            'user' => $user,
            'total_penjualan_report' => $total_penjualan_report,
            'jumlah_penjualan_report' => $jumlah_penjualan_report,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function data()
    {
        $transaction = Transaction::orderBy('id_transaction', 'desc')->get();

        return datatables()
            ->of($transaction)
            ->addIndexColumn()
            ->addColumn('code', function ($transaction) {
                return $transaction->code;
            })    
            ->addColumn('tanggal', function ($transaction) {
                return tanggal_indonesia($transaction->created_at, false);
            })
            ->editColumn('kasir', function ($transaction) {
                return $transaction->user->name ?? '';
            })
            ->editColumn('member', function ($transaction) {
                return $transaction->member->name ?? '';
            }) 
            ->addColumn('total_harga', function ($transaction) {
                return 'Rp'. format_uang($transaction->total_harga);
            }) 
            ->editColumn('diskon', function ($transaction) {
                return $transaction->diskon . '%';
            })  
            ->addColumn('bayar', function ($transaction) {
                return 'Rp'. format_uang($transaction->bayar);
            })    
            ->addColumn('diterima', function ($transaction) {
                return 'Rp'. format_uang($transaction->diterima);
            })    
            ->addColumn('status', function ($transaction) {
                return $transaction->transaction_status;
            })    
            ->addColumn('aksi', function ($transaction) {
                return '
                <div class="btn-group">
                    <button onclick="showDetail(`'. route('transaction.show', $transaction->id_transaction) .'`)" class="btn btn-xs btn-info btn-flat m-1"><i class="fa fa-eye"></i></button>
                    <button onclick="deleteData(`'. route('transaction.destroy', $transaction->id_transaction) .'`)" class="btn btn-xs btn-danger btn-flat m-1"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'status'])
            ->make(true);
    }


    public function create()
    {
        $tanggal = Carbon::now()->format('dmY');
        $cek = Transaction::count();
        if ($cek == 0) {
            $urut = 100001;
            $code = 'Penj-' . $tanggal . $urut;
        } else {
            $ambil = Transaction::all()->last();
            $urut = (int)substr($ambil->code, -6) + 1;  
            $code = 'SKR-' . $tanggal . $urut;      
        }

        $transaction = new Transaction();
        $transaction->id_member = null;
        $transaction->code = $code;
        $transaction->transaction_status = "pending";
        $transaction->total_item = 0;
        $transaction->total_harga = 0;
        $transaction->diskon = 0;
        $transaction->bayar = 0;
        $transaction->diterima = 0;
        $transaction->users_id = auth()->id();
        $transaction->save();

        session(['id_transaction' => $transaction->id_transaction]);
        return redirect()->route('transaction-details.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $transaksi = Transaction::findOrFail($request->transactions_id);
        $transaksi->total_item = $request->total_item;
        $transaksi->transaction_status = 'success';
        $transaksi->id_member = $request->id_member;
        $transaksi->customer_name = $request->customer_name;
        $transaksi->total_harga = $request->total;
        $transaksi->diskon = $request->diskon;
        $transaksi->bayar = $request->bayar;
        $transaksi->diterima = $request->diterima;
        $transaksi->keterangan = $request->keterangan;
        $transaksi->update();

        $detail = TransactionDetail::where('transactions_id', $transaksi->id_transaction)->get();
        foreach ($detail as $item) {
            $produk = Produk::find($item->products_id);
            $produk->stok -= $item->jumlah;
            $produk->update();
        }

        return redirect()->route('transactions.selesai')
        ->with('success', 'Data transaksi penjualan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        $detail = TransactionDetail::with('produk')->where('transactions_id', $id)->get();

        return datatables()
        ->of($detail)
        ->addIndexColumn()
            ->addColumn('code', function ($detail) {
                return $detail->code;
            })    
            ->addColumn('nama_produk', function ($detail) {
                return $detail->produk->name_product;
            })    
            ->addColumn('tanggal', function ($detail) {
                return tanggal_indonesia($detail->created_at, false);
            }) 
            ->addColumn('harga_jual', function ($detail) {
                return 'Rp'. format_uang($detail->harga_jual);
            }) 
            ->editColumn('diskon', function ($detail) {
                return $detail->diskon . '%';
            })  
            ->addColumn('subtotal', function ($detail) {
                return 'Rp'. format_uang($detail->subtotal);
            })  
            ->make(true);
    }

    public function show($id)
    {
        $transaction = Transaction::find($id);

        return response()->json($transaction);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $item = Transaction::findOrFail($id);

        $item->update($data);

         return redirect()->route('transactions.index')
          ->with('success', 'Data Trasaction berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = Transaction::find($id);
        $detail      = TransactionDetail::where('transactions_id', $transaction->id_transaction)->get();
        foreach ($detail as $item) {
            $produk = Produk::find($item->products_id);
            if ($produk) {
                $produk->stok += $item->jumlah;
                $produk->update();
            }
            $item->delete();
        }

        $transaction->delete();

        return redirect()->route('transactions.index');
    
    }

    public function selesai()
    {
        $setting = Setting::first();

        return view('pages.admin.transaction.selesai', [
            'setting' => $setting
        ]);

    }

    public function notaKecil()
    {
        $setting = Setting::first();
        $penjualan = Transaction::find(session('id_transaction'));
        if (! $penjualan) {
            abort(404);
        }
        $detail = TransactionDetail::with('produk')
            ->where('transactions_id', session('id_transaction'))
            ->get();
        
        return view('pages.admin.transaction.nota_kecil', [
            'setting' => $setting,
            'penjualan' => $penjualan,
            'detail' => $detail,
        ]);
    }

    public function notaBesar()
    {
        $setting = Setting::first();
        $penjualan = Transaction::find(session('id_transaction'));
            if (! $penjualan) {
                abort(404);
            }
        $detail = TransactionDetail::with('produk')
            ->where('transactions_id', session('id_transaction'))
            ->get(); 
        $customPaper = array(0,0,615,936);
        $pdf = PDF::loadView('pages.admin.transaction.nota_besar',[
            'setting' => $setting,
            'penjualan' => $penjualan,
            'detail' => $detail,
            
        ])->setPaper($customPaper, 'potrait')->setWarnings(false);

        // ->setPaper('f4', 'portrait')

        return $pdf->stream('Penjualan-'. date('Y-m-d-his') .'.pdf');
      
    }

    public function print($id)
    {
        $setting = Setting::first();
        $penjualan = Transaction::find($id);
            if (! $penjualan) {
                abort(404);
            }
        $detail = TransactionDetail::with('produk')
            ->where('transactions_id', $id)
            ->get();
        
        return view('pages.admin.transaction.nota_kecil', [
            'setting' => $setting,
            'penjualan' => $penjualan,
            'detail' => $detail,
        ]);
    }

    public function transactionAll(Request $request)
    {
        $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $tanggalAkhir = date('Y-m-d');

        if ($request->has('tanggal_awal') && $request->tanggal_awal != "" && $request->has('tanggal_akhir') && $request->tanggal_akhir) {
            $tanggalAwal = $request->tanggal_awal;
            $tanggalAkhir = $request->tanggal_akhir;
        }

        $transactionAll = TransactionDetail::orderBy('id_transaction_detail', 'desc')->get(); 
        
        return view('pages.admin.transaction.transactionAll', [
            'transactionAll' => $transactionAll,
            'tanggalAwal' => $tanggalAwal,
            'tanggalAkhir' => $tanggalAkhir
        ]);
    }

    public function dataDetail()
    {
        $transactionAll = TransactionDetail::orderBy('id_transaction_detail', 'desc')
            ->get();
        $data = array();
        $total_jumlah = 0;
        $total_modal = 0;
        $total_penjualan = 0;
        $total_keuntungan = 0;

        foreach($transactionAll as $item) {
            $total_jumlah += $item->jumlah;
            $total_modal += $item->produk->harga_beli * $item->jumlah;
            $total_penjualan += $item->subtotal;
            $total_keuntungan += $item->subtotal - ($item->produk->harga_beli * $item->jumlah);

            $row = array();
            $row['code'] = $item->code;
            $row['created_at'] = tanggal_indonesia($item->created_at);
            $row['code_produk'] = $item->produk['code'];
            $row['name_produk'] = $item->produk['name_product'];
            $row['modal'] = 'Rp'.format_uang($item->produk['harga_beli']);
            $row['harga_jual'] = 'Rp'.format_uang($item->harga_jual);
            $row['jumlah'] = format_uang($item->jumlah);
            $row['diskon'] = $item->diskon.'%';
            $row['total_modal'] = 'Rp'.format_uang($item->produk->harga_beli * $item->jumlah);
            $row['subtotal'] = 'Rp'.format_uang($item->subtotal);
            $row['keuntungan'] = 'Rp'.format_uang($item->subtotal - ($item->produk->harga_beli * $item->jumlah));

            $data[] = $row;
        }
        $data[] = [
            'code' => '<b> Total </b>',
            'created_at' => '',
            'name_produk' => '',
            'modal' => '',
            'harga_jual' => '',
            'jumlah' => format_uang($total_jumlah),
            'diskon' => '',
            'total_modal' => 'Rp'.format_uang($total_modal),
            'subtotal' => 'Rp'.format_uang($total_penjualan),
            'keuntungan' => 'Rp'.format_uang($total_keuntungan),
        ];
        
        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['code', 'code_produk'])
            ->make(true);
    }

    public function searchByDate(Request $request)
    {
        $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $tanggalAkhir = date('Y-m-d');

        if ($request->has('tanggal_awal') && $request->tanggal_awal != "" && $request->has('tanggal_akhir') && $request->tanggal_akhir) {
            $tanggalAwal = $request->tanggal_awal;
            $tanggalAkhir = $request->tanggal_akhir;
        }

        $transactionAll = TransactionDetail::where('created_at', '>=', $request->tanggal_awal)->where('created_at', '<=', $request->tanggal_akhir)->get(); 
        
        return view('pages.admin.transaction.transactionAll', [
            'transactionAll' => $transactionAll,
            'tanggalAwal' => $tanggalAwal,
            'tanggalAkhir' => $tanggalAkhir
        ]);
    }

    public function getData($awal, $akhir)
    {
        $no = 1;
        $data = array();
        $menu = 0;
        $modal = 0;
        $penjualan = 0;
        $profit = 0;

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1 day", strtotime($awal)));

            $total_menu = TransactionDetail::where('created_at', 'LIKE', "%$tanggal%")->sum('jumlah');
            $total_penjualan = TransactionDetail::where('created_at', 'LIKE', "%$tanggal%")->sum('subtotal');

            $menu += $total_menu;
            $penjualan += $total_penjualan;

            $pendapatan = $total_penjualan;

            $transactionAll = TransactionDetail::orderBy('id_transaction_detail', 'desc')
            ->get();

            $row = array();
            $row['DT_RowIndex'] = $no++;
            $row['tanggal'] = tanggal_indonesia($tanggal, false);
            $row['code_produk'] = $transactionAll->produk['code'];

            $data[] = $row;
        }

        $data[] = [
            'DT_RowIndex' => '',
            'tanggal' => 'Total',
            'code_produk' => '',
        ];

        return $data;
    }

    public function dataPenjualan($awal, $akhir)
    {
        $data = $this->getData($awal, $akhir);

        return datatables()
            ->of($data)
            ->make(true);
    }
}
