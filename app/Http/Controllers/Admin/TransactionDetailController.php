<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Produk;
use App\Transaction;
use App\TransactionDetail;
use App\User;
use Illuminate\Http\Request;

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
        $transactions_id = session('id_transaction');

        return view('pages.admin.transaction-detail.index', [
            'transactions' => $transactions,
            'produk' => $produk,
            'user' => $user,
            'transactions_id' => $transactions_id,
        ]);
        
    }

    public function data($id)
    {
        $detail = TransactionDetail::with('produk')
            ->where('transactions_id', $id)
            ->get();


        return datatables()
            ->of($detail)
            ->addIndexColumn()
            ->addColumn('name_product', function ($detail) {
                return $detail->produk['name_product'];
            })
            ->addColumn('harga_jual', function ($detail) {
                return 'Rp'.format_uang($detail->harga_jual);
            })
            ->addColumn('subtotal', function ($detail) {
                return 'Rp'.format_uang($detail->subtotal);
            })
            ->addColumn('aksi', function ($detail) {
                return '
                    <button onclick="editForm(`'. route('transaction-detail.update', $detail->id_transaction_detail) .'`)" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></button>

                    <button onclick="deleteData(`'. route('transaction-detail.destroy', $detail->id_transaction_detail) .'`)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                ';
            })

            ->rawColumns(['aksi'])
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
        $data['diskon'] = 0;
        $data['subtotal'] = $produk->harga_jual * $request->jumlah;

        TransactionDetail::create($data);

        return redirect()->route('transaction-detail.index')
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
        $transaction_detail = TransactionDetail::find($id);

        return response()->json($transaction_detail);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        //
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
}
