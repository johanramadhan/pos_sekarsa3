<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Kaskecil;
use App\KaskecilDetail;
use App\Setting;
use App\User;
use Carbon\Carbon;
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
        $kaskecils = Kaskecil::orderBy('id_kaskecil', 'desc')->get();

        return view('pages.admin.kaskecil.index', [
            'user' => $user,
            'kaskecils' => $kaskecils,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $tanggal = Carbon::now()->format('dmY');
        $cek = Kaskecil::count();
        if ($cek == 0) {
            $urut = 100001;
            $code = 'Kas-' . $tanggal . $urut;
        } else {
            $ambil = Kaskecil::all()->last();
            $urut = (int)substr($ambil->code, -6) + 1;  
            $code = 'Kas-' . $tanggal . $urut;      
        }

        $kaskecil = new Kaskecil();
        $kaskecil->code        = $code;
        $kaskecil->uraian      = $request->uraian;;
        $kaskecil->debit       = 0;
        $kaskecil->kredit      = 0;
        $kaskecil->save();

        session(['id_kaskecil' => $kaskecil->id_kaskecil]);

        return redirect()->route('kaskecil_detail.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kaskecil = Kaskecil::findOrFail($request->id_kaskecil);
        $kaskecil->kredit = $request->bayar;
        $kaskecil->update();

        return redirect()->route('kasKecil.index')
         ->with('success', 'Data Kas Kecil berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
     * Show the form for editing the specified resource.
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $item = Kaskecil::findOrFail($id);

        $item->update($data);

         return redirect()->route('kasKecil.index')
          ->with('success', 'Data kas kecil berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kaskecil = Kaskecil::find($id);
        $detail      = KaskecilDetail::where('id_kaskecil', $kaskecil->id_kaskecil)->get();
        foreach ($detail as $item) {
            $item->delete();
        }

        $kaskecil->delete();

        return redirect()->route('kasKecil.index');
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
