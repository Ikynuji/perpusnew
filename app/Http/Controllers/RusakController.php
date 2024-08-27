<?php

namespace App\Http\Controllers;

use App\Models\Rusak;
use App\Models\Masterbuku;
use Illuminate\Http\Request;
use PDF;

class RusakController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('search')){
            $rusak = Rusak::where('judul', 'LIKE', '%' .$request->search.'%')->paginate(10);
        }else{
            $rusak = Rusak::paginate(10);
        }
        return view('rusak.index',[
            'rusak' => $rusak
        ]);
    }


    public function create()
    {
        $masterbuku = Masterbuku::all();

        return view('rusak.create', [
            'masterbuku' => $masterbuku,
        ]);
        return view('rusak.create')->with('success', 'Data Telah ditambahkan');
    }


    public function store(Request $request)
    {
        $data = $request->all();

        Rusak::create($data);

        return redirect()->route('rusak.index')->with('success', 'Data Telah ditambahkan');
    }


    public function show($id)
    {

    }


    public function edit(Rusak $rusak)
    {
        $masterbuku = Masterbuku::all();

        return view('rusak.edit', [
            'item' => $rusak,
            'masterbuku' => $masterbuku,
        ]);
    }


    public function update(Request $request, Rusak $id)
    {
        $data = $request->all();

        $id->update($data);

        return redirect()->route('rusak.index')->with('success', 'Data Telah diupdate');

    }


    public function destroy(Rusak $rusak)
    {
        $rusak->delete();
        return redirect()->route('rusak.index')->with('success', 'Data Telah dihapus');
    }

    public function rusakpdf() {
        $data = Rusak::all();

        $pdf = PDF::loadview('rusak/rusakpdf', ['rusak' => $data]);
        return $pdf->download('laporan_BukuRusak.pdf');
    }

    // Laporan Buku Rusak Filter
    public function cetakbarangpertanggal()
    {
        $rusak = Rusak::Paginate(10);

        return view('laporanperpus.laporanrusak', ['laporanrusak' => $rusak]);
    }

    public function filterdatebarang(Request $request)
    {
        $startDate = $request->input('dari');
        $endDate = $request->input('sampai');

         if ($startDate == '' && $endDate == '') {
            $laporanrusak = Rusak::paginate(10);
        } else {
            $laporanrusak = Rusak::whereDate('tanggal','>=',$startDate)
                                        ->whereDate('tanggal','<=',$endDate)
                                        ->paginate(10);
        }
        session(['filter_start_date' => $startDate]);
        session(['filter_end_date' => $endDate]);

        return view('laporanperpus.laporanrusak', compact('laporanrusak'));
    }


    public function laporanrusakpdf(Request $request )
    {
        $startDate = session('filter_start_date');
        $endDate = session('filter_end_date');

        if ($startDate == '' && $endDate == '') {
            $laporanrusak = Rusak::all();
        } else {
            $laporanrusak = Rusak::whereDate('tanggal', '>=', $startDate)
                                            ->whereDate('tanggal', '<=', $endDate)
                                            ->get();
        }

        // Render view dengan menyertakan data laporan dan informasi filter
        $pdf = PDF::loadview('laporanperpus.laporanrusakpdf', compact('laporanrusak'));
        return $pdf->download('laporan_laporanrusak.pdf');
    }
}
