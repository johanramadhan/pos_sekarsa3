<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Product;
use App\ProductGallery;
use App\Category;
use PDF;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use App\Http\Requests\ProductRequest;
use App\Produk;
use App\Satuan;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Produk::with(['galleries','user', 'category'])->get(); 
        $categories = Category::all();
        $satuans = Satuan::all();
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

        return view('pages.admin.product.index', [
            'products' => $products,
            'categories' => $categories,
            'satuans' => $satuans,
            'tanggal' => $tanggal,
            'code' => $code
        ]);
    }

    public function exportPdfTable()
    {
      $products = Produk::all();
      $customPaper = array(0,0,940,615);
      $pdf = PDF::loadView('pages.admin.exports.pdf',[
        'products' => $products, 
      
      ])->setPaper($customPaper, 'landscape')
      ->setWarnings(false);

      // ->setPaper('f4', 'portrait')
      return $pdf->stream();
      
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
    public function store(ProductRequest $request)
    {
        $data = $request->all();

        $data['slug'] = Str::slug($request->name);
        $product = Produk::create($data);

        $gallery = [
            'products_id' => $product->id,
            'photos' => $request->file('photos')->store('assets/product','public')
        ];

        ProductGallery::create($gallery);

        return redirect()->route('products.index')
          ->with('success', 'Data Product berhasil ditambahkan');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categories = Category::all();
        $users = User::all(); 
        $item = Produk::with(['galleries','user','category'])->findOrFail($id);

        return view('pages.admin.product.detail', [
          'item' => $item,
          'users' => $users,
          'categories' => $categories,
        ]);
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
        $satuans = Satuan::all();
        $item = Produk::with(['galleries', 'category'])->findOrFail($id);

        return view('pages.admin.product.edit', [
          'item' => $item,
          'categories' => $categories,
          'satuans' => $satuans,
          
        ]);
    }

    public function uploadGallery(Request $request)
    {
        $data = $request->all();

        $data['photos'] = $request->file('photos')->store('assets/product','public');

        ProductGallery::create($data);

        return redirect()->route('products.edit', $request->products_id)
         ->with('success', 'Gambar berhasil ditambahkan');
    }

    public function deleteGallery(Request $request, $id)
    {
        $item = ProductGallery::findOrFail($id);
        $item->delete();

        return redirect()->route('products.edit', $item->products_id);
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

        $item = Product::findOrFail($id);

        $data['slug'] = Str::slug($request->name);

        $item->update($data);

        return redirect()->route('products.index')
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
        $item = Product::findOrFail($id);
        $item->delete();

        return redirect()->route('products.index');
    }

    public function deleteSelected(Request $request)
    {
        foreach ($request->id as $id) {
            $produk = Product::find($id);
            $produk->delete();
        }

        return response(null, 204);
    }
}
