<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Kaskecil;
use App\KaskecilDetail;
use App\Setting;
use App\User;
use Illuminate\Http\Request;
use PDF;

class KaskecilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::orderBy('name')->get();
        $tanggalAkhir = date('Y-m-d');
        $kaskecils = Kaskecil::whereDate('created_at', $tanggalAkhir)->get();

        return view('pages.kasir.kaskecil.index', [
            'user' => $user,
            'kaskecils' => $kaskecils,
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

    public function detail($id)
    {
        $detail = KaskecilDetail::where('id_kaskecil', $id)->get();

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
            ->addColumn('jenis_uang', function ($detail) {
                return 'Rp'. format_uang($detail->jenis_uang);
            })
            ->addColumn('jumlah', function ($detail) {
                return format_uang($detail->jumlah);
            })
            ->addColumn('satuan', function ($detail) {
                return $detail->satuan;
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
        $kaskecil = Kaskecil::find($id);

        return response()->json($kaskecil);
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
        $setting = Setting::first();
        $kaskecil = Kaskecil::find($id);
            if (! $kaskecil) {
                abort(404);
            }
        $detail = KaskecilDetail::where('id_kaskecil', $id)
            ->get(); 
        $customPaper = array(0,0,615,936);
        $pdf = PDF::loadView('pages.admin.kaskecil.nota_besar',[
            'setting' => $setting,
            'kaskecil' => $kaskecil,
            'detail' => $detail,
            
        ])->setPaper($customPaper, 'potrait')->setWarnings(false);

        // ->setPaper('f4', 'portrait')

        return $pdf->stream('Kas Kecil-'. date('Y-m-d-his') .'.pdf');
    }
}
