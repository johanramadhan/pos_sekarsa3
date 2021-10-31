<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Kaskecil;
use App\KaskecilDetail;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KaskecilDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_kaskecil = session('id_kaskecil');
        $kaskecils = Kaskecil::all(); 
        $user = User::orderBy('name')->get();
        $codeKaskecil = Kaskecil::find($id_kaskecil)->code ?? 0;
        $diskon = Kaskecil::find($id_kaskecil)->diskon ?? 0;

        $tanggal = Carbon::now()->format('dmY');
        $cek = KaskecilDetail::count();
        if ($cek == 0) {
            $urut = 100001;
            $code = 'Rp-' . $tanggal . $urut;
        } else {
            $ambil = KaskecilDetail::all()->last();
            $urut = (int)substr($ambil->code, -6) + 1;  
            $code = 'Rp-' . $tanggal . $urut;      
        }

        return view('pages.admin.kaskecil-detail.index', [
            'kaskecils' => $kaskecils,            
            'user' => $user,            
            'id_kaskecil' => $id_kaskecil,            
            'codeKaskecil' => $codeKaskecil,           
            'diskon' => $diskon,            
            'code' => $code,          
        ]);
    }

    public function data($id)
    {
        $detail = KaskecilDetail::where('id_kaskecil', $id)
            ->get();
        $data = array();
        $total = 0;
        $total_item = 0;

        foreach($detail as $item) {
            $row = array();
            $row['code'] = $item['code'];
            $row['uraian'] = $item ['uraian'];
            $row['jumlah'] = '<input type="number" class="form-control input-sm quantity" data-id="'. $item->id_kaskecil_detail .'" value="'. $item->jumlah .'">';
            $row['jenis_uang'] ='Rp'.format_uang($item->jenis_uang);
            $row['subtotal'] = 'Rp'.format_uang($item->subtotal);
            $row['aksi'] = '<button onclick="deleteData(`'. route('kaskecil_detail.destroy', $item->id_kaskecil_detail) .'`)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>';

            $data[] = $row;
            $total += $item->jenis_uang * $item->jumlah;
            $total_item += $item->jumlah;
        }
        $data[] = [
            'code' => '
                <div class="total d-none">'. $total .'</div>
                <div class="total_item d-none">'. $total_item .'</div>',
            'uraian' => '',
            'jenis_uang' => '',
            'jumlah'      => '',
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
        KaskecilDetail::create($data);

        return redirect()->route('kaskecil_detail.index')
         ->with('success', 'Kas Kecil berhasil ditambahkan');
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
        $detail = KaskecilDetail::find($id);
        $detail->jumlah = $request->jumlah;
        $detail->subtotal = $detail->jenis_uang * $request->jumlah;
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
        $detail = KaskecilDetail::find($id);
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
}
