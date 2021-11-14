<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Pembelian;
use App\PembelianDetail;
use App\Persediaan;
use App\Product;
use App\Produk;
use App\Supplier;
use App\User;
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
        $persediaan = Persediaan::orderBy('name_persediaan')->get();
        $supplier = Supplier::find(session('id_supplier'));
        $codePembelian = Pembelian::find($id_pembelian)->code ?? 0;
        $diskon = Pembelian::find($id_pembelian)->diskon ?? 0;
        $users = User::all();
              

        if (! $supplier) {
            return redirect()->route('pembelian.index');
        }

        return view('pages.admin.pembelian-detail.index', [
            'id_pembelian' => $id_pembelian,
            'produk' => $produk,
            'persediaan' => $persediaan,
            'supplier' => $supplier,
            'codePembelian' => $codePembelian,
            'diskon' => $diskon,
            'users' => $users,
        ]);
    }

    public function data($id)
    {
        $detail = PembelianDetail::with('persediaan')
            ->where('id_pembelian', $id)
            ->get();  
        $data = array();
        $total = 0;
        $totalBerat = 0;
        $total_item = 0;
        
        foreach($detail as $item) {
            $row = array();
            $row['codePersediaan'] = $item->code;
            $row['namaPersediaan'] = $item->persediaan['name_persediaan'];
            $row['satuanBerat'] = $item->persediaan['satuan_berat'];
            $row['jumlah'] = '<input type="number" class="form-control input-sm quantity" data-id="'. $item->id_pembelian_detail .'" value="'. $item->jumlah .'">';
            $row['berat'] = format_uang($item->berat);
            $row['beratTotal'] = format_uang($item->berat_total);
            $row['harga_beli'] = 'Rp'.format_uang($item->harga_beli);
            $row['harga_persatuan'] = 'Rp'.format_uang($item->harga_persatuan);
            $row['subtotal'] = 'Rp'.format_uang($item->subtotal);
            $row['aksi'] = '<button onclick="deleteData(`'. route('pembelian_detail.destroy', $item->id_pembelian_detail) .'`)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>';

            $data[] = $row;
            $total += $item->harga_beli * $item->jumlah;
            $totalBerat += $item->berat * $item->jumlah;
            $total_item += $item->jumlah;
        }
        $data[] = [
            'codePersediaan' => '
                <div class="total d-none">'. $total .'</div>
                <div class="totalBerat d-none">'. $totalBerat .'</div>
                <div class="total_item d-none">'. $total_item .'</div>',
            'namaPersediaan' => '',
            'satuanBerat' => '',
            'jumlah'         => '',
            'berat'    => '',
            'beratTotal'    => '',
            'harga_beli'  => '',
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
        $produk = Persediaan::where('id_persediaan', $request->id_produk)->first();
        if (! $produk) {
            return response()->json('Data gagal disimpan', 400);
        }

        $data = $request->all();
        $data['harga_persatuan'] = $request->harga_beli / $request->berat;
        $data['berat_total'] = $request->berat * $request->jumlah;
        $data['subtotal'] = $produk->harga_beli * $request->jumlah;

        PembelianDetail::create($data);

        return redirect()->route('pembelian_detail.index')
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
        $pembelianDetail = PembelianDetail::find($id);

        return response()->json($pembelianDetail);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $data = $request->all();
        $item = PembelianDetail::findOrFail($id);

        $item->update($data);

         return redirect()->route('pembelian_detail.index')
          ->with('success', 'Data pembelian detail berhasil diedit');
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
        $detail = PembelianDetail::find($id);
        $detail->jumlah = $request->jumlah;
        $detail->subtotal = $detail->harga_beli * $request->jumlah;
        $detail->berat_total = $detail->berat * $request->jumlah;
        $detail->update();
        $detail->update($data);
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

    public function loadForm($diskon, $total)
    {
        $bayar = $total - ($diskon / 100 * $total);
        $data  = [
            'totalrp' => format_uang($total),
            'bayar' => $bayar,
            'bayarrp' => format_uang($bayar),
            'terbilang' => ucwords(terbilang($bayar). ' Rupiah')
        ];

        return response()->json($data);
    }

    public function pembelianAll()
    {
        $pembelianAll = PembelianDetail::orderBy('id_pembelian', 'desc')->get(); 
        $persediaans = Persediaan::orderBy('id_persediaan')->get(); 
        $pembelians = Pembelian::orderBy('id_pembelian', 'desc')->get(); 
        
        return view('pages.admin.pembelian-detail.pembelianAll', [
            'pembelianAll' => $pembelianAll,
            'persediaans' => $persediaans,
            'pembelians' => $pembelians,
        ]);
    }
}
