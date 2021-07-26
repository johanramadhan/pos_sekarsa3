<?php

namespace App\Http\Controllers\Admin;

use App\Countdown;
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
        $countdown = Countdown::first();
        $countdowns = Countdown::all();
        return view('pages.admin.dashboard', [
            'user'=> $user,
            'product'=> $product,
            'proposal'=> $proposal,
            'proposals'=> $proposals,
            'transaction'=> $transaction,
            'countdown'=> $countdown,
            'countdowns'=> $countdowns,
        ]);
    }

    public function add(Request $request)
    {
        $data = $request->all();

        Countdown::create($data);

        return redirect()->route('dashboard-admin');
    }

    public function edit($id)
    {
        $item = Countdown::findOrFail($id);

        return view('pages.admin.countdown-edit', [
            'item' => $item
        ]);
    }
}
