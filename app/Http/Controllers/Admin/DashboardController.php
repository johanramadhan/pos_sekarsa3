<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Product;
use App\Proposal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::count();
        $product = Product::count();
        $proposal = Proposal::count();
        $transaction = Product::sum('price');
        $proposals = Proposal::sum('total_price');
        return view('pages.admin.dashboard', [
            'user'=> $user,
            'product'=> $product,
            'proposal'=> $proposal,
            'proposals'=> $proposals,
            'transaction'=> $transaction,
        ]);
    }
}
