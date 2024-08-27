@extends('layout.admin')

@section('content')
    <!-- Required meta tags -->

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Select2 CSS -->
        {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
        <!-- Or for RTL support -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />

    </head>

    <title>Denda</title>

    <body>
        <div class="container-fluid">
            <div class="card shadow mb-3 border-transparent">
                <div class="card-body">
                    <a href="{{ route('pengembalian.edit', $item->id) }}" class="btn btn-outline-primary mb-3">
                        <i class="ti ti-arrow-left"></i> Kembali
                    </a>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-light border-light">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold mb-4">Detail Pembayaran</h5>
                                    <div class="fs-6">
                                        <div class="row mb-2">
                                            <div class="col-md-4"><b>Nama Lengkap:</b></div>
                                            <div class="col-md-8">{{ Auth::user()->name }}</div>
                                        </div>
                                        {{-- <div class="row mb-2">
                                            <div class="col-md-4"><b>Email:</b></div>
                                            <div class="col-md-8">{{ $item->masteranggota->email }}</div>
                                        </div> --}}
                                        <div class="row mb-2">
                                            <div class="col-md-4"><b>Judul buku:</b></div>
                                            <div class="col-md-8">{{ $item->masterbuku->judul }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4"><b>Jumlah pinjam:</b></div>
                                            <div class="col-md-8">{{ $item->jumlah }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4"><b>Tgl pinjam:</b></div>
                                            <div class="col-md-8">{{ \Carbon\Carbon::parse($item->tanggalpinjam)->format('d M Y') }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4"><b>Tenggat:</b></div>
                                            <div class="col-md-8">{{ \Carbon\Carbon::parse($item->tenggat)->format('d M Y') }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4"><b>Tgl pengembalian:</b></div>
                                            <div class="col-md-8">{{ \Carbon\Carbon::parse($item->tglpengembalian)->format('d M Y') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card bg-light border-light">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold mb-4">Bayar denda</h5>
                                    <form action="{{ route('peminjaman.update', $item->id) }}" method="post">
                                        <div class="mb-3">
                                            @csrf
                                            @method('PUT')
                                            {{-- <h5 class="fs-6">Total denda: Rp {{ number_format($item->denda) }}</h5>
                                            <h5 class="fs-6">Dibayar: Rp {{ number_format($item->bayar) }}</h5>
                                            <h5 class="fs-6">Sisa denda: Rp {{ number_format($item->denda - $item->bayar) }}</h5> --}}
                                            <h5 class="fs-6">STATUS :
                                                @php
                                                    // Mengambil nilai tenggat dari objek $item
                                                    $tenggat = \Carbon\Carbon::parse($item->tenggat);

                                                    // Mendapatkan tanggal hari ini
                                                    $today = \Carbon\Carbon::now();
                                                @endphp
                                                    @if ($today->greaterThan($tenggat))
                                                        <span class="badge bg-danger">TERLAMBAT</span>
                                                    @else
                                                        <span class="badge bg-success">NORMAL</span>
                                                    @endif
                                            </h5>
                                        </div>
                                    </form>
                                        <form action="{{ route('pengembalian.updatePayment', $item->id) }}" method="post">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-3">
                                                <label for="bayar" class="form-label">Nominal bayar</label>
                                                <input type="number" class="form-control @error('bayar') is-invalid @enderror" id="bayar" name="bayar" value="{{ old('bayar') }}" placeholder=" {{ $item->denda - $item->bayar }}" min="1000" aria-describedby="bayarHelp" required>
                                                <div id="bayarHelp" class="form-text">
                                                    Minimal Rp5000.
                                                </div>
                                                @error('bayar')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="keterangan" class="form-label">Keterangan</label>
                                                <input type="text" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" value="{{ old('keterangan', $item->keterangan) }}" aria-describedby="keteranganHelp" required>
                                                <div id="keteranganHelp" class="form-text">
                                                    Masukkan keadaan item.
                                                </div>
                                                @error('keterangan')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <button type="submit" class="btn btn-warning" onclick="return confirm('Konfirmasi');">Bayar</button>
                                        </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    <!-- Optional JavaScript Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV7YyybLOtiN6bX3h+rXxy5lVX" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+pyRy4IhBQvqo8Rx2ZR1c8KRjuva5V7x8GA" crossorigin="anonymous">
    </script>

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
