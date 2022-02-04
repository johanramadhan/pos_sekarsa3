<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Member;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = Member::all(); 
        $tanggal = Carbon::now()->format('dmY');
        $cek = Member::count();
        if ($cek == 0) {
            $urut = 100001;
            $code = 'Memb-' . $tanggal . $urut;
        } else {
            $ambil = Member::all()->last();
            $urut = (int)substr($ambil->code, -6) + 1;  
            $code = 'Memb-' . $tanggal . $urut;      
        } 

        return view('pages.kasir.member.index', [
            'members' => $members,
            'code' => $code,
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

        $data['slug'] = Str::slug($request->name);

        Member::create($data);

        return redirect()->route('memberkasir.index')
         ->with('success', 'Data member berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function detail($id)
    {

    }
    
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
        //
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
        //
    }
}
