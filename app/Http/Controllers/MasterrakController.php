<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Masterrak;

class MasterrakController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('search')){
            $masterrak = Masterrak::where('lantai', 'LIKE', '%' .$request->search.'%')->paginate(10);
        }else{
            $masterrak = Masterrak::paginate(10);
        }
        return view('masterrak.index',[
            'masterrak' => $masterrak
        ]);
    }


    public function create()
    {
        return view('masterrak.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        Masterrak::create($data);

        return redirect()->route('masterrak.index')->with('success','Data Telah Ditambahkan');
    }


    public function show($id)
    {

    }


    public function edit(Masterrak $masterrak)
    {
        return view('masterrak.edit', [
            'item' => $masterrak
        ]);
    }


    public function update(Request $request, Masterrak $masterrak)
    {
        $data = $request->all();

        $masterrak->update($data);

        //dd($data);

        return redirect()->route('masterrak.index')->with('success', 'Data Telah diupdate');

    }


    public function destroy(Masterrak $masterrak)
    {
        $masterrak->delete();
        return redirect()->route('masterrak.index')->with('success', 'Data Telah dihapus');
    }

    // public function masterrakpdf() {
    //     $data = Masterrak::all();

    //     $pdf = PDF::loadview('masterrak/masterrakpdf', ['masterrak' => $data]);
    //     return $pdf->download('laporan_masterrak.pdf');
    // }
}
