<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all(); 
        $tanggal = Carbon::now()->format('dmY');
        $cek = Customer::count();
        if ($cek == 0) {
            $urut = 100001;
            $code = 'Memb-' . $tanggal . $urut;
        } else {
            $ambil = Customer::all()->last();
            $urut = (int)substr($ambil->code, -6) + 1;  
            $code = 'Memb-' . $tanggal . $urut;      
        } 

        return view('pages.admin.customer.index', [
            'customers' => $customers,
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

        Customer::create($data);

        return redirect()->route('customer.index')
         ->with('success', 'Data customer berhasil ditambahkan');
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
         $item = Customer::findOrFail($id);

        return view('pages.admin.customer.edit', [
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

        $item = Customer::findOrFail($id);

        $item->update($data);

        return redirect()->route('customer.index')
            ->with('update', 'Data customer berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Customer::findOrFail($id);
        $item->delete();

        return redirect()->route('customer.index');
    }
}
