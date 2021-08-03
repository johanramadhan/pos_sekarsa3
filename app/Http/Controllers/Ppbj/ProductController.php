<?php

namespace App\Http\Controllers\Ppbj;

use App\User;
use App\Product;
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

        return view('pages.ppbj.product.index', [
            'products' => $products,
            'aset' => $aset,
            'users' => $users,
            'categories' => $categories,
            'code' => $code
        ]);
    }

    public function exportPdfTables()
    {
      $products = Product::all();
      $total = Product::sum('total_price');
      $customPaper = array(0,0,615,940);
      $pdf = PDF::loadView('pages.ppbj.exports.pdf',[
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
    public function store(Request $request)
    {
        //
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

        return view('pages.ppbj.product.detail', [
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
}
