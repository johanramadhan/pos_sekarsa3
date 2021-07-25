<?php

namespace App\Http\Controllers\User;

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
        $asets = Product::with(['user','galleries'])
                    ->where('users_id', Auth::user()->id);

        $asetTotal = $asets->get()->reduce(function ($carry, $item){
            return $carry + $item->total_price;
        });

        $proposals = Proposal::with(['user','galleries'])
                    ->where('users_id', Auth::user()->id);

        $proposalTotal = $proposals->get()->reduce(function ($carry, $item){
            return $carry + $item->total_price;
        });
        
        $proposal = Proposal::with(['galleries','category'])
                    ->where('users_id', Auth::user()->id)
                    ->latest()->get();

        return view('pages.user.dashboard', [
            'asets' => $asets->count(),
            'asetTotal' => $asetTotal,
            'proposals' => $proposals->count(),
            'proposalTotal' => $proposalTotal,
            'proposal' => $proposal,
        ]);
    }
}
