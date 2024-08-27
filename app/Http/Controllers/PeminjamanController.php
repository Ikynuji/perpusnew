<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\Masterrak;
use App\Models\Masterbuku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Models\Masteranggota;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class PeminjamanController extends Controller
{
    public function index(Request $request)
{
    $query = Peminjaman::query();

    // Filter pencarian
    if ($request->has('search')) {
        $query->where('judul', 'LIKE', '%' . $request->search . '%');
    }
    // Role-based filtering
    if (Auth::user()->roles == 'siswa') {
        $query->where('id_anggota', Auth::id());
    }

    $peminjaman = $query->paginate(10);

    return view('peminjaman.index', compact('peminjaman'));
}

    public function create()
    {
        $masterbuku = Masterbuku::all();
        $masteranggota = Masteranggota::all();
        $masterrak = Masterrak::all();

        return view('peminjaman.create', [
            'masterbuku' => $masterbuku,
            'masteranggota' => $masteranggota,
            'masterrak' => $masterrak,
        ]);
        return view('peminjaman.create')->with('success', 'Data Telah ditambahkan');
    }


    public function store(Request $request)
    {
        $data = $request->all();
        $tanggal_pinjam = Carbon::parse($data['tanggalpinjam']);
        $tanggal_tenggat = $tanggal_pinjam->copy()->addDays(7);

        // Menyimpan tanggal tenggat ke dalam data yang akan disimpan
        $data['tenggat'] = $tanggal_tenggat;

        Peminjaman::create($data);

        return redirect()->route('peminjaman.index')->with('success', 'Data Telah ditambahkan');
    }


    public function show($id)
    {

    }


    public function edit(Peminjaman $peminjaman)
    {
        $masterbuku = Masterbuku::all();
        $masteranggota = Masteranggota::all();
        $masterrak = Masterrak::all();

        return view('peminjaman.edit', [
            'item' => $peminjaman,
            'masteranggota' => $masteranggota,
            'masterbuku' => $masterbuku,
            'masterrak' => $masterrak,
        ]);
    }


    public function update(Request $request, $id)
{
    $item = Peminjaman::findOrFail($id);

    // Validate the input
    $request->validate([
        'bayar' => 'required|numeric|min:1000',
    ]);

    // Calculate the new payment amount
    $totalBayar = $item->bayar + $request->bayar;

    // Update the payment
    $item->bayar = $totalBayar;

    // Check if the payment covers the total fine
    if ($totalBayar >= $item->denda) {
        $item->status = 'Lunas'; // Set status to Lunas
    }

    // Save the changes
    $item->save();

    return redirect()->route('peminjaman.index')
                     ->with('success', 'Pembayaran berhasil disimpan.');
}


    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();
        return redirect()->route('peminjaman.index')->with('success', 'Data Telah dihapus');
    }

    public function peminjamanpdf() {
        $data = Peminjaman::all();

        $pdf = PDF::loadview('peminjaman.peminjamanpdf', ['peminjaman' => $data]);
        return $pdf->download('laporan_peminjaman.pdf');
    }

     // Laporan Buku Peminjaman Filter
     public function cetakbarangpertanggal()
     {
         $peminjaman = Peminjaman::Paginate(10);

         return view('laporanperpus.laporanpeminjaman', ['laporanpeminjaman' => $peminjaman]);
     }

     public function filterdatebarang(Request $request)
     {
         $startDate = $request->input('dari');
         $endDate = $request->input('sampai');

          if ($startDate == '' && $endDate == '') {
             $laporanpeminjaman = Peminjaman::paginate(10);
         } else {
             $laporanpeminjaman = Peminjaman::whereDate('tanggal','>=',$startDate)
                                         ->whereDate('tanggal','<=',$endDate)
                                         ->paginate(10);
         }
         session(['filter_start_date' => $startDate]);
         session(['filter_end_date' => $endDate]);

         return view('laporanperpus.laporanpeminjaman', compact('laporanpeminjaman'));
     }


     public function laporanpeminjamanpdf(Request $request )
     {
         $startDate = session('filter_start_date');
         $endDate = session('filter_end_date');

         if ($startDate == '' && $endDate == '') {
             $laporanpeminjaman = Peminjaman::all();
         } else {
             $laporanpeminjaman = Peminjaman::whereDate('tanggal', '>=', $startDate)
                                             ->whereDate('tanggal', '<=', $endDate)
                                             ->get();
         }

         // Render view dengan menyertakan data laporan dan informasi filter
         $pdf = PDF::loadview('laporanperpus.laporanpeminjamanpdf', compact('laporanpeminjaman'));
         return $pdf->download('laporan_laporanpeminjaman.pdf');
     }







    // Pengembalian
    public function pengembalian_index(Request $request)
    {
        $query = Peminjaman::query();

        // Filter pencarian
        if ($request->has('search')) {
            $query->where('judul', 'LIKE', '%' . $request->search . '%');
        }
        // Role-based filtering
        if (Auth::user()->roles == 'siswa') {
            $query->where('id_anggota', Auth::id());
        }

        $peminjaman = $query->paginate(10);

        return view('pengembalian.index', compact('peminjaman'));
    }

    public function pengembalian_edit($peminjaman)
        {
        $peminjaman = Peminjaman::find($peminjaman);

        // $peminjaman->return_date = Carbon::now();
        $timezone = 'Asia/Jakarta';
        $peminjaman->return_date = Carbon::now($timezone)->formatLocalized('%Y-%m-%d');
        $peminjaman->status = 'pengembalian';
        $peminjaman->tglpengembalian = Carbon::now($timezone)->formatLocalized('%Y-%m-%d');



        $due_date = Carbon::parse($peminjaman->tenggat);
        $return_date = Carbon::parse($peminjaman->return_date);

        $selisih = $return_date->greaterThan($due_date);

        $hari_keterlambatan = 0;

        if($selisih) {
            $hari_keterlambatan = $due_date->diffInDays($return_date);
            $denda_per_hari = 5000;
            $total_denda = $hari_keterlambatan * $denda_per_hari;

            $peminjaman->denda = $total_denda;

        } else {
            $peminjaman->denda = 0;
        }

        $peminjaman->hari_keterlambatan = $hari_keterlambatan;

        $masterbuku = Masterbuku::all();
        $masteranggota = Masteranggota::all();

        return view('pengembalian.edit', [
            'item' => $peminjaman,
            'masteranggota' => $masteranggota,
            'masterbuku' => $masterbuku,
        ]);
    }

    public function pengembalian_update(Request $request, Peminjaman $peminjaman)
    {
        $data = $request->all();

        $peminjaman->update($data);

        //dd($data);

        return redirect()->route('pengembalian.index')->with('success', 'Data Telah diupdate');
    }

    public function pengembalian_pdf() {
        $data = Peminjaman::all();

        $pdf = PDF::loadview('pengembalian.pengembalianpdf', ['pengembalian' => $data]);
        return $pdf->download('laporan_pengembalian.pdf');
    }

   public function showPayForm($id)
    {
        $item = Peminjaman::findOrFail($id);
        $denda = session('denda');
        // return($item);

        return view('pengembalian.pay', compact('item', 'denda'));
    }

    public function updatePayment(Request $request, $id)
{
    $item = Peminjaman::findOrFail($id);

    // Validasi permintaan
    // $validatedData = $request->validate([
    //     'bayar' => 'required|numeric|min:1000|max:' . ($item->denda - $item->bayar),
    //     'keterangan' => 'required|string|max:255',
    // ]);


    // return $request->all;

    $item->bayar += $request->bayar;
    $item->keterangan = $request->keterangan;

    if ($item->save()) {
        return redirect()->route('pengembalian.index', $id)->with('success', 'Pembayaran berhasil disimpan.');
    }
}



    // Laporan Buku pengembalian Filter
    public function cetakpertanggalpengembalian()
    {
        $peminjaman = Peminjaman::Paginate(10);

        return view('laporanperpus.laporanpengembalian', ['laporanpengembalian' => $peminjaman]);
    }

    public function filterdatepengembalian(Request $request)
    {
        $startDate = $request->input('dari');
        $endDate = $request->input('sampai');

         if ($startDate == '' && $endDate == '') {
            $laporanpengembalian = Peminjaman::paginate(10);
        } else {
            $laporanpengembalian = Peminjaman::whereDate('tanggal','>=',$startDate)
                                        ->whereDate('tanggal','<=',$endDate)
                                        ->paginate(10);
        }
        session(['filter_start_date' => $startDate]);
        session(['filter_end_date' => $endDate]);

        return view('laporanperpus.laporanpengembalian', compact('laporanpengembalian'));
    }


    public function laporanpengembalianpdf(Request $request )
    {
        $startDate = session('filter_start_date');
        $endDate = session('filter_end_date');

        if ($startDate == '' && $endDate == '') {
            $laporanpengembalian = Peminjaman::all();
        } else {
            $laporanpengembalian = Peminjaman::whereDate('tanggal', '>=', $startDate)
                                            ->whereDate('tanggal', '<=', $endDate)
                                            ->get();
        }

        // Render view dengan menyertakan data laporan dan informasi filter
        $pdf = PDF::loadview('laporanperpus.laporanpengembalianpdf', compact('laporanpengembalian'));
        return $pdf->download('laporan_laporanpengembalian.pdf');
    }



    // Laporan Buku Denda Filter
    public function cetakpertanggaldenda()
    {
        $peminjaman = Peminjaman::Paginate(10);

        return view('laporanperpus.laporandenda', ['laporandenda' => $peminjaman]);
    }

    public function filterdatedenda(Request $request)
    {
        $startDate = $request->input('dari');
        $endDate = $request->input('sampai');

         if ($startDate == '' && $endDate == '') {
            $laporandenda = Peminjaman::paginate(10);
        } else {
            $laporandenda = Peminjaman::whereDate('tanggal','>=',$startDate)
                                        ->whereDate('tanggal','<=',$endDate)
                                        ->paginate(10);
        }
        session(['filter_start_date' => $startDate]);
        session(['filter_end_date' => $endDate]);

        return view('laporanperpus.laporandenda', compact('laporandenda'));
    }


    public function laporandendapdf(Request $request )
    {
        $startDate = session('filter_start_date');
        $endDate = session('filter_end_date');

        if ($startDate == '' && $endDate == '') {
            $laporandenda = Peminjaman::all();
        } else {
            $laporandenda = Peminjaman::whereDate('tanggal', '>=', $startDate)
                                            ->whereDate('tanggal', '<=', $endDate)
                                            ->get();
        }

        // Render view dengan menyertakan data laporan dan informasi filter
        $pdf = PDF::loadview('laporanperpus.laporandendapdf', compact('laporandenda'));
        return $pdf->download('laporan_laporandenda.pdf');
    }

    // Report Pernama
    public function pernama(Request $request)
{
    // Ambil filter dari request, defaultnya adalah null
    $filter = $request->query('filter', null);

    // Ambil data peminjaman berdasarkan filter
    if ($filter === 'all' || empty($filter)) {
        $peminjaman = Peminjaman::paginate(10);
    } else {
        $peminjaman = Peminjaman::where('id_anggota', $filter)->paginate(10);
    }

    // Ambil data agregat
    $idAnggotaCounts = Peminjaman::select('id_anggota', DB::raw('count(*) as count'))
        ->groupBy('id_anggota')
        ->orderBy('id_anggota')
        ->get();

    // Ambil data master anggota
    $masteranggota = MasterAnggota::all();

    return view('laporanperpus.pernama', [
        'peminjaman' => $peminjaman,
        'idAnggotaCounts' => $idAnggotaCounts,
        'filter' => $filter,
        'masteranggota' => $masteranggota,
    ]);
}

    // Fungsi untuk mencetak PDF
    public function cetakPernamaPdf(Request $request)
{
    $filter = $request->query('filter', null);

    // Handle filtering
    if ($filter === 'all' || empty($filter)) {
        $peminjaman = Peminjaman::all();
    } else {
        $peminjaman = Peminjaman::where('id_anggota', $filter)->get();
    }

    // Get aggregated data
    $idAnggotaCounts = Peminjaman::groupBy('id_anggota')
        ->orderBy('id_anggota')
        ->select(DB::raw('count(*) as count, id_anggota'))
        ->get();

    // Load view and convert to PDF
    $pdf = PDF::loadView('laporanperpus.pernamapdf', [
        'peminjaman' => $peminjaman,
        'idAnggotaCounts' => $idAnggotaCounts,
        'filter' => $filter,
    ]);

    // Return the generated PDF as a download
    return $pdf->download('laporan_pernama.pdf');
}

}


