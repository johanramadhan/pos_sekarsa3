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
        $products = Product::with(['galleries','user', 'category'])->get();
        $aset = Product::sum('total_price');
        $users = User::all();  
        $categories = Category::all();  
        $code = 'SISPRAS-' . mt_rand(0000,999999);

        return view('pages.admin.product.index', [
            'products' => $products,
            'aset' => $aset,
            'users' => $users,
            'categories' => $categories,
            'code' => $code
        ]);
    }

    public function exportPdfTable()
    {
      $products = Product::all();
      $total = Product::sum('total_price');
      $customPaper = array(0,0,615,940);
      $pdf = PDF::loadView('pages.admin.exports.pdf',[
        'products' => $products, 
        'total' => $total
      
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
        $product = Product::create($data);

        $gallery = [
            'products_id' => $product->id,
            'photos' => $request->file('photos')->store('assets/product','public')
        ];

        ProductGallery::create($gallery);

        return redirect()->route('aset.index')
          ->with('success', 'Data aset berhasil ditambahkan');
    
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
        $item = Product::with(['galleries','user','category'])->findOrFail($id);

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
        $users = User::all();  
        $item = Product::with(['galleries','user','category'])->findOrFail($id);

        return view('pages.admin.product.edit', [
          'item' => $item,
          'categories' => $categories,
          'users' => $users,
        ]);
    }

    public function uploadGallery(Request $request)
    {
        $data = $request->all();

        $data['photos'] = $request->file('photos')->store('assets/product','public');

        ProductGallery::create($data);

        return redirect()->route('aset.edit', $request->products_id)
         ->with('success', 'Gambar berhasil ditambahkan');
    }

    public function deleteGallery(Request $request, $id)
    {
        $item = ProductGallery::findOrFail($id);
        $item->delete();

        return redirect()->route('aset.edit', $item->products_id);
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

        return redirect()->route('aset.index')
            ->with('update', 'Data aset berhasil diedit');
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

        return redirect()->route('aset.index');
    }
}
