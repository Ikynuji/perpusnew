@extends('layout.admin')

@section('content')
    <!-- Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
      data-sidebar-position="fixed" data-header-position="fixed">

        <div class="container-fluid">
            <!-- Row 1 -->
            <div class="row">
                <!-- BOOKS -->
                <div class="col-lg-3 col-sm-6">
                    <a href="/">
                        <div class="card">
                            <div class="card-body">
                                <h2>
                                    <i class="ti ti-book"></i>
                                </h2>
                                <h3>
                                    {{ $jumlahbuku }} Buku
                                </h3>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- BOOK STOCK -->
                <div class="col-lg-3 col-sm-6">
                    <a href="/">
                        <div class="card">
                            <div class="card-body">
                                <h2>
                                    <i class="ti ti-database"></i>
                                </h2>
                                <h3>
                                    {{ $stockbuku }} Stok Buku
                                </h3>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- RACKS -->
                <div class="col-lg-3 col-6">
                    <a href="/">
                        <div class="card">
                            <div class="card-body">
                                <h2>
                                    <i class="ti ti-columns"></i>
                                </h2>
                                <h3>
                                    {{ $rakbuku }} Rak Buku
                                </h3>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- CATEGORIES -->
                <div class="col-lg-3 col-6">
                    <a href="/">
                        <div class="card">
                            <div class="card-body">
                                <h2>
                                    <i class="ti ti-category-2"></i>
                                </h2>
                                <h3>
                                    {{ ($kategori) }} Kategori
                                </h3>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- MEMBER -->
                <div class="col-sm-6">
                    <a href="{{ url('admin/members') }}">
                        <div class="card">
                            <div class="card-body">
                                <h2>
                                    <i class="ti ti-user"></i>
                                </h2>
                                <h3>
                                    {{ $jumlahanggota }} Anggota
                                </h3>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- LOANS -->
                <div class="col-sm-6">
                    <a href="/">
                        <div class="card">
                            <div class="card-body">
                                <h2>
                                    <i class="ti ti-arrows-exchange"></i>
                                </h2>
                                <h3>
                                    {{ $pinjaman }} Transaksi Peminjaman
                                </h3>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- REPORT TODAY -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h3 class="card-title"><b>Laporan Hari Ini</b></h3>
                            {{ $dateNow->format('d F Y') }}
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6 col-md-3">
                                    <h4 class="text-success"><b>Anggota Baru</b></h4>
                                    <h3>{{ $anggotabaru }}</h3>
                                </div>
                                <div class="col-6 col-md-3">
                                    <h4 class="text-info"><b>Peminjaman</b></h4>
                                    <h3>{{ $peminjamanbaru }}</h3>
                                </div>
                                <div class="col-6 col-md-3">
                                    <h4 class="text-info"><b>Pengembalian</b></h4>
                                    <h3>{{ $pengembalianbaru }}</h3>
                                </div>
                                <div class="col-6 col-md-3">
                                    <h4 class="text-danger"><b>Jatuh Tempo</b></h4>
                                    <h3>{{ $jatuhtempo }}</h3>
                                </div>
                            </div>
                            <div class="row text-center mt-4">
                                <div class="col-6 col-md-3">
                                    <h4 class="text-warning"><b>Rusak</b></h4>
                                    <h3>{{ $rusakCount }}</h3>
                                </div>
                                <div class="col-6 col-md-3">
                                    <h4 class="text-dark"><b>Hilang</b></h4>
                                    <h3>{{ $hilangCount }}</h3>
                                </div>
                                <div class="col-6 col-md-3">
                                    <h4 class="text-primary"><b>Request E-Book</b></h4>
                                    <h3>{{ $reqebook }}</h3>
                                </div>
                                <div class="col-6 col-md-3">
                                    <h4 class="text-secondary"><b>Request Offline Book</b></h4>
                                    <h3>{{ $reqoffbook }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="py-6 px-6 text-center">
                <p class="mb-0 fs-4">Design and Developed by <a href="https://adminmart.com/" target="_blank" class="pe-1 text-primary text-decoration-underline">AdminMart.com</a></p>
            </div> --}}
        </div>
    </div>
@endsection
