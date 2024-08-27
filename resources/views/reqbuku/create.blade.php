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

<title>Data Table</title>


<body>
    <div class="container-fluid">
        <div class="card" style="border-radius: 15px;">
          <div class="card-body">
              <h1 class="text-center mb-4">Tambah Request Buku</h1>
              <div class="container">
                  <div class="row justify-content-center">
                      <div class="col-8">
                          <div class="card" style="border-radius: 10px;">
                              <div class="card-body">
                                  <form method="POST" action="{{ route('reqbuku.store') }}" enctype="multipart/form-data">
                                      @csrf
                                      <div class="form-group" style="border-radius: 8px;">
                                        <label for="id_kategori">Kategori</label>
                                        <select class="form-select" name="id_kategori" id="kategori" style="border-radius: 8px;" data-placeholder="PILIH KATEGORI BUKU">
                                            <option></option>
                                            @foreach ($masterkategori as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group" style="border-radius: 8px;">
                                        <label for="id_anggota">Nama Anggota</label>
                                        <input type="text" class="form-control" id="id_anggota" value="{{ Auth::user()->name }}" readonly>
                                        <input type="hidden" value="{{ Auth::user()->id }}" name="id_anggota">
                                    </div>
                                      <div class="form-group">
                                          <label for="judulbuku">Judul Buku</label>
                                          <input type="text" name="judulbuku" class="form-control @error('judulbuku') is-invalid @enderror"
                                              aria-describedby="emailHelp" placeholder="Masukan Judul Buku" value="{{ old('judulbuku') }}" required>
                                          @error('judulbuku')
                                              <div class="invalid-feedback">{{ $message }}</div>
                                          @enderror
                                      </div>
                                      <div class="form-group">
                                          <label for="author">Author</label>
                                          <input type="text" name="author" class="form-control @error('author') is-invalid @enderror" id="author"
                                              aria-describedby="emailHelp" placeholder="Masukan Nama Author" value="{{ old('author') }}" required>
                                          @error('author')
                                              <div class="invalid-feedback">{{ $message }}</div>
                                          @enderror
                                      </div>
                                      <div class="form-group">
                                          <label for="tahun">Tahun</label>
                                          <input type="number" name="tahun" class="form-control @error('tahun') is-invalid @enderror" id="tahun"
                                              aria-describedby="emailHelp" placeholder="Masukan Tahun" value="{{ old('tahun') }}" required>
                                          @error('tahun')
                                              <div class="invalid-feedback">{{ $message }}</div>
                                          @enderror
                                      </div>
                                      <div class="form-group">
                                        <label for="keterangan">Keterangan</label>
                                        <select name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" required>
                                            <option value="" disabled selected>Pilih Pilihan</option>
                                            <option value="E-Book" {{ old('keterangan') == 'E-Book' ? 'selected' : '' }}>E-Book</option>
                                            <option value="Offline Book" {{ old('keterangan') == 'Offline Book' ? 'selected' : '' }}>Offline Book</option>
                                        </select>
                                        @error('keterangan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group" style="border-radius: 8px;">
                                        <label for="tanggal">Tanggal Peminjaman</label>
                                        <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" style="border-radius: 8px;" placeholder="Masukkan tanggal" value="{{ old('tanggal') }}" min="{{ \Carbon\Carbon::now()->toDateString() }}" max="2100-12-31" required>
                                        @error('tanggal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
    $( '#judulbuku' ).select2( {
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
} );
</script>
<script>
    $( '#kategori' ).select2( {
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
} );
</script>
@endsection
