<?php

namespace App\Http\Controllers\Admin;

use App\Aset;
use App\Customer;
use App\Http\Controllers\Controller;
use App\Pengeluaran;
use App\PengeluaranDetail;
use App\Persediaan;
use App\Produk;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PengeluaranDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_pengeluaran = session('id_pengeluaran');
        $pengeluarans = Pengeluaran::all(); 
        $user = User::orderBy('name')->get();
        $codePengeluaran = Pengeluaran::find($id_pengeluaran)->code ?? 0;
        $diskon = Pengeluaran::find($id_pengeluaran)->diskon ?? 0;

        $tanggal = Carbon::now()->format('dmY');
        $cek = PengeluaranDetail::count();
        if ($cek == 0) {
            $urut = 100001;
            $code = 'PD-' . $tanggal . $urut;
        } else {
            $ambil = PengeluaranDetail::all()->last();
            $urut = (int)substr($ambil->code, -6) + 1;  
            $code = 'PD-' . $tanggal . $urut;      
        }

        return view('pages.admin.pengeluaran-detail.index', [
            'pengeluarans' => $pengeluarans,            
            'user' => $user,            
            'id_pengeluaran' => $id_pengeluaran,            
            'codePengeluaran' => $codePengeluaran,           
            'diskon' => $diskon,            
            'code' => $code,          
        ]);
    }


    public function data($id)
    {
        $detail = PengeluaranDetail::where('id_pengeluaran', $id)
            ->get();
        $data = array();
        $total = 0;
        $total_item = 0;

        foreach($detail as $item) {
            $row = array();
            $row['code'] = $item['code'];
            $row['uraian'] = $item ['uraian'];
            $row['jumlah'] = '<input type="number" class="form-control input-sm quantity" data-id="'. $item->id_pengeluaran_detail .'" value="'. $item->jumlah .'">';
            $row['harga_beli'] = 'Rp'.format_uang($item->harga_beli);
            $row['subtotal'] = 'Rp'.format_uang($item->subtotal);
            $row['aksi'] = '<button onclick="deleteData(`'. route('pengeluaran_detail.destroy', $item->id_pengeluaran_detail) .'`)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>';

            $data[] = $row;
            $total += $item->harga_beli * $item->jumlah;
            $total_item += $item->jumlah;
        }
        $data[] = [
            'code' => '
                <div class="total d-none">'. $total .'</div>
                <div class="total_item d-none">'. $total_item .'</div>',
            'uraian' => '',
            'jumlah'      => '',
            'harga_beli'  => '',
            'subtotal'    => '',
            'aksi'        => '',
        ];

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['aksi', 'code', 'jumlah'])
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
        $data = $request->all();
        PengeluaranDetail::create($data);

        return redirect()->route('pengeluaran_detail.index')
         ->with('success', 'Pengeluaran berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pengeluaranDetail = PengeluaranDetail::find($id);

        return response()->json($pengeluaranDetail);
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
        $item = PengeluaranDetail::findOrFail($id);

        $item->update($data);

         return redirect()->route('pengeluaran_detail.index')
          ->with('success', 'Data pengeluaran detail berhasil diedit');
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
        $detail = PengeluaranDetail::find($id);
        $detail->jumlah = $request->jumlah;
        $detail->subtotal = $detail->harga_beli * $request->jumlah;
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
        $detail = PengeluaranDetail::find($id);
        $detail->delete();

        return response(null, 204);
    }

    public function delete($id)
    {
        $detail = PengeluaranDetail::find($id);
        $detail->delete();

        return redirect()->route('pengeluaran.pengeluaranAll');
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

    public function pengeluaranAll()
    {
        $pengeluaranAll = PengeluaranDetail::orderBy('id_pengeluaran', 'desc')->get(); 
        $pengeluarans = Pengeluaran::orderBy('id_pengeluaran', 'desc')->get(); 
        
        return view('pages.admin.pengeluaran-detail.pengeluaranAll', [
            'pengeluaranAll' => $pengeluaranAll,
            'pengeluarans' => $pengeluarans,
        ]);
    }

    public function detailAset($id)
    {
        $pengeluaranDetail = PengeluaranDetail::find($id);

        return response()->json($pengeluaranDetail);
    }

    public function aset(Request $request)
    {
        $data = $request->all();

        Aset::create($data);
        
        return redirect()->route('pengeluaran.pengeluaranAll');
    }
}
