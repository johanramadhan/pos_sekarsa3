<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Pembelian;
use App\Persediaan;
use App\Produk;
use App\Stok;
use App\StokDetail;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TambahStokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $persediaans = Persediaan::orderBy('name_persediaan')->get();  
        $produks = Produk::orderBy('name_product', 'desc')->get();
        $user = User::orderBy('name')->get();
        $stok = Stok::orderBy('id_stok', 'desc')->get();

        return view('pages.admin.stok.index', [
            'persediaans' => $persediaans,
            'produks' => $produks,
            'user' => $user,
            'stok' => $stok,
        ]);
    }

    public function data()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function tambah($id)
    {
        $tanggal = Carbon::now()->format('dmY');
        $cek = Stok::count();
        if ($cek == 0) {
            $urut = 100001;
            $code = 'Stok-' . $tanggal . $urut;
        } else {
            $ambil = Stok::all()->last();
            $urut = (int)substr($ambil->code, -6) + 1;  
            $code = 'Stok-' . $tanggal . $urut;      
        }

        $stok = new Stok();
        $stok->code         = $code;
        $stok->users_id     =  auth()->id();
        $stok->id_produk  = $id;
        $stok->total_item  = 0;
        $stok->total_harga = 0;
        $stok->diskon      = 0;
        $stok->bayar       = 0;
        $stok->status      = "Pending";
        $stok->save();

        session(['id_stok' => $stok->id_stok]);
        session(['id_produk' => $stok->id_produk]);

        return redirect()->route('tambahStok_detail.index');
    }

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
        $stok = Stok::findOrFail($request->id_stok);
        $stok->total_item = $request->total_item;
        $stok->total_harga = $request->total;
        $stok->diskon = $request->diskon;
        $stok->bayar = $request->bayar;
        $stok->status ='Success';
        $stok->update();

        $produk = Produk::find($stok->id_produk);
        $produk->stok += $request->total_item;
        $produk->harga_beli = $request->total_modal;
        $produk->update();

        // $detail = StokDetail::where('id_stok', $stok->id_stok)->get();
        // foreach ($detail as $item) {
        //     $persediaan = Persediaan::find($item->id_persediaan);
        //     $persediaan->total_berat -= $item->berat_total;
        //     $persediaan->update();
        // }

        return redirect()->route('tambahStok.index')
        ->with('success', 'Data stok produk berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    public function print($id)
    {
        //
    }
}
