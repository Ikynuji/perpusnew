@extends('layout.admin')

@section('content')


<!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />

        <!-- Select2 CSS -->
        {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
        <!-- Or for RTL support -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />


<title>Pengembalian</title>


<body>
    <div class="container-fluid">
        <div class="card" style="border-radius: 15px;">
          <div class="card-body">
              <h1 class="text-center mb-4">Edit Pengembalian</h1>
              <div class="container mt-4"> <!-- Batas Page -->
                <div class="card" style="border-radius: 10px;">
                  <div class="card-body">
                    <div class="d-flex justify-content-between mb-4">
                      <div>
                        <a href="{{ route('pengembalian.index')}}" class="btn btn-outline-primary">
                          <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                      </div>
                      {{-- Batalkan Pengembalian --}}
                      <div class="d-flex gap-2 justify-content-end">
                        <form action="#" method="post" onsubmit="return confirm('Are you sure?');">
                          <input type="hidden" name="_method" value="DELETE">
                          <button type="submit" class="btn btn-danger mb-2">
                            <i class="bi bi-trash"></i> Batalkan pengembalian
                          </button>
                        </form>
                      </div>
                    </div>

                    <h5 class="card-title fw-semibold mb-4">Detail Pengembalian</h5>

                    <div class="row mb-3">
                      <!-- Member data -->
                      <div class="col-12 col-md-6 d-flex flex-wrap">
                        <div class="mb-4">
                          <table class="table">
                            <tbody>
                              <tr>
                                <td><h5><b>Nama Lengkap</b></h5></td>
                                <td class="text-center"><h5><b>:</b></h5></td>
                                <td><h5><b>{{ Auth::user()->name }}</b></h5></td>
                              </tr>
                              <tr>
                                <td><h5>Email</h5></td>
                                <td class="text-center"><h5>:</h5></td>
                                <td><h5>{{ $item->masteranggota->email }}</h5></td>
                              </tr>
                              {{-- <tr>
                                <td><h5>Nomor telepon</h5></td>
                                <td class="text-center"><h5>:</h5></td>
                                <td><h5>{{ $item->masteranggota->no_telp }}</h5></td>
                              </tr> --}}
                              <tr>
                                <td><h5>Alamat</h5></td>
                                <td class="text-center"><h5>:</h5></td>
                                <td><h5>{{ $item->masteranggota->alamat }}</h5></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>

                      <!-- Book data -->
                      <div class="col-12 col-md-6 d-flex flex-wrap">
                        <div class="mb-4">
                          <table class="table">
                            <tbody>
                              <tr>
                                <td><h5><b>Judul buku</b></h5></td>
                                <td class="text-center"><h5><b>:</b></h5></td>
                                <td><h5><b>{{ $item->masterbuku->judul }}</b></h5></td>
                              </tr>
                              <tr>
                                <td><h5>Pengarang</h5></td>
                                <td class="text-center"><h5>:</h5></td>
                                <td><h5>{{ $item->masterbuku->author }}</h5></td>
                              </tr>
                              <tr>
                                <td><h5>Penerbit</h5></td>
                                <td class="text-center"><h5>:</h5></td>
                                <td><h5>{{ $item->masterbuku->publisher }}</h5></td>
                              </tr>
                              <tr>
                                <td><h5>Rak</h5></td>
                                <td class="text-center"><h5>:</h5></td>
                                <td><h5>A1 Contoh</h5></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>

                <div class="row mt-4">
                  <div class="col-12 col-lg-8">
                    <div class="row">
                      <!-- Quantity -->
                      <div class="col-12 col-sm-6">
                        <div class="card" style="height: 180px; border-radius: 10px;"">
                          <div class="card-body">
                            <h2><i class="bi bi-book"></i></h2>
                            <h5>Buku dipinjam:</h5>
                            <h4>{{ $item->jumlah }}</h4>
                          </div>
                        </div>
                      </div>

                      <!-- Loan Date -->
                      <div class="col-12 col-sm-6">
                        <div class="card" style="height: 180px; border-radius: 10px;"">
                          <div class="card-body">
                            <h2><i class="bi bi-calendar-check"></i></h2>
                            <h5>Waktu pinjam:</h5>
                            <h4>{{ \Carbon\Carbon::parse($item->tanggalpinjam)->format('d M Y') }}</h4>
                          </div>
                        </div>
                      </div>

                      <!-- Due Date -->
                      <div class="col-12 col-sm-6">
                        <div class="card" style="height: 180px; border-radius: 10px;">
                          <div class="card-body">
                            <h2><i class="bi bi-calendar-due"></i></h2>
                            <h5>Batas waktu pengembalian:</h5>
                            <h4>{{ \Carbon\Carbon::parse($item->tenggat)->format('d M Y') }}</h4>
                          </div>
                        </div>
                      </div>

                      <!-- Return Date -->
                      <div class="col-12 col-sm-6">
                        <div class="card" style="height: 180px; border-radius: 10px;">
                          <div class="card-body">
                            <h2><i class="bi bi-calendar-check"></i></h2>
                            <h5>Tanggal pengembalian:</h5>
                            <h4>{{ \Carbon\Carbon::parse($item->tglpengembalian)->format('d M Y') }}</h4>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Fines -->
                  <div class="col-12 col-lg-4">
                    <div class="card" style="border-radius: 10px;">
                      <div class="card-body">
                        <h5>Terlambat : {{ $item->hari_keterlambatan }} Hari</h5>
                        <h5>Total denda : Rp {{ $item->denda }}</h5>
                        {{-- <h5>Telah dibayar : Rp </h5>
                        <h5>Sisa bayar : Rp </h5> --}}
                        <h5>STATUS :
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
                        @php
                                // Mengambil nilai tenggat dari objek $item
                                $tenggat = \Carbon\Carbon::parse($item->tenggat);

                                // Mendapatkan tanggal hari ini
                                $today = \Carbon\Carbon::now();
                            @endphp
                                @if ($today->greaterThan($tenggat))
                                    {{-- <span class="badge bg-danger">TERLAMBAT</span> --}}
                                    <a href="{{ route('pengembalian.pay', $item->id) }}" class="btn btn-warning mt-3 w-100" style="border-radius: 10px;">BAYAR SEKARANG</a>
                                @else
                                    {{-- <span class="badge bg-success">NORMAL</span> --}}
                                @endif
                      </div>
                    </div>
                  </div>
                </div>
              </div><!-- Batas Page -->
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

<script>
$( '#judulbuku' ).select2( {
theme: "bootstrap-5",
width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
placeholder: $( this ).data( 'placeholder' ),
} );
</script>
<script>
$( '#namaanggota' ).select2( {
theme: "bootstrap-5",
width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
placeholder: $( this ).data( 'placeholder' ),
} );
</script>
@endsection
