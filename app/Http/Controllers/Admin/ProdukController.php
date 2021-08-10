<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Produk;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $products = Produk::with(['category'])->get();
        $tanggal = Carbon::now()->format('dmY');
        $cek = Produk::count();
        if ($cek == 0) {
            $urut = 100001;
            $code = 'SKS-' . $tanggal . $urut;
        } else {
            $ambil = Produk::all()->last();
            $urut = (int)substr($ambil->code, -6) + 1;  
            $code = 'SKS-' . $tanggal . $urut;      
        }

        return view('pages.admin.produk.index',[
            'categories' => $categories,
            'products' => $products,
            'tanggal' => $tanggal,
            'code' => $code
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
        $data = $request->all();

        $product = Produk::create($data);

        return redirect()->route('produk.index')
          ->with('success', 'Data Produk berhasil ditambahkan');
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
        $categories = Category::all();
        $item = Produk::with(['category'])->findOrFail($id);

        return view('pages.admin.produk.edit', [
          'item' => $item,
          'categories' => $categories,
        ]);
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

        $item = Produk::findOrFail($id);

        $data['slug'] = Str::slug($request->name);

        $item->update($data);

        return redirect()->route('produk.index')
            ->with('update', 'Data produk berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Produk::findOrFail($id);
        $item->delete();

        return redirect()->route('produk.index');
    }
}
