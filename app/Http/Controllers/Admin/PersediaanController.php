<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Persediaan;
use App\PersediaanGallery;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PersediaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $persediaans = Persediaan::with(['category'])->get();
        $tanggal = Carbon::now()->format('dmY');
        $cek = Persediaan::count();
        if ($cek == 0) {
            $urut = 100001;
            $code = 'PSD-' . $tanggal . $urut;
        } else {
            $ambil = Persediaan::all()->last();
            $urut = (int)substr($ambil->code, -6) + 1;  
            $code = 'SKS-' . $tanggal . $urut;      
        }

        return view('pages.admin.persediaan.index',[
            'categories' => $categories,
            'persediaans' => $persediaans,
            'tanggal' => $tanggal,
            'code' => $code
        ]);
    }

    /**e
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

        $persediaan = Persediaan::create($data);

        $gallery = [
            'persediaans_id' => $persediaan->id_persediaan,
            'photos' => $request->file('photos')->store('assets/persediaan','public')
        ];

        PersediaanGallery::create($gallery);

        return redirect()->route('persediaan.index')
          ->with('success', 'Data persediaan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detail = Persediaan::with(['galleries', 'category'])->where('id_persediaan', $id)->get(); 

        return datatables()
        ->of($detail)
        ->addIndexColumn()   
            ->addColumn('stok', function ($detail) {
                return $detail->stok;
            })    
            ->addColumn('satuan', function ($detail) {
                return $detail->satuan;
            })    
            ->addColumn('berat', function ($detail) {
                return $detail->berat;
            })    
            ->addColumn('totalBerat', function ($detail) {
                return $detail->total_berat;
            })    
            ->addColumn('satuan_berat', function ($detail) {
                return $detail->satuan_berat;
            })    
            ->addColumn('harga_beli', function ($detail) {
                return 'Rp'. format_uang($detail->harga_beli);
            })               
            ->editColumn('diskon', function ($detail) {
                return $detail->diskon . '%';
            })    
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $persediaan = Persediaan::find($id);

        return response()->json($persediaan);
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
        $member = Persediaan::find($id)->update($request->all());

         return redirect()->route('persediaan.index')
          ->with('success', 'Data persediaan berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $persediaan = Persediaan::find($id);

        $persediaan->delete();

        return redirect()->route('persediaan.index');
    }
}
