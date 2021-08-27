<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Pembelian;
use App\PembelianDetail;
use App\Product;
use App\Produk;
use App\Supplier;
use Illuminate\Http\Request;

class PembelianDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_pembelian = session('id_pembelian');
        $produk = Produk::orderBy('name_product')->get();
        $supplier = Supplier::find(session('id_supplier'));
        $codePembelian = Pembelian::find($id_pembelian)->code ?? 0;
        $diskon = Pembelian::find($id_pembelian)->diskon ?? 0;

        if (! $supplier) {
            abort(404);
        }

        return view('pages.admin.pembelian-detail.index', [
            'id_pembelian' => $id_pembelian,
            'produk' => $produk,
            'supplier' => $supplier,
            'codePembelian' => $codePembelian,
            'diskon' => $diskon,
        ]);
    }

    public function data($id)
    {
        $detail = PembelianDetail::with('produk')
            ->where('id_pembelian', $id)
            ->get();
       
        return datatables()
            ->of($detail)
            ->addIndexColumn()
            ->addColumn('name_product', function ($detail) {
                return $detail->produk['name_product'];
            })
            ->addColumn('code', function ($detail) {
                return $detail->produk['code'];
            })
            ->addColumn('harga_beli', function ($detail) {
                return 'Rp'. $detail->produk['harga_beli'];
            })
            ->addColumn('jumlah', function ($detail) {
                return '<input type="number" class="form-control input-sm quantity"  data-id="'. $detail->id_pembelian_detail .'" value="'. $detail->jumlah .'">';
            })
            ->addColumn('subtotal', function ($detail) {
                return 'Rp'. $detail->subtotal;
            })
            ->addColumn('aksi', function ($detail) {
                return '
                <div class="btn-group">
                    <button onclick="deleteData(`'. route('pembelian_detail.destroy', $detail->id_pembelian_detail) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'jumlah'])
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
        $produk = Produk::where('id_produk', $request->id_produk)->first();
        if (! $produk) {
            return response()->json('Data gagal disimpan', 400);
        }

        $data = $request->all();
        $data['subtotal'] = $produk->harga_beli * $request->jumlah;

        PembelianDetail::create($data);

        return redirect()->route('pembelian_detail.index')
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
        $detail = PembelianDetail::find($id);
        $detail->jumlah = $request->jumlah;
        $detail->subtotal = $detail->harga_beli * $request->jumlah;
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
        $detail = PembelianDetail::find($id);
        $detail->delete();

        return response(null, 204);
    }
}
