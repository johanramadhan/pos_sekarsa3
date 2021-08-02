<?php

namespace App\Http\Controllers\Ppbj;

use App\User;
use App\Product;
use App\Proposal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::count();
        $product = Product::count();
        $proposal = Proposal::count();
        $transaction = Product::sum('price');
        $proposals = Proposal::sum('total_price');
        return view('pages.ppbj.dashboard', [
            'user'=> $user,
            'product'=> $product,
            'proposal'=> $proposal,
            'proposals'=> $proposals,
            'transaction'=> $transaction,
        ]);
    }
}
