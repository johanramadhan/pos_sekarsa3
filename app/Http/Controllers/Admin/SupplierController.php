<?php

namespace App\Http\Controllers\Admin;

use App\Supplier;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\SupplierRequest;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::all();  

        return view('pages.admin.supplier.index', [
            'suppliers' => $suppliers
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
    public function store(SupplierRequest $request)
    {
        $data = $request->all();

        $data['slug'] = Str::slug($request->name);

        Supplier::create($data);

        return redirect()->route('supplier.index')
         ->with('success', 'Data supplier berhasil ditambahkan');
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
        $item = Supplier::findOrFail($id);

        return view('pages.admin.supplier.edit', [
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
            'name' => 'required'
        ]);
        $data = $request->all();

        $data['slug'] = Str::slug($request->name);

        $item = Supplier::findOrFail($id);

        $item->update($data);

        return redirect()->route('supplier.index')
            ->with('update', 'Data supplier berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Supplier::findOrFail($id);
        $item->delete();

        return redirect()->route('supplier.index');
    }
}
