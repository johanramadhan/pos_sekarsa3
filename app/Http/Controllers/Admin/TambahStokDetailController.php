<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Pembelian;
use App\Persediaan;
use App\Produk;
use App\Stok;
use App\Supplier;
use Illuminate\Http\Request;

class TambahStokDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_stok = session('id_stok');
        $produks = Produk::orderBy('name_product')->get();
        $persediaan = Persediaan::orderBy('name_persediaan')->get();
        $produk = Produk::find(session('id_produk'));
        $codePenambahan = Stok::find($id_stok)->code ?? 0;
        $diskon = Pembelian::find($id_stok)->diskon ?? 0;

        if (! $produk) {
            return redirect()->route('tambahStok.index');
        }

        return view('pages.admin.stok-detail.index', [
            'id_stok' => $id_stok,
            'produks' => $produks,
            'persediaan' => $persediaan,
            'produk' => $produk,
            'codePenambahan' => $codePenambahan,
            'diskon' => $diskon,
        ]);
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
        //
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
}
