<?php

namespace App\Http\Controllers\Ppbj;

use App\User;
use App\Proposal;
use App\ProposalGallery;
use App\Category;
use PDF;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use App\Http\Requests\ProposalRequest;
use Illuminate\Support\Str;

class ProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proposals = Proposal::with(['galleries','user', 'category'])->get();
        $aset = Proposal::sum('total_price');
        $users = User::all();  
        $categories = Category::all();  
        $code = 'SISPRAS-' . mt_rand(0000,999999);

        return view('pages.ppbj.proposal.index', [
            'proposals' => $proposals,
            'aset' => $aset,
            'users' => $users,
            'categories' => $categories,
            'code' => $code
        ]);
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
        $item = Proposal::with(['galleries','user','category'])->findOrFail($id);

        return view('pages.ppbj.proposal.detail', [
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
        $item = Proposal::with(['galleries','user','category'])->findOrFail($id);

        return view('pages.ppbj.proposal.edit', [
          'item' => $item,
          'categories' => $categories,
          'users' => $users,
        ]);
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

        $item = Proposal::findOrFail($id);

        $data['slug'] = Str::slug($request->name);

        $item->update($data);

        return redirect()->route('proposal.index')
            ->with('update', 'Data Pengajuan berhasil diedit');
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
