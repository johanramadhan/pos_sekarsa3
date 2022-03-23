<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $satuans = Satuan::orderBy('name', 'Asc')->get();  

        return view('pages.admin.satuan.index', [
            'satuans' => $satuans
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

        Satuan::create($data);

        return redirect()->route('satuan.index')
         ->with('success', 'Data satuan berhasil ditambahkan');
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
        $item = Satuan::findOrFail($id);

        return view('pages.admin.satuan.edit', [
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
        $data = $request->all();

        $data['slug'] = Str::slug($request->name);

        $item = Satuan::findOrFail($id);

        $item->update($data);

        return redirect()->route('satuan.index')
            ->with('update', 'Data satuan berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Satuan::findOrFail($id);
        $item->delete();

        return redirect()->route('satuan.index');
    }
}
