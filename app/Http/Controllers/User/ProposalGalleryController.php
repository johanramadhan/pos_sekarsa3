<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ProposalGallery;
use App\Proposal;

class ProposalGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = ProposalGallery::all();
        $proposals = Proposal::all();
         return view('pages.user.proposal_gallery.index', [
            'items' => $items,
            'proposals' => $proposals,
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
        $data = $request->all();
        $data['photos'] = $request->file('photos')->store('assets/proposal','public');

        ProposalGallery::create($data);

        return redirect()->route('proposal-gallery.index')->with('success', 'Foto berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = ProposalGallery::findOrFail($id);
        $proposals = Proposal::all();

         return view('pages.user.proposal_gallery.edit', [
          'item' => $item,
          'proposals' => $proposals
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
        $item = ProposalGallery::findOrFail($id);
        $item->delete();

        return redirect()->route('proposal-gallery.index');
    }
}
