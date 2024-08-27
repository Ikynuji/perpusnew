<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Masterkategori;

class MasterkategoriController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('search')){
            $masterkategori = Masterkategori::where('nama', 'LIKE', '%' .$request->search.'%')->paginate(10);
        }else{
            $masterkategori = Masterkategori::paginate(10);
        }
        return view('masterkategori.index',[
            'masterkategori' => $masterkategori
        ]);
    }


    public function create()
    {
        return view('masterkategori.create');
    }


    public function store(Request $request)
    {
        $data = $request->all();

        Masterkategori::create($data);

        return redirect()->route('masterkategori.index')->with('success', 'Data Telah ditambahkan');
    }


    public function show($id)
    {

    }


    public function edit(Masterkategori $masterkategori)
    {
        return view('masterkategori.edit', [
            'item' => $masterkategori
        ]);
    }


    public function update(Request $request, Masterkategori $masterkategori)
    {
        $data = $request->all();

        $masterkategori->update($data);

        //dd($data);

        return redirect()->route('masterkategori.index')->with('success', 'Data Telah diupdate');

    }


    public function destroy(Masterkategori $masterkategori)
    {
        $masterkategori->delete();
        return redirect()->route('masterkategori.index')->with('success', 'Data Telah dihapus');
    }

    public function masterkategoripdf() {
        $data = Masterkategori::all();

        $pdf = PDF::loadview('masterkategori/masterkategoripdf', ['masterkategori' => $data]);
        return $pdf->download('laporan_masterkategori.pdf');
    }
}
