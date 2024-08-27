<?php

namespace App\Http\Controllers;

use App\Models\Masterrak;
use App\Models\Masterbuku;
use Illuminate\Http\Request;
use App\Models\Masterkategori;
use PDF;

class MasterbukuController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('search')){
            $masterbuku = Masterbuku::where('judul', 'LIKE', '%' .$request->search.'%')->paginate(10);
        }else{
            $masterbuku = Masterbuku::paginate(10);
        }
        return view('masterbuku.index',[
            'masterbuku' => $masterbuku
        ]);
    }


    public function create()
    {
        $masterrak = Masterrak::all();
        $masterkategori = Masterkategori::all();

        return view('masterbuku.create', [
            'masterrak' => $masterrak,
            'masterkategori' => $masterkategori,
        ]);
        return view('masterbuku.create')->with('success', 'Data Telah ditambahkan');
    }


    public function store(Request $request)
    {
        $data = Masterbuku::create($request->all());
        if($request->hasFile('cover')) {
            $request->file('cover')->move('cover/', $request->file('cover')->getClientOriginalName());
            $data->cover = $request->file('cover')->getClientOriginalName();
            $data->save();
        }

        return redirect()->route('masterbuku.index')->with('success', 'Data Telah ditambahkan');
    }


    public function show($id)
    {

    }


    public function edit(Masterbuku $masterbuku)
    {
        $masterrak = Masterrak::all();
        $masterkategori = Masterkategori::all();

        return view('masterbuku.edit', [
            'item' => $masterbuku,
            'masterrak' => $masterrak,
            'masterkategori' => $masterkategori,
        ]);
    }


    public function update(Request $request, Masterbuku $masterbuku)
    {
        $data = $request->all();

        $masterbuku->update($data);

        //dd($data);

        return redirect()->route('masterbuku.index')->with('success', 'Data Telah diupdate');

    }


    public function destroy(Masterbuku $masterbuku)
    {
        $masterbuku->delete();
        return redirect()->route('masterbuku.index')->with('success', 'Data Telah dihapus');
    }


    // Laporan Buku Rusak Filter
    public function cetakbukupertanggal()
    {
        $masterbuku = Masterbuku::Paginate(10);

        return view('laporanperpus.laporanpengadaanbuku', ['laporanpengadaanbuku' => $masterbuku]);
    }

    public function filterdatebuku(Request $request)
    {
        $startDate = $request->input('dari');
        $endDate = $request->input('sampai');

         if ($startDate == '' && $endDate == '') {
            $laporanbuku = Masterbuku::paginate(10);
        } else {
            $laporanbuku = Masterbuku::whereDate('tanggal','>=',$startDate)
                                        ->whereDate('tanggal','<=',$endDate)
                                        ->paginate(10);
        }
        session(['filter_start_date' => $startDate]);
        session(['filter_end_date' => $endDate]);

        return view('laporanperpus.laporanpengadaanbuku', compact('laporanbuku'));
    }


    public function laporanbukupdf(Request $request )
    {
        $startDate = session('filter_start_date');
        $endDate = session('filter_end_date');

        if ($startDate == '' && $endDate == '') {
            $laporanbuku = Masterbuku::all();
        } else {
            $laporanbuku = Masterbuku::whereDate('tanggal', '>=', $startDate)
                                            ->whereDate('tanggal', '<=', $endDate)
                                            ->get();
        }

        // Render view dengan menyertakan data laporan dan informasi filter
        $pdf = PDF::loadview('laporanperpus.laporanpengadaanbukupdf', compact('laporanbuku'));
        return $pdf->download('laporan_laporanpengadaanbuku.pdf');
    }
}
