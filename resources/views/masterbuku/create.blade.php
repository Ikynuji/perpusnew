@extends('layout.admin')

@section('content')

<!-- Required meta tags -->
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />

<title>Master Data Buku</title>


<body>
    <div class="container-fluid">
        <div class="card" style="border-radius: 15px;">
          <div class="card-body">
              <h1 class="text-center mb-4">Tambah Data Buku</h1>
              <div class="container">
                  <div class="row justify-content-center">
                      <div class="col-8">
                          <div class="card" style="border-radius: 10px;">
                              <div class="card-body">
                                  <form method="POST" action="{{ route('masterbuku.store') }}" enctype="multipart/form-data">
                                      @csrf
                                      {{-- <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-3 p-3">
                                        <label for="cover" class="d-block" style="cursor: pointer;">
                                            <div class="d-flex justify-content-center bg-light overflow-hidden h-100 position-relative">
                                                <img src="{{ asset(config('constants.book_cover_uri') . '/default_cover.jpg') }}" alt="Default Cover">
                                                <p class="position-absolute top-50 start-50 translate-middle z-0">Pilih sampul</p>
                                            </div>
                                        </label>
                                    </div> --}}
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Masukan Cover</label>
                                        <input {{-- value="{{ old('fotoktp') }}" --}} type="file" name="cover" class="form-control"
                                            placeholder="Masukan Cover">
                                    </div>

                                    <div class="form-group">
                                        <label for="judul">Judul</label>
                                        <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" id="judul" placeholder="Masukkan Judul" value="{{ old('judul') }}" required>
                                        @error('judul')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="author">Pengarang</label>
                                        <input type="text" name="author" class="form-control @error('author') is-invalid @enderror" id="author" placeholder="Masukkan Pengarang" value="{{ old('author') }}" required>
                                        @error('author')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="publisher">Penerbit</label>
                                        <input type="text" name="publisher" class="form-control @error('publisher') is-invalid @enderror" id="publisher" placeholder="Masukkan Penerbit" value="{{ old('publisher') }}" required>
                                        @error('publisher')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="isbn">ISBN</label>
                                        <input type="number" name="isbn" class="form-control @error('isbn') is-invalid @enderror" id="isbn" placeholder="Masukkan ISBN" value="{{ old('isbn') }}" required>
                                        @error('isbn')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="tahun">Tahun</label>
                                        <input type="number" name="tahun" class="form-control @error('tahun') is-invalid @enderror" id="tahun" placeholder="Masukkan Tahun" value="{{ old('tahun') }}" min="1900" max="2100" required>
                                        @error('tahun')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="id_rak">Rak</label>
                                        <select name="id_rak" class="form-control">
                                            @foreach ($masterrak as $item)
                                            <option value="{{ $item->id }}">{{ $item->rak }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="id_kategori">Kategori</label>
                                        <select name="id_kategori" class="form-control">
                                            @foreach ($masterkategori as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="stockbuku">Stok</label>
                                        <input type="number" name="stockbuku" class="form-control @error('stockbuku') is-invalid @enderror" id="stockbuku" placeholder="Masukkan Stok" value="{{ old('stockbuku') }}" required>
                                        @error('stockbuku')
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


























<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>
@endsection
