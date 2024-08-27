@extends('layout.admin')

@section('content')


<head>
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

</head>

<title>Anggaran Pengadaan Buku</title>


<body>
    <div class="container-fluid">
        <div class="card" style="border-radius: 15px;">
          <div class="card-body">
              <h1 class="text-center mb-4">Edit Data Anggaran Pengadaan Buku</h1>
              <div class="container">
                  <div class="row justify-content-center">
                      <div class="col-8">
                          <div class="card" style="border-radius: 10px;">
                              <div class="card-body">
                                  <form method="POST" action="{{ route('anggaran.update', $item->id) }}" enctype="multipart/form-data">
                                      @csrf
                                      @method('PUT')
                                      <div class="form-group">
                                        <label for="tanggal">Tanggal</label>
                                        <input value="{{ $item->tanggal }}" type="date" name="tanggal" class="form-control"
                                             placeholder="Masukan Tanggal" required>
                                     </div>
                                      <div class="form-group" style="border-radius: 8px;">
                                        <label for="id_kategori">Kategori</label>
                                        <select class="form-select" name="id_kategori" id="kategori" style="border-radius: 8px;" data-placeholder="PILIH KATEGORI">
                                            <option></option>
                                            @foreach ($masterkategori as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="namanbuku">Judul Buku</label>
                                        <input value="{{ $item->namanbuku }}" type="text" name="namanbuku" class="form-control"
                                            id="exampleInputPassword1" placeholder="Masukan Judul Buku" required>
                                     </div>
                                    <div class="form-group">
                                        <label for="keterangan">Keterangan</label>
                                        <input value="{{ $item->keterangan }}" type="text" name="keterangan" class="form-control"
                                            id="exampleInputPassword1" placeholder="Masukan Judul Buku" required>
                                     </div>
                                      <div class="form-group">
                                        <label for="tahun">Tahun</label>
                                        <input value="{{ $item->tahun }}" type="number" name="tahun" class="form-control"
                                             placeholder="Masukan Tahun" required>
                                     </div>
                                      <div class="form-group">
                                        <label for="harga">Harga</label>
                                        <input value="{{ $item->harga }}" type="number" name="harga" class="form-control"
                                             placeholder="Masukan Harga" required>
                                     </div>
                                      <div class="form-group">
                                        <label for="qty">Qty</label>
                                        <input value="{{ $item->qty }}" type="number" name="qty" class="form-control"
                                             placeholder="Masukan Qty" required>
                                     </div>

                                      <button type="submit" class="btn btn-primary">Submit</button>
                                  </form>
                              </div>
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
<script>
    $( '#kategori' ).select2( {
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
} );
</script>
@endsection
