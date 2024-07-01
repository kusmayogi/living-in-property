<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyek</title>
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/styledashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/berita.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body>
    <!--- header  -->
    <section class="header">
        <div class="logo">
            <i class="ri-menu-line icon icon-0 menu"></i>
            <h2>Hallo <span>{{ auth()->user()->name }}!</span></h2>
        </div>
        <div class="search--notification--profile">
            <div class="">
                <!-- <input type="text" placeholder="Cari Pengajuan">
                <button> <i class="ri-search-2-line"></i></button> -->
            </div>
            <div class="notification--profile">
                <!-- <div class="picon bell">
                    <i class="ri-notification-2-line"></i> -->
            </div>
            <div class="picon profile">
                <img src="{{ asset('frontend/assets/img/Watermark.png') }}" alt="">
            </div>
        </div>

    </section>
    <section class="main">
        <div class="sidebar">
            <ul class="sidebar--items">
                @guest
                @else
                    @if (auth()->user()->role === 'Master')
                        <li>
                            <a href="/dashboard">
                                <span class="icon icon-1"><i class="ri-layout-grid-line"></i></span>
                                <span class="sidebar--item">Dashboard</span>
                            </a>
                        </li>
                    @endif
                @endguest
                @guest
                @else
                    @if (auth()->user()->role === 'Master' ||
                            auth()->user()->role === 'Manajer' ||
                            auth()->user()->role === 'Admin' ||
                            auth()->user()->role === 'Pengawas')
                        <li>
                            <a href="/keuangan" id="active--link">
                                <span class="icon icon-2"><i class="ri-bar-chart-grouped-line"></i></span>
                                <span class="sidebar--item">Keuangan</span>
                            </a>
                        </li>
                    @endif
                @endguest
                @guest
                @else
                    @if (auth()->user()->role === 'Master' || auth()->user()->role === 'Manajer')
                        <li>
                            <a href="/Data_pekerja">
                                <span class="icon icon-2"><i class="ri-bar-chart-grouped-line"></i></span>
                                <span class="sidebar--item">Data Pekerja</span>
                            </a>
                        </li>
                    @endif
                @endguest
                @guest
                @else
                    @if (auth()->user()->role === 'Master' || auth()->user()->role === 'Manajer' || auth()->user()->role === 'Pengawas')
                        <li>
                            <a href="/absensi">
                                <span class="icon icon-2"><i class="ri-bar-chart-grouped-line"></i></span>
                                <span class="sidebar--item">Absensi</span>
                            </a>
                        </li>
                    @endif
                @endguest
                @guest
                @else
                    @if (auth()->user()->role === 'Master' || auth()->user()->role === 'Manajer')
                        <li>
                            <a href="/proyek">
                                <span class="icon icon-4"><i class="ri-database-line"></i></span>
                                <span class="sidebar--item" style="white-space: nowrap;">Proyek</span>
                            </a>
                        </li>
                    @endif
                @endguest
                @guest
                @else
                    @if (auth()->user()->role === 'Master' || auth()->user()->role === 'Manajer')
                        <li>
                            <a href="/users">
                                <span class="icon icon-4"><i class="ri-database-line"></i></span>
                                <span class="sidebar--item" style="white-space: nowrap;">Daftar Pegawai</span>
                            </a>
                        </li>
                    @endif
                @endguest
            </ul>
            <ul class="sidebar--bottom-items">
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            <span class="icon icon-4"> <i class="ri-login-box-line"></i></span>
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </li>
            </ul>
        </div>
        <div class="main--content">
            <div class="overview">
                <div class="title">
                    <div class="container">
                        {{-- @dd($pengeluarans) --}}

                        <header>Formulir Pengeluaran</header>
                        <form action="{{ route('pengeluaran.update', $pengeluarans->id_pengeluaran) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="column">
                                    <label for="judul_pengeluaran">Judul Pengeluaran</label>
                                    <input type="text" id="judul_pengeluaran" class="form-control"
                                        placeholder="cth: besi, pasir, dll" name="judul_pengeluaran"
                                        value="{{ old('judul_pengeluaran', $pengeluarans->judul_pengeluaran) }}"
                                        required>
                                </div>
                                <div class="column">
                                    <label for="sumber_dana">Sumber Dana</label>
                                    <input type="text" id="sumber_dana" class="form-control"
                                        placeholder="cth: uang kas, dll" name="sumber_dana"
                                        value="{{ old('sumber_dana', $pengeluarans->sumber_dana) }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="column">
                                    <label for="satuan">Satuan</label>
                                    <input type="text" id="satuan" class="form-control"
                                        placeholder="cth: kg, rit, karung" name="satuan"
                                        value="{{ old('satuan', $pengeluarans->satuan) }}" required>
                                </div>
                                <div class="column">
                                    <label for="harga_satuan">Harga Satuan</label>
                                    <input type="text" class="form-control" id="harga_satuan"
                                        placeholder="isikan harga berdasarkan satuan" name="harga_satuan"
                                        value="{{ old('harga_satuan', $pengeluarans->harga_satuan) }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="column">
                                    <label for="total_pengeluaran">Total Pengeluaran</label>
                                    <input type="text" class="form-control" id="total_pengeluaran"
                                        name="total_pengeluaran"
                                        value="{{ old('total_pengeluaran', $pengeluarans->total_pengeluaran) }}">
                                </div>
                                <div class="column">
                                    <label for="keterangan">Keterangan</label>
                                    <input type="text" id="keterangan" class="form-control"
                                        placeholder="Isikan Keterangan" name="keterangan"
                                        value="{{ old('keterangan', $pengeluarans->keterangan) }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="column">
                                    <label for="vendor">Vendor</label>
                                    <input type="text" class="form-control" id="vendor" name="vendor"
                                        value="{{ old('vendor', $pengeluarans->vendor) }}">
                                </div>
                                <div class="column">
                                    <label for="id_proyek">Lokasi Proyek</label>
                                    <input type="text" class="form-control" id="id_proyek" name="id_proyek"
                                        value="{{ old('id_proyek', $pengeluarans->id_proyek) }}">
                                </div>
                            </div>
                            <div class="form-foto">
                                <label for="foto" class="form-label">Foto</label>
                                <input type="file" id="foto" name="foto" accept="image/*"
                                    onchange="previewFile()">
                                <br>
                                <img id="previewImage"
                                    src="{{ asset('storage/app/public/foto_pengeluaran/' . $pengeluarans->foto) }}"
                                    alt="{{ $pengeluarans->foto }}" style="max-width: 300px; max-height: 300px;">
                            </div>
                            <div><button type="submit" class="btn btn-primary">Simpan Perubahan</button></div>
                        </form>
                    </div>
                </div>
            </div>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>
    <script src="{{ asset('frontend/assets/js/formulir.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Fungsi untuk menampilkan preview gambar saat dipilih
        function previewFile() {
            var input = document.getElementById('foto');
            var preview = document.getElementById('previewImage');

            var reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };

            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
            }
        }
    </script>
    <script>
        document.getElementById('btnSimpan').addEventListener('click', function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Data berhasil di edit',
                showConfirmButton: false,
                timer: 1500
            });
        });
    </script>
</body>

</html>