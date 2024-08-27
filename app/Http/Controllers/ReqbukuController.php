<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Reqbuku;
use Illuminate\Http\Request;
use App\Models\Masteranggota;
use App\Models\Masterkategori;
use Illuminate\Support\Facades\Auth;

class ReqbukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Reqbuku::query();

        // Filter pencarian
        if ($request->has('search')) {
            $query->where('judul', 'LIKE', '%' . $request->search . '%');
        }
        // Role-based filtering
        if (Auth::user()->roles == 'siswa') {
            $query->where('id_anggota', Auth::id());
        }

        $reqbuku = $query->paginate(10);

        return view('reqbuku.index', compact('reqbuku'));
    }


    public function create()
    {
        $masterkategori = Masterkategori::all();
        $masteranggota = Masteranggota::all();

        return view('reqbuku.create', [
            'masterkategori' => $masterkategori,
            'masteranggota' => $masteranggota,
        ]);
        return view('reqbuku.create')->with('success', 'Data Telah ditambahkan');
    }


    public function store(Request $request)
    {
        $data = $request->all();

        Reqbuku::create($data);

        return redirect()->route('reqbuku.index')->with('success', 'Data Telah ditambahkan');
    }


    public function show($id)
    {

    }


    public function edit(Reqbuku $reqbuku)
    {
        $masterkategori = Masterkategori::all();
        $masteranggota = Masteranggota::all();

        return view('reqbuku.edit', [
            'item' => $reqbuku,
            'masterkategori' => $masterkategori,
            'masteranggota' => $masteranggota,
        ]);
    }


    public function update(Request $request, Reqbuku $id)
    {
        $data = $request->all();

        $id->update($data);

        return redirect()->route('reqbuku.index')->with('success', 'Data Telah diupdate');

    }


    public function destroy(Reqbuku $reqbuku)
    {
        $reqbuku->delete();
        return redirect()->route('reqbuku.index')->with('success', 'Data Telah dihapus');
    }

    public function reqbukupdf() {
        $data = Reqbuku::all();

        $pdf = PDF::loadview('reqbuku/reqbukupdf', ['reqbuku' => $data]);
        return $pdf->download('laporan_Reqbuku.pdf');
    }

    // Laporan Buku reqbuku Filter
    public function cetakbarangpertanggal()
    {
        $reqbuku = Reqbuku::Paginate(10);

        return view('laporanperpus.laporanreqbuku', ['laporanreqbuku' => $reqbuku]);
    }

    public function filterdatebarang(Request $request)
    {
        $startDate = $request->input('dari');
        $endDate = $request->input('sampai');

         if ($startDate == '' && $endDate == '') {
            $laporanreqbuku = Reqbuku::paginate(10);
        } else {
            $laporanreqbuku = Reqbuku::whereDate('tanggal','>=',$startDate)
                                        ->whereDate('tanggal','<=',$endDate)
                                        ->paginate(10);
        }
        session(['filter_start_date' => $startDate]);
        session(['filter_end_date' => $endDate]);

        return view('laporanperpus.laporanreqbuku', compact('laporanreqbuku'));
    }


    public function laporanreqbukupdf(Request $request )
    {
        $startDate = session('filter_start_date');
        $endDate = session('filter_end_date');

        if ($startDate == '' && $endDate == '') {
            $laporanreqbuku = Reqbuku::all();
        } else {
            $laporanreqbuku = Reqbuku::whereDate('tanggal', '>=', $startDate)
                                            ->whereDate('tanggal', '<=', $endDate)
                                            ->get();
        }

        // Render view dengan menyertakan data laporan dan informasi filter
        $pdf = PDF::loadview('laporanperpus.laporanreqbukupdf', compact('laporanreqbuku'));
        return $pdf->download('laporan_laporanreqbuku.pdf');
    }
}
