<?php

namespace App\Http\Controllers;
use PDF;
use App\Models\Masterebook;
use Illuminate\Http\Request;
use App\Models\Masteranggota;
use App\Models\Peminjamanebook;
use Illuminate\Support\Facades\Auth;

class PeminjamanebookController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjamanebook::query();

        // Filter pencarian
        if ($request->has('search')) {
            $query->where('judul', 'LIKE', '%' . $request->search . '%');
        }
        // Role-based filtering
        if (Auth::user()->roles == 'siswa') {
            $query->where('id_anggota', Auth::id());
        }

        $peminjamanebook = $query->paginate(10);

        return view('peminjamanebook.index', compact('peminjamanebook'));
    }

    public function create()
    {
        $masterebook = Masterebook::all();
        $masteranggota = Masteranggota::all();

        return view('peminjamanebook.create', [
            'masterebook' => $masterebook,
            'masteranggota' => $masteranggota,
        ]);
        return view('peminjamanebook.create')->with('success', 'Data Telah ditambahkan');
    }


    public function store(Request $request)
    {
        $data = $request->all();
        Peminjamanebook::create($data);

        return redirect()->route('peminjamanebook.index')->with('success', 'Data Telah ditambahkan');
    }


    public function show($id)
    {

    }


    public function edit(Peminjamanebook $peminjamanebook)
    {
        $masterebook = Masterebook::all();
        $masteranggota = Masteranggota::all();

        return view('peminjamanebook.edit', [
            'item' => $peminjamanebook,
            'masteranggota' => $masteranggota,
            'masterebook' => $masterebook,
        ]);
    }


    public function update(Request $request, Peminjamanebook $peminjamanebook)
    {
        $data = $request->all();

        $peminjamanebook->update($data);

        //dd($data);

        return redirect()->route('peminjamanebook.index')->with('success', 'Data Telah diupdate');

    }


    public function destroy(Peminjamanebook $peminjamanebook)
    {
        $peminjamanebook->delete();
        return redirect()->route('peminjamanebook.index')->with('success', 'Data Telah dihapus');
    }

    // Laporan Buku Peminjaman Filter E-Book
    public function cetakebookpertanggal()
    {
        $laporanpeminjamanebook = Peminjamanebook::Paginate(10);

        return view('laporanperpus.laporanebook', ['laporanebook' => $laporanpeminjamanebook]);
    }

    // public function peminjamanebookpdf() {
    //     $data = laporanpeminjamanebook::all();

    //     $pdf = PDF::loadview('peminjaman.peminjamanpdf', ['peminjaman' => $data]);
    //     return $pdf->download('laporan_peminjaman.pdf');
    // }

    public function filterdateebook(Request $request)
    {
        $startDate = $request->input('dari');
        $endDate = $request->input('sampai');

         if ($startDate == '' && $endDate == '') {
            $laporanpeminjamanebook = Peminjamanebook::paginate(10);
        } else {
            $laporanpeminjamanebook = Peminjamanebook::whereDate('tanggalpinjam','>=',$startDate)
                                        ->whereDate('tanggalpinjam','<=',$endDate)
                                        ->paginate(10);
        }
        session(['filter_start_date' => $startDate]);
        session(['filter_end_date' => $endDate]);

        return view('laporanperpus.laporanebook', compact('laporanpeminjamanebook'));
    }


    public function laporanpeminjamanebookpdf(Request $request )
    {
        $startDate = session('filter_start_date');
        $endDate = session('filter_end_date');

        if ($startDate == '' && $endDate == '') {
            $laporanpeminjamanebook = Peminjamanebook::all();
        } else {
            $laporanpeminjamanebook = Peminjamanebook::whereDate('tanggalpinjam', '>=', $startDate)
                                            ->whereDate('tanggalpinjam', '<=', $endDate)
                                            ->get();
        }

        // Render view dengan menyertakan data laporan dan informasi filter
        $pdf = PDF::loadview('laporanperpus.laporanebookpdf', compact('laporanpeminjamanebook'));
        return $pdf->download('laporan_laporanpeminjamanebook.pdf');
    }
}
