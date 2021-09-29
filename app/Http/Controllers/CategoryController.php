<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Produk;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::take(6)->get();
        $products = Produk::with(['galleries'])->paginate(32);

        return view('pages.category',[
            'categories' => $categories,
            'products' => $products
        ]);
    }

    public function detail(Request $request, $slug)
    {
        $categories = Category::take(6)->get();
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Produk::with(['galleries'])->where('categories_id', $category->id)->paginate(32);

        return view('pages.category',[
            'categories' => $categories,
            'products' => $products
        ]);
    }
}
