<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Pengeluaran;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pengeluarans = Pengeluaran::all();  

        return view('pages.admin.pengeluaran.index', [
            'pengeluarans' => $pengeluarans
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

        Pengeluaran::create($data);

        return redirect()->route('pengeluaran.index')
         ->with('success', 'Data pengeluaran berhasil ditambahkan');
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
         $item = Pengeluaran::findOrFail($id);

        return view('pages.admin.pengeluaran.edit', [
          'item' => $item
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
        $this->validate($request, [
            'description' => 'required',
            'nominal' => 'required',
        ]);
        $data = $request->all();

        $item = Pengeluaran::findOrFail($id);

        $item->update($data);

        return redirect()->route('pengeluaran.index')
            ->with('update', 'Data pengeluaran berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Pengeluaran::findOrFail($id);
        $item->delete();

        return redirect()->route('pengeluaran.index');
    }
}
