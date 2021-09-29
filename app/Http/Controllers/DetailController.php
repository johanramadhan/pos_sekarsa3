<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Produk;
use App\Category;
use App\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{
    public function index(Request $request, $slug)
    {
        
        $item = Produk::with(['galleries','user','category'])
                ->where('slug', $slug)
                ->firstOrFail();
        
        return view('pages.detail',[
            'item' => $item,
        ]);
    }

    public function add(Request $request, $id)
    {
        $data = [
            'products_id' => $id,
            'users_id' => Auth::user()->id,
        ];

        Cart::create($data);

        return redirect()->route('cart');
    }

    public function pengajuan(Request $request, $slug)
    {
        
        $item = Proposal::with(['galleries','user','category'])
                ->where('slug', $slug)
                ->firstOrFail();
        
        return view('pages.pengajuan-detail',[
            'item' => $item,
        ]);
    }
}
