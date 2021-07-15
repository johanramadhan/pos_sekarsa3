<?php

namespace App\Exports;

use App\Product;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Database\Eloquent\Model;

class ProductExport extends Model
{
    public function view(): View
    {
        $products = Product::with(['user', 'category', 'galleries'])->get();
        $pengajuan = Product::sum('total_price');

        return view('pages.admin.exports.product', [
            'products' => $products,
            'pengajuan' => $pengajuan,
        ]);
    }
}
