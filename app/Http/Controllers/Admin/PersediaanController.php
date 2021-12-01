<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pembelian;
use App\Persediaan;
use App\PersediaanGallery;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
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
        $persediaans = Persediaan::with(['category'])->orderBy('name_persediaan', 'asc')->get();
        $tanggal = Carbon::now()->format('dmY');
        $cek = Persediaan::count();
        if ($cek == 0) {
            $urut = 100001;
            $code = 'PSD-' . $tanggal . $urut;
        } else {
            $ambil = Persediaan::all()->last();
            $urut = (int)substr($ambil->code, -6) + 1;  
            $code = 'PSD-' . $tanggal . $urut;      
        }

        return view('pages.admin.persediaan.index',[
            'categories' => $categories,
            'persediaans' => $persediaans,
            'tanggal' => $tanggal,
            'code' => $code,
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

        Persediaan::create($data);

        return redirect()->route('persediaan.index')
          ->with('success', 'Data persediaan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
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
    public function show($id)
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
        
        $data = $request->all();
        $item = Persediaan::findOrFail($id);

        $item->update($data);

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
        $persediaanGallery      = PersediaanGallery::where('persediaans_id', $persediaan->id_persediaan)->get();

        foreach ($persediaanGallery as $item) {
            
            $item->delete();
        }

        $persediaan->delete();

        return redirect()->route('persediaan.index');
    }
}
