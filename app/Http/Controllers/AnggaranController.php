<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\Anggaran;
use Illuminate\Http\Request;
use App\Models\Masterkategori;

class AnggaranController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('search')){
            $anggaran = Anggaran::where('namanbuku', 'LIKE', '%' .$request->search.'%')->paginate(10);
        }else{
            $anggaran = Anggaran::paginate(10);
        }
        return view('anggaran.index',[
            'anggaran' => $anggaran
        ]);
    }


    public function create()
    {
        $masterkategori = Masterkategori::all();

        return view('anggaran.create', [
            'masterkategori' => $masterkategori,
        ]);
        return view('anggaran.create')->with('success', 'Data Telah ditambahkan');
    }


    public function store(Request $request)
    {
        $request->validate([
            'namanbuku' => 'required|unique:anggarans,namanbuku',
        ], [
            'namanbuku.unique' => 'Nama buku sudah ada. Silakan gunakan nama lain.',
        ]);
        $data = $request->all();

        Anggaran::create($data);

        return redirect()->route('anggaran.index')->with('success', 'Data Telah ditambahkan');
    }


    public function show($id)
    {

    }


    public function edit(Anggaran $anggaran)
    {
        $masterkategori = Masterkategori::all();

        return view('anggaran.edit', [
            'item' => $anggaran,
            'master$masterkategori' => $masterkategori,
        ]);
    }


    public function update(Request $request, Anggaran $id)
    {
        $data = $request->all();

        $id->update($data);

        return redirect()->route('anggaran.index')->with('success', 'Data Telah diupdate');

    }


    public function destroy(Anggaran $anggaran)
    {
        $anggaran->delete();
        return redirect()->route('anggaran.index')->with('success', 'Data Telah dihapus');
    }

    public function anggaranpdf() {
        $data = anggaran::all();

        $pdf = PDF::loadview('anggaran/anggaranpdf', ['anggaran' => $data]);
        return $pdf->download('laporan_Bukuanggaran.pdf');
    }

    public function cetakpertahunanggaran()
{
    $anggaran = Anggaran::paginate(10);

    return view('laporanperpus.laporananggaran', ['laporananggaran' => $anggaran]);
}

public function filtertahunanggaran(Request $request)
{
    $startYear = $request->input('tahun');

    if ($startYear == '') {
        $laporananggaran = Anggaran::paginate(10);
    } else {
        $laporananggaran = Anggaran::whereYear('tanggal', $startYear)
                                    ->paginate(10);
    }
    session(['filter_year' => $startYear]);

    return view('laporanperpus.laporananggaran', compact('laporananggaran'));
}

public function laporananggaranpdf()
{
    $year = session('filter_year');

    if ($year == '') {
        $laporananggaran = Anggaran::all();
    } else {
        $laporananggaran = Anggaran::whereYear('tanggal', $year)
                                    ->get();
    }

    // Render view dengan menyertakan data laporan dan informasi filter
    $pdf = PDF::loadview('laporanperpus.laporananggaranpdf', compact('laporananggaran'));
    return $pdf->download('laporan_laporananggaran.pdf');
}
}
