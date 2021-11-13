<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Pengeluaran;
use App\PengeluaranDetail;
use App\Setting;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $pengeluarans = Pengeluaran::orderBy('id_pengeluaran', 'desc')->get();  

        return view('pages.admin.pengeluaran.index', [
            'users' => $users,
            'pengeluarans' => $pengeluarans,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function data()
    {
        $pengeluaran = Pengeluaran::orderBy('id_pengeluaran', 'desc')->get();

        return datatables()
            ->of($pengeluaran)
            ->addIndexColumn()
            ->addColumn('total_item', function ($pengeluaran) {
                return format_uang($pengeluaran->total_item);
            })
            ->addColumn('total_harga', function ($pengeluaran) {
                return 'Rp'. format_uang($pengeluaran->total_harga);
            })
            ->addColumn('bayar', function ($pengeluaran) {
                return 'Rp'. format_uang($pengeluaran->bayar);
            })
            ->addColumn('tanggal', function ($pengeluaran) {
                return tanggal_indonesia($pengeluaran->created_at, false);
            })
            ->editColumn('diskon', function ($pengeluaran) {
                return $pengeluaran->diskon . '%';
            })
            ->addColumn('kasir', function ($pengeluaran) {
                return $pengeluaran->user->name;
            })
            ->addColumn('aksi', function ($pengeluaran) {
                return '
                <div class="btn-group">
                    <button onclick="showDetail(`'. route('pengeluaran.show', $pengeluaran->id_pengeluaran) .'`)" class="btn btn-xs btn-info m-1"><i class="fa fa-eye"></i></button>
                    <button onclick="showDetail(`'. route('pengeluaran.show', $pengeluaran->id_pengeluaran) .'`)" class="btn btn-xs btn-warning m-1"><i class="fa fa-edit"></i></button>
                    <button onclick="deleteData(`'. route('pengeluaran.destroy', $pengeluaran->id_pengeluaran) .'`)" class="btn btn-xs btn-danger m-1"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create(Request $request)
    {
        $tanggal = Carbon::now()->format('dmY');
        $cek = Pengeluaran::count();
        if ($cek == 0) {
            $urut = 100001;
            $code = 'Kel-' . $tanggal . $urut;
        } else {
            $ambil = Pengeluaran::all()->last();
            $urut = (int)substr($ambil->code, -6) + 1;  
            $code = 'Kel-' . $tanggal . $urut;      
        }

        $pengeluaran = new Pengeluaran();
        $pengeluaran->code        = $code;
        $pengeluaran->users_id    =  auth()->id();
        $pengeluaran->tgl_pengeluaran  =  $request->tgl_pengeluaran;
        $pengeluaran->keterangan  =  $request->keterangan;
        $pengeluaran->total_item  = 0;
        $pengeluaran->total_harga = 0;
        $pengeluaran->diskon      = 0;
        $pengeluaran->bayar       = 0;
        $pengeluaran->status      = "Pending";
        $pengeluaran->save();

        session(['id_pengeluaran' => $pengeluaran->id_pengeluaran]);

        return redirect()->route('pengeluaran_detail.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pengeluaran = Pengeluaran::findOrFail($request->id_pengeluaran);
        $pengeluaran->users_id    =  $request->users_id;
        $pengeluaran->total_item = $request->total_item;
        $pengeluaran->total_harga = $request->total;
        $pengeluaran->diskon = $request->diskon;
        $pengeluaran->bayar = $request->bayar;
        $pengeluaran->status = 'Success';
        $pengeluaran->update();

        return redirect()->route('pengeluaran.index')
         ->with('success', 'Data pengeluaran berhasil ditambahkan');
    }

    public function detail($id)
    {
        $detail = PengeluaranDetail::where('id_pengeluaran', $id)->get();

        return datatables()
            ->of($detail)
            ->addIndexColumn()
            ->addColumn('code', function ($detail) {
                return '<span class="label label-success">'. $detail->code .'</span>';
            })
            ->addColumn('tanggal', function ($detail) {
                return tanggal_indonesia($detail->created_at, false);
            })
            ->addColumn('uraian', function ($detail) {
                return $detail->uraian;
            })
            ->addColumn('harga_beli', function ($detail) {
                return 'Rp'. format_uang($detail->harga_beli);
            })
            ->addColumn('jumlah', function ($detail) {
                return format_uang($detail->jumlah);
            })
            ->addColumn('subtotal', function ($detail) {
                return 'Rp'. format_uang($detail->subtotal);
            })
            ->rawColumns(['code'])
            ->make(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pengeluaran = Pengeluaran::find($id);

        return response()->json($pengeluaran);
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
        $item = Pengeluaran::findOrFail($id);

        $item->update($data);

         return redirect()->route('pengeluaran.index')
          ->with('success', 'Data pengeluaran berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $pengeluaran = Pengeluaran::find($id);
        $detail      = PengeluaranDetail::where('id_pengeluaran', $pengeluaran->id_pengeluaran)->get();
        foreach ($detail as $item) {
            $item->delete();
        }

        $pengeluaran->delete();

        return redirect()->route('pengeluaran.index');
    }

    public function print($id)
    {
        $setting = Setting::first();
        $pengeluaran = Pengeluaran::find($id);
            if (! $pengeluaran) {
                abort(404);
            }
        $detail = PengeluaranDetail::where('id_pengeluaran', $id)
            ->get(); 
        $customPaper = array(0,0,615,936);
        $pdf = PDF::loadView('pages.admin.pengeluaran.nota_besar',[
            'setting' => $setting,
            'pengeluaran' => $pengeluaran,
            'detail' => $detail,
            
        ])->setPaper($customPaper, 'potrait')->setWarnings(false);

        // ->setPaper('f4', 'portrait')

        return $pdf->stream('Penjualan-'. date('Y-m-d-his') .'.pdf');
    }
}
