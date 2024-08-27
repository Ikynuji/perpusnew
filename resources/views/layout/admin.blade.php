<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Modernize Free</title>
        <link rel="shortcut icon" type="image/png" href="{{ asset('template2/assets/images/logos/favicon.png') }}" />
        <link rel="stylesheet" href="{{ asset('template2/assets/css/styles.min.css') }}" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    </head>

    <body>
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                  toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            });
        </script>
    @endif
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div>
              <div class="brand-logo d-flex align-items-center justify-content-between">
                <a href="./index.html" class="text-nowrap logo-img">
                  <img src="{{ asset('template2/assets/images/logos/dark-logo.svg')}}" width="180" alt="" />
                </a>
                <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                  <i class="ti ti-x fs-8"></i>
                </div>
              </div>
              <!-- Sidebar navigation-->
              <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                <ul id="sidebarnav">
                  <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Home</span>
                  </li>
                  <li class="sidebar-item">
                    <a class="sidebar-link" href="/" aria-expanded="false">
                      <span>
                        <i class="ti ti-layout-dashboard"></i>
                      </span>
                      <span class="hide-menu">Dashboard</span>
                    </a>
                  </li>

                  <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">MASTER DATA</span>
                  </li>
                  <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('masteranggota.index')}}" aria-expanded="false">
                      <span>
                        <i class="ti ti-article"></i>
                      </span>
                      <span class="hide-menu">Daftar Anggota</span>
                    </a>
                  </li>
                  @if (Auth::user()->hakakses('kepalaperpus') || Auth::user()->hakakses('petugas'))
                  <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('masterbuku.index')}}" aria-expanded="false">
                      <span>
                        <i class="ti ti-alert-circle"></i>
                      </span>
                      <span class="hide-menu">Buku</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('masterebook.index')}}" aria-expanded="false">
                      <span>
                        <i class="ti ti-alert-circle"></i>
                      </span>
                      <span class="hide-menu">E-Book</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('masterkategori.index')}}" aria-expanded="false">
                      <span>
                        <i class="ti ti-cards"></i>
                      </span>
                      <span class="hide-menu">Kategori</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('masterrak.index')}}" aria-expanded="false">
                      <span>
                        <i class="ti ti-file-description"></i>
                      </span>
                      <span class="hide-menu">Rak</span>
                    </a>
                  </li>
                  @endif
                  <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Data Table</span>
                </li>

                @php
                    $user = Auth::user();
                    $anggota = \App\Models\Masteranggota::where('id_anggota', $user->id)->first();
                @endphp
                @if ($anggota && $anggota->status === 'verifikasi')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('peminjaman.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-book"></i>
                            </span>
                            <span class="hide-menu">Pinjaman</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('pengembalian.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-books"></i>
                            </span>
                            <span class="hide-menu">Pengembalian</span>
                        </a>
                     </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('peminjamanebook.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-book"></i>
                            </span>
                            <span class="hide-menu">Pinjaman E-Book</span>
                        </a>
                    </li>

                    @if (Auth::user()->hakakses('kepalaperpus') || Auth::user()->hakakses('petugas') || Auth::user()->hakakses('siswa'))
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('reqbuku.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-vocabulary"></i>
                                </span>
                                <span class="hide-menu">Request Pengadaan Buku</span>
                            </a>
                        </li>
                    @endif
                @endif


                  @if (Auth::user()->hakakses('kepalaperpus') || Auth::user()->hakakses('petugas'))
                  <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('pengembalian.index') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-books"></i>
                        </span>
                        <span class="hide-menu">Pengembalian</span>
                    </a>
                 </li>
                  <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('rusak.index')}}" aria-expanded="false">
                          <span>
                              <i class="ti ti-file-broken"></i>
                            </span>
                            <span class="hide-menu">Rusak atau Hilang</span>
                        </a>
                    </li>
                    @endif
                  @if (Auth::user()->hakakses('kepalaperpus'))
                  <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('anggaran.index')}}" aria-expanded="false">
                          <span>
                              <i class="ti ti-file-broken"></i>
                            </span>
                            <span class="hide-menu">Anggaran Pengadaan Buku</span>
                        </a>
                    </li>
                @endif
                  @if (Auth::user()->hakakses('kepalaperpus') || Auth::user()->hakakses('petugas'))
                  <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Report</span>
                  </li>
                  <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('laporanpengembalian')}}" aria-expanded="false">
                      <span>
                        <i class="ti ti-report"></i>
                      </span>
                      <span class="hide-menu">Lap Pengembalian</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('laporanrusak')}}" aria-expanded="false">
                      <span>
                        <i class="ti ti-report"></i>
                      </span>
                      <span class="hide-menu">Lap Rusak atau Hilang</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('laporanpengadaanbuku')}}" aria-expanded="false">
                      <span>
                        <i class="ti ti-report"></i>
                      </span>
                      <span class="hide-menu">Lap Pengadaan Buku</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('laporanpeminjaman')}}" aria-expanded="false">
                      <span>
                        <i class="ti ti-report"></i>
                      </span>
                      <span class="hide-menu">Lap Peminjaman</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('laporandenda')}}" aria-expanded="false">
                      <span>
                        <i class="ti ti-report"></i>
                      </span>
                      <span class="hide-menu">Lap Denda</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('pernama')}}" aria-expanded="false">
                      <span>
                        <i class="ti ti-report"></i>
                      </span>
                      <span class="hide-menu">Lap Peminjaman PerSiswa</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('laporananggota')}}" aria-expanded="false">
                      <span>
                        <i class="ti ti-report"></i>
                      </span>
                      <span class="hide-menu">Lap Pendaftaran Anggota</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('laporanreqbuku')}}" aria-expanded="false">
                      <span>
                        <i class="ti ti-report"></i>
                      </span>
                      <span class="hide-menu">Lap Req Pengadaan Buku</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('laporanebook')}}" aria-expanded="false">
                      <span>
                        <i class="ti ti-report"></i>
                      </span>
                      <span class="hide-menu">Lap E-Book</span>
                    </a>
                  </li>
                  @endif
                  @if (Auth::user()->hakakses('kepalaperpus'))
                  <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('laporananggaran')}}" aria-expanded="false">
                      <span>
                        <i class="ti ti-report"></i>
                      </span>
                      <span class="hide-menu">Lap Anggaran Pengadaan Buku</span>
                    </a>
                  </li>
                  @endif



                  {{-- <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">EXTRA</span>
                  </li>
                  <li class="sidebar-item">
                    <a class="sidebar-link" href="./icon-tabler.html" aria-expanded="false">
                      <span>
                        <i class="ti ti-mood-happy"></i>
                      </span>
                      <span class="hide-menu">Icons</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a class="sidebar-link" href="./sample-page.html" aria-expanded="false">
                      <span>
                        <i class="ti ti-aperture"></i>
                      </span>
                      <span class="hide-menu">Sample Page</span>
                    </a>
                  </li> --}}
                </ul>
              </nav>
              <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
          <!--  Sidebar End -->
          <!--  Main wrapper -->
          <div class="body-wrapper">
            <!--  Header Start -->
            <header class="app-header">
              <nav class="navbar navbar-expand-lg navbar-light">
                <ul class="navbar-nav">
                  <li class="nav-item d-block d-xl-none">
                    <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                      <i class="ti ti-menu-2"></i>
                    </a>
                  </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                        <i class="ti ti-bell-ringing"></i>
                        <div class="notification bg-primary rounded-circle"></div>
                        </a>
                    </li> --}}
                </ul>
                <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                  <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                    {{-- <a href="https://adminmart.com/product/modernize-free-bootstrap-admin-dashboard/" target="_blank" class="btn btn-primary">Download Free</a> --}}
                    <li class="nav-item dropdown">
                      <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <img src="{{asset('template2/assets/images/profile/user-1.jpg')}}" alt="" width="35" height="35" class="rounded-circle">
                      </a>
                      <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                        <div class="message-body">
                          <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                            <i class="ti ti-user fs-6"></i>
                            <p class="mb-0 fs-3">My Profile</p>
                          </a>
                          <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                            <i class="ti ti-mail fs-6"></i>
                            <p class="mb-0 fs-3">My Account</p>
                          </a>
                          <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                            <i class="ti ti-list-check fs-6"></i>
                            <p class="mb-0 fs-3">My Task</p>
                          </a>
                          <a href="{{ route('logout')}}" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </nav>
            </header>
            <!--  Header End -->

            @yield('content')
        </div>
        <script src="{{ asset('template2/assets/libs/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('template2/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('template2/assets/js/sidebarmenu.js') }}"></script>
        <script src="{{ asset('template2/assets/js/app.min.js') }}"></script>
        {{-- <script src="{{ asset('template2/assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script> --}}
        {{-- <script src="{{ asset('template2/assets/libs/simplebar/dist/simplebar.js') }}"></script> --}}
        <script src="{{ asset('template2/assets/js/dashboard.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </body>

    </html>
<!-- Sidebar Start -->

