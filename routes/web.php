<?php

use App\Models\Rusak;
use App\Models\Reqbuku;
use App\Models\Masterrak;
use App\Models\Masterbuku;
use App\Models\Peminjaman;
use App\Models\Masteranggota;
use App\Models\Masterkategori;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RusakController;
use App\Http\Controllers\ReqbukuController;

// New
use App\Http\Controllers\AnggaranController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterrakController;
use App\Http\Controllers\MasterbukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\MasterebookController;
use App\Http\Controllers\MasteranggotaController;
use App\Http\Controllers\MasterkategoriController;
use App\Http\Controllers\PeminjamanebookController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $jumlahbuku = Masteranggota::count();
    $pinjaman = Peminjaman::count();
    $jumlahanggota = Masteranggota::count();
    $stockbuku = Masterbuku::count();
    $kategori = Masterkategori::count();
    $rakbuku = Masterrak::count();
    $rusakCount = Rusak::where('kerusakan', 'Rusak')->count();
    $hilangCount = Rusak::where('kerusakan', 'Hilang')->count();
    $reqebook = Reqbuku::where('keterangan', 'E-Book')->count();
    $reqoffbook = Reqbuku::where('keterangan', 'Offline Book')->count();
    $dateNow = new \DateTime();
    $anggotabaru = Masteranggota::whereDate('created_at', today())->count();
    $peminjamanbaru = Peminjaman::whereDate('tanggalpinjam', today())->count();
    $pengembalianbaru = Peminjaman::whereDate('tglpengembalian', today())->count();
    $jatuhtempo = Peminjaman::whereDate('tenggat', today())->count();
    return view('dashboard',compact(
        'jumlahbuku','jumlahanggota','stockbuku','kategori','rakbuku','rusakCount','hilangCount','pinjaman','dateNow','anggotabaru',
        'peminjamanbaru','pengembalianbaru','jatuhtempo','reqoffbook','reqebook'));
})->middleware('auth');


Route::prefix('dashboard')->middleware(['auth:sanctum'])->group(function() {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Master Data
    Route::resource('masterrak', MasterrakController::class);
    Route::resource('masterkategori', MasterkategoriController::class);
    Route::resource('masterbuku', MasterbukuController::class);
    Route::resource('masteranggota', MasteranggotaController::class);
    Route::resource('masterebook', MasterebookController::class);

    // Data Tables
    Route::resource('rusak', RusakController::class);
    Route::resource('reqbuku', ReqbukuController::class);
    Route::resource('peminjaman', PeminjamanController::class);
    Route::resource('anggaran', AnggaranController::class);
    Route::resource('peminjamanebook', PeminjamanebookController::class);

    // Pengembalian
    Route::get('pengembalian', [PeminjamanController::class, 'pengembalian_index'])->name('pengembalian.index');
    Route::get('pengembalian/{peminjaman}', [PeminjamanController::class, 'pengembalian_create'])->name('pengembalian.create');
    Route::get('pengembalian/{peminjaman}/edit', [PeminjamanController::class, 'pengembalian_edit'])->name('pengembalian.edit');
    Route::get('pengembalian/{peminjaman}', [PeminjamanController::class, 'pengembalian_edit'])->name('pengembalian.pay');

    // Pembayaran
    Route::get('/pengembalian/pay/{id}', 'App\Http\Controllers\PeminjamanController@showPayForm')->name('pengembalian.pay');
    Route::put('/pengembalian/pay/{id}', 'App\Http\Controllers\PeminjamanController@updatePayment')->name('pengembalian.updatePayment');
    Route::get('/peminjaman/{id}/pengembalian/create', 'PeminjamanController@pengembalian_create')->name('pengembalian.create');
    Route::post('/peminjaman/{id}/pengembalian/store', 'PeminjamanController@pengembalian_store')->name('pengembalian.store');

    // Verifikasi Di Master Data Anggota
    Route::put('/items/{id}/verify', [MasteranggotaController::class, 'verify'])->name('items.verify');






// Data Tables Report Report
Route::get('laporanreqbuku', [ReqbukuController::class, 'laporanreqbuku'])->name('laporanreqbuku');
Route::get('laporanrusak', [RusakController::class, 'laporanrusak'])->name('laporanrusak');
Route::get('peminjamanpdf', [PeminjamanController::class, 'peminjamanpdf'])->name('peminjamanpdf');

Route::get('laporanperpus/pernama', [PeminjamanController::class, 'pernama'])->name('pernama');
Route::get('/pernamapdf', [PeminjamanController::class, 'cetakPernamaPdf'])->name('pernamapdf');

// Rute untuk menampilkan laporan anggota
Route::get('laporanperpus/laporananggota', [MasteranggotaController::class, 'perkelas'])->name('laporananggota');

// Rute untuk mengekspor PDF
Route::get('/perkelaspdf', [MasteranggotaController::class, 'cetakPerkelasPdf'])->name('laporananggotapdf');

// Recap Laporan Tampilan
Route::get('laporanperpus/laporandenda', [PeminjamanController::class, 'cetakpertanggaldenda'])->name('laporandenda');
Route::get('laporanperpus/laporanreqbuku', [ReqbukuController::class, 'cetakbarangpertanggal'])->name('laporanreqbuku');
Route::get('laporanperpus/laporanrusak', [RusakController::class, 'cetakbarangpertanggal'])->name('laporanrusak');
Route::get('laporanperpus/laporanpeminjaman', [PeminjamanController::class, 'cetakbarangpertanggal'])->name('laporanpeminjaman');
Route::get('laporanperpus/laporanpeminjaman', [PeminjamanController::class, 'cetakpertanggalpengembalian'])->name('laporanpeminjaman');
Route::get('laporanperpus/laporanpengadaanbuku', [MasterbukuController::class, 'cetakbukupertanggal'])->name('laporanpengadaanbuku');

// Filtering

Route::get('laporandenda', [PeminjamanController::class, 'filterdatedenda'])->name('laporandenda');
Route::get('laporanrusak', [RusakController::class, 'filterdatebarang'])->name('laporanrusak');
Route::get('laporanreqbuku', [ReqbukuController::class, 'filterdatebarang'])->name('laporanreqbuku');
Route::get('laporanpeminjaman', [PeminjamanController::class, 'filterdatebarang'])->name('laporanpeminjaman');
Route::get('laporanpeminjamanebook', [PeminjamanebookController::class, 'filterdateebook'])->name('laporanpeminjamanebook');
Route::get('laporanpengembalian', [PeminjamanController::class, 'filterdatepengembalian'])->name('laporanpengembalian');
Route::get('laporanpengadaanbuku', [MasterbukuController::class, 'filterdatebuku'])->name('laporanpengadaanbuku');


//Anggaran
Route::get('laporanperpus/laporananggaran', [AnggaranController::class, 'cetakpertahunanggaran'])->name('laporananggaran');
Route::get('laporananggaran', [AnggaranController::class, 'filtertahunanggaran'])->name('filtertahunanggaran');
Route::get('laporananggaranpdf', [AnggaranController::class, 'laporananggaranpdf'])->name('laporananggaranpdf');

//E-book
Route::get('laporanperpus/laporanebook', [PeminjamanebookController::class, 'cetakebookpertanggal'])->name('laporanebook');
Route::get('laporanebook', [PeminjamanebookController::class, 'filterdateebook'])->name('filterdateebook');
Route::get('laporanpeminjamanebookpdf', [PeminjamanebookController::class, 'laporanpeminjamanebookpdf'])->name('laporanpeminjamanebookpdf');


// Filter Laporan

Route::get('laporandendapdf/filter={filter}', [PeminjamanController::class, 'laporandendapdf'])->name('laporandendapdf');
Route::get('laporanrusakpdf/filter={filter}', [RusakController::class, 'laporanrusakpdf'])->name('laporanrusakpdf');
Route::get('laporanreqbukupdf/filter={filter}', [ReqbukuController::class, 'laporanreqbukupdf'])->name('laporanreqbukupdf');
Route::get('laporanpeminjamanpdf/filter={filter}', [PeminjamanController::class, 'laporanpeminjamanpdf'])->name('laporanpeminjamanpdf');
Route::get('laporanpengembalianpdf/filter={filter}', [PeminjamanController::class, 'laporanpengembalianpdf'])->name('laporanpengembalianpdf');
Route::get('laporanbukupdf/filter={filter}', [MasterbukuController::class, 'laporanbukupdf'])->name('laporanbukupdf');

});



// Login Register
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/loginuser', [LoginController::class, 'loginuser'])->name('loginuser');








