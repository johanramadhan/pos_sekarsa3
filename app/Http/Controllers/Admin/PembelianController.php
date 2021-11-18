<?php

namespace App\Http\Controllers\Admin;

use App\Produk;
use App\Supplier;
use App\Pembelian;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PembelianDetail;
use App\Persediaan;
use App\Setting;
use PDF;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::orderBy('name')->get();  
        $produk = Produk::orderBy('name_product')->get();
        $user = User::orderBy('name')->get();
        $users = User::all();
        $pembelians = Pembelian::orderBy('tgl_pembelian', 'desc')->get();

        return view('pages.admin.pembelian.index', [
            'suppliers' => $suppliers,
            'produk' => $produk,
            'user' => $user,
            'users' => $users,
            'pembelians' => $pembelians,
        ]);
    }

    public function data()
    {
        $pembelian = Pembelian::orderBy('id_pembelian', 'desc')->get();

        return datatables()
            ->of($pembelian)
            ->addIndexColumn()
            ->addColumn('total_item', function ($pembelian) {
                return format_uang($pembelian->total_item);
            })
            ->addColumn('total_harga', function ($pembelian) {
                return 'Rp'. format_uang($pembelian->total_harga);
            })
            ->addColumn('bayar', function ($pembelian) {
                return 'Rp'. format_uang($pembelian->bayar);
            })
            ->addColumn('tanggal', function ($pembelian) {
                return tanggal_indonesia($pembelian->created_at, false);
            })
            ->addColumn('supplier', function ($pembelian) {
                return $pembelian->supplier->name;
            })
            ->editColumn('diskon', function ($pembelian) {
                return $pembelian->diskon . '%';
            })
            ->addColumn('aksi', function ($pembelian) {
                return '
                <div class="btn-group">
                    <button onclick="print(`'. route('pembelian.print', $pembelian->id_pembelian) .'`)" class="btn btn-xs btn-default m-1"><i class="fa fa-print"></i></button>
                    <button onclick="showDetail(`'. route('pembelian.show', $pembelian->id_pembelian) .'`)" class="btn btn-xs btn-info m-1"><i class="fa fa-eye"></i></button>
                    <button onclick="deleteData(`'. route('pembelian.destroy', $pembelian->id_pembelian) .'`)" class="btn btn-xs btn-danger m-1"><i class="fa fa-trash"></i></button>
                </div>
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
    
    public function tambah($id)
    {
        $tanggal = Carbon::now()->format('dmY');
        $tanggalAkhir = date('Y-m-d');
        $cek = Pembelian::count();
        if ($cek == 0) {
            $urut = 100001;
            $code = 'Pemb-' . $tanggal . $urut;
        } else {
            $ambil = Pembelian::all()->last();
            $urut = (int)substr($ambil->code, -6) + 1;  
            $code = 'Pemb-' . $tanggal . $urut;      
        }

        $pembelian = new Pembelian();
        $pembelian->code         = $code;
        $pembelian->users_id     =  auth()->id();
        $pembelian->tgl_pembelian =  $tanggalAkhir;
        $pembelian->id_supplier  = $id;
        $pembelian->total_item  = 0;
        $pembelian->total_harga = 0;
        $pembelian->diskon      = 0;
        $pembelian->bayar       = 0;
        $pembelian->status      = "Pending";
        $pembelian->save();

        session(['id_pembelian' => $pembelian->id_pembelian]);
        session(['id_supplier' => $pembelian->id_supplier]);

        return redirect()->route('pembelian_detail.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pembelian = Pembelian::findOrFail($request->id_pembelian);
        $pembelian->users_id = $request->users_id;
        $pembelian->tgl_pembelian = $request->tgl_pembelian;
        $pembelian->total_item = $request->total_item;
        $pembelian->total_harga = $request->total;
        $pembelian->diskon = $request->diskon;
        $pembelian->bayar = $request->bayar;
        $pembelian->status ='Success';
        $pembelian->update();

        $detail = PembelianDetail::where('id_pembelian', $pembelian->id_pembelian)->get();
        foreach ($detail as $item) {
            $persediaan = Persediaan::find($item->id_produk);
            $persediaan->stok += $item->jumlah;
            $persediaan->berat = $item->berat;
            $persediaan->total_berat += $item->berat_total;
            $persediaan->harga_persatuan = $item->harga_persatuan;
            $persediaan->update();
        }

        return redirect()->route('pembelian.index')
        ->with('success', 'Data pembelian penjualan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        $detail = PembelianDetail::with('persediaan')->where('id_pembelian', $id)->get();

        return datatables()
            ->of($detail)
            ->addIndexColumn()
            ->addColumn('code', function ($detail) {
                return '<span class="label label-success">'. $detail->code .'</span>';
            })
            ->addColumn('tanggal', function ($detail) {
                return tanggal_indonesia($detail->created_at, false);
            })
            ->addColumn('name', function ($detail) {
                return $detail->persediaan->name_persediaan;
            })
            ->addColumn('harga_beli', function ($detail) {
                return 'Rp'. format_uang($detail->harga_beli);
            })
            ->addColumn('jumlah', function ($detail) {
                return format_uang($detail->jumlah);
            })
            ->addColumn('berat', function ($detail) {
                return format_uang($detail->berat);
            })
            ->addColumn('berat_total', function ($detail) {
                return format_uang($detail->berat_total);
            })
            ->addColumn('subtotal', function ($detail) {
                return 'Rp'. format_uang($detail->subtotal);
            })
            ->rawColumns(['code'])
            ->make(true);
    }

    public function show($id)
    {
        $pembelian = Pembelian::find($id);

        return response()->json($pembelian);
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
        $item = Pembelian::findOrFail($id);

        $item->update($data);

         return redirect()->route('pembelian.index')
          ->with('success', 'Data pembelian berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pembelian = Pembelian::find($id);
        $detail    = PembelianDetail::where('id_pembelian', $pembelian->id_pembelian)->get();
        foreach ($detail as $item) {
            $persediaan = Persediaan::find($item->id_produk);
            if ($persediaan) {
                $persediaan->stok -= $item->jumlah;
                $persediaan->total_berat -= $item->berat_total;
                $persediaan->update();
            }
            $item->delete();
        }

        $pembelian->delete();

        return redirect()->route('pembelian.index');
    }

    public function print($id)
    {
        $setting = Setting::first();
        $pembelian = Pembelian::find($id);
            if (! $pembelian) {
                abort(404);
            }
        $detail = PembelianDetail::where('id_pembelian', $id)
            ->get(); 
        $customPaper = array(0,0,615,936);
        $pdf = PDF::loadView('pages.admin.pembelian.nota_besar',[
            'setting' => $setting,
            'pembelian' => $pembelian,
            'detail' => $detail,
            
        ])->setPaper($customPaper, 'potrait')->setWarnings(false);

        // ->setPaper('f4', 'portrait')

        return $pdf->stream('Pembelian-'. date('Y-m-d-his') .'.pdf');
    }

    public function pembelianAllEdit()
    {
        $pembelianAll = PembelianDetail::orderBy('id_produk', 'desc')->get(); 
        
        return view('pages.admin.pembelian.pembelianAll', [
            'pembelianAll' => $pembelianAll,
        ]);
    }
}
