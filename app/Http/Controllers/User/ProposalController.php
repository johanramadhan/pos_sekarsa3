<?php

namespace App\Http\Controllers\User;

use App\User;
use App\Category;
use App\Proposal;
use App\ProposalGallery;
use PDF;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proposals = Proposal::with(['galleries','category','user'])
                    ->where('users_id', Auth::user()->id)
                    ->latest()->get();
        $categories = Category::all(); 
        $code = 'SISPRAS-' . mt_rand(0000,999999);
        $proposal = Proposal::with(['user','galleries'])
                          ->where('users_id', Auth::user()->id);
        $total = $proposal->get()->reduce(function ($carry, $item){
                return $carry + $item->total_price;
        });

        return view('pages.user.proposal.index',[
          'proposals' => $proposals,
          'categories' => $categories,
          'code' => $code,
          'total' => $total,
          'proposal' => $proposal->sum('total_price'),
        ]);
    }

    public function pdfTable()
    {
      $proposals = Proposal::all()->where('users_id', Auth::user()->id)->sortBy('categories_id');
      $judul = Proposal::with(['user','galleries'])
                        ->where('users_id', Auth::user()->id)->first();
      
        $proposal = Proposal::with(['user','galleries'])
                          ->where('users_id', Auth::user()->id);
        $total = $proposal->get()->reduce(function ($carry, $item){
                return $carry + $item->total_price;
        });

      $customPaper = array(0,0,615,940);
      $pdf = PDF::loadView('pages.user.exports.proposalpdf',[
        'proposals' => $proposals, 
        'proposal' => $proposal,
        'total' => $total,
        'judul' => $judul,
      
      ])->setPaper($customPaper, 'landscape')
      ->setWarnings(false);

      // ->setPaper('f4', 'portrait')
      return $pdf->stream();
      
    }

    public function exportPdf()
    {
      $proposals = Proposal::all()->where('users_id', Auth::user()->id)->sortBy('categories_id');
      $judul = Proposal::with(['user','galleries'])
                        ->where('users_id', Auth::user()->id)->first();
      
        $proposal = Proposal::with(['user','galleries'])
                            ->where('users_id', Auth::user()->id);
        $total = $proposal->get()->reduce(function ($carry, $item){
                return $carry + $item->total_price;
        });
      $customPaper = array(0,0,615,936);
      $pdf = PDF::loadView('pages.user.exports.proposalexport',[
        'proposals' => $proposals,
        'proposal' => $proposal,
        'total' => $total,
        'judul' => $judul,
        
      ])->setPaper($customPaper, 'portrait')->setWarnings(false);

      // ->setPaper('f4', 'portrait')

      return $pdf->stream();
      
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

        $data['slug'] = Str::slug($request->name);
        $proposal = Proposal::create($data);

        $gallery = [
            'proposals_id' => $proposal->id,
            'photos' => $request->file('photos')->store('assets/proposal','public')
        ];

        ProposalGallery::create($gallery);

        return redirect()->route('pengajuans.index')
          ->with('success', 'Data pengajuan berhasil ditambahkan');
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

        return view('pages.user.proposal.detail', [
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

        return view('pages.user.proposal.edit', [
          'item' => $item,
          'categories' => $categories,
          'users' => $users,
        ]);
    }

    public function uploadGallery(Request $request)
    {
        $data = $request->all();

        $data['photos'] = $request->file('photos')->store('assets/proposal','public');

        ProposalGallery::create($data);

        return redirect()->route('pengajuans.edit', $request->proposals_id)
         ->with('success', 'Gambar berhasil ditambahkan');
    }

    public function deleteGallery(Request $request, $id)
    {
        $item = ProposalGallery::findOrFail($id);
        $item->delete();

        return redirect()->route('pengajuans.edit', $item->proposals_id);
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

        return redirect()->route('pengajuans.index')
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
        $item = Proposal::findOrFail($id);
        $item->delete();


        return redirect()->route('pengajuans.index');
    }
}
