<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Produk;
use App\Setting;
use App\Customer;
use App\Transaction;
use App\TransactionDetail;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $transactions = Transaction::all();  
        $produk = Produk::orderBy('name_product')->get();
        $user = User::orderBy('name')->get();
        $member = Customer::orderBy('name')->get();
        $transactions_id = session('id_transaction');
        $codeTransaction = Transaction::find($transactions_id)->code ?? 0; 
        $diskon = Transaction::find($transactions_id)->diskon ?? 0;
        $diskon2 = Setting::first()->diskon ?? 0;

        // Cek apakah ada transaksi yang sedang berjalan
        if ($id_penjualan = session('id_transaction')) {
            $penjualan = Transaction::find($id_penjualan);
            $memberSelected = $penjualan->member ?? new Customer();

            return view('pages.admin.transaction-detail.index', [
                'transactions' => $transactions,
                'codeTransaction' => $codeTransaction,
                'produk' => $produk,
                'user' => $user,
                'member' => $member,
                'transactions_id' => $transactions_id,
                'diskon' => $diskon,
                'diskon2' => $diskon2,
                'id_penjualan' => $id_penjualan,
                'penjualan' => $penjualan,
                'memberSelected' => $memberSelected,
            ]);
        } else {
            if(auth()->user()->roles == "ADMIN" ){
                return redirect()->route('transaction.create');
            }  else {
                return redirect()->route('home');
            }
        }
        
    }

    public function data($id)
    {
        $detail = TransactionDetail::with('produk')
            ->where('transactions_id', $id)
            ->get();
        $data = array();
        $total = 0;
        $total_item = 0;
        $total_poin = 0;

        foreach($detail as $item) {
            $row = array();
            $row['code_product'] = $item->produk['code'];
            $row['poin'] = $item->poin;
            $row['name_product'] = $item ->produk['name_product'];
            $row['jumlah'] = '<input type="number" class="form-control input-sm quantity" data-id="'. $item->id_transaction_detail .'" value="'. $item->jumlah .'">';
            $row['harga_jual'] = 'Rp'.format_uang($item->harga_jual);
            $row['diskon'] = $item ->produk['diskon'].'%';
            $row['subtotal'] = 'Rp'.format_uang($item->subtotal);
            $row['resi'] = format_uang($item->resi);
            $row['aksi'] = '<button onclick="deleteData(`'. route('transaction-details.destroy', $item->id_transaction_detail) .'`)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>';

            $data[] = $row;

            $total += ($item->harga_jual - ($item->harga_jual * $item->diskon / 100)) * $item->jumlah;

            $total_item += $item->jumlah;
            $total_poin += $item->resi;
        }
        $data[] = [
            'code_product' => '
                <div class="total ">'. $total .'</div>
                <div class="total_item ">'. $total_item .'</div>
                <div class="total_poin ">'. $total_poin .'</div>',
            'name_product' => '',
            'poin' => '',
            'jumlah'      => '',
            'harga_jual'  => '',
            'diskon'      => '',
            'subtotal'    => '',
            'resi'    => '',
            'aksi'        => '',
        ];

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['aksi', 'code_product', 'jumlah'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $produk = Produk::where('id_produk', $request->products_id)->first();
                
        $data = $request->all();
        $data['subtotal'] = ($produk->harga_jual - ($produk->harga_jual * $produk->diskon / 100)) * $request->jumlah;
        $data['resi'] = ($produk->poin * $request->jumlah);

        TransactionDetail::create($data);

        return redirect()->route('transaction-details.index')
         ->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $transaction_detail = TransactionDetail::find($id);

        return response()->json($transaction_detail);
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
        $detail = TransactionDetail::find($id);
        $detail->jumlah = $request->jumlah;
        $detail->subtotal = ($detail->harga_jual - ($detail->harga_jual * $detail->diskon / 100)) * $request->jumlah;
        $detail->resi =  $detail->poin * $request->jumlah;
        $detail->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detail = TransactionDetail::find($id);
        $detail->delete();

        return response(null, 204);
    }

    public function loadForm($diskon, $total, $diterima)
    {
        $bayar = $total - ($diskon / 100 * $total);
        $kembali = ($diterima != 0) ? $diterima - $bayar : 0;
        $data  = [
            'totalrp' => format_uang($total),
            'bayar' => $bayar,
            'bayarrp' => format_uang($bayar),
            'terbilang' => ucwords(terbilang($bayar). ' Rupiah'),
            'kembalirp' => format_uang($kembali),
            'kembali_terbilang' => ucwords(terbilang($kembali). ' Rupiah'),
        ];

        return response()->json($data);
    }
}
