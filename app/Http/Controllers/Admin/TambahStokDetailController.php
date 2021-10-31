<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Pembelian;
use App\Persediaan;
use App\Produk;
use App\Stok;
use App\StokDetail;
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
        $diskon = Stok::find($id_stok)->total_item ?? 0;

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

    public function data($id)
    {
        $detail = StokDetail::with('persediaan')
            ->where('id_stok', $id)
            ->get();  
        $data = array();
        $total = 0;
        $totalBerat = 0;
        $total_item = 0;
        $total_modal = 0;
        
        foreach($detail as $item) {
            $row = array();
            $row['codePersediaan'] = $item->code;
            $row['namaPersediaan'] = $item->persediaan['name_persediaan'];
            $row['satuanBerat'] = $item->persediaan['satuan_berat'];
            $row['jumlah'] = '<input type="number" class="form-control input-sm quantity" data-id="'. $item->id_stok_detail .'" value="'. $item->jumlah .'">';
            $row['berat'] = format_uang($item->berat);
            $row['beratTotal'] = format_uang($item->berat_total);
            $row['harga_persatuan'] = 'Rp'.format_uang($item->harga_beli);
            $row['subtotal'] = 'Rp'.format_uang($item->subtotal);
            $row['aksi'] = '<button onclick="deleteData(`'. route('tambahStok_detail.destroy', $item->id_stok_detail) .'`)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>';

            $data[] = $row;
            $total += $item->harga_beli * $item->jumlah;
            $totalBerat += $item->berat * $item->jumlah;
            $total_item += $item->jumlah;
            $total_modal += $item->harga_beli;
        }
        $data[] = [
           'codePersediaan' => '
                <div class="total d-none">'. $total .'</div>
                <div class="totalBerat d-none">'. $totalBerat .'</div>
                <div class="total_item d-none">'. $total_item .'</div>
                <div class="total_modal d-none">'. $total_modal .'</div>',
            'namaPersediaan' => '',
            'satuanBerat' => '',
            'jumlah'         => '',
            'berat'    => '',
            'beratTotal'    => '',
            'harga_persatuan'  => '',
            'subtotal'    => '',
            'aksi'        => '',
        ];

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['aksi', 'codePersediaan','jumlah','berat'])
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
        $persediaans = Persediaan::where('id_persediaan', $request->id_persediaan)->first();
        if (! $persediaans) {
            return response()->json('Data gagal disimpan', 400);
        }

        $persediaan = Persediaan::find($request->id_persediaan);
        $persediaan->stok -= round(($request->berat * $request->jumlah) / $persediaan->berat);
        $persediaan->total_berat -= $request->berat * $request->jumlah;
        $persediaan->update();

        $data = $request->all();
        $data['berat_total'] = $request->berat * $request->jumlah;
        $data['subtotal'] = $request->harga_beli * $request->jumlah;

        StokDetail::create($data);

        

        return redirect()->route('tambahStok_detail.index')
         ->with('success', 'Persediaan berhasil ditambahkan');
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
        $detail = StokDetail::find($id);
        $detail->jumlah = $request->jumlah;
        $detail->subtotal = $detail->harga_beli * $request->jumlah;
        $detail->berat_total = $detail->berat * $request->jumlah;
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
        $detail = StokDetail::find($id);
        $persediaan = Persediaan::find($detail->id_persediaan);
        $persediaan->total_berat += $detail->berat_total;
        $persediaan->stok += round($detail->berat_total / $persediaan->berat);
        $persediaan->update();

        $detail->delete();

        return response(null, 204);
    }

    public function loadForm($total, $diskon, $total_modal)
    {
        $bayar = $total - ($diskon / 100 * $total);
        $data  = [
            'totalrp' => format_uang($total),
            'total_modal' => $total_modal,
            'modalrp' => format_uang($total_modal),
            'bayar' => $bayar,
            'bayarrp' => format_uang($bayar),
            'terbilang' => ucwords(terbilang($bayar). ' Rupiah')
        ];

        return response()->json($data);
    }
}
