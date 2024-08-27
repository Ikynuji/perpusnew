@extends('layout.admin')
@push('css')
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="content-wrapper">
                    <!-- Content Header (Page header) -->
                    <div class="content-header">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h3 class="m-0">Data pengembalian</h3>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Data Pengembalian</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        {{-- search --}}
                        <div class="row g-3 align-items-center mb-4">
                            <div class="col-auto">
                                <form action="pengembalian" method="GET">
                                    <input type="text" id="search" name="search" class="form-control"
                                        placeholder="Search">
                                </form>
                            </div>
                            {{-- Button Export PDF --}}
                            {{-- <div class="col-auto">
                                <a href="{{ route('pengembalian.create') }}" class="btn btn-success">
                                    Tambah Data
                                </a> --}}
                                {{-- <a href="{{ route('pendafoutlitepdf')}}" class="btn btn-danger">
                            Export PDF
                        </a> --}}
                            {{-- </div>  --}}
                        </div>
                        <div>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-2">No</th>
                                        @if (Auth::user()->hakakses('kepalaperpus') || Auth::user()->hakakses('petugas'))
                                        <th class="px-6 py-2">Nama Peminjam</th>
                                        @endif
                                        <th class="px-6 py-2">Judul Buku</th>
                                        <th class="px-6 py-2">Jumlah</th>
                                        @if (Auth::user()->hakakses('kepalaperpus') || Auth::user()->hakakses('petugas'))
                                        <th class="px-6 py-2">Tgl Pinjam</th>
                                        <th class="px-6 py-2">Tenggat</th>
                                        <th class="px-6 py-2">Tanggal Pengembalian</th>
                                        @endif
                                        <th class="px-6 py-2">Keterangan Kondisi</th>
                                        <th class="px-6 py-2">Status Pengembalian</th>
                                        @if (Auth::user()->hakakses('kepalaperpus') || Auth::user()->hakakses('petugas')|| Auth::user()->hakakses('siswa'))
                                        <th class="px-6 py-2">Dibayar</th>
                                        @endif
                                        @if (Auth::user()->hakakses('kepalaperpus') || Auth::user()->hakakses('petugas'))
                                        <th class="px-6 py-2">Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($peminjaman as $index => $item)
                                    <tr>
                                        <th class="px-6 py-2">{{ $index + $peminjaman->firstItem() }}</th>
                                        @if (Auth::user()->hakakses('kepalaperpus') || Auth::user()->hakakses('petugas'))
                                        <td class="px-6 py-2">
                                            <b>{{ $item->user->name }}</b>
                                            {{-- <p class="text-body mt-2">Nomor: {{ $item->user->masteranggota->no_telp }}</p> --}}
                                        </td>
                                        @endif
                                        <td class="px-6 py-2">
                                            <b>{{ $item->masterbuku->judul }}, {{ $item->masterbuku->tahun }}</b>
                                            <p class="text-body mt-2">Author: {{ $item->masterbuku->author }}</p>
                                        </td>
                                        <td class="px-6 py-2">{{ $item->jumlah }}</td>
                                        @if (Auth::user()->hakakses('kepalaperpus') || Auth::user()->hakakses('petugas'))
                                        <td class="px-6 py-2">{{ \Carbon\Carbon::parse($item->tanggalpinjam)->format('d M Y') }}</td>
                                        <td class="px-6 py-2">{{ \Carbon\Carbon::parse($item->tenggat)->format('d M Y') }}</td>
                                        <td class="px-6 py-2">{{ \Carbon\Carbon::parse($item->tglpengembalian)->format('d M Y') }}</td>
                                        @endif
                                        @if (Auth::user()->hakakses('siswa')|| Auth::user()->hakakses('kepalaperpus')|| Auth::user()->hakakses('petugas'))
                                        <td>{{ $item->keterangan }}</td>

                                        <td class="px-6 py-2">
                                            @php
                                                $tenggat = \Carbon\Carbon::parse($item->tenggat);
                                                $today = \Carbon\Carbon::now();
                                            @endphp
                                            @if ($today->greaterThan($tenggat))
                                                <span class="badge bg-danger">TERLAMBAT</span>
                                            @else
                                                <span class="badge bg-success">NORMAL</span>
                                            @endif
                                        </td>
                                        @endif


                                        <td class="px-6 py-2">
                                            @if ($item->bayar)
                                                Rp {{ number_format($item->bayar, 0, ',', '.') }}
                                                <br>
                                                <span class="badge bg-success mt-1">LUNAS</span>
                                            @else
                                                Rp 0
                                                <br>
                                                <span class="badge bg-danger mt-1">BELUM DIBAYAR</span>
                                            @endif
                                        </td>
                                        @if (Auth::user()->hakakses('kepalaperpus') || Auth::user()->hakakses('petugas'))
                                            <td class="px-6 py-2">
                                                @if (!$item->bayar)
                                                    <a href="{{ route('pengembalian.pay', $item->id) }}" class="mt-1 btn btn-warning">
                                                        Bayar
                                                    </a>
                                                @endif
                                                <a href="{{ route('pengembalian.edit', $item->id) }}" class="mt-1 btn btn-primary">
                                                    Detail
                                                </a>
                                            </td>
                                        @endif

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{ $peminjaman->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Optional JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script>
        @if (Session::has('success'))
            toastr.success("{{ Session::get('success') }}")
        @endif
    </script>
@endpush
