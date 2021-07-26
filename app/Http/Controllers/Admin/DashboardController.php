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

    public function edit(Request $request, $id)
    {
        $item = Countdown::findOrFail($id);
        $user = User::count();
        $product = Product::count();
        $proposal = Proposal::count();
        $transaction = Product::sum('price');
        $proposals = Proposal::sum('total_price');
        $countdown = Countdown::first();
        $countdowns = Countdown::all();

        return view('pages.admin.countdown-edit', [
            'item' => $item,
            'user'=> $user,
            'product'=> $product,
            'proposal'=> $proposal,
            'proposals'=> $proposals,
            'transaction'=> $transaction,
            'countdown'=> $countdown,
            'countdowns'=> $countdowns,
        ]);
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'date' => 'required',
        ]);
        $data = $request->all();

        $item = Countdown::findOrFail($id);

        $item->update($data);

        return redirect()->route('dashboard-admin')
            ->with('update', 'Data countdown berhasil diubah');
    }
}
